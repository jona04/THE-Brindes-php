<?php
ob_start();
require_once('Connections/teresinabrindes.php');

$menu_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$Menu_categorias_cv = mysql_query($menu_cv) or die(mysql_error());
$row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv);

//$query_Menu_categorias = "SELECT produtos.pro_id, produtos.pro_detalhe, produtos.pro_nome, produtos.pro_preco, categorias_brindes.cat_id, produtos.pro_cat_id FROM produtos, categorias_brindes WHERE pro_id = '$pro_id' AND pro_cat_id = cat_id";
$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);

$pro_cat_id = 1;
if (isset($_GET['id'])) {
  $pro_cat_id = $_GET['id'];
}

$query_categorias = "SELECT * FROM categorias_brindes WHERE cat_id = '$pro_cat_id'";
$categorias = mysql_query($query_categorias) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
?>
<!DOCTYPE html>
<head>
<meta name="description" content=" <?php echo $row_categorias['cat_tag_descricao']; ?> " />
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
<title><?php echo $row_categorias['cat_nome']; ?> para personalizar - THE Brindes Comunicação Visual</title>
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

<div id="container_conteudo_produtos">
<!-- inicia mostruario dos modelos dos produtos -->
        <div id="titulo_maior" class="arredonda_produtos">
            <p class="titulo" style="margin-left:30px;margin-top:7px; float:left; color:#666;">Categoria >
			<?php echo $row_categorias['cat_nome'] ?></p>
            
             <p class="titulo-produtos-brindes" style="margin-right:30px; float: right">
             
             <a href="personalize-online.php"><button id="posicao-bt-personalize-brindes" class="novo-botao-laranja2">Personalize o Seu!</button></a></p>
       
        </div><!-- fim titulo MAIOR -->
		<div class="banner-brindes">
        <!--<img src="imagens/banner-brindes.png">-->
        <center><p><img src="imagens/btw.png">CONFIRA ABAIXO OS NOSSOS MODELOS PERSONALIZÁVEIS</p></center>
        </div>
        <div id="lista_produtos">
        
        
        
        
        
        
        
                <div class="tabela_produtos2">
                <!--<h3 style="margin-left:10px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#999999; margin-bottom:10px;">&Uacute;ltimos Produtos</h3><hr color="#CCCCCC";>-->
				
				<?php   
				$query_new_produtos = "SELECT * FROM subcategorias_brindes WHERE subcat_cat_id = '$pro_cat_id' ORDER BY subcat_nome ASC";
				$new_produtos = mysql_query($query_new_produtos) or die(mysql_error());
				$num_produtos = mysql_num_rows($new_produtos);
				//echo $num_produtos;
				//numero de colunas dos produtos
				$LoopH = 4; 
				//inicializa a contagem de produtos na coluna
				$i = 1;
					while($row_new_produtos = mysql_fetch_assoc($new_produtos)){
						if($row_new_produtos['subcat_personalizavel'] == 'Sim'){
							$pro_personalizado = true;
						}else{
							$pro_personalizado = false;
						}
							
							if($i == 1 || $i == 5 || $i == 9 || $i == 13 || $i == 17 || $i == 21){
								echo "<div id='divisao_produtos'>" ;
							}
							
						//se ainda nao tiver 3 produtos na linha
						if($i < $LoopH){
							echo "
							
				<!-- seleciona o href se o item for personalzavel -->"
				?> <?php if($pro_personalizado == true){ echo "
<a href='app/personaliza.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
				  <div id='exibe_produtos'>
						<div id='foto_vitrine'>
							<img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos['subcat_nome'] ."' />
						</div>
						<div id='titulo_vitrine'>
							<span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos['subcat_nome'] . "</p></span>
						</div>
						<div class='preco-vitrine'>
							<p align='center'>
								<span style='font-size:11px; text-decoration:none; color:#626262;'>
								Por apenas:</span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
							</p>
						</div><!-- fim div lista produtos vitrine -->
						
						<p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
				  </div><!-- fim div exibe_produtos -->
				</a>
							";
							}//fim if se o produto for personalizavel
							else{ echo "
								<a href='app/orcamento.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
								<div id='exibe_produtos'>
									<div id='foto_vitrine'>
										<img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos['subcat_nome'] ."' />
									 </div>

									<span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos['subcat_nome'] . "</p></span>

									<span style='font-size:11px; text-decoration:none; color:#626262;'><br><p align='center'>".$row_new_produtos['subcat_desc']."</p></span>

									<p class='orcamento_vitrine' aling='center'><span class='novo-botao-laranja2'>Faça seu orçamento!</span></p>
								</div><!-- fim div exibe_produtos -->
								</a>							
							";
							}
						}
						//se ja existe 3 produtos na linha
						elseif($i == $LoopH){
							echo "
				<!-- seleciona o href se o item for personalzavel -->"
				?> <?php if($pro_personalizado == true){ echo "
								<a href='app/personaliza.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
				  <div id='exibe_produtos'>
						<div id='foto_vitrine'>
							<img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos['subcat_nome'] ."' />
						</div>
						<div id='titulo_vitrine'>
							<span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos['subcat_nome'] . "</p></span>
						</div>
						<div class='preco-vitrine'>
							<p align='center'>
								<span style='font-size:11px; text-decoration:none; color:#626262;'>
								Por apenas:</span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
							</p>
						</div><!-- fim div lista produtos vitrine -->
						
						<p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
				  </div><!-- fim div exibe_produtos -->
				</a>
							
							";
							}//fim if se profuto for personalizado
							else{ echo "
							
								<a href='app/orcamento.php?cat=".$row_new_produtos['subcat_cat_id']."&subcatid=" . $row_new_produtos['subcat_id'] . "'>
								<div id='exibe_produtos'>
									<div id='foto_vitrine'>
										<img border='0' src='admin/" . $row_new_produtos['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos['subcat_nome'] ."' />
									 </div>

									<span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos['subcat_nome'] . "</p></span>

									<span style='font-size:11px; text-decoration:none; color:#626262;'><br><p align='center'>".$row_new_produtos['subcat_desc']."</p></span>

									<p class='orcamento_vitrine' aling='center'><span class='novo-botao-laranja2'>Faça seu orçamento!</span></p>
								</div><!-- fim div exibe_produtos -->
								</a>
								
							</div> <!-- div divisao_produtos -->   
							  ";
							}
							//retorna para zero a contagem de produtos por linha
							$i = 0;					
						}//fim else if	
					//incrementa a contagem do produto na linha
					$i++;
						
					}//fim while produtos

				
				?>
              </div>
              </div><!-- fim tabela_produtos -->

        </div> <!-- fim lista_produtos -->
<!-- fim mostruario dos modelos dos produtos -->
        <?php
		$totalRows_new_produtos = '0';
        if($totalRows_new_produtos > 9)
        { ?>
            <div id="paginacao">
                <div id="centraliza_paginacao">    
                    <label class="link_paginacao"><?php echo "<a href='#' rel='id=".$pro_cat_id."&pag=1'>primeira pagina </a>"; ?> </label>
            
                    <?php for($i = $pag-$links; $i <= $pag-1; $i++){
                        if($i<=0){
                        }else{ ?>
                            <label class="link_paginacao">
                            <?php echo "<a href='#' rel='id=".$pro_cat_id."&pag=".$i."'>".$i."</a>"; ?> </label>
                    <?php	}
                    }
                    ?> <label class="link_paginacao">  <?php echo "<a href='#'>$pag</a>"; ?> </label>
                    
                    <?php for($i = $pag+1; $i <= $pag+$links; $i++){
                        
                        if($i>$paginas){
                        }else{ ?>
                        <label class="link_paginacao">	<?php echo "<a href='#' rel='id=".$pro_cat_id."&pag=".$i."'>".$i."</a>"; ?> </label>
                    <?php	}
                    } ?>
                    <label class="link_paginacao"> <?php echo "<a href='#' rel='id=".$pro_cat_id."&pag=".$paginas."'>ultima pagina </a>"; ?> </label>
                </div>        
            </div>
         <?php }//fim if
                    ?>
</div><!-- fim div container_conteudo_produto -->			
</div> <!-- fim div conteudo -->
    
	<br class="cancela" />
</div><!--fim div container -->
</div><!-- fim div fundo container-->
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>
