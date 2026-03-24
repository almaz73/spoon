<?php
if(empty($_POST['mail_msg'])) {
	header( 'Location: /#badsend', true, 307 );
	exit();
}	

if($_POST['antibot'] != "40") {
	header( 'Location: /#badsend', true, 307 );
	exit();
}	

// Если поле выбора вложения не пустое - закачиваем его на сервер 
	if (!empty($_FILES['mail_file']['tmp_name'])) { 
		// Проверка, имеет ли файл правильный MIME-тип 
		if ($_FILES ['mail_file']['type'] == 'image/png' || $_FILES ['mail_file']['type'] == 'image/jpeg') 
		{ 
			// Закачиваем файл  
			$path = basename($_FILES['mail_file']['name']); 
			if (copy($_FILES['mail_file']['tmp_name'], $path)) $picture = $path; 
		} else {
			header( 'Location: /#badsend', true, 307 );
			exit();
		}
	} 

	$thm = 'Новый отзыв на сайте';
	$name = $_POST['mail_name'];
	$phone = $_POST['mail_phone'];
	$city = $_POST['mail_city'];
	$mnenie = $_POST['mail_msg'];

	//tegegramm($name, $phone, $city, $mnenie);
	
	$msg = 'Name: <b>'.$name.'</b> <br>';
	$msg .= 'Phone: <b>'.$phone.'</b> <br>';
	$msg .= 'City: <b>'.$city.'</b> <br>';
	$msg .= 'Mnenie: <b>'.$mnenie.'</b> <br>';

	$mail_to = 'lojkin.dom@mail.ru, lih1989@yandex.ru';

	// Отправляем почтовое сообщение   
	if(empty($picture)){
		$headers = "From: Сайт Ложкин Дом <mail@xn----htbeijemffg.xn--p1ai>\n";
		$headers .= "Content-Type: text/html; charset=utf8\n";
		if(!mail($mail_to, $thm, $msg, $headers)){
			header( 'Location: /#badsend', true, 307 );
		} else {
			header( 'Location: /#goodsend', true, 307 );
		}
	} else {
		send_mail($mail_to, $thm, $msg, $picture); 
		// при успехе удаляем
		unlink($picture);
		unset($_FILES);
		unset($_POST);
	} 
 
	// Вспомогательная функция для отправки почтового сообщения с вложением 
function send_mail($to, $thm, $html, $path){ 
	$fp = fopen($path,"r");
	if (!$fp)
	{ 
	  print "Файл не может быть прочитан"; 
	  header( 'Location: /#badsend', true, 307 );
	  exit(); 
	} 

	$file = fread($fp, filesize($path)); 
	fclose($fp); 



	$boundary = "--".md5(uniqid(time())); // генерируем разделитель 
	$headers = "From: Сайт Ложкин Дом <mail@xn----htbeijemffg.xn--p1ai>\n";
	$headers .= "MIME-Version: 1.0\n"; 

	$headers .="Content-Type: multipart/mixed; boundary=".$boundary."\n"; 

	$multipart .= "--".$boundary."\n"; 

	$kod = 'utf-8'; // или $kod = 'koi8-r'; 

	$multipart .= "Content-Type: text/html; charset=".$kod."\n"; 

	$multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n"; 

	$multipart .= $html."\n\n"; 



	$message_part = "--".$boundary."\n"; 

	$message_part .= "Content-Type: application/octet-stream\n"; 

	$message_part .= "Content-Transfer-Encoding: base64\n"; 

	$message_part .= "Content-Disposition: attachment; filename = \"".$path."\"\n\n"; 

	$message_part .= chunk_split(base64_encode($file))."\n"; 

	$multipart .= $message_part."--".$boundary."--\n"; 



	if(!mail($to, $thm, $multipart, $headers)) 
	{ 
	  echo "К сожалению, письмо не отправлено"; 
	  header( 'Location: /#badsend', true, 307 );
	  exit(); 
	} else {
	  echo "Успешно отправлено"; 
	  header( 'Location: /#goodsend', true, 307 );
	}
	}    

// Отправка в телеграмм
function tegegramm($name, $phone, $city, $mnenie){
	$token = '352538299:AAGqOodOgBZmLjN4HUIJrnxr6avK50KE1N4';
	$chatID = -166511690; 

	$messaggio  = '<b>Отзыв с сайта!</b>'. '%0A';
	$messaggio .= 'Имя отправителя: <b>'.$name.'</b>'. '%0A';
	$messaggio .= 'Контактный телефон: <b>'.$phone.'</b>'. '%0A';
	$messaggio .= 'Город: <b>'.$city.'</b>'. '%0A';
	$messaggio .= 'Отзыв: <b>'.$mnenie.'</b>'. '%0A';
	$messaggio .= '%0A'.'**********************************';

		$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID . "&parse_mode=HTML&text=";
		$url = $url . $messaggio;
		$ch = curl_init();
		$optArray = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $optArray);
		$result = curl_exec($ch);
		curl_close($ch);
}
?>