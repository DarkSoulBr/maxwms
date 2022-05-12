var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;	
   	new ajax ('infopedagioseleciona.php?usucodigo='+ vusuario 
        , {onComplete: imprime_serv});
		
}

function imprime_serv(request){

    limpa_form();
	$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		var tabela="<table class='borda'><tr>"

		tabela+="<td colspan='0'></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Fornecedor</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Recibo</b></font></td>"			
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Responsavel</b></font></td>"			
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Valor</b></font></td>"		
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			if(itens[2].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";	
			}	
			tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";
			if(itens[3].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[3].firstChild.data+"</td>";
			}	
			tabela+="<td class='borda' align='right'>"+itens[4].firstChild.data+"</td>";				
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


function format_val(rnum,id)
{

	if(rnum.indexOf(',')!=-1)
	{
		rnum = rnum.replace(",",".");		
	}
	
	if (isNaN(rnum)==true){
	
		alert("O campo Valor deve ser preenchido corretamente!");
		$(id).value="";
		return;
	}
	
   	if(rnum > 0)
   	{
		var valor1 = Math.round(rnum*Math.pow(10,2))/Math.pow(10,2);
	   	var valor2;
	
	   	if (valor1>=1)
	   	{
		   	valor1 =  valor1*100;
		   	valor1 = Math.round(valor1);
		   	valor1 =  valor1.toString();
		   	valor2 = valor1.substring(0,valor1.length-2)+'.'+valor1.substring(valor1.length-2,valor1.length);
	
		   	if (valor2=='.0'){valor2='0.00'}
		   	if (valor2=='N.aN'){valor2='0.00'}
	   	}
	   	else
	   	{
			valor2 = (valor1.format(2, ".", ","));
	   	}
	   	$(id).value=valor2;
	}
	else if(rnum <= 0)
   	{		
		valor2='0.00';
	   	$(id).value=valor2;
	}
	
}   



function load_grid_serv(){

	new ajax ('infopedagioseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_serv});

}

function pesquisar_serv(){

	$("resultado").innerHTML="";
	
	new ajax ('infopedagioseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});
		
}

function enviar(){

	var codservico = document.getElementById('codservico').value;	
	var servico = document.getElementById('servico').value;
	var forne = document.getElementById('forcnpj').value;	
	var respo = document.getElementById('rescnpj').value;	
	var valor 	= document.getElementById('valor').value;	
		
	var erro = 0;

	if(servico=='')
	{
		alert("Digite o numero do Comprovante!");		
		erro = 1;
	}
	else if(valor==0 || valor=='' || valor=='0.00')
		{
			alert("Digite o Valor!");			
			erro = 1;
		}		 
		else if(validar($('forcnpj'))==false)
			{
				// O alert � dado dentro da fun��o
				erro = 1;
			}
			else if(validar($('rescnpj'))==false)
				{	
					// O alert � dado dentro da fun��o
					erro = 1;
				}
		
	
	//Grava os Servicos
	if(erro=='0'){	
	
		//window.open ('infopedagioinsere.php?usucodigo='+ vusuario		
		new ajax ('infopedagioinsere.php?usucodigo='+ vusuario		
		+ '&codservico='+ codservico
        + '&servico='+ servico
		+ '&valor=' + valor	
		+ '&respo=' + respo 
		+ '&forne=' + forne 
		//, '_blank' );
		, {onLoading: carregando, onComplete: load_grid_serv});		
		        
	}
	
}


function apagar(codigo){
    new ajax ('infopedagioapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_serv});
}

function editar(codigo){

	new ajax ('infopedagiocarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function limpa_form(){
	
	$("codservico").value="";
	$("servico").value="";
	$("valor").value="";
	$("forcnpj").value="";
	$("rescnpj").value="";
		
}

function carregando(){	
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
				
			$("codservico").value=itens[0].firstChild.data;			
			$("servico").value=itens[1].firstChild.data;
			if(itens[2].firstChild.data=='_'){
				$("forcnpj").value='';
			}
			else {
				$("forcnpj").value=itens[2].firstChild.data;	
			}
			if(itens[3].firstChild.data=='_'){
				$("rescnpj").value='';	
			}
			else {
				$("rescnpj").value=itens[3].firstChild.data;	
			}	
				
			$("valor").value=itens[4].firstChild.data;
			
		}		
	}
	else {
		$("codservico").value="";
		$("servico").value="";
		$("valor").value="";
		$("forcnpj").value="";
		$("rescnpj").value="";
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