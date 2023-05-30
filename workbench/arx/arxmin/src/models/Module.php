<?php

namespace Arxmin\models;

use Arx\classes\Str;
use File;
use ZipArchive;
use Module as ParentClass;

/**
 * Class Module
 *
 * @package Arxmin
 */
class Module extends ParentClass
{

    public static $currentModule = null;

    public static function cleanTemp()
    {
        $files = File::files(__DIR__);
        // Remove all non php files
        foreach ($files as $file) {
            if (!preg_match('/\.php$/', $file)) {
                File::delete($file);
            }
        }
    }

    /**
     * Download the module from an url
     *
     * @param $url
     * @param $dest
     * @return bool
     */
    public static function download($url, $name, $dest = null)
    {

        if ($dest == null) {
            $dest = \Module::getPath();
        }

        $tmpName = date($name . '-Ymdhis.zip');

        $result = file_put_contents(__DIR__ . "/" . $tmpName, fopen($url, 'r'));

        if ($result) {
            $zip = new ZipArchive;
            if ($zip->open(__DIR__ . "/" . $tmpName) === true) {

                $destFolder = $dest . '/' . $name;
                $oldFolder = "";

                if (is_dir($destFolder)) {

                    $oldFolder = $destFolder . '-old';

                    if (is_dir($oldFolder)) {
                        File::deleteDirectory($oldFolder);
                    }

                    rename($destFolder, $oldFolder);
                }

                $tmpFolder = $dest . '/' . $name . '-tmp';

                $zip->extractTo($tmpFolder);
                $zip->close();

                $file = glob($tmpFolder . '/*');

                $result = rename($file[0], $destFolder);

                File::deleteDirectory($tmpFolder);

                if ($result) {
                    File::deleteDirectory($oldFolder);
                }

                // Cleaning generate temp file
                self::cleanTemp();

                return $result;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * Method to guess the current module used
     *
     * @todo : improve this method
     */
    public static function guessCurrentModule()
    {
        $aDebug = debug_backtrace(1);
        $modules = \Module::all();

        if (isset($aDebug[1])) {
            foreach ($aDebug as $item) {
                if (isset($item['file'])) {
                    foreach ($modules as $module) {
                        if (strpos($item['file'], $module->path)) {
                            self::$currentModule = $module->name;
                            Module::setCurrent($module->name);
                            break;
                        }
                    }
                }
            }
        } else {
            Throw new \Exception('Cannot set current module dynamically');
        }
    }

    public static function getUsedNow()
    {
        # Check if modules exists
        if (!is_file(storage_path('app/modules/modules.used'))) {
            // If not defined => get the first one from the list

            $modules = parent::all();

            if ($modules) {
                $module = array_shift($modules);
                $name = $module->getName();
            } else {
                $name = "";
            }

            File::put(storage_path('app/modules/modules.used'), $name);
        }

        return parent::getUsedNow();
    }

    public static function moduleAsset($path)
    {
        return self::asset(self::getUsed() . ':') . Str::mustBeginWith('/', $path);
    }

    public static function modulePath($path)
    {
        return self::getModulePath(self::getUsed()) . $path;
    }

    public static function moduleUrl($path = null)
    {
        return arxminUrl('modules/' . strtolower(self::getUsed()) . Str::mustBeginWith('/', $path));
    }


    /**
     * Apply current module
     *
     * @param $name
     */
    public static function setUsed($name)
    {
        /**
         * Fix strange bug when there is no modules used in PingPong Modules
         */
        if (!is_file(storage_path('app/modules/modules.used'))) {
            file_put_contents(storage_path('app/modules/modules.used'), $name);
        }

        self::$currentModule = $name;
        parent::setUsed($name);
    }

    /**
     * Set the current used module
     *
     * @param $name
     */
    public static function setCurrent($name)
    {
        self::setUsed($name);
    }
}
