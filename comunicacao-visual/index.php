<?php
//ob_start("ob_gzhandler");
require_once('../Connections/teresinabrindes.php');
include "../anti-injection.php";

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

$url = $_GET['url']; 
$urlE = explode('/', $url);

$arquivo = $urlE['1'];

//recebe o id do produto de comunicação visual
//$id_cat = $_GET['cv'];


$menu_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);

$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);


$query_conteudo_cv = "SELECT * FROM categorias_cv WHERE catcv_url_seo = '$arquivo'";
$conteudo_cv = mysql_query($query_conteudo_cv) or die(mysql_error());
$num_rows_cv = mysql_num_rows($conteudo_cv);
$row_conteudo_cv = mysql_fetch_assoc($conteudo_cv);

$catcv_nome = $row_conteudo_cv['catcv_nome'];
$catcv_conteudo = $row_conteudo_cv['catcv_conteudo'];
$catcv_imagem= $row_conteudo_cv['catcv_imagem'];

//envia email
if(isset($_GET['ac']) && $_GET['ac'] == 'envia'){
//if(isset($_POST['nome'])){
	
	$nome = anti_sql($_POST['nome']);
	$email = anti_sql($_POST['email']);
	$fone = anti_sql($_POST['fone']);
	$msg = anti_sql($_POST['msg']);
	$nome_cv = anti_sql($row_conteudo_cv['catcv_nome']);
	$data = date("d/m/Y");

	//volta 1 pagina no historico
	$var = "<script>javascript:history.back(-1)</script>";
	
	$arroba = '@';
	//função para ver se existe arroba no email
	$email_validado = stripos($email,$arroba);
	
	if($nome == '' || $email == '' || $fone == '' || $msg == ''){
		echo "<script>alert('Por favor preencha todos os campos')</script>";
		echo $var;
	}elseif($email_validado === false){
		echo '<script>alert("Por favor informe um e-mail válido.")</script>';
		echo $var;	
	}else{
		$emailsender2 = "contato@teresinabrindes.com.br";
		
		// Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
		if(PHP_OS == "Linux") $quebra_linha2 = "\n"; //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha2 = "\r\n"; // Se for Windows
		else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
		
			/* Montando o cabeçalho da mensagem */
		$headers2 = "MIME-Version: 1.1".$quebra_linha2;
		$headers2 .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha2;
		// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
		$headers2 .= "From: ".$emailsender2.$quebra_linha2;
		$headers2 .= "Return-Path: " . $emailsender2 . $quebra_linha2;
		
		$Destinatario2="contato@teresinabrindes.com.br";
		$Titulo2="Orçamento comunicação visual! Teresina Brindes";
		
		$mensagem2 =   "Nome: $nome <br />
						Email: $email <br />
						Fone: $fone <br />
						Categoria comunicação visual: $nome_cv <br />
						Mensagem: $msg
						";
		
		
		/* Enviando a mensagem */
		//mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2);
		if(mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2)){

		//adicona no banco
		$add_orc = mysql_query("INSERT INTO orcamento_cv (orcv_nome, orcv_email,orcv_fone, orcv_msg, orcv_data)	VALUES('$nome', '$email','$fone','$msg','$data')") or die(mysql_error()); //insere os campos na tabela
					
		echo '<script>alert("Mensagem enviada com sucesso.")</script>';		
		}
	}
}//fim if envia mensagem	

//pega paramento da url que vem depois do / para direcionar para a devida pagina
$url = $_GET['url']; 
$urlE = explode('/', $url);

$arquivo = $urlE['0'];

//$post     = $urlE['1'];
$query_conteudo_cv = "SELECT * FROM categorias_cv WHERE catcv_url_seo = '$arquivo'";
$conteudo_cv = mysql_query($query_conteudo_cv) or die(mysql_error());
$row_conteudo_cv = mysql_fetch_assoc($conteudo_cv);
?>
<!DOCTYPE html>
<head>
<meta name="description" content="<?php echo $row_conteudo_cv['catcv_tag_descricao']; ?>" />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'pt-BR'}
</script>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<script type="text/javascript" src="../js/tudo.js"></script>
<script type="text/javascript" src="../js/jquery.livequery.js"></script>
<script type="text/javascript" src="../js/jquery.corner.js"></script>
<script type="text/javascript" src="../js/jquery.marquee.js"></script>
<script type="text/javascript" src="../js/jquery.masked.js"></script>
<script type="text/javascript" src="../js/jquery.infieldlabel.js"></script>
<script type="text/javascript" src="../js/jquery.infieldlabel.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script src="../js/slides.min.jquery.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	
	$(function() {
	//$('.mask-data').mask('99/99/9999'); //data
	//$('.mask-hora').mask('99:99'); //hora
	$('.mask-fone').mask('(99) 9999-9999'); //telefone
	
	});
});
</script>

<?php include "../analytics.php"; ?>


<?php include "../favicon.php"; ?>

<link href='<?php get_home(); ?>/estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="<?php get_home(); ?>/css/style.css" type="text/css" media="screen" />
<title><?php include "../titulo.php"; ?> - <?php echo $row_conteudo_cv['catcv_nome']; ?> - Brindes e Comunicação Visual</title>
</head>


<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "../news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />

<div id="fundo_container">
<div class="container">

<?php include "../news_conteudo_lateral.php"; ?> 

<div class="conteudo">

<?php
//$paginas  = array('empresa','contato','localizacao');

/*if(isset($arquivo) && in_array($arquivo, $paginas)){
	include "$arquivo.php";
}elseif(isset($arquivo) && $arquivo == ''){
	include "news_home.php";
}else{
	?> <p align='center'> <?php echo "Opsssss! Sua pagina não pode ser encontrada."; ?> </p> <?php
}*/

if($num_rows_cv == 0 || $arquivo == ''){
	?> <p align='center'> <?php echo "Opsssss! Sua pagina não pode ser encontrada.."; ?> </p> <?php
}else{
?>


        <div id="container_conteudo_produtos">
        	<div class="barra-cv" align="center">
            <h1><?php echo $catcv_nome; ?></h1>
            </div> <!-- fim div barra-cv -->
        
        <div class="banner-cv" style="background-image:url(../admin/<?php echo $catcv_imagem; ?>); width:554px; height:149px; background-repeat:no-repeat; margin: 10px auto 0 auto;">
        <!--<p><img src="admin/<?php// echo $row_conteudo_cv['catcv_imagem']; ?>" alt="<?php// echo $row_conteudo_cv['catcv_nome']; ?>"  /></p> --> 
        </div>
        
        <div class="conteudo-cv"> 
        <h2><?php echo $catcv_conteudo; ?></h2>
        </div>
<!--
        <center>
        <form id="contactform_cv" class="rounded" method="post" action="../comunicacao_visual?cv=<?php echo $_GET['cv']; ?>">
<h5 class="nomes_cv">Solicite um orçamento </h5>
 
<div class="field_cv">
    <label class="nomes_cv" for="name">Nome:</label>
    <input type="text" class="input_cv" name="nome" id="nome" />
    <p class="hint_cv">Entre com seu nome.</p>
</div>
 
<div class="field_cv">
    <label class="nomes_cv" for="e-mail">Email:</label>
    <input type="text" class="input_cv" name="email" id="email" />
    <p class="hint_cv">Entre com seu e-mail.</p>
</div>

<div class="field_cv">
    <label class="nomes_cv" for="fonee">Fone:</label>
    <input type="text" class="mask-fone" name="fone" id="fone_cv" />
    <p class="hint_cv">Entre com seu telefone. DDD + número</p>
</div>
 
<div class="field_cv">
    <label class="nomes_cv" for="message">Mensagem:</label><br>
    <textarea style="width:400px; height:50px;" class="input textarea_cv" name="msg" id="msg">
    
    </textarea>
    <p class="hint_cv">Escreva sua mensagem.</p>
	</div>
 <br>
<input type="submit" name="Submit"  class="novo-botao-verde2" value="Enviar" />
<input type="reset" name="reset"  class="novo-botao-vermelho2" value="Limpar" />
</form>
        </center> 
    -->
      </div> <!-- fim div container_conteudo_produtos --> 
      
<?php } //fim if existe produto ?>  

</div> <!-- fim div conteudo -->
    
	<br class="cancela" />
</div><!--fim div container -->
</div><!-- fim div fundo container-->
<div class="rodape">
  <?php include "../news_rodape.php"; ?>
</div>
</body>
</html>
