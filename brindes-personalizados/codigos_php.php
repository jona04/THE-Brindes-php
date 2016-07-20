<?php 
include 'db.php';
$acao = $_GET['acao'];
$id_img = $_GET['id_img'];
/*--------- acaoo  excluir  ---------    */
//se clicar no botao remover produto do carrinho/checkout
if($acao == 'excluir'){
	
	unset($_SESSION['imagem_enviada_'.$id_img]);
	
	$query_fotos = "SELECT * FROM fotos WHERE fotos_id = '$id_img'";
	$fotos = mysql_query($query_fotos) or die (mysql_error());
	$linhas_fotos = mysql_fetch_assoc($fotos);
	$total_linhas_fotos = mysql_num_rows($fotos);
	
	if($linhas_fotos['fotos_endereco1']!=NULL){
		$local_imagem = $linhas_fotos['fotos_endereco1'];
		$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '$id_img'");	
		//chmod($local_imagem,0777);
		unlink($local_imagem);	
	}
	if($linhas_fotos['fotos_endereco2']!=NULL){
		$local_imagem = $linhas_fotos['fotos_endereco2'];
		$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '$id_img'");	
		//chmod($local_imagem,0777);
		unlink($local_imagem);
	}
}//fim acao excluir


//função exclui as fotos usaurio caso ele saia do aplicativo
if($acao == 'saiu_pagina'){
	
	if(isset($_SESSION)){
		//separa nome de id na sessao fotos
		foreach($_SESSION as $nome => $foto){
			
			if(substr($nome,0,15) == 'imagem_enviada_'){
				$id = substr($nome,15,( strlen($nome) -15));
				//monta fotos
				$query_fotos="SELECT * FROM fotos WHERE fotos_id = '$id'";
				$fotos = mysql_query($query_fotos) or die (mysql_error());
				$total_linhaFotos = mysql_num_rows($fotos);
				$linhas_fotos = mysql_fetch_assoc($fotos);
				// fotos_endereço1 for diferente de null é poque existe imagem lá
				if($linhas_fotos['fotos_endereco1']!=NULL){
					//continua processo se a foto nao estiver no carrinho
					if($linhas_fotos['fotos_carrinho'] != 1){
						$local_imagem = $linhas_fotos['fotos_endereco1'];
						//chmod($local_imagem, 0777);
						unlink($local_imagem);
						$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '".$linhas_fotos['fotos_id']."'");	
					}
				}
				elseif($linhas_fotos['fotos_endereco2']!=NULL){
					//continua processo se a foto nao estiver no carrinho
					if($linhas_fotos['fotos_carrinho'] != 1){
						$local_imagem = $linhas_fotos['fotos_endereco2'];
						//chmod($local_imagem, 0777);
						unlink($local_imagem);
						$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '".$linhas_fotos['fotos_id']."'");	
					}
				}
				
				$verifica_foto = mysql_query("SELECT pers_id, pers_foto_id FROM produto_personalizado WHERE pers_foto_id = '$id'") or die(mysql_error());
				$ver_foto = mysql_num_rows($verifica_foto);
				if($ver_foto == 0){
					unset($_SESSION['imagem_enviada_'.$id]);
				}
			}
		}
	}//fim se existir session
	
	//se existir sessão da imagem visualizada exclui a sessão e o arquivo da mesma
	if(isset($_SESSION['nome_imagem'])){
		//chmod('geradas/'.$_SESSION['nome_imagem'],0777);
		unlink('preVisualizadas/'.$_SESSION['nome_imagem']);
		unset($_SESSION['nome_imagem']);
	}
	if(isset($_SESSION['nome_imagem2'])){
		//chmod('geradas/'.$_SESSION['nome_imagem'],0777);
		unlink('preVisualizadas/'.$_SESSION['nome_imagem2']);
		unset($_SESSION['nome_imagem2']);
	}
	if(isset($_SESSION['nome_imagem3'])){
		//chmod('geradas/'.$_SESSION['nome_imagem'],0777);
		unlink('preVisualizadas/'.$_SESSION['nome_imagem3']);
		unset($_SESSION['nome_imagem3']);
	}
}//fim acao saiu da pagina

if($acao == 'del_preVisualizar'){
	
	//chmod('geradas/'.$_SESSION['nome_imagem'],0777);
	unlink('preVisualizadas/'.$_SESSION['nome_imagem']);
	unset($_SESSION['nome_imagem']);
	unlink('preVisualizadas/'.$_SESSION['nome_imagem2']);
	unset($_SESSION['nome_imagem2']);
	unlink('preVisualizadas/'.$_SESSION['nome_imagem3']);
	unset($_SESSION['nome_imagem3']);	
	
}//fim acao del previsualizar
?>