<?php
require_once('Connections/teresinabrindes.php');
include "anti-injection.php";
$ac = $_GET['ac'];

require 'funcoes.php';
$conecta = new shopping;
$conecta->conexao();


if(anti_sql($ac == 'e_login')){
	//si o usuario ja estiver logado volta para o index
	if(isset($_SESSION['email_the'])){
		header( "Location: index.php");
	}
	//FUNÇÕES RESPONSAVEL PELO LOGIM
	else{
		$email = anti_sql($_POST['email_login']);
		$senha = anti_sql(md5($_POST['senha_login']));
		
		$confirmacao = mysql_query("SELECT * FROM usuarios WHERE usu_email = '$email' AND usu_senha = '".mysql_real_escape_string($senha)."'") or die(mysql_error()); //verifica se o login e a senha conferem
		$contagem = mysql_num_rows($confirmacao); //traz o resultado da pesquisa acima
		$captura_info = mysql_fetch_assoc($confirmacao);
		if ( $contagem == 1 ) {
			$_SESSION['email_the'] = $email;
			$_SESSION['nome_usuario'] = $captura_info['usu_nome_comp'];
			$_SESSION['id_usu'] = $captura_info['usu_id'];
			
			//faz um lopp para contar a quantidade de produtos na sessão
			foreach($_SESSION as $nomeP => $quantidadeP){
				if(substr($nomeP,0,9) == 'produtos_'){
				
				//mysql_query("DELETE FROM carrinho WHERE car_email = '".mysql_real_escape_string($_SESSION['email_the']). "'");
			
					//faz um loop novamente pelas 
					foreach($_SESSION as $nomeP2 => $quantidadeP2){
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
					}//fim foreach $_SESSIONo
				}//fim if produtosn > 0
			}//fim primeiro foreach
			
						//faz um lopp para contar a quantidade de produtos personalizados na sessão
			foreach($_SESSION as $nomeR => $quantidadeR){
				if(substr($nomeR,0,13) == 'produtosPers_'){

				
				//deleta os produtos contidos no carrinho do usuario 
				//mysql_query("DELETE FROM carrinho WHERE car_email = '".mysql_real_escape_string($_SESSION['email_the']). "'")or die(mysql_error());
				
					//faz um loop novamente pelas 
					foreach($_SESSION as $nomeR2 => $quantidadeR2){
						//recebe o id do produto
						$idProCar2 = substr($nomeR2,13,( strlen($nomeR2) -13));
						
						//montar produtos 
						$query_produto2 = mysql_query("SELECT p.pers_foto_id,p.pers_imagem,p.pers_subcat_id, s.subcat_id,s.subcat_preco FROM produto_personalizado p, subcategorias_brindes s WHERE p.pers_subcat_id = s.subcat_id AND p.pers_foto_id =". mysql_real_escape_string((int)$idProCar2)) or die(mysql_error());	
						//insere os dados da sessão no carrinho (banco de dados)
						while($produto2 = mysql_fetch_assoc($query_produto2)){ 
							//insere os campos na tabela
							mysql_query("INSERT INTO carrinho (car_pro_id, car_pro_imagem,car_email,car_qtd,car_preco,car_pro_pers)
							VALUES ('".mysql_real_escape_string($produto2['pers_foto_id'])."','".mysql_real_escape_string($produto2['pers_imagem'])."','".mysql_real_escape_string($_SESSION['email_the'])."','".mysql_real_escape_string((int)$quantidadeR2)."','".mysql_real_escape_string($produto2['subcat_preco'])."',1)") or die(mysql_error()); 	
						}//fim while
						//deleta os produtos contidos no produto_personalizado e deleta sessão 
						mysql_query("DELETE FROM produto_personalizado WHERE pers_foto_id = '".mysql_real_escape_string($idProCar2). "'") or die(mysql_error());
						unset($_SESSION['produtosPers_'.$idProCar2]);	
					}//fim foreach $_SESSIONo		
				}//fim if produtoR > 0*/
			}//fim primeiro foreach 
			$erro == 'false';
			header("Location: checkout.php"); //entra na pagina restrita
		}//fim if contage = 1
		else {
		$erro = 'true';
		}
	}//fim else nao existe sessao
}//fim if(ac == e_login)
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
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title>Login - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<div class="cancela"></div>
<?php if($erro == 'true') { ?>
<div id="msg_login" style="background-color:#FF8080; color:#fff; padding:5px; width:1010px; margin: 20px auto 0 auto; ">
<center>E-mail ou senha incorretos. Tente novamente</center></div>
<?php } ?>
<div class="centraliza_cadastro">
<center>
 <div class="form_cadastro">
 	<div class="logo_cadastro"><div class="img_login"></div>LOGIN</div>
	<form name="cadastrar" class="login-form" method="POST" action="?ac=e_login" enctype="multipart/form-data">
  		
        <table width="500" border="0" cellspacing="0" cellpadding="0">
        
        <tr> 
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
          <td><input name="email_login" type="text" id="email_login" maxlength="80"></td>
        <td> </td>
        </tr>
        <tr>
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Senha:</font></td>
          <td><input name="senha_login" type="password" id="senha_login" maxlength="30"></td>
        <td> </td>
        </tr>
        
        <tr> 
          <td> </td>
          <td> </td>
          <td> </td>
        </tr>
        <tr> 
          <td></td>
          <td nowrap>
           
                  <input class="novo-botao-verde2" name="enviar" type="submit" id="enviar_login" value="Entrar">
                  <input class="novo-botao-vermelho2" name="limpar" type="reset" id="limpar" value="Limpar"><br>
                  <br>
                 
          <a href='rec_sen.php' class="recupera_senha">Recuperar senha</a>
         </td>
          <td></td>
        </tr>
  </table>
</form>
</div>
</center>
</div>
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>
