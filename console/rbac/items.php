<?php
return [
    'createPost' => [
        'type' => 2,
        'description' => 'create a Post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'update a Post',
    ],
    'updateOwnPost' => [
        'type' => 2,
        'description' => 'update Own Post',
        'ruleName' => 'isAuthor',
        'children' => [
            'updatePost',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'createPost',
            'updateOwnPost',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'user',
            'updatePost',
        ],
    ],
];
