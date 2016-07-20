<?php
include 'db.php';
include '../config.php';
$pasta = "imagens/";
include '../anti-injection.php';

if(!isset($_POST['nome_orc'])){
	header('location: ../index.php');
}

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

//para carrocel de produtos relacionados
$query_new_produtos2 = "SELECT * FROM subcategorias_brindes ORDER BY rand()";
$new_produtos2 = mysql_query($query_new_produtos2) or die(mysql_error());

if(isset($_POST['nome_orc'])){
	$nome = anti_sql($_POST['nome_orc']);
	$email = anti_sql($_POST['email_orc']);
	$tel2 = anti_sql($_POST['tel2_orc']);
	$qtd = anti_sql($_POST['qtd_orc']);
	$produto = anti_sql($_POST['produto_orc']);
	$categoria = anti_sql($_POST['cat_orc']);
	$detalhe = anti_sql($_POST['obs_orc']);
	$data = date("d/m/Y");
	
	$arroba = '@';
	//função para ver se existe arroba no email
	$email_validado = stripos($email,$arroba);
		
	if($nome == '' || $email == '' || $tel2 == '' || $qtd == ''){
		echo "<script>alert('Por favor preencha os campos obrigatórios.')</script>";
		//volta 1 pagina no historico
		echo "<script>javascript:history.back(-1)</script>";
	}elseif($email_validado === false){
		echo "<script>alert('Por favor informe um email correto.')</script>";
		//volta 1 pagina no historico
		echo "<script>javascript:history.back(-1)</script>";	
	}else{
	
$emailsender2 = "Contato@teresinabrindes.com.br";
		
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
		$Titulo2="Orçamento Brindes para Personalizar! Teresina Brindes";
		
		$mensagem2 =   
			"
				Nome: $nome 
				Email: $email
				Fone2: $tel2 
				Quantidade: $qtd 
				Produto: $produto 
				Observações: $detalhe
			";
		
		
		/* Enviando a mensagem */
		//mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2);
		if(mail($Destinatario2, $Titulo2, $mensagem2)){
		
		//adicona no banco
		$add_orc = mysql_query("INSERT INTO orcamento_brindes (orcbrin_nome, orcbrin_email,orcbrin_telefone, orcbrin_produto, orcbrin_qtd ,orcbrin_data)	VALUES('$nome', '$email','$tel2','$produto','$qtd','$data')") or die(mysql_error()); //insere os campos na tabela
		
		echo '<script>alert("Mensagem enviada com sucesso.")</script>';		
		}	
	}

}//fim if existe post
else{
//		header("location: ../index.php");
}
//identefica o browser
$browser = "";
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
}

if(isset($_SESSION['email_the'])){
	$id_usuario = $_SESSION['id_usu'];
}else{
	$id_usuario = 0;
}
?>
<!DOCTYPE html>
<head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- inicializa com o google olhar artigo -http://encosia.com/3-reasons-why-you-should-let-google-host-jquery-for-you/- -->
<!-- <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script> -->

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
 
<script type="text/javascript" src="js/tudo.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.session.js"></script>

<!-- script para rodas o carrocel dos produtos relacionados -->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>

<link rel="shortcut icon" href="../favicon.ico" />
<link href='../estilo.css' rel='stylesheet' type='text/css' media="screen" />
<!-- responsavel pelo estilo do carrocel de produtos relacionados -->
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />

<!-- estilo do aplicativo -->
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />

<title><?php echo $produto; ?> - Teresina brindes</title>
</head>
<body>
 
<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo_personaliza.php"; ?>
<!--FIM DO TOPO-->

<?php if($browser=='IE'){?>
<!-- concerta erro no IE do mapa topo ficar muito emcima do menu topo -->
<br />
<?php } ?>
<br>
  			<div class="mapa-topo"><p style="font-size:10px; color:#333;">Você está aqui: <a href="index.php">Teresina Brindes</a> > <a href="../produtos_brindes.php?id=<?php echo $_GET['cat'];?>"><?php echo $categoria;  ?></a> > <?php echo $produto; ?></p>
            </div>
            
 <div id="content_orc"> 

<Br>
<br>
<br>
<p align="center" style="color:#666; font-size:16px; font-family:Arial, Helvetica, sans-serif">Olá! Seu orçamento já foi recebido, em até 24h você receberá a resposta no email fornecido.</p> <Br><br><p align="center" style="color:#666; font-size:16px; font-family:Arial, Helvetica, sans-serif">Fique atento e continue comprando.</p>


</div><!-- fim div content --> 
<br class="cancela" />
<div id="centraliza_content" style="width:1024px; margin:0 auto 0 auto;">
   		
<div class="pt-relacionados">

    <div  align="center" class="informacoes-produto">VEJA TAMBÉM OUTROS PRODUTOS</div>
    <div id="ca-container" class="ca-container">
                    <div class="ca-wrapper">	
                        
                        <?php 
                            while($ver_carrocel_produto2 = mysql_fetch_assoc($new_produtos2)){
                                //verifica se item é personalizavel ou nao
                                if($ver_carrocel_produto2['subcat_personalizavel'] == 'Sim'){
                                    $pro_personalizado = true;
                                }else{
                                    $pro_personalizado = false;
                                }
                                
                            ?>
                                                
                        <div class="ca-item ca-item-2">
                            <?php if($pro_personalizado == true ){?>
                            <a href="index.php?cat=<?php echo $ver_carrocel_produto2['subcat_cat_id']; ?>&subcatid=<?php echo $ver_carrocel_produto2['subcat_id'];?>">
                                <div class="ca-item-main">
                                    <div class="ca-icon"><img border='0' src="../admin/<?php echo $ver_carrocel_produto2['subcat_imagem']; ?>" width='150px' /></div>
                                    <label id='titulo_lista_produtos'><?php echo $ver_carrocel_produto2['subcat_nome']; ?></label>
                                    <br />
                                    <span id='titulo_personalize_agora'>Personalize já!</span>
                                    <div class='lista-produtos-vitrine'>
                                        <span style='font-size:11px; text-decoration:none; color:#626262;'><br><br>Por apenas: </span><span style='color:#339900; font-size:20px;'> R$ <?php echo number_format($ver_carrocel_produto2['subcat_preco'],2, ',' , '.');?></span><span style='font-size:11px; text-decoration:none;color: #000;' >
                            <!--<br />ou 12x de R$ " . number_format($result_subcat['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
                                    </div>
                                </div>
                            </a>
                            <?php } else{ ?>
                            <a href="orcamento.php?cat=<?php echo $ver_carrocel_produto2['subcat_cat_id']; ?>&subcatid=<?php echo $ver_carrocel_produto2['subcat_id'];?>">
                                <div class="ca-item-main">
                                    <div class="ca-icon"><img border='0' src="../admin/<?php echo $ver_carrocel_produto2['subcat_imagem']; ?>" width='150px' /></div>
                                    <label id='titulo_lista_produtos'><?php echo $ver_carrocel_produto2['subcat_nome']; ?></label>
                                    <br />
                                    <span id='titulo_personalize_agora'>Faça já seu orçamento!</span>
                                </div>
                            </a>
                            
                            <?php } ?>
                        </div>
                            
                            <?php }
                            
                        ?>
                        
                        
        </div>
    </div>   



		</div><!--FIM PT RELACIONADOS-->  
</div>
<br class="cancela">
<script type="text/javascript">
	//roda as imagens dos produtos relacionados
	$('#ca-container').contentcarousel();
</script>	            
<?php include "../analytics.php"; ?>
<div class="rodape">
  <?php include "../news_rodape.php"; ?>
</div>
</body>
</html>