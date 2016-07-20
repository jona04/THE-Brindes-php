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
    <div class="oitestenado">
    <div style="width:727px">
        <p class='categorias-dentro-vitrine'>&nbsp;&#8226;<?php echo $row_categorias['cat_nome']; ?>&nbsp;&raquo;</p>
        <p style=" position:relative; float:right; font-size:14px; letter-spacing: 0.1em">
        <a href="produtos_brindes.php?id=<?php echo $row_categorias['cat_id']; ?>">veja todos</a></p>
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
    ?> <?php if($pro_personalizado == true){ echo "
    <a href='app/personaliza.php?cat=".$row_new_produtos_index['subcat_cat_id']."&subcatid=" . $row_new_produtos_index['subcat_id'] . "'>
      <div id='exibe_produtos'>
            <div id='foto_vitrine'>
                <img border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos_index['subcat_nome'] ."' />
            </div>
            <div id='titulo_vitrine'>
                <span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos_index['subcat_nome'] . "</p></span>
            </div>
            <div class='preco-vitrine'>
                <p align='center'>
                    <span style='font-size:11px; text-decoration:none; color:#626262;'>
                    Por apenas:</span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos_index['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos_index['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
                </p>
            </div><!-- fim div lista produtos vitrine -->
            
            <p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
      </div><!-- fim div exibe_produtos -->
    </a>
                ";
                }//fim if se o produto for personalizavel
                else{ echo "
                    <a href='app/orcamento.php?cat=".$row_new_produtos_index['subcat_cat_id']."&subcatid=" . $row_new_produtos_index['subcat_id'] . "'>
                    <div id='exibe_produtos'>
                        <div id='foto_vitrine'>
                            <img border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos_index['subcat_nome'] ."' />
                         </div>

                        <span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos_index['subcat_nome'] . "</p></span>

                        <span style='font-size:11px; text-decoration:none; color:#626262;'><br><p align='center'>*Quantidade mínima 50 unids</p></span>

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
    ?> <?php if($pro_personalizado == true){ echo "
                    <a href='app/personaliza.php?cat=".$row_new_produtos_index['subcat_cat_id']."&subcatid=" . $row_new_produtos_index['subcat_id'] . "'>
      <div id='exibe_produtos'>
            <div id='foto_vitrine'>
                <img border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos_index['subcat_nome'] ."' />
            </div>
            <div id='titulo_vitrine'>
                <span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos_index['subcat_nome'] . "</p></span>
            </div>
            <div class='preco-vitrine'>
                <p align='center'>
                    <span style='font-size:11px; text-decoration:none; color:#626262;'>
                    Por apenas:</span><span style='color:#339900; font-size:20px;'> R$ " . number_format($row_new_produtos_index['subcat_preco'],2, ',' , '.') . "</span><span style='font-size:11px; text-decoration:none;color: #000;' ><!--<br />ou 12x de R$ " . number_format($row_new_produtos_index['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
                </p>
            </div><!-- fim div lista produtos vitrine -->
            
            <p align='center'><span class='novo-botao-verde1'>Personalize agora!</span></p>
      </div><!-- fim div exibe_produtos -->
    </a>
                
                ";
                }//fim if se profuto for personalizado
                else{ echo "
                    <a href='app/orcamento.php?cat=".$row_new_produtos_index['subcat_cat_id']."&subcatid=" . $row_new_produtos_index['subcat_id'] . "'>
                    <div id='exibe_produtos'>
                        <div id='foto_vitrine'>
                            <img border='0' src='admin/" . $row_new_produtos_index['subcat_imagem'] . "' width='150' alt='" . $row_new_produtos_index['subcat_nome'] ."' />
                         </div>

                        <span id='titulo_lista_produtos'><p align='center'>" . $row_new_produtos_index['subcat_nome'] . "</p></span>

                        <span style='font-size:11px; text-decoration:none; color:#626262;'><br><p align='center'>*Quantidade mínima 50 unids</p></span>

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
    <br class="cancela" >
    </div><!-- fim div testando -->
    <?php 
    }//fim while categorias
    ?>
                
</div><!-- fim div tabela produtos-->