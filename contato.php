<?php 
if(isset($_POST['nome_contato'])){
		
	$nome = $_POST['nome_contato'];
	$email = $_POST['email_contato'];
	$fone = $_POST['fone_contato'];
	$msg = $_POST['msg'];
	
	$var = "<script>javascript:history.back(-1)</script>";

	$arroba = '@';
	//função para ver se existe arroba no email
	$email_validado = stripos($email,$arroba);
	//valida formuilario contato
	if($nome == '' || $email == '' || $fone == '' || $msg == ''){
		echo '<script>alert("Por favor preencha todos os campos.")</script>';
		echo $var;
	}elseif($email_validado === false){
		echo '<script>alert("Por favor informe um e-mail válido.")</script>';
		echo $var;
	}else{
	$emailsender2 = "teres387@teresinabrindes.com.br";
	
	// Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
	if(PHP_OS == "Linux") $quebra_linha2 = "\n"; //Se for Linux
	elseif(PHP_OS == "WINNT") $quebra_linha2 = "\r\n"; // Se for Windows
	else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
	
		/* Montando o cabeçalho da mensagem */
	$headers2 = "MIME-Version: 1.1".$quebra_linha2;
	$headers2 .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha2;
	// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
	$headers2 .= "From: ".$emailsender2.$quebra_linha2;
	$headers2 .= "Return-Path: " . $emailsender2 . $quebra_linha2;
	
	$Destinatario2="contato@teresinabrindes.com.br";
	$Titulo2="Contato pelo site! Teresina Brindes";
	
	$mensagem2 =   "Nome: $nome <br />
					Email: $email <br />
					Fone: $fone <br />
					Mensagem: $msg
						";
		
		
		/* Enviando a mensagem */
		if(mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2)){
		echo '<script>alert("Mensagem enviada com sucesso.")</script>';	
		//header('Location: index.php');
		}
	}//fim else formulario válido
}//fim if envia mensagem

?>
<div id="centraliza_infoempresa" style="width:600px; margin-left:auto; margin-right:auto;">
        <div id="titulo_maior_info" class="arredonda_contato">
			<div class="img_vitrine4"></div>
           <p class="titulo2">Contato</p> 
       	</div><!-- fim titulo menu categoria -->
            <br />
    	<div id="conteudo_contato">
        	<form class="form_contato" action="infoEmpresa.php?c=c" method="post" id="form_validado">
        	<p class="p_contato">
			  <label class="l_contato" for="nome_contato">Nome</label><br />
        	  <input class="i_contato" type="text" name="nome_contato" id="nome_contato">
            </p>
            <p class="p_contato">
			  <label class="l_contato" for="email_contato">Email</label><br />
			  <input class="i_contato" type="text" name="email_contato" id="email_contato">
			</p>            
            <p class="p_contato">
			  <label class="l_contato" for="fone_contato">DDD + Fone </label><br />
			  <input class="i_contato" type="text" name="fone_contato" id="fone_contato">
			</p>        
           <p class="p_contato">
			  <label class="l_contato" for="msg">Sua mensagem</label><br />
			  <textarea class="t_contato" name="msg" id="msg" cols="50" rows="5" ></textarea>
			</p>                 
          <br />
          <p class="p_contato">
          	<input id="envia_contato" type="submit" class="novo-botao-verde2" value="Enviar" />
          </p>

		</form>
    
        </div><!-- fim div conteudo contato-->
    
    
    
    <div class="direita-contato">
                <p class="text-contato">&#8226; Entre em contato por telefone: 86 3221-0215  </p>
                <p class="text-contato">&#8226; Entre em contato por e-mail: <a href="mailto:contato@teresinabrindes.com.br">contato@teresinabrindes.com.br</a>  </p>
                <p class="text-contato">&#8226; Ou se preferir nos adicione no MSN/SKYPE: <a href="mailto:atendimento@hotmail.com"> teresinabrindes@hotmail.com</a> | Estamos online de segunda à sexta das 8h às 18h  </p>
   

    
           </div><!-- direita-contato -->
           
               
</div>