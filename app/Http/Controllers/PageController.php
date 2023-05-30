<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App;
use App\Order;
use App\OrderPlanCategory;
use App\OrderPlanAsset;
use App\OrderStoringDuration;
use App\OrderCalculatorCategory;
use Label;
use Modules\Datamanager\DataControllerTrait;
use Lang;
use Mail;
use Illuminate\Http\Request;
use Modules\Datamanager\Entities\Post;
use Session;
use Cookie;
use App\Adyen;
use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;
use App\Events\PickupConfirmationEvent;
use Exception;
use App\Handlers\Events\PickupConfirmationHandler;
use App\OrderAssurance;
use App\OrderCalculatorItem;
use App\OrderPlan;
use App\OrderQuestion;
use App\Pickup;
use App\Area;

/**
 * Class PageController
 *
 * @package App\Http\Controllers
 */
class PageController extends BaseController
{
    protected $layout = "layouts.default";

    public function adyenRedirect(Request $request)
    {
        /*var_dump($request->getSession()->get("encodedcReq"));
        var_dump($request->getSession()->get("token"));
        var_dump($request->getSession()->get("redirectTo"));
        var_dump($request->getSession()->get("mailAdyen"));
        var_dump($request->getSession()->get("PaReq"));
        var_dump($request->getSession()->get("MD"));
        var_dump($request->getSession()->get("TermUrl"));
        var_dump($request->getSession()->get("redirectTo"));
        var_dump($request->getSession()->get("mailAdyen"));

        var_dump($request->get("PaRes"));*/

        if ($request->getSession()->has("token")) {
            $user = User::where('email', $request->getSession()->get("mailAdyen"))->first();
            $cres = json_decode(base64_decode(str_replace("_", "/", str_replace("-", "+",$request["cres"]))), True);
            $result = App\Adyen::getResult3DS2($user, $cres["transStatus"]);

            $request->getSession()->forget('token');
            $request->getSession()->save();

            return self::printResult($result, $request);
        } elseif ($request->getSession()->has("MD") && $request->has("MD") && ($request->getSession()->get("MD") == $request->get("MD"))) {
            $user = User::where('email', $request->getSession()->get("mailAdyen"))->first();
            $result = App\Adyen::getResult3DS1($user, $request->get("MD"), $request->get("PaRes"));

            $request->getSession()->forget('MD');
            $request->getSession()->save();

            return self::printResult($result, $request);
        }

        return redirect()->back();
    }

    public function challenge(Request $request)
    {
        if ((!$request->getSession()->has("encodedcReq") or !$request->getSession()->has("token")) and !$request->getSession()->has("MD")){
            return redirect()->back();
        }

        //dd($request->getSession()->all(), $request->getSession()->has("encodedcReq"));
        //IdentifyShopper --> 3DS2
        if ($request->getSession()->has("encodedJSON")) {
            $redirectTo = $request->getSession()->get('redirectTo');
            $encodedJSON = $request->getSession()->get('encodedJSON');
            $request->getSession()->forget('encodedJSON');

            return view('order.redirectionAdyen')->with('redirectTo', $redirectTo)->with('encodedcReq', '')->with('MD', '')->with('PaReq', '')->with('TermUrl', '')->with('encodedJSON', $encodedJSON)->with('target', 'iframename');
        }

        //ChallengeShopper --> 3DS2
        if ($request->getSession()->has("encodedcReq")) {
            $redirectTo = $request->getSession()->get('redirectTo');
            $encodedcReq = $request->getSession()->get('encodedcReq');
            $request->getSession()->forget('encodedcReq');

            return view('order.redirectionAdyen')->with('redirectTo', $redirectTo)->with('encodedcReq', $encodedcReq)->with('MD', '')->with('PaReq', '')->with('TermUrl', '')->with('encodedJSON', '')->with('target', '_self');
        }

        //RedirectShopper --> 3DS1
        if ($request->getSession()->has("MD")) {
            $redirectTo = $request->getSession()->get('redirectTo');
            $MD = $request->getSession()->get('MD');
            $PaReq = $request->getSession()->get('PaReq');
            $TermUrl = $request->getSession()->get('TermUrl');

            return view('order.redirectionAdyen')->with('redirectTo', $redirectTo)->with('MD', $MD)->with('PaReq', $PaReq)->with('TermUrl', $TermUrl)->with('encodedcReq', '')->with('encodedJSON', '')->with('target', '_self');
        }
    }

    public function printResult($result, Request $request)
    {
        if (App\Adyen::isSuccess($result)) {
            $message = "Paiement réussi";

            if ($request->getSession()->has("urlRedirectAfterAdyen") and strpos($request->getSession()->get("urlRedirectAfterAdyen"), "/profile/")) {
                if ($request->getSession()->has("userAd") && $request->getSession()->has("dataAd")) {
                    $user = $request->getSession()->get("userAd");
                    $data = $request->getSession()->get("dataAd");

                    if (isset($data['card_number_part'])) {
                        $user->billing_card_number = "**** **** **** " . $data['card_number_part'];
                    }

                    if (isset($data['expiration_month'])) {
                        $user->billing_card_month = $data['expiration_month'];
                    }

                    if (isset($data['expiration_year'])) {
                        $user->billing_card_year = $data['expiration_year'];
                    }

                    if (isset($data['card_name'])) {
                        $user->billing_card_holder = $data['card_name'];
                    }

                    $user->save();
                }

                return redirect('/profile/account/#billing')->with('success', 'Payment information updated with success');
            }  elseif ($request->getSession()->has("urlRedirectAfterAdyen") and strpos($request->getSession()->get("urlRedirectAfterAdyen"), "/order/")) {
                event(new PickupConfirmationEvent( App\Pickup::find($request->getSession()->get("pickupAd")["id"])));
                $request->getSession()->get("orderAd")->saveSession();
                return redirect()->action([OrderController::class, 'getConfirmation'], ['orderBooking' =>  Order::retrieve()->booking->id]);
            }
        } else {
            $message = "Echec paiement";

            if ($request->getSession()->has("urlRedirectAfterAdyen") and strpos($request->getSession()->get("urlRedirectAfterAdyen"), "/profile/")) {
                return redirect('/profile/account')->withErrors(['billing' => lg("common.card-encryption-error")]);
            }

            if ($request->getSession()->has("urlRedirectAfterAdyen") and strpos($request->getSession()->get("urlRedirectAfterAdyen"), "/order/") and $request->getSession()->has("pickupAd") and $request->getSession()->has("invoiceAd") and $request->getSession()->has("bookingAd")) {
                try {
                    App\Pickup::find($request->getSession()->get("pickupAd")["id"])->forceDelete();
                    App\Invoice::find($request->getSession()->get("invoiceAd")["id"])->forceDelete();
                    App\OrderBooking::find($request->getSession()->get("bookingAd")["id"])->delete();
                } catch (Exception $e) {
                    \Log::info('Error deleting invoice');
                    \Log::error($e);
                    App\Api::sendAdminNotification($e->getMessage(), 'product@boxify.be', $e->getLine());
                }

                return redirect('/order/billing')->with('error', 'validation.custom.payment.error');
            }
        }

        //Should never happen
        echo "<script type='text/javascript'>";
        echo "alert('" . $message . "');";
        echo "window.location.replace('/')";
        echo "</script>";
    }

    /**
     * Index page
     *
     * @return \Illuminate\View\View
     */
    public function anyIndex($area = null)
    {
        $postalCode = null;

        extract(Label::extract('pages/home'));

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();

        shuffle($testimonials);

        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        /**
         * @var $user User
         */
        if ($user = $this->user) {
            if ($user->postalcode) {
                $postalCode = $user->postalcode;
            }
        }

        if ($order) {
            if ($order->address_postal_code) {
                $postalCode = $order->address_postal_code;
            }
        }

        if (request()->get('postal_code')) {
            $postalCode = request()->get('postal_code');
        }

        if ($area) {
            $meta['metatitle'] = ucfirst($area);
            $meta['metadescription'] = $area;

            $oArea = App\Area::where('slug', $area)->first();

            if ($oArea) {
                if (!$order) {
                    $order = new App\Order();
                }
                $order->address_postal_code = $oArea->zip_code;
            }
        }

        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();

        javascript()->namespace('__app')->set('cities', array_flatten(\App\Area::all(['slug'])->toArray()));

        return view()->make('pages.home', get_defined_vars());
    }

    /**
     * Index page
     *
     * @return \Illuminate\View\View
     */
    public function anyBusiness()
    {
        $mailSent = false;

        if (request()->has('email')) {
            $subject = request()->get('subject');
            $data = [
                'recipient_email' => request()->get('email'),
                'recipient_title' => 'B2B Request info from ' . request()->get('name'),
                'subject' => 'B2B Request info ' . request()->get('name'),
                'sender_email' => request()->get('email'),
            ];

            $content = '<h2>B2B Request from :</h2>';

            foreach (request()->all() as $key => $value) {
                if ($key == 'name' || $key == 'phone' || $key == 'email' || $key == 'business' || str_starts_with($key, 'option_')) {
                    $content .= ucfirst($key) . ' : ' . $value . ' <br />';
                }
            }

            $content .= "Message : <br /><div style='white-space:pre-wrap;padding: 0px 5px;border: 1px dashed grey;'>";
            $content .= request()->get('message');
            $content .= "</div>";

            Mail::send('emails.layout', ['content' => $content], function ($message) use ($data) {
                $message->to("b2bsupport@boxify.be", $data['recipient_title'])->replyTo($data['recipient_email'], 'Customer')->subject($data['subject']);
            });
            $mailSent = true;
        }

        $home_labels = Label::extract('pages/home');
        $business_labels = Label::extract('pages/business');

        $business_labels['areas']['areas'] = $home_labels['areas'];
        $business_labels['testimonials']['testimonials'] = $home_labels['testimonials'];

        extract($home_labels);
        extract($business_labels);

        $order = Order::retrieve();

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();
        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();
        $posts = Post::getByType('blog', ['format' => 'object'])->take(6);
        $meta = [
            'pagetitle' => lg('archive.storage.page.title'),
            'metadescription' => lg('archive.storage.page.metadescription'),
            'metatitle' => lg('business.page.metatitle'),
        ];


        return $this->viewMake('pages.business', get_defined_vars());
    }


     /**
     * merchandise page
     *
     * @return \Illuminate\View\View
     */
    public function anyMerchandise()
    {
        $mailSent = false;

        if (request()->has('email')) {
            $subject = request()->get('subject');
            $data = [
                'recipient_email' => request()->get('email'),
                'recipient_title' => 'B2B Request info from ' . request()->get('name'),
                'subject' => 'B2B Request info ' . request()->get('name'),
                'sender_email' => request()->get('email'),
            ];

            $content = '<h2>B2B Request from :</h2>';

            foreach (request()->all() as $key => $value) {
                if ($key == 'name' || $key == 'phone' || $key == 'email' || $key == 'business' || str_starts_with($key, 'option_')) {
                    $content .= ucfirst($key) . ' : ' . $value . ' <br />';
                }
            }

            $content .= "Message : <br /><div style='white-space:pre-wrap;padding: 0px 5px;border: 1px dashed grey;'>";
            $content .= request()->get('message');
            $content .= "</div>";

            Mail::send('emails.layout', ['content' => $content], function ($message) use ($data) {
                $message->to("b2bsupport@boxify.be", $data['recipient_title'])->replyTo($data['recipient_email'], 'Customer')->subject($data['subject']);
            });
            $mailSent = true;
        }

        $home_labels = Label::extract('pages/home');
        $business_labels = Label::extract('pages/business');

        $business_labels['areas']['areas'] = $home_labels['areas'];
        $business_labels['testimonials']['testimonials'] = $home_labels['testimonials'];

        extract($home_labels);
        extract($business_labels);

        $order = Order::retrieve();

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();
        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();
        $posts = Post::getByType('blog', ['format' => 'object'])->take(6);
        $meta = [
            'pagetitle' => lg('merchandise.storage.page.title'),
            'metadescription' => lg('merchandise.storage.page.metadescription'),
            'metatitle' => lg('business.page.metatitle'),
        ];


        return $this->viewMake('pages.merchandise', get_defined_vars());
    }


      /**
     * move page
     *
     * @return \Illuminate\View\View
     */
    public function anyMove()
    {
        $mailSent = false;

        if (request()->has('email')) {
            $subject = request()->get('subject');
            $data = [
                'recipient_email' => request()->get('email'),
                'recipient_title' => 'B2B Request info from ' . request()->get('name'),
                'subject' => 'B2B Request info ' . request()->get('name'),
                'sender_email' => request()->get('email'),
            ];

            $content = '<h2>B2B Request from :</h2>';

            foreach (request()->all() as $key => $value) {
                if ($key == 'name' || $key == 'phone' || $key == 'email' || $key == 'business' || str_starts_with($key, 'option_')) {
                    $content .= ucfirst($key) . ' : ' . $value . ' <br />';
                }
            }

            $content .= "Message : <br /><div style='white-space:pre-wrap;padding: 0px 5px;border: 1px dashed grey;'>";
            $content .= request()->get('message');
            $content .= "</div>";

            Mail::send('emails.layout', ['content' => $content], function ($message) use ($data) {
                $message->to("b2bsupport@boxify.be", $data['recipient_title'])->replyTo($data['recipient_email'], 'Customer')->subject($data['subject']);
            });
            $mailSent = true;
        }

        $home_labels = Label::extract('pages/home');
        $business_labels = Label::extract('pages/business');

        $business_labels['areas']['areas'] = $home_labels['areas'];
        $business_labels['testimonials']['testimonials'] = $home_labels['testimonials'];

        extract($home_labels);
        extract($business_labels);

        $order = Order::retrieve();

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();
        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();
        $posts = Post::getByType('blog', ['format' => 'object'])->take(6);
        $meta = [
            'pagetitle' => lg('move.page.title'),
            'metadescription' => lg('move.page.metadescription'),
            'metatitle' => lg('business.page.metatitle'),
        ];

        return $this->viewMake('pages.move', get_defined_vars());
    }



    /**
     * Faq page
     *
     * @return \Illuminate\View\View
     */
    public function anyAbout()
    {
        extract(Label::extract('pages/about'));
        return $this->viewMake('pages.about', get_defined_vars());
    }

    /**
     * Faq page
     *
     * @return \Illuminate\View\View
     */
    public function anyPartners()
    {
        extract(Label::extract('pages/partners'));
        return $this->viewMake('pages.partners', get_defined_vars());
    }

    /**
     * Faq page
     *
     * @return \Illuminate\View\View
     */
    public function anyPress()
    {
        extract(Label::extract('pages/press'));
        return $this->viewMake('pages.press', get_defined_vars());
    }

    /**
     * Faq page
     *
     * @return \Illuminate\View\View
     */
    public function anyJobs()
    {
        extract(Label::extract('pages/jobs'));
        return $this->viewMake('pages.jobs', get_defined_vars());
    }

    /**
     * Landing page
     *
     * @return \Illuminate\View\View
     */
    public function anyLanding()
    {
        return $this->viewMake('pages.landing', get_defined_vars());
    }

    /**
     * Service page
	 *
	 * Don't forget to do : php artisan labelmanager:sync
     *
     * @return \Illuminate\View\View
     */
    public function anyService()
    {
        extract(Label::extract('pages/home'));
        extract(Label::extract('pages/service'));

        return $this->viewMake('pages.service', get_defined_vars());
    }

    /**
     * Service page
     *
     * @return \Illuminate\View\View
     */
    public function anyStorageRules()
    {
        extract(Label::extract('pages/rules'));

        return $this->viewMake('pages.rules', get_defined_vars());
    }

    /**
     * Pricing page
     *
     * @return \Illuminate\View\View
     */
    public function anyPricing()
    {
        $postalCode = null;

        extract(Label::extract('pages/pricing'));

        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        /**
         * @var $user User
         */
        if ($user = $this->user) {
            if ($user->postalcode) {
                $postalCode = $user->postalcode;
            }
        }

        if ($order) {
            if ($order->address_postal_code) {
                $postalCode = $order->address_postal_code;
            }
        }

        if (request()->get('postal_code')) {
            $postalCode = request()->get('postal_code');
        }

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();
        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();

        return $this->viewMake('pages.pricing', get_defined_vars());
    }

    /**
     * Pricing page
     *
     * @return \Illuminate\View\View
     */
    /*public function anyPrivacy()
    {
        extract(Label::extract('pages/privacy'));

        return $this->viewMake('pages.default', get_defined_vars());
    }*/

    /**
     * Faq page
     *
     * @return \Illuminate\View\View
     */
    public function anyFaq()
    {
        extract(Label::extract('pages/faq'));
        return $this->viewMake('pages.faq', get_defined_vars());
    }

    /**
     * Login page
     *
     * @return \Illuminate\View\View
     */
    public function anyLogin()
    {
        return $this->viewMake('auth.login', get_defined_vars());
    }

    /**
     * Contact page
     *
     * @return \Illuminate\View\View
     */
    public function anyContact()
    {
        extract($labels = Label::extract('pages/contact'));
        $result = false;
        $form = $labels['form'];

        if (request()->has('email')) {
            $subject = request()->get('subject');
            $data = [
                'recipient_email' => $form['subjects'][$subject]['email'],
                'recipient_title' => $form['subjects'][$subject]['title'],
                'subject' => $form['subjects'][$subject]['title'],
                'sender_email' => request()->get('email'),
            ];

            $content = request()->get('message');

            Mail::send('emails.text', ['content' => $content], function ($message) use ($data) {
                $message->to($data['recipient_email'], $data['recipient_title'])->replyTo($data['sender_email'], 'Customer')->subject($data['subject']);
                $message->to("product@boxify.be", $data['recipient_title'])->replyTo($data['recipient_email'], 'Customer')->subject($data['subject']);
            });
            $result = true;
        }

        return $this->viewMake('pages.contact', get_defined_vars());
    }

    /**
     * Page terms
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function anyTerms()
    {
        return redirect('/files/terms_' . App::getLocale() . '.pdf');
    }

    /**
     * Signup page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function anySignup(Request $request)
    {
        if (!$request->has('error')) {
            return redirect('/order');
        }

        return $this->viewMake('auth.register', get_defined_vars());
    }

}
