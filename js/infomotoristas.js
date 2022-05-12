var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;		
   	new ajax ('infomotseleciona.php?usucodigo='+ vusuario 
        , {onComplete: imprime_mot});
			
}

function load_grid()
{
	var opcaochecada = '';
	var consulta = '';

	if(document.getElementById("opcao1").checked == true)
	opcaochecada = "1";

	if(document.getElementById("opcao2").checked == true)
	opcaochecada = "2";

	if(document.getElementById("opcao3").checked == true)
	opcaochecada = "3";

	consulta = document.getElementById("consulta").value;

	document.getElementById('nome').disabled = false;

	new ajax('consultamotcodigo.php?opcao='+opcaochecada+'&nome='+consulta, {onLoading: carregando, onComplete: imprime});
}

function carregando(){	
}

function imprime(request){

	
	var xmldoc=request.responseXML;

	var dados = xmldoc.getElementsByTagName('dados')[0];

	var contador = '0';
	var tabela='<select id="pesquisap" name="pesquisap" size="1" onchange="setar(this.value);">';
	
    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{

			var itens = registros[i].getElementsByTagName('item');
			
			tabela+='<option value="'+itens[0].firstChild.data+'">'+itens[1].firstChild.data+' '+itens[2].firstChild.data+' '+itens[3].firstChild.data+'</option>\n"';
			
			
			if(i==0)
            setar(itens[0].firstChild.data);
		}

	}
    tabela+="</select>"	
	$("resultado1").innerHTML=tabela;
    //alert(tabela);
}

function setar(obj)
{

	new ajax('consultamotcodigox.php?codigo='+obj, {onLoading: carregando, onComplete: imprime_motorista});
	
}

function imprime_motorista(request){

	$("motorista").value='';
	$("cpf").value='';
	
	var xmldoc=request.responseXML;

	var dados = xmldoc.getElementsByTagName('dados')[0];

	var contador = '0';
		
    if(dados!=null)
	{
        //corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		//alert(registros.length);
		for(i=0;i<registros.length;i++)
		{

			var itens = registros[i].getElementsByTagName('item');
			
			$("motorista").value=itens[2].firstChild.data;
			$("cpf").value=itens[3].firstChild.data;
			
		}

	}
    
}

/*******************************************************************************
 * #################################################################### Assunto =
 * Valida��o de CPF e CNPJ Autor = Marcos Regis Data = 24/01/2006 Vers�o = 1.0
 * Compatibilidade = Todos os navegadores. Pode ser usado e distribu�do desde
 * que esta linhas sejam mantidas
 * ====------------------------------------------------------------====
 * 
 * Funcionamento = O script recebe como par�metro um objeto por isso deve ser
 * chamado da seguinte forma: E.: no evento onBlur de um campo texto <input
 * name="cpf_cnpj" type="text" size="40" maxlength="18" onBlur="validar(this);">
 * Ao deixar o campo o evento � disparado e chama validar() com o argumento
 * "this" que representa o pr�prio objeto com todas as propriedades. A partir
 * da� a fun��o validar() trata a entrada removendo tudo que n�o for caracter
 * num�rico e deixando apenas n�meros, portanto valores escritos s� com n�meros
 * ou com separadores como '.' ou mesmo espa�os s�o aceitos ex.: 111222333/44,
 * 111.222.333-44, 111 222 333 44 ser�o tratadoc como 11122233344 (para CPFs) De
 * certa forma at� mesmo valores como 111A222B333C44 ser� aceito mas aconselho a
 * usar a fun��o soNums() que encotra-se aqui mesmo para que o campo s� aceite
 * caracteres num�ricos. Para usar a fun��o soNums() chame-a no evento
 * onKeyPress desta forma onKeyPress="return soNums(event);" Ap�s limpar o valor
 * verificamos seu tamanho que deve ser ou 11 ou 14 Se o tamanho n�o for aceito
 * a fun��o retorna false e [opcional] mostra uma mensagem de erro. Sugest�es e
 * coment�rios marcos_regis@hotmail.com
 * ####################################################################
 ******************************************************************************/ 

// a fun��o principal de valida��o
function validar(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres n�o num�ricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==14)){ // validando o tamanho
        alert("'"+s+"' N�o � um CNPJ v�lido!" ); // tamanho inv�lido
		obj.focus();
        return false; 
    } 
    
// se for CNPJ
    if (tam==14){ 
        if(!validaCNPJ(s)){ // chama a fun��o que valida o CNPJ
            alert("'"+s+"' N�o � um CNPJ v�lido!" ); // se quiser mostrar o
														// erro
            obj.select();    // se quiser selecionar o campo enviado
			obj.focus();
            return false;             
        } 
        // alert("'"+s+"' � um CNPJ v�lido!" ); // se quiser mostrar que validou
        obj.value=maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// a fun��o principal de valida��o
function validar2(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres n�o num�ricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==11)){ // validando o tamanho
        alert("'"+s+"' N�o � um CPF v�lido!" ); // tamanho inv�lido
		obj.focus();
        return false; 
    } 
     
// se for CPF
    if (tam==11 ){ 
        if (!validaCPF(s)){ // chama a fun��o que valida o CPF
            alert("'"+s+"' N�o � um CPF v�lido!" ); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em quest�o
			obj.focus();
			return false; 
        } 
        // alert("'"+s+"' � um CPF v�lido!" ); // se quiser mostrar que validou
        obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// fun��o que valida CPF
// O algor�timo de valida��o de CPF � baseado em c�lculos
// para o d�gito verificador (os dois �ltimos)
// N�o entrarei em detalhes de como funciona
function validaCPF(s) { 
    var c = s.substr(0,9); 
    var dv = s.substr(9,2); 
    var d1 = 0; 
    for (var i=0; i<9; i++) { 
        d1 += c.charAt(i)*(10-i); 
     } 
    if (d1 == 0) return false; 
    d1 = 11 - (d1 % 11); 
    if (d1 > 9) d1 = 0; 
    if (dv.charAt(0) != d1){ 
        return false; 
    } 
    d1 *= 2; 
    for (var i = 0; i < 9; i++)    { 
         d1 += c.charAt(i)*(11-i); 
    } 
    d1 = 11 - (d1 % 11); 
    if (d1 > 9) d1 = 0; 
    if (dv.charAt(1) != d1){ 
        return false; 
    } 
    return true; 
} 

// Fun��o que valida CNPJ
// O algor�timo de valida��o de CNPJ � baseado em c�lculos
// para o d�gito verificador (os dois �ltimos)
// N�o entrarei em detalhes de como funciona
function validaCNPJ(CNPJ) { 
    var a = new Array(); 
    var b = new Number; 
    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2]; 
    for (i=0; i<12; i++){ 
        a[i] = CNPJ.charAt(i); 
        b += a[i] * c[i+1]; 
    } 
    if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x } 
    b = 0; 
    for (y=0; y<13; y++) { 
        b += (a[y] * c[y]); 
    } 
    if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; } 
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){ 
        return false; 
    } 
    return true; 
} 

// Fun��o que permite apenas teclas num�ricas
// Deve ser chamada no evento onKeyPress desta forma
// return (soNums(event));

function soNums(e) 
{ 
    if (document.all){var evt=event.keyCode;} 
    else{var evt = e.charCode;} 
    if (evt <20 || (evt >47 && evt<58)){return true;} 
    return false; 
} 

// fun��o que mascara o CPF
function maskCPF(CPF){ 
    return CPF.substring(0,3)+"."+CPF.substring(3,6)+"."+CPF.substring(6,9)+"-"+CPF.substring(9,11); 
} 

// fun��o que mascara o CNPJ
function maskCNPJ(CNPJ){ 
    return CNPJ.substring(0,2)+"."+CNPJ.substring(2,5)+"."+CNPJ.substring(5,8)+"/"+CNPJ.substring(8,12)+"-"+CNPJ.substring(12,14);     
}

//Parei Aqui
function enviar(){


	var codmotorista 	= document.getElementById('codmotorista').value;	
	var motorista 		= document.getElementById('motorista').value;	
	var cpf 			= document.getElementById('cpf').value;	
	
	var erro = 0;

	if(motorista=='')
	{
		alert("Digite o Nome do Motorista!");		
		erro = 1;
	}	
	else if ($('cpf').value=='')
		{
			alert("Preencha o campo CPF corretamente!");
			$('forcpf').focus();
			erro = 1;
		}
		else if(validar2($('cpf'))==false)
			{
				// O alert � dado dentro da fun��o
				erro = 1;
			}		
	
	//Grava os Produtos			 
	if(erro=='0'){	
	
		new ajax ('infomotinsere.php?usucodigo='+ vusuario		
		+ '&codmotorista='+ codmotorista
        + '&motorista='+ motorista
		+ '&cpf=' + cpf 
		, {onLoading: carregando, onComplete: load_grid_mot});
		
	}
	
}

function load_grid_mot(){

	new ajax ('infomotseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_mot});

}

function pesquisar_mot(){

	$("resultado").innerHTML="";
	
	new ajax ('infomotseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_mot});
		
}

function imprime_mot(request){

    limpa_form();
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		var tabela="<table class='borda'><tr>"

		tabela+="<td colspan='0'></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Motorista</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>CPF</b></font></td>"					
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";	
			if(itens[2].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";			
			}
			else {
				tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";			
			}	
			tabela+='<td class="borda" style="cursor: pointer"><img src="imagens/edit.gif" onClick=editar('+itens[0].firstChild.data+')></td>';
			tabela+="<td class='borda' style='cursor: pointer'><img src='imagens/delete.gif' onClick=apagar("+itens[0].firstChild.data+")></td>";
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			tabela+="</tr>";
		}

		tabela+="</table>"
		$("resultado").innerHTML=tabela;
		tabela=null;
	}
	else
		$("resultado").innerHTML="Nenhum registro encontrado...";
}

function limpa_form(){
	
	$("consulta").value="";
	var tabela='<select id="pesquisap" name="pesquisap" size="1" disabled>';
	tabela+="<option value=\"0\">-- Escolha um Motorista --</option>";
    tabela+="</select>"
	$("resultado1").innerHTML=tabela;	
	
	$("codmotorista").value="";
	$("motorista").value="";
	$("cpf").value="";
	
}

function apagar(codigo){
    new ajax ('infomotapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_mot});
}

function editar(codigo){

	new ajax ('infomotcarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function imprime_dados(request){

	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');		

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
		
			var itens = registros[i].getElementsByTagName('item');
				
			$("codmotorista").value=itens[0].firstChild.data;			
			$("motorista").value=itens[1].firstChild.data;						
			$("cpf").value=itens[2].firstChild.data;
						
		}		
	}
	else {
		$("codmotorista").value="";			
		$("motorista").value="";			
		$("cpf").value="";				
	}
		
}
