<?php

test('creates a state machine', function () {
    $machine = createMachine([]);

    expect($machine)->toBeInstanceOf(\Shu\StateMachine::class);
});

test('takes in state machine options', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    expect($machine->initial())->toBe('pending');
    expect($machine->states())->toBe(['pending', 'approved', 'rejected']);
    expect($machine->transitions())->toBe(['approve', 'reject']);
});

test('can check if a transition is possible', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    expect($machine->can('approve'))->toBe(true);
    expect($machine->can('reject'))->toBe(true);
    expect($machine->can('unknown'))->toBe(false);

    expect($machine->state())->toBe('pending');
});

test('can transition to a new state', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    $machine->transition('approve');

    expect($machine->state())->toBe('approved');
});

test('can transition to a new state with an action', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    $machine->transition('reject');

    expect($machine->state())->toBe('rejected');
});

test('can transition to a new state with an action that fails', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    $machine->transition('reject');

    expect($machine->state())->toBe('pending');
});

test('can reset machine', function () {
    $machine = createMachine([
        'initial' => 'pending',
        'states' => [
            'pending',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => 'pending',
                'to' => 'approved',
            ],
            'reject' => [
                'action' => function () {
                    $success = db()
                        ->update('users')
                        ->values([
                            'status' => 'rejected'
                        ])
                        ->where([
                            'id' => 1
                        ]);

                    if ($success) {
                        return 'rejected';
                    }

                    return 'pending';
                },
            ],
        ],
    ]);

    expect($machine->transition('approve'))->toBe('approved');
    $machine->reset();

    expect($machine->is('pending'))->toBe(true);
    expect($machine->state())->toBe('pending');
});
