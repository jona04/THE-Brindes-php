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
	$nome_final = $_FILES['pro_imagem']['name'];
	$local_imagem = $pasta . $pasta_produto;
	
	//abrimos o diretorio para a contagem de imagens da pasta
	$dir = opendir($local_imagem);
	
	//realiza a contagem
	$count = -1;
	while($i = readdir($dir)){
		$count++;
	}
	//fecha o diretorio
	closedir($dir);
	
	//se a pasta ainda nao existir
	if(is_dir($local_imagem)){

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
		$upload = move_uploaded_file($_FILES['pro_imagem']['tmp_name'], $local_imagem. "/" . $pasta_produto . " " . $count . "." . $extensao);
			if($upload){
				echo '<script>alert("Imagem adicionada com sucesso.")</script>';
			}else{
				echo '<script>alert("Imagem nao pode ser adicionada com sucesso.")</script>';	
			}
		}//fim ultimo else
	}else{
		echo '<script>alert("Não foi encontrada a pasta com o nome do produto.")</script>';
	}//fim else
}
//monta produto
$query_rsProduto = "SELECT * FROM produtos ORDER BY pro_nome ASC";
$rsProduto = mysql_query($query_rsProduto) or die(mysql_error());
$row_rsProduto = mysql_fetch_assoc($rsProduto);
$totalRows_rsProduto = mysql_num_rows($rsProduto);
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
    
    <?php include "menu_admin.php"; ?>
    
    <h2 align="center">Adiconar Produtos</h2>
        
        
        <p>&nbsp;</p>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
          <table align="center">
          
          
             <tr valign="baseline">
              <td nowrap="nowrap" align="right">Produto:</td>
              <td><select name="pro_nome">
                <?php 
do {  
?>
                <option value="<?php echo $row_rsProduto['pro_nome']?>" ><?php echo $row_rsProduto['pro_nome']?></option>
                <?php
} while ($row_rsProduto = mysql_fetch_assoc($rsProduto));
?>
              </select>
              </td>
            </tr>

            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Imagem:</td>
              <td><input type="file" name="pro_imagem" value="" size="32" /></td>
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