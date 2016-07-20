<?php
include 'db.php';
/* Importa o arquivo onde a função de upload está implementada */
include 'funcao_upload.php';

$subcat_id = $_POST['subcat_id'];
//$idUsuario = $_POST['id_usuario'];

/* Captura o arquivo selecionado */
$arquivo = $_FILES['arquivo'];

//recebe o nome para pega a a extensao
$nome_imagem = $arquivo['name'];
$ext = strtolower(strrchr($nome_imagem,"."));

	//data para servir como nome da pasta
	date_default_timezone_set('America/Sao_Paulo');
	$data_pasta = date("d-m-Y");
	$nome_atual = 'imagem-'.md5(uniqid(time())).$ext; //nome que dará a imagem
			
	if(isset($_SESSION['email_the'])){
		$idUsuario = $_SESSION['id_usu'];
		$pasta = "enviados/" . $data_pasta . "/" . $idUsuario;
		
		//verificando pastas no servidor
		//monta o endereço
		if(!file_exists($pasta))
		{//verifica existência        
			mkdir($pasta,0755,true);//cria pasta
		}
		$endereco = "enviados/" . $data_pasta . "/" . $idUsuario.'/'.$nome_atual;
	}else{
		$pasta = "enviados/temporarios/";
		$endereco = "enviados/temporarios/".$nome_atual;
	}
	/*Define os tipos de arquivos válidos (No nosso caso, só imagens)*/
	$tipos = array('jpg', 'png');
		
	/* Chama a função para enviar o arquivo */
	$enviar = uploadFile($arquivo, $pasta,$nome_atual, $tipos);
	
	$data['sucesso'] = false;
	
	if(isset($enviar['erro'])){    
		$data['msg'] = $enviar['erro'];
	}
	else{
		$data['sucesso'] = true;
	
		mysql_query("INSERT INTO fotos (fotos_subcat_id, fotos_nome, fotos_endereco1,fotos_atual) VALUES ('$subcat_id','$nome_atual','$endereco','1')");
		//recupera o ultimo id gerado pelo auto_increment
		$ultimo_id = mysql_insert_id();
	
		//faz uma busca para encontrar a imagem recem enviada
		$query_fotos2="SELECT * FROM fotos WHERE fotos_id = '$ultimo_id'";
		$fotos2 = mysql_query($query_fotos2) or die (mysql_error());
		$linhas_fotos2 = mysql_fetch_assoc($fotos2);
				
		//criamos uma sessao com o nome e id da imagem recem criada
		$_SESSION['imagem_enviada_'.$linhas_fotos2['fotos_id'].''] = $linhas_fotos2['fotos_nome'];
										
		/* Caminho do arquivo */
		$data['msg'] = $enviar['caminho'];
	}
/* Codifica a variável array $data para o formato JSON */
echo json_encode($data);
//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";

?>
