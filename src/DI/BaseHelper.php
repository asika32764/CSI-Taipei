<?php

namespace DI;

/**
 * A helper base class
 */
abstract class BaseHelper
{
    /**
     * __invoke description
     *
     * @param  string
     * @param  string
     * @param  string
     *
     * @return  string  __invokeReturn
     *
     * @since  1.0
     */
    public function __invoke($helper = null)
    {
        return $this;
    }
}