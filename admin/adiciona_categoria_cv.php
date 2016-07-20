<?php
require_once('../Connections/teresinabrindes.php');
include 'funcoes_admin.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	/*$pasta = "imagens/categorias_cv/";
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
	else{*/
		
	$catcv_nome = $_POST['catcv_nome'];
	$catcv_conteudo = $_POST['catcv_conteudo'];

  	$insertSQL = "INSERT INTO categorias_cv (catcv_nome, catcv_conteudo, catcv_imagem) VALUES ('$catcv_nome', '$catcv_conteudo', '$local_imagem')";                     
  	$Result1 = mysql_query($insertSQL) or die(mysql_error());
	//$upload = move_uploaded_file($_FILES['catcv_imagem']['tmp_name'], $pasta . $nome_final);
		if($Result1){
			echo '<script>alert("Categoria adicionada com sucesso.")</script>';
		}
	//}//fim ultimo else
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
    <h2 align="center">Administrador</h2>
	<br />
    <br />
    <form action="<?php echo $editFormAction; ?>" enctype="multipart/form-data" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nome:</td>
          <td><input type="text" name="catcv_nome" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nome do arquivo</td>
          <td><textarea name="catcv_conteudo" /></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Imagem:</td>
          <td><input type="file" name="catcv_imagem" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Inserir registro" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    
    <p>&nbsp;</p>
  <br class="cancela" />
  </div>   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>