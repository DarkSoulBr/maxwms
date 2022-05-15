/**
 * @author Wellington
 *
 * Validação de dados ao enviar formulario.
 *
 * Criação    23/10/2009
 * Modificado 23/10/2009
 *
 */

$(function(){
			
	// Validar formulario ao clicar botao submit
	$("#formLogin").validate(
	{
		rules: 
		{
			login: 
			{
				required: true,
				minlength: 3
			},
			senha: 
			{
				required: true,
				minlength: 3
			}
		},
		messages: 
		{
			login: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Login Incorreto!"
			},
			senha: 
			{
				required: "Campo Obrigatorio!",
				minlength: "Senha Incorreta!"
			}
		}
	});
	
	//$("#login").alfanumerico();
 });