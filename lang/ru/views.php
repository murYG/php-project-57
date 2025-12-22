<?php

return [
    'common' => [
        'actions' => [
            'title' => 'Действия',
            'actions' => [
                'delete' => 'Удалить',
                'edit' => 'Изменить',
            ],
        ],
    ],
    'index' => [
        'title' => 'Привет от Хекслета!',
        'content' => 'Это простой менеджер задач на Laravel',
    ],
    'task_status' => [
        'index' => [
            'title' => 'Статусы',
            'confirm_deletion' => 'Вы уверены?',
            'buttons' => [
                'create' => 'Создать статус'
            ]
        ],
        'create' => [
            'title' => 'Создать статус',
            'buttons' => [
                'create' => 'Создать'
            ]
        ],
        'edit' => [
            'title' => 'Изменение статуса',
            'buttons' => [
                'edit' => 'Обновить'
            ]
        ]
    ],
    'task' => [
        'index' => [
            'title' => 'Задачи',
            'confirm_deletion' => 'Вы уверены?',
            'buttons' => [
                'create' => 'Создать задачу',
                'filter' => 'Применить'
            ]
        ],
        'show' => [
            'title' => 'Просмотр задачи'
        ],
        'create' => [
            'title' => 'Создать задачу',
            'buttons' => [
                'create' => 'Создать'
            ]
        ],
        'edit' => [
            'title' => 'Изменение задачи',
            'buttons' => [
                'edit' => 'Обновить'
            ]
        ]
    ],
    'label' => [
        'index' => [
            'title' => 'Метки',
            'confirm_deletion' => 'Вы уверены?',
            'buttons' => [
                'create' => 'Создать метку'
            ]
        ],
        'create' => [
            'title' => 'Создать метку',
            'buttons' => [
                'create' => 'Создать'
            ]
        ],
        'edit' => [
            'title' => 'Изменение метки',
            'buttons' => [
                'edit' => 'Обновить'
            ]
        ]
    ],
];
