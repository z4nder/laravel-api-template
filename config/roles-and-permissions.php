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
        $permissions['users'][0],
        $permissions['users'][1],
    ],
];

return [
    'roles' => $roles,
    'permissions' => $permissions,
];
