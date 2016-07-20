<?php
ob_start();
?>
<!DOCTYPE html>
<head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Cadastro de Usuário - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

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


$(document).ready(function(){
	
	$(function() {
	//$('.mask-data').mask('99/99/9999'); //data
	//$('.mask-hora').mask('99:99'); //hora
	$('.ddd').mask('99'); //telefone
	$('.ddd2').mask('99'); //telefone
	$('.mask-fone').mask('9999-9999'); //telefone
	$('.mask-cpf').mask('999.999.999-99'); //cpf
	$('.mask-cep').mask('99999-999'); //cep
	$('.mask-nascimento').mask('99/99/9999'); //nascimento
	
	});
	
	
	function getEndereco() {
		if($.trim($("#cep").val()) != ""){
			$("#endereco").val("Aguarde Procurando endereço...");
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
			if(resultadoCEP["resultado"]){
				$("#endereco_cadastro").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
				$("#bairro").val(unescape(resultadoCEP["bairro"]));
				$("#cidade").val(unescape(resultadoCEP["cidade"]));
				$("#estado").val(unescape(resultadoCEP["uf"]));
			}else{
				alert("Endereço não encontrado");
				}
			});
		}else{ $("#endereco").val("Você precisa informar um CEP...");
			}
	}	
	
	$('#cep').blur(function(){
		getEndereco();	
	});

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
<?php if(isset($_GET['er']) && $_GET['er'] == 1) { ?>
<div id="msg_login" style="background-color:#FF8080; width:1024px; margin: 0 auto 0 auto; ">Seus valores de senha informados nao conferem. Por favor tente novamente.</div>
<?php } ?>
<?php if(isset($_GET['er']) && $_GET['er'] == 2) { ?>
<div id="msg_login" style="background-color:#FF8080; width:1024px; margin: 0 auto 0 auto; ">O email informado já existe. Por favor tente novamente.</div>
<?php } ?>
<?php if(isset($_GET['er']) && $_GET['er'] == 3) { ?>
<div id="msg_login" style="background-color:#FF8080; width:1024px; margin: 0 auto 0 auto; ">O cpf informado já existe. Por favor tente novamente.</div>
<?php } ?>
<div class="centraliza_cadastro">
<div class="logo_cadastro"><div class="img_usuario"></div><span>REGISTRE-SE</span></div>
 <div class="form_cadastro-cad-usu">
	<form name="cadastrar" method="GET" action="funcoes.php" id="form_cadastro_usu">
  		<!--TITULO-->
<div id="dados_pessoais">
        <h3 align='center' style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">Seus dados pessoais</h3>
        <br>
		  		<!--TABELA-->
        <table width="600" border="0" cellspacing="0" cellpadding="0">
       
       <tr>
        <input type="hidden" class="tipo" id="tipo" name="tipo" value="cliente">
       <td class="td_cadastro"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome Completo*:</font></td>
       <td><!--o name é usado .validate--><input name="nome_comp" type="text" id="nome_comp" maxlength="75"></td>
        </tr>
        
        <tr>
          <td class="td_cadastro"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CPF*:</font></td>
          <td>
          <input name="cpf" class="mask-cpf" type="text" id="cpf" maxlength="14"></td>
        </tr>
        
        <tr>
          <td class="td_cadastro"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Data de Nascimento*:</font></td>
          <td>
          <input name="nascimento" class="mask-nascimento" type="text" id="nascimento" maxlength="75"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
          <a style="color:#F00;">dd/mm/aaaa</a></font></td>
        </tr>
        
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sexo*:</font></td>
          <td>
            <label><input name="sexo" type="radio" id="cad_masculino" value="masculino">Masculino</label><br />
            <label><input name="sexo" type="radio" id="cad_feminino" value="feminino">Feminino</label>
          </td>
        </tr>
        
        <script language="javascript">
			function trocaCampo(primeiroCampo){
			if (primeiroCampo.value.length == 2){
			document.getElementById("fone").focus();}}
			function trocaCampo3(primeiroCampo){
			if (primeiroCampo.value.length == 2){
			document.getElementById("cel").focus();}}
</script>
        <tr><!--PRINCIPAL-->
          <td class="td_cadastro" width="15">
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Telefone*:</font></td>
          <td width="10">
          <input name="ddd" class='dddd' onkeyup="JavaScript: trocaCampo(this);"  type="text" id="ddd" maxlength="2">
          <input name="fone" class="mask-fone" type="text" id="fone" maxlength="9"></td>
        </tr>
        <!--#########################     2-->
        <!--#########################    3-->
         <tr>
          <td class="td_cadastro" width="15"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Celular*:</font></td>
          <td width="10">
          <input name="ddd2" onkeyup="JavaScript: trocaCampo3(this);" type="text" class='ddd22' id="ddd2" maxlength="2">
          <input name="cel" class="mask-fone" type="text" id="cel" maxlength="9"></td>
        </tr>
        
       </table>
       
</div> <!-- fim div dados pessoais -->
       <br>
        <br>
       





<div id="seu_endereco">
       <h3 align='center' style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#666;">Seu endereço</h3>
       <br>
<table width="600" border="0" cellspacing="0" cellpadding="0">
       <tr>
          <td class="td_cadastro" width="180"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CEP*:</font></td>
          <td><input class="mask-cep" name="cep" type="text" id="cep" maxlength="75">
          <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
          <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" style="color:#F00;">> Não sei o CEP</a></font>
          </td>
          
        </tr>     

        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Numero*:</font></td>
          <td><input name="endereco_numero" type="text" id="endereco_numero" maxlength="30" size='7'>
          </td>
        </tr>
        
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Endereço*:</font></td>
          <td><input name="endereco_cadastro" type="text" id="endereco_cadastro" maxlength="80">
          </td>
        </tr>   

        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Complemento:</font></td>
          <td><input name="complemento" type="text" id="complemento" maxlength="60"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Ex: Ap 02</font>
          </td>
        </tr>       

        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Bairro*:</font></td>
          <td><input name="bairro" type="text" id="bairro" maxlength="60"></td>
        </tr>
        
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Cidade*:</font></td>
          <td><input name="cidade" type="text" id="cidade" maxlength="60"></td>
        </tr>       
        
        <tr> 
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Estado*:</font></td>
          <td><input name="estado" type="text" id="estado" maxlength="30"></td>
        </tr>
        
       <tr>
          <td> <br /></td>
          <td> </td>
        </tr>
  </table>

</div> <!-- fim div seu endereco -->


<br>
 <br>



<div id="dados_acesso">
       <h3 align='center' style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#666;">Seus dados de acesso ao TeresinaBrindes.com.br</h3>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr> 
       	  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email*:</font></td>
          <td><input name="email" type="text" id="email_cadastro" maxlength="70"></td>
        </tr>  
        <tr> 
       	  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Repetir Email*:</font></td>
          <td><input name="email" type="text" id="email_cadastro2" maxlength="70"></td>
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
       
        

 </table>
</div> <!-- fim div dados_acesso -->

       <tr>
          <td> <br /></td>
          <td> </td>
        </tr>
        <tr> 
          <td colspan="2"><div align="center"> 
                  <input class="novo-botao-verde2" name="enviar" type="submit" id="enviar" value="Enviar Cadastro">
                  <input class="novo-botao-vermelho2" name="limpar" type="reset" id="limpar" value="Limpar Dados">
                </div><br />
                <span>* Itens Obrigat&oacute;rios</span></td>
        </tr>


</form>
</div>
</div>
<div id='mask_cadastro' style="position:absolute; left:0;top:0;z-index:9000;background-color:#000; width:100%; height:100%; opacity:0.65; -moz-opacity: 0.65; filter: alpha(opacity=65); overflow-y:hidden; display:none; ">
	<div id='carregando_cadastro' style="background-image:url(imagens/aguarde.gif); position:absolute; left:50%; top:50%; width:66px; height:66px;"></div>
</div>
<div class="rodape">
  <?php 
  
  include "news_rodape.php"; 
  
  ?>
</div>	
</body>
</html>