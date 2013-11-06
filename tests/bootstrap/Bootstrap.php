<?php

namespace Scandio\lmvc\utils\test;

class Bootstrap extends \Scandio\lmvc\utils\bootstrap\Bootstrap
{
    private
        $_hasBeenInitialized = false;

    public function initialize()
    {
        $this->_hasBeenInitialized = true;

        return true;
    }

    public function hasBeenInitialized()
    {
        return $this->_hasBeenInitialized;
    }
}