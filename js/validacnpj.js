function validarCNPJ(cnpj) {
	// Verifica o formato fornecido
	// if (!cnpj.match(/^\d{2}\d{3}\d{3}\d{4}\d{2}$/)){
	// alert('Formato do CNPJ inv?lido !\n\nUtilize o formato
	// "nnnnnnnnnnnnnn"');
	// return false;
	// }
	// Tira os separadores deixando somente os n?meros
	// cnpj=cnpj.replace(/[\.\/\-]/g,'');
	// Cada n?mero/posi??o do CNPJ ser? multiplicado pelo
	// correspondente/
	// posi??o na string 'multipliers'
	var multipliers = '543298765432';
	// C?lculo do PRIMEIRO d?gito
	//
	// As multiplica??es do multiplicando pelo multiplicador s?o
	// armazenadas
	// no inteiro 'sum'
	var sum = 0;
	// Os n?meros do CNPJ ser?o acumulados na string 'str' para
	// c?lculo do
	// segundo d?gito
	var str = '';
	// Acumulo das multiplica??es e dos n?meros/posi??es do CNPJ
	for (n = 0; n < 12; n++) {
		sum += (parseInt(cnpj.substr(n, 1)) * parseInt(multipliers
				.substr(n, 1)));
		str += cnpj.substr(n, 1);
	}
	// O primeiro d?gito ? o resultado do resto da divis?o da
	// soma das
	// multiplica??es acumuladas por onze. Se este resto for
	// menor que
	// dois, o d?gito ? fixado em zero
	var dig1 = parseInt(sum % 11);
	dig1 = (dig1 < 2 ? 0 : 11 - dig1);
	// C?lculo do SEGUNDO d?gito
	//
	// Acrescenta-se o primeiro d?gito ao n?mero parcial (sem os
	// d?gitos
	// fornecidos) do CNPJ, acumulado na string 'str' durante o
	// c?lculo
	// anterior
	str += String(dig1);
	// Como acrescentou-se o d?gito, ? necess?rio acrescentar
	// uma posi??o
	// aos multiplicadores
	multipliers = '6' + multipliers;
	// As multiplica??es do multiplicando pelo multiplicador s?o
	// armazenadas
	// no inteiro 'sum' novamente
	sum = 0;
	// Acumulo das multiplica??es no inteiro 'sum'
	for (n = 0; n < 13; n++)
		sum += (parseInt(str.substr(n, 1)) * parseInt(multipliers
				.substr(n, 1)));
	// O segundo d?gito ? o resultado do resto da divis?o da
	// soma das
	// multiplica??es acumuladas por onze. Se este resto for
	// menor que
	// dois, o d?gito ? fixado em zero
	var dig2 = parseInt(sum % 11);
	dig2 = (dig2 < 2 ? 0 : 11 - dig2);
	// Compara-se com o CNPJ fornecido
	if (cnpj.substr(-2, 2) != (String(dig1) + String(dig2))) {
		//			    alert('CNPJ inv?lido !');
		return false;
	}
	// Tudo certo!
	return true;
}