<?php 
require_once('Connections/teresinabrindes.php');

$nome = $_GET['nome_newsletter'];
$email = $_GET['email_newsletter'];
$acao = $_GET['ac'];

if($acao == 'enviar' ){
$query_letter = "INSERT INTO newsletter (letter_nome, letter_email) VALUES ('$nome', '$email')";
$letter = mysql_query($query_letter) or die (mysql_error());
}
?>