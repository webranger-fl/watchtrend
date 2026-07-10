<?php

return [
  'yandex' => [
    'client_id_wordstat' => env('YANDEX_CLIENT_ID_WORDSTAT', ''),
    'client_secret_wordstat' => env('YANDEX_CLIENT_SECRET_WORDSTAT', ''),
    'wordstat_api_token' => env('YANDEX_WORDSTAT_API_TOKEN', ''),
    'wordstat_refresh_token' => env('YANDEX_WORDSTAT_REFRESH_TOKEN', ''),
    'ai_studio_api_key' => env('YANDEX_AI_STUDIO_API_KEY', ''),
  ]
  #'filter_regex_for_domain' => env('FILTER_REGEX_FOR_DOMAIN', ''),
];
