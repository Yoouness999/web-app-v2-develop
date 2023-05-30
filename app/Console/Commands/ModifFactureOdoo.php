<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use DB;

class ModifFactureOdoo extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'odoo:modif';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Mise à jour des factures sur Odoo';

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
		//On récupère les factures modifiées récemment
        $all = \App\Invoice::where("updated_at", ">", DB::raw("odoo_updated_at"))->where("transferred_to_odoo", 1)->get();
        foreach($all as $inv){
        	//Récupération du client associé à la facture
            $client = \App\User::where("id", $inv->user_id)->first();
            //On regarde si il y a des champs repris sur Odoo à mettre à jour
            $verif = $this->verif($inv);
            if($verif == 0){
                //Lancement du script Python pour modifier les factures sur Odoo
                $path = "python3 " . base_path() . "/app/ScriptPython/AjoutFacture.py '" . str_replace("'", "&#39", $inv) . "' '" . str_replace("'", "&#39", $client) . "'";
                $process = new Process($path);
                $process->run();
            }
            //Si la mise à jour est faite sur Odoo, on update la date dans la bdd
            $verif = $this->verif($inv);
            if($verif == 1){
                $inv->odoo_updated_at = Carbon::now();
                $inv->save();
            }
        }
	}

	public function verif($data){
        $path = "python3 " . base_path() . "/app/ScriptPython/Verif.py '" . str_replace("'", "&#39", $data) . "'";
        $process = new Process($path);
        $process->run();
        $output = $process->getOutput();
        return $output;
    }

}
