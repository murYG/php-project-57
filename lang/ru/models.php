<?php

return [
    'task_status' => [
        'id' => 'ID',
        'name' => 'Имя',
        'created_at' => 'Дата создания',
        'validation' => [
            'name' => [
                'unique' => 'Статус с таким именем уже существует'
            ]
        ]
    ],
    'task' => [
        'id' => 'ID',
        'name' => 'Имя',
        'description' => 'Описание',
        'createdBy' => 'Автор',
        'assignedTo' => 'Исполнитель',
        'status' => 'Статус',
        'labels' => 'Метки',
        'created_at' => 'Дата создания'
    ],
    'label' => [
        'id' => 'ID',
        'name' => 'Имя',
        'description' => 'Описание',
        'created_at' => 'Дата создания',
        'validation' => [
            'name' => [
                'unique' => 'Метка с таким именем уже существует'
            ]
        ]
    ]
];
