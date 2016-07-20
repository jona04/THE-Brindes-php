<?php
ob_start("ob_gzhandler");
require_once('Connections/teresinabrindes.php');

$menu_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);

$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);

?>
<!DOCTYPE html>
<head>
<meta name="description" content="Devolução e troca de produtos na empresa THE Brindes comunicação visual." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'pt-BR'}
</script>

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
<script src="js/slides.min.jquery.js"></script>

<?php include "analytics.php"; ?>
<?php include "favicon.php"; ?>

<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title><?php include "titulo.php"; ?> - Devolução e Trocas - Brindes e Comunicação Visual</title>
</head>

<body>
<div class="feedback"><a href="https://docs.google.com/spreadsheet/embeddedform?formkey=dGNBOE8wYzVTSnRxc0xRN2ZrN1JqdVE6MQ" target="_blank">D&ecirc; sua Opni&atilde;o!</a></div>


<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />

<div id="fundo_container">
	<div class="container">

		<?php include "news_conteudo_lateral.php"; ?> 

		<div class="conteudo">


			<div id="centraliza_infoempresa" style="width:820px;">
            <div class="barra-cv" align="center">
                        <h3>Privacidade e Segurança</h3>
                        </div> <!-- fim div barra-cv -->
				<br />

				<div id="conteudo_troca_dp">
					<h3 class="titulo_troca_dp">Política de Trocas</h3><br />

					<p id="texto_troca_dp">
					<strong>Todas as suas solicitações devem ser realizadas diretamente ao Serviço de Atendimento ao Cliente.</strong>
					</p>
					<br><br>
					
					<p id="texto_troca_dp">
					-Situações em que <strong>NÃO</strong> serão efetuadas trocas e devoluções de mercadorias: 
					<br><br>
					<strong style="color:#999;">&#8226;Erros Cadastrais</strong><br> 
					</p>
					<br>
					<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					O Cliente tem toda a responsabilidade de informar de forma correta seus dados cadastrais. No caso de problemas na entrega por esse motivo, o custo do reenvio será pago pelo cliente.
					</p>
					<br>
					
					<p id="texto_troca_dp">-Situações em que <strong>SERÃO</strong> efetuadas trocas e devoluções de mercadorias:
					<br><br>
					<strong style="color:#999;">&#8226;Defeito de fabricação</strong><br> 
					</p>
					<br>
					<p id="texto_troca_dp">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Todos os produtos vendidos pela Teresina Brindes, passam por uma rigorosa análise de qualidade antes de serem postados e enviados para você. Mesmo Assim, sendo detectado qualquer tipo de defeito de fabricação, a troca deve ser solicitada dentro do prazo de 7 (sete) dias corridos, contados a partir da data do recebimento das mercadorias e de acordo com as condições abaixo descritas:
					<br><br> 
					</p>

					<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Entre em contato com a nossa central de atendimento, através do e-mail:
					<br>
					<a href="mailto:contato@teresinabrindes.com.br">contato@teresinabrindes.com.br</a> ou telefone (086) 3221-0215 , 				informando o defeito detectado, e declarando o interesse em devolução ou troca do produto. Informe também seu nome, telefone e email.	</p> 
					<br><br>
				
				</div>
			
				<br>
				<div id="conteudo_troca_dp">
                <br>
					<p id="texto_troca_dp"><strong>Importante !</strong>
					<br><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se por alguma eventualidade houver atraso na entrega e for constado que o produto já encontra-se fora dos depósitos da empresa Teresina Brindes, uma reclamação será aberta junto aos correios para sabermos o motivo do atraso.</p>
					<br>

					<p id="texto_troca_dp">-Recuse o recebimento do produto e entre em contato com o Serviço de Atendimento ao Cliente, caso constate alguma das situações abaixo:</p>
					<br>
					<p id="texto_troca_dp">
					•	Produto avariado no transporte;<br>
					•	Embalagem violada;<br>
					•	Ecessórios ou itens faltantes;<br>
					•	Produto em desacordo com o pedido.<br>
					</p>
					<br><br>
				</div>
				  
			</div><!-- fim div centraliza_infoempresa -->	 
					  
		</div> <!-- fim div conteudo -->
			<br class="cancela" />
	</div> <!-- fim div fundo container -->
</div><!-- fim div fundo container -->
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>
