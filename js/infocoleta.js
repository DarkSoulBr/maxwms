var vusuario = 0;

// JavaScript Document
function inicia(usucodigo){

	vusuario = usucodigo;	
	
	//Carrega o Com de Estados
	dadospesquisaestado(0);
		
}

function dadospesquisaestado(valor) {


      //verifica se o browser tem suporte a ajax
	  try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].estado.options.length = 1;

		 idOpcao  = document.getElementById("estado");

       		
		 ajax2.open("POST", "ibgepesquisaestado.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLestado(ajax2.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2.send(params);
      }
	  	 
   }



   function processXMLestado(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].estado.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	         	//idOpcao.innerHTML = "";

			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "estado");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].estado.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  	new ajax ('infocoletaseleciona.php?usucodigo='+ vusuario 
        , {onComplete: imprime_serv});
  
   }
   
   
function itemcomboestado(valor){
	y = document.forms[0].estado.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estado.options[i].selected = true;
		var l = document.forms[0].estado;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor || valor==''){
			i=y;
		}			
	}		
}   

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
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
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Serie</b></font></td>"
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Numero</b></font></td>"			
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Emissao</b></font></td>"			
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>CNPJ</b></font></td>"		
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>IE</b></font></td>"		
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>UF</b></font></td>"		
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Fone</b></font></td>"		
		tabela+="<td colspan='1' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Interno</b></font></td>"		
		tabela+="<td colspan='2' class='borda' bgcolor='#3366CC' bordercolor='#3366CC'><font color='#ffffff'><b>Controles</b></font></td>"
		tabela+="<td colspan='0'></td>"
		tabela+="</tr>"

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			tabela+="<td class='borda2' >"+itens[0].firstChild.data+"</td>";
			if(itens[1].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[1].firstChild.data+"</td>";	
			}
			if(itens[2].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[2].firstChild.data+"</td>";	
			}	
			if(itens[3].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[3].firstChild.data+"</td>";	
			}
			if(itens[4].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[4].firstChild.data+"</td>";	
			}
			if(itens[5].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[5].firstChild.data+"</td>";	
			}
			if(itens[6].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[6].firstChild.data+"</td>";	
			}
			if(itens[7].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[7].firstChild.data+"</td>";	
			}
			if(itens[8].firstChild.data=='_'){
				tabela+="<td class='borda' >&nbsp;</td>";	
			}
			else {
				tabela+="<td class='borda' >"+itens[8].firstChild.data+"</td>";	
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

function load_grid_serv(){

	new ajax ('infocoletaseleciona.php?usucodigo='+ vusuario
        , {onComplete: pesquisar_serv});

}

function pesquisar_serv(){

	$("resultado").innerHTML="";
	
	new ajax ('infocoletaseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});
		
}

function enviar(){

	var codcoleta = document.getElementById('codcoleta').value;	
	var serie = document.getElementById('serie').value;
	var numero = document.getElementById('numero').value;
	var emissao = document.getElementById('emissao').value;
	var forcnpj = document.getElementById('forcnpj').value;
	var forie = document.getElementById('forie').value;
	var estado = document.forms[0].estado.options[document.forms[0].estado.selectedIndex].text
	var fone = document.getElementById('fnefone').value;
	var interno = document.getElementById('interno').value;
	
	trimjs(document.getElementById('emissao').value);
	if (txt==''){alert('Digite a Emissao!');return;}
		
	if (valida_data('emissao')==false){return;};	
		
	var erro = 0;

	if(serie=='')
	{
		alert("Digite a Serie!");		
		erro = 1;
	}
	else if(numero=='')
		{
			alert("Digite o Número!");			
			erro = 1;
		}		 
		else if(validar($('forcnpj'))==false)
			{
				// O alert é dado dentro da função
				erro = 1;
			}
					
	
	//Grava os Servicos
	if(erro=='0'){	
		
		//window.open ('infopedagioinsere.php?usucodigo='+ vusuario		
		new ajax ('infocoletainsere.php?usucodigo='+ vusuario		
		+ '&codcoleta='+ codcoleta
        + '&serie='+ serie
		+ '&numero=' + numero
		+ '&emissao=' + emissao
		+ '&forcnpj=' + forcnpj 
		+ '&forie=' + forie 
		+ '&estado=' + estado 
		+ '&fone=' + fone 
		+ '&interno=' + interno 
		//, '_blank' );
		, {onLoading: carregando, onComplete: load_grid_serv});		
				        
	}
		
}


function apagar(codigo){
    new ajax ('infocoletaapaga.php?codigo=' + codigo
        , {onLoading: carregando, onComplete: load_grid_serv});
}

function editar(codigo){

	new ajax ('infocoletacarrega.php?parametro='+ codigo 
        , {onComplete: imprime_dados});
	
}

function limpa_form(){
	
	$("codcoleta").value="";
	$("serie").value="";
	$("numero").value="";
	$("emissao").value="";
	$("forcnpj").value="";
	$("forie").value="";
	itemcomboestado('');
	$("fnefone").value="";
	$("interno").value="";
		
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
				
			$("codcoleta").value=itens[0].firstChild.data;			
			if(itens[1].firstChild.data=='_'){
				$("serie").value="";				
			}
			else {
				$("serie").value=itens[1].firstChild.data;	
			}
			if(itens[2].firstChild.data=='_'){
				$("numero").value="";				
			}
			else {
				$("numero").value=itens[2].firstChild.data;	
			}	
			if(itens[3].firstChild.data=='_'){
				$("emissao").value="";				
			}
			else {
				$("emissao").value=itens[3].firstChild.data;	
			}
			if(itens[4].firstChild.data=='_'){
				$("forcnpj").value="";				
			}
			else {
				$("forcnpj").value=itens[4].firstChild.data;	
			}
			if(itens[5].firstChild.data=='_'){
				$("forie").value="";				
			}
			else {
				$("forie").value=itens[5].firstChild.data;	
			}
			if(itens[6].firstChild.data=='_'){
				itemcomboestado('');				
			}
			else {
				itemcomboestado(itens[6].firstChild.data);				
			}
			if(itens[7].firstChild.data=='_'){
				$("fnefone").value="";				
			}
			else {
				$("fnefone").value=itens[7].firstChild.data;	
			}
			if(itens[8].firstChild.data=='_'){
				$("interno").value="";
			}
			else {
				$("interno").value=itens[8].firstChild.data;	
			}			
		}		
	}
	else {
		$("codcoleta").value="";
		$("serie").value="";
		$("numero").value="";
		$("emissao").value="";
		$("forcnpj").value="";
		$("forie").value="";
		itemcomboestado('');
		$("fnefone").value="";
		$("interno").value="";
	}
		
}

function Mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function Telefone(v){
    v=v.replace(/\D/g,"")                 
    v=v.replace(/^(\d\d)(\d)/g,"($1)$2") 
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    
    return v
}
 
/*******************************************************************************
 * #################################################################### Assunto =
 * Validação de CPF e CNPJ Autor = Marcos Regis Data = 24/01/2006 Versão = 1.0
 * Compatibilidade = Todos os navegadores. Pode ser usado e distribuído desde
 * que esta linhas sejam mantidas
 * ====------------------------------------------------------------====
 * 
 * Funcionamento = O script recebe como parâmetro um objeto por isso deve ser
 * chamado da seguinte forma: E.: no evento onBlur de um campo texto <input
 * name="cpf_cnpj" type="text" size="40" maxlength="18" onBlur="validar(this);">
 * Ao deixar o campo o evento é disparado e chama validar() com o argumento
 * "this" que representa o próprio objeto com todas as propriedades. A partir
 * daí a função validar() trata a entrada removendo tudo que não for caracter
 * numérico e deixando apenas números, portanto valores escritos só com números
 * ou com separadores como '.' ou mesmo espaços são aceitos ex.: 111222333/44,
 * 111.222.333-44, 111 222 333 44 serão tratadoc como 11122233344 (para CPFs) De
 * certa forma até mesmo valores como 111A222B333C44 será aceito mas aconselho a
 * usar a função soNums() que encotra-se aqui mesmo para que o campo só aceite
 * caracteres numéricos. Para usar a função soNums() chame-a no evento
 * onKeyPress desta forma onKeyPress="return soNums(event);" Após limpar o valor
 * verificamos seu tamanho que deve ser ou 11 ou 14 Se o tamanho não for aceito
 * a função retorna false e [opcional] mostra uma mensagem de erro. Sugestões e
 * comentários marcos_regis@hotmail.com
 * ####################################################################
 ******************************************************************************/ 

// a função principal de validação
function validar(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres não numéricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==14)){ // validando o tamanho
        alert("'"+s+"' Não é um CNPJ válido!" ); // tamanho inválido
		obj.focus();
        return false; 
    } 
    
// se for CNPJ
    if (tam==14){ 
        if(!validaCNPJ(s)){ // chama a função que valida o CNPJ
            alert("'"+s+"' Não é um CNPJ válido!" ); // se quiser mostrar o
														// erro
            obj.select();    // se quiser selecionar o campo enviado
			obj.focus();
            return false;             
        } 
        // alert("'"+s+"' É um CNPJ válido!" ); // se quiser mostrar que validou
        obj.value=maskCNPJ(s);    // se validou o CNPJ mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// a função principal de validação
function validar2(obj) { // recebe um objeto
    var s = (obj.value).replace(/\D/g,''); 
    var tam=(s).length; // removendo os caracteres não numéricos
	if (tam==0){ // validando o tamanho
		return true; 
    } 
    if (!(tam==11)){ // validando o tamanho
        alert("'"+s+"' Não é um CPF válido!" ); // tamanho inválido
		obj.focus();
        return false; 
    } 
     
// se for CPF
    if (tam==11 ){ 
        if (!validaCPF(s)){ // chama a função que valida o CPF
            alert("'"+s+"' Não é um CPF válido!" ); // se quiser mostrar o erro
            obj.select();  // se quiser selecionar o campo em questão
			obj.focus();
			return false; 
        } 
        // alert("'"+s+"' É um CPF válido!" ); // se quiser mostrar que validou
        obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente
        return true; 
    } 
} 
// fim da funcao validar()

// função que valida CPF
// O algorítimo de validação de CPF é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
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

// Função que valida CNPJ
// O algorítimo de validação de CNPJ é baseado em cálculos
// para o dígito verificador (os dois últimos)
// Não entrarei em detalhes de como funciona
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

// Função que permite apenas teclas numéricas
// Deve ser chamada no evento onKeyPress desta forma
// return (soNums(event));

function soNums(e) 
{ 
    if (document.all){var evt=event.keyCode;} 
    else{var evt = e.charCode;} 
    if (evt <20 || (evt >47 && evt<58)){return true;} 
    return false; 
} 

// função que mascara o CPF
function maskCPF(CPF){ 
    return CPF.substring(0,3)+"."+CPF.substring(3,6)+"."+CPF.substring(6,9)+"-"+CPF.substring(9,11); 
} 

// função que mascara o CNPJ
function maskCNPJ(CNPJ){ 
    return CNPJ.substring(0,2)+"."+CNPJ.substring(2,5)+"."+CNPJ.substring(5,8)+"/"+CNPJ.substring(8,12)+"-"+CNPJ.substring(12,14);     
}