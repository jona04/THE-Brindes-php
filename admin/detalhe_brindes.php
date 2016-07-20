<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

$colname_rsProdutos = "-1";
if (isset($_GET['id'])) {
  $colname_rsProdutos = $_GET['id'];
}

$query_rsProdutos = "SELECT categorias_brindes.cat_nome, produtos.pro_id, produtos.pro_nome, produtos.pro_detalhe, produtos.pro_imagem, produtos.pro_estoque, produtos.pro_exibir FROM produtos, categorias_brindes WHERE pro_id = '$colname_rsProdutos' AND categorias_brindes.cat_id = produtos.pro_cat_id";
$rsProdutos = mysql_query($query_rsProdutos) or die(mysql_error());
$row_rsProdutos = mysql_fetch_assoc($rsProdutos);
$totalRows_rsProdutos = mysql_num_rows($rsProdutos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../estilo.css" rel="stylesheet" type="text/css" />

<title>Documento sem t&iacute;tulo</title>

</head>

<body>
<div class="container_admin">
    <div class="topo_admin"></div>    

    <div class="conteudo_admin">
    
    <?php include "menu_admin.php"?>
    <h2 align="center"><?php echo $row_rsProdutos['pro_nome']; ?></h2>
        
        
      <p>&nbsp;</p>
        <table width="423" border="1" align="center">
          <tr>
            <td colspan="2">&nbsp;</td>
            <td width="64"><a href="edita_produto_brindes.php?id=<?php echo $row_rsProdutos['pro_id']; ?>">Editar</a></td>
            <td width="62">Excluir</td>
          </tr>
          <tr>
            <td width="59">Categoria</td>
            <td width="250"><?php echo $row_rsProdutos['cat_nome']; ?></td>
            <td colspan="2" rowspan="6" align="center"><img src="<?php echo $row_rsProdutos['pro_imagem']; ?>" alt="<?php echo $row_rsProdutos['pro_nome']; ?>" /></td>
          </tr>
          <tr>
            <td>Detalhe</td>
            <td><?php echo $row_rsProdutos['pro_detalhe']; ?></td>
          </tr>
          <tr>
            <td>Estoque</td>
            <td><?php echo $row_rsProdutos['pro_estoque']; ?></td>
          </tr>

        </table>
        <p>&nbsp;</p>
      <p>&nbsp;</p>
        <p align="center">Bem vindo a area do administrador</p>
    </div>

<br  class="cancela" />    

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div>

</body>
</html>
<?php
mysql_free_result($rsProdutos);
?>
