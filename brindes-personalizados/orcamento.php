<?php
//ob_start("ob_gzhandler");
include 'db.php';
include "../anti-injection.php";

//pega paramento da url que vem depois do / para direcionar para a devida pagina
$url = $_GET['url']; 
$urlE = explode('/', $url);

echo $arquivo = $urlE['0'];
echo 'oi';

$pasta = "imagens/";
	
//verifica se existe subcatid valido e cat valido
if (isset($_GET['subcatid'])){
$verifica_subcatid = mysql_query("SELECT * FROM subcategorias_brindes WHERE subcat_id='".$_GET['subcatid']."'") or die(mysql_error());
$cont_subcatid = mysql_num_rows($verifica_subcatid);
$result_subcat = mysql_fetch_assoc($verifica_subcatid);
}
if (isset($cont_subcatid)){
$verifica_catid = mysql_query("SELECT * FROM categorias_brindes WHERE cat_id='".$_GET['cat']."'") or die(mysql_error());
$pega_cat = mysql_fetch_assoc($verifica_catid);
$cont_catid = mysql_num_rows($verifica_catid);
}


$nome_div_papel =  $result_subcat['subcat_div'];
$subcat_produto =  $result_subcat['subcat_id'];

//para carrocel de produtos relacionados
$query_new_produtos2 = "SELECT * FROM subcategorias_brindes ORDER BY rand()";
$new_produtos2 = mysql_query($query_new_produtos2) or die(mysql_error());


//PASTA DAS IMAGENS para paginação
$dir = ("../admin/imagens/subcategoria/".$nome_div_papel."/miniaturas/");
if(is_dir($dir)){
	$abrir = opendir($dir);
}
//PASTA DAS IMAGENS para IMAGEM PRINCIPAL
$dir2 = ("../admin/imagens/subcategoria/".$nome_div_papel."/");
if(is_dir($dir2)){
	$abrir2 = opendir($dir2);
}

//$arquivos = array();

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
<meta name="description" content="<?php echo $result_subcat['subcat_tag_descricao']; ?>" />
<meta name="keywords" content="<?php echo $result_subcat['subcat_tags']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- inicializa com o google olhar artigo -http://encosia.com/3-reasons-why-you-should-let-google-host-jquery-for-you/- -->
<!-- <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script> -->

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
 
<script type="text/javascript" src="../app/js/tudo.js"></script>
<script type="text/javascript" src="../js/jquery.masked.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.session.js"></script>

<!-- script para rodas o carrocel dos produtos relacionados -->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>

<!-- resposavel pela galeria de imagens do produto -->
<script type="text/javascript" src="../app/js/slides.min.jquery.js"></script>


<script type="text/javascript">

//exemplo para só aparecer o icone de enviar arquivo quando a pagina estiver carregada
//jQuery(document).ready(function(){
//jQuery('body').hide();
//});
//window.onload=function(){jQuery('body').show();};

$(document).ready(function(){
	
	$(function() {
	$('.mask-qtd').mask('9999'); //quantidade
	$('.mask-fone').mask('(99) 9999-9999'); //telefone
	
	});
	//PAGINATAÇÃO
	//roda slides das imagens dos produtos

	$('.li_pag').click(function(){

		var end_img = $(this).attr('id');	
		
		$('#img_pagination_orc').attr("src", end_img);
		return false;
	});

	//valida o formulario da qunatidade
	function verificaNumero(e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            }
	//valida o formulario da quantidade
	$("#qtdProduto").keypress(verificaNumero);



	// fazemos com que todas as imagens da lista possam ser arrastadas
	$("#img_pagination_orc").draggable({
		revert:'invalid'
	});
	// a área do "papel" será onde os itens podem ser soltos
	$('#fundo_orcamento').droppable({
			//quando eu clicar na imagem arrastavel
			activate: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel estiver dentro do papel
			over: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel sair do papel
			out: function(event, ui) { 
				$(this)
				.css('backgroundColor', '#FF9D9D');
			},			
			// quando soltar um item no "papel"...
			drop: function(evt, ui){
				// referencia ao "papel", mais curta
				var t = $(this);
				// retorna o elemento arrastado
				var e = ui.draggable;
				// colocamos o elemento arrastado no papel
				e.appendTo(t);
			}
		});//fim funcção droppable




});						
</script>

<link rel="shortcut icon" href="../favicon.ico" />
<link href='../estilo.css' rel='stylesheet' type='text/css' media="screen" />
<!-- responsavel pelo estilo do carrocel de produtos relacionados -->
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />

<!-- estilo do aplicativo -->
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />

<title><?php echo $result_subcat['subcat_nome']; ?> - THE brindes - Comunicação Visual e Brindes Personalizados</title>
</head>
<body>
 
<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo_personaliza.php"; ?>
<!--FIM DO TOPO-->
                
                
<div id='msg_erro' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px; display:none; padding-top:5px;">
<p>Por favor, antes de continuar informe a quantidade desejada.</p>
</div>
<div id='msg_erro2' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px; display:none; padding-top:5px;">
<p>Essa quantidade não é permitida, por favor tente novamente.</p>
</div>
 <br class="cancela" />
<?php if($browser=='IE'){?>
<!-- concerta erro no IE do mapa topo ficar muito emcima do menu topo -->
<br />
<?php } ?>
  			<div class="mapa-topo"><p style="font-size:10px; color:#333;">Você está aqui: <a href="index.php">Teresina Brindes</a> > <a href="../produtos_brindes.php?id=<?php echo $_GET['cat'];?>"><?php echo $pega_cat['cat_nome'];  ?></a> > <?php echo $result_subcat['subcat_nome']; ?></p>
            </div>

 <div id="content"> 





<div id="area_personaliza">
        
    <p class="titulo_personalize">Preencha o formulário!</p>
    
    <div class="botoes-app">
		<form action="orcamentoen.php" class="form_orcamento_brindes" enctype="multipart/form-data" method="post" name="form_cont_brindes" >
        <div class="bt-meio-orcamento">
            <div style="padding-top:15px;">
            <p class="text-menu-produto3">Nome:&nbsp; </p>
              <input type="text" name="nome_orc" size='20' style="margin-top:-10px;width:198px;">
            </div>

            <div style="padding-top:15px;">
            <p class="text-menu-produto3">Email:&nbsp; </p>
              <input type="text" name="email_orc" size='20' style="margin-top:-10px;width:200px;">
            </div>

            <div style="padding-top:15px;">
            <p class="text-menu-produto3">Telefone:&nbsp; </p>
              <input type="text" class='mask-fone' name="tel2_orc" size='20' style="margin-top:-10px;width:168px;">
            </div>
                        
            <div style="padding-top:15px;">
            <p class="text-menu-produto3">Quantidade:&nbsp; </p>
             <?php 
			 if($urlE == 'agenda-personalizada-2015'){
			 //if($result_subcat['subcat_id'] == 163) {?>
             	
                <input type="radio" name="qtd_orc" value="1"> 1<br>
                   <input type="radio" name="qtd_orc" value="5"> 5<br>
                    <input type="radio" name="qtd_orc" value="10"> 10<br>
                     <input type="radio" name="qtd_orc" value="20"> 20<br>
                      <input type="radio" name="qtd_orc" value="50"> 50<br>
                <input type="radio" name="qtd_orc" value="100"> 100<br>
                 <input type="radio" name="qtd_orc" value="200"> 200<br>
                 <input type="radio" name="qtd_orc" value="500"> 500<br>
                  <input type="radio" name="qtd_orc" value="1000"> 1000<br>
             
             <?php }else{?>
              <input type="text" class='mask-qtd' name="qtd_orc" size='18' style="margin-top:-10px;width:74px;">
              <?php } ?>
            </div>
            <input type="hidden" name="produto_orc" value="<?php echo $result_subcat['subcat_nome']; ?>" >
            <input type="hidden" name="cat_orc" value="<?php echo $pega_cat['cat_nome']; ?>" >
            <input type="hidden" name="detalhe_orc" value="<?php echo $result_subcat['subcat_detalhe']; ?>" >
        </div><!-- FIM BT MEIO Orcamento-->            	

        <div class="bt-comprar">
            <div class="posicao-comprar">
            <input type="submit" name="envia" value="Enviar orçamento!" class="novo-botao-verde2">
            <!-- <a class="novo-botao-verde2" id='btnSalvar' href="#">Enviar</a> -->
            </div>
        </div>
                    <!--FIM BT-COMPRAR-->
	</form>
	</div><!-- fim div botoes -->
     
</div><!-- fim div area_personaliza -->
<br>
<p align="center" style="font-family: Verdana, Geneva, sans-serif; font-size:15px; color:#666; ">Arraste a imagem para visualiza-la melhor</p>
                  <div id="fundo_orcamento">
					<center>
                    
                    <img id='img_pagination_orc' src="<?php $aux=0; foreach (glob($dir2."*") as $file2){ $aux++; if (($file2 != '.') && ($file2 != '..') && $aux == 1){echo $file2;}} ?>" alt="">
                    
                    </center>
                  </div><!-- fim div fundo almofada quadrada -->
                  <br class="cancela" />
                 
                <!--  lista de elementos que servem para o usuario compor a nova imagem -->

    <div class="img_produtos">
		<div id="products2">
            <ul class="pagination2">
                <?php
               /* //LOCALIZA APENAS AS IMAGENS
                foreach (glob($dir."*") as $file)
                {
                    if (($file != '.') && ($file != '..'))
                    {

                            //$arquivos[] = $file;
                echo "<li id=\"$file\" class='li_pag'><a href=\"#\"><img src=\"$file\" height=\"55\" width=\"55\" border=\"0\" alt=\"1144953 1 2x\"></a></li>";
                    }
                }*/
				
				//LOCALIZA APENAS AS IMAGENS QUE INICIAM COM p
                foreach (glob($dir."*") as $file)
                {
                    if (($file != '.') && ($file != '..'))
                    {
						
						$nome_imagem = end(explode('/', $file));
						$pasta_imagem2 = "../admin/imagens/subcategoria/".$nome_div_papel."/".$nome_imagem;
                        //$arquivos[] = $file;
                		echo "<li id=\"$pasta_imagem2\" class='li_pag'><a href='#'><img src='$file' height='55' width='55' border='0' alt='imagem miniatura' title='$subcat_nome'></a></li>";
                    }
                }   
                ?>
            </ul>
        </div> 
   </div>
           
   <br class="cancela" />    


</div><!-- fim div content --> 
<br class="cancela" />
<div id="centraliza_content" style="width:1024px; margin:0 auto 0 auto;">
    <div class="descricao-produto">
    <br />
       <div  align="center" class="informacoes-produto">INFORMAÇÕES DO PRODUTO </div>
				
				<?php echo $result_subcat['subcat_detalhe']; ?>
               
   </div>
   		
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