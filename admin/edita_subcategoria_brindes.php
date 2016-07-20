<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$subcat_id = "-1";
if (isset($_GET['id'])) {
  $subcat_id = $_GET['id'];
}

$query_rsCategorias = "SELECT * FROM categorias_brindes";
$rsCategorias = mysql_query($query_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);
$totalRows_rsCategorias = mysql_num_rows($rsCategorias);


$query_rsSubCategorias = "SELECT * FROM subcategorias_brindes WHERE subcat_id = '$subcat_id'";
$rsSubCategorias = mysql_query($query_rsSubCategorias) or die(mysql_error());
$row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias);
$totalRows_rsSubCategorias = mysql_num_rows($rsSubCategorias);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	$nome_final = $_FILES['subcat_imagem']['name'];
	
	//si nao houver envio de imagem, faz upload sem alterar imagem
	if(empty($nome_final)){
		
		$subcat_detalhe = str_replace("'","",$_POST['subcat_detalhe']);

		$subcat_cat_id = $_POST['subcat_cat_id'];
        $subcat_nome = $_POST['subcat_nome'];
		$subcat_url_seo = $_POST['subcat_url_seo'];
		$subcat_desc = $_POST['subcat_desc'];
        $subcat_preco = $_POST['subcat_preco'];
		$subcat_peso = $_POST['subcat_peso'];
		$subcat_altura = $_POST['subcat_altura'];
		$subcat_largura = $_POST['subcat_largura'];
		$subcat_comprimento = $_POST['subcat_comprimento'];
		$subcat_tag_descricao = $_POST['subcat_tag_descricao'];
		$subcat_div = $_POST['subcat_div'];
		$subcat_personalizavel = $_POST['subcat_personalizavel'];
		$subcat_tags = $_POST['subcat_tags'];
  		$updateSQL = "UPDATE subcategorias_brindes SET subcat_cat_id= '$subcat_cat_id',subcat_nome= '$subcat_nome',subcat_url_seo= '$subcat_url_seo',subcat_desc= '$subcat_desc', subcat_preco='$subcat_preco',subcat_peso='$subcat_peso',subcat_altura='$subcat_altura',subcat_largura='$subcat_largura',subcat_comprimento='$subcat_comprimento', subcat_div='$subcat_div',subcat_detalhe='$subcat_detalhe',subcat_tag_descricao='$subcat_tag_descricao',subcat_tags='$subcat_tags',subcat_personalizavel='$subcat_personalizavel' WHERE subcat_id='$subcat_id'";

  		$Result1 = mysql_query($updateSQL) or die(mysql_error());
		if($Result1){
			echo '<script>alert("Sub-categoria editado com sucesso.")</script>';
		}
		
	}//sinao si houver alteração de imagem, imagem é alterada
	else{
		$pasta = "imagens/subcategoria/";
	  
	  $local_imagem = $pasta . $nome_final;
	  
		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png','gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['subcat_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		else if($tamanho < $_FILES['subcat_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
			
			$subcat_detalhe = str_replace("'","",$_POST['subcat_detalhe']);
			
			$pasta_final = $pasta.md5(uniqid(time())).'.jpg';
			$subcat_cat_id = $_POST['subcat_cat_id'];
			$subcat_nome = $_POST['subcat_nome'];
			$subcat_url_seo = $_POST['subcat_url_seo'];
			$subcat_desc = $_POST['subcat_desc'];
			$subcat_preco = $_POST['subcat_preco'];
			$subcat_peso = $_POST['subcat_peso'];
			$subcat_altura = $_POST['subcat_altura'];
			$subcat_largura = $_POST['subcat_largura'];
			$subcat_comprimento = $_POST['subcat_comprimento'];
			$subcat_div = $_POST['subcat_div'];
			$subcat_tag_descricao = $_POST['subcat_tag_descricao'];
			$subcat_tags = $_POST['subcat_tags'];
			$updateSQL = "UPDATE subcategorias_brindes SET subcat_cat_id= '$subcat_cat_id',subcat_nome= '$subcat_nome',subcat_url_seo= '$subcat_url_seo',subcat_desc= '$subcat_desc', subcat_preco='$subcat_preco',subcat_peso='$subcat_peso',subcat_altura='$subcat_altura',subcat_largura='$subcat_largura',subcat_comprimento='$subcat_comprimento', subcat_div='$subcat_div',subcat_imagem='$pasta_final',subcat_detalhe='$subcat_detalhe',subcat_tag_descricao='$subcat_tag_descricao',subcat_tags='$subcat_tags',subcat_personalizavel='$subcat_personalizavel' WHERE subcat_id='$subcat_id'";			

			$Result1 = mysql_query($updateSQL) or die(mysql_error());
	  
			$upload = move_uploaded_file($_FILES['subcat_imagem']['tmp_name'], $pasta_final);
			if($upload){
			echo '<script>alert("Sub-categoria editado com sucesso.")</script>';
			}
		}//fim ultimo else
	}//fim else alteração de imagem
}
//funcçao verifica qual item o estabelecimento eferece para ser editado
function selected( $v, $d ){
    return $v===$d ? ' selected="selected"' : '';
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
    <h2 align="center">Editar Sub-categoria</h2>
        
        
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Categoria:</td>
      <td><select name="subcat_cat_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_rsCategorias['cat_id']?>" <?php if (!(strcmp($row_rsCategorias['cat_id'], htmlentities($row_rsSubCategorias['subcat_cat_id'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_rsCategorias['cat_nome']?></option>
        <?php
} while ($row_rsCategorias = mysql_fetch_assoc($rsCategorias));
?>
      </select></td>
    </tr>
    
    
    <tr> 
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="subcat_nome" value="<?php echo htmlentities($row_rsSubCategorias['subcat_nome'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Url-seo:</td>
      <td><input type="text" name="subcat_url_seo" value="<?php echo htmlentities($row_rsSubCategorias['subcat_url_seo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descricao:</td>
      <td><input type="text" name="subcat_desc" value="<?php echo htmlentities($row_rsSubCategorias['subcat_desc'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Div:</td>
      <td><input type="text" name="subcat_div" value="<?php echo htmlentities($row_rsSubCategorias['subcat_div'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Preco:</td>
      <td><input type="text" name="subcat_preco" value="<?php echo htmlentities($row_rsSubCategorias['subcat_preco'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
            <tr valign="baseline">
      <td nowrap="nowrap" align="right">Peso:</td>
      <td><input type="text" name="subcat_peso" value="<?php echo htmlentities($row_rsSubCategorias['subcat_peso'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
            <tr valign="baseline">
      <td nowrap="nowrap" align="right">Altura:</td>
      <td><input type="text" name="subcat_altura" value="<?php echo htmlentities($row_rsSubCategorias['subcat_altura'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
            <tr valign="baseline">
      <td nowrap="nowrap" align="right">Largura:</td>
      <td><input type="text" name="subcat_largura" value="<?php echo htmlentities($row_rsSubCategorias['subcat_largura'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
            <tr valign="baseline">
      <td nowrap="nowrap" align="right">Comprimento:</td>
      <td><input type="text" name="subcat_comprimento" value="<?php echo htmlentities($row_rsSubCategorias['subcat_comprimento'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Imagem:</td>
      <td><input type="file" name="subcat_imagem" value="<?php echo htmlentities($row_rsSubCategorias['subcat_imagem'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Detalhes:</td>
      <td><textarea name="subcat_detalhe" cols="23" rows="3" ><?php echo htmlentities($row_rsSubCategorias['subcat_detalhe'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
       <tr valign="baseline">
      <td nowrap="nowrap" align="right">Meta-Tags Descricao:</td>
      <td><textarea name="subcat_tag_descricao" cols="23" rows="3" ><?php echo htmlentities($row_rsSubCategorias['subcat_tag_descricao'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    </tr>
       <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tags:</td>
      <td><textarea name="subcat_tags" cols="23" rows="3" ><?php echo htmlentities($row_rsSubCategorias['subcat_tags'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      		<td nowrap="nowrap" align="right">Personalizavel:</td>
     		 <td><select name="subcat_personalizavel">
     			   <option value=''>Selecione aqui!</option>
       			   <option <?php echo selected( $row_rsSubCategorias['subcat_personalizavel'], 'Sim' ); ?> value="Sim" >Sim</option>
     			   <option <?php echo selected( $row_rsSubCategorias['subcat_personalizavel'], 'Nao' ); ?> value="Nao" >Não</option>
     			 </select></td>
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
?>
