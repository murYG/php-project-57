<?php

return [
    'task_status' => [
        'destroy_success' => 'Status not found',
        'destroy_error' => 'Failed to delete status',
        'store_success' => 'Status added successfully',
        'update_success' => 'Status successfully changed',
    ],    
    'task' => [
        'destroy_success' => 'Task deleted',
        'destroy_error' => 'The task was not deleted',
        'destroy_auth_error' => 'You can\'t delete someone else\'s task',
        'store_success' => 'The task has been added successfully.',
        'update_success' => 'The task was successfully modified',
    ],
    'label' => [
        'destroy_success' => 'Tag removed',
        'destroy_error' => 'Failed to delete the label',
        'store_success' => 'The tag has been added successfully.',
        'update_success' => 'The label has been successfully changed.',
    ]
];