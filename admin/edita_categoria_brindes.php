<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
		$nome_final = $_FILES['cat_imagem']['name'];
		$cat_id = $_POST['cat_id'];
		$cat_nome = $_POST['cat_nome'];
		$cat_url_seo = $_POST['cat_url_seo'];
		$cat_tag_descricao = $_POST['cat_tag_descricao'];
		
	//si nao houver envio de imagem, faz upload sem alterar imagem
	if(empty($nome_final)){
  		$updateSQL = "UPDATE categorias_brindes SET cat_nome='$cat_nome',cat_url_seo='$cat_url_seo',cat_tag_descricao='$cat_tag_descricao' WHERE cat_id='$cat_id'";

  		$Result1 = mysql_query($updateSQL) or die(mysql_error());
	}//sinao si houver alteração de imagem, imagem é alterada
	else{
		$pasta = "imagens/categorias/";
	  $nome_final = $_FILES['cat_imagem']['name'];
	  $local_imagem = $pasta . $nome_final;
	  
		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png', 'gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['cat_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		else if($tamanho < $_FILES['cat_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
		$updateSQL = "UPDATE categorias_brindes SET cat_nome='$cat_nome',cat_url_seo='$cat_url_seo',cat_tag_descricao='$cat_tag_descricao', cat_imagem='$local_imagem' WHERE cat_id='$cat_id'";
	
		$Result1 = mysql_query($updateSQL) or die(mysql_error());
		$upload = move_uploaded_file($_FILES['cat_imagem']['tmp_name'], $pasta . $nome_final);
		if($upload){
			echo '<script>alert("Categoria editada com sucesso.")</script>';
		}	
		}
	}//fim else si nao houver imagem alterada
}

$colname_rsCategoria = "-1";
if (isset($_GET['id'])) {
  $colname_rsCategoria = $_GET['id'];
}

$query_rsCategoria = "SELECT * FROM categorias_brindes WHERE cat_id = '$colname_rsCategoria'";
$rsCategoria = mysql_query($query_rsCategoria) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria = mysql_num_rows($rsCategoria);
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
    <h2 align="center">Administrador</h2>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="cat_nome" value="<?php echo htmlentities($row_rsCategoria['cat_nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Url Seo:</td>
      <td><input type="text" name="cat_url_seo" value="<?php echo htmlentities($row_rsCategoria['cat_url_seo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tag descricao:</td>
      <td><textarea rows="3" cols="20" name="cat_tag_descricao"><?php echo htmlentities($row_rsCategoria['cat_tag_descricao'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Imagem:</td>
      <td><input type="file" name="cat_imagem" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="cat_id" value="<?php echo $row_rsCategoria['cat_id']; ?>" />
</form>
        <p>&nbsp;</p>
    <br  class="cancela" />
    </div><!-- fim div conteudo admin -->    

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>
<?php
mysql_free_result($rsCategoria);
?>
