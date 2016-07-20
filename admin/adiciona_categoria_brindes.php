<?php
require_once('../Connections/teresinabrindes.php');
include 'funcoes_admin.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	/*
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
		
	*/
	$cat_nome = $_POST['cat_nome'];
	$cat_url_seo = $_POST['cat_url_seo'];
	$cat_tag_descricao = $_POST['cat_tag_descricao'];

  	$insertSQL = "INSERT INTO categorias_brindes (cat_nome,cat_url_seo,cat_tag_descricao) VALUES ('$cat_nome','$cat_url_seo','$cat_tag_descricao')";                     
  	$Result1 = mysql_query($insertSQL) or die(mysql_error());
	//$upload = move_uploaded_file($_FILES['cat_imagem']['tmp_name'], $pasta . $nome_final);
		if($Result1){
			echo '<script>alert("Categoria adicionada com sucesso.")</script>';
		}
	////fim ultimo else
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Documento sem t&iacute;tulo</title>

</head>

<body>
<div class="container_admin">
    <div class="topo_admin"></div>    

    <div class="conteudo_admin">
    
    <?php include "menu_admin.php"?>
    <h2 align="center">Adicionar Categoria</h2>
        
        
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
          <table align="center">
            <tr valign="baseline">
              <td align="right">Nome:</td>
              <td><input type="text" name="cat_nome" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">Url - Seo:</td>
              <td><input type="text" name="cat_url_seo" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">Tag Descricao:</td>
              <td><textarea cols="23" rows="3" name="cat_tag_descricao"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Imagem:</td>
              <td><input type="file" name="cat_imagem" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Inserir registro" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
        <p>&nbsp;</p>
<br  class="cancela" /> 
    </div>

   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>