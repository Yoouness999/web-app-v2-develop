<?php namespace Modules\Labelmanager\Console;

use Illuminate\Console\Command;
use Modules\Labelmanager\Entities\Label;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\SplFileInfo;

class SyncFromResourcesLangFolder extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'labelmanager:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync labels from resources folder to admin';

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
    public function fire()
    {
        # List all files in folders

        # Make a copy of old tables
		if ($this->command_exists('mysqldump')) {
			$file = base_path('_backup/labels-'.date('Ymd-His').'.sql');
			$config = config('database.connections.'.config('database.default'));
			$command = "mysqldump {$config['database']} labels --user={$config['username']} --password={$config['password']} > $file";
			exec($command);
		}

        $labels = [];

        foreach (config('app.locales') as $key => $lang){
            $labels[$key] = [];
        }

        /**
         * @var $file SplFileInfo
         */

        foreach (config('app.locales') as $key => $lang){

            foreach (\File::allFiles(base_path("/resources/lang/".$key)) as $file) {

                $data = include $file->getPathname();
				
				$filePathName = str_replace('\\', '/', $file->getPathname(). '.');
				$basePath = str_replace('\\', '/', base_path('/resources/lang/' . $key . '/'));

                $name = str_replace(['.php', $basePath], [''], $filePathName);

                $label = array_dot($data, $name);

                $labels[$key] = array_merge($labels[$key], $label);
            }
        }

        foreach ($labels[config('app.locale')] as $ref => $value){

            # Check if the translation already exists
            $label = Label::where('ref', $ref)->first();
			
            if (!$label) {
                $label = new Label();
                $label->ref = $ref;

                $fullyTranslated = true;

                foreach (config('app.locales') as $lang => $oLang){
                    $label->{$lang} = isset($labels[$lang][$ref]) ? $labels[$lang][$ref] : $value;

                    if(!isset($labels[$lang][$ref])){
                        $fullyTranslated = false;
                    }
                }

                if (!$fullyTranslated) {
                    $label->meta = json_encode(['translated' => false]);
                }

                $label->save();
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
	
	/**
     * Check if a command exists.
     *
     * @return boolean
     */
	protected function command_exists($command) {
		$whereIsCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';

		$process = proc_open(
			"$whereIsCommand $command",
			array(
				0 => array("pipe", "r"), //STDIN
				1 => array("pipe", "w"), //STDOUT
				2 => array("pipe", "w"), //STDERR
			),
			$pipes
		);
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);

			return $stdout != '';
		}

		return false;
	}
}
