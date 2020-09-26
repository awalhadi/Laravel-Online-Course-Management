<?php

function verification_code($length){
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}


function send_php_mail($receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
{
    $headers = "From: $sender_name <$sender_email> \r\n";
    $headers .= "Reply-To: $sender_name <$sender_email> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail($receiver_email, $subject, $message, $headers);
}


function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function description_shortener($string, $length = null)
{
    if (empty($length)) $length = config('constants.stringLimit.default');
    return Illuminate\Support\Str::limit($string, $length);
}
