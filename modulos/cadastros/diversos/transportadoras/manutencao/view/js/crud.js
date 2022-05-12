/**
 * @author Wellington
 *
 * CRUD - ações jquery para insert, delete, update e select.
 *
 * Criação    04/11/2009
 * Modificado 04/11/2009
 *
 *	PARA ACAO USE verifique o aquivo config.js lib/jquery/max;
 *		1 -> INSERT
 *		2 -> SELECT
 *		3 -> UPDATE
 *		4 -> DELETE
 */

$(function(){
	
	window.onload = function(){
		grupoBotoes(0, 0, 0, 0);
	};
	
	$("input[name='botao']").click(function()
	{	
		var idBotao = $(this).val();	
		usuario = new Object();
		
		//declara variaveis recuperando valores
		usuario.codigo = $('#codigo').val();
		usuario.login = $('#login').val();
		usuario.nome = $('#nome').val();
		usuario.email = $('#email').val();
		usuario.senha = $('#senha').val();
		usuario.nivel = $('#listaNiveis').val();
		usuario.empresa = $('#listaEmpresas').val();
		usuario.acesso = $("input[@name='acesso']:checked").val();
		usuario.caixa = $('#caixa').val();
		var pesquisa = $('#pesquisa').val();
		
		switch(idBotao)
		{
			case BOTAO_INSERIR:
				if($('#formUsuario').validate().form())
				{	
					crudExe(INSERT);
				}
				break;
			
			case BOTAO_ALTERAR:
				desativaCampo(false, true);
				grupoBotoes(BOTAO_CONFIRMAR, BOTAO_RESTAURAR, BOTAO_NOVO, BOTAO_PESQUISAR);
				break;
			
			case BOTAO_CONFIRMAR:
				if($('#formUsuario').validate().form())
				{	
					crudExe(UPDATE);
				}
				break;
			
			case BOTAO_RESTAURAR:
				populaCampo(usuarios[codigo]);
				grupoBotoes(BOTAO_ALTERAR, BOTAO_EXCLUIR, BOTAO_NOVO, BOTAO_PESQUISAR);
				desativaCampo(true, true);
				break;
			
			case BOTAO_EXCLUIR:
				$('#dialog').attr('title','Exclusão de Usuario');
				$('#dialog').html('<p>Tem certeza que deseja excluir!</p>');
				
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() {
							crudExe(DELETE);
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				$('#dialog').dialog("open");
				break;
			
			case BOTAO_PESQUISAR:
				if($('#formPesquisa').validate().form())
				{
					usuario.login = pesquisa;
					crudExe(SELECT);
				}
				break;
			
			case BOTAO_NOVO:
			case BOTAO_LIMPAR:
				novoForm();
				break;
		}
		
		
	});
	
	$('#listDados').change(function(){
		desativaCampo(true, true);
		populaCampo(usuarios[$(this).val()]);
		grupoBotoes(BOTAO_ALTERAR, BOTAO_EXCLUIR, BOTAO_NOVO, BOTAO_PESQUISAR);
	});
	
 });

function crudExe(acao)
{
	//executa insert, select, updete, delete
	if(Boolean(acao))
	{
		//Envia os dados via metodo post
   		$.post('modulos/cadastros/diversos/usuarios/manutencao/controller/acoes.php',
   				{
   					//variaveis a ser enviadas metodo POST
   					codigo:usuario.codigo,
   					login:usuario.login,
   					nome:usuario.nome,
   					email:usuario.email,
   					senha:usuario.senha,
   					nivel:usuario.nivel,
   					empresa:usuario.empresa,
   					acesso:usuario.acesso,
   					caixa:usuario.caixa,
   					acao:acao
   				},
   				function(data)
   				{
   					if (Boolean(Number(data.retorno)))
	                {
   						if (data.usuarios)
   							usuarios = data.usuarios;
   						
   						if (data.usuario)
   							usuario = data.usuario;
   						
   						$('#retorno').html(MENSAGEM_RETORNO_OK.replace('<<mensagem>>', data.mensagem));
   						   						
   						switch(acao)
   						{
   							case INSERT:
   								$("#formUsuario")[0].reset();
   								break;
   							
   							case UPDATE:
   								desativaCampo(true, true);
   								grupoBotoes(BOTAO_ALTERAR, BOTAO_EXCLUIR, BOTAO_NOVO, BOTAO_PESQUISAR);
   								
   								usuarios[codigo] = usuario;
   								
   								var opcoes = '';
       							$.each(usuarios, function (key, value)
   								{
       								if (value.situacao)
           							{
       									if (!opcoes)
       									{
       										opcoes = '<option value="' + value.codigo + '">' + value.login + '</option>';
       									}
       									else
       									{
       										opcoes += '<option value="' + value.codigo + '">' + value.login + '</option>';
       									}
           							}
   								});
       							
       							$("#listDados").html(opcoes);
       							populaCampo(usuarios[codigo]);
       							$('#listDados').val(data.usuario.codigo);
   								break;
   								
   							case DELETE:
   								usuarios[codigo].situacao = false;
   							case SELECT:
   								$("#listDados").attr('disabled', false);
   								$("#listDados").html('<option value="false">Carregando ...</option>');   							
       							   								
   								desativaCampo(true, true);
   								grupoBotoes(BOTAO_ALTERAR, BOTAO_EXCLUIR, BOTAO_NOVO, BOTAO_PESQUISAR);
   								
   								var opcoes = 0;
       							$.each(usuarios, function (key, value) 
   								{
       								if (value.situacao)
           							{
       									if (!opcoes)
       									{
       										opcoes = '<option value="' + value.codigo + '">' + value.login + '</option>';
       										populaCampo(value);
       									}
       									else
       									{
       										opcoes += '<option value="' + value.codigo + '">' + value.login + '</option>';
       									}
           							}
   								});
       							
       							if(opcoes)
       								$("#listDados").html(opcoes);
       							else
       								novoForm();
       							break;
   						}
   							
	                }
	                else
	                {	                	
	                	// Imprime o retorno "false"
	                	$('#retorno').html(MENSAGEM_RETORNO_ATENCAO.replace('<<mensagem>>', data.mensagem));
	                	
	                	$("#listDados").attr('disabled', true);
						$("#listDados").html('<option value="false"></option>');
	                }
   				}, "json");
	}
}

function desativaCampo(situacao,situacaoPass)
{
	$('#login').attr('disabled', situacao);
	$('#nome').attr('disabled', situacao);
	$('#email').attr('disabled', situacao);
	$('#senha').attr('disabled', situacaoPass);
	$('#senhaConfirma').attr('disabled', situacaoPass);
	$('#listaNiveis').attr('disabled', situacao);
	$('#listaEmpresas').attr('disabled', situacao);
	$('#interno').attr('disabled', situacao);
	$('#externo').attr('disabled', situacao);
	$('#caixa').attr('disabled', situacao);
}

function populaCampo(value)
{
	$('#codigo').val(value.codigo);
	$('#login').val(value.login);
	$('#nome').val(value.nome);
	$('#email').val(value.email);
	$('#senha').val('maxtrade');
	$('#senhaConfirma').val('maxtrade');
	$('#listaEmpresas').val(value.empresa);
	$('#listaNiveis').val(value.nivel);
	
	if (value.acessoExterno)	
		$("#externo").attr('checked', true);
	else
		$("#interno").attr('checked', true);
	
	$('#caixa').val(value.caixa);
}

function novoForm()
{
	$("#formUsuario")[0].reset();
	desativaCampo(false, false);
	$('#retorno').html('');
	
	$("#listDados").attr('disabled', true);
	$("#listDados").html('<option value="false"></option>');
	
	grupoBotoes(0, BOTAO_INSERIR, BOTAO_LIMPAR, BOTAO_PESQUISAR);
}