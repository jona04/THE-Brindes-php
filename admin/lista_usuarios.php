<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

/*--------- acaoo  excluir  ---------    */
if($_GET['acao'] == 'excluir1'){

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

$query_rsUsu = "SELECT * FROM usuarios ORDER BY usu_id ASC";
$query_limit_rsUsu = "$query_rsUsu LIMIT $inicio, $quantidade";
$rsUsu = mysql_query($query_limit_rsUsu) or die(mysql_error());
$row_rsUsu = mysql_fetch_assoc($rsUsu);

if (isset($_GET['totalRows_rsUsu'])) {
  $totalRows_rsUsu = $_GET['totalRows_rsUsu'];
} else {
  $all_rsUsu = mysql_query($query_rsUsu);
  $totalRows_rsUsu = mysql_num_rows($all_rsUsu);
}
$paginas = ceil($totalRows_rsUsu/$quantidade);
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
      <h3 align="center">Produtos <?php echo ($inicio + 1) ?> a <?php echo min($inicio + $quantidade, $totalRows_rsUsu) ?> de <?php echo $totalRows_rsUsu ?> </h3>
        <table width="800" border="0" align="center" cellpadding="1" cellspacing="1">
          <tr bgcolor="#666666">
            <td style="padding:5px;">Id</td>
            <td style="padding:5px;">Nome</td>
            <td style="padding:5px;">Email</td>
            <td style="padding:5px;">Telefone</td>
            <td style="padding:5px;">Celular</td>
          </tr>
          <?php do { ?>
            <tr bgcolor="#CCCCCC">
              <td style="padding:5px;"><strong><?php echo $row_rsUsu['usu_id']; ?></strong></td>
              <td style="padding:5px;"><a href="usuario_completo.php?id=<?php echo $row_rsUsu['usu_id']; ?>"><?php echo $row_rsUsu['usu_nome_comp']; ?></a></td>
              <td style="padding:5px;"><?php echo $row_rsUsu['usu_email']; ?></td>
              <td style="padding:5px;"><?php echo $row_rsUsu['usu_fone_prin']; ?></td>
              <td style="padding:5px;"><?php echo $row_rsUsu['usu_celular']; ?></td>
            </tr>
            <?php } while ($row_rsUsu = mysql_fetch_assoc($rsUsu)); ?>
      </table>
<p>&nbsp;</p>
   <br clas="cancela" />
   </div><!-- fim div conteudo admin -->
        <div id="paginacao">
        <?php
        if($totalRows_rsUsu > 9){
        echo "<a href='lista_usuarios.php?pag=1'>primeira pagina </a>&nbsp;&nbsp;";
        
        for($i = $pag-$links; $i <= $pag-1; $i++){
            if($i<=0){
            }else{
                echo "&nbsp;<a href='lista_usuarios.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
            echo "<a href=#>$pag</a>";
        
        for($i = $pag+1; $i <= $pag+$links; $i++){
            
            if($i>$paginas){
            }else{
                echo "&nbsp;&nbsp;<a href='lista_usuarios.php?pag=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
        }
        echo "&nbsp;&nbsp;<a href='lista_usuarios.php?pag=".$paginas."'>ultima pagina </a>&nbsp;&nbsp;";
        }//fim if
        ?>
        </div><!-- fim div paginacao -->
   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div><!-- fim div container admin -->
</body>
</html>