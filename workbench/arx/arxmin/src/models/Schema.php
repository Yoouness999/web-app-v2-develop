<?php

namespace Arxmin\models;

use Config;
use Illuminate\Database\Eloquent\Builder;
use \Schema as ParentClass;

class Schema extends ParentClass {

    /**
     * SchemaModel Builder
     *
     * @param \Illuminate\Database\Connection $connection
     */
    public function __construct($connection){

        $connection = Config::get('arxmin.db.default');

        new Builder($connection);
    }
}
