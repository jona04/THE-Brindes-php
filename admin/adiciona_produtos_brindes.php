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



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$pasta_produto = normaliza($_POST['pro_nome']);
	$pasta = "imagens/produtos/";
	$local_imagem = $pasta . $pasta_produto;
	
	//se a pasta ainda nao existir
	if(is_dir($local_imagem)){
	echo '<script>alert("Já existe produto com esse nome.")</script>';
	}else{
	  
	
	  		
		//cria pasta com autorização 777
		mkdir($local_imagem, 0777,true);

		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png', 'gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['pro_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		elseif($tamanho < $_FILES['pro_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
			//nome da foto principal do prouto
			//$nome_foto = md5(uniqid(time())).".".$extensao;
			$nome_foto = $pasta_produto . " 1." . $extensao;
			$pro_cat_id = $_POST['pro_cat_id'];
			$pro_subcat_id = $_POST['pro_subcat_id'];
			$pro_nome = $_POST['pro_nome'];
			$pro_detalhe = $_POST['pro_detalhe'];
			$pro_estoque = $_POST['pro_estoque'];
			$pro_tags = $_POST['pro_tags'];
			$insertSQL = "INSERT INTO produtos (pro_cat_id,pro_subcat_id, pro_nome, pro_detalhe, pro_imagem, pro_estoque,pro_tags) VALUES ('$pro_cat_id','$pro_subcat_id', '$pro_nome', '$pro_detalhe', '$local_imagem"."/"."$nome_foto', '$pro_estoque','$pro_tags')";
						   
		$Result1 = mysql_query($insertSQL) or die(mysql_error());
		
		
		$upload = move_uploaded_file($_FILES['pro_imagem']['tmp_name'], $local_imagem. "/" . $nome_foto);
			if($upload){
				echo '<script>alert("Produto adicionado com sucesso.")</script>';
			}else{
				echo '<script>alert("Produto nao pode ser adicionado com sucesso.")</script>';
				}
		}//fim ultimo else
  
  }//fim else
}

$query_rsCategorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$rsCategorias = mysql_query($query_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);
$totalRows_rsCategorias = mysql_num_rows($rsCategorias);

$query_rsSubCategorias = "SELECT * FROM subcategorias_brindes ORDER BY subcat_nome ASC";
$rsSubCategorias = mysql_query($query_rsSubCategorias) or die(mysql_error());
$row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias);
$totalRows_rsSubCategorias = mysql_num_rows($rsSubCategorias);
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
    
    <h2 align="center">Adiconar Produtos</h2>
        
        
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
          <table align="center">
          	<tr valign="baseline">
              <td nowrap="nowrap" align="right">Nome:</td>
              <td><input type="text" name="pro_nome" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Categoria:</td>
              <td><select name="pro_cat_id">
                <?php 
do {  
?>
                <option value="<?php echo $row_rsCategorias['cat_id']?>" ><?php echo $row_rsCategorias['cat_nome']?></option>
                <?php
} while ($row_rsCategorias = mysql_fetch_assoc($rsCategorias));
?>
              </select></td>
            </tr>
                        <tr valign="baseline">
              <td nowrap="nowrap" align="right">Sub-Categoria:</td>
              <td><select name="pro_subcat_id">
                <?php 
do {  
?>
                <option value="<?php echo $row_rsSubCategorias['subcat_id']?>" ><?php echo $row_rsSubCategorias['subcat_nome']?></option>
                <?php
} while ($row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias));
?>
              </select></td>
            </tr>
            <tr> </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Estoque:</td>
              <td><input type="text" name="pro_estoque" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Imagem:</td>
              <td><input type="file" name="pro_imagem" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap">Palavras chaves:</td>
              <td><textarea name="pro_tags" cols="23" rows="3"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap">Detalhe:</td>
              <td><textarea name="pro_detalhe" cols="23" rows="3"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Adicionar Produto" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
      </form>
<br class="cancela" />
    </div>
   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>
<?php
mysql_free_result($rsCategorias);
?>
