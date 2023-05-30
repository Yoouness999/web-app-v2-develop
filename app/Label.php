<?php namespace App;

use App;
use Config;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Input;
use Lang;
use Session;

/**
 * Class Label
 *
 * @package Modules\Labelmanager\Entities
 */
class Label extends Model
{
    public static $aUndefinedLabels = array();
    public static $locales = null;
    public $hidden = array();

    public $locale = null;

    # Labels stocked memory
    public $lb = null;
    protected $fillable = ['ref', 'meta'];

    /**
     * Constructor method
     */
    public function __construct()
    {

        parent::__construct();

        global $lb;

        $lb = null;

        $this->locale = App::getLocale();
    }

    /**
     * Extract all info into an array
     * @param $key
     */
    public static function extract($key, $locale = null)
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }

        $labels = self::where('ref', 'LIKE', $key . '%')->pluck($locale, 'ref');

        $data = \Arr::dot_array($labels);

        return $data[$key];
    }

    /**
     * Get Label from table
     *
     * @param $key
     * @param string|array $mGroup
     * @param array $params
     * @param null $locale
     *
     * @return string
     *
     */
    public function get($key, $mGroup = '', $params = array(), $locale = null)
    {
        global $lb;

        if (!$lb) {
            self::getAll();
        }

        # if mGroup is array it's params
        if (is_array($mGroup)) {
            $params = $mGroup;
            $mGroup = '';
        }

        # We add a dot if a group exist
        if (!empty($mGroup) && !(substr($mGroup, -1) === '.')) {
            $mGroup .= '.';
        }

        $ref = $mGroup . $key;

        # If LabelMode is defined => we show the reference

        $labelMode = request()->get('labelMode');
        if ($labelMode === 'info') {
            return $mGroup . $key;
        }

        # If ref exist in labelmanager => we show the ref
        if (isset($lb[$ref])) {
            return $lb[$ref];
        }

        # Else we use tha Lang::get() definition
        $value = Lang::get($ref, $params, $locale);

        /**
         * if we can't find any label
         */
        if ($value == $ref) {
            $this->missingLabel($ref, $key, $mGroup);
            return $key;
        }

        return $value;

    }

    /**
     * Get All Labels
     * @param array $params
     * @return array
     */
    public static function getAll($params = [])
    {
        global $lb;

        if (!$lb || $params === 'refresh' || isset($params['refresh'])) {
            $lb = [];
            $data = self::all()->toArray();
            foreach ($data as $key => $item) {
                try {
                    $lb[$item['ref']] = $item[App::getLocale()];
                } catch (Exception $e) {
                    dd(App::getLocale());
                }
            }
            // Add to as array
            $array = \Arr::dot_array($lb);
            $lb = array_merge($array, $lb);
        }

        return $lb;
    }

    /**
     * Handle missing Label
     *
     * @param $uniqueId
     * @param $key
     * @param $group
     */
    public function missingLabel($ref, $value, $group)
    {

        if (request()->has('writeMode')) {
            Session::put('writeMode', true);
        }

        if (request()->has('readMode')) {
            Session::forget('writeMode');
        }

        if (Session::has('writeMode')) {
            try {
                $label = new self;

                $label->ref = $ref;
                $label->meta = $group;

                foreach (config("app.locales") as $lang => $language) {
                    $label->$lang = $value;
                }

                $label->save();

            } catch (\Exception $e) {
                //Throw $e;
            }

        }
    }

    /***
     * Get Locale file
     *
     * @return mixed
     */
    public static function getLocales()
    {
        self::$locales = Config::get('app.locales');

        return self::$locales;
    }

    /**
     * Transform Meta Attribute
     *
     * @param $value
     *
     * @return string|void
     */
    public function getMetaAttributes($value)
    {

        if (is_array($value)) {
            return $value;
        }

        $return = json_decode($value, true);

        if (!is_array($return))
            return array();
        else
            return $return;
    }
}
