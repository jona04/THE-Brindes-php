<?php
require_once('Connections/teresinabrindes.php');

//recebe o coteudo da pagina via parametro get
if(isset($_GET['c'])){
	$c = $_GET['c'];
}
//envia email
//if(isset($_GET['envia']) && $_GET['envia'] == 'envia_email'){
if(isset($_POST['nome_contato'])){
		
	$nome = $_POST['nome_contato'];
	$email = $_POST['email_contato'];
	$fone = $_POST['fone_contato'];
	$msg = $_POST['msg'];
	
	$var = "<script>javascript:history.back(-1)</script>";

	$arroba = '@';
	//função para ver se existe arroba no email
	$email_validado = stripos($email,$arroba);
	//valida formuilario contato
	if($nome == '' || $email == '' || $fone == '' || $msg == ''){
		echo '<script>alert("Por favor preencha todos os campos.")</script>';
		echo $var;
	}elseif($email_validado === false){
		echo '<script>alert("Por favor informe um e-mail válido.")</script>';
		echo $var;
	}else{
	$emailsender2 = "teres387@teresinabrindes.com.br";
	
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
	$Titulo2="Contato pelo site! Teresina Brindes";
	
	$mensagem2 =   "Nome: $nome <br />
					Email: $email <br />
					Fone: $fone <br />
					Mensagem: $msg
						";
		
		
		/* Enviando a mensagem */
		if(mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2)){
		echo '<script>alert("Mensagem enviada com sucesso.")</script>';	
		//header('Location: index.php');
		}
	}//fim else formulario válido
}//fim if envia mensagem	

$menu_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);

$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);

$query_new_produtos_index = "SELECT * FROM produtos ORDER BY pro_id DESC";
$query_limit_new_produtos_index = "$query_new_produtos_index LIMIT 0, 12";
$new_produtos_index = mysql_query($query_limit_new_produtos_index) or die(mysql_error());
$row_new_produtos_index = mysql_fetch_assoc($new_produtos_index);
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
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title><?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->

<br class="cancela" />

<div id="fundo_container">
<div class="container">

<?php include "news_conteudo_lateral.php"; ?>
 
<div class="conteudo">

<?php if(isset($c) && $c=='e'){?>
<div id="centraliza_infoempresa" style="width:600px; margin-left:auto; margin-right:auto;">
        <div id="titulo_maior_info" class="arredonda_empresa">
            <div class="img_vitrine3"></div>
			<p class="titulo2">Empresa</p>   
        </div><!-- fim titulo menu categoria -->
        <br />
        <div id="empresa_principal">
            <p class="titulo_empresa">Quem Somos</p>
            <p id="texto_empresa">
            A Teresina Brindes é uma empresa de serviços que atua no segmento de comunicação visual e brindes personalizados.
            <br />
            <br />
            Com profissionalismo e qualidade em seus serviços, está capacitada a fornecer soluções para todas as situações pertinentes a 
            promoções, merchandising, sinalização, brindes e comunicação da sua empresa. Utilizando equipamentos de última geração e equipe altamente 
            qualificada, desenvolve trabalhos com profissionalismo, prazo e qualidade em todos os serviços oferecidos.
            <br />
            <br />
            Sabemos que a Comunicação Visual deve ser levada a sério e por isso investimos em uma equipe e estrutura que venha a atender 
            nossos clientes e parceiros de forma especial e diferenciada, sempre com qualidade e a melhor relação custo benefício. 
            </p>
        </div>
        <div id="empresa_missao">
            <p class="titulo_empresa">Missão</p>
            <p id="texto_empresa">
            Ser referência em comunicação visual, brindes e prestação de serviços no setor, desenvolvendo um trabalho inovador, com qualidade, 
            respeito, e superando as expectativas dos mais exigentes.
            </p>
        </div>
        <div id="empresa_visao">
            <p class="titulo_empresa">Visão</p>
            <p id="texto_empresa">
            Solucionar e realizar todo e qualquer projeto prezando a qualidade, a eficiência e o profissionalismo que o mercado exige e merece.  
            </p>
        </div>
</div>
<?php }else if(isset($c) && $c=='l'){?>
<div id="centraliza_infoempresa" style="width:600px; margin-left:auto; margin-right:auto;">
        <div id="titulo_maior_info">
			<div class="img_vitrine2"></div>
            <p class="titulo2">Localização</p>   
        </div>
         <div id="endereco">
              <p><strong>Teresina - PI</strong><br />
              Rua Dr. Area Le&atilde;o, 735, Centro - Norte<br />
              Tel: 3221-0215 </p>
         </div>
         <div id="mapa">
            <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.br/maps?hl=pt-BR&amp;ie=UTF8&amp;q=invista+publicidade&amp;fb=1&amp;gl=br&amp;hq=invista+publicidade&amp;hnear=Teresina+-+Piau%C3%AD&amp;t=m&amp;ll=-5.083293,-42.81179&amp;spn=0.014961,0.018239&amp;z=15&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com.br/maps?hl=pt-BR&amp;ie=UTF8&amp;q=invista+publicidade&amp;fb=1&amp;gl=br&amp;hq=invista+publicidade&amp;hnear=Teresina+-+Piau%C3%AD&amp;t=m&amp;ll=-5.083293,-42.81179&amp;spn=0.014961,0.018239&amp;z=15&amp;source=embed" style="color:#0000FF;text-align:left">Exibir mapa ampliado</a></small>
         </div>
</div>
<?php } elseif(isset($c) && $c=='c'){?>
<div id="centraliza_infoempresa" style="width:600px; margin-left:auto; margin-right:auto;">
        <div id="titulo_maior_info" class="arredonda_contato">
			<div class="img_vitrine4"></div>
           <p class="titulo2">Contato</p> 
       	</div><!-- fim titulo menu categoria -->
            <br />
    	<div id="conteudo_contato">
        	<form class="form_contato" action="infoEmpresa.php?c=c" method="post" id="form_validado">
        	<p class="p_contato">
			  <label class="l_contato" for="nome_contato">Nome</label><br />
        	  <input class="i_contato" type="text" name="nome_contato" id="nome_contato">
            </p>
            <p class="p_contato">
			  <label class="l_contato" for="email_contato">Email</label><br />
			  <input class="i_contato" type="text" name="email_contato" id="email_contato">
			</p>            
            <p class="p_contato">
			  <label class="l_contato" for="fone_contato">DDD + Fone </label><br />
			  <input class="i_contato" type="text" name="fone_contato" id="fone_contato">
			</p>        
           <p class="p_contato">
			  <label class="l_contato" for="msg">Sua mensagem</label><br />
			  <textarea class="t_contato" name="msg" id="msg" cols="50" rows="5" ></textarea>
			</p>                 
          <br />
          <p class="p_contato">
          	<input id="envia_contato" type="submit" class="novo-botao-verde2" value="Enviar" />
          </p>

		</form>
    
        </div><!-- fim div conteudo contato-->
    
    
    
    <div class="direita-contato">
                <p class="text-contato">&#8226; Entre em contato por telefone: 86 3221-0215  </p>
                <p class="text-contato">&#8226; Entre em contato por e-mail: <a href="mailto:contato@teresinabrindes.com.br">contato@teresinabrindes.com.br</a>  </p>
                <p class="text-contato">&#8226; Ou se preferir nos adicione no MSN/SKYPE: <a href="mailto:atendimento@hotmail.com"> teresinabrindes@hotmail.com</a> | Estamos online de segunda à sexta das 8h às 18h  </p>
   

    
           </div><!-- direita-contato -->
           
               
</div>
<?php } ?>    
	<br class="cancela" />    

</div> <!-- fim div conteudo -->
        
</div> <!-- fim div container -->
    
	<br class="cancela" />
</div><!--fim div fundo container -->



<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>

</body>
</html>