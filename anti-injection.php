<?php
function anti_sql($texto){
	// Lista de palavras para procurar
	$check[1] = chr(34); // s�mbolo "
	$check[2] = chr(39); // s�mbolo '
	$check[3] = chr(92); // s�mbolo /
	$check[4] = chr(96); // s�mbolo `
	$check[5] = "drop table";
	$check[6] = "update";
	$check[7] = "alter table";
	$check[8] = "drop database";	
	//$check[9] = "drop";
	$check[9] = "select";
	$check[10] = "delete";
	$check[11] = "insert";
	//$check[13] = "alter";
	$check[12] = "destroy";
	//$check[15] = "table";
	$check[13] = "database";
	//$check[17] = "union";
	$check[14] = "TABLE_NAME";
	$check[15] = "1=1";
	$check[16] = 'or 1';
	//$check[21] = 'exec';
	$check[17] = 'INFORMATION_SCHEMA';
	//$check[23] = 'like';
	$check[18] = 'COLUMNS';
	//$check[25] = 'into';
	$check[19] = 'VALUES';
	
	// Cria se as vari�veis $y e $x para controle no WHILE que far� a busca e substitui��o
	$y = 1;
	$x = sizeof($check);
	// Faz-se o WHILE, procurando alguma das palavras especificadas acima, caso encontre alguma delas, este script substituir� por um espa�o em branco " ".
	while($y <= $x){
		   $target = strpos($texto,$check[$y]);
			if($target !== false){
				$texto = str_replace($check[$y], "", $texto);
			}
		$y++;
	}
	// Retorna a vari�vel limpa sem perigos de SQL Injection
	return $texto;
} 
?>