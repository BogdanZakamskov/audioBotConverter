<?php

namespace App\Http\Controllers;

use App\Classes\CustomResponse;
use App\Classes\ViberService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;




class ViberController extends Controller
{
    public function index(Request $request)
    {
        $data = json_decode(json_encode($request->all()));
        $event = $data->event;
        switch ($event) {
            case "conversation_started":
                $viberId = $data->user->id ?? null;
                if(!empty($viberId)) {
                    (new ViberService())
                        ->sendTextMessage(
                            $viberId,
                            "Приветствую! Чтобы подписаться на уведомления напишите мне любое сообщение."
                        );
                }
                break;
            case "subscribed":
                $viberId = $data->user->id ?? null;
                if(!empty($viberId)) {
                    (new ViberService())
                        ->sendTextMessage($viberId, "Поздравляю! Вы подписаны!");
                }
                break;
        }
    }
}
