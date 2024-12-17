<?php

function dd($data){
	var_dump($data); 
	die;
}

// function render($view, $data = []){
// 	$CI = &get_instance();
// 	$data['content'] = $view;
// 	$CI->load->view('layouts/base_admin', $data);
// }

function render($view, $data = []){
	$CI = &get_instance();
	$data['content'] = $view;
	if ($CI->session->userdata('role') == 'Admin')
	{
		$CI->load->view('layouts/base_admin', $data);
	}
	else if($CI->session->userdata('role') == 'User')
	{
		$CI->load->view('layouts/base_user', $data);
	}
	else if($CI->session->userdata('role') == 'Divisi')
	{
		$CI->load->view('layouts/base_divisi', $data);
	}
}


function asset($files='')
{
	return base_url().'mods/'.$files;
}

function mark_down($title = false,$link = false)
{
	if ($title != false or $link != false)
	{

		$my_html = "[".$title."](".$link.")";
		// $my_html = MarkdownExtra::defaultTransform('['.$title.']('.$link.')');
		return $my_html;
	}
}

function sendMessage($message=false,$chat_id = false)
{
	if ($message != false and $chat_id != false)
	{
		$CI =& get_instance();

		$bot_token = $CI->config->item('telegram_bot_token');
		$chat_id = $chat_id; // ID chat atau nomor telepon tujuan pesan Anda

		$telegram_api_url = "https://api.telegram.org/bot$bot_token/sendMessage";

		$data = array(
			'chat_id' => $chat_id,
			'text' => $message,
			'parse_mode' => 'markdown',
		);

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'GET',
				'content' => http_build_query($data),
			),
		);

		$context  = stream_context_create($options);
		$result = @file_get_contents($telegram_api_url, false, $context);
		if ($result == '')
		{
			return false;
		}
		else
		{
			return true;
		}
		// return json_decode($result,true)['ok'];
	}
	else
	{
		return false;
		// http_response_code(404);
	}
}


function foto_upload64($files=false,$ref='')
{
	$CI =& get_instance();
	if ($files != false )
	{
		$gambar = "";
		$kdfile = $ref;
		$tanggal = date('dmY');
		$username = $CI->session->userdata('id_user');
		if (!file_exists('mods/vendors/user')) {
			mkdir('mods/vendors/user', 0777, true);
		}

		$config = array(
			'upload_path' => './mods/vendors/user/', 
			'file_name' => 'Foto'.'-'.strtoupper($kdfile).'-'.$tanggal.'-'.date('his').'-'.$username.'-'.rand(1,10000000).'.jpg',
		);

		$output_file = $config['upload_path'].''.$config['file_name'];
		$data = explode( ',', $files );
		// var_dump($data);
		if ($data[0] != '')
		{
			$ifp = fopen( $output_file, 'wb' ); 
			// we could add validation here with ensuring count( $data ) > 1
			fwrite($ifp, base64_decode($data[ 1 ]));
			// clean up the file resource
			fclose( $ifp ); 

			return $config['file_name']; 
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function generateUsername($length = 8) {
    // Daftar karakter yang dapat digunakan dalam username
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $username = '';

    // Menggunakan loop untuk membangun username
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $username .= $characters[$randomIndex];
    }

    return $username;
}

function gen_otp($length = 4) {
    // Daftar karakter yang dapat digunakan dalam otp
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $otp = '';
    // Menggunakan loop untuk membangun otp
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $otp .= $characters[$randomIndex];
    }

    return $otp;
}

function format_nomor($number = false)
{
	if ($number != false)
	{
		return str_replace(',', '.', number_format($number));
	}
	else
	{
		return 0;
	}
}