<?php
include('db.php');

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');
		
// recebe o id da subcategoria
if(isset($_POST['subcatid']))
	$subcat_id = $_POST['subcatid'];
//captura o nome da subcategoria para adicionar a largura certa
$qr_subcatDiv = mysql_query("SELECT subcat_id, subcat_div FROM subcategorias_brindes WHERE subcat_id = '$subcat_id'") or die(mysql_error());
$pega_subcat = mysql_fetch_assoc($qr_subcatDiv);
$subcat_div = $pega_subcat['subcat_div'];

// função para retirar acentos e passar a frase para minúscula
function normaliza($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
$b = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYobsaaaaaaceeeeiiiidnoooooouuuyybyRr';
$string = utf8_decode($string);
$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
$string = str_replace(" ","-",$string); // retira espaco
$string = strtolower($string); // passa tudo para minusculo
return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

if(!empty($_POST['itens'])){
	//se existir sessão da imagem visualizada exclui a sessão e o arquivo da mesma	

	if(isset($_SESSION['nome_imagem'])){
		unlink('geradas/'.$_SESSION['nome_imagem']);
		unset($_SESSION['nome_imagem']);
	}
	//nome do usuario para servir de pasta
	if(isset($_SESSION['nome_usuario'])){
		//$nome_usuario = normaliza($_SESSION['nome_usuario']);
		$idUsuario = $_SESSION['id_usu'];
	}
	//data para servir como nome da pasta
	$data_pasta = date("d-m-Y");
	if($subcat_div=='area_qc_quadrado'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 255, 255, 255,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagejpeg($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefromjpeg($imageFileName);  	
		}
		
		//gera foto mesclada -->
		
		  
		//$foto = imagecreatefromjpeg('imagens/plotter.jpg');  
		//$foto = imagecreatefromjpeg( $_FILES['foto']['tmp_name']);      
		imagecopymerge($foto, $moldura, 0,0,0,0, imagesx($moldura), imagesy($moldura),20);
		imagejpeg($foto, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	
	}elseif($subcat_div == 'area_caneca_branca'){
					
				// mudamos o timezone para nao termos problema com datas
			date_default_timezone_set('America/Sao_Paulo');
			
			// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
			$width = empty($_POST['area']['width']) ? 300 : sprintf('%d',$_POST['area']['width']);
			// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
			$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);

			// criamos a imagem e colocamos um fundo branco
			$img = imagecreatetruecolor($width, $height);
			// Define a cor transparente e pintamos toda a imagem
			$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
			imagefill( $img, 0, 0, $corTransparente );	
			//deixa a imagem transparente
			$transparente = imagecolortransparent($img,$corTransparente);
		
		
			// para cada imagem enviada
			foreach($_POST['itens'] as $item){
				//se te o elemnto src
				if(!empty($item['src'])){
					// pegamos somente o nome do arquivo e ignoramos o restante
					// vamos procurar por ela dentro da pasta "imagens"
					if(isset($_SESSION['email_the'])){	
						$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
					}else{
						$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
					}
					$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
					//$_SESSION['extensao'] = $extensao;
					// verifica se o arquivo existe			
					if (file_exists($filename)){				
						
						// pegamos o restante das informacoes enviadas
						// via post para esta imagem
						$w = $item['width'];
						$h = $item['height'];
						$x = $item['x'];
						$y = $item['y'];				
						//verifica a extensão para usar o comando apropriado
						if($extensao == 'png'){
							// vamos ler a imagem			
							$lerimagem = imagecreatefrompng($filename);					
						}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
							// vamos ler a imagem			
							$lerimagem = imagecreatefromjpeg($filename);	
						}
						
						// pegar a largura da imagem
						$img_largura = imagesx($lerimagem);			
						// pegar a altura da imagem
						$img_altura = imagesy($lerimagem);										
						// agora é só copiar a imagem original para dentro da nova imagem				
						imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
						//pega o lado esquerdo da figura
						//imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
		
						// Pronto, fim. Libera a memória usada				
						imagedestroy($lerimagem);
						//imagedestroy($nova);
					
					}
				}
			}
		
			//data para servir como nome da pasta
			$data_pasta = date("d-m-Y");
			//nome do usuario para servir de pasta
			//$nome_usuario = $_SESSION['nome_usuario'];
			
			
			//verifica a extensão para usar comando apropriado
			if($extensao == 'png'){
				// salve o arquivo
				$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
				$imageFileName = 'preVisualizadas/'.$nome_imagem;
				imagepng($img,$imageFileName);	
				$foto = imagecreatefrompng($imageFileName);

	
				$thumb = imagecreatetruecolor(185, 161);
				$source = imagecreatefrompng($imageFileName);
				
				//cria imagem lado 1
				$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.png';
				imagecopy($thumb, $source, 0, 0, 0, 0, 185, 161); //define as cordenadas e o tamanho da imagem a ser cortada
				imagepng($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
				$foto1 = imagecreatefrompng('preVisualizadas/'.$nome_lado1);
				//cria imagem lado 2
				$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.png';
				imagecopy($thumb, $source, 0, 0, 185, 0, 185, 161);
				imagepng($thumb,'preVisualizadas/'.$nome_lado2,9);
				$foto2 = imagecreatefrompng('preVisualizadas/'.$nome_lado2);
							
			}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
				
				$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
				$imageFileName = 'preVisualizadas/'.$nome_imagem;
				imagepng($img,$imageFileName);
				$foto = imagecreatefrompng($imageFileName);			

$source = imagecreatefrompng($imageFileName);
$thumb = imagecreatetruecolor(185, 161);

		// criamos a imagem e colocamos um fundo branco
		//$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($thumb, 255, 255, 255,127);
		imagefill( $thumb, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

				
				//cria imagem lado 1
				$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.jpg';
				imagecopy($thumb, $source, 0, 0, 0, 0, 185, 161); //define as cordenadas e o tamanho da imagem a ser cortada
				imagepng($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
				$foto1 = imagecreatefrompng('preVisualizadas/'.$nome_lado1);
				//cria imagem lado 2
				$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.jpg';
				imagecopy($thumb, $source, 0, 0, 185, 0, 185, 161);
				imagepng($thumb,'preVisualizadas/'.$nome_lado2);
				$foto2 = imagecreatefrompng('preVisualizadas/'.$nome_lado2);
			
			}

			//destroi imagens nao utilizadas
			imagedestroy($thumb);         
			imagedestroy($source);
			
			//junta imagem com moldura
			$moldura1 = imagecreatefromjpeg('imagens/moldura_caneca_branca.jpg');
			imagecopy($moldura1, $foto1, 127,55,0,0,185,161);
			imagejpeg($moldura1, 'preVisualizadas/'.$nome_lado1);  
			imagedestroy($moldura1);         
			imagedestroy($foto1);
			
			$moldura2 = imagecreatefromjpeg('imagens/moldura_caneca_branca2.jpg');
			imagecopy($moldura2, $foto2, 3,55,0,0,185,161);
			imagejpeg($moldura2, 'preVisualizadas/'.$nome_lado2);  
			imagedestroy($moldura2);         
			imagedestroy($foto2);
			
			//armazena o nome da imagem para deleta-la posteriormente
			$_SESSION['nome_imagem'] = $nome_imagem;
			$_SESSION['nome_imagem2'] = $nome_lado1;
			$_SESSION['nome_imagem3'] = $nome_lado2;

	}elseif($subcat_div== 'area_almofada_quadrada'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);
	
			
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 110,50,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 26)
	}elseif($subcat_div== 'area_ecobag'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);
		
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 110,190,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 27)
	}elseif($subcat_div== 'area_capa_notebook14'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 0, 0, 0,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$white);
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 80,60,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 28)
	}elseif($subcat_div== 'area_mousepad_ret'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 0, 0, 0,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$white);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,12,12,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 28,30,0,0, imagesx($foto)-10, imagesy($foto)-10,100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 29)
	}elseif($subcat_div== 'area_azulejo_porcelana'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w-20,$h-20,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 27,27,0,0, imagesx($foto)-20, imagesy($foto)-20,100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 30)
	}elseif($subcat_div== 'area_almofada_coracao'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 90,50,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 34)
		}elseif($subcat_div == 'area_caneca_rosa'){
					
				// mudamos o timezone para nao termos problema com datas
			date_default_timezone_set('America/Sao_Paulo');
			
			// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
			$width = empty($_POST['area']['width']) ? 300 : sprintf('%d',$_POST['area']['width']);
			// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
			$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
			
			// criamos a imagem e colocamos um fundo branco
			//$img = imagecreatetruecolor($width, $height);
			//$white = imagecolorallocate($img, 255, 255, 255);
			//imagefilledrectangle($img, 0, 0, $width, $height, $white);


			// criamos a imagem e colocamos um fundo branco
			$img = imagecreatetruecolor($width, $height);
			// Define a cor transparente e pintamos toda a imagem
			$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
			imagefill( $img, 0, 0, $corTransparente );	
			//deixa a imagem transparente
			$transparente = imagecolortransparent($img,$corTransparente);


			// para cada imagem enviada
			foreach($_POST['itens'] as $item){
				//se te o elemnto src
				if(!empty($item['src'])){
					// pegamos somente o nome do arquivo e ignoramos o restante
					// vamos procurar por ela dentro da pasta "imagens"
					if(isset($_SESSION['email_the'])){	
						$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
					}else{
						$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
					}
					$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
					//$_SESSION['extensao'] = $extensao;
					// verifica se o arquivo existe			
					if (file_exists($filename)){				
						
						// pegamos o restante das informacoes enviadas
						// via post para esta imagem
						$w = $item['width'];
						$h = $item['height'];
						$x = $item['x'];
						$y = $item['y'];				
						//verifica a extensão para usar o comando apropriado
						if($extensao == 'png'){
							// vamos ler a imagem			
							$lerimagem = imagecreatefrompng($filename);					
						}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
							// vamos ler a imagem			
							$lerimagem = imagecreatefromjpeg($filename);	
						}
						
						// pegar a largura da imagem
						$img_largura = imagesx($lerimagem);			
						// pegar a altura da imagem
						$img_altura = imagesy($lerimagem);										
						// agora é só copiar a imagem original para dentro da nova imagem				
						imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
						//pega o lado esquerdo da figura
						//imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
		
						// Pronto, fim. Libera a memória usada				
						imagedestroy($lerimagem);
						//imagedestroy($nova);
					
					}
				}
			}
		
			//data para servir como nome da pasta
			$data_pasta = date("d-m-Y");
			//nome do usuario para servir de pasta
			//$nome_usuario = $_SESSION['nome_usuario'];
			
			
			//verifica a extensão para usar comando apropriado
			if($extensao == 'png'){
				// salve o arquivo
				$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
				$imageFileName = 'preVisualizadas/'.$nome_imagem;
				imagepng($img,$imageFileName);	
				$foto = imagecreatefrompng($imageFileName);

	
				$thumb = imagecreatetruecolor(180, 156);
				$source = imagecreatefrompng($imageFileName);

				
				//cria imagem lado 1
				$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.png';
				imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
				imagepng($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
				$foto1 = imagecreatefrompng('preVisualizadas/'.$nome_lado1);
				//cria imagem lado 2
				$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.png';
				imagecopy($thumb, $source, 0, 0, 180, 0, 180, 156);
				imagepng($thumb,'preVisualizadas/'.$nome_lado2,9);
				$foto2 = imagecreatefrompng('preVisualizadas/'.$nome_lado2);
							
			}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
				$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
				$imageFileName = 'preVisualizadas/'.$nome_imagem;
				imagejpeg($img,$imageFileName);
				$foto = imagecreatefromjpeg($imageFileName);			

$source = imagecreatefromjpeg($imageFileName);
$thumb = imagecreatetruecolor(180, 156);
				
				$black = imagecolorallocate($thumb,0, 0, 0); 
				imagecolortransparent($thumb, $black);

				
				//cria imagem lado 1
				$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.jpg';
				imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
				imagejpeg($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
				$foto1 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado1);
				//cria imagem lado 2
				$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.jpg';
				imagecopy($thumb, $source, 0, 0, 180, 0, 180, 156);
				imagejpeg($thumb,'preVisualizadas/'.$nome_lado2);
				$foto2 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado2);
			
			}

			//destroi imagens nao utilizadas
			imagedestroy($thumb);         
			imagedestroy($source);
			
			//junta imagem com moldura
			$moldura1 = imagecreatefromjpeg('imagens/moldura_caneca_rosa.jpg');
			imagecopy($moldura1, $foto1, 113,50,0,0,180,156);
			imagejpeg($moldura1, 'preVisualizadas/'.$nome_lado1);  
			imagedestroy($moldura1);         
			imagedestroy($foto1);
			
			$moldura2 = imagecreatefromjpeg('imagens/moldura_caneca_rosa2.jpg');
			imagecopy($moldura2, $foto2, 5,50,0,0,180,156);
			imagejpeg($moldura2, 'preVisualizadas/'.$nome_lado2);  
			imagedestroy($moldura2);         
			imagedestroy($foto2);
			
			//armazena o nome da imagem para deleta-la posteriormente
			$_SESSION['nome_imagem'] = $nome_imagem;
			$_SESSION['nome_imagem2'] = $nome_lado1;
			$_SESSION['nome_imagem3'] = $nome_lado2;

	//fim if(subcat_id == 35)
	}elseif($subcat_div == 'area_caneca_azul'){
				
			// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d',$_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		//$img = imagecreatetruecolor($width, $height);
		//$white = imagecolorallocate($img, 255, 255, 255);
		//imagefilledrectangle($img, 0, 0, $width, $height, $white);	

		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);		
		
		
		
		
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				if(isset($_SESSION['email_the'])){	
					$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
					$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//pega o lado esquerdo da figura
					//imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		//data para servir como nome da pasta
		$data_pasta = date("d-m-Y");
		//nome do usuario para servir de pasta
		//$nome_usuario = $_SESSION['nome_usuario'];
		
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);


			$thumb = imagecreatetruecolor(180, 156);
			$source = imagecreatefrompng($imageFileName);
			
			//cria imagem lado 1
			$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.png';
			imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
			imagepng($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
			$foto1 = imagecreatefrompng('preVisualizadas/'.$nome_lado1);
			//cria imagem lado 2
			$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.png';
			imagecopy($thumb, $source, 0, 0, 180, 0, 180, 156);
			imagepng($thumb,'preVisualizadas/'.$nome_lado2,9);
			$foto2 = imagecreatefrompng('preVisualizadas/'.$nome_lado2);
						
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			$foto = imagecreatefrompng($imageFileName);			

$source = imagecreatefrompng($imageFileName);
$thumb = imagecreatetruecolor(180,156);
			
			$black = imagecolorallocate($thumb,255, 255, 255); 
			imagecolortransparent($thumb, $black);

			
			//cria imagem lado 1
			$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.jpg';
			imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
			imagejpeg($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
			$foto1 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado1);
			//cria imagem lado 2
			$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.jpg';
			imagecopy($thumb, $source, 0, 0, 180, 0, 180, 156);
			imagejpeg($thumb,'preVisualizadas/'.$nome_lado2);
			$foto2 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado2);
		
		}

		//destroi imagens nao utilizadas
		imagedestroy($thumb);         
		imagedestroy($source);
		
		//junta imagem com moldura
		$moldura1 = imagecreatefromjpeg('imagens/moldura_caneca_azul.jpg');
		imagecopy($moldura1, $foto1, 120,115,0,0,180,156);
		imagejpeg($moldura1, 'preVisualizadas/'.$nome_lado1);  
		imagedestroy($moldura1);         
		imagedestroy($foto1);
		
		$moldura2 = imagecreatefromjpeg('imagens/moldura_caneca_azul2.jpg');
		imagecopy($moldura2, $foto2, 5,115,0,0,180,156);
		imagejpeg($moldura2, 'preVisualizadas/'.$nome_lado2);  
		imagedestroy($moldura2);         
		imagedestroy($foto2);
		
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
		$_SESSION['nome_imagem2'] = $nome_lado1;
		$_SESSION['nome_imagem3'] = $nome_lado2;
	//fim if(subcat_id == 36)
	}elseif($subcat_div== 'area_prato_ceramica'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor(479, 500);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 187, 170, 158,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x+115,$y+125,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefrompng('imagens/'.'molduras_' . $nome_moldura.'.png');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefrompng('imagens/'.'molduras_' . $nome_moldura.'.png');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($foto,$moldura, 0,0,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($foto, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 37)
	}elseif($subcat_div == 'area_caneca_magica'){
				
			// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d',$_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//deixa a imagem transparente
		//$transparente = imagecolortransparent($img,$white);
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				if(isset($_SESSION['email_the'])){	
					$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
					$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//pega o lado esquerdo da figura
					//imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		//data para servir como nome da pasta
		$data_pasta = date("d-m-Y");
		//nome do usuario para servir de pasta
		//$nome_usuario = $_SESSION['nome_usuario'];
		
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);


			$thumb = imagecreatetruecolor(180, 156);
			$source = imagecreatefrompng($imageFileName);
			
			//cria imagem lado 1
			$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.png';
			imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
			imagepng($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
			$foto1 = imagecreatefrompng('preVisualizadas/'.$nome_lado1);
			//cria imagem lado 2
			$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.png';
			imagecopy($thumb, $source, 0, 0, 180, 0, 180, 156);
			imagepng($thumb,'preVisualizadas/'.$nome_lado2,9);
			$foto2 = imagecreatefrompng('preVisualizadas/'.$nome_lado2);
						
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagejpeg($img,$imageFileName);
			$foto = imagecreatefromjpeg($imageFileName);			

$source = imagecreatefromjpeg($imageFileName);
$thumb = imagecreatetruecolor(180, 156);
			
			$black = imagecolorallocate($thumb,255, 255, 255); 
			imagecolortransparent($thumb, $black);

			
			//cria imagem lado 1
			$nome_lado1 = 'visu1-'.md5(uniqid(time())).'.jpg';
			imagecopy($thumb, $source, 0, 0, 0, 0, 180, 156); //define as cordenadas e o tamanho da imagem a ser cortada
			imagejpeg($thumb,'preVisualizadas/'.$nome_lado1); //copia a imagem cortada
			$foto1 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado1);
			//cria imagem lado 2
			$nome_lado2 = 'visu2-'.md5(uniqid(time())).'.jpg';
			imagecopy($thumb, $source, 0, 0, 180, 0, 180,156);
			imagejpeg($thumb,'preVisualizadas/'.$nome_lado2);
			$foto2 = imagecreatefromjpeg('preVisualizadas/'.$nome_lado2);
		
		}

		//destroi imagens nao utilizadas
		imagedestroy($thumb);         
		imagedestroy($source);
		
		//junta imagem com moldura
		$moldura1 = imagecreatefromjpeg('imagens/moldura_caneca_magica.jpg');
		imagecopy($moldura1, $foto1, 93,50,0,0,180,156);
		imagejpeg($moldura1, 'preVisualizadas/'.$nome_lado1);  
		imagedestroy($moldura1);         
		imagedestroy($foto1);
		
		$moldura2 = imagecreatefromjpeg('imagens/moldura_caneca_magica2.jpg');
		imagecopy($moldura2, $foto2, 6,50,0,0,180,156);
		imagejpeg($moldura2, 'preVisualizadas/'.$nome_lado2);  
		imagedestroy($moldura2);         
		imagedestroy($foto2);
		
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
		$_SESSION['nome_imagem2'] = $nome_lado1;
		$_SESSION['nome_imagem3'] = $nome_lado2;
	//fim if(subcat_id == 38)
	}elseif($subcat_div== 'area_almofada_redonda'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 250, 250, 250,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 70,110,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 39)
	}elseif($subcat_div== 'area_almofada_baby'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 254, 254, 254,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 70,70,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 40)
	}elseif($subcat_div=='area_guirlanda'){
		
		// mudamos o timezone para nao termos problema com datas
		date_default_timezone_set('America/Sao_Paulo');
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 255, 255, 255,127);
		imagefill( $img, 0, 0, $corTransparente );	
		//deixa a imagem transparente
		$transparente = imagecolortransparent($img,$corTransparente);

		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				//$filename = 'imagens/' . pathinfo($item['src'], PATHINFO_BASENAME);	
				if(isset($_SESSION['email_the'])){	
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);
				}
				$nome_extensao = explode('.', pathinfo($item['src'], PATHINFO_BASENAME));
				$extensao = strtolower(end($nome_extensao));
				//$_SESSION['extensao'] = $extensao;
				// verifica se o arquivo existe			
				if (file_exists($filename)){				
					
					// pegamos o restante das informacoes enviadas
					// via post para esta imagem
					$w = $item['width'];
					$h = $item['height'];
					$x = $item['x'];
					$y = $item['y'];				
					
					//verifica a extensão para usar o comando apropriado
					if($extensao == 'png'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefrompng($filename);					
					}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
						// vamos ler a imagem			
						$lerimagem = imagecreatefromjpeg($filename);	
					}
					
					// pegar a largura da imagem
					$img_largura = imagesx($lerimagem);			
					// pegar a altura da imagem
					$img_altura = imagesy($lerimagem);										
					// agora é só copiar a imagem original para dentro da nova imagem				
					imagecopyresampled($img,$lerimagem,$x,$y,0,0,$w,$h,$img_largura,$img_altura);
					//imagecopymerge($moldura, $lerimagem, $x, $y, 0,0,$w,$h,50,100,30);
	
					// Pronto, fim. Libera a memória usada				
					imagedestroy($lerimagem);
					//imagedestroy($nova);
				
				}
			}
		}
	
		
		$nome_moldura = $_POST['nome_moldura'];
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.png';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_' . $nome_moldura.'.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			$nome_imagem = 'visu-'.md5(uniqid(time())).'.jpg';
			$imageFileName = 'preVisualizadas/'.$nome_imagem;
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefrompng('imagens/'.'molduras_' . $nome_moldura.'.png');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($foto,$moldura, 0,0,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($foto, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//zerando as varriáveis, mesmo assim ele repete a última foto
		unset($_POST,$_FILES,$foto,$moldura,$imageFileName);
		$_POST = NULL;  
		$_FILES = NULL;
		$foto = NULL;
		$moldura = NULL;
		$imageFileName = NULL;
	
			
		//armazena o nome da imagem para deleta-la posteriormente
		$_SESSION['nome_imagem'] = $nome_imagem;
	//fim if(subcat_id == 41)
	}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<center>
<?php if($subcat_div == 'area_qc_quadrado'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_caneca_branca'){ ?>

<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Sua imagem é essa:</span> <br />
<br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem']; ?>"/>
<br />
<br />
<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Entenda agora como sua imagem ficaria na caneca.</span> <br /><br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem2']; ?>"/>
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem3']; ?>"/>
<br />
<span style="margin:0 0 0 -30px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado esquerdo</span> 
<span style="margin:0 0 0 150px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado direito</span>
<br />

<?php }elseif($subcat_div == 'area_almofada_quadrada'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_ecobag'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_mousepad_ret'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_azulejo_porcelana'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_almofada_coracao'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_caneca_rosa'){ ?>

<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Sua imagem é essa:</span><br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem']; ?>"/>
<br />
<br />
<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Entenda agora como sua imagem ficaria na caneca.</span><Br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem2']; ?>"/>
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem3']; ?>"/>
<br />
<span style="margin:0 0 0 -30px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado esquerdo</span> 
<span style="margin:0 0 0 150px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado direito</span>
<br />

<?php }elseif($subcat_div == 'area_caneca_azul'){ ?>

<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Sua imagem é essa:</span><br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem']; ?>"/>
<br />
<br />
<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Entenda agora como sua imagem ficaria na caneca.</span><br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem2']; ?>"/>
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem3']; ?>"/>
<br />
<span style="margin:0 0 0 -30px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado esquerdo</span> 
<span style="margin:0 0 0 150px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado direito</span>
<br />


<?php }elseif($subcat_div == 'area_prato_ceramica'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_caneca_magica'){ ?>

<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Sua imagem é essa:</span><br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem']; ?>"/>
<br />
<br />
<span style="color:#999; font-weight:bolder; font-size:20px; font-family:Arial, Helvetica, sans-serif">Entenda agora como sua imagem ficaria na caneca.</span><br /> <br />
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem2']; ?>"/>
<img src="preVisualizadas/<?php echo $_SESSION['nome_imagem3']; ?>"/>
<br />
<span style="margin:0 0 0 -30px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado esquerdo</span> 
<span style="margin:0 0 0 150px; color:#808080; font-weight:bolder; font-size:18px; font-family:Arial, Helvetica, sans-serif">lado direito</span>
<br />

<?php }elseif($subcat_div == 'area_almofada_redonda'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div == 'area_almofada_baby'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php }elseif($subcat_div== 'area_guirlanda'){ ?>
<center><img src="preVisualizadas/<?php echo $nome_imagem; ?>"/></center>
<?php } ?>


</center>