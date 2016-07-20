<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	if($_POST['subcat_personalizavel'] == ''){
		echo '<script>alert("Por favor preencha o campo Personalizável!")</script>';
	}else{
		$pasta = "imagens/subcategoria/";
		$nome_final = $_FILES['subcat_imagem']['name'];
	  
		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpg', 'jpeg', 'png', 'gif');
		
		$extensao = strtolower(end(explode('.', $_FILES['subcat_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		else if($tamanho < $_FILES['pro_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}
		else{
			$subcat_div = $_POST['subcat_div'];
			$diretorio_nome_div = "imagens/subcategoria/".$subcat_div;
			if(is_dir($diretorio_nome_div)){
				echo "<script>alert('O nome da div ja existe!')</script>>";
			}else{
				
				//cria pasta com autorização 777
				mkdir($diretorio_nome_div, 0777,true);
				
				$subcat_detalhe = str_replace("'","",$_POST['subcat_detalhe']);
				
				//$tmp = $_FILES['subcat_imagem']['tmp_name'];
				//$nome = "miniatura-".md5(uniqid(time())).'.jpg';
				//cria_miniatura($tmp,$nome,100,$diretorio_nome_div);
				
				$pasta_final = $pasta.md5(uniqid(time())).'.jpg';
				$subcat_cat_id = $_POST['subcat_cat_id'];
				$subcat_nome = $_POST['subcat_nome'];
				$subcat_url_seo = $_POST['subcat_url_seo'];
				$subcat_desc = $_POST['subcat_desc'];
				//$subcat_div = $_POST['subcat_div'];
				$subcat_preco = $_POST['subcat_preco'];
				$subcat_peso = $_POST['subcat_peso'];
				$subcat_altura = $_POST['subcat_altura'];
				$subcat_largura = $_POST['subcat_largura'];
				$subcat_comprimento = $_POST['subcat_comprimento'];
				$subcat_tag_descricao = $_POST['subcat_tag_descricao'];
				$subcat_tags = $_POST['subcat_tags'];
				$subcat_personalizavel = $_POST['subcat_personalizavel'];
				$insertSQL = "INSERT INTO subcategorias_brindes (subcat_cat_id,subcat_nome,subcat_url_seo,subcat_desc, subcat_preco,subcat_peso,subcat_altura,subcat_largura,subcat_comprimento,subcat_div,subcat_imagem,subcat_detalhe,subcat_tag_descricao,subcat_tags,subcat_personalizavel) VALUES ('$subcat_cat_id','$subcat_nome','$subcat_url_seo','$subcat_desc','$subcat_preco','$subcat_peso','$subcat_altura','$subcat_largura','$subcat_comprimento','$subcat_div','$pasta_final','$subcat_detalhe','$subcat_tag_descricao','$subcat_tags','$subcat_personalizavel')";
							   
		  $Result1 = mysql_query($insertSQL) or die(mysql_error());
		  $upload = move_uploaded_file($_FILES['subcat_imagem']['tmp_name'], $pasta_final);
				if($upload){
					echo '<script>alert("Sub-categorias adicionada com sucesso.")</script>';
				}
			}//fim else não existe o diretorio subcat_div
		}//fim ultimo else
	}//fim else (se campo personalziavel tiver preenchido)
}
//monta categorias
$query_rsCategorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$rsCategorias = mysql_query($query_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);
$totalRows_rsCategorias = mysql_num_rows($rsCategorias);
//monta subcategorias
/*$query_rsSubCategorias = "SELECT * FROM subcategorias_brindes ORDER BY subcat_nome ASC";
$rsSubCategorias = mysql_query($query_rsSubCategorias) or die(mysql_error());
$row_rsSubCategorias = mysql_fetch_assoc($rsSubCategorias);
$totalRows_rsSubCategorias = mysql_num_rows($rsSubCategorias);*/
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
    
    <h2 align="center">Adiconar Sub-Categoria</h2>
        
        
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
          <table align="center">
          	<tr valign="baseline">
              <td nowrap="nowrap" align="right">Nome:</td>
              <td><input type="text" name="subcat_nome" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Url - seo:</td>
              <td><input type="text" name="subcat_url_seo" value="" size="32" /></td>
            </tr>
          	<tr valign="baseline">
              <td nowrap="nowrap" align="right">Descrição:</td>
              <td><input type="text" name="subcat_desc" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Preço:</td>
              <td><input type="text" name="subcat_preco" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Peso:</td>
              <td><input type="text" name="subcat_peso" value="" size="32" /></td>
            </tr>
                        <tr valign="baseline">
              <td nowrap="nowrap" align="right">Altura:</td>
              <td><input type="text" name="subcat_altura" value="" size="32" /></td>
            </tr>
                        <tr valign="baseline">
              <td nowrap="nowrap" align="right">Largura:</td>
              <td><input type="text" name="subcat_largura" value="" size="32" /></td>
            </tr>
                        <tr valign="baseline">
              <td nowrap="nowrap" align="right">Comprimento:</td>
              <td><input type="text" name="subcat_comprimento" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nome div:</td>
              <td><input type="text" name="subcat_div" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Categoria:</td>
              <td><select name="subcat_cat_id">
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
              <td nowrap="nowrap" align="right">Imagem:</td>
              <td><input type="file" name="subcat_imagem" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
     		 <td nowrap="nowrap" align="right">Detalhes:</td><!-- condicional usada para verificar se existe  a variavel $row_rsSubCategorias -->
     		 <td><textarea name="subcat_detalhe" cols="40" rows="10"></textarea></td>
   		   </tr>
           <tr valign="baseline">
     		 <td nowrap="nowrap" align="right">Meta-Tag descrição:</td><!-- condicional usada para verificar se existe  a variavel $row_rsSubCategorias -->
     		 <td><textarea name="subcat_tag_descricao" cols="40" rows="10" ></textarea></td>
   		   </tr>
           <tr valign="baseline">
     		 <td nowrap="nowrap" align="right">Tags:</td><!-- condicional usada para verificar se existe  a variavel $row_rsSubCategorias -->
     		 <td><textarea name="subcat_tags" cols="40" rows="10" ></textarea></td>
    	  </tr>
          <tr valign="baseline">
      		<td nowrap="nowrap" align="right">Personalizavel:</td>
     		 <td><select name="subcat_personalizavel">
     			   <option value=''>Selecione aqui!</option>
       			   <option value="Sim" >Sim</option>
     			   <option value="Nao" >Não</option>
     			 </select></td>
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
