<?php

namespace BetterCollective\WpPlugins\DynamicShortcodeAPI\Traits;

trait SingletonTrait
{
    /**
     * @var SingletonTrait $instance 
     */
    private static $instance;

    /**
     * @return $this
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
