<?php
include "../conexao/conexao.php";

function gerarThumb($localfile,$filename){
	// pegando as dimensoes reais da imagem, largura e altura
	list($width, $height) = getimagesize($localfile.$filename);
	
	//setando a largura da miniatura
	$new_width = $width * 0.5;
	//setando a altura da miniatura
	$new_height = $height * 0.5;
	//gerando a a miniatura da imagem
	$image_p = imagecreatetruecolor($new_width, $new_height);
	$image = imagecreatefromjpeg($localfile.$filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	 
	/*else 
	{
		//setando a largura da miniatura
		$new_width = 40;
		//setando a altura da miniatura
		$new_height = 50;
		//gerando a a miniatura da imagem
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($localfile.$filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	}*/
	
	//o 3º argumento é a qualidade da imagem de 0 a 100
	imagejpeg($image_p, $localfile."thumb-".$filename, 90);
	//imagedestroy($image_p);
}


// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

function nome_imagem_correto($str){
	return str_replace( ' ', '_', preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $str) ) );
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


//converte data para poder ser amazenada no banco no formato date
function converteData($data){
       if (strstr($data, "/")){//verifica se tem a barra /
           $d = explode ("/", $data);//tira a barra
           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...
           return $rstData;
       }
       else if(strstr($data, "-")){
          $data = substr($data, 0, 10);
          $d = explode ("-", $data);
          $rstData = "$d[2]/$d[1]/$d[0]";
          return $rstData;
       }
       else{
           return '';
      }
}

//recebe id do evento a ser validado
$id_ind = $_GET['id_ind'];

//monta estabelecimentos
$query_rsEstab = "SELECT estab_id, estab_nome FROM estabelecimentos where estab_online = 1 ORDER BY estab_nome ASC";
$rsEstab = mysql_query($query_rsEstab) or die(mysql_error());
$row_rsEstab = mysql_fetch_assoc($rsEstab);

//monta estabelecimentos
$query_rsIndEvent = "SELECT * FROM indica_evento where ind_event_id = '$id_ind'";
$rsIndEvent = mysql_query($query_rsIndEvent) or die(mysql_error());
$row_rsIndEvent = mysql_fetch_assoc($rsIndEvent);

$nome_usuario = $row_rsIndEvent['ind_event_user'];
$endereco_img = mb_substr($row_rsIndEvent['ind_event_imagem'],19);
$nome_img = mb_substr($row_rsIndEvent['ind_event_imagem'],53);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_evento")) {

	$at_nome = $_POST['at_nome'];
	$at_cidade= $_POST['at_cidade'];
	$at_estab_id = $_POST['at_estab_id'];
	$at_desc = $_POST['at_desc'];
	$at_data = date("d/m/Y");
	$at_dia = converteData($_POST['at_dia']);
	//$at_dia = $_POST['at_dia'];
	$at_hora = date("H:i:s ");
	
	//evento criado por
	if($nome_usuario == ""){
		$at_criado_por = "Anônimo";
	}else{
		$at_criado_por = $nome_usuario;
		$id_user = $row_rsIndEvent['ind_event_user_id'];
		
		//pegar o usuario que indicou o evento e lhe é adicionado pontos
		$qr_user = mysql_query("SELECT user_id, user_pontos FROM usuarios_user WHERE user_id_face = '$id_user'") or die(mysql_error());
		$pega_user = mysql_fetch_assoc($qr_user);
		$pontos_user = $pega_user['user_pontos'];
		
		$pontos_atual = 5 + $pontos_user;
		$updateUser = "UPDATE usuarios_user SET user_pontos='$pontos_atual' WHERE user_id_face = '$id_user'";
		$Result1 = mysql_query($updateUser) or die(mysql_error());
		
		
	}
	
	$nome_final = $_FILES['at_url_imagem']['name'];
	$estilos = '';
	
	if( $at_nome == "" ||$at_estab_id == "" ||$at_dia == ""){
		echo '<script>alert("Preencha todos os dados obrigatorios.")
		javascript:history.back(-1);
		</script>';
	}elseif($nome_final == ""){
		//caso nao tenha feito upload de imagem copiamos a imagem da indicação para pasta de eventos
		$local_imagem = "../uploads/imagem-eventos/";
			
		//verifica se pasta do dia do evento ja existe, se nao existir ele cria uma
		if (!file_exists($local_imagem.$at_dia."/")) {
			//se ele conseguiur criar a pasta nos recebemos o caminho para gravar no banco
			if(mkdir($local_imagem.$at_dia."/", 0777)){
					$local_imagem = "../uploads/imagem-eventos/".$at_dia."/";
					$at_url_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/".$nome_img;
			//se n conseuir criar mandamos para o banco apenas o local sem a pasta com a data
			}
		//a pasta com o dia do evento ja foi criada	
		}else{
			$at_url_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/".$nome_img;
			$local_imagem = "../uploads/imagem-eventos/".$at_dia."/";
		}
		
		
		//copy(origem,destino)
		copy("../".$endereco_img, $local_imagem.$nome_img);
		gerarThumb($local_imagem,$nome_img);
		$at_thumb_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/thumb-".$nome_img;
			
		
		$insertSQL = "INSERT INTO atracao (at_estab_id,at_nome,at_cidade,at_descricao,at_data_criacao,at_dia,at_hora,at_thumb_imagem, at_imagem,at_estilo,at_criado_por) VALUES ('$at_estab_id','$at_nome','$at_cidade','$at_desc','$at_data','$at_dia','$at_hora','$at_thumb_imagem','$at_url_imagem','$estilos','$at_criado_por')";
		
		//transforma a indicação em evento validado
		$atualiza_valid_event = mysql_query("UPDATE indica_evento SET ind_event_analizado='1' WHERE ind_event_id='$id_ind'") or die(mysql_error());
		
		$Result1 = mysql_query($insertSQL) or die(mysql_error());
				//$upload = move_uploaded_file($_FILES['estab_imagem']['tmp_name'], $pasta.$nome_final);
				if($Result1){
					echo '<script>alert("Atração adicionada com sucesso.")
					javascript:history.back(-1);
					</script>';
				}
		
	}else{
		$tmp_name=$_FILES['at_url_imagem']['tmp_name'];
		$nome_final2 = nome_imagem_correto($nome_final);
		$local_imagem = "../uploads/imagem-eventos/";
			
			//verifica se pasta do dia do evento ja existe, se nao existir ele cria uma
			if (!file_exists($local_imagem.$at_dia."/")) {
				//se ele conseguiur criar a pasta nos recebemos o caminho para gravar no banco
				if(mkdir($local_imagem.$at_dia."/", 0777)){
						$at_url_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/".$nome_final2;
						$local_imagem = "../uploads/imagem-eventos/".$at_dia."/";
				//se n conseuir criar mandamos para o banco apenas o local sem a pasta com a data
				}else{
					$at_url_imagem = "http://axei.net.br/uploads/imagem-eventos/".$nome_final2;
				}
			//a pasta com o dia do evento ja foi criada	
			}else{
				$at_url_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/".$nome_final2;
				$local_imagem = "../uploads/imagem-eventos/".$at_dia."/";
			}
			
			//$estab_url_imagem = "https://d2s5humnetaf4e.cloudfront.net/miniatura-logo/".$nome_final;
			if(move_uploaded_file($tmp_name, $local_imagem.$nome_final2)){	
				
				gerarThumb($local_imagem,$nome_final2);
				$at_thumb_imagem = "http://axei.net.br/uploads/imagem-eventos/".$at_dia."/thumb-".$nome_final2;
				
				$insertSQL = "INSERT INTO atracao (at_estab_id,at_nome,at_cidade,at_descricao,at_data_criacao,at_dia,at_hora,at_thumb_imagem, at_imagem,at_estilo,at_criado_por) VALUES ('$at_estab_id','$at_nome','$at_cidade','$at_desc','$at_data','$at_dia','$at_hora','$at_thumb_imagem','$at_url_imagem','$estilos','$at_criado_por')";
				
				//envia a imagem para o bucket S3 da amazon	
				/*$result = $client->putObject(array(
					'ACL'		 => "public-read",
					'Bucket'     => $bucket,
					'Key'        => "imagem-atracao/".$nome_final2,
					'SourceFile' => $tmp_name,
				));*/
					
				//transforma a indicação em evento validado
				$atualiza_valid_event = mysql_query("UPDATE indica_evento SET ind_event_analizado='1' WHERE ind_event_id='$id_ind'") or die(mysql_error());
									   
				$Result1 = mysql_query($insertSQL) or die(mysql_error());
				//$upload = move_uploaded_file($_FILES['estab_imagem']['tmp_name'], $pasta.$nome_final);
				if($Result1){
					echo '<script>alert("Atração adicionada com sucesso.")
					javascript:history.back(-1);
					</script>';
				}
				
			}else{
				echo '<script>alert("Imagem nao pode ser enviada.")
				javascript:history.back(-1);
				</script>';
				}
	}//extrensao e tamanho da imagem valida
	
}
?>
<center>
	<div id="mapa"></div>
	<p />
    <p />
	<img src="../<?php echo $endereco_img ?>"/>
</center>

<h2 align="center">Adiconar Evento</h2>
        
        
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form_evento" id="form_evento" enctype="multipart/form-data">
        
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Estabelecimento que irá conceder o evento*:</td>
              <td><select name="at_estab_id">
              
                <?php 
do {  
?>
                <option value="<?php echo $row_rsEstab['estab_id']?>" ><?php echo $row_rsEstab['estab_nome']?></option>
                <?php
} while ($row_rsEstab = mysql_fetch_assoc($rsEstab));
?>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nome do evento*:</td>
              <td><input type="text" rel="limpa1" name="at_nome" maxlength="50" value="<?php echo htmlentities($row_rsIndEvent['ind_event_nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Cidade do evento*:</td>
              <td><input type="text" rel="limpa1" name="at_cidade" maxlength="50" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Descrição:</td>
              <td><input type="text" rel="limpa1" name="at_desc" maxlength="200" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Dia do evento* ( dd/mm/aaaa ):</td>
              <td><input type="text" id="datepicker" rel="limpa1" name="at_dia" value="<?php echo htmlentities($row_rsIndEvent['ind_event_data_event'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Imagem* (nao precisa adicionar):</td>
              <td><input type="file" rel="limpa1" name="at_url_imagem" value="" size="32" /></td>
            </tr>
            
            
                      <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Adicionar Evento" /></td>
          </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form_evento" />
      </form>
   <br class="cancela" />
<script> 
$(function() {
	$( "#datepicker" ).datepicker();
	$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );
});
</script>