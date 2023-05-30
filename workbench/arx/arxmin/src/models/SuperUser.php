<?php

namespace Arxmin\models;

use Illuminate\Auth\GenericUser;
use Arxmin\modelUserTrait;

/**
 * Class SuperUser
 *
 * Mock a Super Admin User from the option table
 *
 * @package Arxmin
 */
class SuperUser extends GenericUser
{
    use modelUserTrait;
}
