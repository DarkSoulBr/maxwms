$(function(){
	
	// Validar formulario ao clicar botao, ver crud
	$("#formPreFechamento").validate({
		rules: 
		{
			fecvalor: 
			{
				required: true
			}

		},
		messages: 
		{
			fecvalor: 
			{
				required: "Campo Obrigatorio!"
			}
		}
	});

	// valida��o de dados de entrada
	//$("#txtLocalEntrega").alfanumerico();
	//$("#txtExcecoes").alfanumerico();
	//$("#txtObservacao").alfanumerico();
	$("#fecvalor").moeda();
	var dataAtual = new Date();
	var stringDate = dataAtual.format('dmY');
	 
	$("#fecdata").val($.mask.string(stringDate, 'date'));
	$("#fecvecto").date();
	$("#fecdata").date();
	
	
 });