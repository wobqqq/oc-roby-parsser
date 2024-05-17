<?php

return [
    'parser_queue_processes' => env('PARSER_QUEUE_PROCESSES', 15),
    'parser_timeout' => env('PARSER_TIMEOUT', 30),
    'parser_min_page_content_size' => env('PARSER_MIN_PAGE_CONTENT_SIZE', 100),
    'request_retries' => env('PARSER_REQUEST_RETRIES', 3),
    'chat_gpt_url' => env('CHAT_GPT_URL', 'http://37.251.255.17:8001'),
];
