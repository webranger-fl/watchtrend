<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class YaGPT {

  public function askAsyncWithContext($text, $context, $maxTokens = 1000) {
    //$modelUri = config('ai.models')[$user->settings['gpt-model']]['uri'];
    $modelUri = config('ai.models')['YandexGPT Lite']['uri'];
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->post("https://llm.api.cloud.yandex.net/foundationModels/v1/completionAsync", [
      'modelUri' => "gpt://b1g1gli0dfev7nrvm0bs/$modelUri",
      'completionOptions' => [
        'stream' => false,
        'temperature' => $context['temp'],
        'maxTokens' => $maxTokens
      ],
      'messages' => [
        ["role" => "system", "text" => $context['prompt']],
        ["role" => "user", "text" => $text],
      ]
    ]);
    return json_decode($res->body());
  }

  public function askImageAsync($text) {
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->post("https://llm.api.cloud.yandex.net/foundationModels/v1/imageGenerationAsync", [
      'modelUri' => "art://b1g1gli0dfev7nrvm0bs/yandex-art/latest",
      'generationOptions' => [
        'seed' => 3, // 21
        'aspectRatio' => [
          'widthRatio' => '16',
          'heightRatio' => '9'
        ],
      ],
      'messages' => [
        ["weight" => 1, "text" => $text],
      ]
    ]);
    return json_decode($res->body());
  }

  public function getAsyncResult($operationId) {
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->get("https://operation.api.cloud.yandex.net/operations/$operationId");
    return json_decode($res->body());
  }

  // https://yandex.cloud/ru/docs/foundation-models/text-generation/api-ref/TextGeneration/completion
  /*public function ask($user, $text, $maxTokens = 1000) {
    $modelUri = config('ai.models')[$user->settings['gpt-model']]['uri'];
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->post("https://llm.api.cloud.yandex.net/foundationModels/v1/completion", [
      //'modelUri' => 'gpt://b1g1gli0dfev7nrvm0bs/yandexgpt-lite/latest',
      'modelUri' => "gpt://b1g1gli0dfev7nrvm0bs/$modelUri",
      'completionOptions' => [
        'stream' => false,
        // default 0.3
        //'temperature' => 0.3
        'maxTokens' => $maxTokens
      ],
      'messages' => [
        ["role" => "user", "text" => $text]
      ]
    ]);
    return json_decode($res->body());
  }

  public function askAsync($user, $text, $maxTokens = 1000) {
    $modelUri = config('ai.models')[$user->settings['gpt-model']]['uri'];
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->post("https://llm.api.cloud.yandex.net/foundationModels/v1/completionAsync", [
      //'modelUri' => 'gpt://b1g1gli0dfev7nrvm0bs/yandexgpt-lite/latest',
      'modelUri' => "gpt://b1g1gli0dfev7nrvm0bs/$modelUri",
      'completionOptions' => [
        'stream' => false,
        // default 0.3
        //'temperature' => 0.3
        'maxTokens' => $maxTokens
      ],
      'messages' => [
        ["role" => "user", "text" => $text]
      ]
    ]);
    return json_decode($res->body());
  }

  public function askWithContext($user, $text, $context, $maxTokens = 1000) {
    $modelUri = config('ai.models')[$user->settings['gpt-model']]['uri'];
    $res = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Authorization' => "Api-Key " . env('YANDEX_TRANSLATE_API_KEY')
    ])->post("https://llm.api.cloud.yandex.net/foundationModels/v1/completion", [
      'modelUri' => "gpt://b1g1gli0dfev7nrvm0bs/$modelUri",
      'completionOptions' => [
        'stream' => false,
        'temperature' => $context->temp,
        'maxTokens' => $maxTokens
      ],
      'messages' => [
        ["role" => "system", "text" => $context->prompt],
        ["role" => "user", "text" => $text],
      ]
    ]);
    return json_decode($res->body());
  }*/

  


  
}