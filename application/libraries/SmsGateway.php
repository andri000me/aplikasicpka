<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* 
 * Moded Sms Gateway Api
 * By Nikki Sosa 
 * For CodeIgniter
 * Credits to SmsGateway.me
 */
class SmsGateway
{
    protected $ip;
    function __construct()
    {

    }

    function setIp($ip_addr)
    {
        $this->ip = $ip_addr;
    }

    function sendSMS($to, $message)
    {
        $post = [
            'phone' => $to,
            'message' => $message
        ];
        $url = 'http://'.$this->ip.'/v1/sms/';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $output = curl_exec($ch);

        curl_close($ch);
        return "output : ".$output;
    }
}