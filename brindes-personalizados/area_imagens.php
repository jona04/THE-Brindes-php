<?php
include "db.php";
if($_SESSION){
	
	//separa nome de id na sessao fotos
	foreach($_SESSION as $nome => $foto3){

		if(substr($nome,0,15) == 'imagem_enviada_'){
			$id = substr($nome,15,( strlen($nome) -15));
			//$qtdImagens++;
			//monta fotos
		}else{
			$id = -1;
		}
	}
}else{
	$id = -1;
}			

/*if($qtdImagens == 2){ ?>
	Voce ja adionou uma imagem, deletea para poder add outra <?php
	}else{	*/	
	$query_fotos="SELECT * FROM fotos WHERE fotos_id = '$id' AND fotos_atual = 1";
	$fotos = mysql_query($query_fotos) or die (mysql_error());
	$linhas_fotos = mysql_fetch_assoc($fotos);
	$total_linhaFotos = mysql_num_rows($fotos);

	if($total_linhaFotos > 0){
	?>
<div id="conteudo_personaliza">
	<ul id="<?php echo $linhas_fotos['fotos_id']; ?>" style="float:left; list-style:none; padding:10px;">

	<div id="<?php echo $linhas_fotos['fotos_id']; ?>" class="removeMini"></div>
	<li><img id="<?php echo $linhas_fotos['fotos_id']; ?>" src="<?php echo $linhas_fotos['fotos_endereco1'];?>" class="miniaturas" /></li>
	
	</ul>
	
	
      
 </div><!-- fim div conteudo_personaliza -->
 	<?php
}
	?> 