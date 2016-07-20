<?php
include('db.php');
// se enviou imagens

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');
		
// recebe o id da subcategoria
if(isset($_POST['subcat_id'])){
	$subcat_id = $_POST['subcat_id'];
}
if(isset($_POST['pers_qtd'])){
	$qtd_no_nome = $_POST['pers_qtd'];
}
//captura o nome da subcategoria para adicionar a largura certa
$qr_subcatDiv = mysql_query("SELECT subcat_id, subcat_div,subcat_peso,subcat_altura,subcat_largura,subcat_comprimento FROM subcategorias_brindes WHERE subcat_id = '$subcat_id'") or die(mysql_error());
$pega_subcat = mysql_fetch_assoc($qr_subcatDiv);
$subcat_div = $pega_subcat['subcat_div'];
$peso = $_POST['pers_qtd'] * $pega_subcat['subcat_peso'];
$altura = $_POST['pers_qtd'] * $pega_subcat['subcat_altura'];
$largura = $pega_subcat['subcat_largura'];
$comprimento = $pega_subcat['subcat_comprimento'];

$idUsuario = $_POST['idUsuario'];

if(!empty($_POST['itens'])){
	
	//data para servir como nome da pasta
	$data_pasta = date("d-m-Y");
	//cria nome para imagem e imagem personalizada
	$nome_unico = md5(uniqid(time()));
	
	if($subcat_div=='area_qc_quadrado'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_qc_quadrado.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_qc_quadrado.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		
		imagecopymerge($foto, $moldura, 0,0,0,0, imagesx($moldura), imagesy($moldura),20);
		imagejpeg($foto, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	}//fim if subcat_id == 24
	elseif($subcat_div == 'area_caneca_branca'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			//$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			//$foto = imagecreatefromjpeg($imageFileName);	
		}
	}elseif($subcat_div== 'area_almofada_quadrada'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_almofada_quadrada.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_almofada_quadrada.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 110,50,0,0, imagesx($foto), imagesy($foto),70);
		imagejpeg($moldura, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
		//fim if subcat_id == 26
	}elseif($subcat_div== 'area_ecobag'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_ecobag.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_ecobag.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 110,190,0,0, imagesx($foto), imagesy($foto),70);
		imagejpeg($moldura, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if subcat_id == 27
	}elseif($subcat_div== 'area_capa_notebook14'){
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_capa_notebook14.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_capa_notebook14.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 80,60,0,0, imagesx($foto), imagesy($foto),70);
		imagejpeg($moldura, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if subcat_id == 28
	}elseif($subcat_div== 'area_mousepad_ret'){
		
		
		
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
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_mousepad_ret.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_mousepad_ret.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 28,30,0,0, imagesx($foto)-10, imagesy($foto)-10,100);
		imagejpeg($moldura, 'preVisualizadas/'.$nome_imagem, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if(subcat_id == 29)
	}elseif($subcat_div== 'area_azulejo_porcelana'){
		
		
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		// Define a cor transparente e pintamos toda a imagem
		$corTransparente = imagecolorallocatealpha($img, 253, 253, 253,127);
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
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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

		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/molduras_area_azulejo_porcelana.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/molduras_area_azulejo_porcelana.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		
		
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 27,27,0,0, imagesx($foto)-20, imagesy($foto)-20,100);
		imagejpeg($moldura,$imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 

	//fim if(subcat_id == 30)
	}elseif($subcat_div== 'area_almofada_coracao'){
		
		
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
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefrompng('imagens/'.'molduras_area_almofada_coracao.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefromjpeg('imagens/'.'molduras_area_almofada_coracao.jpg');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 90,50,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if subcat_id == 34
	}elseif($subcat_div == 'area_caneca_rosa'){
	
		
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			//$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			//$foto = imagecreatefromjpeg($imageFileName);	
		}	
	//fim if subcat_id == 35
	}elseif($subcat_div == 'area_caneca_azul'){
	
		
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			//$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			//$foto = imagecreatefromjpeg($imageFileName);	
		}	
	//fim if subcat_id == 36	
	}elseif($subcat_div== 'area_prato_ceramica'){
		
		
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
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			$moldura = imagecreatefrompng('imagens/molduras_area_prato_ceramica.png');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			$moldura = imagecreatefrompng('imagens/molduras_area_prato_ceramica.png');
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			$foto = imagecreatefromjpeg($imageFileName);	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($foto,$moldura, 0,0,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($foto, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if subcat_id == 37
	}elseif($subcat_div == 'area_caneca_magica'){
	
		
		
		// pegamos a largura da pagina enviada via post,  ou usamos 300 como padrao
		$width = empty($_POST['area']['width']) ? 300 : sprintf('%d', $_POST['area']['width']);
		// pegamos a altura da pagina enviada via post,  ou usamos 450 como padrao
		$height = empty($_POST['area']['height']) ? 450 : sprintf('%d', $_POST['area']['height']);
		
		// criamos a imagem e colocamos um fundo branco
		$img = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($img, 255, 255, 255);
		imagefilledrectangle($img, 0, 0, $width, $height, $white);	
		//$moldura = imagecreatefrompng('imagens/moldura3.png');
		// para cada imagem enviada
		foreach($_POST['itens'] as $item){
			//se te o elemnto src
			if(!empty($item['src'])){
				
				if(isset($_SESSION['email_the'])){
				// pegamos somente o nome do arquivo e ignoramos o restante
				// vamos procurar por ela dentro da pasta "imagens"
				$filename = 'enviados/'.$data_pasta. '/' . $idUsuario .'/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}else{
				$filename = 'enviados/temporarios/'. pathinfo($item['src'], PATHINFO_BASENAME);	
				}
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);	
			//$foto = imagecreatefrompng($imageFileName);
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagejpeg($img,$imageFileName);	
			//$foto = imagecreatefromjpeg($imageFileName);		
		}
		//fim if subcat_id == 38
	}elseif($subcat_div== 'area_almofada_redonda'){
		
		
		
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
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
		
		//verifica a extensão para usar comando apropriado
		if($extensao == 'png'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefrompng('imagens/molduras_area_almofada_redonda.jpg');
			$foto = imagecreatefrompng($imageFileName);  
			
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/molduras_area_almofada_redonda.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
			//mescla a foto  com a moldura     
			imagecopymerge($moldura,$foto, 70,110,0,0, imagesx($foto), imagesy($foto),100);
			imagejpeg($moldura, $imageFileName, 100);  
			imagedestroy($moldura);         
			imagedestroy($foto);

	//fim if subcat == 39
	}elseif($subcat_div== 'area_almofada_baby'){
		
		
		
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
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefromjpeg('imagens/molduras_area_almofada_baby.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefromjpeg('imagens/molduras_area_almofada_baby.jpg');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($moldura,$foto, 70,70,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($moldura, $imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if(subcat_id == 40)
	}elseif($subcat_div=='area_guirlanda'){
		
		
		
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
				$extensao = strtolower(end(explode('.', pathinfo($item['src'], PATHINFO_BASENAME))));
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
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.png';
			}
			imagepng($img,$imageFileName);
			
			$moldura = imagecreatefrompng('imagens/molduras_area_guirlanda.png');
			$foto = imagecreatefrompng($imageFileName);  	
		}elseif($extensao == 'jpg' || $extensao == 'jpeg'){
			// salve o arquivo
			if(isset($_SESSION['email_the'])){
				$imageFileName = 'enviados/'.$data_pasta.'/'.$idUsuario.'/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}else{
				$imageFileName = 'enviados/temporarios/personalizada-'.$qtd_no_nome.'-'.$nome_unico.'.jpg';
			}
			imagepng($img,$imageFileName);	
			
			$moldura = imagecreatefrompng('imagens/molduras_area_guirlanda.png');
			$foto = imagecreatefrompng($imageFileName);  	
		}
		//mescla a foto  com a moldura     
		imagecopymerge($foto,$moldura, 0,0,0,0, imagesx($foto), imagesy($foto),100);
		imagejpeg($foto,$imageFileName, 100);  
		imagedestroy($moldura);         
		imagedestroy($foto); 
	//fim if(subcat_id == 41)
	}

	
	
	
		
	//pega o preco do produto com id da subcategoria
	$sql_preco = mysql_query("SELECT subcat_id, subcat_preco FROM subcategorias_brindes WHERE subcat_id ='".$_POST['subcat_id']."' ")or die(mysql_error());
	$pega_preco = mysql_fetch_assoc($sql_preco);
	
	//adicionando endereço da imagem e informações do produto no carrinho
	//se usario estiver logado
	if(isset($_SESSION['email_the'])){

		//faz um loop para saber o id da foto que foi enviada pelo upload atraves de sua sessão
		foreach($_SESSION as $nome2 => $foto){
	
			if(substr($nome2,0,15) == 'imagem_enviada_'){
				$id2 = substr($nome2,15,( strlen($nome2) -15));
			}
		}
		
		$query_carrinho3 = mysql_query("SELECT car_id, car_pro_id,car_pro_imagem,car_pro_pers FROM carrinho WHERE car_pro_id = '".mysql_real_escape_string((int)$id2)."' AND car_email = '".mysql_real_escape_string($_SESSION['email_the'])."'");
		$carrinho3 = mysql_num_rows($query_carrinho3);
		$result_carrinho3 = mysql_fetch_assoc($query_carrinho3);
		//si o produto ja estiver no carrinho, so será alterado sua quantidade
		if($carrinho3>0){	
			mysql_query("UPDATE carrinho SET car_qtd='".mysql_real_escape_string($_POST['pers_qtd'])."' WHERE car_pro_id='".mysql_real_escape_string((int)$id2)."'") or die(mysql_error());
			//header('Location: checkout.php');
		
		}else{
			//USUARIO LOGADO - adiciona um produto no carrinho / checkout	
			mysql_query("INSERT INTO carrinho (car_pro_id,car_pro_imagem,car_email,car_qtd,car_preco,car_peso,car_altura,car_largura,car_comprimento,car_pro_pers) VALUES ('$id2','brindes-personalizados/".$imageFileName."','".$_SESSION['email_the']."','".$_POST['pers_qtd']."','".$pega_preco['subcat_preco']."','$peso',$altura,$largura,$comprimento,1)") or die(mysql_error()); //insere os campos na tabela	
			//atualiza foto_carrinho para 1, indicando que a foto esta sendo usada no carrinho por unm usuario cadastrado
			$update_sql = mysql_query("UPDATE fotos SET fotos_carrinho=1,fotos_atual=0 WHERE fotos_id = '".$id2."'");
		//header('Location:checkout.php');
		}
		
	//se nao existir sessão email
	}else{
		//faz um loop para saber o id da foto que foi enviada pelo upload atraves de sua sessão
		foreach($_SESSION as $nome2 => $fotoo2){
	
			if(substr($nome2,0,15) == 'imagem_enviada_'){
				//recebe o id do produto da sessao
				$id2 = substr($nome2,15,( strlen($nome2) -15));
				//verifica se o produto ja esta na tabela produto_personaliza, para nao ir repetido para o carrinho
				$verifica_id = mysql_query("SELECT pers_foto_id FROM produto_personalizado WHERE pers_foto_id = '$id2'") or die(mysql_error());
				$verifica_linhas = mysql_num_rows($verifica_id);
				if($verifica_linhas > 0){
					//zera o campo foto_atual de todos os outros produtos personalizados que existir, pra nao aparecer na area papel
					$zera_foto = mysql_query("UPDATE fotos SET fotos_atual=0 WHERE fotos_id = '$id2'");
				}else{
					//insere na tabela e no checkout o novo produto pesonalizado gerado
					mysql_query("INSERT INTO produto_personalizado (pers_foto_id,pers_subcat_id, pers_qtd,pers_peso,pers_altura, pers_largura, pers_comprimento, pers_imagem) VALUES ('$id2','".$_POST['subcat_id']."',".$_POST['pers_qtd'].",'".$peso."',".$altura.",".$largura.",".$comprimento.",'brindes-personalizados/".$imageFileName."')"); //insere os campos na tabela	
					//faz um update na tabela da foto que foi gerada, adicionando 1 em pers_carrinho
					$update_sql = mysql_query("UPDATE fotos SET fotos_carrinho=1, fotos_atual=0 WHERE fotos_id = '$id2'");
					$_SESSION['produtosPers_'.$id2] = $_POST['pers_qtd'];
				}
			}//fim if substr
		}//fim foreach
	}//fim else
	
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />