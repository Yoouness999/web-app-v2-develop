<?php namespace Modules\Labelmanager\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Label Facade
 *
 * @see \Modules\Labelmanager\Entities\Label
 */
class Label extends Facade
{
    /**
     * Get Loaded labels
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'label';
    }
}
