<?php

declare(strict_types=1);

return [
    'simulated_banner' => (bool) env('HW_SIMULATED_BANNER', true),
    'nik_pepper' => env('HW_NIK_PEPPER', ''),

    'anomaly' => [
        'under_threshold' => 0.5,
        'over_threshold' => 1.5,
        'high_under' => 0.3,
        'high_over' => 2.0,
    ],

    'sla' => [
        'response_hours' => 72,
        'resolve_days' => 14,
        'min_due_reports' => 5,
        'weights' => [
            'response' => 0.5,
            'resolve' => 0.5,
        ],
    ],

    'codes' => [
        'alphabet' => '23456789ABCDEFGHJKMNPQRSTVWXYZ',
        'receipt_regex' => '/^HWR-[A-Z]{3,5}-\d{4}-[A-Z0-9]{6}$/',
        'ticket_regex' => '/^HWT-\d{4}-[A-Z0-9]{6}$/',
    ],

    'attachments' => [
        'max_files' => 3,
        'max_kb' => 5120,
        'mimes' => ['jpg', 'jpeg', 'png', 'pdf'],
    ],
];
