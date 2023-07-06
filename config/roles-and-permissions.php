<?php

$permissions = [
    'users' => [
        'list',
        'show',
        'create',
        'update',
        'delete',
    ],
];

$roles = [
    'master' => [
        '*',
    ],
    'manager' => [
        'users' => [
            $permissions['users'][0]
        ],
    ],
];

return [
    'roles' => $roles,
    'permissions' => $permissions,
];