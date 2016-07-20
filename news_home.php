<div id="container_conteudo_produtos">
        	
            
           <!-- 
            <div id="titulo_maior" class="arredonda_maior">
				
           	  <p class="titulo_vitrine">&#8226;&nbsp;Vitrine&nbsp;&#8226;</p>   
            </div><!-- fim titulo menu categoria -->
           
			
            <div id="conteudo_produtos">
            <!--<center><a href="<?php get_home(); ?>/brindes-personalizados/agenda-personalizada-2015"><img src="imagens/banner-agenda.jpg" alt="Agenda Personalizada 2015" title="Agenda Personalizada 2015" /></a></center> 
            <br /><Br /> -->       
              <div class="tabela_produtos">
                <!--<h3 style="margin-left:10px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; color:#999999; margin-bottom:10px;">&Uacute;ltimos Produtos</h3><hr color="#CCCCCC";>-->
				
				<?php                
				$query_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
				$new_categorias = mysql_query($query_categorias) or die(mysql_error());

				while($row_categorias = mysql_fetch_array($new_categorias)){
				
				//faz uma busca no banco de dados com a categoria "atual"
				$query_new_produtos_index = "SELECT * FROM subcategorias_brindes WHERE subcat_cat_id =" . $row_categorias['cat_id'];
				$query_limit_new_produtos_index = "$query_new_produtos_index LIMIT 0, 4";
				$new_produtos_index = mysql_query($query_limit_new_produtos_index) or die(mysql_error());
				
				?>
                <div style="width:727px">
               		<h1 class='categorias-dentro-vitrine'>&nbsp;&#8226;<?php echo $row_categorias['cat_nome']; ?>&nbsp;&raquo;</h1>
					<p style=" position:relative; float:right; font-size:14px; letter-spacing: 0.1em">
                	<a href="<?php get_home(); ?>/<?php echo $row_categorias['cat_url_seo']; ?>" title="Veja todos os produtos da categoria: <?php echo $row_categorias['cat_nome']; ?>">veja todos</a></p>
               <br class="cancela">
               <hr />
                </div>
                
                
               
               <br />
                <?php  		
//numero de colunas dos produtos
				$LoopH = 4; 
				//inicializa a contagem de produtos na coluna
				$i = 1;
					while($row_new_produtos_index = mysql_fetch_array($new_produtos_index)){
						if($row_new_produtos_index['subcat_personalizavel'] == 'Sim'){
							$pro_personalizado = true;
						}else{
							$pro_personalizado = false;
						}
						//se ainda nao tiver 3 produtos na linha
						if($i < $LoopH){
							echo "
				<!-- seleciona o href se o item for personalzavel -->"
				?> <?php if($pro_personalizado == true){ 
				$nome_produto = $row_new_produtos_index['subcat_nome']; // para poder botar no title
				echo "
				<a title='$nome_produto personalizado(a)' href='brindes-personalizados/".$row_new_produtos_index['subcat_url_seo'] . "'>
				  <div itemscope itemtype='http://schema.org/Product' id='exibe_produtos'>
						<div id='foto_vitrine'>
							<img itemprop='image' border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' title='$nome_produto personalizado(a)' alt='$nome_produto' />
						</div>
						<div id='titulo_vitrine'>
							<span id='titulo_lista_produtos'><p itemprop='name' align='center'>" . $nome_produto . "</p></span>
						</div>
						<div class='preco-vitrine'>
							<p itemprop='offers' itemscope itemtype='http://schema.org/Offer' align='center'>
								<span style='font-size:11px; text-decoration:none; color:#626262;'>
								Por apenas:</span><span itemprop='price' style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos_index['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos_index['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
							</p>
						</div><!-- fim div lista produtos vitrine -->
						
						<p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
				  </div><!-- fim div exibe_produtos -->
				</a>
							";
							}//fim if se o produto for personalizavel
							else{
								$nome_produto2 = $row_new_produtos_index['subcat_nome']; // para poder botar no tittle da imagem
								 echo "
								<a title='$nome_produto2 personalizado(a)' href='brindes-personalizados/".$row_new_produtos_index['subcat_url_seo'] . "'>
								<div itemscope itemtype='http://schema.org/Product' id='exibe_produtos'>
									<div id='foto_vitrine'>
										<img itemprop='image' border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' title='$nome_produto2 personalizado(a)' alt='$nome_produto2' />
									 </div>

									<span id='titulo_lista_produtos'><p itemprop='name' align='center'>" . $nome_produto2 . "</p></span>

									<span style='font-size:11px; text-decoration:none; color:#626262;'><br><p itemprop='description' align='center'>".$row_new_produtos_index['subcat_desc']."</p></span>

									<p class='orcamento_vitrine' aling='center'><span class='novo-botao-laranja2'>Faça seu orçamento!</span></p>
								</div><!-- fim div exibe_produtos -->
								</a>
								";								
							}//fim else se produto nao for personalizavel
								
						}//fim if $i < Loop se ja existe 3 produtos na linha
						
						//imprime o quarto item da lista
						elseif($i == $LoopH){
							echo "
				<!-- seleciona o href se o item for personalzavel -->"
				?> <?php if($pro_personalizado == true){ 
					$nome_produto = $row_new_produtos_index['subcat_nome']; // para poder botar no title
					echo "
								<a title='$nome_produto personalizado(a)' href='brindes-personalizados/".$row_new_produtos_index['subcat_url_seo'] . "'>
				  <div id='exibe_produtos'>
						<div id='foto_vitrine'>
							<img itemprop='image' border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' title='$nome_produto personalizado(a)' alt='$nome_produto' />
						</div>
						<div id='titulo_vitrine'>
							<span id='titulo_lista_produtos'><p itemprop='name' align='center'>" . $row_new_produtos_index['subcat_nome'] . "</p></span>
						</div>
						<div class='preco-vitrine'>
							<p itemprop='offers' itemscope itemtype='http://schema.org/Offer' align='center'>
								<span style='font-size:11px; text-decoration:none; color:#626262;'>
								Por apenas:</span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos_index['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos_index['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
							</p>
						</div><!-- fim div lista produtos vitrine -->
						
						<p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
				  </div><!-- fim div exibe_produtos -->
				</a>
							
							";
							}//fim if se profuto for personalizado
							else{ 
								$nome_produto2 = $row_new_produtos_index['subcat_nome']; // para poder botar no title
								echo "
								<a title='$nome_produto2 personalizado(a)' href='brindes-personalizados/".$row_new_produtos_index['subcat_url_seo'] . "'>
								<div itemscope itemtype='http://schema.org/Product' id='exibe_produtos'>
									<div id='foto_vitrine'>
										<img itemprop='image' border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' title='$nome_produto2 personalizado(a)' alt='$nome_produto2' />
									 </div>

									<span id='titulo_lista_produtos'><p itemprop='name' align='center'>" . $nome_produto2 . "</p></span>

									<span style='font-size:11px; text-decoration:none; color:#626262;'><br><p itemprop='description' align='center'>".$row_new_produtos_index['subcat_desc']."</p></span>

									<p class='orcamento_vitrine' aling='center'><span class='novo-botao-laranja2'>Faça seu orçamento!</span></p>
								</div><!-- fim div exibe_produtos -->
								</a>
								
								";
							}//fim else se produto nao for personalizado
								
							//retorna para zero a contagem de produtos por linha
							$i = 0;					
						}//fim else if	
					//incrementa a contagem do produto na linha
					$i++;
					}//fim while produtos
				?>
               
				<?php 
				}//fim while categorias
				?>
                <br class="cancela" > 
              </div><!-- fim div tabela produtos-->
            
          </div> <!-- fim div conteudo_produtos -->	
          	  
      </div> <!-- fim div container_conteudo_produtos -->
      <br class="cancela" >