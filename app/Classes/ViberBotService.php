<?php


namespace App\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;


class ViberService
{
    private $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'https://chatapi.viber.com/pa/',
            'headers' => [
                'X-Viber-Auth-Token' => config('viberbot.api-key'),
                'Content-Type' => 'application/json'
            ]]);
    }

    public function sendUrlMessage($receiver, $url)
    {
        $this->call(
            'post',
            'send_message',
            [
                "receiver" => $receiver,
                "type" => "url",
                "media" => $url,
                "sender" => [
                    "name" => config('viberbot.name')
                ]
            ]);
    }

    public function sendTextMessage($receiver, $text)
    {
        $this->call(
            'post',
            'send_message',
            [
                "receiver" => $receiver,
                "type" => "text",
                "text" => $text,
                "sender" => [
                    "name" => config('viberbot.name')
                ]
        ]);
    }

    public function call($method, $url, $body = [])
    {
        $response = null;
        if ($method === 'post') {
            try {
                $response = $this->guzzleClient->post($url, ['json' => $body]);
            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
            return $response->getBody();
        }
        return $response;
    }
}
