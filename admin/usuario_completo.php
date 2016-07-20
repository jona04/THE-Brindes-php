<?php require_once('../Connections/teresinabrindes.php'); 
include 'funcoes_admin.php';

//recebe id usuario via get
if(isset($_GET['id'])){
	$id_usu = $_GET['id'];	
}
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

$query_rsUsu = "SELECT * FROM usuarios ORDER BY usu_id ASC";
$rsUsu = mysql_query($query_rsUsu) or die(mysql_error());
$row_rsUsu = mysql_fetch_assoc($rsUsu);

$query_rsEnd = "SELECT * FROM endereco WHERE end_usu_id = '$id_usu'";
$rsEnd = mysql_query($query_rsEnd) or die(mysql_error());
$row_rsEnd= mysql_fetch_assoc($rsEnd);
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
      <h3 align="center"></h3>
        <table width="538" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr bgcolor="#CCC">
            <td style="padding:5px;">Rua</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_endereco']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Cep</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_cep']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Numero</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_numero']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Complemento</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_complemento']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Bairro</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_bairro']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Cidade</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_cidade']; ?></strong></td>
          </tr>
          <tr bgcolor="#CCC">
            <td style="padding:5px;">Estado</td>
            <td style="padding:5px;"><strong><?php echo $row_rsEnd['end_estado']; ?></strong></td>
          </tr>
      </table>
<p>&nbsp;</p>
   <br clas="cancela" />
   </div><!-- fim div conteudo admin -->
    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div><!-- fim div container admin -->
</body>
</html>
