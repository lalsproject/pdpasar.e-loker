<?php

$botToken = "6610312647:AAHsvVgFU8_4lUlZ7r9mqK1mubzvjikjgnw"; // Masukkan token bot Anda di sini
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents("php://input");
$update = json_decode($update, true);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

$flags = array(
    '<',
    '>'
);

// Mengirim balasan ke Telegram
$telegram_api_url = $website."/sendmessage";
if ($message == '/start')
{
    $data = array(
        'chat_id' => $chatId,
        'text' => "Selamat Datang,\nID TELEGRAM ANDA = $chatId",
        'parse_mode' => 'markdown',
    );
}


$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',
        'content' => http_build_query($data),
    ),
);

$context  = stream_context_create($options);
$result = file_get_contents($telegram_api_url, false, $context);

?>
