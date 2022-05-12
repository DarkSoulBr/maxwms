/**
 * @author Wellington
 *
 * Validação de dados ao envio de formulario.
 *
 * Criação    23/10/2009
 * Modificado 23/10/2009
 *
 */

$(function(){
	
	// Validar formulario de pesquisa
	$("#formulario").validate({
		rules:
		{
			pesquisa: 
			{
				required: true,
				minlength: 4,
				maxlength: 50
			}
		},
		messages: 
		{
			pesquisa:
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 50 caracteres!"
			}
		}
	});

	
	// Validar formulario ao clicar botao, ver crud
	$("#formUsuario").validate({
		rules: 
		{
			cliguerra: 
			{
				required: true,
				minlength: 4,
				maxlength: 10
			},
			nome: 
			{
				required: true,
				minlength: 4,
				maxlength: 50
				
			},
			email: 
			{
				required: true,
				email: true
			},
			senha: 
			{
				required: true,
				minlength: 4,
				maxlength: 8
			},
			senhaConfirma: 
			{
				required: true,
				minlength: 4,
				maxlength: 8,
				equalTo: "#senha"
			},
			caixa: 
			{
				required: true,
				minlength: 2,
				maxlength: 3
			}
		},
		messages: 
		{
			cliguerra: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 10 caracteres!"
			},
			nome: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 50 caracteres!"
			},
			email: "Informe email valido!",
			senha: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 8 caracteres!"
			},
			senhaConfirma: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Minino 4 caracteres!",
				maxlength: "Ultrapassa o limite de 8 caracteres!",
				equalTo: "Senha não confere!"
			},
			caixa: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Caixa de Fechamento invalido!",
				maxlength: "Ultrapassa o limite de 3 caracteres!"
			}
		}
	});
	
 });
