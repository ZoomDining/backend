<?php
return [
    'controllerAccess' => [
        'type' => 2,
        'description' => 'controller Access',
        'ruleName' => 'controllerAccess',
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
    ],
    'manager' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'user',
            'controllerAccess',
        ],
    ],
    'restaurant' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'manager',
            'controllerAccess',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'restaurant',
            'controllerAccess',
        ],
    ],
];
