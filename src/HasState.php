<?php

namespace Shu;

/**
 * Introduce states into your models
 * ----
 * This trait is used to introduce states into your models.
 */
trait HasState
{
    public static $stateMachine = null;

    /**
     * Return the state machine
     */
    public static function state(): StateMachine
    {
        if (!static::$stateMachine) {
            static::$stateMachine = new StateMachine(new (static::$state));
            static::$stateMachine->useModel(static::class);

            if (static::$stateKey) {
                static::$stateMachine->useKey(static::$stateKey);
            }
        }

        return static::$stateMachine;
    }
}
