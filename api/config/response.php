<?php
namespace config;

class Response {

    public $Status;
    public $Message;
    public $Data;

    function __construct($status, $message, $data) {
        $this->Status = $status;
        $this->Message = $message;
        $this->Data = $data;
    }
}