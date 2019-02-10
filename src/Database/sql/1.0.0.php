<?php

return [
        [
        'table_name' => 'player',
        'action' => 'create',
        'columns' => [
            'id' => [
                'type' => 'integer',
                'options' => [
                    'autoincrement' => true
                ]
            ],
            'first_name' => [
                'type' => 'string'
            ],
            'middle_name' => [
                'type' => 'string',
                'options' => [
                    'notnull' => false
                ]
            ],
            'last_name' => [
                'type' => 'string'
            ],
            'birth_day' => [
                'type' => 'date',
            ]
        ],
        'primary_key' => [
            'id'
        ]
    ]
];
