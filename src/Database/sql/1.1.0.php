<?php

return [
    [
        'table_name' => 'highlight',
        'action' => 'create',
        'columns' => [
            'id' => [
                'type' => 'integer',
                'options' => [
                    'autoincrement' => true
                ]
            ],
            'title' => [
                'type' => 'string'
            ],
            'description' => [
                'type' => 'text',
                'options' => [
                    'notnull' => false
                ]
            ],
            'player_id' => [
                'type' => 'integer'
            ]
        ],
        'primary_key' => [
            'id'
        ]
    ],
    [
        'table_name' => 'player_highlight',
        'action' => 'create',
        'columns' => [
            'player_id' => [
                'type' => 'integer'
            ],
            'highlight_id' => [
                'type' => 'integer'
            ]
        ],
        'foreign_keys' => [
            [
                'foreign_table' => 'player',
                'table_columns' => [
                    'player_id'
                ],
                'foreign_columns' => [
                    'id'
                ],
                'options' => [
                    'onUpdate' => 'CASCADE'
                ]
            ],
            [
                'foreign_table' => 'highlight',
                'table_columns' => [
                    'highlight_id'
                ],
                'foreign_columns' => [
                    'id'
                ],
                'options' => [
                    'onUpdate' => 'CASCADE'
                ]
            ]
        ]
    ]
];
