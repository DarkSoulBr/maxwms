$(function(){
	
	// Validar formulario ao clicar botao
	$("#formEstoqueFisico").validate(
	{
		rules: 
		{
			listaEstoqueFisico: 
			{
				required: true
			}
		},
		messages: 
		{
			listaEstoqueFisico: 
			{
				required: "Selecionar Campo Obrigatorio!"
			}
		}
	});
	
	var dataHoje = new Date();
	var dataMin;

	$("#dataInicio").datepicker({changeYear: true, maxDate: dataHoje, 
		onSelect: function(dateText, inst)
		{
			dataMin = new Date().dateBr(dateText);
			$("#dataFim").attr("disabled", "");
			$("#horaFim").attr("disabled", "");
			$("#dataFim").datepicker('destroy');
			$("#dataFim").datepicker({changeYear: true, minDate:dataMin, maxDate: dataHoje});
		}
	});
	
	$("#dataInicio").date();
	$("#dataInicio").val($.mask.string(dataHoje.format('dmY'), 'date'));
	
	$("#horaInicio").time();
	$("#horaInicio").val($.mask.string("000000", 'time'));
	
	$("#dataFim").attr("disabled", "disabled");
	$("#dataFim").date();
	$("#dataFim").val($.mask.string(dataHoje.format('dmY'), 'date'));
	
	$("#horaFim").attr("disabled", "disabled");
	$("#horaFim").time();
        $("#horaFim").val($.mask.string("235959", 'time'));
//	$("#horaFim").val($.mask.string(dataHoje.format('His'), 'time'));
});