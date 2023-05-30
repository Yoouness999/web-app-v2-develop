<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\MailConfirmation;
use DB;
//use Mail;

class VerifFactureOdoo extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'odoo:verif';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Envoie un mail si les données n\'ont pas étées correctement ajoutées / mises à jour sur Odoo';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		//On récupère les numéros des max 10 (pour pas encombrer le mail) factures dont le transfert/la modification a échoué + leur nombre total
        $d0 = \App\Invoice::select("id", "number")->where("transferred_to_odoo", "<=" , 0)->limit(10)->get();
        $dMod = \App\Invoice::select("id", "number")->where("transferred_to_odoo", 1)->where("updated_at", ">", "odoo_updated_at")->limit(10)->get()->toArray();
        $nb0 = \App\Invoice::where("transferred_to_odoo", 0)->count();
        $nbMod = \App\Invoice::where("transferred_to_odoo", 1)->where("updated_at", ">", "odoo_updated_at")->count();

        //Conversion en array
        $tab0 = array();
        for($i = 0; $i < count($d0); $i++){
            $tab0[] = strval($d0[$i]["number"]) . " (id : " . strval($d0[$i]["id"] . ")");
        }
        if($nb0 > 10){$tab0[] = "...";}
        $tabMod = array();
        for($i = 0; $i < count($dMod); $i++){
            $tabMod[] = strval($dMod[$i]["number"]) . " (id : " . strval($dMod[$i]["id"] . ")");
        }
        if($nbMod > 10){$tabMod[] = "...";}

        if($nbMod > 0 OR $nb0 > 0){
        	//Mail::send("paulinegodefroid@skynet.be")->queue(new MailConfirmation($tab0, $tabMod, $nb0, $nbMod));
        	Mail::send('emails.MailConfirmation', ['nb0' => $nb0, 'nbMod' => $nbMod, 'd0' => $tab0, 'dMod' => $tabMod], function ($message) {
                $message->to("paulinegodefroid@skynet.be")->subject("Erreurs pendant le transfert vers Odoo");
            });
        }
	}




}
