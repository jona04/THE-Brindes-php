<div class="mapa-topo"><p style="font-size:10px; color:#333;">Você está aqui: <a href="<?php get_home() ?>">Teresina Brindes</a> > <a href="<?php get_home()?>/<?php echo $pega_cat['cat_url_seo']; ?>"><?php echo $pega_cat['cat_nome'];  ?></a> > <?php echo $subcat_nome; ?></p>
</div>
<div id="content">
<div id="area_personaliza">
        
        <p class="titulo_personalize">Adicione sua imagem!</p>
        
		<div class="icon_aguarde2"><img src="../imagens/aguarde.gif" alt="Aguarde..." width="30" height="30" /></div>
        
        <form name="formUpload" id="formUpload" method="post">
    <div class='inputFile'>
             <span class='selecione'>Selecione aqui seu arquivo</span>
            <input type="file" name="arquivo" id="arquivo" size="45" />
   </div>
            <input type="button" id="btnEnviar" value="Enviar Arquivo" />
            <br class="cancela" />
            <label clas="progress_bar">
            	<progress class="progress_bar" value="0" max="100"></progress><span id="porcentagem">0%</span>
            </label>
            <span class="icon_aguarde"><img src="../imagens/aguarde.gif" alt="Aguarde..." width="30" height="30" /></span>
            
            
        </form>
        
       <div id="resposta">

        </div>
        <!-- include das imagens que seram carregadas -->
        <div id="area_imagens">
		<?php include "area_imagens.php"; ?>
    	</div> 
    
    <div class="botoes-app">
    
        <div class="bt-topo">
        <p style="padding-bottom:15px;">
        
        <span class="text-menu-produto1">Por apenas </span>
        <span style="color:#000; font-weight:bolder; font-size:20px;"><?php echo 'R$ '.number_format($result_subcat['subcat_preco'],2, ',' , '.'); ?></span><br>
        <!--<span class="text-menu-produto2">ou 12x de R$ (preco)</span>-->
    
   	 	</div><!--FIM BT TOPO-->
            	
                <div class="bt-meio">
                <div style="padding-top:15px;">
                <p class="text-menu-produto3">Quantidade:&nbsp; </p>
                  <input type="text" name="qtdProduto" id="qtdProduto" size='5' style="margin-top:-10px;width:74px;">
                </div>
                </div><!-- FIM BT MEIO-->
                
                <div class="bt-visualizar">
                    <div class="posicao-comprar">
                    <a id='btVisualizar' class="novo-botao-cinza" style='color:#000' name="modal" href="#dialog">Pré-visualizar</a>
                    </div>
                </div>
                
                <div class="bt-comprar">
                    <div class="posicao-comprar">
                    <a class="novo-botao-verde2" id='btnSalvar' href="#">Comprar</a>
                    <a class="novo-botao-laranja2" href="">Continuar Comprando</a>
                    </div>
                </div>
                    <!--FIM BT-COMPRAR-->

    </div><!--FIM BOTOES-->
     
   </div><!-- fim div area_personaliza -->





      
<!--  verifica a categoria do produto -->
                <?php if($nome_div_papel == 'area_caneca_branca'){ ?> <!-- se for caneca grande-->
            <div id="fundo_caneca_branca">
                <!--  area do "papel"  -->
                <div id="<?php echo $nome_div_papel ?>">      
                    <div id="area_papel">
                        <?php include 'area_papel.php'; ?>
                    </div><!-- fim div area_papel -->    
                </div><!-- fim div pai area_papel -->
            </div><!-- fim div fundo caneca -->
            <br class="cancela">  
                 <?php }elseif($nome_div_papel=='area_qc_quadrado'){  ?><!-- senao se for quebra cabeça quadrado -->
                    <!--  area do "papel"  -->
                    <div id="<?php echo $nome_div_papel ?>">
                        <!-- div que delimita a area de seguraça -->
                        <div id="top-qc-quad-linha"></div>
                        <div id="esq-qc-quad-linha"></div>
                        <div id="dir-qc-quad-linha"></div>
                        <div id="bai-qc-quad-linha"></div>
                    
                        <div id="area_papel">
                            <?php include 'area_papel.php'; ?>
                        </div><!-- fim div area_papel -->
                      <br class="cancela" />
                    </div><!-- fim div pai area_papel -->
                    <br class="cancela" />
                 <?php }elseif($nome_div_papel== 'area_almofada_quadrada'){  ?>
                  <div id="fundo_almofada_quadrada">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  </div><!-- fim div fundo almofada quadrada -->
                  <br class="cancela" />
            <?php }elseif($nome_div_papel== 'area_ecobag'){  ?>
                  <div id="fundo_ecobag">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  
                  </div><!-- fim div fundo -->
                  <br class="cancela" />
				<?php }elseif($nome_div_papel== 'area_capa_notebook14'){  ?>
                  <div id="fundo_capa_notebook14">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  </div><!-- fim div fundo almofada quadrada -->
                  <br class="cancela" />
                 <?php }elseif($nome_div_papel== 'area_mousepad_ret'){  ?><!-- senao se for mouse pad -->
                    <!--  area do "papel"  -->
                    <div id="<?php echo $nome_div_papel ?>">
                        <!-- div que delimita a area de seguraça -->
                        <div id="top-mouse-linha"></div>
                        <div id="esq-mouse-linha"></div>
                        <div id="dir-mouse-linha"></div>
                        <div id="bai-mouse-linha"></div>
                    
                        <div id="area_papel">
                            <?php include 'area_papel.php'; ?>
                        </div><!-- fim div area_papel -->
                      
                    </div><!-- fim div pai area_papel -->
                    <br class="cancela" />
                 <?php }elseif($nome_div_papel== 'area_azulejo_porcelana'){  ?><!-- senao se for azulejo -->
                    <!--  area do "papel"  -->
                    <div id="<?php echo $nome_div_papel ?>">
                        <!-- div que delimita a area de seguraça -->
                        <div id="top-azulejo-porcelana-linha"></div>
                        <div id="esq-azulejo-porcelana-linha"></div>
                        <div id="dir-azulejo-porcelana-linha"></div>
                        <div id="bai-azulejo-porcelana-linha"></div>
                    
                        <div id="area_papel">
                            <?php include 'area_papel.php'; ?>
                        </div><!-- fim div area_papel -->
                      
                    </div><!-- fim div pai area_papel -->
                    <br class="cancela" />
                 <?php }elseif($nome_div_papel== 'area_almofada_coracao'){  ?><!-- senao se for almofada -->
                  <div id="fundo_almofada_coracao">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  </div><!-- fim div fundo almofada coração -->
                  <br class="cancela" />
                    <!-- caneca rosa -->
                   <?php }elseif($nome_div_papel == 'area_caneca_rosa'){ ?>
            <div id="fundo_caneca_rosa">
                <!--  area do "papel"  -->
                <div id="<?php echo $nome_div_papel ?>">      
                    <div id="area_papel">
                        <?php include 'area_papel.php'; ?>
                    </div><!-- fim div area_papel -->    
                </div><!-- fim div pai area_papel -->
            </div><!-- fim div fundo caneca -->
            <br class="cancela">  

                 <!-- caneca azul -->
                 <?php }elseif($nome_div_papel == 'area_caneca_azul'){ ?>
            <div id="fundo_caneca_azul">
                <!--  area do "papel"  -->
                <div id="<?php echo $nome_div_papel ?>">      
                    <div id="area_papel">
                        <?php include 'area_papel.php'; ?>
                    </div><!-- fim div area_papel -->    
                </div><!-- fim div pai area_papel -->
            </div><!-- fim div fundo caneca -->
            <br class="cancela">  
                 <?php }elseif($nome_div_papel== 'area_prato_ceramica'){  ?><!-- senao se for prato porcelana -->
                 <div id='fundo_prato_ceramica'>
                    <!--  area do "papel"  -->
                    <div id="<?php echo $nome_div_papel ?>">
   
                        <div id="area_papel">
                            <?php include 'area_papel.php'; ?>
                        </div><!-- fim div area_papel -->
                      
                    </div><!-- fim div pai area_papel -->
                  </div>
                  <br class="cancela"> 
                               <!-- caneca magica -->
                 <?php }elseif($nome_div_papel == 'area_caneca_magica'){ ?>
            <div id="fundo_caneca_magica">
                <!--  area do "papel"  -->
                <div id="<?php echo $nome_div_papel ?>">      
                    <div id="area_papel">
                        <?php include 'area_papel.php'; ?>
                    </div><!-- fim div area_papel -->    
                </div><!-- fim div pai area_papel -->
            </div><!-- fim div fundo caneca -->
            <br class="cancela">  
                 <?php }elseif($nome_div_papel== 'area_almofada_redonda'){  ?><!-- senao se for almofada redonda -->
                 
                   <div id="fundo_almofada_redonda">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  </div><!-- fim div fundo almofada quadrada -->
                  <br class="cancela" />
                    <!-- caneca magica -->
 					<?php }elseif($nome_div_papel== 'area_almofada_baby'){  ?>
                  <div id="fundo_almofada_baby">
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                        
                            <div id="area_papel">
                                    <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->
                  </div><!-- fim div fundo almofada baby -->
                  <br class="cancela" />
 					<?php }elseif($nome_div_papel=='area_guirlanda'){  ?>
                    	<!--  area do "papel"  -->
                        <div id="<?php echo $nome_div_papel ?>">
                            <!-- div que delimita a area de seguraça -->
                            <div id="top-guirlanda"></div>
                            <div id="esq-guirlanda"></div>
                            <div id="dir-guirlanda"></div>
                            <div id="bai-guirlanda"></div>
                            
                            <div id="area_papel" style="width:205px; height:203px; margin:160px auto 0 auto;"">
                                        <?php include 'area_papel.php'; ?>
                            </div><!-- fim div area_papel -->
                          
                        </div><!-- fim div pai area_papel -->

                  <br class="cancela" />
            <?php }  ?>
                 
                <!--  lista de elementos que servem para o usuario compor a nova imagem -->

    <div class="img_produtos">
		<div id="products2">
            <ul class="pagination2">
                <?php
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