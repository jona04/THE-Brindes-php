<?php
require_once('Connections/teresinabrindes.php');
include "anti-injection.php";

if(isset($_GET['acao']) && anti_sql($_GET['acao'] == 'recuperar'))
{

	$email_perdido = $_POST['recupera'];
	
	$sql = "SELECT * FROM usuarios WHERE usu_email = '".mysql_real_escape_string($email_perdido)."'";
	$qr = mysql_query($sql) or die (mysql_error());
	$resultado = mysql_fetch_assoc($qr); 
	$linha = mysql_num_rows($qr);
	
	if(empty($linha)){
		echo '<script>alert("O e-mail solicitado não existe, por favor tente novamente.");document.location.href="rec_sen.php";</script>';
	}else{
	
	$nome = $resultado['nome'];	
	$senha_rand = rand(100000, 999999);
	$senha_temp = $senha_rand;
	$senha_temp_cript = md5($senha_temp);
	
	$sql_altera = "UPDATE usuarios SET usu_senha = '$senha_temp_cript' WHERE usu_email = '$email_perdido'";
	$qr_altera = mysql_query($sql_altera) or die(mysql_error());

//Enviando email para o novo cliente cadastrado
$emailsender2='contato@teresinabrindes.com.br';

/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
if(PHP_OS == "Linux") $quebra_linha2 = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha2 = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");

	/* Montando o cabeçalho da mensagem */
$headers2 = "MIME-Version: 1.1".$quebra_linha2;
$headers2 .= "Content-type: text/html; charset=iso-utf8".$quebra_linha2;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers2 .= "From: ".$emailsender2.$quebra_linha2;
$headers2 .= "Return-Path: " . $emailsender2 . $quebra_linha2;
  
  	$Destinatario2=$email_perdido;
	$senha = $_POST['senha'];
	$Titulo2="Recuperação de senha";
	
	$mensagem2 = "


The Brindes<br>
	<br>
<br>
Olá $nome
<br><br>
Houve uma solicitação para recuperação de senha para este email através do site.<br>
Por motivos de segurança sua senha antiga foi criptografada, portanto lhe será enviada uma nova senha.<br>
Sua nova senha é: $senha_temp<br>
Para Alterar sua senha nova, entre na area de clientes do site da Teresina Brindes.
	 <br><br>
Atenciosamente: Equipe Teresina Brindes.

	";

	/* Enviando a mensagem */
	mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2);
	
		if(mail){
	echo '<script>alert("Recuperação de senha realizada com sucesso.\nSua nova senha foi enviada por e-mail.");document.location.href="index.php";</script>';
		
	}
}

}//fim else do if(empty($sql))
?>
<!DOCTYPE html>
<head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<script type="text/javascript" src="js/tudo.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript" src="js/jquery.marquee.js"></script>
<script type="text/javascript" src="js/jquery.masked.js"></script>
<script type="text/javascript" src="js/jquery.infieldlabel.js"></script>
<script type="text/javascript" src="js/jquery.infieldlabel.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>

<?php include "analytics.php"; ?>


<?php include "favicon.php"; ?>
<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title><?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->
<div class="centraliza_cadastro">
<br class="cancela" />


		
        <form action="?acao=recuperar" method="POST" class="recuperar_senha" id="recuperar_senha">
        <div class="box">
          <p align="center">Sua senha ser&aacute; enviada para seu email de cadastro.  </p>
          <p>&nbsp;</p>
          <p align="center">Seu e-mail:         
          
           
            <input type="text" id="recupera" name="recupera" size="40" class="input_novo"/>
            <br /><br /><br />
          
          <p  align="center">&nbsp;

          <input type="submit" value="Recuperar senha" class="novo-botao-verde2" align="middle"/>
        </p>
        </div>
        </form>
        </center>
   		

<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</div>
</body>
</html>