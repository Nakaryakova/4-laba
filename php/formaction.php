<?php 
header("Content-Type: text/html; charset=utf-8"); 
session_start();
	//Проверка сессии
	if ($_SESSION['test'] == md5($_SERVER['REMOTE_ADDR']))  
	{
	//Сообщение, которое вернется пользователю
	$_SESSION['message']='';
	//Сюда запишем данные из формы
	$Ail = $Name = $Tel = '';
	$NewLine = '--------------';
	if(check_length($_GET["Name"], 2, 16) || check_length($_GET["Ail"], 2, 15) || check_length($_GET["Tel"], 2, 15))
	{
		$_SESSION['message'] = 'Проверьте правильность введенных данных!';
	}
	else
	{
		$Ail = clean($_GET["Ail"]);
		$Name = clean($_GET["Name"]);
		$Tel = clean($_GET["Tel"]);	
		mysqli_query(connect(),"INSERT INTO patients (name, telephone, ail)
		VALUES ('$Name', '$Tel', '$Ail')");
		$_SESSION['message'] = $Name.' Ваша запись успешно занесена в базу, мы вам обязательно перезвоним на ваш номер - '.$Tel;
	}
	}
	else
	{
		$_SESSION['message'] = 'Доступ закрыт.';
	}
	back();
?>

<?php
function connect() {    
    return mysqli_connect('localhost','root','','doctorru');
}
?>

<?php 
function back() 
{
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
}
?>

<?php 
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);    
    return $value;
}
?>

<?php
function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return $result;
}
?>