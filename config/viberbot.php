<?php

return [

    'api-key' => env('VIBERBOT_API'),

    'name' => env('VIBERBOT_NAME'),

    'photo' => env('VIBERBOT_PHOTO'),

    'event_types' => [
        'delivered',
        'seen',
        'failed',
        'subscribed',
        'unsubscribed',
        'conversation_started',
    ],

];
