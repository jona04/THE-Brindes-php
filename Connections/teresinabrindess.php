<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_teresinabrindess = "159.203.79.64";
$database_teresinabrindess = "teresina_brindes";
$username_teresinabrindess = "thebrindes";
$password_teresinabrindess = "nfjy1994";
$teresinabrindess = mysql_pconnect($hostname_teresinabrindess, $username_teresinabrindess, $password_teresinabrindess) or trigger_error(mysql_error(),E_USER_ERROR); 
?>