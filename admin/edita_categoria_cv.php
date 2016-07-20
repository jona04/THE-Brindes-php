<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	$nome_final = $_FILES['catcv_imagem']['name'];
	$catcv_id = $_POST['catcv_id'];
	$catcv_nome = $_POST['catcv_nome'];
	$catcv_url_seo = $_POST['catcv_url_seo'];
	$catcv_tag_descricao = $_POST['catcv_tag_descricao'];
	$catcv_conteudo = $_POST['catcv_conteudo'];
		
	//si nao houver envio de imagem, faz upload sem alterar imagem
	if(empty($nome_final)){
  		$updateSQL = "UPDATE categorias_cv SET catcv_nome='$catcv_nome',catcv_url_seo='$catcv_url_seo',catcv_tag_descricao='$catcv_tag_descricao', catcv_conteudo='$catcv_conteudo' WHERE catcv_id='$catcv_id'";

  		$Result1 = mysql_query($updateSQL) or die(mysql_error());
				if($Result1){
			echo '<script>alert("Categoria editada com sucesso.")</script>';
		}
	}//sinao si houver alteração de imagem, imagem é alterada
	else{
		
		$pasta = "imagens/categorias_cv/";
	  $nome_final = $_FILES['catcv_imagem']['name'];
	  $local_imagem = $pasta . $nome_final;
	  
		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png', 'gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['catcv_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		else if($tamanho < $_FILES['catcv_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
		
		$updateSQL = "UPDATE categorias_cv SET catcv_nome='$catcv_nome', catcv_conteudo='$catcv_conteudo', catcv_imagem='$local_imagem' WHERE catcv_id='$catcv_id'";
	
		$Result1 = mysql_query($updateSQL) or die(mysql_error());
		$upload = move_uploaded_file($_FILES['catcv_imagem']['tmp_name'], $pasta . $nome_final);
		if($upload){
			echo '<script>alert("Categoria editada com sucesso.")</script>';
		}	
		}
	}//fim else si nao houver imagem
}

$colname_rsCategoria = "-1";
if (isset($_GET['id'])) {
  $colname_rsCategoria = $_GET['id'];
}

$query_rsCategoria = "SELECT * FROM categorias_cv WHERE catcv_id = '$colname_rsCategoria'";
$categorias_cv = mysql_query($query_rsCategoria) or die(mysql_error());
$row_categorias_cv = mysql_fetch_assoc($categorias_cv);
$totalRows_rsCategoria = mysql_num_rows($categorias_cv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Documento sem t&iacute;tulo</title>

</head>

<body>
<div class="container_admin">
    <div class="topo_admin"></div>    

    <div class="conteudo_admin">
    
    <?php include "menu_admin.php"?>
    <h2 align="center">Edita Categorias Comunicação Visual</h2>
	<br />
    <br />
<form action="<?php echo $editFormAction; ?>"  enctype="multipart/form-data" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="catcv_nome" value="<?php echo htmlentities($row_categorias_cv['catcv_nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Url Seo:</td>
      <td><input type="text" name="catcv_url_seo" value="<?php echo htmlentities($row_categorias_cv['catcv_url_seo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tag Descricao:</td>
      <td><textarea name="catcv_tag_descricao" cols="70" rows="5"><?php echo htmlentities($row_categorias_cv['catcv_tag_descricao'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Conteudo:</td>
      <td><textarea name="catcv_conteudo" cols="70" rows="5"><?php echo htmlentities($row_categorias_cv['catcv_conteudo'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Imagem:</td>
      <td><input type="file" name="catcv_imagem" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="catcv_id" value="<?php echo $row_categorias_cv['catcv_id']; ?>" />
</form>
    </div>

<br  class="cancela" />    

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>
<?php
mysql_free_result($categorias_cv);
?>