<div class="mapa-topo"><p style="font-size:10px; color:#333;">Você está aqui: <a href="<?php get_home() ?>">Teresina Brindes</a> > <a href="<?php get_home()?>/<?php echo $pega_cat['cat_url_seo']; ?>"><?php echo $pega_cat['cat_nome'];  ?></a> > <?php echo $subcat_nome; ?></p>
</div>
<div id="content">
<div id="area_personaliza">
        
    <p class="titulo_personalize">Preencha o formulário!</p>
    
    <div class="botoes-app">
		<form action="orcamentoen.php" class="form_orcamento_brindes" enctype="multipart/form-data" method="post" name="form_cont_brindes" >
        <div class="bt-meio-orcamento">
            <div style="padding-top:15px;">
            <p class="text-menu-produto3">* Nome:&nbsp; </p>
              <input type="text" name="nome_orc" size='20' style="margin-top:-10px;margin-left:34px;width:200px;">
            </div>

            <div style="padding-top:15px;">
            <p class="text-menu-produto3">* Email:&nbsp; </p>
              <input type="text" name="email_orc" size='20' style="margin-top:-10px;margin-left:37px;width:200px;">
            </div>

            <div style="padding-top:15px;">
            <p class="text-menu-produto3">* Telefone:&nbsp; </p>
              <input type="text" class='mask-fone' name="tel2_orc" size='20' style="margin-top:-10px;margin-left:18px;width:200px;">
            </div>
                        
            <div style="padding-top:15px;">
            <p class="text-menu-produto3">* Quantidade:&nbsp; </p>
              <?php 
			 if($arquivo == 'agenda-personalizada-2015'){
			 //if($result_subcat['subcat_id'] == 163) {?>
             	<br />
                <center>
                <table class="text-menu-produto3" width="250px">
                <tr>
                <td>
                <input type="radio" name="qtd_orc" value="1"> 1<br>
                   </td>
                   <td>
                   R$ 45,00
                 </td>
                </tr>
                <tr>
                <td>
                <input type="radio" name="qtd_orc" value="2"> 2<br>
                   </td>
                   <td>
                   R$ 80,00
                 </td>
                </tr>
                <tr>
                <td>
                <input type="radio" name="qtd_orc" value="3"> 3<br>
                   </td>
                   <td>
                   R$ 105,00
                 </td>
                </tr>
                <tr>
                <td>
                <input type="radio" name="qtd_orc" value="4"> 4<br>
                   </td>
                   <td>
                   R$ 132,00
                 </td>
                </tr>
                <tr>
                <td>
                   <input type="radio" name="qtd_orc" value="5"> 5<br>
                 </td>
                 <td>
                   R$ 155,00
                 </td>
                 </tr>   
                    <tr>
                    <td>
                    <input type="radio" name="qtd_orc" value="10"> 10<br>
                     </td>
                     <td>
                   R$ 280,00
                 </td>
                     </tr>
                     <tr>
                     <td>
                     <input type="radio" name="qtd_orc" value="20"> 20<br>
                      </td>
                      <td>
                   R$ 540,00
                 </td>
                      </tr>
                      <tr>
                      <td>
                      
                      <input type="radio" name="qtd_orc" value="50"> 50<br>
                </td>
                <td>
                   R$ 1.300,00
                 </td>
                </tr>
                <tr>
                      <td>
                <input type="radio" name="qtd_orc" value="100"> 100<br>
                </td>
                <td>
                   R$ 2.550,00
                 </td>
                </tr>
                 <tr>
                      <td>
                 <input type="radio" name="qtd_orc" value="200"> 200<br>
                 </td>
                 <td>
                   R$ 4.980,00
                 </td>
                </tr>
             </table>
             </center>
             <?php }else{?>
              <input type="text" class='mask-qtdd' name="qtd_orc" size='16' style="margin-top:-10px;margin-left:0px;width:200px;">
              <?php } ?>

              <div style="padding-top:15px;">
              <p class="text-menu-produto3">Observações:&nbsp; </p>
                <textarea rows="4" cols="25" name="obs_orc"></textarea>
              </div>


            </div>
            <input type="hidden" name="produto_orc" value="<?php echo $result_subcat['subcat_nome']; ?>" >
            <input type="hidden" name="cat_orc" value="<?php echo $pega_cat['cat_nome']; ?>" >
            <input type="hidden" name="detalhe_orc" value="<?php echo $result_subcat['subcat_detalhe']; ?>" >
        </div><!-- FIM BT MEIO Orcamento-->            	

        <div class="bt-comprar">
            <div class="posicao-comprar">
            <input type="submit" name="envia" value="Enviar orçamento!" class="novo-botao-verde2">
            <!-- <a class="novo-botao-verde2" id='btnSalvar' href="#">Enviar</a> -->
            </div>
        </div>
                    <!--FIM BT-COMPRAR-->
	</form>
	</div><!-- fim div botoes -->
     
</div><!-- fim div area_personaliza -->
<br>
<p align="center" style="font-family: Verdana, Geneva, sans-serif; font-size:15px; color:#666; ">Arraste a imagem para visualiza-la melhor</p>
                  <div id="fundo_orcamento">
					<center>
                    
                    <img id='img_pagination_orc' src="<?php $aux=0; foreach (glob($dir2."*") as $file2){ $aux++; if (($file2 != '.') && ($file2 != '..') && $aux == 1){echo $file2;}} ?>" alt="">
                    
                    </center>
                  </div><!-- fim div fundo almofada quadrada -->
                  <br class="cancela" />
                 
                <!--  lista de elementos que servem para o usuario compor a nova imagem -->

    <div class="img_produtos">
		<div id="products2">
            <ul class="pagination2">
                <?php
               /* //LOCALIZA APENAS AS IMAGENS
                foreach (glob($dir."*") as $file)
                {
                    if (($file != '.') && ($file != '..'))
                    {

                            //$arquivos[] = $file;
                echo "<li id=\"$file\" class='li_pag'><a href=\"#\"><img src=\"$file\" height=\"55\" width=\"55\" border=\"0\" alt=\"1144953 1 2x\"></a></li>";
                    }
                }*/
				
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