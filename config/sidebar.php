<?php

return [

    [
        'title' => 'Menu',
        'menus' => [

            [
                'title' => 'Dashboard',
                'icon' => 'bi bi-grid-fill',
                'route' => 'dashboard',
                'permission' => 'read_dashboard',
            ],

            [
                'title' => 'Master Data',
                'icon' => 'bi bi-stack',
                'children' => [
                    [
                        'title' => 'Program Studi',
                        'route' => 'program-studi',
                        'permission' => 'read_master_program_studi',
                    ],
                ],
            ],

        ],
    ],

    [
        'title' => 'Setting',
        'menus' => [

            [
                'title' => 'User Management',
                'icon' => 'bi bi-person-fill-gear',
                'children' => [
                    ['title' => 'Users',       'route' => 'users',       'permission' => 'read_user'],
                    ['title' => 'Roles',       'route' => 'roles',       'permission' => 'read_role'],
                    ['title' => 'Permissions', 'route' => 'permissions', 'permission' => 'read_permission'],
                ],
            ],

        ],
    ],

];
