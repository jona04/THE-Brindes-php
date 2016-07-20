<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$quantidade = 9; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;

$query_produtos = "SELECT c.cat_id, c.cat_nome, s.subcat_id, s.subcat_cat_id, s.subcat_preco,s.subcat_nome, s.subcat_imagem FROM subcategorias_brindes s, categorias_brindes c WHERE c.cat_id = s.subcat_cat_id ORDER BY s.subcat_nome ASC";
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
if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){

$del_produto = $_GET['id'];

$sql_verifica = "SELECT p.pro_subcat_id, s.subcat_id FROM produtos p, subcategorias_brindes s WHERE s.subcat_id = p.pro_subcat_id AND s.subcat_id='$del_produto'";
$query_verifica = mysql_query($sql_verifica) or die(mysql_error());
$verifica_linhas = mysql_num_rows($query_verifica);
//if tiver produtos na categoria, nao será possivel deleta-la
if($verifica_linhas >= 1){
	echo '<script>alert("Não é possivel excluir essa sub-categoria. Ela possui produtos")</script>';
}
else{	
	$sql_del_produto = "SELECT subcat_imagem FROM subcategorias_brindes WHERE subcat_id = '$del_produto'";
	$query_del = mysql_query($sql_del_produto) or die(mysql_error());
	$imagem = mysql_fetch_assoc($query_del);
	$local_imagem = $imagem['subcat_imagem'];
	
	$sql_del = mysql_query("DELETE FROM subcategorias_brindes WHERE subcat_id = '$del_produto'");
		
	if($sql_del && unlink($local_imagem)){
		echo '<script>alert("Subcategoria excluido com sucesso.");document.location.href="lista_subcategoria_brindes.php"</script>';
		}
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
    <h2 style="color:#666666;">Sub-categorias - Brindes</h2>
    </center>
        
        
        <p>&nbsp;</p>
        <h5 align="center">Subcategorias <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_rsProdutos) ?> de <?php echo $totalRows_rsProdutos ?> </h5>
      <table border="0" cellpadding="0" cellspacing="1" align="center">
        <tr>
            <td colspan="5">&nbsp;</td>
            <td colspan="3" align="center"><a href="adiciona_subcategoria_brindes.php" style="color:red;">Adicionar Sub-categoria</a></td>
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
              <td  style="padding:5px;"><?php echo $row_rsProdutos['subcat_id']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['subcat_nome']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['cat_nome']; ?></td>
              <td  style="padding:5px;"><?php echo $row_rsProdutos['subcat_preco']; ?></td>
              <td  style="padding:5px;"><img width="130" height="130" src="<?php echo $row_rsProdutos['subcat_imagem']; ?>" alt="<?php echo $row_rsProdutos['subcat_nome']; ?>" /></td>
              <td  style="padding:5px;"><a href="subcategoria_produtos_brindes.php?subcat_id=<?php echo $row_rsProdutos['subcat_id']; ?>">Produtos</a></td>
              <td  style="padding:5px;"><a href="edita_subcategoria_brindes.php?id=<?php echo $row_rsProdutos['subcat_id']; ?>">Editar</a></td>
              <td style="padding:5px;"><a href="?acao=excluir&id=<?php echo $row_rsProdutos['subcat_id']; ?>">Excluir</a></td>
              
            </tr>
            <?php } while ($row_rsProdutos = mysql_fetch_assoc($rsProdutos)); ?>
        </table>
<p>&nbsp;</p>
       
<br  class="cancela" /> 
    </div><!-- fim div conteudo admin -->
		<div id="paginacao">
        <?php
        if($totalRows_rsProdutos > 9){
        echo "<a href='lista_subcategoria_brindes.php?pag=1'>primeira pagina </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='lista_subcategoria_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href=#>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='lista_subcategoria_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='lista_subcategoria_brindes.php?pag=".$paginas."'>ultima pagina </a>&nbsp;&nbsp;";
        }//fim if
        ?>
        </div><!-- fim div paginacao -->

</div>

</body>
</html>
<?php
mysql_free_result($rsProdutos);
?>
