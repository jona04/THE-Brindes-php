<?php 
ob_start();
require_once('../Connections/teresinabrindes.php');
if(isset($_SESSION['adm'])){
	header("Location: logado.php");	
}

if(isset($_GET['acao']) && $_GET['acao'] == 'login'){
	
	$email = ($_POST['login']);
	$senha = ($_POST['senha']);
	
	$sql = "SELECT usu_email, usu_senha, usu_nivel FROM usuarios WHERE usu_email='$email' AND usu_senha='$senha'";
	$qr = mysql_query($sql) or die (mysql_error());
	$numReg = mysql_num_rows($qr);
	
	$registro = mysql_fetch_assoc($qr);
	if($registro['usu_nivel'] == '1'){	
		$_SESSION['adm'] = 'adm';	
		header("Location: logado.php"); 
		exit();
	}
	if($numReg == 0){
		header("Location: erro.php");
		exit();
	}
}
?>


<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>INDEX</title>

</head>

<body bgcolor="#CCCCCC">
<div class="conteudo_index_admin">

 	<form name="form_admin" action="?acao=login" method="POST">
    	<table width="200" border="0" align="center">
  <tr>
    <td>Login</td>
    <td><input type="text" name="login" /></td>
  </tr>
  <tr>
    <td>Senha</td>
    <td><input type="password" name="senha" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="enviar" value="Entrar" /></td>
  </tr>
</table>
  </form>

</div>

</body>
</html>