<?php


namespace App\Classes;


class CustomResponse
{
    private $data;
    private $code;

    public function __construct($data = [], $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function getResponse()
    {
        return response()->json(["data" => $this->data, "code" => $this->code], $this->code);
    }
}
