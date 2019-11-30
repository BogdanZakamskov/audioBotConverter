<?php

namespace App\Http\Controllers;

use App\Classes\CustomResponse;
use App\Classes\ViberService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
            case "message":
                $viberId = $data->sender->id ?? null;
                if(!strcmp($data->message->type, "file") == 0){
                    (new ViberService())
                        ->sendTextMessage($viberId, "Это не голосовое сообщение :(");
                    return (new CustomResponse(['message' => 'ok']))->getResponse();
                }
                $remoteUrl = $data->message->media;
                $fileName = Str::random();

                $pathToFile = storage_path("audio/$fileName");
                $fileM4A = fopen("$pathToFile.m4a",'w');
                $client = new \GuzzleHttp\Client();
                $response = $client->get($remoteUrl, ['save_to' => $fileM4A]);

                if ($response->getStatusCode() != 200) {
                    (new ViberService())
                        ->sendTextMessage($viberId, "Не получилось скачать запись :(");
                    // TODO написать логирование
                    return (new CustomResponse(['message' => 'ok']))->getResponse();
                }

                // ПРЕОБРАЗОВАНИЕ
                exec("ffmpeg -i " . $pathToFile . ".m4a -acodec opus -aq 60 -strict -2 -vn -ac 2 " . $pathToFile . ".ogg");

                $token = config('yandex.IAMToken'); # IAM-токен
                $folderId = config('yandex.folderId'); # Идентификатор каталога
                $audioFileName = $pathToFile . '.ogg';

                $file = fopen($audioFileName, 'rb');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Transfer-Encoding: chunked'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

                curl_setopt($ch, CURLOPT_INFILE, $file);
                curl_setopt($ch, CURLOPT_INFILESIZE, filesize($audioFileName));
                $res = curl_exec($ch);
                curl_close($ch);
                $decodedResponse = json_decode($res, true);
                if (isset($decodedResponse["result"])) {
                    (new ViberService())
                        ->sendTextMessage($viberId, "В вашем сообщении сказано:\n" . $decodedResponse["result"]);
                } else {
                    (new ViberService())
                        ->sendTextMessage($viberId, "Печалька. Не удалось преобразовать сообщение :(");
                    // TODO написать логирование
                    echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
                    echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
                }

                fclose($file);
                break;
        }
    }
}
