<?php
require_once('../Connections/teresinabrindes.php');

include 'funcoes_admin.php';

$acao = $_GET['acao'];
$des_id = $_GET['des_id'];
$del_id = $_GET['del_id'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = ("INSERT INTO destaques (des_pro_id) VALUES (" . $_POST['des_pro_id'] . ")");

  $Result1 = mysql_query($insertSQL) or die(mysql_error());
	if($Result1){
		echo '<script>alert("Destaque adicionada com sucesso.")</script>';
	}
}

/* inicio remover destaque */
if($acao=='excluir'){
$query_remover = "DELETE FROM destaques WHERE des_id = '$del_id'";
$remover = mysql_query($query_remover) or die(mysql_error());
if($remover){
	echo '<script>alert("Destaque removido com sucesso.")</script>';
}
}

$query_mostra_destaques = "SELECT d.des_id, d.des_pro_id, p.pro_id, p.pro_imagem, p.pro_nome FROM destaques d, produtos p WHERE d.des_pro_id = p.pro_id ";
$mostra_destaques = mysql_query($query_mostra_destaques) or die(mysql_error());
$row_mostra_destaques = mysql_fetch_assoc($mostra_destaques);
$totalRows_mostra_destaques = mysql_num_rows($mostra_destaques);

$query_produtos = "SELECT * FROM produtos";
$produtos = mysql_query($query_produtos) or die(mysql_error());
$row_produtos = mysql_fetch_assoc($produtos);
$totalRows_produtos = mysql_num_rows($produtos);

$query_destaques = "SELECT * FROM destaques";
$destaques = mysql_query($query_destaques) or die(mysql_error());
$row_destaques = mysql_fetch_assoc($destaques);
$totalRows_destaques = mysql_num_rows($destaques);
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
    
    <div id="lista_destaques">
      <table border="1" cellpadding="1" cellspacing="1">
        <tr>
          <td>Id</td>
          <td>Imagem</td>
          <td>Nome</td>
          <td>&nbsp;</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_mostra_destaques['des_id']; ?></td>
            <td><img src="<?php echo $row_mostra_destaques['pro_imagem']; ?>" width="78" height="78" alt="<?php echo $row_mostra_destaques['pro_nome']; ?>" /></td>
            <td><?php echo $row_mostra_destaques['pro_nome']; ?></td>
            <td><a href="?acao=excluir&del_id=<?php echo $row_mostra_destaques['des_id'] ?>">Excluir</a></td>
          </tr>
          <?php } while ($row_mostra_destaques = mysql_fetch_assoc($mostra_destaques)); ?>
      </table>
    </div>
    <div id="atualiza_destaque">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Des_pro_id:</td>
            <td><select name="des_pro_id">
              <?php 
    do {  
    ?>
              <option value="<?php echo $row_produtos['pro_id']?>" ><?php echo $row_produtos['pro_nome']?></option>
              <?php
    } while ($row_produtos = mysql_fetch_assoc($produtos));
    ?>
            </select></td>
          </tr>
          <tr> </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Inserir registro" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p>&nbsp;</p>
    </div>
	<br  class="cancela" />   
    </div><!-- fim div conteudo admin -->
   

    <div class="rodape">O conte&uacute;do de  class "rodape" &eacute; inserido aqui</div>

</div><!-- fim div container admin -->

</body>
</html>
