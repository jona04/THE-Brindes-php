<?php
ob_start();
include 'Connections/teresinabrindes.php';

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

$file = fopen('arquivo.txt', 'a');
if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
	//Todo resto do código iremos inserir aqui.
	
	//$email = 'jonatas.iw@gmail.com';
	$email = 'jonatas@teresinabrindes.com.br';
	//$token = 'B3FA57C32B7D4A10A3B4C17A42ECB9FB'; jonatas.iw@gmail.com
	$token = 'D11B06B5F278497EAE280BD40A67E469';
	//$token = 'D11B06B5F278497EAE280BD40A67E469'; jonatas@tersinabrindes.com.br
	$url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$transaction= curl_exec($curl);
	curl_close($curl);
	
	if($transaction == 'Unauthorized'){
	//Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção
	fwrite($file, 'Trocar o token');
	exit;//Mantenha essa linha
	}
	
	$transaction = simplexml_load_string($transaction);
	fwrite($file, var_export($transaction, true));
	$data = date("d/m/Y");

	if(isset($transaction->shipping->type)){
		$sql_trans = "INSERT INTO pedidos (
								ped_email,
								ped_ref,
								ped_transacao,
								ped_status,
								ped_meioPagamento,
								ped_identificadorPagamento,
								ped_valorBruto,
								ped_valorDesconto,
								ped_valorTaxas,
								ped_valorLiquido,
								ped_dataRetirada,
								ped_valorExtra,
								ped_numeroParcelas,
								ped_numeroItens,
								ped_tipoFrete,
								ped_custoFrete,
								ped_cepEnvio,
								ped_data
								) VALUES (
								'".$transaction -> sender -> email."',
								'". $transaction->reference ."',
								'". $transaction->code ."',
								'". $transaction->status ."',
								'". $transaction->paymentMethod->type ."',
								'". $transaction->paymentMethod->code."',
								'". $transaction->grossAmount ."',
								'". $transaction->discountAmount ."',
								'". $transaction->feeAmount ."',
								'". $transaction->netAmount ."',
								'". $transaction->escrowEndDate ."',
								'". $transaction->extraAmount ."',
								'". $transaction->installmentCount ."',
								'". $transaction->itemCount ."',
								'". $transaction->shipping->type ."',
								'". $transaction->shipping->cost ."',
								'". $transaction->shipping->address->postalCode ."',
								'$data'
								)";
	}else{
		$sql_trans = "INSERT INTO pedidos (
							ped_email,
							ped_ref,
							ped_transacao,
							ped_status,
							ped_meioPagamento,
							ped_identificadorPagamento,
							ped_valorBruto,
							ped_valorDesconto,
							ped_valorTaxas,
							ped_valorLiquido,
							ped_dataRetirada,
							ped_valorExtra,
							ped_numeroParcelas,
							ped_numeroItens,
							ped_cepEnvio,
							ped_data
							) VALUES (
							'".$transaction -> sender -> email."',
							'". $transaction->reference ."',
							'". $transaction->code ."',
							'". $transaction->status ."',
							'". $transaction->paymentMethod->type ."',
							'". $transaction->paymentMethod->code."',
							'". $transaction->grossAmount ."',
							'". $transaction->discountAmount ."',
							'". $transaction->feeAmount ."',
							'". $transaction->netAmount ."',
							'". $transaction->escrowEndDate ."',
							'". $transaction->extraAmount ."',
							'". $transaction->installmentCount ."',
							'". $transaction->itemCount ."',
							'". $transaction->shipping->address->postalCode ."',
							'$data'
							)";
	
	}//fim else sem frete

	//envia para banco de dados
	$envia_trans = mysql_query($sql_trans) or die(mysql_error());
	$ultimo_id = mysql_insert_id();
	
	foreach ($transaction->items->item as $row) {
		$sql_itens = "INSERT INTO pedido_itens (	
			pediN_ped_id,	
			pediN_itemID,	
			pediN_nome,
			pediN_qtd,	
			pediN_preco
		) VALUES (	
			'$ultimo_id',	
			'".$row->id."',	
			'".$row->description."',
			'".$row->quantity."',
			'".$row->amount."'
		)";
		$envia_itens = mysql_query($sql_itens) or die(mysql_error());
	}

}
//recebe os dados da transação pra mostrar na tela
//header("Location:finalizado.php?id_seguro=$id_seguro");
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
    <td height="20" align="left">Código do PagSeguro:</td>
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


<p>
 
</p>
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