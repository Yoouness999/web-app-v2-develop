<?php

namespace Modules\Datamanager\Traits;

trait getMetaAttributeTrait {
    /**
     * Get Meta
     *
     * @param $value
     * @return array|mixed
     */
    public function getMetaAttribute($value)
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

    /**
     * Get meta from dot notated format
     */
    public function getMeta($name)
    {
        $meta = $this->meta;

        return array_get($meta, $name);
    }

    /**
     * Set value
     *
     * @param $name
     * @param $value
     * @return string
     */
    public function setMeta($name, $value){

        $meta = $this->meta;

        $meta = array_set($meta, $name, $value);

        $this->meta = json_encode($meta);

        $this->save();

        return $this->meta;
    }


    public function scopeByMeta($query, $key, $value){
        return $query->whereRaw('meta REGEXP ?', ['\"'.$key.'\"\:\"(.*?)'.$value.'(.*?)\"']);
    }
}
