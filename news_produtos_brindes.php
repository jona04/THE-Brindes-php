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
				$query_new_produtos = "SELECT * FROM subcategorias_brindes WHERE subcat_cat_id = '$pro_cat_id' ORDER BY rand()";
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
				?> <?php if($pro_personalizado == true){ echo "<a href='brindes-personalizados/".$row_new_produtos['subcat_url_seo'] . "'>
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
								<a href='brindes-personalizados/".$row_new_produtos['subcat_url_seo'] . "'>
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
								<a href='brindes-personalizados/".$row_new_produtos['subcat_url_seo'] . "'>
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
					</div> <!-- div divisao_produtos -->		
							";
							}//fim if se profuto for personalizado
							else{ echo "
							
								<a href='brindes-personalizados/".$row_new_produtos['subcat_url_seo'] . "'>
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