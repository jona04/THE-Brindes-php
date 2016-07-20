<!DOCTYPE html>
<head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Cadastro Pessoa Jurídica- <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

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
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>



<?php include "analytics.php"; ?>


<script language="javascript">


$(function() {
//$('.mask-data').mask('99/99/9999'); //data
//$('.mask-hora').mask('99:99'); //hora
//$('.mask-fone').mask('(999) 999-9999'); //telefone
$('.mask-cnpj').mask('99.999.999/9999-99'); //cnpj
$('.mask-cpf').mask('999.999.999-99'); //cpf
});

</script>
<?php include "favicon.php"; ?>

<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />

<div class="centraliza_cadastro">

 <div class="form_cadastro">
 	<div class="logo_cadastro"><div class="img_revenda"></div><span>REGISTRE-SE COMO REVENDEDOR</span></div>
	<form name="cadastrar" method="POST" action="enviar_cadastro.php?tp=rev">
  		<table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <input type="hidden" class="tipo" id="tipo" name="tipo" value="revendedor">
          <td class="td_cadastro" width="150"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome*:</font></td>
          <td width="250"><input name="nome" type="text" id="nome" maxlength="75"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CNPJ:</font></td>
          <td><input name="cnpj" class="mask-cnpj" type="text" id="cnpj" maxlength="30"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CPF*:</font></td>
          <td><input name="cpf" class="mask-cpf" type="text" id="cpf" maxlength="30"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Login*:</font></td>
          <td><input name="login" type="text" id="login" maxlength="30"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Senha*:</font></td>
          <td><input name="senha" type="password" id="senha" maxlength="30"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Repetir 
          Senha*:</font></td>
          <td><input name="senha2" type="password" id="senha2" maxlength="30"></td>
        </tr>
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email*:</font></td>
          <td><input name="email" type="text" id="email" maxlength="50"></td>
        </tr>
        <tr> 
          <td> </td>
          <td> </td>
        </tr>
        <tr> 
          <td colspan="2"><div align="center"> 
                  <input class="botao pequeno cinza" name="enviar" type="submit" id="enviar" value="Enviar Cadastro">
                  <input class="botao pequeno cinza" name="limpar" type="reset" id="limpar" value="Limpar Dados">
                </div>
             <span>* Itens Obrigat&oacute;rios</span></td>
        </tr>
  </table>
</form>
</div>

</div>
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>

