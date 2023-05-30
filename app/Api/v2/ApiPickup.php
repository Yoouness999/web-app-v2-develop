<?php

namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\Item;
use App\Pickup;

class ApiPickup
{
    protected $pickup;

    public static function add($params = [])
    {

        if (isset($params['items'])) {
            $items = $params['items'];
            unset($params['items']);
        }

        $pickup = Pickup::create($params);
        $pickup->save();

        if (isset($items)) {
            self::syncItems($pickup, $items);
        }

        return $pickup;
    }

    public static function get($params = [])
    {
        return ApiHelper::get(Pickup::query(), $params);
    }

    public static function save($id, $params = [])
    {

        if (isset($params['items'])) {
            $items = $params['items'];
            unset($params['items']);
        }

        $pickup = Pickup::find($id);

        /**
         * When pickup is completed => make the reajustment of the prorata
         */
        if (isset($params['action']) && $params['action'] === 'complete') {
            $pickup->complete();
        }

        $pickup = $pickup->fill($params);
        $pickup->save();

        if (isset($items)) {
            self::syncItems($pickup, $items);
        }

        return $pickup;
    }

    /**
     * Sync items regarding the pickup
     *
     * @param $items
     */
    public static function syncItems($pickup, $items)
    {
        $itemsToSynchronize = [];

        foreach ($items as $item) {

            if (is_array($item)) {
                $item = $item['id'];
            }

            $item = Item::find($item);

            if ($item) {
                //Item status should not me modified while updating pickup/delivery.
                //$item->status = Item::STATUS_ORDERED;
                //$item->save();
                $itemsToSynchronize[] = $item->id;
            }
        }

        $pickup->itemsRecords()->sync($itemsToSynchronize);
    }
}
