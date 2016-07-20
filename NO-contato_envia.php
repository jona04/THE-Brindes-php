<?php
require_once('Connections/teresinabrindes.php');

if(isset($_GET['ac'])){
	$acao = $_GET['ac'];
	$nome = $_GET['nome'];
	$email = $_GET['email'];
	$fone = $_GET['fone'];
	$msg = $_GET['msg'];
}else{
	$acao = '0';
}
//inicio envia mensagem
if($acao==1){
	$emailsender2 = "teres387@teresinabrindes.com.br";
	
	// Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
	if(PHP_OS == "Linux") $quebra_linha2 = "\n"; //Se for Linux
	elseif(PHP_OS == "WINNT") $quebra_linha2 = "\r\n"; // Se for Windows
	else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
	
		/* Montando o cabeçalho da mensagem */
	$headers2 = "MIME-Version: 1.1".$quebra_linha2;
	$headers2 .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha2;
	// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
	$headers2 .= "From: ".$emailsender2.$quebra_linha2;
	$headers2 .= "Return-Path: " . $emailsender2 . $quebra_linha2;
  
  	$Destinatario2="contato@teresinabrindes.com.br";
	$Titulo2="Contato pelo site! Teresina Brindes";
	
	$mensagem2 =   "Nome: $nome <br />
					Email: $email <br />
					Fone: $fone <br />
					Mensagem: $msg";
	

	/* Enviando a mensagem */
	mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2);
	if(mail){
	echo '<script>alert("Mensagem enviada com sucesso.")</script>';		
	}
}//fim if envia mensagem
?>