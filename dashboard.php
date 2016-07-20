<?php 
ob_start();
require_once('Connections/teresinabrindes.php');
include "anti-injection.php";

//recebe a ação para sair da dash
if(isset($_GET['ac'])){
	$ac = $_GET['ac'];
}
//rcebe o conteudo para exibir na pagina
if(isset($_GET['c'])){
	$conteudo = $_GET['c'];
}
//si o usuario nao estiver logado volta para o index
if(!isset($_SESSION['email_the'])){
	header( "Location: index.php");
}else{
	$query_rsClientes = mysql_query("SELECT * FROM usuarios WHERE usu_email = '".$_SESSION['email_the']."'");
	$row_rsClientes = mysql_fetch_assoc($query_rsClientes);
	$id_atual = $row_rsClientes['usu_id'];
}

if(isset($ac) && $ac == 'sair'){
	unset($_SESSION['email_the']);
	unset($_SESSION['nome_usuario']);
	unset($_SESSION['id_usu']);
	session_destroy();
	header( "Location: index.php");	
}
if(isset($ac) && anti_sql($ac == 'at')){
	$nomecompleto = $_POST['nomecompleto'];
	$nasc = $_POST['nasc'];
	$ddd= $_POST['ddd'];
	$ddd2= $_POST['ddd2'];
	$fone= $_POST['fone'];
	$cel= $_POST['cel'];
	$email = $_POST['email'];
	$sexo = $_POST['sexo'];	
	
	//verifica se email ja existe
	$qr_email = mysql_query("SELECT usu_email FROM usuarios WHERE usu_email = '$email'") or die(mysql_error());
	$linhas_email = mysql_num_rows($qr_email);
	if($linhas_email > 0){
		$email_existe == true;
	}else{
		$email_existe == false;
	}
	
	//verifica se existe @ no email
	$arroba = '@';
	$email_validado = stripos($email,$arroba);
	
	if($email_existe == true){
		echo "<script>alert('O email fornecido já existe. Por favor digite outro.')</script>";
	}elseif($nomecompleto == '' || $nasc == '' || $ddd == '' || $ddd2 == '' || $fone == '' || $cel == '' || $email == '' || $sexo == ''){
		echo "<script>alert('Por favor preencha todos os campos.')</script>";
	}elseif($email_validado === false){
		echo "<script>alert('Por favor insira um email válido.')</script>";
	}else{
		$updateSQL = mysql_query("UPDATE usuarios SET usu_nome_comp='$nomecompleto', usu_nasc='$nasc', ddd='$ddd',ddd2='$ddd2',usu_fone_prin='$fone',usu_celular='$cel',usu_email='$email', usu_sexo='$sexo' WHERE usu_email='".$_SESSION['email_the']."' ") or die(mysql_error());
		
		//atualiza sessão com o novo nome caso seja alterado
		$_SESSION['nome_usuario'] = $nomecompleto;
		//atualiza sessão com o novo email caso seja alterado
		$_SESSION['email_the'] = $email;
		if($updateSQL){
			echo "<script> alert('Usuario atualizado com sucesso!')</script>";
			//echo "<meta HTTP-EQUIV='refresh' CONTENT='0.1;URL=dashboard.php?c=m_dados'>";
			header("Location: dashboard.php?c=m_dados");
		}
	}//fim else
}
if(isset($_GET['ac']) && anti_sql($_GET['ac'] == 'alt')){
	
	$senha_atual = md5($_POST['senha_atual']);
	$senha_nova = md5($_POST['senha_nova']);
	$confirma_senha = md5($_POST['confirma_senha']);	
	$email_cliente = $_SESSION['email_the'];

$sql = "SELECT * FROM usuarios WHERE usu_email = '".mysql_real_escape_string($email_cliente)."'";
$qr = mysql_query($sql) or die (mysql_error());
$resultado = mysql_fetch_assoc($qr) or die (mysql_error());
$senha_usuario_logado = $resultado['usu_senha'];

	if($senha_usuario_logado == $senha_atual && $senha_nova == $confirma_senha){
			$sql_altera = "UPDATE usuarios SET usu_senha='$senha_nova' WHERE usu_email='".mysql_real_escape_string($email_cliente)."'";
			$qr_altera = mysql_query($sql_altera) or die (mysql_error());
			if ($qr_altera){
			echo '<script>alert("Senha alterada com sucesso.");document.location.href="dashboard.php?c=a_sen";</script>';		
			}
	}
	else{
		echo '<script>alert("Sua senha não pôde ser alterada, por favor verifique os valores digitados.");document.location.href="dashboard.php?c=a_sen";</script>';
		
		}	
}


//endereço
$meu_endereço = mysql_query("SELECT * FROM endereco WHERE end_usu_id = '".$id_atual."'") or die(mysql_error());
$meu_end = mysql_fetch_assoc($meu_endereço);

if(isset($ac) && anti_sql($ac == 'end')){
	$cep = $_POST['cep'];
	$endereco= $_POST['endereco_cadastro'];
	$numero= $_POST['endereco_numero'];
	$complemento= $_POST['complemento'];
	$bairro= $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];	
	
	if($cep == '' || $numero == '' || $endereco == '' || $bairro == '' || $cidade == '' || $estado == '' ){
	echo "<script>alert(Por favor preencha os campos obrigatórios.)</script>";
	header('Location: dashboard.php?c=m_end');
	}else{
		$updateEnd = mysql_query("UPDATE endereco SET end_cep='$cep', end_endereco='$endereco',end_numero='$numero',end_complemento='$complemento',end_bairro='$bairro',end_cidade='$cidade', end_estado='$estado' WHERE end_usu_id='".$id_atual."' ") or die(mysql_error());
	
		$updateSQL = mysql_query("UPDATE usuarios SET usu_cep='$cep' WHERE usu_id='".$id_atual."' ") or die(mysql_error());
		
		if($updateEnd){
			echo "<script>alert('Endereço atualizado com sucesso!')</script>";
			header('Location: dashboard.php?c=m_end');
			
		}
	}// fim else 
}

//pedidos
$qr_pedidos = mysql_query("SELECT * FROM pedidos WHERE ped_email = '".$_SESSION['email_the']."'");
//$meus_pedidos = mysql_fetch_assoc($qr_pedidos);

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Área do Usuário - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

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
<script language="javascript"  src="js/jquery.pstrength-min.1.2.js"></script>


<?php include "analytics.php"; ?>


<script language="javascript">


$(document).ready(function(){
	
	$(function() {
	//$('.mask-data').mask('99/99/9999'); //data
	//$('.mask-hora').mask('99:99'); //hora
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


<div class="centraliza_cadastro">

<br class="cancela" />

<div id="menu_top_dash"></div>
	<ul id="menu_dash">
    	<li class="menu_right2"><a href="?c=m_dados" id="1" class="drop2">Meus Dados</a>
		<li class="menu_right2"><a href="?c=m_end" id="2" class="drop2">Meu Endereço</a>
		<li class="menu_right2"><a href="?c=m_ped" id="3" class="drop2">Meus Pedidos</a>
        <li class="menu_right2"><a href="?c=a_sen" id="5" class="drop2">Alterar Senha</a>
		<!--<li class="menu_right2"><a href="?c=c_atend" id="4" class="drop2">Central de atendimento</a> -->
        <li class="menu_right3"><a href="?ac=sair" id="6" class="drop3">Sair</a>
	</ul>      	   

    <div class="conteudo_dash">
      <?php if(isset($conteudo) && $conteudo == 'm_end') {?>
     	 <div id='centraliza_end' style="width:650px; height:400px; border: solid 1px #A0A0A4; margin:0 auto 40px auto; padding:20px;" >
        
           <h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">&#8250;Seu endereço</h3>
           <h6 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">Caso haja necessidade, seu endereço também podem ser editado, basta modificar e clicar no botão atualizar endereço, no canto inferior da caixa.</h6>
           <br>
          <form action="?ac=end" method="post" name="form1" id="form_dash_endereco"> 
    <table width="600" border="0" cellspacing="0" cellpadding="0">
           <tr>
              <input type="hidden" class="tipo" id="tipo" name="tipo" value="cep">
              <td class="td_cadastro" width="180"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CEP*:</font></td>
              <td><input class="mask-cep" name="cep" type="text" id="cep" maxlength="25" value="<?php echo htmlentities($meu_end['end_cep'], ENT_COMPAT, 'utf-8'); ?>" />
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
              <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" style="color:#F00;">> Não sei o CEP</a></font>
              </td>
              
            </tr>     
           
             <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Numero*:</font></td>
              <td><input name="endereco_numero" type="text" id="endereco_numero" maxlength="15" size='7' value="<?php echo htmlentities($meu_end['end_numero'], ENT_COMPAT, 'utf-8'); ?>" />
              </td>
            </tr>           
           
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Endereço*:</font></td>
              <td><input name="endereco_cadastro" type="text" id="endereco_cadastro" maxlength="80" value="<?php echo htmlentities($meu_end['end_endereco'], ENT_COMPAT, 'utf-8'); ?>" />
              </td>
            </tr>  
    
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Complemento:</font></td>
              <td><input name="complemento" type="text" id="complemento" maxlength="60" value="<?php echo htmlentities($meu_end['end_complemento'], ENT_COMPAT, 'utf-8'); ?>" /><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Ex: Ap 02</font>
              </td>
            </tr>       
    
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Bairro*:</font></td>
              <td><input name="bairro" type="text" id="bairro" maxlength="60" value="<?php echo htmlentities($meu_end['end_bairro'], ENT_COMPAT, 'utf-8'); ?>" /></td>
            </tr>
            
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Cidade*:</font></td>
              <td><input name="cidade" type="text" id="cidade" maxlength="60" value="<?php echo htmlentities($meu_end['end_cidade'], ENT_COMPAT, 'utf-8'); ?>" /></td>
            </tr>       
            
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Estado*:</font></td>
              <td><input name="estado" type="text" id="estado" maxlength="30" value="<?php echo htmlentities($meu_end['end_estado'], ENT_COMPAT, 'utf-8'); ?>" /></td>
            </tr>
            
              
                <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><br><input type="submit" class="novo-botao-verde2" value="Atualizar endereço" /></td>
              </tr>
      </table>

       </form> 
        
        
         </div> 
 			<!-- <h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">&#8250;Meus Endere&ccedil;os</h3>
      		<center>
            <div  style="float:right;  margin-bottom:60px;
  margin-top:-50px;">
           <a class="novo-botao-verde2" href="?c=cad_end">Cadastrar novo Endere&ccedil;o</a>
           </div>
           <div class="m-enderecos">
           
           <table width="100%" border="0" class="tabela-dash">
  <tr class="tabela-topo">
    <td>Endere&ccedil;os Cadastrados</td>
    <td>A&ccedil;&otilde;es:</td>
  </tr>
  
  <!-- ABAIXO LISTAGEM DE TODOS OS ENDEREÇOS CADASTRADOS -->
  <!--
  <tr>
    <td>RUA 300 NUMERO 1000 TERESINA PIAUI</td>
    
    
    <td><a href="#">Alterar</a> - <a href="#">Excluir</a> </td>
    
  </tr>
  
</table>

           </div><!--FIM M-ENDERECOS
    		</center> -->
            
     
      
        <?php } else if(isset($conteudo) && $conteudo == 'm_ped') {?>

         <h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;">&#8250;Meus Pedidos</h3><br><br>

           <div class="m-pedidos" style=" margin-bottom:40px;">
           <table cellpadding="0" cellspacing="0" width="100%" border="0" class="tabela-dash">
              <tr class="tabela-topo">
                <td class="1">Produtos / Pedido</td>
                <td class="1">Código de compra</td>
                <td class="1">Quantidade</td>
                <td class="1">Data</td>
                <td class="2">Status</td>
                <td class="3">Pagamento</td>
              </tr>
              <!-- ABAIXO LISTAGEM DE TODOS OS ENDEREÇOS CADASTRADOS -->
              <?php 
			  	while($meus_pedidos = mysql_fetch_assoc($qr_pedidos)){ 
					$qr_itens = mysql_query("SELECT * FROM pedido_itens WHERE pediN_ped_id = '".$meus_pedidos['ped_id']."'") or die(mysql_error());
					$qtd_itens = mysql_num_rows($qr_itens);
					if($qtd_itens == 1) {
						while($pega_itens = mysql_fetch_assoc($qr_itens)){	
			  
			  ?>

              <tr bgcolor="#E8E8E8">
                <td><?php echo $pega_itens['pediN_nome'] ?> </td>
                <td><?php echo $meus_pedidos['ped_transacao'] ?> </td>
                <td align="center"><?php echo $pega_itens['pediN_qtd'] ?> </td>
                <td><?php echo $meus_pedidos['ped_data'] ?> </td>
                <td><?php 
						$status = $meus_pedidos['ped_status'];
			  			if($status == 1)
							echo 'Aguardando pagamento';
			  			elseif($status == 2)
							echo 'Em análise';
			  			elseif($status == 3)
							echo 'Paga';
			  			elseif($status == 4)
							echo 'Disponivel';
			  			elseif($status == 5)
							echo 'Em disputa';
			  			elseif($status == 6)
							echo 'Devolvida';
			  			elseif($status == 7)
							echo 'Cancelada';																																											
					?>
                </td>
                <td>
					<?php 
                        $pagamento = $meus_pedidos['ped_meioPagamento'];
                        if($pagamento == 1)
                            echo 'Cartão de crédito';
                        elseif($pagamento == 2)
                            echo 'Boleto';
                        elseif($pagamento == 3)
                            echo 'Débito online (TEF)';
                        elseif($pagamento == 4)
                            echo 'Saldo PagSeguro';
                        elseif($pagamento == 5)
                            echo 'Oi Paggo';																																											
                    ?>                
                </td>  
              </tr>
              
			  <tr nowrap bgcolor="#A0A0A4" style="height:1px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr> 
			  
			  <?php 
			  			}//fim while pega itens
					}//fim if qtd_itens == 1
					elseif($qtd_itens > 1){
					 ?>
                   <tr bgcolor="#E8E8E8">
                   
                    <td></td>
                    <td rowspan="<?php echo $qtd_itens+1; ?>"><?php echo $meus_pedidos['ped_transacao'] ?></td>
                    <td></td>
                    
                    
                    <td rowspan="<?php echo $qtd_itens+1; ?>"> <?php echo $meus_pedidos['ped_data'] ?></td>
                    <td rowspan="<?php echo $qtd_itens+1; ?>">
						<?php 
                            $status = $meus_pedidos['ped_status'];
                            if($status == 1)
                                echo 'Aguardando pagamento';
                            elseif($status == 2)
                                echo 'Em análise';
                            elseif($status == 3)
                                echo 'Paga';
                            elseif($status == 4)
                                echo 'Disponivel';
                            elseif($status == 5)
                                echo 'Em disputa';
                            elseif($status == 6)
                                echo 'Devolvida';
                            elseif($status == 7)
                                echo 'Cancelada';																																											
                        ?>
                    </td>
                    
                    <td rowspan="<?php echo $qtd_itens+1; ?>">
					<?php 
                        $pagamento = $meus_pedidos['ped_meioPagamento'];
                        if($pagamento == 1)
                            echo 'Cartão de crédito';
                        elseif($pagamento == 2)
                            echo 'Boleto';
                        elseif($pagamento == 3)
                            echo 'Débito online (TEF)';
                        elseif($pagamento == 4)
                            echo 'Saldo PagSeguro';
                        elseif($pagamento == 5)
                            echo 'Oi Paggo';																																											
                    ?>                     
                    </td>  
                    
                  </tr>

                  <?php 
                  		while($pega_itens = mysql_fetch_assoc($qr_itens)){
				  ?>
                  <tr bgcolor="#E8E8E8">
                	<td><?php echo $pega_itens['pediN_nome'] ?> </td>
                    <td align="center"><?php echo $pega_itens['pediN_qtd'] ?> </td>
              	  </tr>
                  
                  <?php
						}//fim while pega intens
			?>
				<tr bgcolor="#A0A0A4" style="height:1px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
              </tr>
				<?php	}//fim elseif qtd > 1
				}//fim while meus itens 
			   ?>
            </table>
   			</div>

		<!--CENTRAL DE ATENDIMENTO-->
        <?php } else if(isset($conteudo) && $conteudo == 'c_atend') {?>
         <h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">&#8250;Central de Atendimento</h3>
           <!-- webim button --><a href="/tb/chat/client.php?locale=pt-br" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/tb/chat/client.php?locale=pt-br&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/tb/chat/b.php?i=webim&amp;lang=pt-br" border="0" width="163" height="61" alt=""/></a><!-- / webim button -->
   		<!--FIM CENTRAL DE ATENDIMENTO-->
      <?php } else if(isset($conteudo) && $conteudo == 'a_sen') {?>
	
<script language="javascript">
	$(function() {
		$('.password').pstrength();
	});
</script>
	<div id='centralizar_senha' style="border:solid 1px #A0A0A4; width:500px; height:300px; margin: 0 auto 30px auto; padding:20px;">
 		<h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">&#8250;Alterar senha</h3>
		<h6 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">Para maior segurança sua senha deve ser alterada sempre que houver suspeita de fraude.</h6>
      <br />
        <form action="?ac=alt" method="POST" class="alterar_senha" id="alterar_senha">
        
        <table border="0" align="center" class="centraliza_tabela">
      <tr>
        <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Senha atual</font></td>
        <td>
          <input type="password" name="senha_atual" id="senha_atual" />
          </td>
      </tr>
      <tr >
        <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Senha nova</font></td>
        <td style="padding-top: 25px;">
          <input type="password" class="password" name="senha_nova" id="senha_nova" />
          </td>
      </tr>
      <tr>
        <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Confirme senha nova</font></td>
        <td>
          <input type="password" name="confirma_senha" id="confirma_senha" />
          </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><br /><input name="Alterar" type="submit" class="novo-botao-verde2" value="Alterar" /></td>
      </tr>
        </table>
       
        </form>
	</div><!--fuim centraliza senha -->

		<!--CADASTRO DOS ENDEREÇOS-->
        <?php } else if(isset($conteudo) && $conteudo == 'cad_end') {?>
		Cadastre o endereço
        
        <!--FIM CADASTRO DOS ENDEREÇOS-->
        
		<?php }else{?><!-- RESUMO DE TUDO -->
   
   <div id='centraliza_dados' style="border:solid 1px #A0A0A4; margin:0 auto 20px auto; width:650px; padding:20px; height:470px; ">
   
   <form action="?ac=at" method="post" name="form1" id="form_dash_dados">
			 <br class="cancela" />
             
            <h3 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">&#8250;Seus dados pessoais</h3>
            <h6 style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;color:#666;;">Caso haja necessidade, seus dados também podem ser editados, basta modificar e clicar no botão atualizar dados, no canto inferior da caixa.
            <br>
            Obs: Para alterar o seu cpf ou e-mail, entre em contato com nossos atendentes através do chat online ou email.
            </h6>
			<br>
            
            <table class="centraliza_tabela" width="550" align="center">
            
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome Completo*:</font></td>
                <td>
                  <input type="text" id="dash" name="nomecompleto" value="<?php echo htmlentities($row_rsClientes['usu_nome_comp'], ENT_COMPAT, 'utf-8'); ?>" size="40" />
       			</td>
              </tr>
              
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CPF:</font></td>
                <td ><input disabled type="text" id="dash" style="margin-left:5px; color:#808080;" value="<?php echo htmlentities($row_rsClientes['usu_cpf'], ENT_COMPAT, 'iso-8859-1'); ?>" /></td>
              </tr>
              
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Data de Nascimento*:</font></td>
                <td>
                  <input type="text" id="dash" class="mask-nascimento" name="nasc" value="<?php echo htmlentities($row_rsClientes['usu_nasc'], ENT_COMPAT, 'iso-8859-1'); ?>" size="40" />
       			</td>
              </tr>
              
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Telefone*:</font></td>
                <td>
<input type="text" id="ddd" name="ddd" value="<?php echo htmlentities($row_rsClientes['ddd'], ENT_COMPAT, 'iso-8859-1'); ?>" maxlength="2" />
   
<input type="text" id="dash" class="mask-fone" name="fone" value="<?php echo htmlentities($row_rsClientes['usu_fone_prin'], ENT_COMPAT, 'iso-8859-1'); ?>" size="40" />
       			</td>
              </tr>
              
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Celular:</font></td>
                <td>
<input type="text" id="ddd2" name="ddd2" value="<?php echo htmlentities($row_rsClientes['ddd2'], ENT_COMPAT, 'iso-8859-1'); ?>" maxlength="2" />                
<input type="text" id="dash" class="mask-fone" name="cel" value="<?php echo htmlentities($row_rsClientes['usu_celular'], ENT_COMPAT, 'iso-8859-1'); ?>" size="40" />
       			</td>
              </tr>
              
              <tr valign="baseline">
                <td class="td_cadastro"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email*:</font></td>
                <td>
                <input disable type="text" id="dash" name="email" style="margin-left:5px; color:#808080;" value="<?php echo htmlentities($row_rsClientes['usu_email'], ENT_COMPAT, 'iso-8859-1'); ?>" size="40" />
                </td>
              </tr>
              
              
              <tr valign="baseline">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sexo*:</font></td>
                <td>
              		<label><input name="sexo" type="radio" id="cad_masculino" <?php if($row_rsClientes['usu_sexo'] == 'masculino'){ echo "checked='checked'";} ?> value="masculino">Masculino</label><br />
          			<label><input name="sexo" type="radio" id="cad_feminino"  <?php if($row_rsClientes['usu_sexo'] == 'feminino'){ echo "checked='checked'";} ?> value="feminino">Feminino</label>
                   </td>
             
              </tr>
              
                <tr valign="baseline">
                <td>&nbsp;</td>
                <td><br><input type="submit" class="novo-botao-verde2" value="Atualizar dados" /></td>
              </tr>
              
            </table>
            
          </form>
   
   </div>
   
   
   
   
   <?php }?>
    </div><!-- fim div conteudo dash -->
	
</div><!--fim div centraliza --> 
		
 <br class="cancela" />       
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>     
</body>
</html>