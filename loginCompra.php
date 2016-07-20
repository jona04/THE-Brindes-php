<?php
require_once('Connections/teresinabrindes.php');
include "anti-injection.php"; 

if(isset($_GET['ac'])){
$ac = $_GET['ac'];
}else{
	$ac = "";
}
//si o usuario ja estiver logado volta para o index
if(isset($_SESSION['email_the'])){
	header( "Location: index.php");
}


// função para retirar acentos e passar a frase para minúscula
/*function normaliza($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYobsaaaaaaceeeeiiiidnoooooouuuyybyRr';
$string = utf8_decode($string);
$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
$string = str_replace(" ","-",$string); // retira espaco
$string = strtolower($string); // passa tudo para minusculo
return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}
*/
//FUNÇÕES RESPONSAVEL PELO LOGIM
if(anti_sql($ac == 'e_login')){
	$email = anti_sql($_POST['email_login']);
	$senha = anti_sql(md5($_POST['senha_login']));
	
	$confirmacao = mysql_query("SELECT * FROM usuarios WHERE usu_email = '$email' AND usu_senha = '".mysql_real_escape_string($senha)."'"); //verifica se o login e a senha conferem
	$contagem = mysql_num_rows($confirmacao); //traz o resultado da pesquisa acima
	$captura_info = mysql_fetch_assoc($confirmacao);
	if ( $contagem == 1 ) {
		$_SESSION['email_the'] = $email;
		$_SESSION['nome_usuario'] = $captura_info['usu_nome_comp'];
		$_SESSION['id_usu'] = $captura_info['usu_id'];
	
		//faz um lopp para contar a quantidade de produtos na sessão
		/*foreach($_SESSION as $nomeP2 => $quantidadeP2){
			if(substr($nomeP2,0,9) == 'produtos_'){
			
				$idProCar = substr($nomeP2,9,( strlen($nomeP2) -9));
				//montar produtos 
				$query_produto = mysql_query("SELECT p.pro_id,p.pro_subcat_id,p.pro_imagem, s.subcat_id, s.subcat_preco FROM produtos p, subcategorias_brindes s WHERE s.subcat_id = p.pro_subcat_id AND p.pro_id =". mysql_real_escape_string((int)$idProCar));		
		
				while($produto = mysql_fetch_assoc($query_produto)){ 
					//monta carrinho para verificar si ja existe produto
					$qr_carrinho = mysql_query("SELECT * FROM carrinho WHERE car_pro_id =". mysql_real_escape_string((int)$idProCar)) or die(mysql_error());
					$verifica_carrinho = mysql_fetch_assoc($qr_carrinho);
					//se ja existir produto, so altera quantidade
					if($verifica_carrinho['car_pro_id'] == $idProCar){
						mysql_query("UPDATE carrinho SET car_qtd='".mysql_real_escape_string($quantidadeP2)."' WHERE car_pro_id='".mysql_real_escape_string($idProCar)."'") or die(mysql_error());
						//header('Location: checkout.php');
					}else{
					//insere os campos na tabela
					mysql_query("INSERT INTO carrinho (car_pro_id, car_pro_imagem,car_email,car_qtd,car_preco)
					VALUES ('".mysql_real_escape_string($produto['pro_id'])."','".mysql_real_escape_string($produto['pro_imagem'])."','".mysql_real_escape_string($_SESSION['email_the'])."','".mysql_real_escape_string((int)$quantidadeP2)."','".mysql_real_escape_string($produto['subcat_preco'])."')");
					}
				}//fim while
			
				unset($_SESSION['produtos_' . $idProCar] );
			}//fim if produtosn > 0
		}//fim primeiro foreach
		*/	
		//faz um lopp para contar a quantidade de produtos na sessão
		foreach($_SESSION as $nomeR2 => $quantidadeR2){
			
			//pega o id da imagem penviada para guardar seu endereço
			if(substr($nomeR2,0,15) == 'imagem_enviada_'){
				
				$idProCar3 = substr($nomeR2,15,( strlen($nomeR2) -15));
				
				//verifica se imagem esta no carrinho
				$qr_verifica_foto = mysql_query("SELECT fotos_id, fotos_carrinho FROM fotos WHERE fotos_id = '$idProCar3' AND fotos_carrinho = 1");
				$num_linhas = mysql_num_rows($qr_verifica_foto);
				if($num_linhas > 0){
				
					$qr_foto = mysql_query("SELECT pers_imagem, pers_foto_id FROM produto_personalizado WHERE pers_foto_id = '$idProCar3'") or die(mysql_error());

					$pega_foto = mysql_fetch_assoc($qr_foto);
					
					//captura o edereço da imagem
					$origem = $pega_foto['pers_imagem'];
					$origem2 = 'brindes-personalizados/enviados/temporarios/'.$quantidadeR2;
					//data para servir como nome da pasta
					$data_pasta = date("d-m-Y");
					//recebe nome do usuario para nome da pasta
					//$nomeUsuario = normaliza($_SESSION['nome_usuario']);
					$nome_atual = $quantidadeR2; //nome que dará a imagem
		
					$idUsuario = $_SESSION['id_usu'];
					$pasta = "brindes-personalizados/enviados/" . $data_pasta . "/" . $idUsuario . "/";
					$pasta2 = "enviados/" . $data_pasta . "/" . $idUsuario . "/";
					//verificando pastas no servidor
					//monta o endereço
					if(!file_exists($pasta))
					{//verifica existência        
						mkdir($pasta,0755,true);//cria pasta
					}
					
					//captura somente o nome da imagem
					$nome_imagem = basename($pega_foto['pers_imagem']);
					
					$atualiza_foto = mysql_query("UPDATE fotos SET fotos_endereco1 ='".mysql_real_escape_string($pasta2.$nome_atual)."' WHERE fotos_id='".mysql_real_escape_string($idProCar3)."'") or die(mysql_error());;
									
					copy($origem, $pasta.$nome_imagem);
					copy($origem2, $pasta.$nome_atual);
					unlink($origem);
					unlink($origem2);
				}//fim if num rows > 0
			}
			
			if(substr($nomeR2,0,13) == 'produtosPers_'){
					
				$idProCar2 = substr($nomeR2,13,( strlen($nomeR2) -13));
				
				//montar produtos 
				$query_produto2 = mysql_query("SELECT p.pers_foto_id,p.pers_imagem,p.pers_subcat_id,p.pers_peso,p.pers_altura,p.pers_largura,p.pers_comprimento, s.subcat_id,s.subcat_preco FROM produto_personalizado p, subcategorias_brindes s WHERE p.pers_subcat_id = s.subcat_id AND p.pers_foto_id =". mysql_real_escape_string((int)$idProCar2)) or die(mysql_error());		
				//insere os dados da sessão no carrinho (banco de dados)
				while($produto2 = mysql_fetch_assoc($query_produto2)){ 
					//insere os campos na tabela
					mysql_query("INSERT INTO carrinho (car_pro_id, car_pro_imagem,car_email,car_qtd,car_preco,car_peso,car_altura,car_largura,car_comprimento,car_pro_pers)
					VALUES ('".mysql_real_escape_string($produto2['pers_foto_id'])."','".mysql_real_escape_string($pasta.$nome_imagem)."','".mysql_real_escape_string($_SESSION['email_the'])."','".mysql_real_escape_string((int)$quantidadeR2)."','".mysql_real_escape_string($produto2['subcat_preco'])."','".mysql_real_escape_string($produto2['pers_peso'])."',".mysql_real_escape_string($produto2['pers_altura']).",".mysql_real_escape_string($produto2['pers_largura']).",".mysql_real_escape_string($produto2['pers_comprimento']).",1)") or die(mysql_error()); 	
				}//fim while
				//deleta os produtos contidos no produto_personalizado e deleta sessão 
				mysql_query("DELETE FROM produto_personalizado WHERE pers_foto_id = '".mysql_real_escape_string($idProCar2). "'") or die(mysql_error());
				unset($_SESSION['produtosPers_'.$idProCar2]);
				unset($_SESSION['imagem_enviada_'.$idProCar2]);	
			}//fim if substr produtoPers
		}//fim primeiro foreach 
		header("Location: checkout.php"); //entra na pagina restrita
		$erro == 'false';
	} else {
	$erro = 'true';
	}
}//fim if(ac == e_login)?>

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
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title>Login - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />
<?php if(isset($erro) && $erro == 'true') { ?>
<div id="msg_login" style="background-color:#FF8080; color:#fff; padding:5px; width:1010px; margin: 20px auto 0 auto; ">
<center>E-mail ou senha incorretos. Tente novamente</center></div>
<?php } ?>
<?php if(isset($_GET['login']) && $_GET['login'] == 's') { ?>
<div id="msg_login" style="background-color:#0C3; color:#fff; padding:5px; width:1010px; margin: 20px auto 0 auto; border:solid 1px; border-color:#060; ">
<center>Parabéns, você já esta cadastrado. Agora basta entrar com seu email e senha.</center></div>
<?php } ?>
<div class="centraliza_logim">

 	<div id="login_left" style="width:500px; float:left;">
        <div class="logo_cadastro2"><div class="img_login"></div><span>LOGIN</span></div>
        <form name="cadastrar" method="POST" action="?ac=e_login" enctype="multipart/form-data">
            <table width="200" align="center" border="0" cellspacing="0" cellpadding="0">
            
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
              <td><input name="email_login" type="text" id="email_login" maxlength="75"></td>
            </tr>
            <tr> 
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Senha:</font></td>
              <td><input name="senha_login" type="password" id="senha_login" maxlength="75"></td>
              
            </tr>
            
            <tr> 
              <td> </td>
              <td> </td>
            </tr>
            <tr> 
              <td colspan="2"><div align="center"> 
                                  <input class="novo-botao-verde2" name="enviar" type="submit" id="enviar_login" value="Entrar">
                                  <input class="novo-botao-vermelho2" name="limpar" type="reset" id="limpar" value="Limpar">
							</div>
                            <br /><p align="center"><a href='rec_sen.php' class="recupera_senha">Recuperar senha</a></p>
              			
              </td>
            
            </tr>
          </table>
        </form>	
	</div>
    
     	<div id="login_right" style="width:500px; float:right;">
        <div class="logo_cadastro2"><div class="img_login"></div><span>CADASTRO</span></div>
        <p align="center" style="color:#666; font-family:Tahoma, Geneva, sans-serif; font-size:20px;">N&atilde;o &eacute; cadastrado?</p>
	<p align="center">cadastre-se <a href='cadastro_usuario.php' style="color:#003;"><strong>AQUI</strong></a></p>
	</div>
    
    
 <br class="cancela" />   

</div>
</div>
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>
