<?php 
if(eregi("google",$HTTP_USER_AGENT)) 
{ 
   if ($QUERY_STRING != "") 
   {$url = "http://".$SERVER_NAME.$PHP_SELF.'?'.$QUERY_STRING;} 
   else 
   {$url = "http://".$SERVER_NAME.$PHP_SELF;} 
   $today = date("F j, Y, g:i a"); 
   mail("jonatas.iw@gmail.com", "Foi detectado um robô de Google em http://$SERVER_NAME", 
   "$today - Google indexou a página $url.\n 
   ..:: MAIS OUTRA PÁGINA :) ::.."); 
} 
?>