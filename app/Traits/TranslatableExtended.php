<?php

namespace App\Traits;


use Astrotomic\Translatable\Translatable;

trait TranslatableExtended
{
    use Translatable;

    /**
     * Get the translation by local API
     */
    public function geTranslationsByLocal()
    {
        $translations = [];

        foreach (config('translatable.locales') as $lang) {
            $translations[$lang] = [];

            foreach ($this->translatedAttributes as $key){
                $translations[$lang][$key] = $this->translate($lang) ? $this->translate($lang)->{$key} : $this->{$key};
            }
        }

        return $translations;
    }

    public static function translateName($item, $params)
    {

        foreach (config('translatable.locales') as $local) {
            if (isset($params[$local], $params[$local]['name'])) {
                $item->translate($local)->name = $params[$local]['name'];
                $item->save();
            }
        }

        return $item;
    }
}
