<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$quantidade = 9; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;

$query_produtos = "SELECT categorias_brindes.cat_id, categorias_brindes.cat_nome, produtos.pro_id, produtos.pro_cat_id, produtos.pro_nome, produtos.pro_detalhe, produtos.pro_imagem FROM produtos, categorias_brindes WHERE categorias_brindes.cat_id = produtos.pro_cat_id ORDER BY pro_nome ASC";
$query_limit_produtos = "$query_produtos LIMIT $inicio, $quantidade";
$rsProdutos = mysql_query($query_limit_produtos) or die(mysql_error());
$row_rsProdutos = mysql_fetch_assoc($rsProdutos);

if (isset($_GET['totalRows_rsProdutos'])) {
  $totalRows_rsProdutos = $_GET['totalRows_rsProdutos'];
} else {
  $all_rsProdutos = mysql_query($query_produtos);
  $totalRows_rsProdutos = mysql_num_rows($all_rsProdutos);
}
$paginas = ceil($totalRows_rsProdutos/$quantidade);
$links = 3;


/*--------- acaoo  excluir  ---------    */
if($_GET['acao'] == 'excluir'){


function apagar($dir){
	if(is_dir($dir)) {
	if($handle = opendir($dir)) {
	while(false !== ($file = readdir($handle))) {
	if(($file == ".") or ($file == "..")) {
	continue;
	}
	if(is_dir($dir . $file)) {
	apagar($dir . $file . "/");
	} else {
	unlink($dir . $file);
	}
	}
	} else {
	print("nao foi possivel abrir o arquivo.");
	$_SESSION['nao_abriu_arquivo'] == 1;
	return false;
	}
	
	// fecha a pasta aberta
	closedir($handle);
	
	// apaga a pasta, que agora esta vazia
	rmdir($dir);
	} else {
	print("diretorio informado invalido");
	$_SESSION['diretorio_invalido'] == 1;
	return false;
	}
	return true;
} 


	$del_produto = $_GET['id'];
	$sql_del_produto = "SELECT pro_imagem FROM produtos WHERE pro_id = '$del_produto'";
	$query_del = mysql_query($sql_del_produto) or die(mysql_error());
	$imagem = mysql_fetch_assoc($query_del);
	$local_imagem = $imagem['pro_imagem'];
	
	//captura somente o nome do arquivo
	$nome_da_imagem = basename($local_imagem);
	//agora deletaremos o nome do arquivo, para ficar somente o nome da pasta em que ele esta
	$local_pasta = str_replace($nome_da_imagem,"",$local_imagem);
	
	//se a pasta or deletada	
	if(apagar($local_pasta) == true){
		$sql_del = mysql_query("DELETE FROM produtos WHERE pro_id = '$del_produto'");
		//se o produto for deletado no bd
		if($sql_del){
			echo '<script>alert("Produto excluido com sucesso.");document.location.href="lista_produtos_brindes.php"</script>';
		}
	
	//se nal for deletada a pasta
	}else{
		echo '<script>alert("A pasta do produto nao pode ser excluida.");document.location.href="lista_produtos_brindes.php"</script>';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Lista de Produtos - Brindes</title>

</head>

<body>
<div class="container_admin">
    <?php include "admin_topo.php"?>

    <div class="conteudo_admin">
    
    <?php include "menu_admin.php"?>
    <center>
    <h2 style="color:#666666;">Produtos - Brindes</h2>
    </center>
        
        
        <p>&nbsp;</p>
        <h5 align="center">Produtos <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_rsProdutos) ?> de <?php echo $totalRows_rsProdutos ?> </h5>
      <table border="0" cellpadding="0" cellspacing="1" align="center">
        <tr>
            <td colspan="5">&nbsp;</td>
            <td colspan="3" align="center"><a href="adiciona_produtos_brindes.php" style="color:red;">Adicionar Produto</a></td>
        </tr>        
        <tr bgcolor="#666666">
            <td  style="padding:5px;">Id</td>
          <td  style="padding:5px;">Nome</td>
          <td  style="padding:5px;">Categoria</td>
          <td  style="padding:5px;">Pre&ccedil;o</td>
          <td  style="padding:5px;">Imagem</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <?php do { ?>
            <tr bgcolor="#CCCCCC">
              <td  style="padding:5px;"><?php echo $row_rsProdutos['pro_id']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['pro_nome']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['cat_nome']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['pro_preco']; ?></td>
              <td  style="padding:5px;"><img width="130" height="130" src="<?php echo $row_rsProdutos['pro_imagem']; ?>" alt="<?php echo $row_rsProdutos['pro_nome']; ?>" /></td>
              <td  style="padding:5px;"><a href="detalhe_brindes.php?id=<?php echo $row_rsProdutos['pro_id']; ?>">Visualizar</a></td>
              <td  style="padding:5px;"><a href="edita_produto_brindes.php?id=<?php echo $row_rsProdutos['pro_id']; ?>">Editar</a></td>
              <td style="padding:5px;"><a href="?acao=excluir&id=<?php echo $row_rsProdutos['pro_id']; ?>">Excluir</a></td>
              
            </tr>
            <?php } while ($row_rsProdutos = mysql_fetch_assoc($rsProdutos)); ?>
        </table>
<p>&nbsp;</p>
       
<br  class="cancela" /> 
    </div><!-- fim div conteudo admin -->
		<div id="paginacao">
        <?php
        if($totalRows_rsProdutos > 9){
        echo "<a href='lista_produtos_brindes.php?pag=1'>primeira pagina </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='lista_produtos_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href=#>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='lista_produtos_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='lista_produtos_brindes.php?pag=".$paginas."'>ultima pagina </a>&nbsp;&nbsp;";
        }//fim if
        ?>
        </div><!-- fim div paginacao -->
   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>
<?php
mysql_free_result($rsProdutos);
?>
