<?php
require_once('../Connections/teresinabrindes.php');
// função para retirar acentos e passar a frase para minúscula
function normaliza($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYobsaaaaaaceeeeiiiidnoooooouuuyybyRr';
$string = utf8_encode($string);
$string = strtr($string, utf8_encode($a), $b); //substitui letras acentuadas por "normais"
$string = str_replace(" ","-",$string); // retira espaco
$string = strtolower($string); // passa tudo para minusculo
return utf8_decode($string); //finaliza, gerando uma saída para a funcao
}


//PASTA DAS IMAGENS
$id_produto = $_GET['id'];
$produto = mysql_query("SELECT * FROM produtos WHERE pro_id = '$id_produto'") or die(mysql_error());
$ver_produto = mysql_fetch_assoc($produto);


$nome_produto = normaliza($ver_produto['pro_nome']);

echo $nome_produto . "<br>";


//foreach (glob("images/galerias/$pasta/*.*") as $filename) {
//echo "<img src='$filename' width='75' height='55' /></a>" ;

$dir = ("imagens/produtos/".$nome_produto."/");
echo $dir . "<br>";
$abrir = opendir($dir);
$arquivos = array();
//LOCALIZA APENAS AS IMAGENS QUE INICIAM COM p
foreach (glob($dir."*") as $file)
{
	if (($file != '.') && ($file != '..'))
	{

			$arquivos[] = $file;
echo $file . "<br>";
	}
}
?>