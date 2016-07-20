    <div id="conteudo_lateral">
    	<div id="menu_container">
          <ul id="menu_lista">
 
            <div id="titulo_menu_categoria">
				<p align="center" id="titulo_lista_produtos" style="font-size:13px; margin-top:3px;">Brindes</p>
            </div><!-- fim titulo menu categoria -->
			<?php do { ?>
            <li id="brindes"><a href="produtos_brindes.php?id=<?php echo $row_Menu_categorias['cat_id']; ?>" rel="<?php echo $row_Menu_categorias['cat_id']; ?>"><?php echo $row_Menu_categorias['cat_nome']; ?></a></li>
            <?php } while ($row_Menu_categorias = mysql_fetch_assoc($Menu_categorias)); ?>
            <br />
            <br />
         	<div id="titulo_menu_categoria">
            	<p align="center" id="titulo_lista_produtos" style="font-size:13px; margin-top:3px;">Comunica&ccedil;&atilde;o Visual</p>
            </div><!-- fim titulo menu categoria -->
            
			<?php do { ?>
            <li id="cv"><a href="comunicacao_visual.php?cv=<?php echo $row_Menu_categorias_cv['catcv_id']; ?>" rel="<?php echo $row_Menu_categorias_cv['catcv_id']; ?>"><?php echo $row_Menu_categorias_cv['catcv_nome']; ?></a></li>
            <?php } while ($row_Menu_categorias_cv = mysql_fetch_assoc($Menu_categorias_cv)); ?>


          </ul>
        </div>
  
        <div id="newsletter">
        	<div id="titulo_newsletter">
			<div class="img_lateral3"></div>
			<p align="center" id="titulo_lista_produtos" style="font-size:13px; margin-top:3px;">Newsletters</p></div>
            <div id="conteudo_newsletter">
                <p style="color:#03436D;; font-size:13px; font-family:Arial, Helvetica, sans-serif;">Cadastre seu e-mail e receba todas as novidades da Teresina Brindes!</p>
                <form class="f_newsletter" action="index.php" method="post" id="form_newsletter">
                <p class="p_newsletter">
                  <label class="l_newsletter" for="email_letter">Email</label><br />
                  <input class="i_newsletter" id="email_letter" type="text" name="email_letter" value="" />
                </p>
                <p class="p_newsletter">
                <label class="l_newsletter" for="nome_letter">Nome</label><br />
                <input class="i_newsletter" type="text" name="nome_letter" id="nome_letter" value="">
                </p>
                <br  />
                <input type="hidden" name="format" value="h" />
            
                <input class="novo-botao-verde2" type="submit" value="Cadastrar" />
                </form>
        
            </div>    
        </div><!-- fim div newsletter --> 
            
    </div><!-- fim div conteudo lateral --> 