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

$pro_id = "-1";
if (isset($_GET['id'])) {
  $pro_id = $_GET['id'];
}

$query_rsProdutos = "SELECT * FROM produtos WHERE pro_id = '$pro_id'";
$rsProdutos = mysql_query($query_rsProdutos) or die(mysql_error());
$row_rsProdutos = mysql_fetch_assoc($rsProdutos);
$totalRows_rsProdutos = mysql_num_rows($rsProdutos);

$query_rsCategorias = "SELECT * FROM categorias_brindes";
$rsCategorias = mysql_query($query_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);
$totalRows_rsCategorias = mysql_num_rows($rsCategorias);


$query_rsSubCategorias = "SELECT * FROM subcategorias_brindes";
$rsSubCategorias = mysql_query($query_rsSubCategorias) or die(mysql_error());
$row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias);
$totalRows_rsSubCategorias = mysql_num_rows($rsSubCategorias);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	//si nao houver envio de imagem, faz upload sem alterar imagem
	if(empty($_FILES['pro_imagem']['name'])){
		$pro_cat_id = $_POST['pro_cat_id'];
		$pro_subcat_id = $_POST['pro_subcat_id'];
		//se o nome do produto for alterado alteraremos o nome da pasta do mesmo
		if($_POST['pro_nome'] != $row_rsProdutos['pro_nome']){

			//captura somente o nome da imagem no local do arquivo no banco de dados
			$nome_da_imagem = basename($row_rsProdutos['pro_imagem']);
			//echo $nome_da_imagem."<br>";
			//agora deletaremos o nome da imagem, para ficar somente o nome da pasta em que ele esta
			$local_pasta = str_replace($nome_da_imagem,"",$row_rsProdutos['pro_imagem']);
			//echo $local_pasta."<br>";
			//pegamos agora o nome da pasta do produto
			$pasta_produto = basename($local_pasta);
			//echo $pasta_produto."<br>";
			//pega o novo nome do poduto que será dado para a pasta
			$novo_nome_pasta = normaliza($_POST['pro_nome']);
			//echo normaliza($novo_nome_pasta)."<br>";
			//alteramos agora o nome do novo endereço com o nome da pasta do produto atualizado
			$novo_local_pasta = str_replace($pasta_produto,$novo_nome_pasta,$local_pasta);
			//echo $novo_local_pasta."<br>";
			//novo endereço para imagem no banco de dados
			$local_imagem = $novo_local_pasta . $nome_da_imagem;
			//echo $local_imagem."<br>";
			
			//recebe o nome do produto digitado para adiciona-lo no bd
			$pro_nome = $_POST['pro_nome'];

			//alteraremos agora o nome da pasta no servidor
			rename($local_pasta, $novo_local_pasta); // Renomeia pasta antiga para nova pasta
			
			$extensao = strtolower(end(explode('.', $nome_da_imagem)));
			$pro_detalhe = $_POST['pro_detalhe'];
			$pro_tags = $_POST['pro_tags'];
			$pro_estoque = $_POST['pro_estoque'];
			$updateSQL = "UPDATE produtos SET pro_cat_id= '$pro_cat_id',pro_subcat_id= '$pro_subcat_id', pro_nome='$pro_nome', pro_detalhe='$pro_detalhe',pro_imagem='$local_imagem',pro_tags='$pro_tags', pro_estoque='$pro_estoque' WHERE pro_id='$pro_id'";
	
			$Result1 = mysql_query($updateSQL) or die(mysql_error());

		}
		$pro_nome = $_POST['pro_nome'];	
        $pro_detalhe = $_POST['pro_detalhe'];
		$pro_tags = $_POST['pro_tags'];
        $pro_estoque = $_POST['pro_estoque'];
  		$updateSQL = "UPDATE produtos SET pro_cat_id= '$pro_cat_id',pro_subcat_id= '$pro_subcat_id', pro_nome='$pro_nome', pro_detalhe='$pro_detalhe',pro_tags='$pro_tags', pro_estoque='$pro_estoque' WHERE pro_id='$pro_id'";

  		$Result1 = mysql_query($updateSQL) or die(mysql_error());
	}//sinao si houver alteração de imagem, imagem é alterada
	else{
		//local da pasta
		$pasta_produto = normaliza($row_rsProdutos['pro_nome']);
		//echo $pasta_produto."<br>";
		//nome da imagem principal
		$nome_imagem = basename($row_rsProdutos['pro_imagem']);
		//echo $pasta_produto."<br>";
		$pasta = "imagens/produtos/";
		
		$local_imagem = $pasta . $pasta_produto ."/". $nome_imagem;
	  	//echo $local_imagem."<br>";
	  
		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png','gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['pro_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		else if($tamanho < $_FILES['pro_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
			$pro_cat_id = $_POST['pro_cat_id'];
			$pro_subcat_id = $_POST['pro_subcat_id'];
			$pro_nome = $_POST['pro_nome'];
			$pro_detalhe = $_POST['pro_detalhe'];
			$pro_tags = $_POST['pro_tags'];
			$pro_estoque = $_POST['pro_estoque'];
			$pro_id = $_POST['pro_id'];
			$updateSQL = "UPDATE produtos SET pro_cat_id= '$pro_cat_id',pro_subcat_id= '$pro_subcat_id', pro_nome='$pro_nome', pro_detalhe='$pro_detalhe', pro_imagem='$local_imagem',pro_tags='$pro_tags', pro_estoque='$pro_estoque' WHERE pro_id='$pro_id'";			

			$Result1 = mysql_query($updateSQL) or die(mysql_error());
	  
			$upload = move_uploaded_file($_FILES['pro_imagem']['tmp_name'], $local_imagem);
			if($upload){
			echo '<script>alert("Produto editado com sucesso.")</script>';
			}
		}//fim ultimo else
	}//fim else alteração de imagem
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
    <h2 align="center">Editar Produto</h2>
        
        
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Categoria:</td>
      <td><select name="pro_cat_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsCategorias['cat_id']?>" <?php if (!(strcmp($row_rsCategorias['cat_id'], htmlentities($row_rsProdutos['pro_cat_id'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_rsCategorias['cat_nome']?></option>
        <?php
} while ($row_rsCategorias = mysql_fetch_assoc($rsCategorias));
?>
      </select></td>
    </tr>
    <tr>
          <td nowrap="nowrap" align="right">Sub-Categoria:</td>
      <td><select name="pro_subcat_id">
       <?php 
do {  
?>
        <option value="<?php echo $row_rsSubCategorias['subcat_id']?>" <?php if (!(strcmp($row_rsSubCategorias['subcat_id'], htmlentities($row_rsProdutos['pro_subcat_id'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_rsSubCategorias['subcat_nome']?></option>
        <?php
} while ($row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias));
?>
      </select></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="pro_nome" value="<?php echo htmlentities($row_rsProdutos['pro_nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Imagem:</td>
      <td><input type="file" name="pro_imagem" value="<?php echo htmlentities($row_rsProdutos['pro_imagem'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estoque:</td>
      <td><input type="text" name="pro_estoque" value="<?php echo htmlentities($row_rsProdutos['pro_estoque'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">Detalhe:</td>
      <td><textarea name="pro_detalhe" cols="23" rows="3" ><?php echo htmlentities($row_rsProdutos['pro_detalhe'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
        <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">Palavras chave:</td>
      <td><textarea name="pro_tags" cols="23" rows="3" ><?php echo htmlentities($row_rsProdutos['pro_tags'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Atualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="pro_id" value="<?php echo $row_rsProdutos['pro_id']; ?>" />
</form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p align="center">Bem vindo a area do administrador</p>
    </div>

<br  class="cancela" />    

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsCategorias);

mysql_free_result($rsProdutos);
?>
