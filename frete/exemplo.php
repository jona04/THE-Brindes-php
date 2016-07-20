<?php
require_once('../Connections/teresinabrindes.php');
require_once('RsCorreios.php');
require '../funcoes.php';
$conecta = new shopping;

// ----------------   VIA PAC   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//tira o '-' do cep
//$local = str_replace('-','',$usuario['usu_cep']);

if($_GET['ac'] == 'frete_pago'){
	
	$peso_total = $_GET['peso'];
	
	$frete = new RsCorreios();
	
	// Informa o cep de origem
	$frete->setCepOrigem("64000310");
	// Informa o cep de destino
	$frete->setCepDestino($_GET['cepDestino']);
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
				
	
	// ----------------   VIA SEDEX   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	
	//tira o '-' do cep
	//$local2 = str_replace('-','',$usuario['usu_cep']);
	
	$frete2 = new RsCorreios();
	
	// Informa o cep de origem
	$frete2->setCepOrigem("64000310");
	// Informa o cep de destino
	$frete2->setCepDestino($_GET['cepDestino']);
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
//fim frete pago
?>
<table style="width: 1021px;">
		<tr>
			<th colspan="1" class="tabela-frete" >Serviço de entrega</th>
			<th class="tabela-frete" width='200px'>Prazo de entrega</th>
			<th class="tabela-frete">Valor do frete</th>
			<th class="tabela-frete">Valor Total</th>
			<th class="tabela-frete">Escolher</th>
		</tr>
		<tr>
			<!--SERVIÇO--><td> <center>PAC</center></td>
			<!--PRAZO DE ENTREGA--><td><center><?php echo $prazo_frete ?> dias</center></td>
			<!--VALOR DO FRETE--><td><center><?php echo $result_valor_frete ?> R$</center></td>
			<!--VALOR TOTAL-->
			<td>
				<center>
					<?php 
					$valor_total = $conecta->getTotal();
					$total_and_frete = $valor_total + $result_valor_frete;
					echo number_format($total_and_frete,2);
					?> R$
				</center>
			</td>
			<!--VALOR TOTAL--><td><center><input type="radio" alt="1" name='modelo_frete' value='<?php echo $total_and_frete; ?>' checked></center></td>
		</tr>
	  <tr>
			<!--SERVIÇO--><td> <center>E-sedex</center></td>
			<!--PRAZO DE ENTREGA--><td><center><?php echo $prazo_frete2 ?> dias</center></td>
			<!--VALOR DO FRETE--><td><center><?php echo $result_valor_frete2 ?> R$</center></td>
			<!--VALOR TOTAL-->
			<td>
				<center>
					<?php 
					$valor_total2 = $conecta->getTotal();
					$total_and_frete2 = $valor_total2 + $result_valor_frete2; 
					echo number_format($total_and_frete2,2);
					?> R$
				</center>
			</td>
			<!--VALOR TOTAL--><td><center><input type="radio" name='modelo_frete' alt="2" value='<?php echo $total_and_frete2; ?>'></center></td>
		</tr>
  </table>
<?php }elseif($_GET['ac'] == 'frete_gratis'){ ?>
<br />
<h5 style="color:#666; font-family:Verdana, Geneva, sans-serif" align="right"> FRETE GRÁTIS PARA TODA TERESINA!</h5>

<?php } ?>
