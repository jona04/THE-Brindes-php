<?php
ob_start();
include 'Connections/teresinabrindes.php';
include 'frete/RsCorreios.php';
include "PagSeguroLibrary/PagSeguroLibrary.php";
  
//session_destroy();

$pro_id = -1;
if (isset($_GET['id'])) {
  $pro_id = $_GET['id'];
}
        

//captura os dados do usuario logado
if(isset($_SESSION['email_the'])){
	$email = $_SESSION['email_the'] ;
	$qr_usuario = mysql_query("SELECT * FROM usuarios WHERE usu_email = '".$_SESSION['email_the']."'") or die(mysql_error());
	$usuario = mysql_fetch_assoc($qr_usuario);
	$telefone = str_replace('-','',$usuario['usu_fone_prin']);
	$ddd = $usuario['ddd'];
	
	//echo $email;
	$endereco = mysql_query("SELECT e.end_endereco, e.end_numero, e.end_bairro, e.end_cep, e.end_cidade, e.end_estado, e.end_complemento,  e.end_usu_id, u.usu_id, u.ddd, u.usu_fone_prin ,u.usu_cep, u.usu_email FROM endereco e, usuarios u WHERE e.end_usu_id = u.usu_id AND usu_email = '".$_SESSION['email_the']."'")or die(mysql_error());
	$result_endereco = mysql_fetch_assoc($endereco);     

	//captura o peso do usuario logado
	$qr_peso_total = mysql_query("SELECT car_peso FROM carrinho WHERE car_email = '$email'") or die(mysql_error());
	while($pega_peso_total = mysql_fetch_assoc($qr_peso_total)){
		$peso_total += $pega_peso_total['car_peso'];
	}
}else{
	//captura o peso do usuario deslogado
	foreach($_SESSION as $nome4 => $qtd4){

		if(substr($nome4,0,13) == 'produtosPers_'){
			//recebe o id do produto da sessao
		
			$id4 = substr($nome4,13,( strlen($nome4) -13));
						
			$qr_peso_total = mysql_query("SELECT pers_peso FROM produto_personalizado WHERE pers_foto_id = '$id4'") or die(mysql_error());
			$pega_peso_total = mysql_fetch_assoc($qr_peso_total);
				
			$peso_total += $pega_peso_total['pers_peso'];

		}
	}//fim forearch
}
	
//se usuario clicar em comprar
if(isset($_GET['usu']) == 'comp'){
	
	//variavel do valor e tipo do frete recebem suas respectivas sessões
	$result_tipo_frete = $_GET['tipee99'];
	if($_GET['tipee99'] == '1'){
		$string_valor_frete = $_SESSION['v1'];
	}elseif($_GET['tipee99'] == '2'){
		$string_valor_frete = $_SESSION['v2'];	
	}

	$paymentRequest = new PagSeguroPaymentRequest();
	
	$shipping = new PagSeguroShipping();
	$shipping->setCost($string_valor_frete);  
	$paymentRequest->setShipping($shipping);
	
	
	//faz a lista dos produto personalizado	 que estao no carrinho
	$qr_pers_carrinho = mysql_query("SELECT c.car_id, c.car_pro_id, c.car_email, c.car_qtd, c.car_pro_pers,c.car_peso, s.subcat_id, s.subcat_preco,s.subcat_nome,f.fotos_id,f.fotos_subcat_id FROM carrinho c, subcategorias_brindes s,fotos f WHERE car_pro_pers = 1 AND car_pro_id = fotos_id AND subcat_id = fotos_subcat_id AND car_email = '$email'") or die(mysql_error());
	while($recebe_qr_pers = mysql_fetch_assoc($qr_pers_carrinho)){	
	
		//envia para pagseguro
		$paymentRequest->addItem($recebe_qr_pers['car_pro_id'], $recebe_qr_pers['subcat_nome'], $recebe_qr_pers['car_qtd'],number_format($recebe_qr_pers['subcat_preco'],2));
		
	}//fim while 

	//faz a lista dos produto NAO personalizado	 que estao no carrinho
	$qr_pro_carrinho = mysql_query("SELECT c.car_id, c.car_pro_id, c.car_email, c.car_qtd, p.pro_id, p.pro_nome, p.pro_subcat_id, s.subcat_id, s.subcat_preco,s.subcat_nome FROM carrinho c, produtos p, subcategorias_brindes s WHERE car_pro_id = pro_id AND subcat_id = pro_subcat_id AND car_email = '$email'") or die(mysql_error());		
	while($recebe_qr_pro = mysql_fetch_assoc($qr_pro_carrinho)){
		
	//envia para pagseguro
	$paymentRequest->addItem($recebe_qr_pro['car_pro_id'], $recebe_qr_pro['pro_nome'],$recebe_qr_pro['car_qtd'],number_format($recebe_qr_pro['subcat_preco'],2));
	}

	$paymentRequest->setSender($usuario['usu_nome_comp'],$email,$ddd,$telefone);	
	
	$paymentRequest->setShippingAddress($result_endereco['end_cep'],$result_endereco['end_endereco'],$result_endereco['end_numero'],$result_endereco['end_complemento'],$result_endereco['end_bairro'],$result_endereco['end_cidade'],$result_endereco['end_estado'],'BRA'); 
	
	$paymentRequest->setCurrency("BRL");
	$paymentRequest->setShippingType($_GET['tipee99']); 
	$paymentRequest->setReference("I9635");
	
	// Informando as credenciais  
$credentials = new PagSeguroAccountCredentials(  
    'jonatas.iw@gmail.com',   
    'B3FA57C32B7D4A10A3B4C17A42ECB9FB'  
);  
  
// fazendo a requisição a API do PagSeguro pra obter a URL de pagamento  
$url = $paymentRequest->register($credentials);

//limpa carrinho
$del_sql = mysql_query("DELETE FROM carrinho WHERE car_email = '".$_SESSION['email_the']."'");

header("Location: $url");
}//fim if usu comprar


$query_new_produtos = "SELECT * FROM produtos WHERE pro_id = '$pro_id'";
$new_produtos = mysql_query($query_new_produtos) or die(mysql_error());
$row_new_produtos = mysql_fetch_assoc($new_produtos);

/* ---------- adiciona item ao carrinho ----------------*/
//$query_carrinho = "INSERT INTO carrinho (car_pro_id, car_idUsuario, car_qtd, car_precoTotal) VALUES ('$pro_id', '2', '2', '2')";


require 'funcoes.php';
$conecta = new shopping;
$conecta->conexao();
?>
<!DOCTYPE html>
<head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Checkout - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

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



<script language="JavaScript">


$(document).ready(function(){

	$("#calcula_frete").livequery('click',function(){
			
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#checkout_cart_postalCode").val(), function(){
				if(resultadoCEP["resultado"]){
					$("#cidade").val(unescape(resultadoCEP["cidade"]));
					var cidade = resultadoCEP["cidade"];
					if(cidade == 'Teresina' || cidade == 'teresina'){
						$.ajax({
							type:"GET",
							url:"frete/exemplo.php",
							data:{ac:'frete_gratis'},
							beforeSend:function(){
								$('#aguarde_frete').show();
								//$("#no-cep").hide();
							},
							complete:function(){
								$('#aguarde_frete').hide();
								//$("#resultado_cep").show();
							},			
							success: function(atual){
								$("#resultado_cep").html(atual).show()
								//cria sessao do valor do creve
								//$.session.set('frete',valor_frete);
							}	
						})//fim ajax 
					}else{
						var cepDestino = $('#checkout_cart_postalCode').attr("value");
						var peso_total = '<?php echo $peso_total; ?>';
						//servico = $('#tipo_servico').find('option').filter(':selected').attr('value');
						$.ajax({
							type:"GET",
							url:"frete/exemplo.php",
							data:{ac:'frete_pago',cepDestino:cepDestino,peso:peso_total},
							beforeSend:function(){
								$('#aguarde_frete').show();
								//$("#no-cep").hide();
							},
							complete:function(){
								$('#aguarde_frete').hide();
								//$("#resultado_cep").show();
							},			
							success: function(atual){
								$("#resultado_cep").html(atual).show()
								//cria sessao do valor do creve
								//$.session.set('frete',valor_frete);
							}	
						})//fim ajax 
					}
				}//fim if resultado[cep]
			});
			//}else{
			
		return false;
	})

	$(".right #btnFecharPedido").click(function(){
		var qtd = $('#qtdProduto').val();
		//alert(qtd);
		window.location = 'funcoes.php?ac=com&qtdProduto='+qtd;
		return false;
	})
	
	$('.right #botao_comprar_pagseguro').click(function(){
		var tipo_frete = $("input[type=radio][name=modelo_frete]:checked").attr("alt");
		var preco_frete = $("input[type=radio][name=modelo_frete]:checked").val();

		//alert(preco_frete + tipo_frete);
		var qtd = $('#qtdProduto').val();
		if(qtd == '' || qtd == 0){
			window.location = 'funcoes.php?ac=com&qtdProduto='+qtd;
		}else if(tipo_frete == '' || tipo_frete == 0){
			alert('Desculpe, houve um pequeno problema no frete, entre em contato conosco no chat online ou através do telefone para resolvermos seu problema.');
			//window.location = '?usu=error';
		}else if(tipo_frete == undefined){
			window.location = '?usu=comp&tipee99=3';
		}else
		
		{
			//submeter();
			//alert(tipo_frete +' deu certo' );
			window.location = '?usu=comp&tipee99='+tipo_frete;
		}
		return false;
	});

//caso o usuario saia da pagina do aplicativo é realizado as seguntes funções
	//$(window).bind('beforeunload', excluiFotos);//fim função beforeunload
	//window.onbeforeunload = exclui();
	function exclui() {

		//aqui terá alguma variavel para saber qual usuario esta saindo da pagina
		$.ajax({
			type:'GET',
			url:'funcoes.php',
			async: false,
			data:{sessao_frete:'exclui'},
			success:function(atual){
				//$.session.delete('frete');
				//window.location = 'funcoes.php?sessao_frete=exclui';
				}	
		});//fim ajax	
	
	}
});
</script>




<?php include "favicon.php"; ?>

<link href="checkout.css" rel="stylesheet" type="text/css" />
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
<?php if(isset($_GET['msg_error']) && $_GET['msg_error'] ==1){?> 
<div id='msg_erro' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px;">
<p>Por favor, antes de continuar informe a quantidade desejada.</p>
</div>
<?php } ?>
<?php if(isset($_GET['msg_error']) && $_GET['msg_error']==2){?> 
<div id='msg_erro' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px;">
<p>Essa quantidade não é permitida, por favor tente novamente.</p>
</div>
<?php } ?>
<div class="centraliza_checkout" style="width:1020px; margin: 40px auto 0 auto;">
 	<div class="logo_cadastro"><span>MEU CARRINHO</span></div>
        
    <!-- se existe produto no carrinho -->
	<?php 
	if(isset($_SESSION)){
		//separa nome de quantidade ou valor dos produtos nao personaliaveis
		foreach($_SESSION as $nome2 => $quantidade2){

			if(substr($nome2,0,13) == 'produtosPers_'){
			$qtd++;
			}else{
				$qtd = "0";
			}
		}
	}
	if(!isset($qtd)){
		$qtd = "0";
	}
    if($conecta->getExisteProduto() == true || $qtd > 0){
    ?>	
    
    <div class="clear"></div>
    <a class="novo-botao-laranja2" id="continua-comprando" href="index.php">Continuar comprando</a>
	<?php if(isset($_SESSION['email_the'])){ ?>
    <div class="right">
       <!-- submit do form (obrigatório) -->  
       <a href='#' id='botao_comprar_pagseguro'><img src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro" /></a> 
       <!--  <a class="botao medio verde" id='btnFecharPedido' href="#"><span>Fechar Pedido</span></a> -->
    </div> 
	<?php }else{?>
    <div class="right2">
    	<a class="novo-botao-verde2" id='btnFecharPedido' href="#"><span>Fechar Pedido</span></a>
    </div>
    <?php } ?>    
    <table>
        <thead>
        <tr>
            <th colspan="2">Produtos</th>
            <th width='200px'>Quantidade</th>
            <th>Preço</th>
            <th width="2px"></th>
        </tr>
        </thead>
        <tbody>
         
         <!-- mostra os produtos do carrinho -->
		 <?php $conecta->carrinho(); ?>
           
            <tr>
            <!--<td colspan="5" class="postal-code">
                <form action="checkout.php" method="post">
                    <label skip-resolve-postalcode="1" for="checkout_cart_postalCode" class=" required">CEP</label>
                    <input type="text" id="checkout_cart_postalCode" name="cepDestino" required    skip-resolve-postalcode="1" />

                    <select name='servico' id="tipo_servico" rel="0">
                    	<option value="41106" selected="selected">PAC</option>
                        <option value="40215" >SEDEX</option>
                        <option value="40010" >SEDEX 10</option>
                    </select>
             
                   <button id="calcula_frete" class="rounded button-gray button">Calcular frete</button>
                </form>
            </td>-->
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">
               <!-- <form id="voucherSubmit" action="#" method="post">
                    <label for="voucherCode">Cupom</label>
                        <input type="text" id="voucherCode" name="voucherCode"
                               value="" />
                    <button class="rounded button-gray button">Aplicar</button>
                </form> -->
            </td>
            <td colspan="3" class="price">
                <span style="font-size:12px;">Subtotal:</span> 
                <span style="font-size:12px;">R$<?php if(isset($_SESSION['email_the'])){
								echo $conecta->getLogadoTotal();
								}else{ 
							  	echo $conecta->getTotal();
								} 
						?>
               </span>
            </td>
        </tr>
        </tfoot>
    </table>  
	<?php if(isset($_SESSION['email_the'])){ ?>	
    
    <br>
    <center>
    <?php 
	
	if ($result_endereco['end_endereco'] != ""){	
	echo "<h5 style='color:#666;'>Seu endereço atual é:</h5>";
	echo "<p style='font-size:12px; color:#666;'>";
	echo 'Cep: ' . $result_endereco['usu_cep'] . "<br />";
	echo $result_endereco['end_endereco'];echo " - ";echo $result_endereco['end_numero']; echo "<br>";
	echo $result_endereco['end_bairro'];echo " - "; echo $result_endereco['end_cidade'];echo " - ";echo $result_endereco['end_estado']; echo "<br>";
	echo "</p>";
	}else
	{
		echo "<h4 style='color:red;'>Cadastre um endereço na área do usuário, assim poderemos calcular seu frete !</h4>";
		}
	
	?>
   
   </center>
    <br> 
    <?php if(strcasecmp($result_endereco['end_cidade'],'teresina') != 0){ ?>
	<table>
		<tr>
			<th colspan="1" class="tabela-frete" >Serviço de entrega</th>
			<th class="tabela-frete" width='200px'>Prazo de entrega</th>
			<th class="tabela-frete">Valor do frete</th>
			<th class="tabela-frete">Valor Total</th>
			<th class="tabela-frete">Escolher</th>
		</tr>
		<tr>
			<?php 
			//tira o '-' do cep
			$local = str_replace('-','',$usuario['usu_cep']);
			
			$frete = new RsCorreios();
			
			// Informa o cep de origem
			$frete->setCepOrigem("64000310");
			// Informa o cep de destino
			$frete->setCepDestino($local);
			// Informa o peso da encomenda
			$frete->setPeso($peso_total/*$row_new_produtos['pro_peso']*/);
			// Informa a altura da encomenda
			$frete->setAltura('20'/*$row_new_produtos['pro_altura']*/);
			// Informa o comprimento da encomenda
			$frete->setComprimento('20'/*$row_new_produtos['pro_comprimento']*/);
			// Informa a largura da encomenda
			$frete->setLargura('20'/*$row_new_produtos['pro_altura']*/);
			// Informa o serviço. 41106 = PAC
			$frete->setServico('41106');
			
			// Consulta o frete
			$resposta = $frete->getDadosFrete();
			
			// Imprime na tela o resultado obtido:
			$valor_frete = $resposta['valor'];
			$prazo_frete = $resposta['prazoEntrega'];
			$msgErro_frete = $resposta['msgErro'];

			//converte o valor do frete de virgula em ponto para que o pagseguro possa ler
			$result_valor_frete = str_replace(',','.',$valor_frete);
			
			
			?>
			<!--SERVIÇO--><td> <center>PAC</center></td>
			<!--PRAZO DE ENTREGA--><td><center><?php echo $prazo_frete ?> dias</center></td>
			<!--VALOR DO FRETE--><td><center><?php echo $result_valor_frete ?> R$</center></td>
			<!--VALOR TOTAL-->
			<td>
				<center>
					<?php 
					$valor_total = $conecta->getLogadoTotal();
					$total_and_frete = $valor_total + $result_valor_frete;
					echo number_format($total_and_frete,2);
					$_SESSION['v1'] = number_format($result_valor_frete,2)
					?> R$
				</center>
			</td>
			<!--VALOR TOTAL--><td><center><input type="radio" alt="1" name='modelo_frete' value='<?php echo $total_and_frete; ?>' checked></center></td>
		</tr>
	  <tr>
		  <?php 
			//tira o '-' do cep
			$local2 = str_replace('-','',$usuario['usu_cep']);
			
			$frete2 = new RsCorreios();
			
			// Informa o cep de origem
			$frete2->setCepOrigem("64000310");
			// Informa o cep de destino
			$frete2->setCepDestino($local2);
			// Informa o peso da encomenda
			$frete2->setPeso($peso_total/*$row_new_produtos['pro_peso']*/);
			// Informa a altura da encomenda
			$frete2->setAltura('20'/*$row_new_produtos['pro_altura']*/);
			// Informa o comprimento da encomenda
			$frete2->setComprimento('20'/*$row_new_produtos['pro_comprimento']*/);
			// Informa a largura da encomenda
			$frete2->setLargura('20'/*$row_new_produtos['pro_altura']*/);
			// Informa o serviço. 41106 = PAC
			$frete2->setServico('40010');
			
			// Consulta o frete
			$resposta2 = $frete2->getDadosFrete();
			
			// Imprime na tela o resultado obtido:
			$valor_frete2 = $resposta2['valor'];
			$prazo_frete2 = $resposta2['prazoEntrega'];
			$msgErro_frete2 = $resposta2['msgErro'];

			//converte o valor do frete de virgula em ponto para que o pagseguro possa ler
			$result_valor_frete2 = str_replace(',','.',$valor_frete2);
			
			
			?>
			<!--SERVIÇO--><td> <center>E-sedex</center></td>
			<!--PRAZO DE ENTREGA--><td><center><?php echo $prazo_frete2 ?> dias</center></td>
			<!--VALOR DO FRETE--><td><center><?php echo $result_valor_frete2 ?> R$</center></td>
			<!--VALOR TOTAL-->
			<td>
				<center>
					<?php 
					$valor_total2 = $conecta->getLogadoTotal();
					$total_and_frete2 = $valor_total2 + $result_valor_frete2; 
					echo number_format($total_and_frete2,2);
					$_SESSION['v2'] = number_format($result_valor_frete2,2);
					?> R$
				</center>
			</td>
			<!--VALOR TOTAL--><td><center><input type="radio" name='modelo_frete' alt="2" value='<?php echo $total_and_frete2; ?>'></center></td>
		</tr>

	</table>
	<?php
	}//FIM IF cidade != teresina
	elseif(strcasecmp($result_endereco['end_cidade'],'teresina') == 0){  // faz comparação sem diferencia maiuscula de minuscula?>
    	<h5 align='center' style='color:#666;'>FRETE GRÁTIS PARA TODA TERESINA!</h5><br>
        <?php $_SESSION['v1'] = 0; $_SESSION['v2'] = 0; ?>
	<?php }//fim if compração
	//fim if sessão email
	}else{ 
	?>
    <table>
		<div id="resultado_cep">
        </div>
	    <tr id='no-cep'>
			<div id="aguarde_frete" style="display:none; float:right;"><img src="imagens/aguarde.gif" /></div>
            <td colspan="5" class="postal-code">
                <form action="checkout.php" method="post">
                    <label skip-resolve-postalcode="1" for="checkout_cart_postalCode" class=" required">CEP</label>
                    <input type="text" id="checkout_cart_postalCode" name="cepDestino" required    skip-resolve-postalcode="1" />
             
                   <button id="calcula_frete" class="rounded button-gray button">Calcular frete</button>
                </form>
            </td>
        </tr>
	</table>
	<?php 
		//}//fim else nao exite frete gratis
	}//fim else 
	?>

    
    
    
    <a class="novo-botao-laranja2" id="continua-comprando2" href="index.php">Continuar comprando</a>
	<?php if(isset($_SESSION['email_the'])){ ?>
    <div class="right">
       <!-- submit do form (obrigatório) <img src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro" /> -->  
       <a href='#' id='botao_comprar_pagseguro'><img src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro" /> </a> 
       <!--  <a class="botao medio verde" id='btnFecharPedido' href="#"><span>Fechar Pedido</span></a> -->
    </div> 
	<?php }else{?>
    <div class="right">
    	<a class="novo-botao-verde2" id='btnFecharPedido' href="#"><span>Fechar Pedido</span></a>
    </div>
    <?php } ?>  
    
    </form> <!-- fim form pag seguro -->
    
        <?php  }else{ //caso nao existe produto no carrinho executa esta ação ?>
        
        
        <div>
        
        
        
        <p class="verifica_carrinho"><img src="imagens/danger.png" width="50px" height="50px" style="float: left;margin-left: 380px;margin-right: 10px;margin-top: 0px;">Não possui produtos no carrinho </p>
        
        </div>
        
        
        <a class="novo-botao-laranja2" href="index.php">Continuar comprando</a>
        <?php } //fim else carrinho vazio ?>
    <div class="clear"></div>

</div>
<div class="rodape">
  <?php include "news_rodape.php";?>
</div>

</body>
</html>