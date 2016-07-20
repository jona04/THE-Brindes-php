<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

// função para retirar acentos e passar a frase para minúscula
function normaliza($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYobsaaaaaaceeeeiiiidnoooooouuuyybyRr';
$string = utf8_decode($string);
$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
$string = str_replace(" ","-",$string); // retira espaco
$string = strtolower($string); // passa tudo para minusculo
return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

$query_rsCategorias = "SELECT * FROM categorias_brindes";
$rsCategorias = mysql_query($query_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {


	$cat_id = $_POST['cat_id'];
	
	$query_rsCategorias2 = "SELECT * FROM categorias_brindes WHERE cat_id = '$cat_id'";
	$rsCategorias2 = mysql_query($query_rsCategorias2) or die(mysql_error());
	$row_rsCategorias2 = mysql_fetch_assoc($rsCategorias2);

	$tamanho = 1024 * 1024 * 5; // 1M
	$extensoes = array('jpg', 'jpeg', 'png','gif');
	
	$extensao = strtolower(end(explode('.', $_FILES['cat_imagem']['name'])));
	if (array_search($extensao, $extensoes) === false){
	echo '<script>alert("Imagem com extensão invalida.")</script>';	
	}
	else if($tamanho < $_FILES['cat_imagem']['size']){
	echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
	}
	else{
		$pasta = "imagens/imagem-promocional/";
		$nome_da_imagem = normaliza($row_rsCategorias2['cat_nome']);
		$local_imagem = $pasta . $nome_da_imagem.'.'.$extensao;
		
		$updateSQL = "UPDATE categorias_brindes SET cat_img_promocional= '$local_imagem' WHERE cat_id='$cat_id'";

		$Result1 = mysql_query($updateSQL) or die(mysql_error());

  
		$upload = move_uploaded_file($_FILES['cat_imagem']['tmp_name'], $local_imagem);
		if($upload){
		echo '<script>alert("Produto editado com sucesso.")</script>';
		}
	}

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
    <h2 align="center">Adicionar imagem promocional</h2>
        
        
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Categoria:</td>
      <td><select name="cat_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsCategorias['cat_id']?>"><?php echo $row_rsCategorias['cat_nome']?></option>
        <?php
} while ($row_rsCategorias = mysql_fetch_assoc($rsCategorias));
?>
      </select></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Imagem:</td>
      <td><input type="file" name="cat_imagem" size="32" />	</td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>

<br  class="cancela" />    

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsProdutos);
?>
