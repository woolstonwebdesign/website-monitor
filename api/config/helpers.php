<?php
namespace config;

class Helpers {

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    function applicationUrl() {
        return 'https://api.woolston.com.au/auth/v1/';
    }
}
?>