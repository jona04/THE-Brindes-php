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
<meta name="description" content="Segurança e privacidade da sua compra na empresa THE Brindes comunicação visual." />
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




<script language="JavaScript">

$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
		  
</script>
<?php include "favicon.php"; ?>
<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title><?php include "titulo.php"; ?> - Segurança e Privacidade - Brindes e Comunicação Visual</title>
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
        
    </div><!--fim div conteudo right -->

        <div id="container_conteudo_produtos">
        <div class="barra-cv" align="center">
            <h3>Privacidade e Segurança</h3>
            </div> <!-- fim div barra-cv -->	
           
            <br /><br />
            <div id="conteudo_troca_dp">
            <h4 class="titulo_troca_dp">Política de Privacidade</h4><br />
<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nosso compromisso é respeitar sua privacidade e garantir o sigilo de todas as informações que você nos fornece. Todos os dados cadastrados em nosso site são utilizados apenas para melhorar sua experiência de compra. e mantê-lo atualizado sobre nossas promoções e vantagens oferecidas por empresas parceiras do Grupo Invista.</p>
<br /><br />
<h4 class="titulo-doc">Uso das informações</h4><br />
<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Para seu cadastro, solicitamos informações como nome, cpf, e-mail e telefones para contato, para facilitar suas compras no site.
O seu e-mail é utilizado para divulgar informações de suas compras e, quando solicitado por você, para comunicar promoções de produtos e serviços de empresas do Grupo Invista e suas parceiras. </p>


<br /><br />
<h4 class="titulo-doc">Cookies</h4><br />

<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
No Teresinabrindes.com.br, o uso de cookies é feito apenas para reconhecer um visitante constante e melhorar a experiência de compra. Os cookies são pequenos arquivos de dados transferidos de um site da web para o disco do seu computador e não armazenam dados pessoais. Se preferir, você pode apagar os cookies existentes em seu computador através do browser.</p>

<br /><br />
<h4 class="titulo-doc">Compra segura no Teresinabrindes.com.br</h4><br />
<p id="texto_troca_dp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Nosso site utiliza uma tecnologia avançada de segurança. Todo o tráfego de dados é feito com as informações criptografadas, utilizando-se do certificado SSL (Secure Socket Layer), que é um método padrão usado na Internet para proteger as comunicações entre os usuários da Web e os sites, fornecendo uma compra 100% segura.
As informações de cartões de crédito <strong>NÃO</strong> são armazenadas em nossos sistemas e todo o processo de aprovação é feito diretamente com as Administradoras de Cartões e Bancos <strong>(PagSeguro)</strong>. Para sua tranquilidade, o ícone do cadeado fechado, no canto superior da tela, indica absoluta segurança durante a transmissão de dados em sua compra.
Para sua segurança, se houver qualquer divergência de informações cadastrais e de pagamento, o Teresinabrindes.com.br entrará em contato para confirmar os dados antes de aprovar o pedido.</p>

            
</div>    
           

            <div id="conteudo_produtos">         	  
      </div> <!-- fim div container_conteudo_produtos -->
        
</div> <!-- fim div conteudo -->
	<br class="cancela" />
</div><!--fim div container -->
</div><!-- fim div fundo container-->
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>
