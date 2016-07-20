<?php
ob_start("ob_gzhandler");
date_default_timezone_set('America/Sao_Paulo'); 
require_once('Connections/teresinabrindes.php');

//url amigavel
//include "config.php";

//if(!isset($_GET['beta'])){
	//header("location:thebrindes/");
//}


//if(isset($_GET['ac']) &&  $_GET['ac'] == 'newsletter' ){
if(isset($_POST['email_letter'])){	
	$arroba = '@';
	$letter_email = $_POST['email_letter'];
	$letter_nome = $_POST['nome_letter'];
	$letter_data = date("d-m-Y");
	//função para ver se existe arroba no email
	$email_validado = stripos($letter_email,$arroba);
	
	$qr_letter = mysql_query("SELECT * FROM newsletter WHERE letter_email = '$letter_email'") or die(mysql_error());
	$linhas_letter = mysql_num_rows($qr_letter);
	if($linhas_letter > 0){
		$email_validado = 'ja-existe';
	}
	if($email_validado == 'ja-existe'){
		echo '<script>alert("Ops! seu email já foi cadastrado.")</script>';
	}elseif($email_validado === false){
		echo '<script>alert("Ops! seu e-mail não possui um formato válido tente novamente.")</script>';	
	}elseif($letter_email == ''){
		echo '<script>alert("Ops! preencha o campo e-mail e tente novamente.")</script>';	
	}elseif($letter_nome == ''){
		echo '<script>alert("Ops! preencha o campo nome e tente novamente.")</script>';	
	}else{
	$insere_news = mysql_query("INSERT INTO newsletter (letter_nome, letter_email,letter_data) VALUES ('$letter_nome','$letter_email','$letter_data')");
		echo '<script>alert("Parabéns! Seu e-mail acaba de ser cadastrado.")</script>';	
	}
}

$menu_cv = "SELECT * FROM categorias_cv WHERE catcv_exibir = 0 ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);

$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);

//pega paramento da url que vem depois do / para direcionar para a devida pagina
$url = $_GET['url']; 
$urlE = explode('/', $url);

$arquivo = $urlE['0'];
$post     = $urlE['1'];

//verifica se existe categira na url
if(isset($arquivo)){
$verifica_catid = mysql_query("SELECT * FROM categorias_brindes WHERE cat_url_seo='$arquivo'") or die(mysql_error());
$row_categorias = mysql_fetch_assoc($verifica_catid);
$cont_catid = mysql_num_rows($verifica_catid);
}
?>
<!DOCTYPE html>
<!-- Este site possui marcação de microdados adicionada para dados estruturados do Google. -->
<head>
<meta name="description" content="<?php 
$paginas  = array('empresa','contato','localizacao');

//get s é a busca
if(isset($_GET['s']) && $_GET['s'] != ''){
	echo $_GET['s']." personalizado ou impresso para você ou sua empresa. Produzimos também qualquer tipo de brinde personalizado além de banner, fachadas e adevisos para sua empresa - THE Brindes.";
}elseif(isset($arquivo) && ($arquivo == 'empresa')){
	echo 'Saiba mais Informações sobre a empresa THE Brindes, uma empresa de comunicação visual e brindes personalizados.';
}elseif(isset($arquivo) && ($arquivo == 'localizacao')){
	echo 'Localize a THE Brindes uma empresa de comunicação visual e brindes personalizados.';
}elseif(isset($arquivo) && ($arquivo == 'contato')){
	echo 'Entre em Contato com a THE Brindes uma empresa de comunicação visual e brindes personalizados.';
}elseif(isset($arquivo) && $arquivo == ''){
	echo 'THE Brindes, uma empresa de comunicação visual e brindes personalizados. Fornecemos qualquer tipo de brinde para todo o Brasil, faça já seu orçamento.';
}elseif(isset($arquivo)){
	echo $row_categorias['cat_nome']. ' personalizado(a) ou impresso para você ou sua empresa. Produzimos também qualquer tipo de brinde personalizado além de banner, fachadas e adevisos para sua empresa - THE Brindes.';
}

?>
" />
<meta name="keywords" content="empresa comunicação visual, comunicação visual em teresina,brindes em teresina,brindes empresas,banner em teresina, brindes infantil, brindes promocionais, lembranças infantil personalizadas" />
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
<script type="text/javascript" src="js/slides.min.jquery.js"></script>
<?php include "analytics.php"; ?>


<script type="text/javascript">

$(document).ready(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 7000,
				pause: 2000,
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
<link href='<?php get_home(); ?>/estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="<?php get_home(); ?>/css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php get_home(); ?>/css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php get_home(); ?>/css/style.css" type="text/css" media="screen" />
<title>
<?php 
$paginas  = array('empresa','contato','localizacao');


//get s é a busca
if(isset($_GET['s']) && $_GET['s'] != ''){
	echo 'THE Brindes - '.$_GET['s'];
}elseif(isset($arquivo) && ($arquivo == 'empresa')){
	echo 'Empresa - THE Brindes - Comunicação Visual e Brindes Personalizados no piauí';
}elseif(isset($arquivo) && ($arquivo == 'localizacao')){
	echo 'Localização - THE Brindes - Comunicação Visual e Brindes Personalizados no paiuí';
}elseif(isset($arquivo) && ($arquivo == 'contato')){
	echo 'Contato - THE Brindes - Comunicação Visual e Brindes Personalizados no piauí';
}elseif(isset($arquivo) && $arquivo == ''){
	echo 'THE Brindes - Comunicação Visual e Brindes Personalizados no piauí';
}elseif(isset($arquivo)){
	echo $row_categorias['cat_nome'].' personalizado(a) Comunicação Visual e Brindes no piauí';
}

?>
</title>
</head>

<body>
<div class="feedback"><a href="https://docs.google.com/forms/d/1fbE8-ur1tGRhDZsZ2ddR5XcjCaDkJPmt68pemrUuijs/viewform" target="_blank">D&ecirc; sua Opni&atilde;o!</a></div>


<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<?php
if(isset($arquivo) && $arquivo == ''){
	include "news_banner_index.php"; 
}
?>

<br class="cancela" />

<div id="fundo_container">
<div class="container">

<?php include "news_conteudo_lateral.php"; ?> 

<div class="conteudo">

<?php

$paginas  = array('empresa','contato','localizacao');

//get s é a busca
if(isset($_GET['s']) && $_GET['s'] != ''){
	include "search.php";
}elseif(isset($arquivo) && in_array($arquivo, $paginas)){
	include "$arquivo.php";
}elseif(isset($arquivo) && $arquivo == ''){
	//echo '<script>alert("Olá, o site da THE Brindes está em manutenção. Logo Logo voltaremos ao normal.")</script>';	
	include "news_home.php";
}elseif($cont_catid > 0 && isset($post)){
	?> <p align='center'> <?php echo "Opsssss! Sua pagina não pode ser encontrada...."; ?> </p> <?php
}elseif($cont_catid > 0){
	$pro_cat_id = $row_categorias['cat_id'];
	include "news_produtos_brindes.php";
}else{
	?> <p align='center'> <?php echo "Opsssss! Sua pagina não pode ser encontrada.."; ?> </p> <?php
}
?>
        
</div> <!-- fim div conteudo -->
 
	<br class="cancela" />
</div><!--fim div container -->
</div><!-- fim div fundo container-->
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>