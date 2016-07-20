<?php 
require_once('Connections/teresinabrindes.php');
//recebe a ação para sair da dash
if(isset($_GET['ac'])){
	$ac = $_GET['ac'];
}else{
	$ac = '';
}

if(isset($ac) && $ac == 'sair'){
	unset($_SESSION['email_the']);
	unset($_SESSION['id_usu']);
	unset($_SESSION['nome_usuario']);
	//session_destroy();
	header( "Location: index.php");	
}
$menu_cv2 = "SELECT * FROM categorias_cv WHERE catcv_exibir = 0 ORDER BY catcv_nome ASC";
$Menu_categorias_cv2 = mysql_query($menu_cv2) or die(mysql_error());
$row_Menu_categorias_cv2 = mysql_fetch_assoc($Menu_categorias_cv2);

$query_Menu_categorias2 = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias2 = mysql_query($query_Menu_categorias2) or die(mysql_error());
$row_Menu_categorias2 = mysql_fetch_assoc($Menu_categorias2);

//identefica o browser
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
}else{
	$browser = 0;
} 

?>



<div class="fundo_topo">
	<div class="topo">
    	<div class="conteudo_topo">
        	<div id="<?php if($browser == 'IE') echo 'barra_topIE'; else echo 'barra_top' ?>">
            <nav id="menu6">
    		<ul>
            	<li><a class="ico_top"><div class="img_aten"></div><span>Televendas (86) 3221-0215</span></a></li>
                  	
    		</ul>
			</nav>
            <nav id="menu7">
    		<ul>
            <!-- si o usuario nao estiver cadastrado -->
			<?php if(!isset($_SESSION['email_the'])){ ?>            
        		<li><a href="<?php get_home() ?>/loginCompra.php"class="ico_top" title="Entre na sua conta THE Brindes"><div class="img_conta"></div><span>Entrar</span></a></li>
        		<li><a href="<?php get_home() ?>/cadastro_usuario.php" class="ico_top" title="Crie uma conta na THE Brindes"><div class="img_add"></div><span>Cadastre-se</span></a></li>
        	<?php } ?> 
            <!-- si o usuario estiver cadastrado  aparece o nome dele no topo-->
            <?php if(isset($_SESSION['email_the'])){ ?>
           		
                <li><a href="?ac=sair" class="ico_top"><span>Sair</span></a><a href="<?php get_home() ?>/dashboard.php" class="ico_top"><div class="img_add"></div><span>Minha Conta</span></a><a class="ico_top">Olá, <?php echo $_SESSION['nome_usuario'] ?></a></li>
        	<?php } ?>                       		
    		</ul>
			</nav>
</div>
            <div id="<?php if($browser == 'IE') echo 'centro_topIE'; else echo 'centro_top' ?>">
                    <!--MUDAR LINK PARA IR PARA INDEX-->          
               		<div class="<?php if($browser == 'IE') echo 'logoie'; else echo 'logo'; ?>"><a href="<?php get_home(); ?>"><img src="<?php get_home() ?>/imagens/logo3.png" width="305" height="50" alt="Logo Teresina Brindes" title="Logo Teresina Brindes: Comunicação Visual" border="0" /></a></div>
                    
                    <div class="contendo-a-lista">
                    <div class="minha_lista">
                         <div class="img_carrinho"></div>
                    </div>
                    <div class="minha_lista2"><span>Minha Cesta</span></div>
                    <div class="meu_carrinho2">
                    <br />
					
<p class="carrinho">
					<a href="<?php get_home() ?>/checkout.php" title="Visualize seu carrinho">
                    
					<?php if(isset($_SESSION['email_the'])){
								$qtdCarrinho = 0;
								$query_carrinho = mysql_query("SELECT * FROM carrinho WHERE car_email = '".mysql_real_escape_string($_SESSION['email_the'])."'");
								while($qr_my_carrinho = mysql_fetch_assoc($query_carrinho)){ 
									$qtdCarrinho += $qr_my_carrinho['car_qtd'];
								}
									$carrinho = mysql_num_rows($query_carrinho);
									if($carrinho == 0){
									echo 'Est&aacute; vazia';
									//}elseif($carrinho == 1){
									}elseif($qtdCarrinho == 1){
										echo '<span class="carrinho2">Tem 1 item</span>';	
									}else{
										echo "Tem " .$qtdCarrinho . " itens";
									}
								//}//fim while
						  }
						  else{
							  $qtd2 = 0;
							foreach($_SESSION as $nome => $quantidade){  
						  		if(substr($nome,0,9) == 'produtos_'){
								$qtdCarrinho += $quantidade;	
								$qtd++;
								}else{
									$qtdCarrinho = "0";
								}
							}
							foreach($_SESSION as $nome2 => $quantidade2){  
						  		if(substr($nome2,0,13) == 'produtosPers_'){
								$qtdCarrinho2 += $quantidade2;	
								$qtd2++;
								}else{
									$qtdCarrinho2 = "0";
								}
							}
							//$qtdTotal = $qtd + $qtd2;						
							if(isset($qtdCarrinho2) || isset($qtdCarrinho)){
								$qtdTotal = $qtdCarrinho2 + $qtdCarrinho;
							}else{
								$qtdTotal = 0;
							}
							
							if(isset($qtdTotal) && $qtdTotal == 0)
								{echo "Est&aacute; vazia";}
							elseif($qtdTotal == 1)
								{echo '<span class="carrinho2">Tem 1 item</span>';}
							else
								{echo '<span class="carrinho2">Tem ' .$qtdTotal . ' itens</span>';}
						  }
						
						  
					?>
					
					   </a>  </p>
                    <br />
                    <div style="margin-left:-125px; margin-top:-66px;">
                    <!--<img src="imagens/premium.png" alt="" title="Produtos de Alta Qualidade" />-->
                    <!--<img src="imagens/satisfacao.png" alt="" title="QUALIDADE PREMIUM EM NOSSOS PRODUTOS" />--></div>
                    <div style="margin-top:-15px; margin-left:-40px;" align="center">
                    </div>
	                </div>
                   
                    </div>

               		<div class="pesquisa">
                    	<form action="<?php get_home() ?>/bus_pro.php"  method="post" enctype="multipart/form-data">
						<input type="text" maxlength="60" autocomplete="on" widdit="on" x-webkit-speech="true" onwebkitspeechchange="this.form.submit();" class="l_busca" name="s" id="s" />
						<input type="submit" value="Pesquisar" class="i_busca" id="busca" name="busca" />
						</form>
                    </div>
                    
          </div>
          
          
            <div id="<?php if($browser == 'IE') echo 'menu_topIE'; else echo 'menu_top' ?>"></div>
           <ul id="<?php if($browser == 'IE') echo 'menuIE'; else echo 'menu' ?>" class='menu_topo'>
    
    <li class="menu_right"><a href="#" class="drop">Todas as Categorias</a><!-- Begin 3 columns Item -->
    
        <div class="dropdown_5columns align_left"><!-- Begin 3 columns container -->
            
            <div class="col_3">
                <h2>Comunica&ccedil;&atilde;o Visual & Brindes</h2>
            </div>
            
            
            
            
            <div id="lado_esq_menu" style="float:left; width:150px;">
            <?php do { ?>
            <div class="col_1">
                    <ul class="greybox">
            <li id="cv"><a href="<?php get_comunicacao_visual() ?><?php echo '/'.$row_Menu_categorias_cv2['catcv_url_seo'] ?>" title="Comunicação Visual: <?php echo $row_Menu_categorias_cv2['catcv_nome']; ?>" rel="<?php echo $row_Menu_categorias_cv2['catcv_id']; ?>"><?php echo $row_Menu_categorias_cv2['catcv_nome']; ?></a></li>
            </ul>  
            </div>
            <?php } while ($row_Menu_categorias_cv2 = mysql_fetch_assoc($Menu_categorias_cv2)); ?>
            </div><!-- fim div lado_esq_menu -->
			
            
            
           
           
           
           
            <div id="lado_dir_menu" style="float:left; width:160px;">
			
			<?php do{ ?>
                    <div class="col_2">
                    <ul class="greybox">
                    
                    <li style="float:left; display:block;">
                    <a href="<?php get_home() ?>/<?php echo $row_Menu_categorias2['cat_url_seo']; ?>" title="Brindes Personalizados: <?php echo $row_Menu_categorias2['cat_nome']; ?>" rel="<?php echo $row_Menu_categorias2['cat_id']; ?>"><?php echo $row_Menu_categorias2['cat_nome']; ?></a>
                    </li>
                    
                    </ul>   
                    </div> 
            <?php } while($row_Menu_categorias2 = mysql_fetch_assoc($Menu_categorias2));?>
        	</div><!-- fim div lado_dir_menu -->
        </div> 
        
    </li><!-- End 3 columns Item -->

<li class="menu_right2"><a href="<?php get_home(); ?>" class="drop2" title="Pagina inicial da THE Brindes">Principal</a></li>
<li class="menu_right2"><a href="<?php get_home(); ?>/empresa" class="drop2" title="Informações sobre a THE Brindes">A Empresa</a></li>
<li class="menu_right2"><a href="<?php get_home(); ?>/localizacao" class="drop2" title="Localização da THE Brindes">Localiza&ccedil;&atilde;o</a></li>
<li class="menu_right2"><a href="<?php get_home(); ?>/contato" class="drop2" title="Fale com a THE Brindes">Fale conosco</a></li>

<li class="menu_right3"><div class="img_personalize"></div><a href="<?php get_home() ?>/personalize-online.php" class="drop3" title="Personalize direto do site!">PERSONALIZE</a></li>
</ul>

        
               	   
			</div><!--fim div conteudo topo --> 
    </div><!-- fim topo -->
</div><!--fim div fundo topo -->

