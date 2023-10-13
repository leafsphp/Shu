<?php

namespace Shu;

/**
 * StateMachine
 * -----
 * Create a new Shu state machine
 */
class StateMachine
{
    protected $state;
    protected $initial;
    protected $states;
    protected $transitions;
    protected $throwExceptions = false;
    protected $errors = [];

    protected $stateKey;

    protected $model = null;

    /**
     * Create a new state machine
     *
     * @param array|State $state The state for the machine
     *
     * @return void
     */
    public function __construct($state)
    {
        if (!is_array($state)) {
            $state->create();
            $state = $state->toArray();
        }

        $this->initial = $state['initial'] ?? null;
        $this->states = $state['states'] ?? [];
        $this->transitions = $state['transitions'] ?? [];

        $this->state = $this->initial;
    }

    /**
     * Toggle debug mode
     *
     * @return StateMachine
     */
    public function throwExceptions(): StateMachine
    {
        $this->throwExceptions = true;

        return $this;
    }

    /**
     * Return the initial state
     *
     * @return string
     */
    public function initial()
    {
        return $this->initial;
    }

    /**
     * Return the states
     *
     * @return array
     */
    public function states(): array
    {
        return $this->states;
    }

    /**
     * Return the transitions
     *
     * @return array
     */
    public function transitions(): array
    {
        return array_keys($this->transitions);
    }

    /**
     * Check if a transition is possible
     *
     * @param string $transition
     * @return bool
     */
    public function can(string $transition): bool
    {
        if (!isset($this->transitions[$transition])) {
            return false;
        }

        if (!in_array($this->state(), explode('|', $this->transitions[$transition]['from']))) {
            return false;
        }

        return true;
    }

    /**
     * Transition to a new state
     *
     * @param string $transition
     * @return string
     */
    public function transition(string $transition): string
    {
        if (!$this->can($transition)) {
            if (!$this->throwExceptions) {
                $this->errors[] = 'Cannot transition from ' . $this->state() . ' to ' . $this->transitions[$transition]['to'] ?? $transition;
            } else {
                throw new \Exception('Cannot transition from ' . $this->state() . ' to ' . $this->transitions[$transition]['to'] ?? $transition);
            }

            return $this->state();
        }

        $transition = $this->transitions[$transition];

        if (isset($transition['action'])) {
            if (!call_user_func($transition['action'], $this->state())) {
                if (!$this->throwExceptions) {
                    $this->errors[] = 'Transition action failed';
                } else {
                    throw new \Exception('Transition action failed');
                }

                return $this->state();
            }
        }

        $this->state = $transition['to'];

        return $this->state();
    }

    /**
     * Check if the current state is the given state
     *
     * @param string $state
     * @return bool
     */
    public function is(string $state): bool
    {
        return $this->state() === $state;
    }

    /**
     * Return the current state
     *
     * @return string
     */
    public function state(): string
    {
        return $this->state;
    }

    /**
     * Toggle the state machine to use a model
     *
     * @param mixed $model The model to use
     */
    public function useModel($model): StateMachine
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set the key to use for the model
     */
    public function useKey(string $key): StateMachine
    {
        $this->stateKey = $key;

        return $this;
    }

    /**
     * Reset the state machine to the initial state
     *
     * @return void
     */
    public function reset(): void
    {
        $this->state = $this->initial;
    }

    /**
     * Return the errors
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Reset machine errors
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Return the state machine as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'initial' => $this->initial,
            'states' => $this->states,
            'transitions' => $this->transitions,
        ];
    }
}
