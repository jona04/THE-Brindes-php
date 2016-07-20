<?php
include 'Connections/teresinabrindes.php';

//recebe o id da transição a acabou de ser realizada para exibir os valores na tela
$id_seguro = $_GET['sec'];

//recebe os dados da transação pra mostrar na tela
if(isset($id_seguro)){
	$recebe_dados = mysql_query("SELECT * FROM pedidos WHERE ped_transacao = '".$id_seguro."' ") or die(mysql_error());
	$pega_dados = mysql_fetch_assoc($recebe_dados);
	$recebe_itens = mysql_query("SELECT * FROM pedido_itens WHERE pediN_ped_id = '".$id_seguro."'") or die(mysql_error());
	$pega_itens = mysql_fetch_assoc($recebe_itens);	
	$status = $pega_dados['ped_status'];
	
	if(isset($_SESSION['email_the'])){
		//deleta os itens do carrinho que acabou de ser finalizado(comprado)
		$del_sql = mysql_query("DELETE FROM carrinho WHERE car_email = '".$_SESSION['email_the']."'") or die(mysql_error());
		
	}else{
		//deleta os itens do carrinho que acabou de ser finalizado(comprado)
		$del_sql = mysql_query("DELETE FROM carrinho WHERE car_email = '".$pega_dados['ped_email']."'") or die(mysql_error());
	
	}
}//fim if id_seguro
else{
	header("Location:finalizado?sec=$id_seguro");
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Área do Usuário - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

<?php include "favicon.php"; ?>
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<style>
#centraliza_retorno{
	width:800px; 
	height:350px;
	background-color:#DFEBEC;
	margin:60px auto 60px auto;
   padding: 20px;
   
   box-shadow: 7px 5px 3px #A0A0A4;
   -webkit-box-shadow: 7px 5px 3px #A0A0A4;
   -moz-box-shadow: 7px 5px 3px #A0A0A4;
}
</style>
</head>

<body leftmargin="2">

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />


<div id='centraliza_retorno'>
<?php if($status != 7){ ?>
<?php if($pega_dados['ped_valorBruto'] == ''){ ?>
<br/>
<br/>
<br/>
<br/>
<strong style="font-size:19px; font-family:Verdana, Geneva, sans-serif; color:#009F00;">Obrigado pela compra!</strong>
<br/>
<br/>

<strong style="font-size:14px; font-family:Verdana, Geneva, sans-serif;">Recebemos seu pedido!</strong>
<br/><br/>
<p style="font-size:13px; font-family:Verdana, Geneva, sans-serif;">Uma mensagem com detalhes desta transição foi enviada para seu e-mail.</p>
<br/>

<br/>
<br/>

<?php 
}else{ ?>
<strong style="font-size:19px; font-family:Verdana, Geneva, sans-serif; color:#009F00;">Obrigado pela compra!</strong>
<br/>
<br/>

<strong style="font-size:14px; font-family:Verdana, Geneva, sans-serif;">Recebemos seu pedido!</strong>
<br/><br/>
<p style="font-size:13px; font-family:Verdana, Geneva, sans-serif;">Uma mensagem com detalhes desta transição foi enviada para seu e-mail.</p>
<br/>

<p style="font-size:13px; font-family:Verdana, Geneva, sans-serif;">Confira abaixo alguns detalhes de sua compra:</p>
<br/>
<br/>

<table width="600" border="0">
  <tr style="font-size:14px; font-family:Verdana, Geneva, sans-serif;">
    <td height="20" align="left">Valor: </td>
    <td>&nbsp;&nbsp;<?php echo $pega_dados['ped_valorBruto']; ?></td>
  </tr>
  <tr style="font-size:14px; font-family:Verdana, Geneva, sans-serif;">
    <td height="20" align="left">Código da compra:</td>
    <td>&nbsp;&nbsp;<?php echo $pega_dados['ped_transacao']; ?></td>
  </tr>
  <tr style="font-size:14px; font-family:Verdana, Geneva, sans-serif;">
    <td height="20" align="left">Meio de Pagamento:</td>
    <td>&nbsp;&nbsp;<?php 
		if($pega_dados['ped_meioPagamento'] =='1' ){
			echo 'Cartão de Crédito';
			}elseif($pega_dados['ped_meioPagamento']=='2' ){
			echo 'Boleto Bancário';
			}elseif($pega_dados['ped_meioPagamento']=='3' ){
			echo 'Débito Online(TEF)';
			}elseif($pega_dados['ped_meioPagamento']=='4' ){
			echo 'Saldo PagSeguro';
			}elseif($pega_dados['ped_meioPagamento']=='5' ){
			echo 'Oi Paggo';
			}
		?></td>
  </tr>
</table>

<?php } ?>
<br/>
<br/>

<p style="font-size:12px; font-family:Verdana, Geneva, sans-serif;">O reconhecimento do pagamento pode demorar até 2 dias úteis. Seu produto será liberado quando o pagamento for confirmado. Não se preocupe: Você receberá uma mensagem de confirmação do pagseguro.</p>
</div>
<?php }elseif($status == 7){ ?>
<p style=" margin:100px 0 0 0; font-size:14px; font-family:Verdana, Geneva, sans-serif;">Atenção! Houve um problema na validação de seu pagamento. Por favor tente novamente. Caso o problema persista entre em contato com a Teresina Brindes através do chat online ou através do numero (86) 3084-2019.</p>
<?php } ?>
</div>

<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>     
</body>
</html>