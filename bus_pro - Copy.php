<?php
ob_start();
require_once('Connections/teresinabrindes.php');
include "anti-injection.php";

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

$busca = "";
if (isset($_POST['s'])) {
  $busca = anti_sql($_POST['s']);
}

$quantidade = 12; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;



// Monta a consulta MySQL para saber quantos registros serão encontrados
//$sql = "SELECT COUNT(*) AS total FROM `noticias` WHERE (`ativa` = 1) AND ((`titulo` LIKE '%".$busca."%') OR ('%".$busca."%'))";
// Executa a consulta
//$query = mysql_query($sql);


//$query_new_produtos = "SELECT p.pro_id,p.pro_subcat_id,p.pro_nome,p.pro_detalhe,p.pro_imagem,s.subcat_id,s.subcat_preco FROM produtos p, subcategorias_brindes s WHERE p.pro_cat_id = '$pro_cat_id' AND p.pro_subcat_id = s.subcat_id ORDER BY p.pro_nome ASC";

//verifica a busca vasculhando todos os registros
$query_new_produtos = "SELECT * FROM subcategorias_brindes WHERE subcat_tags like '%".$busca."%' ORDER BY subcat_nome ASC";
$query_limit_new_produtos = "$query_new_produtos LIMIT $inicio, $quantidade";
$new_produtos = mysql_query($query_limit_new_produtos) or die(mysql_error());
//$row_new_produtos = mysql_fetch_assoc($new_produtos);

if (isset($_GET['total_registros'])) {
  $totalRows_new_produtos = $_GET['total_registros'];
} else {
  $all_new_produtos = mysql_query($query_new_produtos);
  $totalRows_new_produtos = mysql_num_rows($all_new_produtos);
}
$paginas = ceil($totalRows_new_produtos/$quantidade);
$links = 3;
/*
$query_categorias = "SELECT categorias_brindes.cat_id, categorias_brindes.cat_nome, produtos.pro_cat_id FROM categorias_brindes, produtos WHERE produtos.pro_cat_id = categorias_brindes.cat_id AND produtos.pro_cat_id = '$pro_cat_id'";
$categorias = mysql_query($query_categorias) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);*/
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

<link href='estilo.css' rel='stylesheet' type='text/css' media="screen" /> 
<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<title>Resultados para "<?php echo $busca ?>" - <?php include "titulo.php"; ?> - Brindes e Comunicação Visual</title>
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
	
       
  	<!-- Div que contem todo o conteudo do canto direito da tela -->
    <!--<div id="conteudo_right">
        <div class="conteudo_carrinho">
            
            <div id="titulo_carrinho">
           	<p class="titulo">Minha Rede</p>
            <img class="img_mh_lista" src="imagens/Conversation.png" width="32" height="26" alt="imagem minha lista"></div><!-- fim titulo carrinho -->			
            <!--INICIO DOS ICONES DAS REDES
			<div class="redes">
            <center>	
            <img src="imagens/facebook.png" width="36" height="36" style="margin-left:0px;">
            <img src="imagens/twitter.png" width="36" height="36" style="margin-left:5px;">
            <img src="imagens/youtube.png" width="36" height="36" style="margin-left:5px;">
            <img src="imagens/blooger.png" width="36" height="36" style="margin-left:5px;">
            </center>
            </div>
            <!--FIM DOS ICONES DE REDES-->
               
                   
               
        <!--</div><!-- fim div conteudo carrinho 
        <div id="conteudo_destaque">
            <div id="titulo_carrinho" class="arredonda_destaque">
            	<p class="titulo">Destaques</p>
             <img class="img_destaques" src="imagens/favourites.png" width="32" height="32" alt="destaques"></div><!-- fim titulo detaque 
            <div class="meus_destaques">
               // 
            </div>
        </div><!-- fim div conteudo detalhe -->
   <!-- </div><!--fim div conteudo right 
        <div id="carregando_pagina"><img src="imagens/carregando.gif" width="373" height="280" alt="carregando" align="center"/></div>-->





<div id="titulo_maior">
    <div id="titulo_centro_maior" align="right" class="titulo">Resultado da busca para <span style="color:#F00;">"<?php echo $busca ?>"</span></div>
</div><!-- fim titulo menu categoria -->

<!-- condicional caso exista produtos com a pesquisa digitada -->
<?php if($totalRows_new_produtos == 0){ ?>
	<br  />
    <br  />
    <p align="center" style="color:#666; font-size:13px; font-family:Arial, Helvetica, sans-serif">Nenhum resultado para a sua pesquisa. Por favor refine sua busca.</p>
<?php } else {?>    
    <div id="lista_produtos">










               <table class="tabela_produtos2" border="0">
                <!--<h3 style="margin-left:10px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#999999; margin-bottom:10px;">&Uacute;ltimos Produtos</h3><hr color="#CCCCCC";>-->
				
				<?php   
				//$query_new_produtos = "SELECT p.pro_id,p.pro_subcat_id,p.pro_nome,p.pro_detalhe,p.pro_imagem,s.subcat_id,s.subcat_preco FROM produtos p, subcategorias_brindes s WHERE p.pro_cat_id = '$pro_cat_id' AND p.pro_subcat_id = s.subcat_id ORDER BY p.pro_nome ASC";
				//$new_produtos = mysql_query($query_new_produtos) or die(mysql_error());
				//numero de colunas dos produtos
				$LoopH = 4; 
				//inicializa a contagem de produtos na coluna
				$i = 1;
					while($row_new_produtos = mysql_fetch_assoc($new_produtos)){
						//se ainda nao tiver 3 produtos na linha
						if($i < $LoopH){
							echo "
							<td height='206' align='center'  id='layout_produtos'>

				<a href='app/personaliza.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
				  <div id='exibe_produtos'>
					<table height='300' border='0'>
					  <tr>
						<td height='140' align='center'><br /><img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='130' alt='" . $row_new_produtos['subcat_nome'] ."' /></td>
					  </tr>
					  <tr>
						<td height='80' align='center'>
						<span id='titulo_lista_produtos'>" . $row_new_produtos['subcat_nome'] . " </span><br />
						<span id='titulo_personalize_agora'>Personalize já!</span>
						</td>
					  </tr>
					  <tr>
				<div class='lista-produtos-vitrine'>
						<td valign='top' height='80' align='center'  class='presco-brindes'><span style='font-size:11px; text-decoration:none; color:#626262;'><br />
						Por apenas: </span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' >
						<!--<br />ou 12x de R$ " . number_format($row_new_produtos['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
					
						</td>
						</div>
					  </tr>
					  <tr>
					
						</span></td>
					  </tr>
					 
					 <!-- <tr>
						<td align='center'  class='botoes-brindes'><span style='text-decoration:none;'>
						<div>											
							
							<a href=\"\" class=\"img_add2\"  title=\"Add ao Carrinho\"></a>
							<a href=\"\" class=\"img_remove\" title=\"Remover do Carrinho\"></a>
						</div>
						</span></td>
					  </tr> -->
					  <tr>
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
							<td height='206' align='center'  id='layout_produtos'>




<a href='app/personaliza.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
				  <div id='exibe_produtos'>
					<table height='300' border='0'>
					  <tr>
						<td height='140' align='center'><br /><img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='130' alt='" . $row_new_produtos['subcat_nome'] ."' /></td>
					  </tr>
					  <tr>
						<td height='80' align='center'>
						<span id='titulo_lista_produtos'>" . $row_new_produtos['subcat_nome'] . " </span><br />
						<span id='titulo_personalize_agora'>Personalize já!</span>
						</td>
					  </tr>
					  <tr>
				<div class='lista-produtos-vitrine'>
						<td valign='top' height='80' align='center'  class='presco-brindes'><span style='font-size:11px; text-decoration:none; color:#626262;'><br />
						Por apenas: </span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' >
						<!--<br />ou 12x de R$ " . number_format($row_new_produtos['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
					
						</td>
						</div>
					  </tr>
					  <tr>

						</span></td>
					  </tr>
					  
					  <!-- <tr>
						<td align='center'  class='botoes-brindes'><span style='text-decoration:none;'>
						<div>											
							
							<a href=\"\" class=\"img_add2\"  title=\"Add ao Carrinho\"></a>
							<a href=\"\" class=\"img_remove\" title=\"Remover do Carrinho\"></a>
						</div>
						</span></td>
					  </tr> -->
					  
					  <tr>
					  </tr>
					  
					</table>
				  </div><!-- fim div exibe_produtos -->
				  </a>
				</td><!-- fim td id layout brindes -->
				
							</tr>
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









    
        <div id="paginacao_busca">
        <?php
        if($totalRows_new_produtos > 12){
        echo "<a href='#' rel='busca=".$busca."&pag=1'  style=\"color:#ccc;\">Primeira - </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='#' rel='busca=".$busca."&pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href='#'>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='#' rel='busca=".$busca."&pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='#' rel='busca=".$busca."&pag=".$paginas."' style=\"color:#ccc;\"> - Última </a>&nbsp;&nbsp;";
        }//fim if
        ?>
        </div><!-- fim div paginacao -->
    </div><!--fim div lista_produos -->
<?php } ?>



        
</div> <!-- fim div conteudo -->
<br class="cancela" />
</div><!--fim div container -->
</div><!-- fim div fundo container-->

<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
    <script type="text/javascript" src="jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>   
</body>
</html>