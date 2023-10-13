<?php

namespace Shu;

/**
 * Create a state class for your state machine
 * -----
 * This class is used to create a state for your state machine.
 */
abstract class State
{
    protected $initial;
    protected $states = [];
    protected $transitions = [];

    /**
     * Create a new state
     * 
     * @return void
     */
    abstract public function create();

    /**
     * Set initial state
     * 
     * @param string $state The initial state
     * 
     * @return State
     */
    public function setInitial($state)
    {
        $this->initial = $state;
        return $this;
    }

    /**
     * Add a state
     * 
     * @param string|array $state The state to add
     * 
     * @return State
     */
    public function addState($state)
    {
        if (is_array($state)) {
            $this->states = array_merge($this->states, $state);
        } else {
            $this->states[] = $state;
        }

        return $this;
    }

    /**
     * Create a new transition
     * 
     * @param string|array $transition The name of the transition or an array of transitions
     * @param array $data The transition to create
     * 
     * @return State
     */
    public function addTransition($transition, array $data = [])
    {
        if (is_array($transition)) {
            foreach ($transition as $name => $data) {
                $this->addTransition($name, $data);
            }
        } else {
            $this->transitions[$transition] = $data;
        }

        return $this;
    }

    public function toArray()
    {
        return [
            'initial' => $this->initial,
            'states' => $this->states,
            'transitions' => $this->transitions,
        ];
    }
}
