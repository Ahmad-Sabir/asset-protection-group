<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class BaseResponse implements Responsable
{
    /**
     * request status code will be in this variable
     * @var int
     */
    protected int $code;

    /**
     * response message will be in this variable
     * @var mixed
     */
    protected $message;

    /**
     * model data will be in this variable
     * @var mixed
     */
    protected $data;

    /**
     * Default constructor to load data and view
     * @param int $code
     * @param mixed $message
     * @param mixed $data
     */
    public function __construct($code, $message, $data)
    {
        $this->code         = $code;
        $this->message      = $message;
        $this->data         = $data;
    }

    /**
     * Responsible method to return either view or JSON as per request
     * @param  object $request
     */
    public function toResponse($request)
    {
        $jsonData = [
            "statusCode" => $this->code,
            "message"    => $this->message,
            "data"       => $this->data,
        ];

        return response()->json(
            $jsonData,
            $this->code
        );
    }
}
