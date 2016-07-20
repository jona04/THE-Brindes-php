<?php
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['adm']))
{
		
}else{
header("Location: ../index.php");	
}

if (isset($_GET['acao']) && $_GET['acao'] == 'sair'){
		header( "Location:index.php");
		unset($_SESSION['adm']);
		session_destroy();	
}

?>