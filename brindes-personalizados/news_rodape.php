<?php
date_default_timezone_set('America/Sao_Paulo'); 
$query_Menu_categorias = "SELECT * FROM categorias_brindes ORDER BY cat_nome ASC";
$Menu_categorias = mysql_query($query_Menu_categorias) or die(mysql_error());
$row_Menu_categorias = mysql_fetch_assoc($Menu_categorias);
$totalRows_Menu_categorias = mysql_num_rows($Menu_categorias);

?>
<div id="chat_online">

<!-- mibew button --><a href="/chat/client.php?locale=pt-br" target="_blank" title="Fale agora com um de nossos atendentes" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(&#039;/chat/client.php?locale=pt-br&amp;url=&#039;+escape(document.location.href)+&#039;&amp;referrer=&#039;+escape(document.referrer), 'mibew', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/chat/b.php?i=simple&amp;amp;lang=pt-br" border="0" width="130" height="135" alt=""/></a><!-- / mibew button -->
</div>

<div id="fundo_rodape">
					
                    <div class="formas_pagamento">
                    <span class="span_rod">
                    <div class="footer-img"></div>- Formas de Pagamento</span>
                   <center>
                   <ul>
                   <li style="font-size:10px; float:left; list-style:none; margin-left:5px;">Crédito</li>
                   <br />
                   <div class="img_pagamentos1"></div>
                   <div class="img_pagamentos1-5"></div>
                   <br /><br />
                   <br />
                   <li style="font-size:10px; float:left;list-style:none;margin-left:5px;">Débito</li>
                   <br />
                   <div class="img_pagamentos2"></div>
                   <br />
                   <br />
                   <li style="font-size:10px; float:left;list-style:none;margin-left:5px;">Boleto</li>
                   <br />
                   <div class="img_pagamentos3"></div>
                   <br /><br />
                  
                   <div style="float:left;">
                   
                   <p style="color:#999; margin:0 10px 10px 10px; font-size:10px; float:left;">Veja também &#8250;</p>
                   <a href="../devolucao-trocas.php" title="Política de trocas e devoluções da THE Brindes">
                   <p style="color:#333; float:left; margin-left:10px; font-size:14px;">Política de trocas e devoluções</p>
                   </a>
                   </div>
                  
                   </ul>
                  </center>
                   
                   
                   
                    </div><!-- FIM FORMAS_PAGAMENTO-->

                    <div class="rodape_seguranca">
                    <span class="span_rod">
                    <div class="footer-img"></div>- Seguran&ccedil;a</span>
                    <br />
                    <a href="http://www.internetsegura.org/" style="margin:5px;"><div style="background-image:url(../imagens/imgFooter.png); width:57px; height:22px; margin: 0 auto 0 auto;"></div></a>
                    <center>
                   <ul>
                   <li style="font-size:10px; float:left; list-style:none; margin: 0 auto 0 auto;">Certificações</li>
                   <br />
                   <table width="135" border="0" cellpadding="2" cellspacing="0" title="Clique para verificar - Este site selecionou o Symantec SSL para realizar e-commerce seguro e manter as comunicações confidenciais.">
<tr>
<td width="135" align="center" valign="top"><script  type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.teresinabrindes.com.br&amp;size=M&amp;use_flash=NO&amp;use_transparent=NO&amp;lang=pt"></script><br />
<a href="http://www.verisign.com/products-services/security-services/ssl/ssl-information-center/" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;">Sobre certificados SSL</a></td>
</tr>
</table><br  /><br /><br />
					
                    
                    <div>
                    	<p style="color:#999; font-size:10px; margin:5px; float:left;">Veja também &#8250;</p><br />
                       <a href="../seguranca-privacidade.php" title="Privacidade e segurança da THE Brindes"><p style="color:#333; float:left; margin-left:10px; font-size:14px;">Privacidade e Segurança</p></a>
                    </div>
                   </ul>
                   </center>
                    </div><!-- FIM RODAPE_SEGURANCA-->
                    
                    <div class="rodape_televendas">
                    <!--<span class="span_rod"><div class="footer-img"></div>Televendas</span>
                    <center>
                    <ul class="text-televendas">
                    <li> (86) 3084-2019</li>
                    <p style="color:#999; font-size:9px;">Para comprar ou tirar dúvidas sobre produtos e preços, é só ligar. 
                    <br />Segunda até Sexta das 8h às 23:45hs e Sábados, Domingos e Feriados das 8h às 20h.</p>
                    </ul>
                    </center>-->
                    <span class="span_rod"><div class="footer-img"></div>- Atendimento</span>
                     <center>
                    <ul class="text-televendas">
                    <li> (86) 3221-0215</li>
                    <p style="color:#999; font-size:10px;">Para comprar ou tirar dúvidas sobre produtos e preços, é só ligar. 
                    <br />Segunda até Sexta das 8h às 18hs e aos Sábados das 8h às 12h.</p><br />
                    <li> MSN/SKYPE teresinabrindes@hotmail.com</li>
                    <p style="color:#999; font-size:10px;">Estamos online de segunda a sexta das 9h às 18h, basta nos adicionar.<br /><br /> 
                    <li> contato@teresinabrindes.com.br</li>
                    <p style="color:#999; font-size:10px;">Para clientes de Internet e Televendas</p>
                    <br />
                    
                    
                    </ul>
                    </center>
                    
                    </div><!-- FIM RODAPE_TELEVENDAS-->
                                       
                    <div class="rodape_redes">
                    <span class="span_rod"><div class="footer-img"></div>- Redes Sociais</span>

						<div id="fb-root"></div>
						<script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=107283522716859";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-like-box" data-href="http://www.facebook.com/thebrindes" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true"></div>
                    </div><!-- FIM RODAPE_REDES-->
                    
                    
                    
				</div><!-- FIM FUNDO_FORMAS_PAGAMENTO-->
				
                
                
                
					
                    <div id="rodape_categorias">
                       <div id="conteudo_rodape_categorias">
					    <!--<ul class="conteudo_footer"><li><a href="#" rel=""></a></li></ul>
          				<!--<div id="traco"></div>-->
              		</div>

	<br class="cancela" />
	<!--<div id="linha_topo_rodape"></div>-->


	<!--<div class="rodape_institucional">
						<span class="span_rod"><div class="footer-img"></div>Institucional</span>
						
						<ul class="text-institucional">
						<li>Sobre a TheBrindes</li>
						<li>Política de Privacidade</li>
						<li>Programa de Afiliados TheBrindes <span style="font-size:10px; color:#F00;">EM BREVE</span></li>
						<li>Soluções Corporativas</li>
						</ul>
						
						
						</div><!-- FIM RODAPE_INSTITUCIONAL-->

						<div id="linha_bottom_rodape"></div>
	<br />
	<br />
	<p align="center" style="color:#666; font-size:12px; font-family:Arial, Helvetica, sans-serif">&copy; 2012-<?php include "../copyright.php"; ?> - TERESINA BRINDES LTDA - Todos os direitos reservados. </p>
	<br />
	<!--<p align="center" style="font-size:9px;">
	Preços e condições exclusivos para o site www.teresinabrindes.com.br e para o televendas, podendo sofrer alterações sem prévia notificação.
	Invista Publicidade LTDA / www.teresinabrindes.com.br / Rua Area Le&atilde;o, Nº 735 – 1º andar / Teresina - PI - CEP. : 64.310-000 / CNPJ: xx.xxx.xxx/0001-xx / Inscrição Estadual: xxx.xxx.xxx.xxx / <br /> Telefone: (86) 3084-2019 / contato@teresinabrindes.com.br / Caixa postal exclusiva para o envio/recebimento de correspondências da loja virtual: 19083 CEP: 64.310-000 - Teresina – PI / Endereço de nossas filiais</p> -->

	</div>
</div>