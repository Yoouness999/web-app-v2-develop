<?php

namespace Arxmin\models;

use Arxmin\traits\modelApiTrait;

/**
 * Class Api
 *
 * Api Current Version
 *
 */
class Api extends \Arx\classes\Singleton
{
    use modelApiTrait;

    /**
     * Api Current Version
     *
     * @var string
     */
    public static $version = "1.0.0";
}
