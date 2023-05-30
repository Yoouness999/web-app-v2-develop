<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use DB;
use Config;

class AjoutFactureOdoo extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'odoo:ajout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Transfert des nouvelles factures vers Odoo';

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
		/*
		$all = \App\Invoice::where("created_at", ">=", Carbon::create(2021, 01, 01, 0, 0, 0, "Europe/Paris"))->get();
        foreach($all as $inv){
        	$inv->transferred_to_odoo = 0;
        	$inv->odoo_updated_at = Carbon::create(0000, 00, 00, 0, 0, 0, "Europe/Paris");
        	$inv->save();
        }*/
		$all = \App\Invoice::where("transferred_to_odoo", "<=", 0)
		//->where("type", "credit_note")
		//->where("credit_note_id", 1060)
		->where("created_at", ">=", Carbon::create(2021, 1, 1, 0, 0, 0, "Europe/Paris"))
		//->where("created_at", "<", Carbon::create(2021, 11, 1, 0, 0, 0, "Europe/Paris"))
		->limit(200)
		//->select("number")
		->get();
		//dd($all);

        foreach($all as $inv){
        	//On comptabilise un essai
        	//$inv->transferred_to_odoo -= 1;
        	//$inv->save();
            //Récupération du client associé à la facture
            $client = \App\User::where("id", $inv->user_id)->first();
            //Lancement du script Python pour ajouter les factures/notes de crédit sur Odoo
            if(strpos($inv->number, "nc") == False){
	            $path = "python3 " . base_path() . "/app/ScriptPython/AjoutFacture.py '" . str_replace("'", "&#39", $inv) . "' '" . str_replace("'", "&#39", $client) . "' '" . self::getConfig() . "'";
	        }
	        else{
	        	$invoiceToRefund = \App\Invoice::where("credit_note_id", $inv->id)->first();
	        	$path = "python3 " . base_path() . "/app/ScriptPython/AjoutNC.py '" . str_replace("'", "&#39", $inv) . "' '" . str_replace("'", "&#39", $invoiceToRefund) . "' '" . self::getConfig() . "'";
	        }
            $process = new Process($path);
            $process->setTimeout(3600);
            $process->run();
            $o = $process->getOutput();
            //dd($o);

            //Vérification que les données ont bien été enregistrées sur Odoo
            $verif = $this->verif($inv);
            if($verif == 1){
                //Si elles ont bien été transférées, on peut l'indiquer en bdd
                $inv->transferred_to_odoo = 1;
                $inv->odoo_updated_at = Carbon::now();
                $inv->save();
            }
            /*else{
            	dd($inv->number);
            }*/

            //dd($verif, $inv->number, $client->name);

        }
	}

	public function verif($data){
        $path = "python3 " . base_path() . "/app/ScriptPython/Verif.py '" . str_replace("'", "&#39", $data) . "' '" . self::getConfig() . "'";
        $process = new Process($path);
        $process->setTimeout(3600);
        $process->run();
        $output = $process->getOutput();
        return $output;
    }

    public function getConfig(){
        $config = [
        	'username' => Config::get('odoo.username'),
        	'db' => Config::get('odoo.db'),
        	'url' => Config::get('odoo.url'),
        	'api_key' => Config::get('odoo.api_key')
        ];
        return json_encode($config);
    }

}

