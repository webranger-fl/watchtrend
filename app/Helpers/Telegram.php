<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram {

  public function sendMessage($chatId, $msg) {

    return Http::tgBot()->post("/sendMessage", [
      'chat_id' => $chatId,
      'text' => $msg,
      'parse_mode' => 'html',
      'link_preview_options' => [
        'is_disabled' => true
      ]
    ]);

  }
  
  public function deleteMsg($chatId, $msgId) {

    return Http::tgBot()->post("/deleteMessage", [
      'chat_id' => $chatId,
      'message_id' => $msgId,
    ]);

  }

  public function sendDocument($chat_id, $file, $reply_id = null){
    return Http::tgBot()->attach('document', Storage::get('/public/'.$file), 'document.png')
          ->post('/sendDocument', [
          'chat_id' => $chat_id,
          'reply_to_message_id' => $reply_id
      ]);
  }

  public function sendButtons($chat_id, $message, $button){
    return  Http::tgBot()->post('/sendMessage', [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'html',
        'reply_markup' => $button,
        // https://core.telegram.org/bots/api#linkpreviewoptions
        'link_preview_options' => [
          'is_disabled' => true
        ]
    ]);
  }


  


}