<?php

return [
    'common' => [
        'actions' => [
            'title' => 'Actions',
            'actions' => [
                'delete' => 'Delete',
                'edit' => 'Edit',
            ],
        ],
    ],
    'index' => [
        'title' => 'Hello from Hexlet!',
        'content' => 'This is a simple task manager on Laravel',
    ],
    'task_status' => [
        'index' => [
            'title' => 'Statuses',            
            'confirm_deletion' => 'Are you sure?',
            'buttons' => [
                'create' => 'Add new status'
            ]
        ],
        'create' => [
            'title' => 'Create status',
            'buttons' => [
                'create' => 'Create'
            ]
        ],
        'edit' => [
            'title' => 'Change of status',
            'buttons' => [
                'edit' => 'Update'
            ]
        ]
    ],
    'task' => [
        'index' => [
            'title' => 'Tasks',            
            'confirm_deletion' => 'Are you sure?',
            'buttons' => [
                'create' => 'Create task',
                'filter' => 'Apply'
            ]
        ],
        'show' => [
            'title' => 'View a task'
        ],        
        'create' => [
            'title' => 'Create task',
            'buttons' => [
                'create' => 'Create'
            ]
        ],
        'edit' => [
            'title' => 'Changing a task',
            'buttons' => [
                'edit' => 'Update'
            ]
        ]
    ],
    'label' => [
        'index' => [
            'title' => 'Labels',            
            'confirm_deletion' => 'Are you sure?',
            'buttons' => [
                'create' => 'Create label'
            ]
        ],
        'create' => [
            'title' => 'Create label',
            'buttons' => [
                'create' => 'Create'
            ]
        ],
        'edit' => [
            'title' => 'Changing the label',
            'buttons' => [
                'edit' => 'Update'
            ]
        ]
    ],
];