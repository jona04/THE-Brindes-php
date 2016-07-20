	/* ------------------- menu index -------------------- */
$(document).ready(function(){

	/*--------------- FUNCAO MARQUEE em detalhes ----- */
	//para o destaque qdo o mouse tiver emcima
	/*$('marquee').marquee('pointer').mouseover(function () { 
		$(this).trigger('stop');
		}).mouseout(function () { $(this).trigger('start'); 
		})
		/*.mousemove(function (event) { if ($(this).data('drag') == true) { 
		this.scrollTop = $(this).data('scrollY') ($(this).data('y') - event.clientY); } 
		}).mousedown(function (event) { 
		$(this).data('drag', true).data('y', event.clientY).data('scrollY', this.scrollTop); 
		}).mouseup(function () { $(this).data('drag', false); })*/

	/* ------------ mascara para formulario de orcamento comunicação visual ---- */
	$('#fone_contato').mask("(99) 9999-9999")
	$("label").inFieldLabels();
	$("label .l_newsletter").inFieldLabels();
	$(".l_contato").inFieldLabels();
	$(".l_pedidos").inFieldLabels();
	$(".l_orcamento_cv").inFieldLabels();


jQuery.validator.addMethod("verificaCPF", function(value, element) {
    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
    return true;
}, "Informe um CPF válido."); // Mensagem padrão

    /* ----------------- validando formulario E ENVIANDO CONTADO---------------- */
	$('#form_cadastro_usu').validate({  
            rules: {  
                nome_comp: { required: true, minlength: 6 },    
				cpf    : { verificaCPF: true,required: true, minlength: 11 },
				nascimento: { required: true, minlength: 8 },
				cep: { required: true, minlength: 8 },
				ddd: { required: true, minlength: 2 },
				ddd2: { required: true, minlength: 2 },
				fone: { required: true, minlength: 6 },
				cel: { required: true, minlength: 6 },
                email_cadastro: { required: true, email: true },
				email_cadastro2: { required: true, email: true },  
                senha: { required: true,minlength: 6 },
				senha2: { required: true, minlength: 6 } , 
				radio: { required: true}, 
				endereco_numero:{ required: true, minlength: 1},
				endereco_cadastro:{ required: true, minlength: 6 },
				bairro:{ required: true, minlength: 1 },
				cidade:{ required: true, minlength: 1 },
				estado:{ required: true, minlength: 1 }
            },  
            messages: {  
                nome_comp: { required: '<br />Preencha o campo Nome Completo<br/>', minlength: '<br>No mínimo 6 letras</br>' }, 
				nome: { required: '<br>Preencha o campo Apelido</br>', minlength: '<br>No mínimo 1 letras</br>' }, 
				cpf: {verificaCPF: "CPF inválido",required: '<br>Preencha o campo CPF</br>', minlength: '<br>No mínimo 11 números</br>' },
				nascimento: { required: '<br>Preencha o campo Nascimento</br>', minlength: '<br>No mínimo 10 caracteres nesse formato:</br>' }, 
				cep: { required: '<br>Preencha o campo CEP</br>', minlength: '<br>No mínimo 11 números</br>' }, 
				ddd: { required: 'Preencha o DDD', minlength: 'No mínimo 2 números' }, 
				ddd2: { required: 'Preencha o DDD', minlength: 'No mínimo 2 números' }, 
				fone: { required: '<br>Preencha o campo Telefone Principal</br>', minlength: '<br>No mínimo 8 números</br>' },
				cel: { required: '<br>Preencha o campo Telefone Principal</br>', minlength: '<br>No mínimo 8 números</br>' }, 
                email_cadastro: { required: '<br>Informe o seu Email</br>', email: '<br>Informe um email válido</br>' }, 
				email_cadastro2: { required: '<br>Informe o seu Email</br>', email: '<br>Informe um email válido</br>' },  
                senha: { required: '<br>Informe sua Senha</br>',minlength: '<br>Digite no minimo 6 letras</br>' },
				senha2: { required: '<br>Informe a 2º Senha </br>', minlength: '<br>Digite no minimo 6 letras</br>'},
				radio: { required: '<br>Informe o Sexo</br>'},
				endereco_numero: { required: '<br>Informe o numero</br>',minlength: '<br>Digite no minimo 1 letra</br>' },
				endereco_cadastro:{ required: '<br>Informe o endereço</br>', minlength: 6 },
				bairro:{ required: '<Br>Informe o bairro<br>', minlength: 1 },
				cidade:{ required: '<br>Informe a cidade<br>', minlength: 1 },
				estado:{ required: '<br>Informe o estado<br>', minlength: 1 }
    
            }/*,
			submitHandler:function(form){  
                var dados = $( form ).serialize(); 
				//dados pessiais 
				nome_comp = $('#nome_comp').val();
				cpf  = $('#cpf').val();
				nascimento = $('#nascimento').val();
				ddd = $('#ddd').val();
				ddd2 = $('#ddd2').val();
				fone = $('#fone').val();
				cel = $('#cel').val();
				//dados endereço
				cep = $('#cep').val();
				endereco = $('#endereco_cadastro').val();
				numero = $('#endereco_numero').val();
				complemento = $('#complemento').val();
				bairro = $('#bairro').val();
				cidade = $('#cidade').val();
				estado = $('#estado').val();
				//dados de acesso
				email = $('#email_cadastro').val();
				email2 = $('#email_cadastro2').val();
				senha = $('#senha').val();
				senha2 = $('#senha2').val();
				
				if(senha != senha2){
					alert('senha diferentes!');
				}
				else if(email != email2){
					alert('email diferentes!');	
				}else{
				
					var sexo = $('input:radio[name=sexo]:checked').val();
					$.ajax({  
						type:"GET",
						url:"funcoes.php",  
						data:{
							//realizando cadastro
							tp:"us",
							//dados pessoais
							nome_comp:nome_comp,
							cpf:cpf,
							nascimento:nascimento,
							sexo:sexo,
							ddd:ddd,
							ddd2:ddd2,
							fone:fone,
							cel:cel,
							//endereço
							cep:cep,
							endereco:endereco,
							numero:numero,
							complemento:complemento,
							bairro:bairro,
							cidade:cidade,
							estado:estado,
							//dados de acesso
							email:email,
							senha:senha,
							senha2:senha2,
							
							}, 
						beforeSend:function(){
							$('#mask_cadastro').show();
							$('html, body').scrollTop(0);
						},
						success: function(atual){
							$("#nome_comp").attr('value','');
							$("#nome").attr('value','');
							$("#cpf").attr('value','');
							$("#nascimento").attr('value','');
							$("#cep").attr('value','');
							$("#ddd").attr('value','');
							$("#ddd2").attr('value','');
							$("#fone").attr('value','');
							$("#cel").attr('value','');
							$("#email_cadastro").attr('value','');
							$("#senha").attr('value','');
							$("#senha2").attr('value','');
							$('#mask_cadastro').hide();
							//window.location = 'loginCompra.php';
						}
					})//fim ajax
					
				}//fim else
				
			 return false;  
			*/
			//}
        });



    /* ----------------- validando formulario  no dash board dados---------------- */
	$('#form_dash_dados').validate({  
		rules: {  
			nomecompleto: { required: true, minlength: 6 },    
			cpf    : { verificaCPF: true,required: true, minlength: 11 },
			nasc: { required: true, minlength: 8 },
			cep: { required: true, minlength: 8 },
			ddd: { required: true, minlength: 2 },
			ddd2: { required: true, minlength: 2 },
			fone: { required: true, minlength: 6 },
			cel: { required: true, minlength: 6 },
			email: { required: true, email: true },
			radio: { required: true}, 
		},  
		messages: {  
			nomecompleto: { required: '<br />Preencha o campo Nome Completo<br/>', minlength: '<br>No mínimo 6 letras</br>' }, 
			cpf: {verificaCPF: "CPF inválido",required: '<br>Preencha o campo CPF</br>', minlength: '<br>No mínimo 11 números</br>' },
			nasc: { required: '<br>Preencha o campo Nascimento</br>', minlength: '<br>No mínimo 10 caracteres nesse formato:</br>' }, 
			ddd: { required: 'Preencha o DDD', minlength: 'No mínimo 2 números' }, 
			ddd2: { required: 'Preencha o DDD', minlength: 'No mínimo 2 números' }, 
			fone: { required: '<br>Preencha o campo Telefone Principal</br>', minlength: '<br>No mínimo 8 números</br>' },
			cel: { required: '<br>Preencha o campo Telefone Principal</br>', minlength: '<br>No mínimo 8 números</br>' }, 
			email: { required: '<br>Informe o seu Email</br>', email: '<br>Informe um email válido</br>' }, 
			radio: { required: '<br>Informe o Sexo</br>'},

		}
	})


    /* ----------------- validando formulario  no dash board endereço---------------- */
	$('#form_dash_endereco').validate({  
 		rules: {      
			cep: { required: true, minlength: 8 }, 
			endereco_numero:{ required: true, minlength: 1},
			endereco_cadastro:{ required: true, minlength: 6 },
			bairro:{ required: true, minlength: 1 },
			cidade:{ required: true, minlength: 1 },
			estado:{ required: true, minlength: 1 }
		}, 
		messages: {   
			cep: { required: '<br>Preencha o campo CEP</br>', minlength: '<br>No mínimo 11 números</br>' }, 
			endereco_numero: { required: '<br>Informe o numero</br>',minlength: '<br>Digite no minimo 1 letra</br>' },
			endereco_cadastro:{ required: '<br>Informe o endereço</br>', minlength: 6 },
			bairro:{ required: '<Br>Informe o bairro<br>', minlength: 1 },
			cidade:{ required: '<br>Informe a cidade<br>', minlength: 1 },
			estado:{ required: '<br>Informe o estado<br>', minlength: 1 }

		},
	})
	/*$("#remove_proCarrinho").livequery('click',function(){
			unset($_SESSION['nome']);
			session_destroy();
			id = <?php echo $pro_id ?>;
			$.ajax({
				type:"GET",
				url:"checkout.php",
				data:{},			
				success: function(atual){
					$("#resultado_cep").html(atual).show()
				}	
			})//fim ajax
		return false;
	})*/		 
		
})//fim document ready function





