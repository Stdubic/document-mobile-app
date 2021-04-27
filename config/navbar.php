<?php

return [
	[
		'type' => 'divider',
		'title' => 'PAGES'
	],
	[
		'title' => 'Dashboard',
		'icon_class' => 'fa fa-chart-line',
		'route' => 'dashboard'
	],
    [
        'title' => 'Documents',
        'icon_class' => 'fa fa-file',
        'items' => [
            [
                'title' => 'Add document',
                'route' => 'documents.add'
            ],
            [
                'title' => 'List documents',
                'route' => 'documents.list'
            ]
        ]
    ],
    [
        'title' => 'Videos',
        'icon_class' => 'fa fa-video',
        'items' => [
            [
                'title' => 'Add Video',
                'route' => 'videos.add'
            ],
            [
                'title' => 'List videos',
                'route' => 'videos.list'
            ]
        ]
    ],
    [
        'title' => 'Filters',
        'icon_class' => 'fa fa-search',
        'items' => [
            [
                'title' => 'Add Filter',
                'route' => 'filters.add'
            ],
            [
                'title' => 'List Filter',
                'route' => 'filters.list'
            ]
        ]
    ],
    [
        'title' => 'Filter options',
        'icon_class' => 'fa fa-search',
        'items' => [
            [
                'title' => 'Add Filter Option',
                'route' => 'filteroptions.add'
            ],
            [
                'title' => 'List Filter Option',
                'route' => 'filteroptions.list'
            ]
        ]
    ],
    [
        'title' => 'Comment categories',
        'icon_class' => 'fa fa-comment',
        'items' => [
            [
                'title' => 'Add Comment category',
                'route' => 'category.add'
            ],
            [
                'title' => 'List Comment category',
                'route' => 'category.list'
            ]
        ]
    ],
    [
        'title' => 'Terms of use',
        'icon_class' => 'fa fa-print',
        'items' => [
            [
                'title' => 'Add Terms of use',
                'route' => 'terms.add'
            ],
            [
                'title' => 'List Terms of use',
                'route' => 'terms.list'
            ]
        ]
    ],
    [
        'title' => 'Notifications',
        'icon_class' => 'fa fa-broadcast-tower',
        'items' => [
            [
                'title' => 'Add notification',
                'route' => 'notifications.add'
            ],
            [
                'title' => 'List notifications',
                'route' => 'notifications.list'
            ],
            [
                'title' => 'Add group',
                'route' => 'notification-groups.add'
            ],
            [
                'title' => 'List groups',
                'route' => 'notification-groups.list'
            ]
        ]
    ],
    [
        'title' => 'User transactions',
        'icon_class' => 'fa fa-users',
        'items' => [
            [
                'title' => 'User upgrade',
                'route' => 'transactions.add'
            ],
            [
                'title' => 'List user transactions',
                'route' => 'transactions.list'
            ]
        ]
    ],
    [
        'title' => 'Upgrade requests',
        'icon_class' => 'fa fa-users',
        'items' => [
            [
                'title' => 'List upgrade requests',
                'route' => 'upgrade.list'
            ]
        ]
    ],
    [
		'title' => 'Users',
		'icon_class' => 'fa fa-users',
		'items' => [
			[
				'title' => 'Add user',
				'route' => 'users.add'
			],
			[
				'title' => 'List users',
				'route' => 'users.list'
			]
		]
	],
	[
		'title' => 'Roles',
		'icon_class' => 'fa fa-ban',
		'items' => [
			[
				'title' => 'Add role',
				'route' => 'roles.add'
			],
			[
				'title' => 'List roles',
				'route' => 'roles.list'
			]
		]
	],
	[
		'title' => 'Administration',
		'icon_class' => 'fa fa-cogs',
		'items' => [
			[
				'title' => 'Settings',
				'route' => 'settings.edit'
			],
			[
				'title' => 'Technical info',
				'route' => 'tech-info'
			]
		]
	]
];