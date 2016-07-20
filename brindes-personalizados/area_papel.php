<?php
include "db.php";
//script para verificar o brower utilizado
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
} 

//rece o nome da div quando o usuario remover a imagem antes de enviar para o checkout, e apaecer a imagem guia na area papel 
if(isset($_GET['nome_div_remove'])){
	$nome_div_remove = $_GET['nome_div_remove'];
}

if(isset($_SESSION)){
	//separa nome de id na sessao fotos
	foreach($_SESSION as $nome2 => $foto2){

		if(substr($nome2,0,15) == 'imagem_enviada_'){
			$id2 = substr($nome2,15,( strlen($nome2) -15));
			//monta fotos
			$query_fotos2="SELECT * FROM fotos WHERE fotos_id = '$id2' AND fotos_atual='1'";
			$fotos2 = mysql_query($query_fotos2) or die (mysql_error());
			$linhas_fotos2 = mysql_fetch_assoc($fotos2);
			$total_linhaFotos2 = mysql_num_rows($fotos2);
			if($total_linhaFotos2 > 0){
				
				//captura o nome da subcategoria para adicionar a largura certa
				//$qr_subcatDiv = mysql_query("SELECT subcat_id, subcat_div FROM subcategorias_brindes WHERE subcat_id = ".$linhas_fotos2['fotos_subcat_id']."") or die(mysql_error());
				//$pega_subcat = mysql_fetch_assoc($qr_subcatDiv);
				//$subcat_div = $pega_subcat['subcat_div'];
				//echo $subcat_div;
				//recebe o nome da div quando o usuario enviar a foto para redimensiona-la
				if(isset($_GET['nome_div'])){
					$subcat_div = $_GET['nome_div'];
				
					//altera o tamaho da imagem para si ajustar a moldura de acordo com o nome de sua div
					if($subcat_div == 'area_qc_quadrado'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 540){
							$largura_nova = 535;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE fotos_id = '$ultimo_id'");
						
					}
					elseif($subcat_div == 'area_caneca_branca'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 390){
							$largura_nova = 380;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");	
					}	
					elseif($subcat_div == 'area_caneca_rosa'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 380){
							$largura_nova = 370;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = ");	
					}
					elseif($subcat_div == 'area_caneca_azul'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 380){
							$largura_nova = 370;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = ".$linhas_fotos2['fotos_id']."");	
					}
					elseif($subcat_div == 'area_caneca_magica'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 380){
							$largura_nova = 370;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");	
					}
					elseif($subcat_div == 'area_almofada_baby'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 400){
							$largura_nova = 390;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");	
					}
					elseif($subcat_div == 'area_almofada_coracao'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 470){
							$largura_nova = 460;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");	
					}
					elseif($subcat_div == 'area_almofada_redonda'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 340){
							$largura_nova = 330;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");	
					}
					elseif($subcat_div == 'area_almofada_quadrada'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 260){
							$largura_nova = 250;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");
					}	
					elseif($subcat_div == 'area_ecobag'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
				
						$largura_nova = 0.25*$largura_atual[0];
						if($largura_nova > 210){
							$largura_nova = 205;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");
					}										
					elseif($subcat_div == 'area_guirlanda'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 290){
							$largura_nova = 280;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");
					}
					elseif($subcat_div == 'area_azulejo_porcelana'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.30*$largura_atual[0];
						if($largura_nova > 500){
							$largura_nova = 510;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");
					}
					elseif($subcat_div == 'area_prato_ceramica'){
						$largura_atual = getimagesize($linhas_fotos2['fotos_endereco1']);
						$largura_nova = 0.27*$largura_atual[0];
						if($largura_nova > 260){
							$largura_nova = 250;
						}
						//mysql_query("UPDATE fotos SET fotos_largura = '$largura_nova' WHERE  fotos_id = '$ultimo_id'");
					}
				}

				
				

?>

                <img
                    name="img_arrastavel" 
                    <?php 
						if(isset($largura_nova)){
							if($largura_nova != ''){ ?> width='<?php echo $largura_nova; ?>' <?php } 
						}
					?>
                    id="<?php echo $linhas_fotos2['fotos_id']; ?>" 
                    src="<?php echo $linhas_fotos2['fotos_endereco1'];?>" 
                    class="img_arrastavel" 
                />

<?php
			}
		}
	}
}
?>
<img 
     <?php if(isset($browser) && $browser == 'IE'){}else{
    //name='img_arrastavel'
    //style='cursor:move;'
     } ?>
    id="img_guia" 
    src="imagens/
	<?php 
		if(isset($nome_div_remove)){
			echo "legendas_".$nome_div_remove. ".jpg";
		}else{ echo "legendas_".$nome_div_papel . ".jpg"; }
	?>" 
    class="class_img_guia"
/>

