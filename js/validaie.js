
	var uf;
	var ie;

        var OrdZero = '0'.charCodeAt(0);

        function CharToInt(ch)
        {
        return ch.charCodeAt(0) - OrdZero;
        }




	/* private */
	function validateAC(ie){
		/*
		* VERIFICAÇÃO 1
		* onze dígitos mais dois dígitos verificadores
		*/
		if(ie.length!=13){
			return false;
		}

		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];
		dv_01 = caracteres[11];
		dv_02 = caracteres[12];

		/*
		* VERIFICAÇÃO 2
		* os dois primeiros dígitos são sempre 01 (número do estado)
		*/
		if(number_01!=0 || number_02!=1){
			return false;
		}

		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=4; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		dv_01_obtido = 11-resto;
		if(dv_01_obtido==10 || dv_01_obtido==11){
			dv_01_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 3
		* dígitos devem coincidir
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		remontagem_03 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3];
		caracteresRemontagem_03 = remontagem_03.split('');
		i = 0;
		soma = 0;
		for(j=5; j>1; j--){
			soma += j * caracteresRemontagem_03[i];
			i++;
		}
		remontagem_04 = caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10]+""+dv_01_obtido;
		caracteresRemontagem_04 = remontagem_04.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_04[i];
			i++;
		}
		resto = soma%11;
		dv_02_obtido = 11-resto;
		if(dv_02_obtido==10 || dv_02_obtido==11){
			dv_02_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 4
		* dígitos devem coincidir
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}

	function validateAL( ie ){
	
		//Exceção devido não seguir as regras do Estado, porém foi aceito no Sintegra: 246010738
		//if(ie=='246010738'){	
		//	return true;
		//} else{
		/*
		* VERIFICAÇÃO 1
		* nove dígitos
		*/
		
		if(ie.length!=9){
			return false;
		}
		
		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];
		tipoEmpresa = caracteres[2];
		dv = caracteres[8];

		/*
		* VERIFICAÇÃO 2
		* os dois primeiros dígitos são o código do estado: 24
		*/
		if(number_01!=2 || number_02!=4){
			return false;
		}

		/*
		* VERIFICAÇÃO 3
		* 3o. dígito refere-se ao tipo de empresa (0-Normal, 3-Produtor Rural, 5-Substituta, 7- Micro-Empresa Ambulante, 8-Micro-Empresa)
		*/
//           segundo o http://www.sefaz.al.gov.br/sintegra/cad_AL.asp não é mais utilizado a verificação abaixo
//		if(tipoEmpresa!=0 && tipoEmpresa!=2 && tipoEmpresa!=3 && tipoEmpresa!=5 && tipoEmpresa!=7 && tipoEmpresa!=8){
//			return false;
//		}

		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){			
			soma += j * caracteresRemontagem[i];
			i++;
		}		
		
		dv_obtido = (soma*10)-parseInt((soma*10)/11)*11;
		
		//resto = soma%11;
		//dv_obtido = 11-resto;
		
		if(dv_obtido==10){
			dv_obtido = 0;
		}
			

		/*
		* VERIFICAÇÃO 4
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
		//}
	}

	/* private */
	function validateAP( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];
		dv = caracteres[8];

		/*
		* VERIFICAÇÃO 2
		* código do estado: 03
		*/
		if(number_01!=0 || number_02!=3){
			return false;
		}

		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];

		if(remontagem>="03000001" && remontagem<="03017000"){
			p = 5;
			d = 0;
		}
		else if(remontagem>="03017001" && remontagem<="03019022"){
			p = 9;
			d = 1;
		}
		else if(remontagem>="03019023"){
			p = 0;
			d = 0;
		}

		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		soma += p;
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido == 10){dv_obtido = 0;}
		else if(dv_obtido == 11){dv_obtido = d;}

		/*
		* VERIFICAÇÃO 3
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	/* private */
	function validateAM( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		dv= caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		if(soma<11){
			dv_obtido = 11-soma;
		}
		else{
			resto = soma%11;
			if(resto <= 1){
				dv_obtido = 0;
			}
			else{
				dv_obtido = 11-resto;
			}
		}

		/*
		* VERIFICAÇÃO 3
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateBA( ie ){
		/*
		* VERIFICAÇÃO 1:
		* Bahia pode ter 2 tipos de ie, com 8 e com 9 dígitos
		*/
		if(ie.length!=8 && ie.length!=9){
			return false;
		}
		return ie.length==8 ? validateBA_8D( ie ) : validateBA_9D( ie );
	}

	function validateBA_8D( ie ){
		caracteres = ie.split('');
		if(caracteres[0]==0 || caracteres[0]==1 || caracteres[0]==2 || caracteres[0]==3 || caracteres[0]==4 || caracteres[0]==5 || caracteres[0]==8){
			//Para Inscrições cujo primeiro dígito da I.E. é 0,1,2,3,4,5,8 cálculo pelo módulo 10:
			return validateBA_8D_Modulo(10, caracteres);
		}
		else{
			//Para Inscrições cujo primeiro dígito da I.E. é 6,7,9 cálculo pelo módulo 11:
			return validateBA_8D_Modulo(11, caracteres);
		}
	}

	function validateBA_9D( ie ){
		caracteres = ie.split('');
		if(caracteres[1]==0 || caracteres[1]==1 || caracteres[1]==2 || caracteres[1]==3 || caracteres[1]==4 || caracteres[1]==5 || caracteres[1]==8){
			//Para Inscrições cujo primeiro dígito da I.E. é 0,1,2,3,4,5,8 cálculo pelo módulo 10:
			return validateBA_9D_Modulo(10, caracteres);
		}
		else{
			//Para Inscrições cujo primeiro dígito da I.E. é 6,7,9 cálculo pelo módulo 11:
			return validateBA_9D_Modulo(11, caracteres);
		}
		return true;
	}

	function validateBA_8D_Modulo(modulo, caracteres){
		dv_01 = caracteres[6];
		dv_02 = caracteres[7];
		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=7; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		resto = soma%modulo;
		if(resto === 0){dv_02_obtido = 0;}
		else{dv_02_obtido = modulo-resto;

				if (dv_02_obtido == 10 ) {
					dv_02_obtido = 0;
				}
		}

		/*
		* VERIFICAÇÃO 01:
		*/

		if(dv_02!=dv_02_obtido){
			return false;
		}

		remontagem_02 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+dv_02_obtido;
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=8; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%modulo;
		if(resto === 0 || resto == 10){dv_01_obtido = 0;}
		else{dv_01_obtido = modulo-resto;
                            if (dv_01_obtido == 10) {
                                dv_01_obtido =0;
                            }
                 }

		/*
		* VERIFICAÇÃO 02:
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		return true;
	}

	/* private */
	function validateBA_9D_Modulo(modulo, caracteres){
		dv_01 = caracteres[7];
		dv_02 = caracteres[8];
		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=8; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		resto = soma%modulo;
		if(resto === 0){dv_02_obtido = 0;}
		else{dv_02_obtido = modulo-resto;}

		/*
		* VERIFICAÇÃO 01:
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		remontagem_02 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+dv_02_obtido;
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%modulo;
		if(resto === 0){dv_01_obtido = 0;}
		else{dv_01_obtido = modulo-resto;}

		/*
		* VERIFICAÇÃO 02:
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		return true;
	}

	function validateCE( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
                soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido==10 || dv_obtido==11){
			dv_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateDF( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=13){
			return false;
		}

		caracteres = ie.split('');

		/*
		* VERIFICAÇÃO 2
		* campos fixos (07)
		*/
		if(caracteres[0]!=0 && caracteres[1]!=7){
			return false;
		}

		dv_01 = caracteres[11];
		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=4; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		dv_01_obtido = 11-resto;
		if(dv_01_obtido==10 || dv_01_obtido==11){
			dv_01_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		dv_02 = caracteres[12];
		remontagem_03 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3];
		caracteresRemontagem_03 = remontagem_03.split('');
		i = 0;
		soma = 0;
		for(j=5; j>1; j--){
			soma += j * caracteresRemontagem_03[i];
			i++;
		}
		remontagem_04 = caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10]+""+dv_01_obtido;
		caracteresRemontagem_04 = remontagem_04.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_04[i];
			i++;
		}

		resto = soma%11;
		dv_02_obtido = 11-resto;
		if(dv_02_obtido==10 || dv_02_obtido==11){
			dv_02_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 3
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}

	function validateES( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}
		caracteres = ie.split('');
		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
                soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		if(resto<2){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateGO( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		ab = caracteres[0]+""+caracteres[1];

		/*
		* VERIFICAÇÃO 2:
		* dois primeiros dígitos devem ser 10, 11 ou 15
		*/
		if(ab!=10 && ab!=11 && ab!=15){
			return false;
		}

		dv = caracteres[8];
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;

		/*
		* VERIFICAÇÃO 3:
		*/
		if(ie == 11094402 && dv!=0 && dv!=1){
			return false;
		}

		/*
		* VERIFICAÇÃO 4:
		*/
		if(resto==0 && dv!=0){
			return false;
		}

		/*
		* VERIFICAÇÃO 5:
		*/
		if(resto==1 && ie >= 10103105 && ie <= 10119997 && dv!=1){
			 return false;
		}

		/*
		* VERIFICAÇÃO 6:
		*/
		if(resto==1 && ie < 10103105 && ie > 10119997 && dv!=0){
			 return false;
		}

		/*
		* VERIFICAÇÃO 7:
		*/
		if(resto!=1 && resto!=0 && dv!=(11-resto)){
			return false;
		}

		return true;
	}

	function validateMA( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];

		/*
		* VERIFICAÇÃO 1
		* número fixo do estado: 12
		*/
		if(number_01!=1 || number_02!=2){
			return false;
		}

		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
                soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		if(resto==0 || resto==1){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateMT( ie ){
		/*
		* VERIFICAÇÃO 1
		*/

		if(ie.length<11){

                    while ( ie.length < 11 ){
                        ieTmp = 0 + ie;
                        ie = ieTmp;
                    }

		}

		if(ie.length!=11){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[10];
		remontagem_01 = caracteres[0]+""+caracteres[1];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=3; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		if(resto<2){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}

                /*
		* VERIFICAÇÃO 2
		*/
                if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateMS( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];
		/*
		* VERIFICAÇÃO 1
		* número fixo do estado: 28
		*/
		if(number_01!=2 || number_02!=8){
			return false;
		}

		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
                soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		if(resto==0){
			dv_obtido = 0;
		}
		else if(resto>0){
			t = 11-resto;
			if(t>9){
				dv_obtido = 0;
			}
			else{
				dv_obtido = t;
			}
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateMG( ie ){
		/*
		* VERIFICAÇÃO 1
		*/
		if(ie.length!=13){
			return false;
		}
//4981135320058
//                     î î
		caracteres = ie.split('');
		dv_01 = caracteres[11];
		dv_02 = caracteres[12];
				
		remontagem_01 = caracteres[0]+""+
                    caracteres[1]+""+
                    caracteres[2]+""+"0"+""+
                    caracteres[3]+""+
                    caracteres[4]+""+
                    caracteres[5]+""+
                    caracteres[6]+""+
                    caracteres[7]+""+
                    caracteres[8]+""+
                    caracteres[9]+""+
                    caracteres[10];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 1;
        concat = "";
				
		for(j=0; j<caracteresRemontagem_01.length; j++){
			concat += i * caracteresRemontagem_01[j];
			if(i===1) {
                            i=2;
                        }
                        else{
                            i=1;
                        }
		}
		caracteres_concat= concat.split('');
		
		//alert( caracteres_concat );
		
		soma = 0;
		for(i=0; i<concat.length; i++){
			soma += Number(caracteres_concat[i]);
		}
		caracteresSoma = String(soma).split('');
		
		//Havia um erro nessa funcao
		//Quando a soma era menor que 10
		//somava-se 1 no soma, exemplo 7 + 1 = 8 
		//nesse caso a dezena era 80 
		//aí 80 - 7 = 73 que não batia com o digito 3
		if(soma<10){
			dezena = "1";
		}
		else {
			if(caracteresSoma[1] !== '0'){
				dezena = Number(caracteresSoma[0])+1;
			} else {
				dezena = Number(caracteresSoma[0]);
			}
		}
				
		dezena += "0";
		
		dv_01_obtido = dezena - soma;

		/*
		* VERIFICAÇÃO 2:
		*/
		
		if(dv_01!=dv_01_obtido){
			return false;
		}

		remontagem_02 = caracteres[0]+""+caracteres[1];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=3; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		remontagem_03 = caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10]+""+dv_01_obtido;
		caracteresRemontagem_03 = remontagem_03.split('');
		i = 0;
		for(j=11; j>1; j--){
			soma += j * caracteresRemontagem_03[i];
			i++;
		}
		resto = soma%11;
		if(resto==1 || resto==0){
			dv_02_obtido = 0;
		}
		else{
			dv_02_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 3:
		*/		
				
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}
	

	function validatePA( ie ){
		/*
		* VERIFICAÇÃO 1
		* oito dígitos mais um dígito verificador
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];

		/*
		* VERIFICAÇÃO 2
		* número fixo do estado: 15
		*/
		if(number_01!=1 || number_02!=5){
			return false;
		}

		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
                soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		if(resto==0 || resto==1){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validatePB( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[8];
		i=0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido == 10 || dv_obtido == 11){
			dv_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 2:
		* dígitos devem coincidir
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validatePR( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length!=10){
			return false;
		}

		caracteres = ie.split('');
		dv_01 = caracteres[8];
		dv_02 = caracteres[9];
		remontagem_01 = caracteres[0]+""+caracteres[1];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=3; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		for(j=7; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		dv_01_obtido = 11-resto;

		if(dv_01_obtido==10 || dv_01_obtido==11){
			dv_01_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 2:
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		remontagem_03 = caracteres[0]+""+caracteres[1]+""+caracteres[2];
		caracteresRemontagem_03 = remontagem_03.split('');
		i = 0;
		soma = 0;
		for(j=4; j>1; j--){
			soma += j * caracteresRemontagem_03[i];
			i++;
		}
		remontagem_04 = caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+dv_01_obtido;
		caracteresRemontagem_04 = remontagem_04.split('');
		i = 0;
		for(j=7; j>1; j--){
			soma += j * caracteresRemontagem_04[i];
			i++;
		}
		resto = soma%11;
		dv_02_obtido = 11-resto;

		if(dv_02_obtido==10 || dv_02_obtido==11){
			dv_02_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 3:
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}


        function validatePE( ie ){
		/*
		* VERIFICAÇÃO 1:
		* inscrição estadual do e-Fisco: 9 dígitos
		* inscrição antiga: 14 dígitos
		*/
		if(ie.length<9){

                       while (ie.length<9){
                            ietmp = "0"+ie;
                            ie = ietmp;
                        }
			return validatePE_9D( ie );
		}
		if(ie.length==9){
			return validatePE_9D( ie );
		}
		else if(ie.length==14){
			return validatePE_14D( ie );
		}
		else{
			return false;
		}
	}


        function validatePE_9D( ie ){
		caracteres = ie.split('');
		dv_01 = caracteres[7];
		dv_02 = caracteres[8];

		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=8; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		resto = soma%11;
		if(resto==0 || resto==1){
			dv_01_obtido = 0;
		}
		else{
			dv_01_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 1
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		remontagem_02 = remontagem_01+""+dv_01_obtido;
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		if(resto==0 || resto==1){
			dv_02_obtido = 0;
		}
		else{
			dv_02_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}

          //TESTAR
	function validatePE_14D( ie ){
		caracteres = ie.split('');
		dv = caracteres[13];

		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=5; j>0; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10]+""+caracteres[11]+""+caracteres[12];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;

		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido>9){dv_obtido=dv_obtido-10;}

		/*
		* VERIFICAÇÃO 1
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validatePI( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[8];

		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido==10 || dv_obtido==11){
			dv_obtido=0;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRJ( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length!=8){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[7];

//		remontagem = ie.substr( 0, -1);
//alert("remontagem: "+remontagem);
//		caracteresRemontagem = caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6];
//		caracteresRemontagem = remontagem.split('');
		soma = (caracteres[0] * 2);
                i = 1;
		for(j=7; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;
		if(resto<=1){
			dv_obtido=0;
		}
		else{
			dv_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
//alert("dv: "+dv+"\ndv_obtido: "+dv_obtido);
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRN( ie ){
		/*
		* VERIFICAÇÃO 1:
		*/
		if(ie.length==9){
			return validateRN_9D( ie );
		}
		else if(ie.length==10){
			return validateRN_10D( ie );
		}
		else return false;
	}

	function validateRN_9D( ie ){
		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];

		/*
		* VERIFICAÇÃO 1:
		* número do estado: 20
		*/
		if(number_01!=2 || number_02!=0){
			return false;
		}

		dv = caracteres[8];
//		remontagem = substr(ie, 0, -1);
//		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		soma = soma * 10;
		resto = soma%11;
		if(resto==10){
			dv_obtido=0;
		}
		else{
			dv_obtido = resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRN_10D( ie ){
		caracteres = ie.split('');
		number_01 = caracteres[0];
		number_02 = caracteres[1];

		/*
		* VERIFICAÇÃO 1:
		* número do estado: 20
		*/
		if(number_01!=2 || number_02!=0){
			return false;
		}

		dv = caracteres[9];
		remontagem = substr(ie, 0, -1);
		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=10; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		soma = soma * 10;
		resto = soma%11;
		if(resto==10){
			dv_obtido=0;
		}
		else{
			dv_obtido = resto;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRS( ie ){
		/*
		* VERIFICACAO 1
		*/
		if(ie.length!=10){
			return false;
		}

		caracteres = ie.split('');
		dv = caracteres[9];
//		remontagem = substr(ie, 0, -1);
//		caracteresRemontagem = remontagem.split('');
		i = 1;
		soma = (caracteres[0] * 2);
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido==10 || dv_obtido==11){
			dv_obtido=0;
		}

		//echo "<script>alert('".dv_obtido."')</script		>";
		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRO( ie ){
		/*
		* VERIFICACAO 1
		*/
		if(ie.length==9){
			return validateRO_9D( ie );
		}
		else if(ie.length==14){
			return validateRO_14D( ie );
		}
	}

	function validateRO_9D( ie ){
		caracteres = ie.split('');
		dv = caracteres[8];
		remontagem = caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=6; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido==10 || dv_obtido==11){
			dv_obtido=dv_obtido-10;;
		}

		/*
		* VERIFICAÇÃO 1
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRO_14D( ie ){
		caracteres = ie.split('');
		dv = caracteres[13];

		remontagem_01 = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = 0;
		for(j=6; j>1; j--){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}
		remontagem_02 = caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10]+""+caracteres[11]+""+caracteres[12];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		resto = soma%11;
		dv_obtido = 11-resto;
		if(dv_obtido==10 || dv_obtido==11){
			dv_obtido=dv_obtido-10;;
		}

		/*
		* VERIFICAÇÃO 1
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateRR( ie ){
		/*
		* VERIFICACAO 1
		*/
		if(ie.length!=9){
			return false;
		}

//		remontagem = substr(ie, 0, -1);

		caracteres = ie.split('');
                dv = caracteres[8];
		soma = 0;
		for(i=0; i<8; i++){
			soma += ( i+1 ) * caracteres[i];
		}
		dv_obtido = soma%9;
		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateSC( ie ){
		/*
		* VERIFICACAO 1
		*/
		if(ie.length!=9){
			return false;
		}

		caracteres = ie.split('');
                dv = caracteres[8];
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;
		if(resto==0 || resto==1){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}
		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateSP( ie ){
		/*
		* São Paulo possui dois tipos de IE: Industriais e Comerciantes no formato 110.042.490.114
		* e Produtor Rural no formato P-01100424.3/002, então verificamos o primeiro dígito para
		* determinar o tipo de validação a ser feita.
		*/
		caracteres = ie.split('');
		return caracteres[0]=="P" ? validateSpRural( ie ) : validateSpIndustrial( ie );
	}

	function validateSpIndustrial( ie ){

		/*
		* VERIFICAÇÃO 1:
		* doze dígitos
		*/

		if(ie.length!=12){
			return false;
		}

		caracteres = ie.split('');
		dv_01 = Number(caracteres[8]);
		dv_02 = Number(caracteres[11]);
		remontagem_01 = caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6];
		caracteresRemontagem_01 = remontagem_01.split('');
		i = 0;
		soma = Number(caracteres[0]);
		for(j=3; j<9; j++){
			soma += j * caracteresRemontagem_01[i];
			i++;
		}

		soma +=  (caracteres[7] * 10);
		resto = ""+soma%11;
		dv_01_obtido = resto[resto.length-1];


		/*
		* VERIFICAÇÃO 2:
		*/
		if(dv_01!=dv_01_obtido){
			return false;
		}

		remontagem_02 = caracteres[0]+""+caracteres[1];
		caracteresRemontagem_02 = remontagem_02.split('');
		i = 0;
		soma = 0;
		for(j=3; j>1; j--){
			soma += j * caracteresRemontagem_02[i];
			i++;
		}
		remontagem_03 = caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9]+""+caracteres[10];
		caracteresRemontagem_03 = remontagem_03.split('');
		i = 0;
		for(j=10; j>1; j--){
			soma += j * caracteresRemontagem_03[i];
			i++;
		}
		resto = ""+soma%11;
		dv_02_obtido = resto[resto.length-1];

		/*
		* VERIFICAÇÃO 3:
		*/
		if(dv_02!=dv_02_obtido){
			return false;
		}

		return true;
	}

	 function validateSpRural( ie ) {

             if (((ie.substring(0,1)).toUpperCase()) == 'P')
                    {
                      s = ie.substring(1, 9);
                      var nro = new Array(12);
                      for (var i = 0; i <= 7; i++)
                       nro = CharToInt(s);
                      soma = (nro[0] * 1) + (nro[1] * 3) + (nro[2] * 4) + (nro[3] * 5) +
                       (nro[4] * 6) + (nro[5] * 7) + (nro[6] * 8) + (nro[7] * 10);
                      dig = soma % 11;
                      if (dig >= 10)
                       dig = 0;
                      resultado = (dig == nro[8]);
                      if (!resultado)
                       return false;
                    } else {
                        return false;
                    }
                    return true;
         }

//        function validateSpRural( ie )
//         {
//		/*
//		* VERIFICAÇÃO 1:
//		*/
//		if(ie.length!=13){
//			return false;
//		}
//
//		caracteres = ie.split('');
//		dv = Number (caracteres[9]);
//		remontagem_01 = caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
//		caracteresRemontagem_01 = remontagem_01.split('');
//		i = 0;
//                soma = 0;
//alert(
//caracteres[2] +"\n"+
//caracteres[3]+"\n"+
//caracteres[4]+"\n"+
//caracteres[5]+"\n"+
//caracteres[6]+"\n"+
//caracteres[7]
//            );
////		for(j=3; j<=10; j++){
//		for(j=3; j<8; j++){
//			soma += j * caracteresRemontagem_01[i];
//alert( "caracteresRemontagem_01["+i+"]: "+ caracteresRemontagem_01[i]);
//			i++;
//		}
//		soma += caracteres[1] + (caracteres[8] * 10);
//		resto = ""+soma%11;
//		dv_obtido = resto[resto.length-1];
//
//
//
//		/*
//		* VERIFICAÇÃO 2:
//		* dígitos devem coincidir
//		*/
//		if(dv!=dv_obtido){
//alert("dv: "+dv+"\n dv_obtido: "+dv_obtido);
//			return false;
//		}
//
//		return true;
//	}

	function validateSE( ie ){
	
		//exceção
		if("270921460") return true;
		/*
		* VERIFICACAO 1
		*/
		if(ie.length!=9){
			return false;
		}

                caracteres = ie.split('');
                dv = caracteres[8];
//		remontagem = substr(ie, 0, -1);
//		dv = substr(ie, -1);
//		caracteresRemontagem = remontagem.split('');
		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteres[i];
			i++;
		}
		resto = soma%11;

		if(resto==10 ){
			dv_obtido = 1;
		}else if(resto==10 || resto==11 || resto===0){
			dv_obtido = 0;
		}
		else{
			dv_obtido = 11-resto;
		}
		
		
		if(dv_obtido==10 || dv_obtido==11 ) {
			dv_obtido = 0;
		}

		/*
		* VERIFICAÇÃO 2
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}

	function validateTO( ie ){
		/*
		* No Tocantins pode-se ou não informar os dígitos que determinam o tipo de empresa
		*/
		if(ie.length==11){
			return validateTO_11D( ie );
		}
		else if(ie.length==9){
			//echo "<script>alert('".ie.length."');< /script>";
			return validateTO_9D( ie );
		}
		else return false;
	}

	function validateTO_11D( ie ){
		caracteres = ie.split('');
		digitos_34 = caracteres[2]+""+caracteres[3];
		dv = caracteres[10];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7]+""+caracteres[8]+""+caracteres[9];
		caracteresRemontagem = remontagem.split('');

		/*
		* VERIFICAÇÃO 1:
		* o terceiro e quarto dígitos não entram na conta, mas só podem assumir os seguintes valores:
		* 01 = Produtor Rural (não possui CGC)
		* 02 = Industria e Comércio
		* 03 = Empresas Rudimentares
		* 99 = Empresas do Cadastro Antigo (SUSPENSAS)
		*/
		if(digitos_34 != "01" && digitos_34 != "02" && digitos_34 != "03" && digitos_34 != "99"){
			return false;
		}

		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;

		/*
		* VERIFICAÇÃO 2:
		* se resto menor que dois, dígito == 0
		*/
		if(resto<2 && dv!=0){
			return false;
		}

		/*
		* VERIFICAÇÃO 3:
		* se resto >= 2 que dois, dígito == 11-resto
		*/
		if(resto>=2 && (dv!=11-resto)){
			return false;
		}

		return true;
	}

	function validateTO_9D( ie ){
		caracteres = ie.split('');
		dv = caracteres[8];
		remontagem = caracteres[0]+""+caracteres[1]+""+caracteres[2]+""+caracteres[3]+""+caracteres[4]+""+caracteres[5]+""+caracteres[6]+""+caracteres[7];
		caracteresRemontagem = remontagem.split('');

		i = 0;
		soma = 0;
		for(j=9; j>1; j--){
			soma += j * caracteresRemontagem[i];
			i++;
		}
		resto = soma%11;
		if(resto<2){
			dv_obtido = 0;;
		}
		else{
			dv_obtido = 11-resto;
		}

		/*
		* VERIFICAÇÃO 1:
		*/
		if(dv!=dv_obtido){
			return false;
		}

		return true;
	}
//} // termino da classe


function strtr (str, from, to) {
    // Translates characters in str using given translation tables
    //
    // version: 1107.2516
    // discuss at: http://phpjs.org/functions/strtr
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +      input by: uestla
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Alan C
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Taras Bogach
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: jpfle
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // -   depends on: krsort
    // -   depends on: ini_set
    // *     example 1: $trans = {'hello' : 'hi', 'hi' : 'hello'};
    // *     example 1: strtr('hi all, I said hello', $trans)
    // *     returns 1: 'hello all, I said hi'
    // *     example 2: strtr('äaabaåccasdeöoo', 'äåö','aao');
    // *     returns 2: 'aaabaaccasdeooo'
    // *     example 3: strtr('ääääääää', 'ä', 'a');
    // *     returns 3: 'aaaaaaaa'
    // *     example 4: strtr('http', 'pthxyz','xyzpth');
    // *     returns 4: 'zyyx'
    // *     example 5: strtr('zyyx', 'pthxyz','xyzpth');
    // *     returns 5: 'http'
    // *     example 6: strtr('aa', {'a':1,'aa':2});
    // *     returns 6: '2'
    var fr = '',
        i = 0,
        j = 0,
        lenStr = 0,
        lenFrom = 0,
        tmpStrictForIn = false,
        fromTypeStr = '',
        toTypeStr = '',
        istr = '';
    var tmpFrom = [];
    var tmpTo = [];
    var ret = '';
    var match = false;

    // Received replace_pairs?
    // Convert to normal from->to chars
    if (typeof from === 'object') {
        tmpStrictForIn = this.ini_set('phpjs.strictForIn', false); // Not thread-safe; temporarily set to true
        from = this.krsort(from);
        this.ini_set('phpjs.strictForIn', tmpStrictForIn);

        for (fr in from) {
            if (from.hasOwnProperty(fr)) {
                tmpFrom.push(fr);
                tmpTo.push(from[fr]);
            }
        }

        from = tmpFrom;
        to = tmpTo;
    }

    // Walk through subject and replace chars when needed
    lenStr = str.length;
    lenFrom = from.length;
    fromTypeStr = typeof from === 'string';
    toTypeStr = typeof to === 'string';

    for (i = 0; i < lenStr; i++) {
        match = false;
        if (fromTypeStr) {
            istr = str.charAt(i);
            for (j = 0; j < lenFrom; j++) {
                if (istr == from.charAt(j)) {
                    match = true;
                    break;
                }
            }
        } else {
            for (j = 0; j < lenFrom; j++) {
                if (str.substr(i, from[j].length) == from[j]) {
                    match = true;
                    // Fast forward
                    i = (i + from[j].length) - 1;
                    break;
                }
            }
        }
        if (match) {
            ret += toTypeStr ? to.charAt(j) : to[j];
        } else {
            ret += str.charAt(i);
        }
    }

    return ret;
}


function validarIE(uf, ie){
            uf = uf.toUpperCase();
            ie =ie.replace(/[^a-zA-Z0-9]/g, '');

		switch(uf){
			case "AC":
				return validateAC( ie ) ? true : false;
				break;
			case "AL":
				return validateAL( ie ) ? true : false;
				break;
			case "AP":
				return validateAP( ie ) ? true : false;
				break;
			case "AM":
				return validateAM( ie ) ? true : false;
				break;
			case "BA":
				return validateBA( ie ) ? true : false;
				break;
			case "CE":
				return validateCE( ie ) ? true : false;
				break;
			case "DF":
				return validateDF( ie ) ? true : false;
				break;
			case "ES":
				return validateES( ie ) ? true : false;
				break;
			case "GO":
				return validateGO( ie ) ? true : false;
				break;
			case "MA":
				return validateMA( ie ) ? true : false;
				break;
			case "MT":
				return validateMT( ie ) ? true : false;
				break;
			case "MS":
				return validateMS( ie ) ? true : false;
				break;
			case "MG":
				return validateMG( ie ) ? true : false;
				break;
			case "PA":
				return validatePA( ie ) ? true : false;
				break;
			case "PB":
				return validatePB( ie ) ? true : false;
				break;
			case "PR":
				return validatePR( ie ) ? true : false;
				break;
			case "PE":
				return validatePE( ie ) ? true : false;
				break;
			case "PI":
				return validatePI( ie ) ? true : false;
				break;
			case "RJ":
				return validateRJ( ie ) ? true : false;
				break;
			case "RN":
				return validateRN( ie ) ? true : false;
				break;
			case "RS":
				return validateRS( ie ) ? true : false;
				break;
			case "RO":
				return validateRO( ie ) ? true : false;
				break;
			case "RR":
				return validateRR( ie ) ? true : false;
				break;
			case "SC":
				return validateSC( ie ) ? true : false;
				break;
			case "SP":
				return validateSP( ie ) ? true : false;
				break;
			case "SE":
				return validateSE( ie ) ? true : false;
				break;
			case "TO":
				return validateTO( ie ) ? true : false;
				break;
		}
	}//end validar()

//Lista de inscrições válidas:
//"AC", "01.004.823/001-12"
//"AL", "240000048"
//"AP", "030123459"
//"AM", "04.210.308-8"
//"BA", "123456-63", "1000003-06", "612345-57"
//"CE", "06000001-5"
//"DF", "07300001001-09"
//"ES", "999999990"
//"GO", "10.987.654-7"
//"MA", "120000385"
//"MT", "0013000001-9"
//"MG", "062.307.904/0081"
//"PA", "15-999999-5"
//"PB", "06000001-5"
//"PR", "12345678-50"
//"PE", "0321418-40" e "18.1.001.0000004-9"
//"PI", "012345679"
//"RJ", "99.999.99-3"
//"RN", "20.040.040-1" e "20.0.040.040-0"
//"RS", "2243658792"
//"RO", "101.62521-3" e "0000000062521-3"
//"RR", "24006153-6"
//"SC", "251.040.852"
//"SP", "110.042.490.114" E "P-01100424.3/002"
//"SE", "27123456-3"
//"TO", "29010227836" E 290686385
/*
validador = new ClassValidarIE("TO", "29010227836");


if(validador->validar()){
	echo "<script>alert('IE OK')</script>";
}
else{
	echo "<script>alert('IE invalida!')</script>";
}
*/
//?>