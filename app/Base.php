<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    public function bad($msg)
    {
        return ['success' => false, 'msg' => $msg];
    }

    public function ok($msg)
    {
        return ['success' => true, 'msg' => $msg];
    }

    public function httpGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function httpPost($url, $data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}