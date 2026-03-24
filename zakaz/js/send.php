<?php
ini_set("display_errors",1);
error_reporting(E_ALL);

$err = 0;
if(isset($_POST)) {
	if(isset($_POST['name']) and isset($_POST['phone']) and isset($_POST['email']) and isset($_POST['text'])){
		//print_r($_POST);
		header('Content-Type: text/html; charset=utf-8');
		mb_internal_encoding('UTF-8'); // Установка кодировки
		
        $to = 'lih1989@yandex.ru, lojkin.dom@mail.ru,'.$_POST['email']; //Почта получателя, через запятую можно указать сколько угодно адресов
        $subject = 'Заказ сувениров с гравировкой - '.$_POST['name']; //Заголовок сообщения
		$zakaz = '<table style="border-collapse: collapse;">
			<tr>
				<td style="min-width: 200px;border: 1px solid black;padding: 3px;"><b>Наименование</b></td>
				<td style="min-width: 100px;border: 1px solid black;padding: 3px;"><b>Надпись</b></td>
				<td style="min-width: 50px;border: 1px solid black;padding: 3px;"><b>Макет</b></td>
				<td style="min-width: 50px;border: 1px solid black;padding: 3px;"><b>Количество</b></td>
				<td style="min-width: 100px;border: 1px solid black;padding: 3px;"><b>Стоимость</b></td>
			</tr>';
		$zarr = explode(",", $_POST['text']);
		foreach ($zarr as $tovar){
			$str = explode(";", $tovar);
			$zakaz .= '
			<tr>
				<td style="min-width: 200px;border: 1px solid black;padding: 3px;">'.$str[0].'</td>
				<td style="min-width: 100px;border: 1px solid black;padding: 3px;">'.$str[1].'</td>
				<td style="min-width: 50px;border: 1px solid black;padding: 3px;">'.$str[2].'</td>
				<td style="min-width: 50px;border: 1px solid black;padding: 3px;">'.$str[3].'</td>
				<td style="min-width: 100px;border: 1px solid black;padding: 3px;;">'.$str[4].'</td>
			</tr>';
		}
		$zakaz .= '<tr>
						<td style="min-width: 200px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 100px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 50px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 50px;border: 1px solid black;padding: 3px;">Размер скидки: </td>
						<td style="min-width: 100px;border: 1px solid black;padding: 3px;">'.$_POST['skidka'].'</td>
					</tr>
					<tr>
						<td style="min-width: 200px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 100px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 50px;border: 1px solid black;padding: 3px;"></td>
						<td style="min-width: 50px;border: 1px solid black;padding: 3px;">Итого к оплате: </td>
						<td style="min-width: 100px;border: 1px solid black;padding: 3px;">'.$_POST['itog'].'</td>
					</tr>';
		$zakaz .= '</table>';
		
        $message = '
                <html>
                    <head>
                        <title>'.$subject.'</title>
                    </head>
                    <body>
                        <p>Имя заказчика: '.$_POST['name'].'</p>
                        <p>Телефон заказчика: '.$_POST['phone'].'</p>      
                        <p>Почта заказчика: '.$_POST['email'].'</p>                     
                        <p style="text-aling:center;font-weight:600;">Заказ</p>                     
                        '.$zakaz.'					
                   </body>
                </html>'; //Текст нащего сообщения можно использовать HTML теги
        $headers  = "Content-type: text/html; charset=utf-8 \r\n"; //Кодировка письма
        $headers .= "From: Онлайн заказ <php-zakaz@ложкин-дом.рф>\r\n"; //Наименование и почта отправителя
        mail($to, $subject, $message, $headers); //Отправка письма с помощью функции mail

		echo "0";
	} else {
	$err++;
	}
} else {
	$err++;
}
if($err > 0){
	echo $err;
} 
?>