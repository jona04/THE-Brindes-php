<?php
require_once('Connections/teresinabrindes.php');

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

//recebe a ação para saber qual função realizar
$ac='';
if(isset($_GET['ac'])){
	$ac = $_GET['ac'];
}
//recebe o tipo do cadastro
if(isset($_GET['tipo'])){
$tipo = $_GET['tipo'];
}


//verifica se email ja existe
if(isset($tipo)){

	$consulta_cpf = mysql_query("SELECT usu_cpf FROM usuarios WHERE usu_cpf = '".$_GET['cpf']."'") or die(mysql_error());
	$total_usu_cpf = mysql_num_rows($consulta_cpf);

	$consulta_usu = mysql_query("SELECT usu_email FROM usuarios WHERE usu_email = '".$_GET['email']."'") or die(mysql_error());
	$total_usu = mysql_num_rows($consulta_usu);
	if($tipo=='cliente'){
		//se senha 1 for diferente de senha 2
		if($_GET['senha'] != $_GET['senha2']){
			//header("Location: cadastro_usuario.php?er=1");
			echo "<script>alert('Por favor confirme a senha correta.')</script>";
			echo "<script>javascript:history.back(-1)</script>";
		}elseif($total_usu > 0){
			//header("Location: cadastro_usuario.php?er=2");
			echo "<script>alert('O email informado ja existe.')</script>";
			echo "<script>javascript:history.back(-1)</script>";		
		}elseif($total_usu_cpf > 0){
			//header("Location: cadastro_usuario.php?er=3");
			echo "<script>alert('O CPF informado já existe.')</script>";
			echo "<script>javascript:history.back(-1)</script>";		
		}
		else{
			//dados pessoais
			$nome_comp = $_GET['nome_comp'];
			$cpf = $_GET['cpf'];
			$sexo = $_GET['sexo'];
			$ddd = $_GET['ddd'];
			$ddd2 = $_GET['ddd2'];
			$fone = $_GET['fone'];//FONE PRINCIPAL
			$cel = $_GET['cel'];//CELULAR
			$nascimento = $_GET['nascimento'];
			//dados endereço
			$cep = $_GET['cep'];
			$endereco = $_GET['endereco_cadastro'];
			$numero = $_GET['endereco_numero'];
			$complemento = $_GET['complemento'];
			$bairro = $_GET['bairro'];
			$cidade = $_GET['cidade'];
			$estado = $_GET['estado'];
			//dados acesso
			$senha = md5($_GET['senha']);
			$email = $_GET['email'];
			$data = date('d-m-Y');
			//adicona no banco
			$cadastrar = mysql_query("INSERT INTO usuarios (usu_nome_comp, usu_cpf, usu_nasc, usu_cep, ddd, ddd2, usu_fone_prin, usu_celular, usu_email, usu_senha, usu_sexo,usu_data)	VALUES('$nome_comp','$cpf','$nascimento','$cep','$ddd','$ddd2','$fone','$cel','$email','$senha','$sexo','$data')") or die(mysql_error()); //insere os campos na tabela	
	
			//recupera o ultimo id gerado pelo auto_increment
			$ultimo_id = mysql_insert_id();
			//adiciona endereço no banco
			$cadastrar_endereco = mysql_query("INSERT INTO endereco (end_usu_id, end_cep, end_endereco, end_numero, end_complemento, end_bairro, end_cidade, end_estado) VALUES ( '$ultimo_id', '$cep', '$endereco', '$numero','$complemento', '$bairro', '$cidade', '$estado' ) ") or die(mysql_error());
			
	
	
	
	
	
		$data2 = date('Y-m-d H:i:s');
		/* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
		//if (eregi(' tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
		if (eregi('teresinabrindes.com.br$', $_SERVER[HTTP_HOST])) {
				$emailsender='contato@teresinabrindes.com.br';
		} else {
				$emailsender = "contato@" . $_SERVER[HTTP_HOST];
				//    Na linha acima estamos forçando que o remetente seja 'webmaster@seudominio',
				// você pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
		}
		// Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
		if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
		else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
		
		/* Montando o cabeçalho da mensagem */
		
		$headers = "MIME-Version: 1.1".$quebra_linha;
		$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
		// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
		$headers .= "From: ".$emailsender.$quebra_linha;
		$headers .= "Return-Path: " . $emailsender . $quebra_linha;
			
			
			$Destinatario= "contato@teresinabrindes.com.br";
			$Titulo="Site TheBrindes - Novo usuário cadastrado!";
			$mensagem1=" Um novo usuário foi cadastrado no site: <br />
			Nome do usuario: $nome_comp <br />
			Email da usuario: $email <br />
			Data: $data2"; 
			
			/* Enviando a mensagem */
			mail($Destinatario, $Titulo, $mensagem1, $headers, "-r". $emailsender);
			
			
			//Enviando email para o novo cliente cadastrado
			
			/* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
		//if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
		if (eregi('teresinabrindes.com.br$', $_SERVER[HTTP_HOST])) {
				$emailsender2='contato@teresinabrindes.com.br';
		} else {
				$emailsender2= "contato@" . $_SERVER[HTTP_HOST];
				//    Na linha acima estamos forçando que o remetente seja 'webmaster@seudominio',
				// você pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
		}
		/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
		/*if(PHP_OS == "Linux") $quebra_linha2 = "\n"; //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha2 = "\r\n"; // Se for Windows
		else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
		
			/* Montando o cabeçalho da mensagem */
		$headers2 = "MIME-Version: 1.1".$quebra_linha2;
		$headers2 .= "Content-type: text/html; charset=iso-utf8".$quebra_linha2;
		// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
		$headers2 .= "From: ".$emailsender2.$quebra_linha2;
		$headers2 .= "Return-Path: " . $emailsender2 . $quebra_linha2;
		  
			$Destinatario2=$email;
			$senha = $_POST['senha'];
			$Titulo2="Cadastro realizado com sucesso";
			
			$mensagem2 = "
			
			
			 TheBrindes<br><br>

			 Olá, $nome_comp<br><br>
			 
			 Seu cadastro na TheBrindes foi realizado com sucesso.<br>
			 Agora você poderá usufruir de todos os nossos serviços de forma mais rápida e simples.<br>
			 Para isso basta acessar a area de clientes com as seguintes informações:<br>
			 <br><br>
			 E-mail: $email<br>
			 Senha:".$_GET['senha']."
			 <br>
			Atenciosamente: Equipe TheBrindes.

			";
		
			/* Enviando a mensagem */
			mail($Destinatario2, $Titulo2, $mensagem2, $headers2, "-r". $emailsender2);
			echo "<script>alert('Cadastro efetuado.')</script>";
			header("Location:loginCompra.php?login=s");
	}//fim else senha1 == senha2
	}//fim if usuario
}//fim if se existe get['email']

/* -----------  CARRINHO ----------------- */
//instancia a pagina do carrinho
$pagina = "checkout.php";
//inicar classe
class shopping{
/*
private $banco = 'teresina_brindes';
private $login = 'root';
private $senha = '';
private $hostname = '127.0.0.1';

private $banco = 'teresina brindes';
private $login = 'root';
private $senha = 'rootroot';
private $hostname = 'meubanco.copcbgdicyli.sa-east-1.rds.amazonaws.com';

	private $banco = 'bandabonan_4';
	private $login = 'bandabonan_4';
	private $senha = 'isacsa918273645';
	private $hostname = 'dbmy0019.whservidor.com';
*/
private $banco = 'teresina_brindes';
private $login = 'root';
private $senha = 'nfjy1994';
private $hostname = 'bdteresinabrindes.copcbgdicyli.sa-east-1.rds.amazonaws.com';	

	//variaveis privadas
	private $Total = 0;
	private $logadoTotal = 0;
	private $existe_produto = false;
	private $usuario_logado = false;
	
	function conexao(){	
	//conexão com banco de dados
	mysql_connect($this->hostname, $this->login, $this->senha) or die("Não foi possivel conectar ao banco de dados.");
	mysql_select_db($this->banco) or die("Não foi possivel selecionar o banco " . mysql_error());
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET character_set_connection=utf8");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_results=utf8");
	
	}
	
	
	
	//mostrar o carrinho
	function carrinho(){
		
		//verifica se usuario esta logado
		if(isset($_SESSION['email_the'])){
		$email_usuario = $_SESSION['email_the'];
			/*
			//montar carrinho de produto NAO PERSONALIZAVEL
			$query_carrinho2 = mysql_query("SELECT c.car_pro_pers,c.car_email,c.car_qtd, c.car_id, c.car_pro_id,c.car_pro_imagem, c.car_pro_pers, p.pro_id, p.pro_nome, p.pro_imagem, s.subcat_preco,s.subcat_id FROM subcategorias_brindes s, carrinho c, produtos p WHERE c.car_email = '".mysql_real_escape_string($email_usuario)."' AND c.car_pro_id = p.pro_id AND s.subcat_id = p.pro_subcat_id ") or die(mysql_error()); 		
			$total_linhas = mysql_num_rows($query_carrinho2);
			
			//se houver produto no carrinho
			if($total_linhas > 0){
				$this->existe_produto = true;
				while($carrinho2 = mysql_fetch_assoc($query_carrinho2)){
					
					//verificar si o prox produto é personalizado, para pega-lo com outros parametros 
					if($carrinho2['car_pro_pers'] != 1){
					
						//define o preço total
						$logadoSubTotal = $carrinho2['car_qtd'] * $carrinho2['subcat_preco'];
						echo "	
						<tr>
						<td nowrap>
							<a href='#'  width='50px'>
								<img src='admin/" . $carrinho2['car_pro_imagem'] . "' width='50px' alt='Imagem do produto'/>
				
								
							</a>
						</td>
						<td nowrap width='200px' class='info'> " . $carrinho2['pro_nome'] . "</td>
						<td nowrap class='quantity center'>
									<form action='funcoes.php?alt_id_logado=".$carrinho2['pro_id']."' method='post' >
									<input type='text' id='qtdProduto' name='qtdProduto' value='". $carrinho2['car_qtd'] ."' size='2' />
									<input type='submit' name='atualizar_qtd' class='i2Style' value='Atualizar Qtd' />
									</form>
							
						</td>
						<td nowrap class='price-inside'>
							R$" . number_format($carrinho2['subcat_preco'],2) . "
						</td>
						<td>
							<a class='remove' id='remove_proCarrinho' href='funcoes.php?ac=remove_logado&rem_id_logado=" . $carrinho2['pro_id'] .  "' title='Remover'>&nbsp;</a>
						</td>
						</tr>";
						$this->logadoTotal += $logadoSubTotal;
					}//fim while
				}//fim if é personalizado
			}//fim if num rows > 0
			*/
			//verifica produtos que estao no carrinho
			$p_pers = mysql_query("SELECT * FROM carrinho WHERE car_pro_pers = 1 AND car_email = '".$_SESSION['email_the']."'") or die(mysql_error());
			$total_p_pers = mysql_num_rows($p_pers);
			if($total_p_pers > 0){
				$this->existe_produto = true;
				//montar carrinho de produto personalizado
				$pd_pers_on = mysql_query("SELECT c.car_id, c.car_qtd,c.car_pro_imagem,c.car_pro_id, s.subcat_preco,s.subcat_id,s.subcat_nome,s.subcat_peso,s.subcat_altura,s.subcat_largura,s.subcat_comprimento,f.fotos_id,f.fotos_subcat_id FROM subcategorias_brindes s, carrinho c,fotos f WHERE c.car_pro_id = f.fotos_id AND f.fotos_subcat_id = s.subcat_id AND c.car_email = '".$_SESSION['email_the']."'") or die(mysql_error());
					
				while ($lista_pers_on = mysql_fetch_assoc($pd_pers_on)){
					
					//define o preço total
					$subTotal_pers_on = $lista_pers_on['car_qtd'] * $lista_pers_on['subcat_preco'];
					echo "	
						<tr>
						<td nowrap>
							<a href='#'>
								<img src='" . $lista_pers_on['car_pro_imagem'] . "' width='50px' alt='Imagem do produto'/>
		
								
							</a>
						</td>
						<td nowrap width='200px' class='info'> " . $lista_pers_on['subcat_nome'] . " com Upload</td>
						<td nowrap class='quantity center'>
								<form action='funcoes.php?id=".$lista_pers_on['subcat_id']."&altura=".$lista_pers_on['subcat_altura']."&largura=".$lista_pers_on['subcat_largura']."&comprimento=".$lista_pers_on['subcat_comprimento']."&peso=".$lista_pers_on['subcat_peso']."&alt_id_pers=".$lista_pers_on['car_id']."' method='post' >
								<input type='text' id='qtdProduto' name='qtdProduto' value='". $lista_pers_on['car_qtd'] ."' size='2' />
								<input type='submit' name='atualizar_qtd' class='i2Style' value='Atualizar Qtd'/>
								</form>
						</td>
						<td nowrap class='price-inside'>
							R$" . number_format($lista_pers_on['subcat_preco'],2, ',', '.') . "
						</td>
						<td>
						<a class='remove' id='remove_proCarrinho' href='funcoes.php?ac=remove_pers&rem_pers_id=" . $lista_pers_on['car_pro_id'] .  "' title='Remover'>&nbsp;</a>
						</td>
					</tr>";
					$this->logadoTotal += $subTotal_pers_on;
				}//fim while	
			}//fim if total pers			
			
		}//fim if usuario logado
		elseif($_SESSION){
			//monta cesta com produtos de uma usuario nao logado
			//verifica se existe uma session
			
			/*
			//separa nome de quantidade ou valor dos produtos nao personaliaveis
			foreach($_SESSION as $nome => $quantidade){

				if(substr($nome,0,9) == 'produtos_'){
					$this->existe_produto = true;
					$id = substr($nome,9,( strlen($nome) -9));
					//montar carrinho
					$pd = mysql_query("SELECT p.pro_id, p.pro_imagem,p.pro_cat_id,p.pro_subcat_id, p.pro_nome, s.subcat_preco,s.subcat_id FROM produtos p, subcategorias_brindes s WHERE p.pro_subcat_id = s.subcat_id AND p.pro_id =". mysql_real_escape_string((int)$id));
					
						
					while ($lista = mysql_fetch_assoc($pd)){
					
						echo "<script type='text/javascript'>$('document').ready(function(){";
					// If - Se o valor do option sendo testado for igual ao valor passado no parâmetro, adicionará o atributo selected
						echo "
							$(\"select[id='".$id."'] option\").each(function(){
							if($(this).text() == ". $quantidade .")
								$(this).attr('selected','selected');
							});
							";
						echo "});</script>";
						
						//define o preço total
						$subTotal = $quantidade * $lista['subcat_preco'];
						echo "	
							<tr>
							<td nowrap>
								<a href='#'>
									<img src='admin/" . $lista['pro_imagem'] . "' width='50px' alt='Imagem do produto'/>
			
									
								</a>
							</td>
							<td nowrap width='200px' class='info'> " . $lista['pro_nome'] . "</td>
							<td nowrap class='quantity center'>
								<form action='funcoes.php?alt_id=".$lista['pro_id']."' method='post' >
								<input type='text' style='width:40px' id='qtdProduto' name='qtdProduto' value='". $_SESSION['produtos_' . $lista['pro_id']] ."' size='2' />
								<input type='submit' name='atualizar_qtd' class='i2Style' value='Atualizar Qtd'/>
								</form>
								
							</td>
							<td nowrap class='price-inside'>
								R$" . number_format($lista['subcat_preco'],2, ',', '.') . "
							</td>
							<td>
						<a class='remove' id='remove_proCarrinho' href='funcoes.php?ac=remove&rem_id=" . $lista['pro_id'] .  "' title='Remover'>&nbsp;</a>
						</td>
						</tr>";
						//sessão total recebe o valor total do carrinho
						$this->Total += $subTotal;
						}//fim while

					}//im if substr	produtos_	
				}//fim foreach	
				*/
				
			//separa nome de quantidade ou valor dos produtos personaliaveis
			foreach($_SESSION as $nome2 => $quantidade2){

				if(substr($nome2,0,13) == 'produtosPers_'){
					
					$this->existe_produto = true;
					$id_pers = substr($nome2,13,( strlen($nome2) -13));
					//montar carrinho de produto personalizado
					$pd_pers = mysql_query("SELECT p.pers_id,p.pers_foto_id, p.pers_qtd,p.pers_imagem,p.pers_subcat_id, s.subcat_preco,s.subcat_id,s.subcat_nome,s.subcat_peso,s.subcat_altura,s.subcat_largura,s.subcat_comprimento FROM produto_personalizado p, subcategorias_brindes s WHERE p.pers_subcat_id = s.subcat_id AND p.pers_foto_id =". mysql_real_escape_string((int)$id_pers)) or die(mysql_error());
						
					while ($lista_pers = mysql_fetch_assoc($pd_pers)){
					
						echo "<script type='text/javascript'>$('document').ready(function(){";
					// If - Se o valor do option sendo testado for igual ao valor passado no parâmetro, adicionará o atributo selected
						echo "
							$(\"select[id='". $lista_pers['pers_id']."'] option\").each(function(){
							if($(this).text() == ". $lista_pers['pers_qtd'] .")
								$(this).attr('selected','selected');
							});
							";
						echo "});</script>";
						
						//define o preço total
						$subTotal_pers = $lista_pers['pers_qtd'] * $lista_pers['subcat_preco'];
						echo "	
							<tr>
							<td nowrap>
								<a href='#'>
									<img src='" . $lista_pers['pers_imagem'] . "' width='50px' alt='Imagem do produto'/>
			
									
								</a>
							</td>
							<td nowrap width='200px' class='info'> " . $lista_pers['subcat_nome'] . " com Upload</td>
							<td nowrap class='quantity center'>
								<form id='pqp' action='funcoes.php?id=".$lista_pers['subcat_id']."&altura=".$lista_pers['subcat_altura']."&largura=".$lista_pers['subcat_largura']."&comprimento=".$lista_pers['subcat_comprimento']."&peso=".$lista_pers['subcat_peso']."&id_foto=".$lista_pers['pers_foto_id']."&alt_id_pers=".$lista_pers['pers_id']."' method='post' >
								<input type='text' id='qtdProduto' name='qtdProduto' value='".$_SESSION['produtosPers_'.$lista_pers['pers_foto_id']]."' size='2' />
								<input type='submit' name='atualizar_qtd' class='i2Style' value='Atualizar Qtd'/>
								</form>
								
							</td>
							<td nowrap class='price-inside'>
								R$" . number_format($lista_pers['subcat_preco'],2, ',', '.') . "
							</td>
							<td>
						<a class='remove' id='remove_proCarrinho' href='funcoes.php?ac=remove_pers&rem_pers_id=" . $lista_pers['pers_foto_id'] .  "' title='Remover'>&nbsp;</a>
						</td>
						</tr>";
						$this->Total += $subTotal_pers;
					}//fim while 
				}//fim if substr produtosPers
			}//fim foreach			
		
		}// fim if session
			
			
		
		/*if($Total == 0){
			echo 'Não possui produtos';
			}else{
				
				echo $Total ;
				}*/
		
	}//fim function carrinho
	
	//USUARIO LOGADO retorna o valor total do carrinho
	function getLogadoTotal(){
		return number_format($this->logadoTotal,2);	
	}	
	//retorna o valor total do carrinho
	function getTotal(){
		return number_format($this->Total,2);	
	}
	// retorna true se existe produto no carrinho e false caso contrario
	function getExisteProduto(){
		
		//verifica se usuario esta logado
		if(isset($_SESSION['email_the'])){
			$email_usuario2 = $_SESSION['email_the'];
			//montar carrinho
			$query_carrinho2 = mysql_query("SELECT car_id FROM carrinho WHERE car_email = '".mysql_real_escape_string($email_usuario2)."'") or die(mysql_error()); 		
			$total_linhas = mysql_num_rows($query_carrinho2);
			//se houver produto no carrinho
			if($total_linhas > 0 ){
				$this->existe_produto = true;
			}
		}elseif($_SESSION){
				
			//separa nome de quantidade ou valor
			foreach($_SESSION as $nome => $quantidade){

				if(substr($nome,0,9) == 'produtos_'){
					$this->existe_produto = true;
				}
			}
		}//fim elseif(session)*/
		return $this->existe_produto;	
	}//fim function get existeProduto
		
	//returna true si usuario logao e false caso contrario
	function getUsuarioLogado(){
		if(isset($_SESSION['email_the']) && isset($_SESSION['nome'])){
		$this->usuario_logado = true;
		}
		return $this->usuario_logado;	
	}
	
}//fim classe

	/*if(isset($_SESSION))
	{
	//Abre a tag script
		echo "<script type='text/javascript'>$('document').ready(function(){";
		//Para cada índice passado por parâmetro....
		foreach($_SESSION as $nome2=>$valor)
		{
			if(substr($nome2,0,9) == 'produtos_'){
				$id2 = substr($nome2,9,( strlen($nome2) -9));
				echo "
				$(\"select[id='".$id2."'] option\").each(function(){
				if($(this).text() == '" . $valor . "')
					$(this).attr('selected','selected');
				});
				";
			}
		}
		//Seletor CSS: tags "options do select com nome igual ao índice do parâmetro passado
		// If - Se o valor do option sendo testado for igual ao valor passado no parâmetro, adicionará o atributo selected
		echo "});</script>";
		
	}*/

//adiciona um produto no carrinho / checkout	
if(isset($_GET['add_id'])){
	$verifica_qtd = (int)$_POST['qtdProduto'];
	if($verifica_qtd == '' || $verifica_qtd == 0 || $verifica_qtd < 0){
		//se no produto.php o usario clicar em comprar sem adicoonar a quantidade do produto, executa este comoando, msg de error
		header('Location: produto.php?msg_error=2&id='.$_GET['p_id'].'&cat='.$_GET['c_id'].'');
	}else{
		//query do produto adicionado para capturar seu preco
		$query_preco = mysql_query("SELECT p.pro_id, p.pro_subcat_id, s.subcat_id, s.subcat_preco FROM produtos p, subcategorias_brindes s WHERE p.pro_id = '".$_GET['add_id']."' AND p.pro_subcat_id = s.subcat_id") or die(mysql_error());
		$pega_preco = mysql_fetch_assoc($query_preco);
		
		if(isset($_SESSION['email_the'])){
			$query_carrinho3 = mysql_query("SELECT car_id, car_pro_id,car_pro_imagem FROM carrinho WHERE car_pro_id = '".mysql_real_escape_string($_GET['add_id'])."' AND car_email = '".mysql_real_escape_string($_SESSION['email_the'])."'");
			$carrinho3 = mysql_num_rows($query_carrinho3);
			//se o produto que foi adicionado ja existir, so será alterado sua qtd
			if($carrinho3>0){	
				mysql_query("UPDATE carrinho SET car_qtd='".mysql_real_escape_string($verifica_qtd)."' WHERE car_pro_id='".mysql_real_escape_string($_GET['add_id'])."'") or die(mysql_error());
				
				header('Location: checkout.php');
			}else{
				//USUARIO LOGADO - adiciona um produto no carrinho / checkout	
				mysql_query("INSERT INTO carrinho (car_pro_id,car_pro_imagem,car_email,car_qtd,car_preco) VALUES ('".mysql_real_escape_string($_GET['add_id'])."','".mysql_real_escape_string($_GET['pro_imagem'])."','".mysql_real_escape_string($_SESSION['email_the'])."','".mysql_real_escape_string($verifica_qtd)."','".mysql_real_escape_string($pega_preco['subcat_preco'])."')"); //insere os campos na tabela	
			header('Location:checkout.php');
			}
		//fim if existe sessao email
		}else{
			$_SESSION['produtos_' . $_GET['add_id']] = $verifica_qtd;//$_GET['qtdProduto'];	
			header('Location:checkout.php');
		}
	}//fim else existe qtd produto
}//fim if existe get add_id


//Altera quantidade do produto PERSONALIZADO direto no carrinho / checkout usario logado e nao logao
if(isset($_GET['alt_id_pers'])){
	$verifica_qtd = (int)$_POST['qtdProduto'];
	if($verifica_qtd == 0 || $verifica_qtd == '' || $verifica_qtd < 0){
		header ("Location:" . $pagina.'?msg_error=2');
	}else{
		
		//pega peso largura comprimento e arltura do produto passado via get
		$pega_peso = $_GET['peso'];
		$pega_altura = $_GET['altura'];
		$pega_largura = $_GET['largura'];
		$pega_comprimento = $_GET['comprimento'];
		
		//calcula peso, altura, largura e comprimento com a quantidade
		$peso = $verifica_qtd * $pega_peso;
		$comprimento = $pega_comprimento;
		$altura = $verifica_qtd * $pega_altura;
		$largura = $pega_largura;
		
		//se usurio estiver logado
		if(isset($_SESSION['email_the'])){
			$updateSQL = mysql_query("UPDATE carrinho SET car_peso='$peso',car_altura='$altura',car_largura='$largura',car_comprimento='$comprimento',car_qtd='".mysql_real_escape_string($verifica_qtd)."' WHERE car_id='".mysql_real_escape_string((int)$_GET['alt_id_pers'])."'") or die(mysql_error());
			header ("Location:" . $pagina);		
		}else{
			$updateSQL = mysql_query("UPDATE produto_personalizado SET pers_peso='$peso',pers_altura='$altura',pers_largura='$largura',pers_comprimento='$comprimento',pers_qtd='".mysql_real_escape_string($verifica_qtd)."' WHERE pers_id='".mysql_real_escape_string((int)$_GET['alt_id_pers'])."'") or die(mysql_error());
			$_SESSION['produtosPers_'.$_GET['id_foto']] = $verifica_qtd;
			header ("Location:" . $pagina);
		}
	}//fim else qtd == 0 ou vaizio
}
//USUARIO LOGADO altera quantidade do produto NAO personalizado direto no carrinho / checkout
if(isset($_GET['alt_id_logado'])){
	$verifica_qtd = (int)$_POST['qtdProduto'];
	if($verifica_qtd == 0 || $verifica_qtd == '' || $verifica_qtd < 0){
		header ("Location:" . $pagina.'?msg_error=2');
	}else{
		$updateSQL = mysql_query("UPDATE carrinho SET car_qtd='".mysql_real_escape_string($verifica_qtd)."' WHERE car_pro_id='".mysql_real_escape_string((int)$_GET['alt_id_logado'])."'") or die(mysql_error());
		header ("Location:" . $pagina);
	}
}
//altera quantidade do produto NAO personalizado direto no carrinho / checkout
if(isset($_GET['alt_id'])){
	$verifica_qtd = (int)$_POST['qtdProduto'];
	if($verifica_qtd == 0 || $verifica_qtd == '' || $verifica_qtd < 0){
		header ("Location:" . $pagina.'?msg_error=2');
	}else{
		$_SESSION['produtos_' . $_GET['alt_id']] = $verifica_qtd;//$_GET['qtdProduto'];
		header ("Location:" . $pagina);
	}
}



//remove o produto do carrinho / checkout
if($ac=='remove'){
	unset($_SESSION['produtos_' . $_GET['rem_id']] );
	//session_destroy();
	header ("Location:" . $pagina);
}
//USUARIO LOGADO remove o produto do carrinho / checkout
if($ac=='remove_logado'){
	$sql_del = mysql_query("DELETE FROM carrinho WHERE car_pro_id = '".mysql_real_escape_string((int) $_GET['rem_id_logado'] ). "'");	
	header ("Location:" . $pagina);
}
//REMOVE PRODUTO PERSONALIZADO de usuiario logado e nao logado
if($ac=='remove_pers'){
	if(isset($_SESSION['email_the'])){
		
		//monta carrinho do produto personalizado
		$query_del_car = mysql_query("SELECT car_pro_imagem,car_pro_id,car_pro_imagem,car_id FROM carrinho WHERE car_pro_id = '".mysql_real_escape_string((int)$_GET['rem_pers_id'] ). "'") or die(mysql_error());
		$imagem = mysql_fetch_assoc($query_del_car);
		//monta foto do produto personalizado
		$query_del_foto = mysql_query("SELECT fotos_endereco1,fotos_id FROM fotos WHERE fotos_id = '".mysql_real_escape_string((int)$imagem['car_pro_id']). "'") or die(mysql_error());
		$imagem_foto = mysql_fetch_assoc($query_del_foto);
		//captura o endereços das imagens
		$local_imagem_foto = "brindes-personalizados/".$imagem_foto['fotos_endereco1'];
		$local_imagem = $imagem['car_pro_imagem'];
		//deleta os produtos no banco de dados
		$sql_del = mysql_query("DELETE FROM carrinho WHERE car_pro_id = '".mysql_real_escape_string((int)$_GET['rem_pers_id'] ). "'") or die(mysql_error());
		$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '".mysql_real_escape_string((int)$_GET['rem_pers_id'] ). "'") or die(mysql_error());
		//deleta a sessão da imagem enviada
		unset($_SESSION['imagem_enviada_'.$_GET['rem_pers_id']]);
		
		//deleta os arquivos
		unlink($local_imagem);
		unlink($local_imagem_foto);

		//retorna para pagina
		header ("Location:".$pagina);
	
	}else{
		//monta carrinho do produto personalizado
		$query_del = mysql_query("SELECT pers_imagem,pers_foto_id FROM produto_personalizado WHERE pers_foto_id = '".mysql_real_escape_string((int) $_GET['rem_pers_id'] ). "'") or die(mysql_error());
		$imagem = mysql_fetch_assoc($query_del);
		//monta foto do produto personalizado
		$query_del_foto = mysql_query("SELECT fotos_endereco1 FROM fotos WHERE fotos_id = '".mysql_real_escape_string((int)$imagem['pers_foto_id']). "'") or die(mysql_error());
		$imagem_foto = mysql_fetch_assoc($query_del_foto);
		//captura o endereços das imagens
		$local_imagem_foto = "brindes-personalizados/".$imagem_foto['fotos_endereco1'];
		$local_imagem = $imagem['pers_imagem'];
		//deleta os produtos no banco de dados
		$sql_del = mysql_query("DELETE FROM produto_personalizado WHERE pers_foto_id = '".mysql_real_escape_string((int) $_GET['rem_pers_id'] ). "'");
		$sql_del = mysql_query("DELETE FROM fotos WHERE fotos_id = '".mysql_real_escape_string((int) $imagem['pers_foto_id'] ). "'");
		
		//deleta a sessão da imagem enviada
		unset($_SESSION['imagem_enviada_'.$imagem['pers_foto_id']]);
		unset ($_SESSION['produtosPers_'.$imagem['pers_foto_id']]);		
		
		//deleta os arquivos
		unlink($local_imagem);
		unlink($local_imagem_foto);
		
		//retorna para pagina
		header ("Location:" . $pagina);
	}//fim else
}//fim ac = remove produto personalizado


//executa ação comprar, direto do checkout, varificanco se a quantidade esta correta e se usuario esta logado
if($ac=='com'){
	$verifica_qtd = (int)$_GET['qtdProduto'];
	if($verifica_qtd == '' || $verifica_qtd == 0 || $verifica_qtd< 0){
		//se no produto.php o usario clicar em comprar sem adicoonar a quantidade do produto, executa este comoando, msg de error
		header('Location: checkout.php?msg_error=2');
	}else{
		if(!$_SESSION['email_the'] && !$_SESSION['nome']){
			header ("Location: loginCompra.php");
		}
		//nunca vai chegar aqui
		elseif(isset($_SESSION['email_the']) && isset($_SESSION['nome'])){
			// ELE SERÁ REDIRECIONADO PARA A PAGINA DE PAGAMENTO		
		}
	}//fim else quantidade produto
	
	
	
}//fim if ac == com

if(isset($_GET['sessao_frete']) && $_GET['sessao_frete'] == 'exclui'){
	unset($_SESSION['valor_frete']);
	//unset($_SESSION['valor_prazo']);	
}

?>