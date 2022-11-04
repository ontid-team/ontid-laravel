<?php

namespace App\Traits;

trait Singleton {

    protected static $instance = null;

    /**
     * @return static
     */
    public static function instance()
    {

        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /** protected to prevent cloning */
    protected function __clone()
    {
    }

    /** protected to prevent instantiation from outside of the class */
    protected function __construct()
    {
    }
}
