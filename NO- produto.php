<?php
ob_start("ob_gzhandler");
require_once('Connections/teresinabrindes.php');
//id do produto
if(isset($_GET['id'])){
  $pro_id = $_GET['id'];
}else{
$pro_id = 1;
}
//categoria do produto
if(isset($_GET['cat'])){
  $pro_cat = $_GET['cat'];
}else{
$pro_cat = 1;
}


$query_new_produtos = "SELECT p.pro_nome,p.pro_cat_id,p.pro_imagem,p.pro_id,p.pro_subcat_id,p.pro_detalhe,s.subcat_preco,s.subcat_id FROM produtos p, subcategorias_brindes s WHERE p.pro_id = '$pro_id' AND p.pro_subcat_id = s.subcat_id";
$new_produtos = mysql_query($query_new_produtos) or die(mysql_error());
$row_new_produtos = mysql_fetch_assoc($new_produtos);
$pro_imagem = $row_new_produtos['pro_imagem'];

$query_new_produtos2 = "SELECT p.pro_nome,p.pro_cat_id,p.pro_imagem,p.pro_id,p.pro_subcat_id,p.pro_detalhe,s.subcat_preco,s.subcat_id FROM produtos p, subcategorias_brindes s WHERE p.pro_cat_id = '$pro_cat' AND p.pro_id != $pro_id AND p.pro_subcat_id = s.subcat_id";
$new_produtos2 = mysql_query($query_new_produtos2) or die(mysql_error());

// função para retirar acentos e passar a frase para minúscula
function normaliza($string){
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
	$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYobsaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$string = utf8_decode($string);
	$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
	$string = str_replace(" ","-",$string); // retira espaco
	$string = strtolower($string); // passa tudo para minusculo
	return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

//PASTA DAS IMAGENS
$id_produto = $_GET['id'];
$produto = mysql_query("SELECT * FROM produtos WHERE pro_id = '$pro_id'") or die(mysql_error());
$ver_produto = mysql_fetch_assoc($produto);


$nome_produto = normaliza($row_new_produtos['pro_nome']);

$dir = ("admin/imagens/produtos/".$nome_produto."/");

$abrir = opendir($dir);
$arquivos = array();

//script para verificar o brower utilizado
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
} 
?>
<!DOCTYPE html><head>
<meta name="description" content="Empresa de comunicação visual especializada em brindes personalizados para todos tipo de eventos. Produzimos também banner, fachadas e adevisos para sua empresa." />
<meta name="keywords" content="brindes em teresina, comunicação visual em teresina, brindes personalizados para todos tipo de festa,banners, adesivos, lembranças infantis e personalizadas, lembrancinhas" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php include "favicon.php"; ?>
<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<!-- estilo carrocel -->
<link rel="stylesheet" type="text/css" href="css/style.css" />


<title><?php echo $row_new_produtos['pro_nome']; ?> - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>

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

<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>

<!-- resposavel pela galeria de imagens do produto -->
<script type="text/javascript" src="js/slides.min.jquery.js"></script>

<!-- script para rodas o carrocel dos produtos relacionados -->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>
        
<script language="javascript">
	
		$(document).ready(function(){
			
			//roda as imagens dos produtos relacionados
			$('#ca-container').contentcarousel();
			
			//roda slides das imagens dos produtos
			$('#products').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				effect: 'slide, fade',
				crossfade: false,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});
			
			//valida o formulario da qunatidade
			function verificaNumero(e) {
						if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
							return false;
						}
					}
			//valida o formulario da quantidade
			$("#qtdProduto").keypress(verificaNumero);
		});
	
	// função reposanvel por adicionar itens no carrinho, checkout ia jquery
	/*$('#go_carrinho').livequery('click',function(){
		add_id = '<?php//echo $row_new_produtos['pro_id']; ?>';
		pro_imagem = '<?php//echo $row_new_produtos['pro_imagem']; ?>';
		qtdProduto = $('#qtdProduto').find('option').filter(':selected').text();
		$.ajax({
			type:"GET",
			url:"funcoes.php",
			data:{add_id:add_id,qtdProduto:qtdProduto,pro_imagem:pro_imagem},
			success: function(atual){
			}
		})//fim ajaax
		
		//alert(add_id + pro_imagem);
		//return false;	
	})	*/

</script>
 
<?php include "favicon.php"; ?>
<style>
label.error { float: none; color: red; margin: 0 .5em 0 0; vertical-align: top; font-size: 10px }
</style>
</head>

<body>

<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo.php"; ?>
<!--FIM DO TOPO-->
<?php if($_GET['msg_error']==1){?> 
<br class="cancela" />
<div id='msg_erro' style="width:1024px; margin: 10px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px;">
<p>Por favor, antes de continuar informe a quantidade desejada.</p>
</div>
<?php } ?>
<?php if($_GET['msg_error']==2){?> 
<div id='msg_erro' style="width:1024px; padding-top:5px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px;">
<p>Essa quantidade não é permitida, por favor tente novamente.</p>
</div>
<?php } ?>
<div class="centraliza_cadastro">
  <div class="produtos">
  			<div class="mapa-topo"><p style="font-size:10px; color:#333;">Você está aqui: <a href="index.php">Teresina Brindes</a> > Quebra-Cabeça </p>
            </div>
             
  	  		<div class="foto-produto">
            	
            	<div class="img_mh_lista"></div>
            <?php if($browser == 'IE'){ ?>    
            <a href="app/personalizaIE.php?cat=<?php echo $pro_cat; ?>&subcatid=<?php echo $row_new_produtos['subcat_id']; ?>"><button id="posicao-bt-personalize" class="novo-botao-azul">Personalize o Seu!</button></a>    
            <?php }else{?>    
            <a href="brindes-personalizados/index.php?cat=<?php echo $pro_cat; ?>&subcatid=<?php echo $row_new_produtos['subcat_id']; ?>"><button id="posicao-bt-personalize" class="novo-botao-azul">Personalize o Seu!</button></a>
            <?php } ?>
            		
                    
                <div id="products_example">
                    <div id="products">
                        <div class="slides_container">
                            <?php   
                            //LOCALIZA APENAS AS IMAGENS QUE INICIAM COM p
                            foreach (glob($dir."*") as $file)
                            {
                                if (($file != '.') && ($file != '..'))
                                {
            
                                        $arquivos[] = $file;
                            echo "<a target=\"_blank\"><img border=\"0\" src=\"$file\" width=\"550\" alt=\"1144953 3 2x\"></a>";
                                }
                            }  
                            ?>
                        </div>
                        <ul class="pagination">
                            <?php
                            //LOCALIZA APENAS AS IMAGENS QUE INICIAM COM p
                            foreach (glob($dir."*") as $file)
                            {
                                if (($file != '.') && ($file != '..'))
                                {
            
                                        $arquivos[] = $file;
                            echo "<li><a href=\"#\"><img src=\"$file\" width=\"55\" border=\"0\" alt=\"1144953 1 2x\"></a></li>";
                                }
                            }  
                            ?>
                        </ul>
                    </div>
            	</div>        
                    
                    
                    
                    
                    
                    
            </div><!--FIM FOTO PRODUTO-->
    		
   		 <div class="botoes">
   	  
    		  <div class="bt-topo">
                <p style="padding-bottom:15px;">
		
        		<?php echo $row_new_produtos['pro_nome']; ?>	</p>								
							<!--<div class="add-produto">
							<a href="" class="img_add2"  title="Add ao Carrinho"></a>
							<a href="" class="img_remove" title="Remover do Carrinho"></a>
                            </div> -->
						
                <span class="text-menu-produto1">Por apenas </span>
                <span style="color:#000; font-weight:bolder; font-size:20px">R$ <?php echo number_format($row_new_produtos['subcat_preco'],2, ',', '.'); ?></span><br>
                <span class="text-menu-produto2">ou 12x de R$ (preco)</span>
                
      		  </div><!--FIM BT TOPO-->
            	 <form id="form_produto" action="funcoes.php?p_id=<?php echo $pro_id ?>&c_id=<?php echo $pro_cat ?>&add_id=<?php echo $row_new_produtos['pro_id'] ?>&pro_imagem=<?php echo $row_new_produtos['pro_imagem'] ?>"  method="post" enctype="multipart/form-data" >
                <div class="bt-meio">
                <div style="padding-top:15px;">
                <p class="text-menu-produto3">Quantidade:&nbsp; </p>
            
                  <input style="margin-top:-10px;width:74px;" type="text" name="qtdProduto" id="qtdProduto" size='5'>
                  <span style="float:right; font-size:11px;margin-right:5px;margin-top:-7px;">Cod. do Item: <?php echo $row_new_produtos['pro_id'] ?></span>
                </div>
                </div><!-- FIM BT MEIO-->
                
				<div class="bt-comprar">
                	<div style="float:left; width:50px;">
                    </div>
                    <div class="posicao-comprar">
					<!-- <a class="botao verde pequeno" id='go_carrinho' href="checkout.php">Comprar</a> -->
                    <input type="submit" class="novo-botao-verde2" id='go_carrinho' value='Comprar'>
                    <input type="submit" class="novo-botao-laranja2"  formaction="index.php"  value='Continuar Compras'>
                    </div>            
                                   
                </div>
                </form>
                    <!--FIM BT-COMPRAR-->

        <!--        <div class="bt-frete">
                
                <p style="font-size:10px; color:#666; padding:5px;">Calcule seu frete:</p>
                <script language="javascript">
			function trocaCampo(primeiroCampo){
			if (primeiroCampo.value.length == 5){
			document.getElementById("cep2").focus();}}
			
			
</script>
                <input style="margin:5px; width:78px;" onkeyup="JavaScript: trocaCampo(this);" id="cep1" type="text" maxlength="5" value=''>
                <input style="margin:5px; width:30px;" id="cep2" type="text" maxlength="3" value=''>
                <input type="submit" class="novo-botao-cinza2" value='Calcular'><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
          <br>
      <a href="http://www.buscacep.correios.com.br/servicos/dnec/index.do" target="_blank" style="color:#F00; font-size:10px; margin:5px;">> Não sei o CEP</a></font>
                
                <!--################# FAZER CARREGAMENTO DE FRETE IGUAL AO PONTO FRIO --- APAGUE ESSE COMENTÁRIO 	
                
                </div> <!--FIM BT FRETE -->	
                    
                    
        		<div class="bt-abaixo">
                <!-- AddThis Button BEGIN -->
<div style="margin-left:5px;" class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet" style="width:40px"></a>
<br>
<!--<a class="addthis_button_pinterest_pinit" style="margin-left:0px; margin-top:10px;"></a>-->
<a class="addthis_button_google_plusone" style=" margin-top:10px;" g:plusone:size="medium"></a> 
<a class="addthis_counter addthis_pill_style" style="margin-top:10px;"></a>
<br>

</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50ecae416b8c300e"></script>
<!-- AddThis Button END -->
                
                
                </div><!--FIM BT ABAIXO -->
           
           
    </div><!--FIM BOTOES-->
    
    <br class="cancela" />
    
    <div class="descricao-produto">
    <br />
       <div  align="center" class="informacoes-produto">INFORMAÇÕES DO PRODUTO </div>

				<?php echo $row_new_produtos['pro_detalhe']; ?>
               
   </div>        
   		
		<div class="pt-relacionados">
<div  align="center" class="informacoes-produto">VEJA TAMBÉM OUTROS PRODUTOS</div>

<div id="ca-container" class="ca-container">
				<div class="ca-wrapper">	
					
					<?php 
						while($ver_carrocel_produto = mysql_fetch_assoc($new_produtos2)){
						?>
											
					<div class="ca-item ca-item-2">
						<a href="produto.php?cat=<?php echo $ver_carrocel_produto['pro_cat_id']; ?>&id=<?php echo $ver_carrocel_produto['pro_id'];?>">
                            <div class="ca-item-main">
                                <div class="ca-icon"><img border='0' src="admin/<?php echo $ver_carrocel_produto['pro_imagem']; ?>" width='150px' /></div>
                                <span id='titulo_lista_produtos'><?php echo $ver_carrocel_produto['pro_nome']; ?></span>
                                <div class='lista-produtos-vitrine'>
                                    <span style='font-size:11px; text-decoration:none; color:#626262;'><br />Por apenas: </span><span style='color:#339900; font-size:20px;'> R$ <?php echo number_format($ver_carrocel_produto['subcat_preco'],2, ',' , '.'); ?></span><!--<span style='font-size:11px;'><br />ou 12x de R$ <?php// echo number_format($ver_carrocel_produto['subcat_preco']/12+(40/100),2, ',' , '.'); ?></span>-->
                                </div>
                            </div>
						</a>
					</div>
						
						<?php }
						
					?>
					
					
				</div>
			</div>
		</div><!--FIM PT RELACIONADOS-->  		 
                
    			
    
    </div><!--FIM PRODUTOS--> 


   

</div>
<br class="cancela" />

<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>


<?php include "analytics.php"; ?>
</body>
</html>