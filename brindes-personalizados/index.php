<?php
//ob_start("ob_gzhandler");
include 'db.php';
include '../config.php'; //url amigavel
include "../anti-injection.php";

//pega paramento da url que vem depois do / para direcionar para a devida pagina
//echo $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$url = $_GET['url']; 
$urlE = explode('/', $url);

echo $arquivo = $urlE['5'];

//verifica se existe subcatid valido e cat valido
$verifica_subcatid = mysql_query("SELECT * FROM subcategorias_brindes WHERE subcat_url_seo='$arquivo'") or die(mysql_error());
$cont_subcatid = mysql_num_rows($verifica_subcatid);
$result_subcat = mysql_fetch_assoc($verifica_subcatid);
if ($cont_subcatid > 0){
$verifica_catid = mysql_query("SELECT * FROM categorias_brindes WHERE cat_id='".$result_subcat['subcat_cat_id']."'") or die(mysql_error());
$pega_cat = mysql_fetch_assoc($verifica_catid);
$cont_catid = mysql_num_rows($verifica_catid);
}

//usado em area_imagens.php
$query_fotos="SELECT * FROM fotos";
$fotos = mysql_query($query_fotos) or die (mysql_error());
$linhas_fotos = mysql_fetch_assoc($fotos);
$total_linhaFotos = mysql_num_rows($fotos);

//usado em area_papel.php
$query_fotos2="SELECT * FROM fotos";
$fotos2 = mysql_query($query_fotos2) or die (mysql_error());
$linhas_fotos2 = mysql_fetch_assoc($fotos2);

/*$query_produtos="SELECT * FROM subcategorias_brindes WHERE subcat_id='$subcat_id'";
$produtos = mysql_query($query_produtos) or die (mysql_error());
$result_subcat = mysql_fetch_assoc($produtos);*/

$subcat_nome =  $result_subcat['subcat_nome'];
$nome_div_papel =  $result_subcat['subcat_div'];
$subcat_produto =  $result_subcat['subcat_id'];
//captura o nome da subcategoria para adicionar a largura certa

//variavel $pro_id nao existe, temos e inventar algo pra ela, pois o produto tbm nao existe, ele é personalizavel
//$query_new_produtos = "SELECT * FROM produtos WHERE pro_id = '$pro_id'";
//$new_produtos = mysql_query($query_new_produtos) or die(mysql_error());
//$row_new_produtos = mysql_fetch_assoc($new_produtos);

//para carrocel de produtos relacionados
$query_new_produtos2 = "SELECT * FROM subcategorias_brindes ORDER BY rand()";
$new_produtos2 = mysql_query($query_new_produtos2) or die(mysql_error());

//ISSO VAI SERVIR PARA CONCERTAR O ERRO DE ENVIAR MAIS DE 1 FOTO NO UPLOAD
//$permissao = 'true';

//PASTA DAS IMAGENS
$dir = ("../admin/imagens/subcategoria/".$nome_div_papel."/miniaturas/");
if(is_dir($dir)){
	$abrir = opendir($dir);
}
//PASTA DAS IMAGENS para IMAGEM PRINCIPAL ORÇAMENTO
$dir2 = ("../admin/imagens/subcategoria/".$nome_div_papel."/");
if(is_dir($dir2)){
	$abrir2 = opendir($dir2);
}
//$arquivos = array();

//identefica o browser
$browser = "";
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
$browser_version=$matched[1];
$browser = 'IE';
}

if(isset($_SESSION['email_the'])){
	$id_usuario = $_SESSION['id_usu'];
}else{
	$id_usuario = 0;
}
?>
<!DOCTYPE html>
<head>
<meta name="description" content="<?php echo $result_subcat['subcat_tag_descricao']; ?>" />
<meta name="keywords" content="<?php echo $result_subcat['subcat_tags']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- inicializa com o google olhar artigo -http://encosia.com/3-reasons-why-you-should-let-google-host-jquery-for-you/- -->
<!-- <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script> -->

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
 
<script type="text/javascript" src="js/tudo.js"></script>
<script type="text/javascript" src="../js/jquery.masked.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.session.js"></script>

<!-- script para rodas o carrocel dos produtos relacionados -->
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>

<!-- resposavel pela galeria de imagens do produto -->
<script type="text/javascript" src="js/slides.min.jquery.js"></script>


<script type="text/javascript">

//exemplo para só aparecer o icone de enviar arquivo quando a pagina estiver carregada
//jQuery(document).ready(function(){
//jQuery('body').hide();
//});
//window.onload=function(){jQuery('body').show();};

//quando a pagina estiver totalmente carrega, o formulario de enviar arquivo ficará disponivel
window.onload=function(){
	$('#formUpload').show();
	$('.icon_aguarde2').hide();
};

$(document).ready(function(){

	$(function() {
	$('.mask-qtd').mask('9999'); //quantidade
	$('.mask-fone').mask('(99) 9999-9999'); //telefone
	
	});
	
	$("#arquivo").livequery('click',function(){
		if($.session.get('imagem_enviada')){
			alert("Por favor, exclua sua imagem antes de selecionar outra.")
		}else{
			$("#arquivo").change(function() {
				$(this).prev().html($(this).val());
				
				nome_arquivo = $(this).val();
				var imagem = new Image();
				imagem.src = nome_arquivo;
				var tamanhoArquivo = imagem.fileSize;
				//alert(nome_arquivo.fileSize);
				
				TamanhoString = nome_arquivo.length;
				
				extensao   = nome_arquivo.substr(TamanhoString - 4,TamanhoString);
				var ext = new Array('.jpg','.png');
				for(var i = 0; i < ext.length; i++) 
				{ 
					if (extensao == ext[i])
					{
						flag = "ok";
						break;
					}
					else
					{
						flag = "erro";
					}
				}
				if (flag=="erro")
				{
					alert('Tipo de arquivo não permitido.')
					$(this).html('Selecione aqui seu arquivo');

					return false;
				}
				//cria uma sessão para saber se a imagem foi selecionada
				$.session.set('imagem_selecionada','true');
				
			});	
		}
		
		// Zerar o contador do PROGRESSO
		$('progress').attr('value',0);
		$('#porcentagem').html('0%');

	});
	
	
	var nome_div = '<?php echo $nome_div_papel; ?>';
	var subcat_id = '<?php echo $subcat_produto ?>';
	var idUsusario = '<?php echo $id_usuario; ?>';
    $('#btnEnviar').livequery('click',function(){
				
		$('#btnEnviar').hide();
		$('.icon_aguarde').show();
		
		//verifica se a imagem foi selecionada ante de clicar em enviar
		if($.session.get('imagem_selecionada') != 'true'){
			alert("Por favor, selecione sua imagem antes.");
			$('#btnEnviar').show();
			$('.icon_aguarde').hide();
		}else{
			$('#formUpload').ajaxForm({
				uploadProgress: function(event, position, total, percentComplete) {
					$('progress').attr('value',percentComplete);
					$('#porcentagem').html(percentComplete+'%');
					//$('#btnEnviar').hide();
					//$('.icon_aguarde').show();
				},        
				success: function(data) {
					$('.icon_aguarde').hide();
					$('.progress_bar').hide();
					$('#porcentagem').hide();

					$.ajaxSetup({
						cache: false
			 		});
					$.ajax({
						type:"GET",
						async: false,
						data:{nome_div:nome_div},
						url:"area_papel.php",
						success:function(atual){
							$(".img_arrastavel").remove();
							$("#area_papel").html(atual);
							// fazemos com que todas as imagens da lista possam ser arrastadas
							$("img[name='img_arrastavel']").draggable({
								revert:'invalid'
							});
							//cria sessao imagem enviada
							$.session.set('imagem_enviada','true');
							//remove imagem de especificações
							$(".class_img_guia").remove();
							
							 //$("#area_papel").load('area_papel.php');
						}
					});
					$("#area_imagens").load('area_imagens.php');
		
					$('progress').attr('value','100');
					$('#porcentagem').html('100%');                
					if(data.sucesso == true){
						//$('#resposta').html("<img src='" + data.msg + "' width='80px' /><img class='close' src='imagens/cancel.png' />");
					}
					else
					{
						alert("Olá, ocorreu o seguinte erro no envio de seu arquivo: \""+data.msg+"\". Por favor tente novamente.");
						window.location = "<?php echo $arquivo; ?>";
					}                
				},
				//error : function(jqXHR, textStatus, errorThrown) { 
				//console.log("error " + textStatus); console.log("incoming Text " + jqXHR.responseText); 
				//}, 
				error : function(data){
					alert("Olá, houve um erro no envio de seu arquivo, por favor tente novamente."+data.error);
					//$('#resposta').html('Erro ao enviar requisição!!!');
					window.location = "<?php echo $arquivo; ?>";
					//$('#resposta').html('Erro ao enviar requisição!!!');
				},
				dataType: 'json',
				data:{subcat_id:subcat_id},
				url: 'enviar_arquivo.php',
				//url: 'enviar_arquivo.php?subcatid=<?php// echo $subcat_id; ?>',
				resetForm: true
			}).submit();
			
		}//fim se isset sessão imagem selecionada
    });
	
	/*// Zerar o contador do PROGRESSO
	$('#arquivo').click(function(){
		$('progress').attr('value',0);
		$('#porcentagem').html('0%');
	});
	*/
	//PAGINATAÇÃO
	//roda slides das imagens dos produtos

	$('.li_pag').click(function(){

		$('body').css('overflow-x', 'hidden');
		$('html, body').scrollTop(10);
		
		var end_img = $(this).attr('id');
		//alert(end_img);
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		//alert($(this).attr('id'));
		
		$('#img_pagination2').show();
		$('#mascara').show();	
		$('#mascara').fadeIn(2000);	
		$('#mascara').fadeTo("slow",0.8);
		
		$('#mascara').css({'width':maskWidth,'height':maskHeight});	
		
		$('#img_pagination').attr("src", end_img);
		return false;
	});
	
	//orçamento paginação
	$('.li_pag2').click(function(){

		var end_img = $(this).attr('id');	
		
		$('#img_pagination_orc').attr("src", end_img);
		return false;
	});
	
	$('#mascara').click(function () {
		$(this).hide();
		$('.mascara').hide();
		$('#img_pagination2').hide();
	});	
	$('.fechar_visualizar').click(function () {
		$('#mascara').hide();
		$('.mascara').hide();
		$('#img_pagination2').hide();
	});	
	
	// fazemos com que todas as imagens da lista possam ser arrastadas
	$("img[name='img_arrastavel']").draggable({
		revert:'invalid'
	});
// fazemos com que todas as imagens da lista possam ser arrastadas
	$("#img_pagination_orc").draggable({
		revert:'invalid'
	});

	// a área do "papel" será onde os itens podem ser soltos
	$('#fundo_orcamento').droppable({
			//quando eu clicar na imagem arrastavel
			activate: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel estiver dentro do papel
			over: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel sair do papel
			out: function(event, ui) { 
				$(this)
				.css('backgroundColor', '#FF9D9D');
			},			
			// quando soltar um item no "papel"...
			drop: function(evt, ui){
				// referencia ao "papel", mais curta
				var t = $(this);
				// retorna o elemento arrastado
				var e = ui.draggable;
				// colocamos o elemento arrastado no papel
				e.appendTo(t);
			}
		});//fim funcção droppable	
	// a área do "papel" será onde os itens podem ser soltos
	$('#'+nome_div).droppable({
			//quando eu clicar na imagem arrastavel
			activate: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel estiver dentro do papel
			over: function(event, ui) { 
				$(this)
				.css('backgroundColor', '');
			},
			//quando a imagem arrastavel sair do papel
			out: function(event, ui) { 
				$(this)
				.css('backgroundColor', '#FF9D9D');
			},			
			// quando soltar um item no "papel"...
			drop: function(evt, ui){
				// referencia ao "papel", mais curta
				var t = $(this);
				// retorna o elemento arrastado
				var e = ui.draggable;
				// colocamos o elemento arrastado no papel
				e.appendTo(t);
			}
		});//fim funcção droppable
	
	//valida o formulario da qunatidade
	function verificaNumero(e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            }
	//valida o formulario da quantidade
	$("#qtdProduto").keypress(verificaNumero);
	
	// ao clicar em comprar, a imagem é gerada e enviada para banco de dados
	$('#btnSalvar').livequery('click',function(evt){
		
		var qtd_produto = $('#qtdProduto').val();
		if(qtd_produto == '' || qtd_produto == 0){
			$('html, body').scrollTop(100);
			$('#msg_erro').show();
			$('#msg_erro2').hide();
			//alert('Antes de comprar insira a quantidade.');
		}else if(qtd_produto < 0){
			$('html, body').scrollTop(100);
			$('#msg_erro2').show();
			$('#msg_erro').hide();
		}else{
		
			var confirma = confirm("Revise sua arte! Deseja realmente fazer a compra?");
			if(confirma) {
				if($.session.get('imagem_enviada')){
					var id_subcat = '<?php echo $subcat_produto; ?>';
					// dados a serem enviados para o servidor
					data={},
					// area dos itens
					area = $('#'+nome_div),
					// tamanho da pagina
					pageSize = {width:area.width(),height:area.height()},
					// elementos escolhidos pelo usuario
					itens=[];
			
					// para cada elemento dentro da pagina
					area.find('.img_arrastavel').each(function(){
						// referencia ao elemento atual
						var t=$(this),
							// criamos um novo objeto com as propriedades desejadas
							// para geração do arquivo final
							item = {
								src: this.src,
								width: t.width(),
								height: t.height(),
								x: t.position().left,
								y: t.position().top
							};
						// colocamos na lista de itens que serão usados para compor
						// a nova imagem
						itens.push(item);
					});
			
					// colocamos os dados no objeto para
					// enviar para geração da imagem
					data.area = pageSize;
					data.itens = itens;
					data.subcat_id = id_subcat;
					data.pers_qtd = $('#qtdProduto').val();
					data.idUsuario = idUsusario;
					
					// envia para o PHP gerar a imagem final
					
					$.post('gerar.php', data, function(link){
						window.location = '../checkout.php';
					}); 
				}//fim if session imagem envia
				else{
					alert('Faça o upload de sua foto antes de adicionar ao carrinho.');	
				}//fim else
			}//fim if confirma
		}//fim else quantidade preenchida

	});

	//função para verificar se existe elemento na div
	jQuery.fn.exists = function ()
	{
		return jQuery(this).length > 0 ? true : false;
	};

/*  remove um item */
	$('.removeMini').livequery('click',function(){
		var $this = $(this);
		var id_img = $(this).attr('id');
		/* remove o objeto do papel  */
		$this.parent().remove();
		$("ul[id='"+id_img+"']").remove();
		$("img[id='"+id_img+"']").remove();
		
		//aparece nome para selecionar imagem
		$('#arquivo').prev().html('Selecione aqui seu arquivo');
		
		//resposavel por enviar as informações para as imagens serem deletadas no banco de dados
		$.ajax({
			type:"GET",
			url:"codigos_php.php",
			data:{acao:'excluir',id_img:id_img},
			success:function(atual){
				$.session.delete('imagem_enviada');
				$.session.delete('imagem_selecionada');
				$("#area_imagens").load('area_imagens.php');

				$('#btnEnviar').show();
				$('.progress_bar').show();
				$('#porcentagem').show();
				
				//limpar o o nome do arquivo e aparecer selecione aqui seu arquivo
				//$("#arquivo").prev().html($("#arquivo").val("oiiii"));
				
				//zera porcentagem
				$('progress').attr('value',0);
				$('#porcentagem').html('0%');
				//aparece imagem guia
				$("#area_papel").load('area_papel.php?nome_div_remove='+nome_div);
				}	
		});//fim ajax 
	//$("#area_papel").load('area_papel.php?img=<?php// echo $nome_div_papel; ?>');
	});

//caso o usuario saia da pagina do aplicativo é realizado as seguntes funções
	//$(window).bind('beforeunload', excluiFotos);//fim função beforeunload
	window.onbeforeunload = excluiFotos();
	function excluiFotos() {
		//aqui terá alguma variavel para saber qual usuario esta saindo da pagina
		$.ajax({
			type:'GET',
			url:'codigos_php.php',
			async: false,
			data:{acao:'saiu_pagina'},
			success:function(atual){
				$.session.delete('imagem_enviada');
				$.session.delete('imagem_selecionada');
				$(".img_arrastavel").remove();
				$("#area_imagens").load('area_imagens.php?nome_div='+nome_div);
				}	
		});//fim ajax	
	}
//essa função anula a exclusão de fotos caso ele atualize a pagina do aplicativo
	function no_excluiFoto(){
		window.onbeforeunload = null;	
	}
//clicar para pre visualizar
	$('a[name=modal]').livequery('click', function(e) {
		$('body').css('overflow-x', 'hidden');
		$('html, body').scrollTop(10);
		if($.session.get('imagem_enviada')){		
			//nome da div onde as imagens podem ser arrastadas
			var nome_div = '<?php echo $result_subcat['subcat_div']; ?>';
			var moldura = '<?php echo $nome_div_papel; ?>';
			var id_subcat = '<?php echo $subcat_produto; ?>';
			
			e.preventDefault();
			var id = $(this).attr('href');
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
	
			// dados a serem enviados para o servidor
			data={},
			// area dos itens
			area = $('#'+nome_div),
			// tamanho da pagina
			pageSize = {width:area.width(),height:area.height()},
			// elementos escolhidos pelo usuario
			itens=[];
	
			// para cada elemento dentro da pagina
			area.find('.img_arrastavel').each(function(){
				// referencia ao elemento atual
				var t=$(this),
					// criamos um novo objeto com as propriedades desejadas
					// para geração do arquivo final
					item = {
						src: this.src,
						width: t.width(),
						height: t.height(),
						x: t.position().left,
						y: t.position().top
					};
				// colocamos na lista de itens que serão usados para compor
				// a nova imagem
				itens.push(item);
			});
	
			// colocamos os dados no objeto para
			// enviar para geração da imagem
			area1 = pageSize;
			itens1 = itens;
			nome_moldura1 = moldura;
			subcatid1 = id_subcat;
			// envia para o PHP gerar a imagem final
			$.ajax({
				type:'POST',
				url:'gerar_visu.php',
				async : false, 
				data:{area:pageSize,itens:itens,nome_moldura:moldura,subcatid:id_subcat},
				beforeSend:function(){
					$('#aguarde_pers').show();
					//$("#no-cep").hide();
				},
				complete:function(){
					$('#aguarde_pers').hide();
					//$("#resultado_cep").show();
				},
				success:function(atual){
					//alert(pageSize);
					// quando receber a resposta, mostra o Link para baixar a imagem
					//s.html('Imagem gerada: <a target="_blank" href="'+link+'">Clique aqui para baixar</a>');
					//$("#dialog").html(atual);
					$("#recebe_imagem").html(atual);
					//$("#dialog").load('gerar_visu.php');
				}
			}); 
			
							
			$('#mask').css({'width':maskWidth,'height':maskHeight});
	
			$('#mask').fadeIn(1000);	
			$('#mask').fadeTo("slow",0.8);	
			$('#dialog').fadeIn(3000);
			//Get the window height and width
			$(window).heigth();
			var winH = "30px";
			var winW = $(window).width();
				  
			$(id).css('top',  winH);
			$(id).css('left', winW/2-$(id).width()/2);
			
			$(id).fadeIn(2000); 
			
		}else{
			alert('Por favor antes de visualizar seu produto é necessário enviar uma imagem com sua arte pronta. ');
		}
			//return false;
	});
		
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
		//deleta a imagem pre-visualizada
		$.ajax({
			type:'GET',
			url:'codigos_php.php',
			data:{acao:'del_preVisualizar'},
			success:function(atual){
				}	
		});//fim ajax	
	});
	$('#fechar_pre_visualizar').click(function () {
		$('#mask').hide();
		$('.window').hide();
		//deleta a imagem pre-visualizada
		$.ajax({
			type:'GET',
			url:'codigos_php.php',
			data:{acao:'del_preVisualizar'},
			success:function(atual){
				}	
		});//fim ajax	
	});
});						
</script>

<title><?php echo $subcat_nome; ?> - THE brindes - Comunicação Visual e Brindes Personalizados</title>
<link rel="shortcut icon" href="../favicon.ico" />
<link href='../estilo.css' rel='stylesheet' type='text/css' media="screen" />
<!-- responsavel pelo estilo do carrocel de produtos relacionados -->
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />

<!-- estilo do aplicativo -->
<link rel="stylesheet" href="estilo.css" type="text/css" media="screen" />
</head>
<body oncontextmenu="return false" ; return true;>

<!-- PRE VISUALIZAÇÃO -->
<div id="boxes">
	<div id='centraliza_visu'>
        
        <div id="dialog" class="window">
        
        <div id='fechar_pre_visualizar' class="fechar_visualizar"><a alt="Fechar" href="#"><img alt="Fechar" src='../imagens/icon_fechar.png' ></a></div><br />
        <div id="recebe_imagem"></div>
        </div>
        
   </div>
    <!-- Máscara para cobrir a tela -->
    <div id="mask"></div>
</div>

<!-- IMAGEM GRANDE PAGINAÇÃO -->
<div id='mascara'></div>
<div id='centraliza_visu'>
    <div id='img_pagination2'>
        <div id='center_pag'>
        	<div class="fechar_visualizar"><a alt="Fechar" href="#"><img alt="Fechar" src='../imagens/icon_fechar.png' ></a></div><br />
			<center>
                <img id='img_pagination' align='center' width="500" src="" border="0" alt="1144953 1 2x">
			</center>
        </div>
    </div>
</div>
 
<!--AQUI COMEÇA O TOPO -->
<?php include "news_menu_topo_personaliza.php"; ?>
<!--FIM DO TOPO-->
                
                
<div id='msg_erro' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px; display:none; padding-top:5px;">
<p>Por favor, antes de continuar informe a quantidade desejada.</p>
</div>
<div id='msg_erro2' style="width:1024px; margin: 22px auto 22px auto; height:30px; background-color:#FF7C7C; color:#FFF; text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:15px; display:none; padding-top:5px;">
<p>Essa quantidade não é permitida, por favor tente novamente.</p>
</div>
 <br class="cancela" />
<?php if($browser=='IE'){?>
<!-- concerta erro no IE do mapa topo ficar muito emcima do menu topo -->
<br />
<?php } ?>

<?php 
if( $arquivo == '' || $cont_subcatid < 1){
	?> 
    <div class="mapa-topo"><p align="center" style="font-size:17px; color:#333;"><br /><br /><br />Opsssss! Sua pagina não pode ser encontrada...<br /><br /><br /><br /></p>
    </div>
    <br class="cancela" />
	<div id="centraliza_content" style="width:1024px; margin:0 auto 0 auto;">
	<?php
}elseif($result_subcat['subcat_personalizavel'] == 'Sim'){
	include "news_brindes_personalizado.php";
}elseif($result_subcat['subcat_personalizavel'] == 'Nao'){
	include "news_orcamento.php";
} 
?>


<div class="pt-relacionados">


<div  align="center" class="informacoes-produto">VEJA TAMBÉM OUTROS PRODUTOS</div>

<div id="ca-container" class="ca-container">
				<div class="ca-wrapper">	
					
					<?php 
						while($ver_carrocel_produto2 = mysql_fetch_assoc($new_produtos2)){
							//verifica se item é personalizavel ou nao
							if($ver_carrocel_produto2['subcat_personalizavel'] == 'Sim'){
								$pro_personalizado = true;
							}else{
								$pro_personalizado = false;
							}
							
						?>
											
					<div class="ca-item ca-item-2">
                    	<?php if($pro_personalizado == true ){?>
						<a href="<?php get_home(); ?>/brindes-personalizados/<?php echo $ver_carrocel_produto2['subcat_url_seo']; ?>">
                            <div class="ca-item-main">
                                <div class="ca-icon"><img border='0' src="../admin/<?php echo $ver_carrocel_produto2['subcat_imagem']; ?>" width='150px' /></div>
                                <label id='titulo_lista_produtos'><?php echo $ver_carrocel_produto2['subcat_nome']; ?></label>
                                <br />
                                <span id='titulo_personalize_agora'>Personalize já!</span>
                                <div class='lista-produtos-vitrine'>
									<span style='font-size:11px; text-decoration:none; color:#626262;'><br><br>Por apenas: </span><span style='color:#339900; font-size:20px;'> R$ <?php echo number_format($ver_carrocel_produto2['subcat_preco'],2, ',' , '.');?></span><span style='font-size:11px; text-decoration:none;color: #000;' >
						<!--<br />ou 12x de R$ " . number_format($result_subcat['subcat_preco']/12+(40/100),2, ',' , '.') . " --></span>
                                </div>
                            </div>
						</a>
                        <?php } else{ ?>
						<a href="<?php get_home(); ?>/brindes-personalizados/<?php echo $ver_carrocel_produto2['subcat_url_seo']; ?>">
                            <div class="ca-item-main">
                                <div class="ca-icon"><img border='0' src="../admin/<?php echo $ver_carrocel_produto2['subcat_imagem']; ?>" width='150px' /></div>
                                <label id='titulo_lista_produtos'><?php echo $ver_carrocel_produto2['subcat_nome']; ?></label>
                                <br />
                                <span id='titulo_personalize_agora'>Faça já seu orçamento!</span>
                            </div>
						</a>
						
						<?php } ?>
					</div>
						
						<?php }//fim pagina nao encontrada
						
					?>
					
					
				</div>
			</div>





		</div><!--FIM PT RELACIONADOS-->  
</div>
<br class="cancela">
<script type="text/javascript">
	//roda as imagens dos produtos relacionados
	$('#ca-container').contentcarousel();
</script>	            
<?php include "../analytics.php"; ?>
<div class="rodape">
  <?php include "news_rodape.php"; ?>
</div>
</body>
</html>