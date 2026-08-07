<?php

return [

    // Dashboard
    [
        'title' => 'Dashboard',
        'icon' => 'bi bi-grid-fill',
        'route' => 'dashboard',
        'active' => ['dashboard*'],
        'permission' => 'read_dashboard',
    ],

    // Master Data
    [
        'title' => 'Master Data',
        'icon' => 'bi bi-stack',
        'active' => ['program-studi*', 'tahun-akademik*', 'gelombang*'],

        'permissions' => [
            'read_master_program_studi',
            'read_master_tahun_akademik',
            'read_master_gelombang',
        ],

        'children' => [

            [
                'title' => 'Program Studi',
                'route' => 'program-studi',
                'active' => ['program-studi*'],
                'permission' => 'read_master_program_studi',
            ],

        ]

    ],

    // User Management
    [
        'title' => 'User Management',
        'icon' => 'bi bi-person-fill-gear',
        'active' => ['users*', 'roles*', 'permissions*'],

        'permissions' => [
            'read_user',
            'read_role',
            'read_permission',
        ],

        'children' => [

            [
                'title' => 'Users',
                'route' => 'users',
                'active' => ['users*'],
                'permission' => 'read_user',
            ],

            [
                'title' => 'Roles',
                'route' => 'roles',
                'active' => ['roles*'],
                'permission' => 'read_role',
            ],

            [
                'title' => 'Permissions',
                'route' => 'permissions',
                'active' => ['permissions*'],
                'permission' => 'read_permission',
            ],

        ]

    ],

];