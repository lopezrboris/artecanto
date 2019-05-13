<?php

if(!$_POST) exit;

function tommus_email_validate($email) { return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email); }

$name = $_POST['name']; $email = $_POST['email']; $website = $_POST['website']; $comments = $_POST['comments'];


if(trim($name) == '') {
	exit('<div class="alert alert-danger">¡Atención! Debes ingresar tu nombre.</div>');
} else if(trim($name) == 'Name') {
	exit('<div class="alert alert-danger">¡Atención! Debes ingresar tu nombre.</div>');
} else if(trim($email) == '') {
	exit('<div class="alert alert-danger">¡Atención! Por favor, ingrese una dirección de correo válida.</div>');
} else if(!tommus_email_validate($email)) {
	exit('<div class="alert alert-danger">¡Atención! Usted ingresó una dirección de correo inválida.</div>');
}else if(trim($comments) == 'Message') {
	exit('<div class="alert alert-danger">¡Atención! Por favor, ingrese su mensaje.</div>');
} else if(trim($comments) == '') {
	exit('<div class="alert alert-danger">¡Atención! Por favor, ingrese su mensaje.</div>');
} else if( strpos($comments, 'href') !== false ) {
	exit('<div class="alert alert-danger">¡Atención! Please leave links as plain text.</div>');
} else if( strpos($comments, '[url') !== false ) {
	exit('<div class="alert alert-danger">¡Atención! Please leave links as plain text.</div>');
} if(get_magic_quotes_gpc()) { $comments = stripslashes($comments); }

//ENTER YOUR EMAIL ADDRESS HERE
$address = 'contacto@gerliproducciones.com';

$e_subject = 'Nuevo contacto de ' . $name . '.';
$e_body = "Nuevo contacto de $name desde el sitio Artemcantum, el mensaje dejado es el siguiente." . "\r\n" . "\r\n";
$e_content = "\"$comments\"" . "\r\n" . "\r\n";
$e_reply = "Para responder a $name dirigirse a $email";

$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

$headers = "From: $address" . "\r\n";
$headers .= "Reply-To: $email" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/plain; charset=utf-8" . "\r\n";
$headers .= "Content-Transfer-Encoding: quoted-printable" . "\r\n";

if(mail($address, $e_subject, $msg, $headers)) { echo "<fieldset><div id='success_page'><h4 class='remove-bottom'>Mensaje enviado exitosamente.</h4><p>Gracias <strong>$name</strong>, tu mensaje ha sido recibido por el directorio, en breve nos contactaremos contigo.</p></div></fieldset>"; }
