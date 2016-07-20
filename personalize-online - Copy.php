<?php
require_once('Connections/teresinabrindes.php');
//monta categorias cv para o menu lateral
$menu_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);
//monta categorias brindes para o menu lateral
$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);


//script para verificar o brower utilizado
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
} 
  
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
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />
<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

<title>Personalize seu Brinde - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
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
        
    </div><!--fim div conteudo right -->

        <div id="container_conteudo_produtos">
        	
            <div id="titulo_maior" class="arredonda_maior">
           	   
           	  <p class="titulo_vitrine">&#8226;&nbsp;QUAL PRODUTO VOCÊ DESEJA PERSONALIZAR?&nbsp;&#8226;</p>    
            </div><!-- fim titulo menu categoria -->
            <br />

            <div id="conteudo_produtos">         
              <table class="tabela_produtos2" border="0">
                <!--<h3 style="margin-left:10px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#999999; margin-bottom:10px;">&Uacute;ltimos Produtos</h3><hr color="#CCCCCC";>-->
				
				<?php                
				$query_subcategorias = "SELECT * FROM subcategorias_brindes WHERE subcat_personalizavel = 'Sim'  ORDER BY subcat_nome ASC";
				$new_subcategorias = mysql_query($query_subcategorias) or die(mysql_error());
								
				//numero de colunas dos produtos
				$LoopH = 4; 
				//inicializa a contagem de produtos na coluna
				$i = 1;
					while($row_subcategorias = mysql_fetch_array($new_subcategorias)){
						//se ainda nao tiver 3 produtos na linha
						if($i < $LoopH){
							echo "
							<td height='206' align='center'  id='layout_produtos_personalize'>
				" ?> 
				
				<?php if($browser == 'IE') { 
					echo "<a href='brindes-personalizados/".$row_subcategorias['subcat_url_seo']."'";
				}else{ echo "<a href='brindes-personalizados/".$row_subcategorias['subcat_url_seo']."'>"; }?> 
				
				<?php echo " 
				  <div id='exibe_produtos_personalize'>
					
					<table width='60' border='0'>
					  					  <tr>
										  <center>
                <td class='n_c_p' align='center'> " .  $row_subcategorias['subcat_nome'] . " 
				</td></center>
					  </tr>
					  <tr>
						<td height='130' border='0' align='center'><br />
						
						<img src='admin/" . $row_subcategorias['subcat_imagem'] . "'&h=130&w=130&zc=1' alt='".  $row_subcategorias['subcat_nome'] ."'>
						
						</td>
					  </tr>
					  
					 
					 
					 
					  
					</table>
				  </div><!-- fim div exibe_produtos -->
				  </a>
				</td><!-- fim td id layout brindes -->
							";	
						}//fim if
						//se ja existe 3 produtos na linha
						elseif($i == $LoopH){
							echo "
							<td height='206' align='center'  id='layout_produtos_personalize'>

					" ?> 
					
					<?php if($browser == 'IE') { 
						echo "<a href='app/personaliza.php?cat=".$row_subcategorias['subcat_cat_id']."&subcatid=" . $row_subcategorias['subcat_id'] . "'> ";
					}else{ echo "<a href='app/personaliza.php?cat=".$row_subcategorias['subcat_cat_id']."&subcatid=" . $row_subcategorias['subcat_id'] . "'>"; }?> 
					
					<?php echo " 


				  <div id='exibe_produtos_personalize'>
					<table width='150' border='0'>
						<tr>
					<td  class='n_c_p'>" .  $row_subcategorias['subcat_nome'] . "</td>
					  </tr>
					  <tr>
						<td height='130' align='center'><br />
						
						<img src='admin/" . $row_subcategorias['subcat_imagem'] . "'&h=130&w=130&zc=1' alt='".  $row_subcategorias['subcat_nome'] ."'>
						
						</td>
					  </tr>
					  
					  
					  
					  
					</table>
				  </div><!-- fim div exibe_produtos -->
				  </a>
				</td><!-- fim td id layout brindes -->
				<tr>
				
				
				
							
							";	
							//retorna para zero a contagem de produtos por linha
							$i = 0;					
						}//fim else if	
					//incrementa a contagem do produto na linha
					$i++;
					}//fim while produtos

				//}//fim while categorias
				?>
              </table>
              
          </div> <!-- fim div conteudo_produtos -->		  
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
