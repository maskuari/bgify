<?php

return [
    'python_binary' => env('BGIFY_PYTHON_BINARY', env('PYTHON_BINARY', 'python')),
    'script_path' => env('BGIFY_SCRIPT_PATH', base_path('scripts/remove_background.py')),
    'timeout' => (int) env('BGIFY_PROCESS_TIMEOUT', 180),
    'max_upload_kb' => 10240,
    'allowed_mimes' => ['jpg', 'jpeg', 'png', 'webp'],
];
