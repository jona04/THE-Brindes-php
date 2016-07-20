<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

/*--------- acaoo  excluir  ---------    */
if($_GET['acao'] == 'excluir'){

$del_categoria = $_GET['id'];

$sql_verifica = "SELECT c.cat_id, p.pro_cat_id, s.subcat_cat_id FROM categorias_brindes c, produtos p, subcategorias_brindes s WHERE c.cat_id = p.pro_cat_id AND c.cat_id='$del_categoria' OR s.subcat_cat_id='$del_categoria'";
$query_verifica = mysql_query($sql_verifica) or die(mysql_error());
$verifica_linhas = mysql_num_rows($query_verifica);
//if tiver produtos na categoria, nao será possivel deleta-la
if($verifica_linhas >= 1){
	echo '<script>alert("Não é possivel excluir essa categoria. Ela possui produtos ou sub-categorias.")</script>';
}
else{
	$sql_del_categoria = "SELECT cat_imagem FROM categorias_brindes WHERE cat_id = '$del_categoria'";
	$query_del = mysql_query($sql_del_categoria) or die(mysql_error());
	$imagem = mysql_fetch_assoc($query_del);
	//$local_imagem = $imagem['cat_imagem'];
	$sql_del = mysql_query("DELETE FROM categorias_brindes WHERE cat_id = '$del_categoria'");
		
	if($sql_del){
		echo '<script>alert("Categoria excluido com sucesso.");document.location.href="lista_categorias_brindes.php"</script>';
		}
	}
}//fim acao = excluir

$quantidade = 9; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;

$query_rsCategorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$query_limit_rsCategorias = "$query_rsCategorias LIMIT $inicio, $quantidade";
$rsCategorias = mysql_query($query_limit_rsCategorias) or die(mysql_error());
$row_rsCategorias = mysql_fetch_assoc($rsCategorias);

if (isset($_GET['totalRows_rsCategorias'])) {
  $totalRows_rsCategorias = $_GET['totalRows_rsCategorias'];
} else {
  $all_rsCategorias = mysql_query($query_rsCategorias);
  $totalRows_rsCategorias = mysql_num_rows($all_rsCategorias);
}
$paginas = ceil($totalRows_rsCategorias/$quantidade);
$links = 3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Editar Categoria em Brindes</title>

</head>

<body>
<div class="container_admin">
    <?php include "admin_topo.php"?>
       
	<?php include "menu_admin.php"?>

    <div class="conteudo_admin">
    <center>
    <h2 style="color:#666666;">Editar - Categorias de Brindes</h2>
    </center>
        
    
        <p>&nbsp;</p>
      <p>&nbsp;</p>
      <h3 align="center">Produtos <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_rsCategorias) ?> de <?php echo $totalRows_rsCategorias ?> </h3>
        <table width="538" border="0" align="center" cellpadding="1" cellspacing="1">
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="3" align="center"><a href="adiciona_categoria_brindes.php" style="color:#FF0000;"><strong>Adicionar Categoria</strong></a></td>
          </tr>
          <tr bgcolor="#666666">
            <td style="padding:5px;">Id</td>
            <td style="padding:5px;">Nome</td>
            
            <td style="padding:5px;">&nbsp;</td>
            <td style="padding:5px;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php do { ?>
            <tr bgcolor="#CCCCCC">
              <td style="padding:5px;"><strong><?php echo $row_rsCategorias['cat_id']; ?></strong></td>
              <td style="padding:5px;"><?php echo $row_rsCategorias['cat_nome']; ?></td>
              
              <td style="padding:5px;"><a href="categoria_produtos_brindes.php?id_categoria=<?php echo $row_rsCategorias['cat_id']; ?>">Produtos</a></td>
              <td style="padding:5px;"><a href="edita_categoria_brindes.php?id=<?php echo $row_rsCategorias['cat_id']; ?>">Editar</a></td>
              <td style="padding:5px;"><a href="?acao=excluir&id=<?php echo $row_rsCategorias['cat_id']; ?>">Excluir</a></td>
            </tr>
            <?php } while ($row_rsCategorias = mysql_fetch_assoc($rsCategorias)); ?>
      </table>
<p>&nbsp;</p>
   <br clas="cancela" />
   </div><!-- fim div conteudo admin -->
        <div id="paginacao">
        <?php
        if($totalRows_rsCategorias > 9){
        echo "<a href='lista_categorias_brindes.php?pag=1'>primeira pagina </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='lista_categorias_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href=#>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='lista_categorias_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='lista_categorias_brindes.php?pag=".$paginas."'>ultima pagina </a>&nbsp;&nbsp;";
        }//fim if
        ?>
        </div><!-- fim div paginacao -->
   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div><!-- fim div container admin -->
</body>
</html>
<?php
mysql_free_result($rsCategorias);
?>
