<?php

declare(strict_types=1);

if (!function_exists('createMachine')) {
    /**
     * Return the Leaf instance
     *
     * @param array|\Shu\State The state for the machine
     */
    function createMachine($state): \Shu\StateMachine
    {
        return new \Shu\StateMachine($state);
    }
}
