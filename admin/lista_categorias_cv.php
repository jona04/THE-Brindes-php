<?php require_once('../Connections/teresinabrindess.php');
require_once('../Connections/teresinabrindes.php');
include 'funcoes_admin.php';

/*--------- acaoo  excluir  ---------    */
if($_GET['acao'] == 'excluir'){

$del_categoria = $_GET['id'];

$sql_verifica = "SELECT categorias_cv.catcv_id, produtos_cv.procv_catcv_id FROM categorias_cv, produtos_cv WHERE categorias_cv.catcv_id = produtos_cv.procv_catcv_id AND categorias_cv.catcv_id='$del_categoria'";
$query_verifica = mysql_query($sql_verifica) or die(mysql_error());
$verifica_linhas = mysql_num_rows($query_verifica);
if($verifica_linhas >= 1){
	echo '<script>alert("Não é possivel excluir essa categoria.")</script>';
}
else{
	$sql_del_categoria = "SELECT catcv_imagem FROM categorias_cv WHERE catcv_id = '$del_categoria'";
	$query_del = mysql_query($sql_del_categoria) or die(mysql_error());
	$imagem = mysql_fetch_assoc($query_del);
	$local_imagem = $imagem['catcv_imagem'];
	$sql_del = mysql_query("DELETE FROM categorias_cv WHERE catcv_id = '$del_categoria'");
		
	if($sql_del && unlink($local_imagem)){
		echo '<script>alert("Categoria excluido com sucesso.");document.location.href="lista_categorias_cv.php"</script>';
		}
	}
}//fim acao = excluir

$quantidade = 9; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;

$query_categorias_cv = "SELECT * FROM categorias_cv ORDER BY catcv_nome ASC";
$query_limit_categorias_cv = "$query_categorias_cv LIMIT $inicio, $quantidade";
$categorias_cv = mysql_query($query_limit_categorias_cv) or die(mysql_error());
$row_categorias_cv = mysql_fetch_assoc($categorias_cv);

if (isset($_GET['totalRows_categorias_cv'])) {
  $totalRows_categorias_cv = $_GET['totalRows_categorias_cv'];
} else {
  $all_categorias_cv = mysql_query($query_categorias_cv);
  $totalRows_categorias_cv = mysql_num_rows($all_categorias_cv);
}
$paginas = ceil($totalRows_rsCategorias/$quantidade);
$links = 3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Categorias de Comunica&ccedil;&atilde;o Visual</title>

</head>

<body>
<div class="container_admin">
    <?php include "admin_topo.php"?>

    <div class="conteudo_admin">
    
    <?php include "menu_admin.php"?>
    <center>
    <h2>Categorias de Comunica&ccedil;&atilde;o Visual</h2>
    </center>
    <br />
    <br />
    <h3 align="center">Produtos <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_categorias_cv) ?> de <?php echo $totalRows_categorias_cv ?> </h3>
    <table border="0" cellpadding="4" cellspacing="1" align="center">
      <tr bgcolor="">
        <td colspan="5">&nbsp;</td>
        <td colspan="2" align="center"><a href="adiciona_categoria_cv.php" style="color:#FF0000;">Adicionar Categoria</a></td>
      </tr>
      <?php do { ?>
        <tr>
          <td width="60" bgcolor="#666666">&nbsp;</td>
          <td style="padding:5px; color: #FFFFFF;" width="31" bgcolor="#666666">Id:</td>
          <td style="padding:5px; color: #FFFFFF;" width="153" bgcolor="#666666"><?php echo $row_categorias_cv['catcv_id']; ?></td>
          <td style="padding:5px; color: #FFFFFF;" width="51" bgcolor="#666666">Nome:</td>
          <td style="padding:5px; color: #FFFFFF;" width="199" bgcolor="#666666"><?php echo $row_categorias_cv['catcv_nome']; ?></td>
          <td style="padding:5px; color: #FFFFFF;" width="42" bgcolor="#666666"><a href="edita_categoria_cv.php?id=<?php echo $row_categorias_cv['catcv_id']; ?>">Editar</a></td>
          <td style="padding:5px; color:#FF0000;" width="79" bgcolor="#666666"><a href="?acao=excluir&id=<?php echo $row_categorias_cv['catcv_id']; ?>">Excluir</a></td>
        </tr>
        <tr>
          <td style="padding:5px;" >Imagem</td>
          <td style="padding:5px;" colspan="6" bgcolor="#CCCCCC"><img src="<?php echo $row_categorias_cv['catcv_imagem']; ?>" alt="<?php echo $row_categorias_cv['catcv_nome']; ?>" /></td>
        </tr>
        <tr>
          <td style="padding:5px;">Conteudo</td>
          <td style="padding:5px;" colspan="6" bgcolor="#CCCCCC"><?php echo $row_categorias_cv['catcv_conteudo']; ?></td>
        </tr>
        <?php } while ($row_categorias_cv = mysql_fetch_assoc($categorias_cv)); ?>
    </table>
<br  class="cancela" />    
</div><!--fim div conteudo admin -->
    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>
</body>
</html>
<?php
mysql_free_result($categorias_cv);
?>
