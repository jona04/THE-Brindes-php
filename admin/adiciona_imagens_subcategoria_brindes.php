<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

//monta produto
$query_rsProduto = "SELECT * FROM subcategorias_brindes ORDER BY subcat_nome ASC";
$rsProduto = mysql_query($query_rsProduto) or die(mysql_error());
$row_rsProduto = mysql_fetch_assoc($rsProduto);
$totalRows_rsProduto = mysql_num_rows($rsProduto);
$subcat_div = $row_rsProduto['subcat_div'];

function cria_miniatura($tmp,$nome,$largura,$pasta){
	$img    = imagecreatefromjpeg($tmp);
	$x      = imagesx($img);
	$y      = imagesy($img);
	$altura = ($largura * $y) / $x;
	$nova   = imagecreatetruecolor($largura,$altura);
	imagecopyresampled($nova,$img,0,0,0,0,$largura,$altura,$x,$y);
	imagejpeg($nova,$pasta."/$nome");
	imagedestroy($img);
	imagedestroy($nova);
	return($nome);
}

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

	$query_envia = "SELECT * FROM subcategorias_brindes WHERE subcat_id = ".$_POST['pro_nome'];
	$qr_produto = mysql_query($query_envia) or die(mysql_error());
	$row_produto = mysql_fetch_assoc($qr_produto);
	
	$pasta = "imagens/subcategoria/".$row_produto['subcat_div'];
	
	if(is_dir($pasta)){
		//$pasta_produto = normaliza($_POST['pro_nome']);
		//abrimos o diretorio para a contagem de imagens da pasta
		/*$dir = opendir($local_imagem);
		
		//realiza a contagem
		$count = -1;
		while($i = readdir($dir)){
			$count++;
		}
		//fecha o diretorio
		closedir($dir);
		*/
		//se a pasta ainda nao existir
		
		$pasta_miniatura = $pasta."/miniaturas";
		
		if(!is_dir($pasta_miniatura)){
			//cria pasta com autorização 777
			mkdir($pasta_miniatura, 0777,true);
		}
			
		$nome_final = md5(uniqid(time())).'.jpg';
		$tmp = $_FILES['pro_imagem']['tmp_name'];
	
		cria_miniatura($tmp,$nome_final,55,$pasta_miniatura);

		$tamanho = 1024 * 1024 * 1; // 1M
		$extensoes = array('jpeg','jpg');
		
		$extensao = strtolower(end(explode('.', $_FILES['pro_imagem']['name'])));
		if (array_search($extensao, $extensoes) === false){
		echo '<script>alert("Imagem com extensão invalida.")</script>';	
		}
		elseif($tamanho < $_FILES['pro_imagem']['size']){
		echo '<script>alert("Sua imagem é maior que 1Mb")</script>';	
		}else{		   
		$upload = move_uploaded_file($tmp, $pasta."/".$nome_final);
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
              <td nowrap="nowrap" align="right">Produto - Subcategoria:</td>
              <td><select name="pro_nome">
                <?php 
do {  
?>
                <option value="<?php echo $row_rsProduto['subcat_id']?>" ><?php echo $row_rsProduto['subcat_nome']?></option>
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
              <td><input type="submit" value="Adicionar Imagem" /></td>
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