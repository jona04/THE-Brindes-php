<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$quantidade = 9; //quantidade de registros por  pagina
$pag = 1;
if (isset($_GET['pag'])) {
  $pag = $_GET['pag'];
}
$inicio = ($pag*$quantidade)-$quantidade;

$categoria_produto = "-1";
if (isset($_GET['id_categoria'])) {
  $categoria_produto = $_GET['id_categoria'];
}

$query_rsProdutos = "SELECT cb.cat_id, cb.cat_nome, produtos.pro_id, produtos.pro_cat_id, produtos.pro_nome, produtos.pro_detalhe, produtos.pro_imagem FROM produtos, categorias_brindes cb WHERE cb.cat_id = produtos.pro_cat_id AND cb.cat_id = '$categoria_produto' ORDER BY pro_nome ASC";
$query_limit_rsProdutos = "$query_rsProdutos LIMIT $inicio, $quantidade";
$rsProdutos = mysql_query($query_limit_rsProdutos) or die(mysql_error());
$row_rsProdutos = mysql_fetch_assoc($rsProdutos);

if (isset($_GET['totalRows_rsProdutos'])) {
  $totalRows_rsProdutos = $_GET['totalRows_rsProdutos'];
} else {
  $all_rsProdutos = mysql_query($query_rsProdutos);
  $totalRows_rsProdutos = mysql_num_rows($all_rsProdutos);
}
$paginas = ceil($totalRows_rsCategorias/$quantidade);
$links = 3;
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
    <h2 align="center">Produtos</h2>
        
        
        <p>&nbsp;</p>
        <h3 align="center">Produtos <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_rsProdutos) ?> de <?php echo $totalRows_rsProdutos ?> </h3>
      <table border="1" cellpadding="1" cellspacing="1" align="center">
        <tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Categoria</td>
        
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_rsProdutos['pro_id']; ?></td>
              <td><?php echo $row_rsProdutos['pro_nome']; ?></td>
              <td><?php echo $row_rsProdutos['cat_nome']; ?></td>
              
              <td><a href="detalhe_brindes.php?id=<?php echo $row_rsProdutos['pro_id']; ?>">Visualizar</a></td>
              <td><a href="edita_produto_brindes.php?id=<?php echo $row_rsProdutos['pro_id']; ?>">Editar</a></td>
              <td>Deletar</td>
              
            </tr>
            <?php } while ($row_rsProdutos = mysql_fetch_assoc($rsProdutos)); ?>
        </table>
<p>&nbsp;</p>
    <br  class="cancela" />
    </div><!-- fim div conteudo admin -->    
		<div id="paginacao">
        <?php
        if($query_rsProdutos > 9){
        echo "<a href='categoria_produtos_brindes.php?pag=1'>primeira pagina </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='categoria_produtos_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href=#>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='categoria_produtos_brindes.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='categoria_produtos_brindes.php?pag=".$paginas."'>ultima pagina </a>&nbsp;&nbsp;";
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
