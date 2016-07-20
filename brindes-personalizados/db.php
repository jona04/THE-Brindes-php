<?php 
if(!isset($_SESSION)){
    session_start();
}


function get_home(){
    echo 'http://127.0.0.1/teresinabrindes';
}
function get_comunicacao_visual(){
    echo 'http://127.0.0.1/teresinabrindes/comunicacao-visual';
}
function get_brindes_personalizados(){
    echo 'http://127.0.0.1/teresinabrindes/brindes-personalizados';
}

$conexao = mysql_connect('127.0.0.1','root', '') or die (mysql_error());

        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET character_set_connection=utf8");
        mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_results=utf8");
		
mysql_select_db('teresina_brindes') or die ('Error ao conectar com o banco de dados, por favor entrar em contato com a Invista.');
/*
$conexao = mysql_connect('159.203.79.64','thebrindes', 'nfjy1994') or die (mysql_error());

        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET character_set_connection=utf8");
        mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_results=utf8");
        
mysql_select_db('teresina_brindes') or die ('Error ao conectar com o banco de dados, por favor entrar em contato com a Invista.');

function get_home(){
    echo 'http://teresinabrindes.com.br';
}
function get_comunicacao_visual(){
    echo 'http://teresinabrindes.com.br/comunicacao-visual';
}
function get_brindes_personalizados(){
    echo 'http://teresinabrindes.com.br/brindes-personalizados';
}*/
?>