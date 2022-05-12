// JavaScript Document       

var carregaCte;

var gctetomuf;
var gtomcidcodigoibge;

var gcteremuf;
var gremcidcodigoibge;

var gcteexpuf;
var gexpcidcodigoibge;

var gcterecuf;
var greccidcodigoibge;

var gctedesuf;
var gdescidcodigoibge;
	
var vusuario = 0;
var uf_emitente = '';
var cidade_emitente = '';

var cep1 = '';
var tomcep1 = '';
var remcep1 = '';
var expcep1 = '';
var reccep1 = '';
var descep1 = '';
var ufibge = '';
var tomufibge = '';
var remufibge = '';
var expufibge = '';
var recufibge = '';
var desufibge = '';

var vgerente = 2;
var valoralterado = 0;
var registrosprtabela = '';

var id_orcamento_corretox = 0;

var numero_correto = 0;

var numero_controle = 0;

var grnum = 0;

function trimjs(valor)
{
	Resultado = String;

	//Retira os espaços do inicio

	var i;
	i = 0;

	while(Resultado.charCodeAt(Resultado.length-1) == "32"){
   		Resultado = Resultado.substring(0,Resultado.length-1);
	}
	return Resultado;
}

 
function format(rnum,id)
{
	if(rnum.indexOf(',')!=-1)
	{
		rnum = rnum.replace(",",".");
		//alert("Num: "+rnum);
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
	//else
	//{
	//	alert("O campo Valor deve ser preenchido corretamente!");
	//	$(id).value="";
		//$(id).focus();
	//}
}



function FormataValor(campo,teclapres) {
	var tammax = 9;
	var NomeForm = 'formulario';

	var tecla = teclapres.keyCode;
	vr = document.forms[NomeForm].elements[campo].value;
	vr = vr.replace( "/", "" );
	vr = vr.replace( "/", "" );
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

	if (tecla == 8 ){	tam = tam - 1 ; }

	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= 2 ){
	 		document.forms[NomeForm].elements[campo].value = vr ; }
	 	if ( (tam > 2) && (tam <= 5) ){
	 		document.forms[NomeForm].elements[campo].value = vr.substr( 0, tam - 2 ) + '.' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 6) && (tam <= 8) ){
	 		document.forms[NomeForm].elements[campo].value = vr.substr( 0, tam - 5 ) + '' + vr.substr( tam - 5, 3 ) + '.' + vr.substr( tam - 2, tam ) ; }
	 	if ( (tam >= 9) && (tam <= 11) ){
	 		document.forms[NomeForm].elements[campo].value = vr.substr( 0, tam - 8 ) + '' + vr.substr( tam - 8, 3 ) + '' + vr.substr( tam - 5, 3 ) + '.' + vr.substr( tam - 2, tam ) ; }
	}
}



//------------- Número do pedido e Data --------// 

function load_pedido2(vusu)
{

	vusuario = vusu;		
	//new ajax('incluirgeracte.php?flag=NumeroOrcamento', {onComplete: imprime_pedido});
	
	//alert(vusuario);
	
	dadospesquisaparametros(1);
	//dadospesquisamodal(0);
	
}


function imprime_pedido(request)
{
	var xmldoc=request.responseXML;
   	var dados = xmldoc.getElementsByTagName('dados')[0];
	var registros = xmldoc.getElementsByTagName('registro');
	var itens = registros[0].getElementsByTagName('item');

	var orcamento = parseInt(itens[0].firstChild.data);
	var modelo = parseInt(itens[1].firstChild.data);
	var serie = itens[2].firstChild.data;
	var numero = itens[3].firstChild.data;
	var emissao = itens[4].firstChild.data;
	var hora = itens[5].firstChild.data;

	$("orcnumero").value=orcamento;
	$("modelo").value=modelo;
	$("serie").value=serie;
	$("numero").value=numero;
	$("orcemissao").value=emissao;
	$("orchora").value=hora;
		
	dadospesquisaparametros(1);
	
}



//--------------- Incluir Orçamento -------------------------//
function incluirorcamento(status)
{
	if (status==1){
		var erro = 0;		
		if($("cfop").value==''){
			alert("Digite o CFOP!");
			$("resultado").innerHTML="Digite o CFOP!";
			erro = 1;
		}
		else if($("natureza").value==''){
			alert("Digite a Natureza de Operação!");
			$("resultado").innerHTML="Digite a Natureza de Operação!";
			erro = 1;
		}		
		else if(document.forms[0].modal.value>1){
			alert("Opção Indisponivel, Utilize Modal Rodoviário!");
			$("resultado").innerHTML="Opção Indisponivel, Utilize Modal Rodoviário!"; 
			erro = 1;
		}
		else if(document.forms[0].finalidade.value==2 && $("chavefin").value==''){
			alert("CTe de Complemento é obrigatorio informar a chave do CTe complementado!");
			$("resultado").innerHTML="CTe de Complemento é obrigatorio informar a chave do CTe complementado!"; 
			erro = 1;
		}
		else if(document.forms[0].finalidade.value==3 && $("chavefin").value==''){
			alert("CTe de Anulação é obrigatorio informar a chave do CTe a ser anulado!");
			$("resultado").innerHTML="CTe de Anulação é obrigatorio informar a chave do CTe a ser anulado!"; 
			erro = 1;
		}
		else if(document.forms[0].finalidade.value==3 && $("datatomador").value==''){
			alert("CTe de Anulação é obrigatorio informar a Data de emissão da declaração do tomador não contribuinte do ICMS!");
			$("resultado").innerHTML="CTe de Anulação é obrigatorio informar a Data de emissão da declaração do tomador não contribuinte do ICMS!"; 
			erro = 1;
		}
		else if(document.forms[0].finalidade.value==4 && $("chavefin").value==''){
			alert("CTe de Substituição é obrigatorio informar a chave do CTe a ser substituido!");
			$("resultado").innerHTML="CTe de Substituição é obrigatorio informar a chave do CTe a ser substituido!"; 
			erro = 1;
		}
		
		if(erro=='0'){
			load_grid(status);
		}	
	}	
	else
	{			
		//numero_correto = 9;
		if(numero_correto==0){
			alert("Favor incluir o Conhecimento na Aba CTe!");
		}
		else {
			load_grid2(status);	
		}	
	}	

}

//--------------------- Inclui os dados na tabela -------------------//
function load_grid(status)
{
	
	$("resultado").innerHTML="Processando...";
	
	var pedido			= $("orcnumero").value;
	var modelo			= $("modelo").value;	
	var serie			= $("serie").value;	
	var numero			= $("numero").value;	

	var orcemissao 		= $("orcemissao").value;	
	var orchora 		= $("orchora").value;	
	
	var cfop 			= $("cfop").value;	
    var natureza 		= $("natureza").value;	

	var modal = document.forms[0].modal.value;
	var servico = document.forms[0].servico.value;
	var finalidade = document.forms[0].finalidade.value;
	
	var pagto = document.forms[0].pagto.value;
	var forma = document.forms[0].forma.value;

	var chave = $("chave").value;	
	
	var chavefin = $("chavefin").value;	
	var datatomador = $("datatomador").value;	
	
	var estado = document.forms[0].estado.value;
	var estadoini = document.forms[0].estadoini.value;
	var estadofim = document.forms[0].estadofim.value;
	
	var cidade = document.forms[0].cidade.value;
	var cidadeini = document.forms[0].cidadeini.value;
	var cidadefim = document.forms[0].cidadefim.value;
	
	
	
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
	if(ajax2) 
	{		
		ajax2.open("POST", "incluirgeractenovo.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function()
		{
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{

	        }
			//após ser processado 
            if(ajax2.readyState == 4 )
            {	
				//conf(id_pedido);				
				if(ajax2.responseXML) {
      			      processXMLinclui(ajax2.responseXML);					  
      			}
            }
    	}	
	}	

	var params = 'flag=InserirOrcamento&tabela=cte&pedido='+pedido+	
	'&numero_correto='+numero_correto+
	'&modelo='+modelo+
	'&serie='+serie+
	'&numero='+numero+
	'&orcemissao='+orcemissao+
	'&orchora='+orchora+
	'&cfop='+cfop+
    '&natureza='+natureza+
	'&modal='+modal+
	'&servico='+servico+
	'&finalidade='+finalidade+
	'&pagto='+pagto+
	'&forma='+forma+
	'&chave='+chave+
	'&estado='+estado+
	'&estadoini='+estadoini+
	'&estadofim='+estadofim+
	'&cidade='+cidade+
	'&cidadeini='+cidadeini+
	'&cidadefim='+cidadefim+
	'&chavefin='+chavefin+
	'&datatomador='+datatomador;
	
	//window.open('incluirgeractenovo.php?' + params );
	ajax2.send(params);	
	

}
//-------------------------------------------------------------------//


//--------------------- Inclui os dados na tabela -------------------//
function load_grid2(status)
{
	
	$("resultado").innerHTML="Processando...";
	
	var pedido			= $("orcnumero").value;
	var modelo			= $("modelo").value;	
	var serie			= $("serie").value;	
	var numero			= $("numero").value;	

	var orcemissao 		= $("orcemissao").value;	
	var orchora 		= $("orchora").value;	
	
	var cfop 			= $("cfop").value;	
    var natureza 		= $("natureza").value;	

	var modal = document.forms[0].modal.value;
	var servico = document.forms[0].servico.value;
	var finalidade = document.forms[0].finalidade.value;
	
	var pagto = document.forms[0].pagto.value;
	var forma = document.forms[0].forma.value;

	var chave = $("chave").value;	
	var chavefin = $("chavefin").value;	
	var datatomador = $("datatomador").value;	
	
	var estado = document.forms[0].estado.value;
	var estadoini = document.forms[0].estadoini.value;
	var estadofim = document.forms[0].estadofim.value;
	
	var cidade = document.forms[0].cidade.value;
	var cidadeini = document.forms[0].cidadeini.value;
	var cidadefim = document.forms[0].cidadefim.value;
	
	var emipessoa = '0';	
	if ( document.getElementById("radio11").checked==true){
		emipessoa = '1'
	}
	else{
		emipessoa = '2'
	}	
	var emicnpj 			= document.getElementById('forcnpj').value;
	var emiie 				= document.getElementById('forie').value;
	var emicpf 				= document.getElementById('forcpf').value;
	var emirg 				= document.getElementById('forrg').value;
	var eminguerra 			= document.getElementById('fornguerra').value;
	var	emirazao 			= document.getElementById('forrazao').value;
	var emicep 				= document.getElementById('fnecep').value;
	var emiendereco 		= document.getElementById('fneendereco').value; 
	var eminumero 			= document.getElementById('fnenumero').value;
	var emibairro 			= document.getElementById('fnebairro').value;
	var emicomplemento 		= document.getElementById('fnecomplemento').value;
	var	emifone 			= document.getElementById('fnefone').value;
	var emipais 			= document.getElementById('fnepais').value
	var emiuf 				= document.getElementById('fneuf').value
	var emicidcodigo 		= document.getElementById('fnecodcidade').value;
	var emicidcodigoibge	= document.getElementById('cidadeibge').value;	
	
	var tomcodigo 			= document.forms[0].tomador.value;
	var tompessoa = '0';	
	if ( document.getElementById("radiotom11").checked==true){
		tompessoa = '1'
	}
	else{
		tompessoa = '2'
	}	
	var tomcnpj 			= document.getElementById('tomcnpj').value;
	var tomie 				= document.getElementById('tomie').value;
	var tomcpf 				= document.getElementById('tomcpf').value;
	var tomrg 				= document.getElementById('tomrg').value;
	var tomnguerra 			= document.getElementById('tomnguerra').value;
	var	tomrazao 			= document.getElementById('tomrazao').value;
	var tomcep 				= document.getElementById('tomcep').value;
	var tomendereco 		= document.getElementById('tomendereco').value; 
	var tomnumero 			= document.getElementById('tomnumero').value;
	var tombairro 			= document.getElementById('tombairro').value;
	var tomcomplemento 		= document.getElementById('tomcomplemento').value;
	var	tomfone 			= document.getElementById('tomfone').value;
	var tompais 			= document.getElementById('tompais').value
	var tomuf 				= document.getElementById('tomuf').value
	var tomcidcodigo 		= document.getElementById('tomcodcidade').value;
	var tomcidcodigoibge	= document.getElementById('tomcidadeibge').value;	
	
	var remcodigo 			= document.forms[0].remetente.value;
	var rempessoa = '0';	
	if ( document.getElementById("radiorem11").checked==true){
		rempessoa = '1'
	}
	else{
		rempessoa = '2'
	}	
	var remcnpj 			= document.getElementById('remcnpj').value;
	var remie 				= document.getElementById('remie').value;
	var remcpf 				= document.getElementById('remcpf').value;
	var remrg 				= document.getElementById('remrg').value;
	var remnguerra 			= document.getElementById('remnguerra').value;
	var	remrazao 			= document.getElementById('remrazao').value;
	var remcep 				= document.getElementById('remcep').value;
	var remendereco 		= document.getElementById('remendereco').value; 
	var remnumero 			= document.getElementById('remnumero').value;
	var rembairro 			= document.getElementById('rembairro').value;
	var remcomplemento 		= document.getElementById('remcomplemento').value;
	var	remfone 			= document.getElementById('remfone').value;
	var rempais 			= document.getElementById('rempais').value
	var remuf 				= document.getElementById('remuf').value
	var remcidcodigo 		= document.getElementById('remcodcidade').value;
	var remcidcodigoibge	= document.getElementById('remcidadeibge').value;	
	
	var expcodigo 			= document.forms[0].expedidor.value;
	var exppessoa = '0';	
	if ( document.getElementById("radioexp11").checked==true){
		exppessoa = '1'
	}
	else{
		exppessoa = '2'
	}	
	var expcnpj 			= document.getElementById('expcnpj').value;
	var expie 				= document.getElementById('expie').value;
	var expcpf 				= document.getElementById('expcpf').value;
	var exprg 				= document.getElementById('exprg').value;
	var expnguerra 			= document.getElementById('expnguerra').value;
	var	exprazao 			= document.getElementById('exprazao').value;
	var expcep 				= document.getElementById('expcep').value;
	var expendereco 		= document.getElementById('expendereco').value; 
	var expnumero 			= document.getElementById('expnumero').value;
	var expbairro 			= document.getElementById('expbairro').value;
	var expcomplemento 		= document.getElementById('expcomplemento').value;
	var	expfone 			= document.getElementById('expfone').value;
	var exppais 			= document.getElementById('exppais').value
	var expuf 				= document.getElementById('expuf').value
	var expcidcodigo 		= document.getElementById('expcodcidade').value;
	var expcidcodigoibge	= document.getElementById('expcidadeibge').value;	
	
	var reccodigo 			= document.forms[0].recebedor.value;
	var recpessoa = '0';	
	if ( document.getElementById("radiorec11").checked==true){
		recpessoa = '1'
	}
	else{
		recpessoa = '2'
	}	
	var reccnpj 			= document.getElementById('reccnpj').value;
	var recie 				= document.getElementById('recie').value;
	var reccpf 				= document.getElementById('reccpf').value;
	var recrg 				= document.getElementById('recrg').value;
	var recnguerra 			= document.getElementById('recnguerra').value;
	var	recrazao 			= document.getElementById('recrazao').value;
	var reccep 				= document.getElementById('reccep').value;
	var recendereco 		= document.getElementById('recendereco').value; 
	var recnumero 			= document.getElementById('recnumero').value;
	var recbairro 			= document.getElementById('recbairro').value;
	var reccomplemento 		= document.getElementById('reccomplemento').value;
	var	recfone 			= document.getElementById('recfone').value;
	var recpais 			= document.getElementById('recpais').value
	var recuf 				= document.getElementById('recuf').value
	var reccidcodigo 		= document.getElementById('reccodcidade').value;
	var reccidcodigoibge	= document.getElementById('reccidadeibge').value;	
	
	var descodigo 			= document.forms[0].destinatario.value;
	var despessoa = '0';	
	if ( document.getElementById("radiodes11").checked==true){
		despessoa = '1'
	}
	else{
		despessoa = '2'
	}	
	var descnpj 			= document.getElementById('descnpj').value;
	var desie 				= document.getElementById('desie').value;
	var descpf 				= document.getElementById('descpf').value;
	var desrg 				= document.getElementById('desrg').value;
	var desnguerra 			= document.getElementById('desnguerra').value;
	var	desrazao 			= document.getElementById('desrazao').value;
	var descep 				= document.getElementById('descep').value;
	var desendereco 		= document.getElementById('desendereco').value; 
	var desnumero 			= document.getElementById('desnumero').value;
	var dessuframa 			= document.getElementById('dessuframa').value;
	var desbairro 			= document.getElementById('desbairro').value;
	var descomplemento 		= document.getElementById('descomplemento').value;
	var	desfone 			= document.getElementById('desfone').value;
	var despais 			= document.getElementById('despais').value
	var desuf 				= document.getElementById('desuf').value
	var descidcodigo 		= document.getElementById('descodcidade').value;
	var descidcodigoibge	= document.getElementById('descidadeibge').value;	
	
	
	var cteservicos 		= document.getElementById('valorservico').value;	
	var ctereceber 			= document.getElementById('valorreceber').value;	
	var ctetributos 		= document.getElementById('valortributos').value;	
	var sitcodigo 			= document.forms[0].situacao.value;
	var cteperreducao 		= document.getElementById('reducao').value;	
	var ctebasecalculo 		= document.getElementById('baseicms').value;	
	var ctepericms 			= document.getElementById('percicms').value;	
	var ctevalicms 			= document.getElementById('valoricms').value;	
	var ctecredito 			= document.getElementById('valorcredito').value;	
	var ctepreencheicms		= '0';	
	if ( document.getElementById("opcao_icms1").checked==true){
		ctepreencheicms 	= '1'
	}		
	var ctebaseicms 		= document.getElementById('interbase').value;	
	var cteperinterna 		= document.getElementById('interpercterm').value;	
	var cteperinter 		= document.getElementById('interpercinter').value;	
	var cteperpartilha 		= document.forms[0].partilha.value;
	var ctevalicmsini 		= document.getElementById('intervalini').value;	
	var ctevalicmsfim 		= document.getElementById('intervalfim').value;	
	var cteperpobreza 		= document.getElementById('interpercpobr').value;	
	var ctevalpobreza 		= document.getElementById('intervalpobr').value;	
	var cteadcfisco 		= document.getElementById('adcfisco').value;
	
	var ctecargaval 		= document.getElementById('valorcarga').value;
	var ctepropredominante 	= document.getElementById('produtopre').value;
	var cteoutcaracteristica= document.getElementById('produtoout').value;
	var ctecobrancanum 		= document.getElementById('cobnumero').value;
	var ctecobrancaval 		= document.getElementById('cobvalor').value;
	var ctecobrancades 		= document.getElementById('cobdesconto').value;
	var ctecobrancaliq 		= document.getElementById('cobliquido').value;	
	
	var cterntrc 			= document.getElementById('gerrntrc').value;	
	var cteentrega 			= document.getElementById('gerentrega').value;	
	var cteindlocacao 		= document.forms[0].lotacao.value;
	var cteciot 			= document.getElementById('gerciot').value;		
	
	var cteobsgeral 		= document.getElementById('obsgeral').value;		
	
	var ctesubstipo  = '0';
	var ctesubschave  = '';	
	
	if (document.getElementById("chaveacesso").disabled == false){
	
		if ( document.getElementById("radio111").checked==true){
			ctesubstipo  = '1'
		}
		else if ( document.getElementById("radio112").checked==true){
			ctesubstipo  = '2'
		}
		else{
			ctesubstipo  = '3'
		}	
		
		ctesubschave 		= document.getElementById('chaveacesso').value;
		
	}	
	
	
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
	if(ajax2) 
	{		
		ajax2.open("POST", "incluirgeractenovo.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.onreadystatechange = function()
		{
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{

	        }
			//após ser processado 
            if(ajax2.readyState == 4 )
            {	
				//conf(id_pedido);				
				if(ajax2.responseXML) {
      			      processXMLinclui(ajax2.responseXML);					  
      			}
            }
    	}	
	}	

	var params = 'flag=InserirOrcamento&tabela=ctecompleto&pedido='+pedido+	
	'&numero_correto='+numero_correto+
	'&modelo='+modelo+
	'&serie='+serie+
	'&numero='+numero+
	'&orcemissao='+orcemissao+
	'&orchora='+orchora+
	'&cfop='+cfop+
    '&natureza='+natureza+
	'&modal='+modal+
	'&servico='+servico+
	'&finalidade='+finalidade+
	'&pagto='+pagto+
	'&forma='+forma+
	'&chave='+chave+
	'&estado='+estado+
	'&estadoini='+estadoini+
	'&estadofim='+estadofim+
	'&cidade='+cidade+
	'&cidadeini='+cidadeini+
	'&cidadefim='+cidadefim+
	'&emipessoa='+emipessoa+
	'&emicnpj='+emicnpj+
	'&emiie='+emiie+
	'&emicpf='+emicpf+
	'&emirg='+emirg+
	'&eminguerra='+eminguerra+
	'&emirazao='+emirazao+
	'&emicep='+emicep+
	'&emiendereco='+emiendereco+
	'&eminumero='+eminumero+
	'&emibairro='+emibairro+
	'&emicomplemento='+emicomplemento+
	'&emifone='+emifone+
	'&emipais='+emipais+
	'&emiuf='+emiuf+
	'&emicidcodigo='+emicidcodigo+
	'&emicidcodigoibge='+emicidcodigoibge+
	'&tomcodigo='+tomcodigo+
	'&tompessoa='+tompessoa+
	'&tomcnpj='+tomcnpj+
	'&tomie='+tomie+
	'&tomcpf='+tomcpf+
	'&tomrg='+tomrg+
	'&tomnguerra='+tomnguerra+
	'&tomrazao='+tomrazao+
	'&tomcep='+tomcep+
	'&tomendereco='+tomendereco+
	'&tomnumero='+tomnumero+
	'&tombairro='+tombairro+
	'&tomcomplemento='+tomcomplemento+
	'&tomfone='+tomfone+
	'&tompais='+tompais+
	'&tomuf='+tomuf+
	'&tomcidcodigo='+tomcidcodigo+
	'&tomcidcodigoibge='+tomcidcodigoibge+
	'&remcodigo='+remcodigo+
	'&rempessoa='+rempessoa+
	'&remcnpj='+remcnpj+
	'&remie='+remie+
	'&remcpf='+remcpf+
	'&remrg='+remrg+
	'&remnguerra='+remnguerra+
	'&remrazao='+remrazao+
	'&remcep='+remcep+
	'&remendereco='+remendereco+
	'&remnumero='+remnumero+
	'&rembairro='+rembairro+
	'&remcomplemento='+remcomplemento+
	'&remfone='+remfone+
	'&rempais='+rempais+
	'&remuf='+remuf+
	'&remcidcodigo='+remcidcodigo+
	'&remcidcodigoibge='+remcidcodigoibge+
	'&expcodigo='+expcodigo+
	'&exppessoa='+exppessoa+
	'&expcnpj='+expcnpj+
	'&expie='+expie+
	'&expcpf='+expcpf+
	'&exprg='+exprg+
	'&expnguerra='+expnguerra+
	'&exprazao='+exprazao+
	'&expcep='+expcep+
	'&expendereco='+expendereco+
	'&expnumero='+expnumero+
	'&expbairro='+expbairro+
	'&expcomplemento='+expcomplemento+
	'&expfone='+expfone+
	'&exppais='+exppais+
	'&expuf='+expuf+
	'&expcidcodigo='+expcidcodigo+
	'&expcidcodigoibge='+expcidcodigoibge+
	'&reccodigo='+reccodigo+
	'&recpessoa='+recpessoa+
	'&reccnpj='+reccnpj+
	'&recie='+recie+
	'&reccpf='+reccpf+
	'&recrg='+recrg+
	'&recnguerra='+recnguerra+
	'&recrazao='+recrazao+
	'&reccep='+reccep+
	'&recendereco='+recendereco+
	'&recnumero='+recnumero+
	'&recbairro='+recbairro+
	'&reccomplemento='+reccomplemento+
	'&recfone='+recfone+
	'&recpais='+recpais+
	'&recuf='+recuf+
	'&reccidcodigo='+reccidcodigo+
	'&reccidcodigoibge='+reccidcodigoibge+
	'&descodigo='+descodigo+
	'&despessoa='+despessoa+
	'&descnpj='+descnpj+
	'&desie='+desie+
	'&descpf='+descpf+
	'&desrg='+desrg+
	'&desnguerra='+desnguerra+
	'&desrazao='+desrazao+
	'&descep='+descep+
	'&desendereco='+desendereco+
	'&desnumero='+desnumero+
	'&dessuframa='+dessuframa+
	'&desbairro='+desbairro+
	'&descomplemento='+descomplemento+
	'&desfone='+desfone+
	'&despais='+despais+
	'&desuf='+desuf+
	'&descidcodigo='+descidcodigo+
	'&descidcodigoibge='+descidcodigoibge+
	'&cteservicos='+cteservicos+
	'&ctereceber='+ctereceber+
	'&ctetributos='+ctetributos+
	'&sitcodigo='+sitcodigo+
	'&cteperreducao='+cteperreducao+
	'&ctebasecalculo='+ctebasecalculo+
	'&ctepericms='+ctepericms+
	'&ctevalicms='+ctevalicms+
	'&ctecredito='+ctecredito+
	'&ctepreencheicms='+ctepreencheicms+
	'&ctebaseicms='+ctebaseicms+
	'&cteperinterna='+cteperinterna+
	'&cteperinter='+cteperinter+
	'&cteperpartilha='+cteperpartilha+
	'&ctevalicmsini='+ctevalicmsini+
	'&ctevalicmsfim='+ctevalicmsfim+
	'&cteperpobreza='+cteperpobreza+
	'&ctevalpobreza='+ctevalpobreza+
	'&cteadcfisco='+cteadcfisco+	
	'&ctecargaval='+ctecargaval+
	'&ctepropredominante='+ctepropredominante+
	'&cteoutcaracteristica='+cteoutcaracteristica+
	'&ctecobrancanum='+ctecobrancanum+
	'&ctecobrancaval='+ctecobrancaval+
	'&ctecobrancades='+ctecobrancades+
	'&ctecobrancaliq='+ctecobrancaliq+
	'&cterntrc='+cterntrc+
	'&cteentrega='+cteentrega+
	'&cteindlocacao='+cteindlocacao+
	'&cteciot='+cteciot+
	'&cteobsgeral='+cteobsgeral+
	'&usucodigo='+vusuario+
	'&chavefin='+chavefin+
	'&datatomador='+datatomador+
	'&ctesubstipo='+ctesubstipo+
	'&ctesubschave='+ctesubschave
	;
		
	//window.open('incluirgeractenovo.php?' + params );
	ajax2.send(params);	
	

}

//-------------------------------------------------------------------//




function fim(request)
{
	var xmldoc=request.responseXML;
   	var dados = xmldoc.getElementsByTagName('dados')[0];
	var registros = xmldoc.getElementsByTagName('registro');
	var itens = registros[0].getElementsByTagName('item');

	var id_orcamento_corretox = parseInt(itens[1].firstChild.data);

	alert("Controle de devolução incluído com sucesso com o número: "+id_orcamento_corretox);	
	$("resultado").innerHTML="Controle de devolução incluído com sucesso com o número: "+id_orcamento_corretox;
	
	//history.go(0);
	window.open("incluircontroledevnovo.php","_self");
	
}


function processXMLinclui(obj){

	var numero_cte = '';

    //pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	//total de elementos contidos na tag dado
	if(dataArray.length > 0) {
		//percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];			
			//contéudo dos campos no arquivo XML
			numero_correto =  item.getElementsByTagName("pvnumero")[0].firstChild.nodeValue;
			numero_cte =  item.getElementsByTagName("ctenumero")[0].firstChild.nodeValue;	
		}
	}
	else {
	  
	     //caso o XML volte vazio
         // alert("Pedido Não Encontrado!");
         
	}	
	
	if(numero_cte==''){
		alert('Problema com a inclusão do CTE, favor avisar o T.I.');
	}
	else {
		//Atualiza os campos na Tela	
		$("orcnumero").value=numero_correto;	
		$("numero").value=numero_cte;		
		
		
		$("resultado").innerHTML="";
		alert("CTe atualizado!");
	}	
  
	//alert("CTe incluído com sucesso com o número: "+numero_correto);	
	//$("resultado").innerHTML="CTe incluido com sucesso com o número: "+numero_correto;	
	//window.open("incluircte.php","_self");

}   

function dadospesquisausu(valor)
{

   
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

     ajax2.open("POST", "pesquisausu.php", true);
	 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	 
	 ajax2.onreadystatechange = function() {
        //enquanto estiver processando...emite a msg de carregando
		if(ajax2.readyState == 1) {

        }
		//após ser processado - chama função processXML que vai varrer os dados
        if(ajax2.readyState == 4 ) {
		   if(ajax2.responseXML) {
		      processXMLusu(ajax2.responseXML);				  
		   }
		   else {

		   }
        }
     }
	 //passa o parametro
     var params = "parametro="+valor;
     ajax2.send(params);
  }
  
    
}

function processXMLusu(obj)
{
	//pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");
      
	//total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		//percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			
			trimjs(codigo);
       		codigo = txt;
			trimjs(descricao);
			descricao  = txt;
			trimjs(descricao2);
			descricao2  = txt;
			
			vgerente = descricao2; 

		}
	}
	else
	{
	    //caso o XML volte vazio, printa a mensagem abaixo

	}
	
	
   		
	
}

function cancelarPedido()
{

	window.open('alterarcte.php', "_self" );
	
}

function formata_data(obj)
{
	obj.value = obj.value.replace( "//", "/" );
	tam = obj.value;
	
	if (tam.length == 2 || tam.length == 5)
		obj.value = obj.value + "/";
}   

function dadospesquisamodal(valor) {


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
		 document.forms[0].modal.options.length = 1;

		 idOpcao  = document.getElementById("modal");

       		
 	         ajax2.open("POST", "ctepesquisamodal.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLmodal(ajax2.responseXML);
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



   function processXMLmodal(obj){
	   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].modal.options.length = 0;

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
			    novo.setAttribute("id", "modal");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].modal.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisaservico(0);
  
   }   

function dadospesquisaservico(valor) {


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
		 document.forms[0].servico.options.length = 1;

		 idOpcao  = document.getElementById("servico");

       		
 	         ajax2.open("POST", "ctepesquisaservico.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLservico(ajax2.responseXML);
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



   function processXMLservico(obj){	
	   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].servico.options.length = 0;

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
			    novo.setAttribute("id", "servico");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].servico.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisafinalidade(0);
  
   }  

function dadospesquisafinalidade(valor) {


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
		 document.forms[0].finalidade.options.length = 1;

		 idOpcao  = document.getElementById("finalidade");

       		
 	         ajax2.open("POST", "ctepesquisafinalidade.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLfinalidade(ajax2.responseXML);
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



   function processXMLfinalidade(obj){	
	   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].finalidade.options.length = 0;

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
			    novo.setAttribute("id", "finalidade");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].finalidade.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisapagto(0);
  
   }     
   
function dadospesquisapagto(valor) {


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
		 document.forms[0].pagto.options.length = 1;

		 idOpcao  = document.getElementById("pagto");

       		
 	         ajax2.open("POST", "ctepesquisapagto.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLpagto(ajax2.responseXML);
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



   function processXMLpagto(obj){	
	   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].pagto.options.length = 0;

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
			    novo.setAttribute("id", "pagto");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].pagto.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisaforma(0);
  
   }        
   
function dadospesquisaforma(valor) {


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
		 document.forms[0].forma.options.length = 1;

		 idOpcao  = document.getElementById("forma");

       		
 	         ajax2.open("POST", "ctepesquisaforma.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLforma(ajax2.responseXML);
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



   function processXMLforma(obj){
	   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].forma.options.length = 0;

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
			    novo.setAttribute("id", "forma");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].forma.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  //dadospesquisaestado(0);
	  dadospesquisatiposituacao(0);
  
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
	  
	  itemcomboestado(uf_emitente);	  
	  dadospesquisaestadoini(0);
  
   }
   
   
   function dadospesquisaestadoini(valor) {


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
		 document.forms[0].estadoini.options.length = 1;

		 idOpcao  = document.getElementById("estadoini");

       		
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
			   			    			 
			      processXMLestadoini(ajax2.responseXML);
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



   function processXMLestadoini(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].estadoini.options.length = 0;

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
			    novo.setAttribute("id", "estadoini");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].estadoini.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  itemcomboestadoini(uf_emitente);	  
	  dadospesquisaestadofim(0);
  
   }
   
   
   function dadospesquisaestadofim(valor) {


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
		 document.forms[0].estadofim.options.length = 1;

		 idOpcao  = document.getElementById("estadofim");

       		
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
			   			    			 
			      processXMLestadofim(ajax2.responseXML);
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



   function processXMLestadofim(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].estadofim.options.length = 0;

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
			    novo.setAttribute("id", "estadofim");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].estadofim.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  itemcomboestadofim(uf_emitente);	  
	  //dadospesquisaforma(0);
	  
	  //Se foi chamado por outra tela já carrega os dados
	  if(carregaCte>0){
			$("orcnumero").value=carregaCte;
			$("orcnumero").disabled=true;
			carregaCte=0;
			load_pedidopesq0($("orcnumero").value,vusuario)
	  }
	  
  
   }   
   

function dadospesquisaparametros(valor)
{	

	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
        }
    }
	
	  // se tiver suporte ajax
	if(ajax2)
	{	  	

		ajax2.open("POST", "empresapesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{			
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{					
			    	processXMLparametros(ajax2.responseXML);
			   	}
				else {
					alert('Favor cadastrar o Emitente antes de Continuar!');
				}				
			}
		}
		
		valor2 = "1";        
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		
	}
	
}   


function processXMLparametros(obj)
{

	
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{		

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;			
			uf_emitente = descricaoz;
			cidade_emitente = cidadeibge;
				
		}
	}		
	
	dadospesquisamodal(0);
}	

function itemcomboestado(valor){
	y = document.forms[0].estado.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estado.options[i].selected = true;
		var l = document.forms[0].estado;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}	
	dadospesquisacidade(valor,0);	
}

function itemcomboestadoini(valor){
	y = document.forms[0].estadoini.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estadoini.options[i].selected = true;
		var l = document.forms[0].estadoini;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}
	dadospesquisacidadeini(valor,0);
}

function itemcomboestadofim(valor){
	y = document.forms[0].estadofim.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estadofim.options[i].selected = true;
		var l = document.forms[0].estadofim;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}
	dadospesquisacidadefim(valor);
}

function itemcombocidade(valor){
	y = document.forms[0].cidade.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidade.options[i].selected = true;
		var l = document.forms[0].cidade;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}
}

function itemcombocidadeini(valor){
	y = document.forms[0].cidadeini.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidadeini.options[i].selected = true;
		var l = document.forms[0].cidadeini;
		var li = l.options[l.selectedIndex].text;
		if(li==valor){
			i=y;
		}			
	}
}

function itemcombocidadefim(valor){
	y = document.forms[0].cidadefim.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidadefim.options[i].selected = true;
		var l = document.forms[0].cidadefim;
		var li = l.options[l.selectedIndex].text;
		if(li==valor){
			i=y;
		}			
	}
	
	dadospesquisatipotomador(0);
	
}


function dadospesquisatipotomador(valor) {


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
		 document.forms[0].tomador.options.length = 1;

		 idOpcao  = document.getElementById("tomador");

       		
 	         ajax2.open("POST", "ctepesquisatomador.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtipotomador(ajax2.responseXML);
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



   function processXMLtipotomador(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].tomador.options.length = 0;

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
			    novo.setAttribute("id", "tomador");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].tomador.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatiporemetente(0);
  
   }

function dadospesquisatiporemetente(valor) {


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
		 document.forms[0].remetente.options.length = 1;

		 idOpcao  = document.getElementById("remetente");

       		
 	         ajax2.open("POST", "ctepesquisaremetente.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtiporemetente(ajax2.responseXML);
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



   function processXMLtiporemetente(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].remetente.options.length = 0;

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
			    novo.setAttribute("id", "remetente");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].remetente.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatipoexpedidor(0);
  
   }   


function dadospesquisacidade(valor,valor2) {


      //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidade = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidade = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidade = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidade = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidade) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidade.options.length = 1;

		 idOpcaoCid  = document.getElementById("cidade");

       		
		 ajax2Cidade.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidade.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidade.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidade.readyState == 1) {
			   idOpcaoCid.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidade.readyState == 4 ) {
			   if(ajax2Cidade.responseXML) {
			   			    			 
			      processXMLcidade(ajax2Cidade.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCid.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidade.send(params);
      }
	  	 
   }



   function processXMLcidade(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidade.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidade");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidade.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCid.innerHTML = "____________________";

	  }
	  
	  itemcombocidade(cidade_emitente);	  
	    
   }
   
   
   function dadospesquisacidadeini(valor,valor2) {


      //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidadeini = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidadeini = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidadeini = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidadeini = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidadeini) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidadeini.options.length = 1;

		 idOpcaoCidIni  = document.getElementById("cidadeini");

       		
		 ajax2Cidadeini.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidadeini.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidadeini.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidadeini.readyState == 1) {
			   idOpcaoCidIni.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidadeini.readyState == 4 ) {
			   if(ajax2Cidadeini.responseXML) {
			   			    			 
			      processXMLcidadeini(ajax2Cidadeini.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCidIni.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidadeini.send(params);
      }
	  	 
   }



   function processXMLcidadeini(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidadeini.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidadeini");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidadeini.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCidIni.innerHTML = "____________________";

	  }
	  
	  itemcombocidadeini(cidade_emitente);	  
  
   }
   
   
   function dadospesquisacidadefim(valor) {


      //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidadefim = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidadefim = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidadefim = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidadefim = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidadefim) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidadefim.options.length = 1;

		 idOpcaoCidfim  = document.getElementById("cidadefim");

       		
		 ajax2Cidadefim.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidadefim.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidadefim.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidadefim.readyState == 1) {
			   idOpcaoCidfim.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidadefim.readyState == 4 ) {
			   if(ajax2Cidadefim.responseXML) {
			   			    			 
			      processXMLcidadefim(ajax2Cidadefim.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCidfim.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidadefim.send(params);
      }
	  	 
   }



   function processXMLcidadefim(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidadefim.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidadefim");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidadefim.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCidfim.innerHTML = "____________________";

	  }
	  
	  itemcombocidadefim(cidade_emitente);	  
	    
   }
   
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

function verificacfop(codigo){

	new ajax('verificacfop.php?cfop='+codigo, {onComplete: imprime_cfop});
	
}   

function imprime_cfop(request)
{
    
	var xmldoc=request.responseXML;
	
	$("natureza").value="";

    if(xmldoc!=null)
	{
		var dados = xmldoc.getElementsByTagName('dados')[0];
		
		//Acesso para desconto entre 5 e 10%
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			if(itens[0].firstChild.data!=null)
			{
           		if(itens[0].firstChild.data!='_'){           		    
					$("natureza").value=itens[0].firstChild.data;
                }				
            }
		}
		
		
	}
	
}

function verificapessoa(valor)
{
	if( document.getElementById("radio11").checked==true)
	{
		$("forcnpj").disabled = false;
		$("forie").disabled = false;
		$("forrg").value = "";
		$("forcpf").value = "";
		$("forrg").disabled = true;
		$("forcpf").disabled = true;
	}
	else
	{
		$("forcnpj").disabled = true;
		$("forie").disabled = true;
		$("forcnpj").value = "";
		$("forie").value = "";
		$("forrg").disabled = false;
		$("forcpf").disabled = false;
	}
}

// JavaScript Document
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

function pesquisacep(valor)
{
	trimjs($("fnecep").value);

	if(cep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEP(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("fnecidade").value="";
      		$("fneuf").value="";
      		$("fnecodcidade").value="";
		}
	}
}

function processXMLCEP(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("fneendereco").value=descricao3;
			$("fnebairro").value=descricao4.substring(0,30);
            $("fnecidade").value=descricao;
			$("fneuf").value=descricao2;
 	        $("fnecodcidade").value=codigo;
  	        cep1=$("fnecep").value;

  	        // busca cidade ibge
           	dadospesquisaibgerep(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("fnecep").focus();
	}
}

function dadospesquisaibgerep(valor)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].cidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("cidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgerep(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerep(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].cidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "cidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].cidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].cidadeibge.options.add(novo);

            document.forms[0].cidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("cidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(ufibge != "")
	{
	$('cidadeibge').value = ufibge;
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

function dadospesquisa(valor)
{	

	alert('xxx');

	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {	  	
		ajax2.open("POST", "empresapesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXML(ajax2.responseXML);
			   	}
			   	else
			   	{			    	
					// caso o XML volte vazio, printa a mensagem abaixo
					cep1="";        		
					$("fornguerra").value="";		
					$("forrazao").value="";		
					$("forcnpj").value="";
					$("forie").value="";
					$("forrg").value="";
					$("forcpf").value="";		
					$("fnecep").value="";
					$("fneendereco").value="";
					$("fnebairro").value="";
					$("fnefone").value="";
					$("fnecomplemento").value="";	
					$("fnepais").value="";		
					document.getElementById("radio11").checked=true;
			   	}
			}
		}
		
		valor2 = "1";        
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function processXML(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			if(i==0)
			{
                cep1=descricao2a;

				$("fornguerra").value=descricao;				
				$("forrazao").value=descricaoc;				
				$("forcnpj").value=descricaoe;
				$("forie").value=descricaof;
				$("forrg").value=descricaog;
				$("forcpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radio11").checked=true;
					$("forcnpj").disabled=false;
					$("forie").disabled=false;
					$("forrg").disabled=true;
					$("forcpf").disabled=true;
				}
                else
                {
                    document.getElementById("radio12").checked=true;
					$("forcnpj").disabled=true;
					$("forie").disabled=true;
					$("forrg").disabled=false;
					$("forcpf").disabled=false;
				}
				$("fnecep").value=descricao2a;
				$("fneendereco").value=descricao2b;
				$("fnebairro").value=descricao2c;
				$("fnefone").value=descricao2d;
				$("fnecomplemento").value=descricao2e;
				
                $("fnecodcidade").value=descricaov;
				$("fnecidade").value=descricaox;
				$("fneuf").value=descricaoz;
				
				$("fnenumero").value=fnenumero;
				$("fnepais").value="BRASIL";
				
										
				document.getElementById("radio11").disabled = false;		
				document.getElementById("radio12").disabled = false;
			
				if( document.getElementById("radio11").checked==true)
				{
					$("forcnpj").disabled = false;
					$("forie").disabled = false;
					$("forrg").value = "";
					$("forcpf").value = "";
					$("forrg").disabled = true;
					$("forcpf").disabled = true;
				}
				else
				{
					$("forcnpj").disabled = true;
					$("forie").disabled = true;
					$("forcnpj").value = "";
					$("forie").value = "";
					$("forrg").disabled = false;
					$("forcpf").disabled = false;
				}
				document.getElementById("radio11").disabled = false;
				document.getElementById("radio12").disabled = false;					
												 
				ufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgerep('"+descricaoz+"')", 1000);
								
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	cep1="";        		
		$("fornguerra").value="";		
		$("forrazao").value="";		
		$("forcnpj").value="";
		$("forie").value="";
		$("forrg").value="";
		$("forcpf").value="";		
		$("fnecep").value="";
		$("fneendereco").value="";
		$("fnebairro").value="";
		$("fnefone").value="";
		$("fnecomplemento").value="";		
		document.getElementById("radio11").checked=true;        
		
	}
}

function dadospesquisavertomador(valor) {

	//Opcao Outros Habilita os Campos para Digitação
	if(valor==5){
		$("pesquisatomador").disabled = false;
		$("buttontomador").disabled = false;		
		document.formulario.listDadosTomador.disabled=false;
		$("radio1").disabled = false;		
		$("radio2").disabled = false;		
		$("radio3").disabled = false;		
		$("radio4").disabled = false;		
		$("radio5").disabled = false;		
		$("radiotom11").disabled = false;		
		$("radiotom12").disabled = false;		
		$("radiotom11").checked = true;		
		$("tomcnpj").disabled = false;
		$("tomie").disabled = false;		
		$("tomrg").disabled = true;
		$("tomcpf").disabled = true;
		$("tomnguerra").disabled = false;
		$("tomrazao").disabled = false;
		$("tomcep").disabled = false;
		$("tomendereco").disabled = false;
		$("tomnumero").disabled = false;
		$("tombairro").disabled = false;
		$("tomcomplemento").disabled = false;
		$("tomfone").disabled = false;
	}
	//Desabilita os Campos para Digitação
	else {
		$("pesquisatomador").value = "";
		$("pesquisatomador").disabled = true;
		$("buttontomador").disabled = true;
		document.formulario.listDadosTomador.disabled=true;		
		$("radio1").checked = true;
		$("radio1").disabled = true;
		$("radio2").disabled = true;
		$("radio3").disabled = true;
		$("radio4").disabled = true;
		$("radio5").disabled = true;
		$("radiotom11").disabled = true;		
		$("radiotom12").disabled = true;		
		$("radiotom11").checked = true;		
		$("tomcnpj").disabled = true;
		$("tomie").disabled = true;		
		$("tomrg").disabled = true;
		$("tomcpf").disabled = true;
		//$("tomcnpj").value = "";
		//$("tomie").value = "";
		//$("tomrg").value = "";
		//$("tomcpf").value = "";
		$("tomnguerra").disabled = true;
		$("tomrazao").disabled = true;
		//$("tomnguerra").value = "";
		//$("tomrazao").value = "";
		$("tomcep").disabled = true;
		$("tomendereco").disabled = true;
		$("tomnumero").disabled = true;
		//$("tomcep").value = "";
		//$("tomendereco").value = "";
		//$("tomnumero").value = "";
		$("tombairro").disabled = true;
		$("tomcomplemento").disabled = true;
		$("tomfone").disabled = true;
		//$("tombairro").value = "";
		//$("tomcomplemento").value = "";
		//$("tomfone").value = "";
		
		//$("tomuf").value = "";
		//$("tomcidade").value = "";
		
		document.forms[0].listDadosTomador.options.length = 1;
		idOpcao  = document.getElementById("opcaoDadosTomador");
		idOpcao.innerHTML = "____________________";			

		$('tomcidadeibge').innerHTML = '<option id="tomcidcodigoibge" value="0">________________________________</option>';	
		$("tomcidadeibge").disabled = true;
		
	}
		
}

function verificapessoatom(valor)
{
	if( document.getElementById("radiotom11").checked==true)
	{
		$("tomcnpj").disabled = false;
		$("tomie").disabled = false;
		$("tomrg").value = "";
		$("tomcpf").value = "";
		$("tomrg").disabled = true;
		$("tomcpf").disabled = true;
	}
	else
	{
		$("tomcnpj").disabled = true;
		$("tomie").disabled = true;
		$("tomcnpj").value = "";
		$("tomie").value = "";
		$("tomrg").disabled = false;
		$("tomcpf").disabled = false;
	}
}

function pesquisaceptom(valor)
{
	trimjs($("tomcep").value);

	if(tomcep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEPtom(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("tomcidade").value="";
      		$("tomuf").value="";
      		$("tomcodcidade").value="";
		}
	}
}

function processXMLCEPtom(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("tomendereco").value=descricao3;
			$("tombairro").value=descricao4.substring(0,30);
            $("tomcidade").value=descricao;
			$("tomuf").value=descricao2;
 	        $("tomcodcidade").value=codigo;
  	        tomcep1=$("tomcep").value;

  	        // busca cidade ibge
           	dadospesquisaibgereptom(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("tomcep").focus();
	}
}

function dadospesquisaibgereptom(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].tomcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("tomcidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgereptom(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('tomcidadeibge').innerHTML = '<option id="tomcidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgereptom(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].tomcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "tomcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].tomcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "tomcidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].tomcidadeibge.options.add(novo);

            document.forms[0].tomcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("tomcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(tomufibge != "")
	{
	$('tomcidadeibge').value = tomufibge;
	}
}


function dadospesquisatomador(valor)
{
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDadosTomador.options.length = 1;

		idOpcao  = document.getElementById("opcaoDadosTomador");

		ajax2.open("POST", "clientectepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLtomador(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radio1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radio2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radio3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radio4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisatomador2(valor)
{	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientectepesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXMLtomador2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function processXMLtomador(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDadosTomador.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcaoDadosTomador");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radio1").checked==true){
            	novo.text  = descricaob+' '+descricao;
			}
			else if ( document.getElementById("radio2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radio3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radio4").checked==true){
				novo.text  = descricaoe+' '+descricao;
			}
            else
            {
				novo.text  = descricaoh+' '+descricao;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDadosTomador.options.add(novo);

			if(i==0)
			{
                tomcep1=descricao2a;

				$("tomnguerra").value=descricao;				
				$("tomrazao").value=descricaoc;				
				$("tomcnpj").value=descricaoe;
				$("tomie").value=descricaof;
				$("tomrg").value=descricaog;
				$("tomcpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radiotom11").checked=true;
					$("tomcnpj").disabled=false;
					$("tomie").disabled=false;
					$("tomrg").disabled=true;
					$("tomcpf").disabled=true;
				}
                else
                {
                    document.getElementById("radiotom12").checked=true;
					$("tomcnpj").disabled=true;
					$("tomie").disabled=true;
					$("tomrg").disabled=false;
					$("tomcpf").disabled=false;
				}
				$("tomcep").value=descricao2a;
				$("tomendereco").value=descricao2b;
				$("tombairro").value=descricao2c;
				$("tomfone").value=descricao2d;
				$("tomcomplemento").value=descricao2e;
				
                $("tomcodcidade").value=descricaov;
				$("tomcidade").value=descricaox;
				$("tomuf").value=descricaoz;
				
				$("tomnumero").value=fnenumero;
				
										
				document.getElementById("radiotom11").disabled = false;		
				document.getElementById("radiotom12").disabled = false;
			
				if( document.getElementById("radiotom11").checked==true)
				{
					$("tomcnpj").disabled = false;
					$("tomie").disabled = false;
					$("tomrg").value = "";
					$("tomcpf").value = "";
					$("tomrg").disabled = true;
					$("tomcpf").disabled = true;
				}
				else
				{
					$("tomcnpj").disabled = true;
					$("tomie").disabled = true;
					$("tomcnpj").value = "";
					$("tomie").value = "";
					$("tomrg").disabled = false;
					$("tomcpf").disabled = false;
				}
				document.getElementById("radiotom11").disabled = false;
				document.getElementById("radiotom12").disabled = false;					
												 
				tomufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgereptom('"+descricaoz+"')", 1000);
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	tomcep1="";        		
		$("tomnguerra").value="";		
		$("tomrazao").value="";		
		$("tomcnpj").value="";
		$("tomie").value="";
		$("tomrg").value="";
		$("tomcpf").value="";		
		$("tomcep").value="";
		$("tomendereco").value="";
		$("tombairro").value="";
		$("tomfone").value="";
		$("tomcomplemento").value="";			
		document.getElementById("radiotom11").checked=true;        
		idOpcao  = document.getElementById("opcaoDadosTomador");
		idOpcao.innerHTML = "____________________";				
	}
}

function processXMLtomador2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            tomcep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;

			$("tomnguerra").value=descricao;			
			$("tomrazao").value=descricaoc;			
			$("tomcnpj").value=descricaoe;
			$("tomie").value=descricaof;
			$("tomrg").value=descricaog;
			$("tomcpf").value=descricaoh;			
			if (descricaou=='1')
			{
            	document.getElementById("radiotom11").checked=true;
				$("tomcnpj").disabled=false;
				$("tomie").disabled=false;
				$("tomrg").disabled=true;
				$("tomcpf").disabled=true;
			}
            else
            {
            	document.getElementById("radiotom12").checked=true;
				$("tomcnpj").disabled=true;
				$("tomie").disabled=true;
				$("tomrg").disabled=false;
				$("tomcpf").disabled=false;
			}
			$("tomcep").value=descricao2a;
			$("tomendereco").value=descricao2b;
			$("tombairro").value=descricao2c;
			$("tomfone").value=descricao2d;
			$("tomcomplemento").value=descricao2e;
			
	        $("tomcodcidade").value=descricaov;
			$("tomcidade").value=descricaox;
			$("tomuf").value=descricaoz;
	
									
			document.getElementById("radiotom11").disabled = false;		
			document.getElementById("radiotom12").disabled = false;
		
			if( document.getElementById("radiotom11").checked==true)
			{
				$("tomcnpj").disabled = false;
				$("tomie").disabled = false;
				$("tomrg").value = "";
				$("tomcpf").value = "";
				$("tomrg").disabled = true;
				$("tomcpf").disabled = true;
			}
			else
			{
				$("tomcnpj").disabled = true;
				$("tomie").disabled = true;
				$("tomcnpj").value = "";
				$("tomie").value = "";
				$("tomrg").disabled = false;
				$("tomcpf").disabled = false;
			}
			document.getElementById("radiotom11").disabled = false;
			document.getElementById("radiotom12").disabled = false;			
			
			tomufibge = descricaoib;				
			window.setTimeout("dadospesquisaibgereptom('"+descricaoz+"')", 1000);
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        tomcep1="";        		
		$("tomnguerra").value="";		
		$("tomrazao").value="";		
		$("tomcnpj").value="";
		$("tomie").value="";
		$("tomrg").value="";
		$("tomcpf").value="";		
		document.getElementById("radiotom11").checked=true;				
	}
}

function dadospesquisaverremetente(valor) {

	//Opcao Com Remetente Habilita os Campos para Digitação
	if(valor==1){
		$("pesquisaremetente").disabled = false;
		$("buttonremetente").disabled = false;		
		document.formulario.listDadosRemetente.disabled=false;
		$("radiorem1").disabled = false;		
		$("radiorem2").disabled = false;		
		$("radiorem3").disabled = false;		
		$("radiorem4").disabled = false;		
		$("radiorem5").disabled = false;		
		$("radiorem11").disabled = false;		
		$("radiorem12").disabled = false;		
		$("radiorem11").checked = true;		
		$("remcnpj").disabled = false;
		$("remie").disabled = false;		
		$("remrg").disabled = true;
		$("remcpf").disabled = true;
		$("remnguerra").disabled = false;
		$("remrazao").disabled = false;
		$("remcep").disabled = false;
		$("remendereco").disabled = false;
		$("remnumero").disabled = false;
		$("rembairro").disabled = false;
		$("remcomplemento").disabled = false;
		$("remfone").disabled = false;
	}
	//Desabilita os Campos para Digitação
	else {
		$("pesquisaremetente").value = "";
		$("pesquisaremetente").disabled = true;
		$("buttonremetente").disabled = true;
		document.formulario.listDadosRemetente.disabled=true;		
		$("radiorem1").checked = true;
		$("radiorem1").disabled = true;
		$("radiorem2").disabled = true;
		$("radiorem3").disabled = true;
		$("radiorem4").disabled = true;
		$("radiorem5").disabled = true;
		$("radiorem11").disabled = true;		
		$("radiorem12").disabled = true;		
		$("radiorem11").checked = true;		
		$("remcnpj").disabled = true;
		$("remie").disabled = true;		
		$("remrg").disabled = true;
		$("remcpf").disabled = true;
		$("remcnpj").value = "";
		$("remie").value = "";
		$("remrg").value = "";
		$("remcpf").value = "";
		$("remnguerra").disabled = true;
		$("remrazao").disabled = true;
		$("remnguerra").value = "";
		$("remrazao").value = "";
		$("remcep").disabled = true;
		$("remendereco").disabled = true;
		$("remnumero").disabled = true;
		$("remcep").value = "";
		$("remendereco").value = "";
		$("remnumero").value = "";
		$("rembairro").disabled = true;
		$("remcomplemento").disabled = true;
		$("remfone").disabled = true;
		$("rembairro").value = "";
		$("remcomplemento").value = "";
		$("remfone").value = "";
		
		$("remuf").value = "";
		$("remcidade").value = "";
		
		document.forms[0].listDadosRemetente.options.length = 1;
		idOpcao  = document.getElementById("opcaoDadosRemetente");
		idOpcao.innerHTML = "____________________";			

		$('remcidadeibge').innerHTML = '<option id="remcidcodigoibge" value="0">________________________________</option>';	
		$("remcidadeibge").disabled = true;
		
	}
		
}

function verificapessoarem(valor)
{
	if( document.getElementById("radiorem11").checked==true)
	{
		$("remcnpj").disabled = false;
		$("remie").disabled = false;
		$("remrg").value = "";
		$("remcpf").value = "";
		$("remrg").disabled = true;
		$("remcpf").disabled = true;
	}
	else
	{
		$("remcnpj").disabled = true;
		$("remie").disabled = true;
		$("remcnpj").value = "";
		$("remie").value = "";
		$("remrg").disabled = false;
		$("remcpf").disabled = false;
	}
}

function pesquisaceprem(valor)
{
	trimjs($("remcep").value);

	if(remcep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEPrem(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("remcidade").value="";
      		$("remuf").value="";
      		$("remcodcidade").value="";
		}
	}
}

function processXMLCEPrem(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("remendereco").value=descricao3;
			$("rembairro").value=descricao4.substring(0,30);
            $("remcidade").value=descricao;
			$("remuf").value=descricao2;
 	        $("remcodcidade").value=codigo;
  	        remcep1=$("remcep").value;

  	        // busca cidade ibge
           	dadospesquisaibgereprem(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("remcep").focus();
	}
}

function dadospesquisaibgereprem(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].remcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("remcidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgereprem(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('remcidadeibge').innerHTML = '<option id="remcidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgereprem(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].remcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "remcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].remcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "remcidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].remcidadeibge.options.add(novo);

            document.forms[0].remcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("remcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(remufibge != "")
	{
	$('remcidadeibge').value = remufibge;
	}
}

function dadospesquisaremetente(valor)
{
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDadosRemetente.options.length = 1;

		idOpcao  = document.getElementById("opcaoDadosRemetente");

		ajax2.open("POST", "clientectepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLremetente(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radiorem1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radiorem2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radiorem3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radiorem4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisaremetente2(valor)
{	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientectepesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXMLremetente2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function processXMLremetente(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDadosRemetente.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcaoDadosRemetente");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radiorem1").checked==true){
            	novo.text  = descricaob+' '+descricao;
			}
			else if ( document.getElementById("radiorem2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radiorem3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radiorem4").checked==true){
				novo.text  = descricaoe+' '+descricao;
			}
            else
            {
				novo.text  = descricaoh+' '+descricao;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDadosRemetente.options.add(novo);

			if(i==0)
			{
                remcep1=descricao2a;

				$("remnguerra").value=descricao;				
				$("remrazao").value=descricaoc;				
				$("remcnpj").value=descricaoe;
				$("remie").value=descricaof;
				$("remrg").value=descricaog;
				$("remcpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radiorem11").checked=true;
					$("remcnpj").disabled=false;
					$("remie").disabled=false;
					$("remrg").disabled=true;
					$("remcpf").disabled=true;
				}
                else
                {
                    document.getElementById("radiorem12").checked=true;
					$("remcnpj").disabled=true;
					$("remie").disabled=true;
					$("remrg").disabled=false;
					$("remcpf").disabled=false;
				}
				$("remcep").value=descricao2a;
				$("remendereco").value=descricao2b;
				$("rembairro").value=descricao2c;
				$("remfone").value=descricao2d;
				$("remcomplemento").value=descricao2e;
				
                $("remcodcidade").value=descricaov;
				$("remcidade").value=descricaox;
				$("remuf").value=descricaoz;				
				$("rempais").value="BRASIL";
				
				$("remnumero").value=fnenumero;
				
										
				document.getElementById("radiorem11").disabled = false;		
				document.getElementById("radiorem12").disabled = false;
			
				if( document.getElementById("radiorem11").checked==true)
				{
					$("remcnpj").disabled = false;
					$("remie").disabled = false;
					$("remrg").value = "";
					$("remcpf").value = "";
					$("remrg").disabled = true;
					$("remcpf").disabled = true;
				}
				else
				{
					$("remcnpj").disabled = true;
					$("remie").disabled = true;
					$("remcnpj").value = "";
					$("remie").value = "";
					$("remrg").disabled = false;
					$("remcpf").disabled = false;
				}
				document.getElementById("radiorem11").disabled = false;
				document.getElementById("radiorem12").disabled = false;					
												 
				remufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgereprem('"+descricaoz+"')", 1000);
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	remcep1="";        		
		$("remnguerra").value="";		
		$("remrazao").value="";		
		$("remcnpj").value="";
		$("remie").value="";
		$("remrg").value="";
		$("remcpf").value="";		
		$("remcep").value="";
		$("remendereco").value="";
		$("rembairro").value="";
		$("remfone").value="";
		$("remcomplemento").value="";				
		document.getElementById("radiorem11").checked=true;        
		idOpcao  = document.getElementById("opcaoDadosRemetente");
		idOpcao.innerHTML = "____________________";				
	}
}

function processXMLremetente2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            remcep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;

			$("remnguerra").value=descricao;			
			$("remrazao").value=descricaoc;			
			$("remcnpj").value=descricaoe;
			$("remie").value=descricaof;
			$("remrg").value=descricaog;
			$("remcpf").value=descricaoh;			
			if (descricaou=='1')
			{
            	document.getElementById("radiorem11").checked=true;
				$("remcnpj").disabled=false;
				$("remie").disabled=false;
				$("remrg").disabled=true;
				$("remcpf").disabled=true;
			}
            else
            {
            	document.getElementById("radiorem12").checked=true;
				$("remcnpj").disabled=true;
				$("remie").disabled=true;
				$("remrg").disabled=false;
				$("remcpf").disabled=false;
			}
			$("remcep").value=descricao2a;
			$("remendereco").value=descricao2b;
			$("rembairro").value=descricao2c;
			$("remfone").value=descricao2d;
			$("remcomplemento").value=descricao2e;
			
	        $("remcodcidade").value=descricaov;
			$("remcidade").value=descricaox;
			$("remuf").value=descricaoz;	
			$("rempais").value="BRASIL";
									
			document.getElementById("radiorem11").disabled = false;		
			document.getElementById("radiorem12").disabled = false;
		
			if( document.getElementById("radiorem11").checked==true)
			{
				$("remcnpj").disabled = false;
				$("remie").disabled = false;
				$("remrg").value = "";
				$("remcpf").value = "";
				$("remrg").disabled = true;
				$("remcpf").disabled = true;
			}
			else
			{
				$("remcnpj").disabled = true;
				$("remie").disabled = true;
				$("remcnpj").value = "";
				$("remie").value = "";
				$("remrg").disabled = false;
				$("remcpf").disabled = false;
			}
			document.getElementById("radiorem11").disabled = false;
			document.getElementById("radiorem12").disabled = false;			
			
			remufibge = descricaoib;				
			window.setTimeout("dadospesquisaibgereprem('"+descricaoz+"')", 1000);
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        remcep1="";        		
		$("remnguerra").value="";		
		$("remrazao").value="";		
		$("remcnpj").value="";
		$("remie").value="";
		$("remrg").value="";
		$("remcpf").value="";		
		document.getElementById("radiorem11").checked=true;				
	}
}


function dadospesquisatipoexpedidor(valor) {


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
		 document.forms[0].expedidor.options.length = 1;

		 idOpcao  = document.getElementById("expedidor");

       		
 	         ajax2.open("POST", "ctepesquisaexpedidor.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtipoexpedidor(ajax2.responseXML);
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



   function processXMLtipoexpedidor(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].expedidor.options.length = 0;

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
			    novo.setAttribute("id", "expedidor");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].expedidor.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatiporecebedor(0);
  
   }   
   
function dadospesquisaverexpedidor(valor) {

	//Opcao Com Expedidor Habilita os Campos para Digitação
	if(valor==1){
		$("pesquisaexpedidor").disabled = false;
		$("buttonexpedidor").disabled = false;		
		document.formulario.listDadosExpedidor.disabled=false;
		$("radioexp1").disabled = false;		
		$("radioexp2").disabled = false;		
		$("radioexp3").disabled = false;		
		$("radioexp4").disabled = false;		
		$("radioexp5").disabled = false;		
		$("radioexp11").disabled = false;		
		$("radioexp12").disabled = false;		
		$("radioexp11").checked = true;		
		$("expcnpj").disabled = false;
		$("expie").disabled = false;		
		$("exprg").disabled = true;
		$("expcpf").disabled = true;
		$("expnguerra").disabled = false;
		$("exprazao").disabled = false;
		$("expcep").disabled = false;
		$("expendereco").disabled = false;
		$("expnumero").disabled = false;
		$("expbairro").disabled = false;
		$("expcomplemento").disabled = false;
		$("expfone").disabled = false;
	}
	//Desabilita os Campos para Digitação
	else {
		$("pesquisaexpedidor").value = "";
		$("pesquisaexpedidor").disabled = true;
		$("buttonexpedidor").disabled = true;
		document.formulario.listDadosExpedidor.disabled=true;		
		$("radioexp1").checked = true;
		$("radioexp1").disabled = true;
		$("radioexp2").disabled = true;
		$("radioexp3").disabled = true;
		$("radioexp4").disabled = true;
		$("radioexp5").disabled = true;
		$("radioexp11").disabled = true;		
		$("radioexp12").disabled = true;		
		$("radioexp11").checked = true;		
		$("expcnpj").disabled = true;
		$("expie").disabled = true;		
		$("exprg").disabled = true;
		$("expcpf").disabled = true;
		$("expcnpj").value = "";
		$("expie").value = "";
		$("exprg").value = "";
		$("expcpf").value = "";
		$("expnguerra").disabled = true;
		$("exprazao").disabled = true;
		$("expnguerra").value = "";
		$("exprazao").value = "";
		$("expcep").disabled = true;
		$("expendereco").disabled = true;
		$("expnumero").disabled = true;
		$("expcep").value = "";
		$("expendereco").value = "";
		$("expnumero").value = "";
		$("expbairro").disabled = true;
		$("expcomplemento").disabled = true;
		$("expfone").disabled = true;
		$("expbairro").value = "";
		$("expcomplemento").value = "";
		$("expfone").value = "";
		
		$("expuf").value = "";
		$("expcidade").value = "";
		
		document.forms[0].listDadosExpedidor.options.length = 1;
		idOpcao  = document.getElementById("opcaoDadosExpedidor");
		idOpcao.innerHTML = "____________________";			

		$('expcidadeibge').innerHTML = '<option id="expcidcodigoibge" value="0">________________________________</option>';	
		$("expcidadeibge").disabled = true;
		
	}
		
}

function verificapessoaexp(valor)
{
	if( document.getElementById("radioexp11").checked==true)
	{
		$("expcnpj").disabled = false;
		$("expie").disabled = false;
		$("exprg").value = "";
		$("expcpf").value = "";
		$("exprg").disabled = true;
		$("expcpf").disabled = true;
	}
	else
	{
		$("expcnpj").disabled = true;
		$("expie").disabled = true;
		$("expcnpj").value = "";
		$("expie").value = "";
		$("exprg").disabled = false;
		$("expcpf").disabled = false;
	}
}

function pesquisacepexp(valor)
{
	trimjs($("expcep").value);

	if(expcep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEPexp(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("expcidade").value="";
      		$("expuf").value="";
      		$("expcodcidade").value="";
		}
	}
}

function processXMLCEPexp(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("expendereco").value=descricao3;
			$("expbairro").value=descricao4.substring(0,30);
            $("expcidade").value=descricao;
			$("expuf").value=descricao2;
 	        $("expcodcidade").value=codigo;
  	        expcep1=$("expcep").value;

  	        // busca cidade ibge
           	dadospesquisaibgerepexp(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("expcep").focus();
	}
}

function dadospesquisaibgerepexp(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].expcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("expcidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgerepexp(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('expcidadeibge').innerHTML = '<option id="expcidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerepexp(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].expcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "expcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].expcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "expcidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].expcidadeibge.options.add(novo);

            document.forms[0].expcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("expcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(expufibge != "")
	{
	$('expcidadeibge').value = expufibge;
	}
}

function dadospesquisaexpedidor(valor)
{
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDadosExpedidor.options.length = 1;

		idOpcao  = document.getElementById("opcaoDadosExpedidor");

		ajax2.open("POST", "clientectepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLexpedidor(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radioexp1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radioexp2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radioexp3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radioexp4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisaexpedidor2(valor)
{	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientectepesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXMLexpedidor2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function processXMLexpedidor(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDadosExpedidor.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcaoDadosExpedidor");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radioexp1").checked==true){
            	novo.text  = descricaob+' '+descricao;
			}
			else if ( document.getElementById("radioexp2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radioexp3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radioexp4").checked==true){
				novo.text  = descricaoe+' '+descricao;
			}
            else
            {
				novo.text  = descricaoh+' '+descricao;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDadosExpedidor.options.add(novo);

			if(i==0)
			{
                expcep1=descricao2a;

				$("expnguerra").value=descricao;				
				$("exprazao").value=descricaoc;				
				$("expcnpj").value=descricaoe;
				$("expie").value=descricaof;
				$("exprg").value=descricaog;
				$("expcpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radioexp11").checked=true;
					$("expcnpj").disabled=false;
					$("expie").disabled=false;
					$("exprg").disabled=true;
					$("expcpf").disabled=true;
				}
                else
                {
                    document.getElementById("radioexp12").checked=true;
					$("expcnpj").disabled=true;
					$("expie").disabled=true;
					$("exprg").disabled=false;
					$("expcpf").disabled=false;
				}
				$("expcep").value=descricao2a;
				$("expendereco").value=descricao2b;
				$("expbairro").value=descricao2c;
				$("expfone").value=descricao2d;
				$("expcomplemento").value=descricao2e;
				
                $("expcodcidade").value=descricaov;
				$("expcidade").value=descricaox;
				$("expuf").value=descricaoz;
				
				$("expnumero").value=fnenumero;
				
										
				document.getElementById("radioexp11").disabled = false;		
				document.getElementById("radioexp12").disabled = false;
			
				if( document.getElementById("radioexp11").checked==true)
				{
					$("expcnpj").disabled = false;
					$("expie").disabled = false;
					$("exprg").value = "";
					$("expcpf").value = "";
					$("exprg").disabled = true;
					$("expcpf").disabled = true;
				}
				else
				{
					$("expcnpj").disabled = true;
					$("expie").disabled = true;
					$("expcnpj").value = "";
					$("expie").value = "";
					$("exprg").disabled = false;
					$("expcpf").disabled = false;
				}
				document.getElementById("radioexp11").disabled = false;
				document.getElementById("radioexp12").disabled = false;					
												 
				expufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgerepexp('"+descricaoz+"')", 1000);
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	expcep1="";        		
		$("expnguerra").value="";		
		$("exprazao").value="";		
		$("expcnpj").value="";
		$("expie").value="";
		$("exprg").value="";
		$("expcpf").value="";		
		$("expcep").value="";
		$("expendereco").value="";
		$("expbairro").value="";
		$("expfone").value="";
		$("expcomplemento").value="";				
		document.getElementById("radioexp11").checked=true;        
		idOpcao  = document.getElementById("opcaoDadosExpedidor");
		idOpcao.innerHTML = "____________________";				
	}
}

function processXMLexpedidor2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            expcep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;

			$("expnguerra").value=descricao;			
			$("exprazao").value=descricaoc;			
			$("expcnpj").value=descricaoe;
			$("expie").value=descricaof;
			$("exprg").value=descricaog;
			$("expcpf").value=descricaoh;			
			if (descricaou=='1')
			{
            	document.getElementById("radioexp11").checked=true;
				$("expcnpj").disabled=false;
				$("expie").disabled=false;
				$("exprg").disabled=true;
				$("expcpf").disabled=true;
			}
            else
            {
            	document.getElementById("radioexp12").checked=true;
				$("expcnpj").disabled=true;
				$("expie").disabled=true;
				$("exprg").disabled=false;
				$("expcpf").disabled=false;
			}
			$("expcep").value=descricao2a;
			$("expendereco").value=descricao2b;
			$("expbairro").value=descricao2c;
			$("expfone").value=descricao2d;
			$("expcomplemento").value=descricao2e;
			
	        $("expcodcidade").value=descricaov;
			$("expcidade").value=descricaox;
			$("expuf").value=descricaoz;
	
									
			document.getElementById("radioexp11").disabled = false;		
			document.getElementById("radioexp12").disabled = false;
		
			if( document.getElementById("radioexp11").checked==true)
			{
				$("expcnpj").disabled = false;
				$("expie").disabled = false;
				$("exprg").value = "";
				$("expcpf").value = "";
				$("exprg").disabled = true;
				$("expcpf").disabled = true;
			}
			else
			{
				$("expcnpj").disabled = true;
				$("expie").disabled = true;
				$("expcnpj").value = "";
				$("expie").value = "";
				$("exprg").disabled = false;
				$("expcpf").disabled = false;
			}
			document.getElementById("radioexp11").disabled = false;
			document.getElementById("radioexp12").disabled = false;			
			
			expufibge = descricaoib;				
			window.setTimeout("dadospesquisaibgerepexp('"+descricaoz+"')", 1000);
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        expcep1="";        		
		$("expnguerra").value="";		
		$("exprazao").value="";		
		$("expcnpj").value="";
		$("expie").value="";
		$("exprg").value="";
		$("expcpf").value="";		
		document.getElementById("radioexp11").checked=true;				
	}
}


function dadospesquisatiporecebedor(valor) {


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
		 document.forms[0].recebedor.options.length = 1;

		 idOpcao  = document.getElementById("recebedor");

       		
 	         ajax2.open("POST", "ctepesquisarecebedor.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtiporecebedor(ajax2.responseXML);
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



   function processXMLtiporecebedor(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].recebedor.options.length = 0;

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
			    novo.setAttribute("id", "recebedor");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].recebedor.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatipodestinatario(0);
  
   }   
   
function dadospesquisaverrecebedor(valor) {

	//Opcao Com Recebedor Habilita os Campos para Digitação
	if(valor==1){
		$("pesquisarecebedor").disabled = false;
		$("buttonrecebedor").disabled = false;		
		document.formulario.listDadosRecebedor.disabled=false;
		$("radiorec1").disabled = false;		
		$("radiorec2").disabled = false;		
		$("radiorec3").disabled = false;		
		$("radiorec4").disabled = false;		
		$("radiorec5").disabled = false;		
		$("radiorec11").disabled = false;		
		$("radiorec12").disabled = false;		
		$("radiorec11").checked = true;		
		$("reccnpj").disabled = false;
		$("recie").disabled = false;		
		$("recrg").disabled = true;
		$("reccpf").disabled = true;
		$("recnguerra").disabled = false;
		$("recrazao").disabled = false;
		$("reccep").disabled = false;
		$("recendereco").disabled = false;
		$("recnumero").disabled = false;
		$("recbairro").disabled = false;
		$("reccomplemento").disabled = false;
		$("recfone").disabled = false;
	}
	//Desabilita os Campos para Digitação
	else {
		$("pesquisarecebedor").value = "";
		$("pesquisarecebedor").disabled = true;
		$("buttonrecebedor").disabled = true;
		document.formulario.listDadosRecebedor.disabled=true;		
		$("radiorec1").checked = true;
		$("radiorec1").disabled = true;
		$("radiorec2").disabled = true;
		$("radiorec3").disabled = true;
		$("radiorec4").disabled = true;
		$("radiorec5").disabled = true;
		$("radiorec11").disabled = true;		
		$("radiorec12").disabled = true;		
		$("radiorec11").checked = true;		
		$("reccnpj").disabled = true;
		$("recie").disabled = true;		
		$("recrg").disabled = true;
		$("reccpf").disabled = true;
		$("reccnpj").value = "";
		$("recie").value = "";
		$("recrg").value = "";
		$("reccpf").value = "";
		$("recnguerra").disabled = true;
		$("recrazao").disabled = true;
		$("recnguerra").value = "";
		$("recrazao").value = "";
		$("reccep").disabled = true;
		$("recendereco").disabled = true;
		$("recnumero").disabled = true;
		$("reccep").value = "";
		$("recendereco").value = "";
		$("recnumero").value = "";
		$("recbairro").disabled = true;
		$("reccomplemento").disabled = true;
		$("recfone").disabled = true;
		$("recbairro").value = "";
		$("reccomplemento").value = "";
		$("recfone").value = "";
		
		$("recuf").value = "";
		$("reccidade").value = "";
		
		document.forms[0].listDadosRecebedor.options.length = 1;
		idOpcao  = document.getElementById("opcaoDadosRecebedor");
		idOpcao.innerHTML = "____________________";			

		$('reccidadeibge').innerHTML = '<option id="reccidcodigoibge" value="0">________________________________</option>';	
		$("reccidadeibge").disabled = true;
		
	}
		
}

function verificapessoarec(valor)
{
	if( document.getElementById("radiorec11").checked==true)
	{
		$("reccnpj").disabled = false;
		$("recie").disabled = false;
		$("recrg").value = "";
		$("reccpf").value = "";
		$("recrg").disabled = true;
		$("reccpf").disabled = true;
	}
	else
	{
		$("reccnpj").disabled = true;
		$("recie").disabled = true;
		$("reccnpj").value = "";
		$("recie").value = "";
		$("recrg").disabled = false;
		$("reccpf").disabled = false;
	}
}

function pesquisaceprec(valor)
{
	trimjs($("reccep").value);

	if(reccep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEPrec(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("reccidade").value="";
      		$("recuf").value="";
      		$("reccodcidade").value="";
		}
	}
}

function processXMLCEPrec(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("recendereco").value=descricao3;
			$("recbairro").value=descricao4.substring(0,30);
            $("reccidade").value=descricao;
			$("recuf").value=descricao2;
 	        $("reccodcidade").value=codigo;
  	        reccep1=$("reccep").value;

  	        // busca cidade ibge
           	dadospesquisaibgereprec(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("reccep").focus();
	}
}

function dadospesquisaibgereprec(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].reccidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("reccidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgereprec(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('reccidadeibge').innerHTML = '<option id="reccidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgereprec(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].reccidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "reccidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].reccidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "reccidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].reccidadeibge.options.add(novo);

            document.forms[0].reccidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("reccidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(recufibge != "")
	{
	$('reccidadeibge').value = recufibge;
	}
}

function dadospesquisarecebedor(valor)
{
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDadosRecebedor.options.length = 1;

		idOpcao  = document.getElementById("opcaoDadosRecebedor");

		ajax2.open("POST", "clientectepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLrecebedor(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radiorec1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radiorec2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radiorec3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radiorec4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisarecebedor2(valor)
{	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientectepesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXMLrecebedor2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function processXMLrecebedor(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDadosRecebedor.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcaoDadosRecebedor");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radiorec1").checked==true){
            	novo.text  = descricaob+' '+descricao;
			}
			else if ( document.getElementById("radiorec2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radiorec3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radiorec4").checked==true){
				novo.text  = descricaoe+' '+descricao;
			}
            else
            {
				novo.text  = descricaoh+' '+descricao;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDadosRecebedor.options.add(novo);

			if(i==0)
			{
                reccep1=descricao2a;

				$("recnguerra").value=descricao;				
				$("recrazao").value=descricaoc;				
				$("reccnpj").value=descricaoe;
				$("recie").value=descricaof;
				$("recrg").value=descricaog;
				$("reccpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radiorec11").checked=true;
					$("reccnpj").disabled=false;
					$("recie").disabled=false;
					$("recrg").disabled=true;
					$("reccpf").disabled=true;
				}
                else
                {
                    document.getElementById("radiorec12").checked=true;
					$("reccnpj").disabled=true;
					$("recie").disabled=true;
					$("recrg").disabled=false;
					$("reccpf").disabled=false;
				}
				$("reccep").value=descricao2a;
				$("recendereco").value=descricao2b;
				$("recbairro").value=descricao2c;
				$("recfone").value=descricao2d;
				$("reccomplemento").value=descricao2e;
				
                $("reccodcidade").value=descricaov;
				$("reccidade").value=descricaox;
				$("recuf").value=descricaoz;
				$("recpais").value="BRASIL";
				$("recnumero").value=fnenumero;
				
										
				document.getElementById("radiorec11").disabled = false;		
				document.getElementById("radiorec12").disabled = false;
			
				if( document.getElementById("radiorec11").checked==true)
				{
					$("reccnpj").disabled = false;
					$("recie").disabled = false;
					$("recrg").value = "";
					$("reccpf").value = "";
					$("recrg").disabled = true;
					$("reccpf").disabled = true;
				}
				else
				{
					$("reccnpj").disabled = true;
					$("recie").disabled = true;
					$("reccnpj").value = "";
					$("recie").value = "";
					$("recrg").disabled = false;
					$("reccpf").disabled = false;
				}
				document.getElementById("radiorec11").disabled = false;
				document.getElementById("radiorec12").disabled = false;					
												 
				recufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgereprec('"+descricaoz+"')", 1000);
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	reccep1="";        		
		$("recnguerra").value="";		
		$("recrazao").value="";		
		$("reccnpj").value="";
		$("recie").value="";
		$("recrg").value="";
		$("reccpf").value="";		
		$("reccep").value="";
		$("recendereco").value="";
		$("recbairro").value="";
		$("recfone").value="";
		$("reccomplemento").value="";				
		document.getElementById("radiorec11").checked=true;        
		idOpcao  = document.getElementById("opcaoDadosRecebedor");
		idOpcao.innerHTML = "____________________";				
	}
}

function processXMLrecebedor2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            reccep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;

			$("recnguerra").value=descricao;			
			$("recrazao").value=descricaoc;			
			$("reccnpj").value=descricaoe;
			$("recie").value=descricaof;
			$("recrg").value=descricaog;
			$("reccpf").value=descricaoh;			
			if (descricaou=='1')
			{
            	document.getElementById("radiorec11").checked=true;
				$("reccnpj").disabled=false;
				$("recie").disabled=false;
				$("recrg").disabled=true;
				$("reccpf").disabled=true;
			}
            else
            {
            	document.getElementById("radiorec12").checked=true;
				$("reccnpj").disabled=true;
				$("recie").disabled=true;
				$("recrg").disabled=false;
				$("reccpf").disabled=false;
			}
			$("reccep").value=descricao2a;
			$("recendereco").value=descricao2b;
			$("recbairro").value=descricao2c;
			$("recfone").value=descricao2d;
			$("reccomplemento").value=descricao2e;
			
	        $("reccodcidade").value=descricaov;
			$("reccidade").value=descricaox;
			$("recuf").value=descricaoz;
			$("recpais").value="BRASIL";
									
			document.getElementById("radiorec11").disabled = false;		
			document.getElementById("radiorec12").disabled = false;
		
			if( document.getElementById("radiorec11").checked==true)
			{
				$("reccnpj").disabled = false;
				$("recie").disabled = false;
				$("recrg").value = "";
				$("reccpf").value = "";
				$("recrg").disabled = true;
				$("reccpf").disabled = true;
			}
			else
			{
				$("reccnpj").disabled = true;
				$("recie").disabled = true;
				$("reccnpj").value = "";
				$("recie").value = "";
				$("recrg").disabled = false;
				$("reccpf").disabled = false;
			}
			document.getElementById("radiorec11").disabled = false;
			document.getElementById("radiorec12").disabled = false;			
			
			recufibge = descricaoib;				
			window.setTimeout("dadospesquisaibgereprec('"+descricaoz+"')", 1000);
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        reccep1="";        		
		$("recnguerra").value="";		
		$("recrazao").value="";		
		$("reccnpj").value="";
		$("recie").value="";
		$("recrg").value="";
		$("reccpf").value="";		
		document.getElementById("radiorec11").checked=true;				
	}
}

function dadospesquisatipodestinatario(valor) {


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
		 document.forms[0].destinatario.options.length = 1;

		 idOpcao  = document.getElementById("destinatario");

       		
 	         ajax2.open("POST", "ctepesquisadestinatario.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtipodestinatario(ajax2.responseXML);
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



   function processXMLtipodestinatario(obj){
		   
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].destinatario.options.length = 0;

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
			    novo.setAttribute("id", "destinatario");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].destinatario.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  //dadospesquisatiposituacao(0);
  
   }   
   
function dadospesquisaverdestinatario(valor) {

	//Opcao Com Destinatario Habilita os Campos para Digitação
	if(valor==1){
		$("pesquisadestinatario").disabled = false;
		$("buttondestinatario").disabled = false;		
		document.formulario.listDadosDestinatario.disabled=false;
		$("radiodes1").disabled = false;		
		$("radiodes2").disabled = false;		
		$("radiodes3").disabled = false;		
		$("radiodes4").disabled = false;		
		$("radiodes5").disabled = false;		
		$("radiodes11").disabled = false;		
		$("radiodes12").disabled = false;		
		//$("radiodes11").checked = true;		
		$("descnpj").disabled = false;
		$("desie").disabled = false;		
		$("desrg").disabled = true;
		$("descpf").disabled = true;
		$("desnguerra").disabled = false;
		$("desrazao").disabled = false;
		$("descep").disabled = false;
		$("desendereco").disabled = false;
		$("desnumero").disabled = false;
		$("dessuframa").disabled = false;
		$("desbairro").disabled = false;
		$("descomplemento").disabled = false;
		$("desfone").disabled = false;
	}
	//Desabilita os Campos para Digitação
	else {
		$("pesquisadestinatario").value = "";
		$("pesquisadestinatario").disabled = true;
		$("buttondestinatario").disabled = true;
		document.formulario.listDadosDestinatario.disabled=true;		
		$("radiodes1").checked = true;
		$("radiodes1").disabled = true;
		$("radiodes2").disabled = true;
		$("radiodes3").disabled = true;
		$("radiodes4").disabled = true;
		$("radiodes5").disabled = true;
		$("radiodes11").disabled = true;		
		$("radiodes12").disabled = true;		
		$("radiodes11").checked = true;		
		$("descnpj").disabled = true;
		$("desie").disabled = true;		
		$("desrg").disabled = true;
		$("descpf").disabled = true;
		$("descnpj").value = "";
		$("desie").value = "";
		$("desrg").value = "";
		$("descpf").value = "";
		$("desnguerra").disabled = true;
		$("desrazao").disabled = true;
		$("desnguerra").value = "";
		$("desrazao").value = "";
		$("descep").disabled = true;
		$("desendereco").disabled = true;		
		$("desnumero").disabled = true;
		$("dessuframa").disabled = true;
		$("descep").value = "";
		$("desendereco").value = "";		
		$("desnumero").value = "";
		$("dessuframa").value = "";
		$("desbairro").disabled = true;
		$("descomplemento").disabled = true;
		$("desfone").disabled = true;
		$("desbairro").value = "";
		$("descomplemento").value = "";
		$("desfone").value = "";
		
		$("desuf").value = "";
		$("descidade").value = "";
		
		document.forms[0].listDadosDestinatario.options.length = 1;
		idOpcao  = document.getElementById("opcaoDadosDestinatario");
		idOpcao.innerHTML = "____________________";			

		$('descidadeibge').innerHTML = '<option id="descidcodigoibge" value="0">________________________________</option>';	
		$("descidadeibge").disabled = true;
		
	}
		
}

function verificapessoades(valor)
{
	if( document.getElementById("radiodes11").checked==true)
	{
		$("descnpj").disabled = false;
		$("desie").disabled = false;
		$("desrg").value = "";
		$("descpf").value = "";
		$("desrg").disabled = true;
		$("descpf").disabled = true;
	}
	else
	{
		$("descnpj").disabled = true;
		$("desie").disabled = true;
		$("descnpj").value = "";
		$("desie").value = "";
		$("desrg").disabled = false;
		$("descpf").disabled = false;
	}
}

function pesquisacepdes(valor)
{
	trimjs($("descep").value);

	if(descep1!=txt)
	{
    	if(txt!="")
    	{
			// verifica se o browser tem suporte a ajax
	  		try
	  		{
         		ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
      		}
      		catch(e)
      		{
         		try
         		{
            		ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
         		}
	     		catch(ex)
	     		{
            		try
            		{
               			ajax2 = new XMLHttpRequest();
            		}
	        		catch(exc)
	        		{
               			alert("Esse browser não tem recursos para uso do Ajax");
						ajax2 = null;
            		}
         		}
      		}
	  		// se tiver suporte ajax
	  		if(ajax2)
	  		{
				ajax2.open("POST", "ceppesquisa.php", true);
				ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

				ajax2.onreadystatechange = function()
				{
					// enquanto estiver processando...emite a msg de carregando
					if(ajax2.readyState == 1) {
					}
					// após ser processado - chama função processXML que vai
					// varrer os dados
            		if(ajax2.readyState == 4 )
            		{
			   			if(ajax2.responseXML)
			   			{
			      			processXMLCEPdes(ajax2.responseXML);
			   			}
			   			else
			   			{
			       			// caso não seja um arquivo XML emite a mensagem
							// abaixo
						}
            		}
         		}
				// passa o parametro
         		var params = "parametro="+valor;
         		ajax2.send(params);
      		}
		}
		else
      	{
			$("descidade").value="";
      		$("desuf").value="";
      		$("descodcidade").value="";
		}
	}
}

function processXMLCEPdes(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricao2 =  item.getElementsByTagName("descricao2")[0].firstChild.nodeValue;
			var descricao3 =  item.getElementsByTagName("descricao3")[0].firstChild.nodeValue;
			var descricao4 =  item.getElementsByTagName("descricao4")[0].firstChild.nodeValue;

			trimjs(codigo);if (txt=='_'){txt='';};codigo = txt;
			trimjs(descricao);if (txt=='_'){txt='';};descricao = txt;
			trimjs(descricao2);if (txt=='_'){txt='';};descricao2 = txt;
			trimjs(descricao3);if (txt=='_'){txt='';};descricao3 = txt;
			trimjs(descricao4);if (txt=='_'){txt='';};descricao4 = txt;

			$("desendereco").value=descricao3;
			$("desbairro").value=descricao4.substring(0,30);
            $("descidade").value=descricao;
			$("desuf").value=descricao2;
 	        $("descodcidade").value=codigo;
  	        descep1=$("descep").value;

  	        // busca cidade ibge
           	dadospesquisaibgerepdes(descricao2);
		}
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        alert("O CEP não é válido!");
        document.getElementById("descep").focus();
	}
}

function dadospesquisaibgerepdes(valor)
{
	
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].descidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("descidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
			   if(ajax2.responseXML)
			   {
			      processXMLibgerepdes(ajax2.responseXML);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('descidadeibge').innerHTML = '<option id="descidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerepdes(obj)
{
	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].descidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "descidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].descidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "descidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].descidadeibge.options.add(novo);

            document.forms[0].descidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("descidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	if(desufibge != "")
	{
	$('descidadeibge').value = desufibge;
	}
}

function dadospesquisadestinatario(valor)
{
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].listDadosDestinatario.options.length = 1;

		idOpcao  = document.getElementById("opcaoDadosDestinatario");

		ajax2.open("POST", "clientectepesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
			    	processXMLdestinatario(ajax2.responseXML);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				   	idOpcao.innerHTML = "____________________";
				   	alert("Nenhum Registro encontrado!");					
			   	}
			}
		}
		// passa o parametro
   		if ( document.getElementById("radiodes1").checked==true){
                 valor2 = "1";
        }
		else if ( document.getElementById("radiodes2").checked==true){
                 valor2 = "2";
        }
		else if ( document.getElementById("radiodes3").checked==true){
                 valor2 = "3";
        }
		else if ( document.getElementById("radiodes4").checked==true){
                 valor2 = "4";
        }
        else{
                 valor2 = "5";
        }
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}

function dadospesquisadestinatario2(valor)
{	
	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try{
				ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		ajax2.open("POST", "clientectepesquisa2.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
        	// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
		    }
			// após ser processado - chama função processXML que vai varrer os
			// dados
        	if(ajax2.readyState == 4 )
        	{
				if(ajax2.responseXML) {
					processXMLdestinatario2(ajax2.responseXML);
				}
				else {
					// caso não seja um arquivo XML emite a mensagem abaixo
		   		}
			}
		}
		// passa o parametro escolhido
		var params = "parametro="+valor;
    	ajax2.send(params);
   	}
}

function processXMLdestinatario(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados

		document.forms[0].listDadosDestinatario.options.length = 0;

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			
            var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;
			var cidadeibge =  item.getElementsByTagName("cidadeibge")[0].firstChild.nodeValue;						
            var fnenumero =  item.getElementsByTagName("fnenumero")[0].firstChild.nodeValue;
			

			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;			
			trimjs(cidadeibge);if (txt=='0'){txt='';};cidadeibge = txt;			
			trimjs(fnenumero);if (txt=='0'){txt='';};fnenumero = txt;
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");
			// atribui um ID a esse elemento
			novo.setAttribute("id", "opcaoDadosDestinatario");
			// atribui um valor
			novo.value = codigo;
			// atribui um texto
			if ( document.getElementById("radiodes1").checked==true){
            	novo.text  = descricaob+' '+descricao;
			}
			else if ( document.getElementById("radiodes2").checked==true){
            	novo.text  = descricao;
			}
			else if ( document.getElementById("radiodes3").checked==true){
				novo.text  = descricaoc;
			}
    		else if ( document.getElementById("radiodes4").checked==true){
				novo.text  = descricaoe+' '+descricao;
			}
            else
            {
				novo.text  = descricaoh+' '+descricao;
			}
			// finalmente adiciona o novo elemento
			document.forms[0].listDadosDestinatario.options.add(novo);

			if(i==0)
			{
                descep1=descricao2a;

				$("desnguerra").value=descricao;				
				$("desrazao").value=descricaoc;				
				$("descnpj").value=descricaoe;
				$("desie").value=descricaof;
				$("desrg").value=descricaog;
				$("descpf").value=descricaoh;				
			    if (descricaou=='1')
			    {
                    document.getElementById("radiodes11").checked=true;
					$("descnpj").disabled=false;
					$("desie").disabled=false;
					$("desrg").disabled=true;
					$("descpf").disabled=true;
				}
                else
                {
                    document.getElementById("radiodes12").checked=true;
					$("descnpj").disabled=true;
					$("desie").disabled=true;
					$("desrg").disabled=false;
					$("descpf").disabled=false;
				}
				$("descep").value=descricao2a;
				$("desendereco").value=descricao2b;
				$("desbairro").value=descricao2c;
				$("desfone").value=descricao2d;
				$("descomplemento").value=descricao2e;
				
                $("descodcidade").value=descricaov;
				$("descidade").value=descricaox;
				$("desuf").value=descricaoz;
				
				$("desnumero").value=fnenumero;
				$("dessuframa").value=descricaod;
				
										
				document.getElementById("radiodes11").disabled = false;		
				document.getElementById("radiodes12").disabled = false;
			
				if( document.getElementById("radiodes11").checked==true)
				{
					$("descnpj").disabled = false;
					$("desie").disabled = false;
					$("desrg").value = "";
					$("descpf").value = "";
					$("desrg").disabled = true;
					$("descpf").disabled = true;
				}
				else
				{
					$("descnpj").disabled = true;
					$("desie").disabled = true;
					$("descnpj").value = "";
					$("desie").value = "";
					$("desrg").disabled = false;
					$("descpf").disabled = false;
				}
				document.getElementById("radiodes11").disabled = false;
				document.getElementById("radiodes12").disabled = false;					
												 
				desufibge = descricaoib;				
				window.setTimeout("dadospesquisaibgerepdes('"+descricaoz+"')", 1000);
				
			}
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
       	descep1="";        		
		$("desnguerra").value="";		
		$("desrazao").value="";		
		$("descnpj").value="";
		$("desie").value="";
		$("desrg").value="";
		$("descpf").value="";		
		$("descep").value="";
		$("desendereco").value="";
		$("desbairro").value="";
		$("desfone").value="";
		$("descomplemento").value="";				
		document.getElementById("radiodes11").checked=true;        
		idOpcao  = document.getElementById("opcaoDadosDestinatario");
		idOpcao.innerHTML = "____________________";				
	}
}

function processXMLdestinatario2(obj)
{
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			var descricaob =  item.getElementsByTagName("descricaob")[0].firstChild.nodeValue;
			var descricaoc =  item.getElementsByTagName("descricaoc")[0].firstChild.nodeValue;
			var descricaod =  item.getElementsByTagName("descricaod")[0].firstChild.nodeValue;
			var descricaoe =  item.getElementsByTagName("descricaoe")[0].firstChild.nodeValue;
			var descricaof =  item.getElementsByTagName("descricaof")[0].firstChild.nodeValue;
			var descricaog =  item.getElementsByTagName("descricaog")[0].firstChild.nodeValue;
			var descricaoh =  item.getElementsByTagName("descricaoh")[0].firstChild.nodeValue;
			var descricaoi =  item.getElementsByTagName("descricaoi")[0].firstChild.nodeValue;			
			var descricaoib =  item.getElementsByTagName("descricaoib")[0].firstChild.nodeValue;			
			var descricaou =  item.getElementsByTagName("descricaou")[0].firstChild.nodeValue;
            var descricao2a =  item.getElementsByTagName("descricao2a")[0].firstChild.nodeValue;
            var descricao2b =  item.getElementsByTagName("descricao2b")[0].firstChild.nodeValue;
			var descricao2c =  item.getElementsByTagName("descricao2c")[0].firstChild.nodeValue;
			var descricao2d =  item.getElementsByTagName("descricao2d")[0].firstChild.nodeValue;
			var descricao2e =  item.getElementsByTagName("descricao2e")[0].firstChild.nodeValue;
			var descricao2f =  item.getElementsByTagName("descricao2f")[0].firstChild.nodeValue;
			var descricaov =  item.getElementsByTagName("descricaov")[0].firstChild.nodeValue;
			var descricaox =  item.getElementsByTagName("descricaox")[0].firstChild.nodeValue;
			var descricaoz =  item.getElementsByTagName("descricaoz")[0].firstChild.nodeValue;

            descep1=descricao2a;
            
			trimjs(codigo);        	codigo = txt;
			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
			trimjs(descricaob);if (txt=='0'){txt='';};descricaob = txt;
			trimjs(descricaoc);if (txt=='0'){txt='';};descricaoc = txt;
			trimjs(descricaod);if (txt=='0'){txt='';};descricaod = txt;
			trimjs(descricaoe);if (txt=='0'){txt='';};descricaoe = txt;
			trimjs(descricaof);if (txt=='0'){txt='';};descricaof = txt;
			trimjs(descricaog);if (txt=='0'){txt='';};descricaog = txt;
			trimjs(descricaoh);if (txt=='0'){txt='';};descricaoh = txt;
			trimjs(descricaoi);if (txt=='0'){txt='';};descricaoi = txt;			
			trimjs(descricaoib);if (txt=='0'){txt='';};descricaoib = txt;			
			trimjs(descricaou);if (txt=='0'){txt='';};descricaou = txt;
			trimjs(descricao2a);if (txt=='0'){txt='';};descricao2a = txt;
			trimjs(descricao2b);if (txt=='0'){txt='';};descricao2b = txt;
			trimjs(descricao2c);if (txt=='0'){txt='';};descricao2c = txt;
			trimjs(descricao2d);if (txt=='0'){txt='';};descricao2d = txt;
			trimjs(descricao2e);if (txt=='0'){txt='';};descricao2e = txt;
			trimjs(descricao2f);if (txt=='0'){txt='';};descricao2f = txt;
      		trimjs(descricaov);if (txt=='0'){txt='';};descricaov = txt;
         	trimjs(descricaox);if (txt=='0'){txt='';};descricaox = txt;
			trimjs(descricaoz);if (txt=='0'){txt='';};descricaoz = txt;

			$("desnguerra").value=descricao;			
			$("desrazao").value=descricaoc;			
			$("descnpj").value=descricaoe;
			$("desie").value=descricaof;
			$("desrg").value=descricaog;
			$("descpf").value=descricaoh;			
			if (descricaou=='1')
			{
            	document.getElementById("radiodes11").checked=true;
				$("descnpj").disabled=false;
				$("desie").disabled=false;
				$("desrg").disabled=true;
				$("descpf").disabled=true;
			}
            else
            {
            	document.getElementById("radiodes12").checked=true;
				$("descnpj").disabled=true;
				$("desie").disabled=true;
				$("desrg").disabled=false;
				$("descpf").disabled=false;
			}
			$("descep").value=descricao2a;
			$("desendereco").value=descricao2b;
			$("desbairro").value=descricao2c;
			$("desfone").value=descricao2d;
			$("descomplemento").value=descricao2e;
			
	        $("descodcidade").value=descricaov;
			$("descidade").value=descricaox;
			$("desuf").value=descricaoz;
	
									
			document.getElementById("radiodes11").disabled = false;		
			document.getElementById("radiodes12").disabled = false;
		
			if( document.getElementById("radiodes11").checked==true)
			{
				$("descnpj").disabled = false;
				$("desie").disabled = false;
				$("desrg").value = "";
				$("descpf").value = "";
				$("desrg").disabled = true;
				$("descpf").disabled = true;
			}
			else
			{
				$("descnpj").disabled = true;
				$("desie").disabled = true;
				$("descnpj").value = "";
				$("desie").value = "";
				$("desrg").disabled = false;
				$("descpf").disabled = false;
			}
			document.getElementById("radiodes11").disabled = false;
			document.getElementById("radiodes12").disabled = false;			
			
			desufibge = descricaoib;				
			window.setTimeout("dadospesquisaibgerepdes('"+descricaoz+"')", 1000);
			
		}		
	}
	else
	{
		// caso o XML volte vazio, printa a mensagem abaixo
        descep1="";        		
		$("desnguerra").value="";		
		$("desrazao").value="";		
		$("descnpj").value="";
		$("desie").value="";
		$("desrg").value="";
		$("descpf").value="";		
		document.getElementById("radiodes11").checked=true;				
	}
}


function dadospesquisatiposituacao(valor) {


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
		 document.forms[0].situacao.options.length = 1;

		 idOpcao  = document.getElementById("situacao");

       		
 	         ajax2.open("POST", "ctepesquisasituacao.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtiposituacao(ajax2.responseXML);
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



   function processXMLtiposituacao(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].situacao.options.length = 0;

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
			    novo.setAttribute("id", "situacao");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].situacao.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatipopartilha(0);
  
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


function dadospesquisaversituacao(valor) {

	//Icms Normal
	if(valor==1){
		$("reducao").value = "";
		$("valorcredito").value = "";		
		$("reducao").disabled = true;		
		$("baseicms").disabled = false;
		$("percicms").disabled = false;
		$("valoricms").disabled = false;
		$("valorcredito").disabled = true;		
		document.forms[0].baseicms.focus();		
	}
	//Com Reducao
	else if(valor==2){		
		$("valorcredito").value = "";
		$("reducao").disabled = false;
		$("baseicms").disabled = false;
		$("percicms").disabled = false;
		$("valoricms").disabled = false;
		$("valorcredito").disabled = true;		
		document.forms[0].reducao.focus();
	}
	//Isento / Nao Tributado / Diferido
	else if(valor==3 || valor==4 || valor==5 || valor==8){		
		$("reducao").value = "";
		$("baseicms").value = "";
		$("percicms").value = "";
		$("valoricms").value = "";
		$("valorcredito").value = "";		
		$("reducao").disabled = true;
		$("baseicms").disabled = true;
		$("percicms").disabled = true;
		$("valoricms").disabled = true;
		$("valorcredito").disabled = true;				
	}
	//S.T.
	else if(valor==6){		
		$("reducao").value = "";
		$("reducao").disabled = true;
		$("baseicms").disabled = false;
		$("percicms").disabled = false;
		$("valoricms").disabled = false;
		$("valorcredito").disabled = false;		
		document.forms[0].baseicms.focus();
	}
	//Outros
	else if(valor==7){		
		$("reducao").disabled = false;
		$("baseicms").disabled = false;
		$("percicms").disabled = false;
		$("valoricms").disabled = false;
		$("valorcredito").disabled = false;		
		document.forms[0].reducao.focus();
	}
		
}

function dadospesquisatipopartilha(valor) {


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
		 document.forms[0].partilha.options.length = 1;

		 idOpcao  = document.getElementById("partilha");

       		
 	         ajax2.open("POST", "ctepesquisapartilha.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtipopartilha(ajax2.responseXML);
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



   function processXMLtipopartilha(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].partilha.options.length = 0;

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
			    novo.setAttribute("id", "partilha");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].partilha.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  dadospesquisatipolotacao(0);
  
   }   
   
function dadospesquisatipolotacao(valor) {


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
		 document.forms[0].lotacao.options.length = 1;

		 idOpcao  = document.getElementById("lotacao");

       		
 	         ajax2.open("POST", "ctepesquisaopcao.php", true);
		 ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2.readyState == 4 ) {
			   if(ajax2.responseXML) {
			   			    			 
			      processXMLtipolotacao(ajax2.responseXML);
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



   function processXMLtipolotacao(obj){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].lotacao.options.length = 0;

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
			    novo.setAttribute("id", "lotacao");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].lotacao.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcao.innerHTML = "____________________";

	  }
	  
	  
	  dadospesquisaestado(0);		
	  //dadospesquisa(1); xxxxxxxxxxxxxxx
  
   }      
   
function verificatipoicms(valor)
{
	if( document.getElementById("opcao_icms1").checked==true)
	{
		$("interbase").disabled = false;
		$("interpercterm").disabled = false;		
		$("interpercinter").disabled = false;
		document.forms[0].partilha.disabled=false;		
		$("intervalini").disabled = false;
		$("intervalfim").disabled = false;
		$("interpercpobr").disabled = false;
		$("intervalpobr").disabled = false;
	}
	else
	{
		$("interbase").disabled = true;				
		$("interbase").value = "";		
		$("interpercterm").disabled = true;
		$("interpercterm").value = "";		
		$("interpercinter").disabled = true;
		$("interpercinter").value = "";		
		document.forms[0].partilha.disabled=true;		
		$("intervalini").disabled = true;
		$("intervalfim").disabled = true;
		$("interpercpobr").disabled = true;
		$("intervalpobr").disabled = true;
		$("intervalini").value = "";		
		$("intervalfim").value = "";		
		$("interpercpobr").value = "";		
		$("intervalpobr").value = "";		
	}
}   


function digitaservicos()
{

	$("tab3").checked = false;	
	novaJanela("valorservico.php?usucodigo="+vusuario,"COMPONENTES DA PRESTACAO DE SERVICOS");	
	//window.open("valorservico.php?usucodigo="+vusuario,"_blank");
	
}


function novaJanela(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callback,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callback()
{
	digitaservicosOK();
}

function digitaservicosOK()
{

	$("tab3").checked = true;	
	
	new ajax ('valorservicocarregatotal.php?parametro='+ vusuario
        , {onComplete: imprime_total_servicos});
	
}

function imprime_total_servicos(request){

	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');		

		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
		
			var itens = registros[i].getElementsByTagName('item');				
			$("valorservico").value=itens[0].firstChild.data;							
			
		}		
	}
	else {
		$("valorservico").value="";		
	}
		
}

function verificaempresa(valor)
{
	if( document.getElementById("radioempresa1").checked==true)
	{	
		$('linhaemitente').style.display="";						
		$('linhatomador').style.display="none";			
		$('linharemetente').style.display="none";			
		$('linhaexpedidor').style.display="none";			
		$('linharecebedor').style.display="none";			
		$('linhadestinatario').style.display="none";			
	}
	else if( document.getElementById("radioempresa2").checked==true)
	{	
		$('linhaemitente').style.display="none";						
		$('linhatomador').style.display="";			
		$('linharemetente').style.display="none";			
		$('linhaexpedidor').style.display="none";			
		$('linharecebedor').style.display="none";			
		$('linhadestinatario').style.display="none";			
	}
	else if( document.getElementById("radioempresa3").checked==true)
	{	
		$('linhaemitente').style.display="none";						
		$('linhatomador').style.display="none";				
		$('linharemetente').style.display="";			
		$('linhaexpedidor').style.display="none";			
		$('linharecebedor').style.display="none";			
		$('linhadestinatario').style.display="none";			
	}
	else if( document.getElementById("radioempresa4").checked==true)
	{	
		$('linhaemitente').style.display="none";						
		$('linhatomador').style.display="none";				
		$('linharemetente').style.display="none";			
		$('linhaexpedidor').style.display="";			
		$('linharecebedor').style.display="none";			
		$('linhadestinatario').style.display="none";			
	}
	else if( document.getElementById("radioempresa5").checked==true)
	{
		$('linhaemitente').style.display="none";						
		$('linhatomador').style.display="none";				
		$('linharemetente').style.display="none";			
		$('linhaexpedidor').style.display="none";			
		$('linharecebedor').style.display="";			
		$('linhadestinatario').style.display="none";			
	}
	else {
		$('linhaemitente').style.display="none";						
		$('linhatomador').style.display="none";				
		$('linharemetente').style.display="none";			
		$('linhaexpedidor').style.display="none";			
		$('linharecebedor').style.display="none";			
		$('linhadestinatario').style.display="";			
	}
}


function carregacarga()
{

	$("tab4").checked = false;	
	novaJanelaCarga("infocarga.php?usucodigo="+vusuario,"QUANTIDADES DA CARGA");	
	//window.open("valorservico.php?usucodigo="+vusuario,"_blank");
	
}


function novaJanelaCarga(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackcarga,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackcarga()
{
	carregacargaOK();
}

function carregacargaOK()
{

	$("tab4").checked = true;	
	
}

function carregaseguro()
{

	$("tab4").checked = false;	
	novaJanelaSeguro("infoseguro.php?usucodigo="+vusuario,"SEGURO");	
		
}


function novaJanelaSeguro(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackseguro,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackseguro()
{
	carregaseguroOK();
}

function carregaseguroOK()
{
	$("tab4").checked = true;	
	new ajax ('infoseguroseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});	
}

function imprime_serv(request){
	
	$("segresp").value="";
	$("segnome").value="";
	$("segapolice").value="";
	$("segaverba").value="";
	$("segvalor").value="";

   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){
				
				$("segresp").value=itens[1].firstChild.data;
				$("segnome").value=itens[2].firstChild.data;
				if(itens[4].firstChild.data!='_'){					
					$("segapolice").value=itens[4].firstChild.data;
				}	
				if(itens[5].firstChild.data!='_'){					
					$("segaverba").value=itens[5].firstChild.data;
				}	
				$("segvalor").value=itens[3].firstChild.data;
				
			}	
		}		
	}
	
}

function carregaduplicata()
{

	$("tab4").checked = false;	
	novaJanelaDuplicata("infoduplicata.php?usucodigo="+vusuario,"DUPLICATAS");	
		
}


function novaJanelaDuplicata(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackduplicata,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackduplicata()
{
	carregaduplicataOK();
}

function carregaduplicataOK()
{
	$("tab4").checked = true;	
	
}


function carregacontribuinte()
{

	$("tab6").checked = false;	
	novaJanelaContribuinte("obscontribuinte.php?usucodigo="+vusuario,"OBSERVACOES DE INTERESSE DO CONTRIBUINTE");	
		
}


function novaJanelaContribuinte(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackcontribuinte,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackcontribuinte()
{
	carregacontribuinteOK();
}

function carregacontribuinteOK()
{
	$("tab6").checked = true;	
	new ajax ('obscontribuinteseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_contr});	
}

function imprime_contr(request){
	
	$("obscontribuinte").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){				
				$("obscontribuinte").value=itens[2].firstChild.data;				
			}	
		}		
	}
	
}


function carregafisco()
{

	$("tab6").checked = false;	
	novaJanelaFisco("obsfisco.php?usucodigo="+vusuario,"OBSERVACOES DE INTERESSE DO FISCO");	
		
}


function novaJanelaFisco(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackfisco,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackfisco()
{
	carregafiscoOK();
}

function carregafiscoOK()
{
	$("tab6").checked = true;	
	new ajax ('obsfiscoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_fisco});	
}

function imprime_fisco(request){
	
	$("obsfisco").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){				
				$("obsfisco").value=itens[2].firstChild.data;				
			}	
		}		
	}
	
}


function uploadnfe()
{

	$("tab4").checked = false;	
	novaJanelaNfe("importanfe.php?usucodigo="+vusuario,"UPLOAD DE XML DE NOTA FISCAL ELETRONICA");
		
}


function novaJanelaNfe(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbacknfe,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbacknfe()
{
	carreganfeOK();
}

function carreganfeOK()
{
	$("tab4").checked = true;	
	
	titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO LEITURA DOS DADOS DAS NOTAS";

    $a("#retorno").messageBoxModal(titulo, mensagem);
	
	new ajax('processanfe.php?usuario='+vusuario , {onComplete: encerraarquivos});
	//window.open('processanfe.php?usuario='+vusuario, '_blank');
	
}


function encerraarquivos(request)
{
	
	var xmldoc=request.responseXML;

	var dados = xmldoc.getElementsByTagName('dadosc')[0];

	var mensagem = xmldoc.getElementsByTagName('resultado');
	
	$a.unblockUI();
	
	new ajax ('infonfeseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_nota});	
	
}

function carreganota()
{

	$("tab4").checked = false;	
	novaJanelaNota("infonfe.php?usucodigo="+vusuario,"NOTA FISCAL ELETRÔNICA");	
		
}


function novaJanelaNota(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbacknota,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbacknota()
{
	carreganotaOK();
}

function carreganotaOK()
{
	$("tab4").checked = true;	
	new ajax ('infonfeseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_nota});	
}

function imprime_nota(request){
	
	$("nfechave").value="";
	$("nfepin").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){				
				$("nfechave").value=itens[1].firstChild.data;				
				if(itens[2].firstChild.data!='_'){
					$("nfepin").value=itens[2].firstChild.data;				
				}	
			}	
		}		
	}
	
}


function carregamotorista()
{

	$("tab5").checked = false;	
	novaJanelaMotorista("infomotoristas.php?usucodigo="+vusuario,"MOTORISTAS");	
		
}


function novaJanelaMotorista(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackmotorista,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackmotorista()
{
	carregamotoristaOK();
}

function carregamotoristaOK()
{
	$("tab5").checked = true;		
	new ajax ('infomotseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_motorista});	
	
}

function imprime_motorista(request){
	
	$("motnome").value="";
	$("motcpf").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){				
				$("motnome").value=itens[1].firstChild.data;				
				$("motcpf").value=itens[2].firstChild.data;								
			}	
		}		
	}
	
}

function carregapedagio()
{

	$("tab5").checked = false;	
	novaJanelaPedagio("infopedagio.php?usucodigo="+vusuario,"PEDAGIO");
		
}


function novaJanelaPedagio(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackpedagio,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackpedagio()
{
	carregapedagioOK();
}

function carregapedagioOK()
{
	$("tab5").checked = true;	
	new ajax ('infopedagioseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_pedagio});	
	
}

function imprime_pedagio(request){
	
	$("pedcnpj").value="";
	$("pedcomprova").value="";
	$("pedcnpj2").value="";
	$("pedvalor").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');
			
			if(i==0){		
				if(itens[2].firstChild.data!='_'){
					$("pedcnpj").value=itens[2].firstChild.data;
				}	
				$("pedcomprova").value=itens[1].firstChild.data;
				if(itens[3].firstChild.data!='_'){
					$("pedcnpj2").value=itens[3].firstChild.data;
				}					
				$("pedvalor").value=itens[4].firstChild.data;				
			}	
		}		
	}
	
}

function carregalacres()
{

	$("tab5").checked = false;	
	novaJanelaLacre("infolacre.php?usucodigo="+vusuario,"LACRES");
		
}


function novaJanelaLacre(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (325),
		width: (600),
		
		animation: true,
		overlay_clickable: false,
		callback: callbacklacre,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbacklacre()
{
	carregalacreOK();
}

function carregalacreOK()
{
	$("tab5").checked = true;			
}


function carregacoleta()
{

	$("tab5").checked = false;	
	novaJanelaColeta("infocoleta.php?usucodigo="+vusuario,"ORDEM DE COLETA ASSOCIADA");
		
}


function novaJanelaColeta(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (425),
		width: (800),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackcoleta,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackcoleta()
{
	carregacoletaOK();
}

function carregacoletaOK()
{
	$("tab5").checked = true;			
}

function carregaveiculo()
{

	$("tab5").checked = false;	
	novaJanelaVeiculo("infoveiculos.php?usucodigo="+vusuario,"VEICULOS");
		
}


function novaJanelaVeiculo(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (500),
		width: (980),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackveiculo,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackveiculo()
{
	carregaveiculoOK();
}

function carregaveiculoOK()
{
	$("tab5").checked = true;	
	new ajax ('infoveiculoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_veiculo});	
	
}

function imprime_veiculo(request){
	
	$("veiplaca").value="";
	$("veirenavan").value="";
	$("veiuf").value="";
	$("veicodigo").value="";
	$("veiprop").value="";
	
	$("veiplaca2").value="";
	$("veirenavan2").value="";
	$("veiuf2").value="";
	$("veicodigo2").value="";
	$("veiprop2").value="";
	
	$("veiplaca3").value="";
	$("veirenavan3").value="";
	$("veiuf3").value="";
	$("veicodigo3").value="";
	$("veiprop3").value="";
	
	$("veiplaca4").value="";
	$("veirenavan4").value="";
	$("veiuf4").value="";
	$("veicodigo4").value="";
	$("veiprop4").value="";
	   
	var xmldoc=request.responseXML;
	var cabecalho = xmldoc.getElementsByTagName('cabecalho')[0];

	if(cabecalho!=null)
	{
		var campo = cabecalho.getElementsByTagName('campo');
		
		//corpo da tabela
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
			var itens = registros[i].getElementsByTagName('item');			
			if(i==0){
				if(itens[1].firstChild.data!='_'){
					$("veiplaca").value=value=itens[1].firstChild.data;
				}
				if(itens[2].firstChild.data!='_'){
					$("veirenavan").value=itens[2].firstChild.data;
				}
				if(itens[3].firstChild.data!='_'){
					$("veiuf").value=itens[3].firstChild.data;
				}
				if(itens[4].firstChild.data!='_'){
					$("veicodigo").value=itens[4].firstChild.data;
				}
				if(itens[5].firstChild.data!='_'){
					$("veiprop").value=itens[5].firstChild.data;
				}				
			}
			else if(i==1){
				if(itens[1].firstChild.data!='_'){
					$("veiplaca2").value=value=itens[1].firstChild.data;
				}
				if(itens[2].firstChild.data!='_'){
					$("veirenavan2").value=itens[2].firstChild.data;
				}
				if(itens[3].firstChild.data!='_'){
					$("veiuf2").value=itens[3].firstChild.data;
				}
				if(itens[4].firstChild.data!='_'){
					$("veicodigo2").value=itens[4].firstChild.data;
				}
				if(itens[5].firstChild.data!='_'){
					$("veiprop2").value=itens[5].firstChild.data;
				}				
			}
			else if(i==2){
				if(itens[1].firstChild.data!='_'){
					$("veiplaca3").value=value=itens[1].firstChild.data;
				}
				if(itens[2].firstChild.data!='_'){
					$("veirenavan3").value=itens[2].firstChild.data;
				}
				if(itens[3].firstChild.data!='_'){
					$("veiuf3").value=itens[3].firstChild.data;
				}
				if(itens[4].firstChild.data!='_'){
					$("veicodigo3").value=itens[4].firstChild.data;
				}
				if(itens[5].firstChild.data!='_'){
					$("veiprop3").value=itens[5].firstChild.data;
				}				
			}
			else if(i==3){
				if(itens[1].firstChild.data!='_'){
					$("veiplaca4").value=value=itens[1].firstChild.data;
				}
				if(itens[2].firstChild.data!='_'){
					$("veirenavan4").value=itens[2].firstChild.data;
				}
				if(itens[3].firstChild.data!='_'){
					$("veiuf4").value=itens[3].firstChild.data;
				}
				if(itens[4].firstChild.data!='_'){
					$("veicodigo4").value=itens[4].firstChild.data;
				}
				if(itens[5].firstChild.data!='_'){
					$("veiprop4").value=itens[5].firstChild.data;
				}				
			}
		}		
	}
	
}



//------------- Número do pedido e Data --------// 
function load_pedidopesq(cte)
{

	new ajax('pesquisargeracte.php?flag=NumeroOrcamento&cte=' + cte, {onComplete: imprime_pedidopesq});
	
	
}



function imprime_pedidopesq(request)
{
	var xmldoc=request.responseXML;
   	var dados = xmldoc.getElementsByTagName('dados')[0];
	var registros = xmldoc.getElementsByTagName('registro');
	var itens = registros[0].getElementsByTagName('item');

	var orcamento = parseInt(itens[0].firstChild.data);
	var modelo = parseInt(itens[1].firstChild.data);
	var serie = itens[2].firstChild.data;
	var numero = itens[3].firstChild.data;
	var emissao = itens[4].firstChild.data;
	var hora = itens[5].firstChild.data;
	var tmonome = itens[6].firstChild.data;
	var sernome = itens[7].firstChild.data;
	var ctechaveref = itens[8].firstChild.data;
	var tomnome = itens[9].firstChild.data;
	var tfonome = itens[10].firstChild.data;
	var ctecfop = itens[11].firstChild.data;
	var ctenatureza = itens[12].firstChild.data;
	var tctnome = itens[13].firstChild.data;
	var cidinicio = itens[14].firstChild.data;
	var cteufinicio = itens[15].firstChild.data;
	var cidfinal = itens[16].firstChild.data;
	var cteuffinal = itens[17].firstChild.data;

	var cteremrazao = itens[18].firstChild.data;
	var cteremendereco = itens[19].firstChild.data;
	var cterembairro = itens[20].firstChild.data;
	var cteremnumero = itens[21].firstChild.data;
	var cidrem = itens[22].firstChild.data;
	var cteremfone = itens[23].firstChild.data; 
	var cterempais = itens[24].firstChild.data; 
	var cteremuf = itens[25].firstChild.data; 
	var cterempessoa = itens[26].firstChild.data; 
	var cteremcep = itens[27].firstChild.data; 
	var cteremcnpj = itens[28].firstChild.data; 
	var cteremie = itens[29].firstChild.data; 
	var cteremcpf = itens[30].firstChild.data; 

	var ctedesrazao = itens[31].firstChild.data; 
	var ctedesendereco = itens[32].firstChild.data; 
	var ctedesbairro = itens[33].firstChild.data;
	var ctedesnumero = itens[34].firstChild.data;
	var ciddes = itens[35].firstChild.data;
	var ctedesfone = itens[36].firstChild.data; 
	var ctedespais = itens[37].firstChild.data; 
	var ctedesuf = itens[38].firstChild.data; 
		
	var ctedespessoa = itens[39].firstChild.data;
	var ctedescep = itens[40].firstChild.data; 
	var ctedescnpj = itens[41].firstChild.data; 
	var ctedesie = itens[42].firstChild.data; 
	var ctedescpf = itens[43].firstChild.data; 

	var cteexprazao = itens[44].firstChild.data; 
	var cteexpendereco = itens[45].firstChild.data; 
	var cteexpbairro = itens[46].firstChild.data; 
	var cteexpnumero = itens[47].firstChild.data; 
	var cidexp = itens[48].firstChild.data; 
	var cteexpfone = itens[49].firstChild.data; 
	var cteexppais = itens[50].firstChild.data; 
	var cteexpuf = itens[51].firstChild.data; 
		
	var cteexppessoa = itens[52].firstChild.data; 
	var cteexpcep = itens[53].firstChild.data; 
	var cteexpcnpj = itens[54].firstChild.data; 
	var cteexpie = itens[55].firstChild.data; 
	var cteexpcpf = itens[56].firstChild.data; 
		
	var cterecrazao = itens[57].firstChild.data; 
	var cterecendereco = itens[58].firstChild.data; 
	var cterecbairro = itens[59].firstChild.data; 
	var cterecnumero = itens[60].firstChild.data; 
	var cidrec = itens[61].firstChild.data; 
	var cterecfone = itens[62].firstChild.data; 
	var cterecpais = itens[63].firstChild.data; 
	var cterecuf = itens[64].firstChild.data; 
		
	var cterecpessoa = itens[65].firstChild.data; 
	var ctereccep = itens[66].firstChild.data; 
	var ctereccnpj = itens[67].firstChild.data; 
	var cterecie = itens[68].firstChild.data;
	var ctereccpf = itens[69].firstChild.data;
		
	var ctetomrazao = itens[70].firstChild.data; 
	var ctetomendereco = itens[71].firstChild.data; 
	var ctetombairro = itens[72].firstChild.data; 
	var ctetomnumero = itens[73].firstChild.data; 
	var cidtom = itens[74].firstChild.data; 
	var ctetomfone = itens[75].firstChild.data; 
	var ctetompais = itens[76].firstChild.data; 
	var ctetomuf = itens[77].firstChild.data; 
	var ctetompessoa = itens[78].firstChild.data; 
	var ctetomcep = itens[79].firstChild.data; 
	var ctetomcnpj = itens[80].firstChild.data; 
	var ctetomie = itens[81].firstChild.data; 
	var ctetomcpf = itens[82].firstChild.data; 
		
	var ctepropredominante = itens[83].firstChild.data; 
	var cteoutcaracteristica = itens[84].firstChild.data; 
	var ctecargaval = itens[85].firstChild.data; 
	var cteservicos = itens[86].firstChild.data; 
	var ctereceber = itens[87].firstChild.data; 
	var sitnome = itens[88].firstChild.data; 
		
	var cteperreducao = itens[89].firstChild.data; 
	var ctebasecalculo = itens[90].firstChild.data; 
	var ctepericms = itens[91].firstChild.data; 
	var ctevalicms = itens[92].firstChild.data; 
		
	var cteobsgeral = itens[93].firstChild.data; 
		
	var cterntrc = itens[94].firstChild.data; 
	var cteentrega = itens[95].firstChild.data; 
	var cteciot = itens[96].firstChild.data; 
	var topnome = itens[97].firstChild.data; 
	
	
	var tmocodigo = itens[98].firstChild.data; 
	var sercodigo = itens[99].firstChild.data; 
	var tctcodigo = itens[100].firstChild.data; 
	var tpgcodigo = itens[101].firstChild.data; 
	var tfocodigo = itens[102].firstChild.data; 
	

	var cteufemissao = itens[103].firstChild.data; 
	var cteufinicio = itens[104].firstChild.data; 
	var cteuffinal = itens[105].firstChild.data; 
	var ctecidemissao = itens[106].firstChild.data; 

	var ctecidinicio = itens[107].firstChild.data; 
	var ctecidfinal = itens[108].firstChild.data; 
	

	var cteemipessoa = itens[109].firstChild.data; 
	var cteemicnpj = itens[110].firstChild.data; 
	var cteemiie = itens[111].firstChild.data; 
	var cteemicpf = itens[112].firstChild.data; 
	var cteemirg = itens[113].firstChild.data; 
	var cteeminguerra = itens[114].firstChild.data; 
	var cteemirazao = itens[115].firstChild.data; 
	var cteemicep = itens[116].firstChild.data; 
	var cteemiendereco = itens[117].firstChild.data; 
	var cteeminumero = itens[118].firstChild.data; 
	var cteemibairro = itens[119].firstChild.data; 
	var cteemicomplemento = itens[120].firstChild.data; 
	var cteemifone = itens[121].firstChild.data; 
	var cteemipais = itens[122].firstChild.data; 
	var cteemiuf = itens[123].firstChild.data; 
	var cteemicidcodigo = itens[124].firstChild.data; 
	var cteemicidcodigoibge = itens[125].firstChild.data; 
	var ctecidemi = itens[126].firstChild.data; 
	
	var tomcodigo = itens[127].firstChild.data; 
	var tompessoa = itens[128].firstChild.data; 
	var ctetomrg = itens[129].firstChild.data; 
	var ctetomnguerra = itens[130].firstChild.data; 
	var ctetombairro = itens[131].firstChild.data; 
	var ctetomcomplemento = itens[132].firstChild.data; 
	var tomcidcodigo = itens[133].firstChild.data; 
	var tomcidcodigoibge = itens[134].firstChild.data; 
	

	var remcodigo = itens[135].firstChild.data; 
	var cteremrg = itens[136].firstChild.data; 
	var cteremnguerra = itens[137].firstChild.data; 
	var cteremcomplemento = itens[138].firstChild.data; 
	var remcidcodigo = itens[139].firstChild.data; 
	var remcidcodigoibge = itens[140].firstChild.data; 
	

	var expcodigo = itens[141].firstChild.data; 
	var cteexprg = itens[142].firstChild.data; 
	var cteexpnguerra = itens[143].firstChild.data; 
	var cteexpcomplemento = itens[144].firstChild.data; 
	var expcidcodigo = itens[145].firstChild.data; 
	var expcidcodigoibge = itens[146].firstChild.data; 


	var reccodigo = itens[147].firstChild.data; 
	var cterecrg = itens[148].firstChild.data; 
	var cterecnguerra = itens[149].firstChild.data; 
	var ctereccomplemento = itens[150].firstChild.data; 
	var reccidcodigo = itens[151].firstChild.data; 
	var reccidcodigoibge = itens[152].firstChild.data; 
	
	var descodigo = itens[153].firstChild.data; 
	var ctedesrg = itens[154].firstChild.data; 
	var ctedesnguerra = itens[155].firstChild.data; 
	var ctedescomplemento = itens[156].firstChild.data; 
	var descidcodigo = itens[157].firstChild.data; 
	var descidcodigoibge = itens[158].firstChild.data; 
	
	 
	
	var cteservicos = itens[159].firstChild.data; 
	var ctereceber = itens[160].firstChild.data; 
	var ctetributos = itens[161].firstChild.data; 
	var sitcodigo = itens[162].firstChild.data; 
	var cteperreducao = itens[163].firstChild.data; 
	var ctebasecalculo = itens[164].firstChild.data; 
	var ctepericms = itens[165].firstChild.data; 
	var ctevalicms = itens[166].firstChild.data; 
	var ctecredito = itens[167].firstChild.data; 
	var ctepreencheicms = itens[168].firstChild.data; 
	var ctebaseicms = itens[169].firstChild.data; 
	var cteperinterna = itens[170].firstChild.data; 
	var cteperinter = itens[171].firstChild.data; 
	var cteperpartilha = itens[172].firstChild.data; 
	var ctevalicmsini = itens[173].firstChild.data; 
	var ctevalicmsfim = itens[174].firstChild.data; 
	var cteperpobreza = itens[175].firstChild.data; 
	var ctevalpobreza = itens[176].firstChild.data; 
	var cteadcfisco = itens[177].firstChild.data; 
		
	var ctecargaval = itens[178].firstChild.data; 
	var ctepropredominante = itens[179].firstChild.data; 
	var cteoutcaracteristica = itens[180].firstChild.data; 
	var ctecobrancanum = itens[181].firstChild.data; 
	var ctecobrancaval = itens[182].firstChild.data; 
	var ctecobrancades = itens[183].firstChild.data; 
	var ctecobrancaliq = itens[184].firstChild.data; 
	var cterntrc = itens[185].firstChild.data; 
	//var cteentrega = itens[186].firstChild.data; 
	var cteindlocacao = itens[187].firstChild.data; 
	var cteciot = itens[188].firstChild.data; 
	var cteobsgeral = itens[189].firstChild.data; 
	
	var ctechavefin = itens[190].firstChild.data; 
	var ctedatatomador = itens[191].firstChild.data; 
	
	var ctesubstipo = itens[192].firstChild.data; 
	var ctesubschave = itens[193].firstChild.data; 
	var ctedessuframa = itens[194].firstChild.data;
	var ctechave = itens[195].firstChild.data;	
	
	var sefazchave			= itens[196].firstChild.data;
	var sefazemissao		= itens[197].firstChild.data;
	var sefazrecebto		= itens[198].firstChild.data;
	var sefazstatus			= itens[199].firstChild.data;
	var sefazprotocolo		= itens[200].firstChild.data;
	var sefazcancchave		= itens[201].firstChild.data;
	var sefazcancemissao	= itens[202].firstChild.data;
	var sefazcancrecebto	= itens[203].firstChild.data;
	var sefazcancstatus		= itens[204].firstChild.data;
	var sefazcancprotocolo	= itens[205].firstChild.data;
	
	var inutmotivo			= itens[206].firstChild.data;
	var inutdata			= itens[207].firstChild.data;
	
	
	trimjs(cteemicnpj);if (txt=='0'){txt='';};cteemicnpj = txt;
	trimjs(cteemiie);if (txt=='0'){txt='';};cteemiie = txt;
	trimjs(cteemicpf);if (txt=='0'){txt='';};cteemicpf = txt;
	trimjs(cteemirg);if (txt=='0'){txt='';};cteemirg = txt;
	trimjs(cteeminguerra);if (txt=='0'){txt='';};cteeminguerra = txt;
	trimjs(cteemirazao);if (txt=='0'){txt='';};cteemirazao = txt;
	trimjs(cteemicep);if (txt=='0'){txt='';};cteemicep = txt;
	trimjs(cteemiendereco);if (txt=='0'){txt='';};cteemiendereco = txt;
	trimjs(cteeminumero);if (txt=='0'){txt='';};cteeminumero = txt;
	trimjs(cteemibairro);if (txt=='0'){txt='';};cteemibairro = txt;
	trimjs(cteemicomplemento);if (txt=='0'){txt='';};cteemicomplemento = txt;
	trimjs(cteemifone);if (txt=='0'){txt='';};cteemifone = txt;
	trimjs(cteemipais);if (txt=='0'){txt='';};cteemipais = txt;
	trimjs(cteemiuf);if (txt=='0'){txt='';};cteemiuf = txt;
	trimjs(cteemicidcodigo);if (txt=='0'){txt='';};cteemicidcodigo = txt;
	trimjs(ctecidemi);if (txt=='0'){txt='';};ctecidemi = txt;
	
	trimjs(tomcodigo);if (txt=='0'){txt='';};tomcodigo = txt;
	trimjs(tompessoa);if (txt=='0'){txt='';};tompessoa = txt;
	trimjs(ctetomrg);if (txt=='0'){txt='';};ctetomrg = txt;
	trimjs(ctetomnguerra);if (txt=='0'){txt='';};ctetomnguerra = txt;
	trimjs(ctetombairro);if (txt=='0'){txt='';};ctetombairro = txt;
	trimjs(ctetomcomplemento);if (txt=='0'){txt='';};ctetomcomplemento = txt;
	trimjs(tomcidcodigo);if (txt=='0'){txt='';};tomcidcodigo = txt;
	trimjs(tomcidcodigoibge);if (txt=='0'){txt='';};tomcidcodigoibge = txt;

	trimjs(ctetomrazao);if (txt=='0'){txt='';};ctetomrazao = txt;
	trimjs(ctetomcep);if (txt=='0'){txt='';};ctetomcep = txt;
	trimjs(ctetomendereco);if (txt=='0'){txt='';};ctetomendereco = txt;
	trimjs(ctetomnumero);if (txt=='0'){txt='';};ctetomnumero = txt;
	trimjs(ctetomfone);if (txt=='0'){txt='';};ctetomfone = txt;
	trimjs(ctetompais);if (txt=='0'){txt='';};ctetompais = txt;
	trimjs(ctetomuf);if (txt=='0'){txt='';};ctetomuf = txt;
	trimjs(ctetomcnpj);if (txt=='0'){txt='';};ctetomcnpj = txt;
	trimjs(ctetomie);if (txt=='0'){txt='';};ctetomie = txt;
	trimjs(ctetomcpf);if (txt=='0'){txt='';};ctetomcpf = txt;
	
	
	
	trimjs(remcodigo);if (txt=='0'){txt='';};remcodigo = txt;
	trimjs(cteremrg);if (txt=='0'){txt='';};cteremrg = txt;
	trimjs(cteremnguerra);if (txt=='0'){txt='';};cteremnguerra = txt;
	trimjs(cterembairro);if (txt=='0'){txt='';};cterembairro = txt;
	trimjs(cteremcomplemento);if (txt=='0'){txt='';};cteremcomplemento = txt;
	trimjs(remcidcodigo);if (txt=='0'){txt='';};remcidcodigo = txt;
	trimjs(remcidcodigoibge);if (txt=='0'){txt='';};remcidcodigoibge = txt;
	
	trimjs(cteremrazao);if (txt=='0'){txt='';};cteremrazao = txt;
	trimjs(cteremcep);if (txt=='0'){txt='';};cteremcep = txt;
	trimjs(cteremendereco);if (txt=='0'){txt='';};cteremendereco = txt;
	trimjs(cteremnumero);if (txt=='0'){txt='';};cteremnumero = txt;
	trimjs(cteremfone);if (txt=='0'){txt='';};cteremfone = txt;
	trimjs(cterempais);if (txt=='0'){txt='';};cterempais = txt;
	trimjs(cteremuf);if (txt=='0'){txt='';};cteremuf = txt;
	trimjs(cteremcnpj);if (txt=='0'){txt='';};cteremcnpj = txt;
	trimjs(cteremie);if (txt=='0'){txt='';};cteremie = txt;
	trimjs(cteremcpf);if (txt=='0'){txt='';};cteremcpf = txt;
	

	
	
	trimjs(expcodigo);if (txt=='0'){txt='';};expcodigo = txt;
	trimjs(cteexprg);if (txt=='0'){txt='';};cteexprg = txt;
	trimjs(cteexpnguerra);if (txt=='0'){txt='';};cteexpnguerra = txt;
	trimjs(cteexpcomplemento);if (txt=='0'){txt='';};cteexpcomplemento = txt;
	trimjs(expcidcodigo);if (txt=='0'){txt='';};expcidcodigo = txt;
	trimjs(expcidcodigoibge);if (txt=='0'){txt='';};expcidcodigoibge = txt;	

	trimjs(cteexprazao);if (txt=='0'){txt='';};cteexprazao = txt;
	trimjs(cteexpcep);if (txt=='0'){txt='';};cteexpcep = txt;
	trimjs(cteexpendereco);if (txt=='0'){txt='';};cteexpendereco = txt;
	trimjs(cteexpnumero);if (txt=='0'){txt='';};cteexpnumero = txt;
	trimjs(cteexpfone);if (txt=='0'){txt='';};cteexpfone = txt;
	trimjs(cteexppais);if (txt=='0'){txt='';};cteexppais = txt;
	trimjs(cteexpuf);if (txt=='0'){txt='';};cteexpuf = txt;
	trimjs(cteexpcnpj);if (txt=='0'){txt='';};cteexpcnpj = txt;
	trimjs(cteexpie);if (txt=='0'){txt='';};cteexpie = txt;
	trimjs(cteexpcpf);if (txt=='0'){txt='';};cteexpcpf = txt;

	
	
	trimjs(reccodigo);if (txt=='0'){txt='';};reccodigo = txt;
	trimjs(cterecrg);if (txt=='0'){txt='';};cterecrg = txt;
	trimjs(cterecnguerra);if (txt=='0'){txt='';};cterecnguerra = txt;
	trimjs(ctereccomplemento);if (txt=='0'){txt='';};ctereccomplemento = txt;
	trimjs(reccidcodigo);if (txt=='0'){txt='';};reccidcodigo = txt;
	trimjs(reccidcodigoibge);if (txt=='0'){txt='';};reccidcodigoibge = txt;	

	trimjs(cterecrazao);if (txt=='0'){txt='';};cterecrazao = txt;
	trimjs(ctereccep);if (txt=='0'){txt='';};ctereccep = txt;
	trimjs(cterecendereco);if (txt=='0'){txt='';};cterecendereco = txt;
	trimjs(cterecnumero);if (txt=='0'){txt='';};cterecnumero = txt;
	trimjs(cterecfone);if (txt=='0'){txt='';};cterecfone = txt;
	trimjs(cterecpais);if (txt=='0'){txt='';};cterecpais = txt;
	trimjs(cterecuf);if (txt=='0'){txt='';};cterecuf = txt;
	trimjs(ctereccnpj);if (txt=='0'){txt='';};ctereccnpj = txt;
	trimjs(cterecie);if (txt=='0'){txt='';};cterecie = txt;
	trimjs(ctereccpf);if (txt=='0'){txt='';};ctereccpf = txt;	
	

	
	trimjs(descodigo);if (txt=='0'){txt='';};descodigo = txt;
	trimjs(ctedesrg);if (txt=='0'){txt='';};ctedesrg = txt;
	trimjs(ctedesnguerra);if (txt=='0'){txt='';};ctedesnguerra = txt;
	trimjs(ctedescomplemento);if (txt=='0'){txt='';};ctedescomplemento = txt;
	trimjs(descidcodigo);if (txt=='0'){txt='';};descidcodigo = txt;
	trimjs(descidcodigoibge);if (txt=='0'){txt='';};descidcodigoibge = txt;	

	trimjs(ctedesrazao);if (txt=='0'){txt='';};ctedesrazao = txt;
	trimjs(ctedescep);if (txt=='0'){txt='';};ctedescep = txt;
	trimjs(ctedesendereco);if (txt=='0'){txt='';};ctedesendereco = txt;
	trimjs(ctedesnumero);if (txt=='0'){txt='';};ctedesnumero = txt;
	trimjs(ctedessuframa);if (txt=='0'){txt='';};ctedessuframa = txt;
	trimjs(ctedesfone);if (txt=='0'){txt='';};ctedesfone = txt;
	trimjs(ctedespais);if (txt=='0'){txt='';};ctedespais = txt;
	trimjs(ctedesuf);if (txt=='0'){txt='';};ctedesuf = txt;
	trimjs(ctedescnpj);if (txt=='0'){txt='';};ctedescnpj = txt;
	trimjs(ctedesie);if (txt=='0'){txt='';};ctedesie = txt;
	trimjs(ctedescpf);if (txt=='0'){txt='';};ctedescpf = txt;		

	
	trimjs(cteservicos);if (txt=='0'){txt='';};cteservicos = txt;		
	trimjs(ctereceber);if (txt=='0'){txt='';};ctereceber = txt;		
	trimjs(ctetributos);if (txt=='0'){txt='';};ctetributos = txt;		
	trimjs(sitcodigo);if (txt=='0'){txt='';};sitcodigo = txt;		
	trimjs(cteperreducao);if (txt=='0'){txt='';};cteperreducao = txt;		
	trimjs(ctebasecalculo);if (txt=='0'){txt='';};ctebasecalculo = txt;		
	trimjs(ctepericms);if (txt=='0'){txt='';};ctepericms = txt;		
	trimjs(ctevalicms);if (txt=='0'){txt='';};ctevalicms = txt;		
	trimjs(ctecredito);if (txt=='0'){txt='';};ctecredito = txt;		
	trimjs(ctepreencheicms);if (txt=='0'){txt='';};ctepreencheicms = txt;		
	trimjs(ctebaseicms);if (txt=='0'){txt='';};ctebaseicms = txt;		
	trimjs(cteperinterna);if (txt=='0'){txt='';};cteperinterna = txt;		
	trimjs(cteperinter);if (txt=='0'){txt='';};cteperinter = txt;		
	trimjs(cteperpartilha);if (txt=='0'){txt='';};cteperpartilha = txt;		
	trimjs(ctevalicmsini);if (txt=='0'){txt='';};ctevalicmsini = txt;		
	trimjs(ctevalicmsfim);if (txt=='0'){txt='';};ctevalicmsfim = txt;		
	trimjs(cteperpobreza);if (txt=='0'){txt='';};cteperpobreza = txt;		
	trimjs(ctevalpobreza);if (txt=='0'){txt='';};ctevalpobreza = txt;		
	trimjs(cteadcfisco);if (txt=='0'){txt='';};cteadcfisco = txt;		
	

	trimjs(ctecargaval);if (txt=='0'){txt='';};ctecargaval = txt;		
	trimjs(ctepropredominante);if (txt=='0'){txt='';};ctepropredominante = txt;		
	trimjs(cteoutcaracteristica);if (txt=='0'){txt='';};cteoutcaracteristica = txt;		
	trimjs(ctecobrancanum);if (txt=='0'){txt='';};ctecobrancanum = txt;		
	trimjs(ctecobrancaval);if (txt=='0'){txt='';};ctecobrancaval = txt;		
	trimjs(ctecobrancades);if (txt=='0'){txt='';};ctecobrancades = txt;		
	trimjs(ctecobrancaliq);if (txt=='0'){txt='';};ctecobrancaliq = txt;		
	trimjs(cterntrc);if (txt=='0'){txt='';};cterntrc = txt;		
	//trimjs(cteentrega);if (txt=='0'){txt='';};cteentrega = txt;		
	trimjs(cteindlocacao);if (txt=='0'){txt='';};cteindlocacao = txt;		
	trimjs(cteciot);if (txt=='0'){txt='';};cteciot = txt;		
	trimjs(cteobsgeral);if (txt=='0'){txt='';};cteobsgeral = txt;		
	
	trimjs(ctechaveref);if (txt=='0'){txt='';};ctechaveref = txt;		
	trimjs(ctechavefin);if (txt=='0'){txt='';};ctechavefin = txt;		
	trimjs(ctedatatomador);if (txt=='0'){txt='';};ctedatatomador = txt;		
	
	//trimjs(ctesubstipo);if (txt=='0'){txt='';};ctesubstipo = txt;		
	trimjs(ctesubschave);if (txt=='0'){txt='';};ctesubschave = txt;		
	
	trimjs(ctechave);if (txt=='0'){txt='';};ctechave = txt;
	
	trimjs(cidtom);if (txt=='0'){txt='';};cidtom = txt;
	trimjs(cidrem);if (txt=='0'){txt='';};cidrem = txt;
	trimjs(ciddes);if (txt=='0'){txt='';};ciddes = txt;
	trimjs(cidrec);if (txt=='0'){txt='';};cidrec = txt;
	trimjs(cidexp);if (txt=='0'){txt='';};cidexp = txt;
	
	trimjs(sefazchave);if (txt=='0'){txt='';};sefazchave = txt;
	trimjs(sefazemissao);if (txt=='0'){txt='';};sefazemissao = txt;
	trimjs(sefazrecebto);if (txt=='0'){txt='';};sefazrecebto = txt;
	trimjs(sefazstatus);if (txt=='0'){txt='';};sefazstatus = txt;
	trimjs(sefazprotocolo);if (txt=='0'){txt='';};sefazprotocolo = txt;
	trimjs(sefazcancchave);if (txt=='0'){txt='';};sefazcancchave = txt;
	trimjs(sefazcancemissao);if (txt=='0'){txt='';};sefazcancemissao = txt;
	trimjs(sefazcancrecebto);if (txt=='0'){txt='';};sefazcancrecebto = txt;
	trimjs(sefazcancstatus);if (txt=='0'){txt='';};sefazcancstatus = txt;
	trimjs(sefazcancprotocolo);if (txt=='0'){txt='';};sefazcancprotocolo = txt;
	
	trimjs(inutmotivo);if (txt=='0'){txt='';};inutmotivo = txt;
	trimjs(inutdata);if (txt=='0'){txt='';};inutdata = txt;
	
	numero_correto = orcamento;

	$("orcnumero").value=orcamento;
	$("modelo").value=modelo;
	$("serie").value=serie;
	$("numero").value=numero;
	$("orcemissao").value=emissao;
	$("orchora").value=hora;
	$("orcchave").value=ctechave;
	$("cfop").value=ctecfop;
	$("natureza").value=ctenatureza; 
	
	$("chave").value=ctechaveref;
	$("chavefin").value=ctechavefin;
	$("datatomador").value=ctedatatomador;
	
	itemcombomodal(tmocodigo);
	itemcomboservico(sercodigo);
	itemcombofinalidade(tctcodigo);
	verificaFinalidade(tctcodigo);
	itemcombopagto(tpgcodigo);
	itemcomboforma(tfocodigo);
	
	//itemcomboestado(cteufemissao);
	//itemcomboestadoini(cteufinicio);
	//itemcomboestadofim0(cteuffinal);
	
	dadospesquisacidade0(cteufemissao,ctecidemissao);		
	dadospesquisacidadeini0(cteufinicio,ctecidinicio);
	dadospesquisacidadefim0(cteuffinal,ctecidfinal);
	
	

	if  (cteemipessoa==1){
		document.getElementById("radio11").checked=true;
		$("forcnpj").disabled = false;
		$("forie").disabled = false;
		$("forrg").value = "";
		$("forcpf").value = "";
		$("forrg").disabled = true;
		$("forcpf").disabled = true;
	}
	else
	{
		document.getElementById("radio12").checked=true;
		$("forcnpj").disabled = true;
		$("forie").disabled = true;
		$("forcnpj").value = "";
		$("forie").value = "";
		$("forrg").disabled = false;
		$("forcpf").disabled = false;
	}
	
	
	
	$("forcnpj").value=cteemicnpj;
	$("forie").value=cteemiie;
	$("forcpf").value=cteemicpf;
	$("forrg").value=cteemirg;
	$("fornguerra").value=cteeminguerra;
	$("forrazao").value=cteemirazao;
	$("fnecep").value=cteemicep;
	$("fneendereco").value=cteemiendereco;
	$("fnenumero").value=cteeminumero;
	$("fnebairro").value=cteemibairro;
	$("fnecomplemento").value=cteemicomplemento;
	$("fnefone").value=cteemifone;
	$("fnepais").value=cteemipais;
	$("fneuf").value=cteemiuf;
	$("fnecodcidade").value=cteemicidcodigo;
	$("fnecidade").value=ctecidemi;

	
	$("tomnguerra").value=ctetomnguerra;
	$("tomrazao").value=ctetomrazao;
	$("tomcep").value=ctetomcep;
	$("tomendereco").value=ctetomendereco;
	$("tomnumero").value=ctetomnumero;
	$("tombairro").value=ctetombairro;
	$("tomcomplemento").value=ctetomcomplemento;
	$("tomfone").value=ctetomfone;
	$("tompais").value=ctetompais;
	$("tomuf").value=ctetomuf;
	
	
	itemcombotomserv(tomcodigo); 

	
	if  (ctetompessoa==1){
		document.getElementById("radiotom11").checked=true;
		$("tomcnpj").disabled = false;
		$("tomie").disabled = false;
		$("tomrg").value = "";
		$("tomcpf").value = "";
		$("tomrg").disabled = true;
		$("tomcpf").disabled = true;
	}
	else
	{
		document.getElementById("radiotom12").checked=true;
		$("tomcnpj").disabled = true;
		$("tomie").disabled = true;
		$("tomcnpj").value = "";
		$("tomie").value = "";
		$("tomrg").disabled = false;
		$("tomcpf").disabled = false;
	}
	
	dadospesquisavertomador(tomcodigo);
	
	$("tomcnpj").value=ctetomcnpj;
	$("tomie").value=ctetomie;
	$("tomcpf").value=ctetomcpf;
	$("tomrg").value=ctetomrg;
	$("tomcidade").value=cidtom;
	
	$("tomcodcidade").value=tomcidcodigo;
	
	
	

	
	$("remnguerra").value=cteremnguerra;
	$("remrazao").value=cteremrazao;
	$("remcep").value=cteremcep;
	$("remendereco").value=cteremendereco;
	$("remnumero").value=cteremnumero;
	$("rembairro").value=cterembairro;
	$("remcomplemento").value=cteremcomplemento;
	$("remfone").value=cteremfone;
	$("rempais").value=cterempais;
	$("remuf").value=cteremuf;
	
	
	itemcomboremserv(remcodigo); 
		
	
	if  (cterempessoa==1){
		document.getElementById("radiorem11").checked=true;
		$("remcnpj").disabled = false;
		$("remie").disabled = false;
		$("remrg").value = "";
		$("remcpf").value = "";
		$("remrg").disabled = true;
		$("remcpf").disabled = true;
	}
	else
	{
		document.getElementById("radiorem12").checked=true;
		$("remcnpj").disabled = true;
		$("remie").disabled = true;
		$("remcnpj").value = "";
		$("remie").value = "";
		$("remrg").disabled = false;
		$("remcpf").disabled = false;
	}
	
	dadospesquisaverremetente(remcodigo);
	
	$("remcnpj").value=cteremcnpj;
	$("remie").value=cteremie;
	$("remcpf").value=cteremcpf;
	$("remrg").value=cteremrg;
	$("remcidade").value=cidrem;
	
	$("remcodcidade").value=remcidcodigo;
	
	
	
	
	
	$("expnguerra").value=cteexpnguerra;
	$("exprazao").value=cteexprazao;
	$("expcep").value=cteexpcep;
	$("expendereco").value=cteexpendereco;
	$("expnumero").value=cteexpnumero;
	$("expbairro").value=cteexpbairro;
	$("expcomplemento").value=cteexpcomplemento;
	$("expfone").value=cteexpfone;
	$("exppais").value=cteexppais;
	$("expuf").value=cteexpuf;
	
	itemcomboexpserv(expcodigo); 
		
	
	if  (cteexppessoa==1){
		document.getElementById("radioexp11").checked=true;
		$("expcnpj").disabled = false;
		$("expie").disabled = false;
		$("exprg").value = "";
		$("expcpf").value = "";
		$("exprg").disabled = true;
		$("expcpf").disabled = true;
	}
	else
	{
		document.getElementById("radioexp12").checked=true;
		$("expcnpj").disabled = true;
		$("expie").disabled = true;
		$("expcnpj").value = "";
		$("expie").value = "";
		$("exprg").disabled = false;
		$("expcpf").disabled = false;
	}
	
	dadospesquisaverexpedidor(expcodigo);
	
	$("expcnpj").value=cteexpcnpj;
	$("expie").value=cteexpie;
	$("expcpf").value=cteexpcpf;
	$("exprg").value=cteexprg;
	$("expcidade").value=cidexp;	
	
	$("expcodcidade").value=expcidcodigo;
	

	


	$("recnguerra").value=cterecnguerra;
	$("recrazao").value=cterecrazao;
	$("reccep").value=ctereccep;
	$("recendereco").value=cterecendereco;
	$("recnumero").value=cterecnumero;
	$("recbairro").value=cterecbairro;
	$("reccomplemento").value=ctereccomplemento;
	$("recfone").value=cterecfone;
	$("recpais").value=cterecpais;
	$("recuf").value=cterecuf;
	
	itemcomborecserv(reccodigo);      
		
	
	if  (cterecpessoa==1){
		document.getElementById("radiorec11").checked=true;
		$("reccnpj").disabled = false;
		$("recie").disabled = false;
		$("recrg").value = "";
		$("reccpf").value = "";
		$("recrg").disabled = true;
		$("reccpf").disabled = true;
	}
	else
	{
		document.getElementById("radiorec12").checked=true;
		$("reccnpj").disabled = true;
		$("recie").disabled = true;
		$("reccnpj").value = "";
		$("recie").value = "";
		$("recrg").disabled = false;
		$("reccpf").disabled = false;
	}
	
	dadospesquisaverrecebedor(reccodigo);
	
	$("reccnpj").value=ctereccnpj;
	$("recie").value=cterecie;
	$("reccpf").value=ctereccpf;
	$("recrg").value=cterecrg;
	$("reccidade").value=cidrec;	
	
	$("reccodcidade").value=reccidcodigo;

	$("desnguerra").value=ctedesnguerra;
	$("desrazao").value=ctedesrazao;
	$("descep").value=ctedescep;
	$("desendereco").value=ctedesendereco;
	$("desnumero").value=ctedesnumero;
	$("dessuframa").value=ctedessuframa;
	$("desbairro").value=ctedesbairro;
	$("descomplemento").value=ctedescomplemento;
	$("desfone").value=ctedesfone;
	$("despais").value=ctedespais;
	$("desuf").value=ctedesuf;
	
	itemcombodesserv(descodigo);      
		
	
	if  (ctedespessoa==1){
		document.getElementById("radiodes11").checked=true;
		$("descnpj").disabled = false;
		$("desie").disabled = false;
		$("desrg").value = "";
		$("descpf").value = "";
		$("desrg").disabled = true;
		$("descpf").disabled = true;
	}
	else
	{
		document.getElementById("radiodes12").checked=true;
		$("descnpj").disabled = true;
		$("desie").disabled = true;
		$("descnpj").value = "";
		$("desie").value = "";
		$("desrg").disabled = false;
		$("descpf").disabled = false;
	}
	
	dadospesquisaverdestinatario(descodigo);
	
	$("descnpj").value=ctedescnpj;
	$("desie").value=ctedesie;
	$("descpf").value=ctedescpf;
	$("desrg").value=ctedesrg;
	$("descidade").value=ciddes;	

	$("descodcidade").value=descidcodigo;	
	

	itemcombosituacao(sitcodigo);
	
	itemcombopartilha(cteperpartilha);
	
	if  (ctepreencheicms==1){
		document.getElementById("opcao_icms1").checked=true;
	}
	else
	{
		document.getElementById("opcao_icms1").checked=false;
	}
	
	verificatipoicms(ctepreencheicms);
	
	//checkbox                 
	//" name="opcao_icms1" id="opcao_icms1" value="1" align="absmiddle" tabIndex='10' onclick="verificatipoicms(this.value);">Preencher o ICMS devido para UF de término do serviço de Transporte</td>
    //maxlength="10" size="18" style="text-align:right;" value="" onblur="format_val(this.value,this.id);" tabIndex='1'></td>
	
	
	format_val2(cteservicos);
	$("valorservico").value=grnum;	
	
	format_val2(ctereceber);
	$("valorreceber").value=grnum;
	
	format_val2(ctebaseicms);
	$("interbase").value=grnum;
	
	format_val2(ctetributos);
	$("valortributos").value=grnum;
	
	format_val2(cteperinterna);	
	$("interpercterm").value=grnum;
		
	//<select name="situacao" onChange="dadospesquisaversituacao(this.value);" tabIndex='3'>&nbsp;<option id="situacao" value="0">________________________________</option></select></td>
	
	format_val2(cteperinter);	
	$("interpercinter").value=grnum;
	
	format_val2(cteperreducao);		
	$("reducao").value=grnum;
	
	//<select name="partilha" tabindex='14' disabled>&nbsp;<option id="partilha" value="0">_____________</option></select></td>
	
	format_val2(ctebasecalculo);		
	$("baseicms").value=grnum;
	
	format_val2(ctevalicmsini);		
	$("intervalini").value=grnum;
	
	format_val2(ctepericms);		
	$("percicms").value=grnum;
	
	format_val2(ctevalicmsfim);		
	$("intervalfim").value=grnum;
	
	format_val2(ctevalicms);		
	$("valoricms").value=grnum;
	
	format_val2(cteperpobreza);		
	$("interpercpobr").value=grnum;
	
	format_val2(ctecredito);		
	$("valorcredito").value=grnum;
	
	format_val2(ctevalpobreza);		
	$("intervalpobr").value=grnum;

	$("adcfisco").value=cteadcfisco;
	

	trimjs(cterntrc);if (txt=='0'){txt='';};cterntrc = txt;		
	trimjs(cteentrega);if (txt=='0'){txt='';};cteentrega = txt;		
	trimjs(cteindlocacao);if (txt=='0'){txt='';};cteindlocacao = txt;		
	trimjs(cteciot);if (txt=='0'){txt='';};cteciot = txt;		
	trimjs(cteobsgeral);if (txt=='0'){txt='';};cteobsgeral = txt;		
	
	format_val2(ctecargaval);		
	$("valorcarga").value=grnum;
	
	$("produtopre").value=ctepropredominante;
	$("produtoout").value=cteoutcaracteristica;
	
	/*
	$("segresp").value=cteadcfisco;
	$("segnome").value=cteadcfisco;
	$("segapolice").value=cteadcfisco;
	$("segaverba").value=cteadcfisco;
	$("segvalor").value=cteadcfisco;
	$("nfechave").value=cteadcfisco;
	$("nfepin").value=cteadcfisco;
	*/
	
	$("cobnumero").value=ctecobrancanum;
	
	format_val2(ctecobrancaval);		
    $("cobvalor").value=grnum;
	
	format_val2(ctecobrancades);		
    $("cobdesconto").value=grnum;
	
	format_val2(ctecobrancaliq);		
    $("cobliquido").value=grnum;
	
	$("gerrntrc").value=cterntrc;
    $("gerentrega").value=cteentrega;
	
	itemcombolotacao(cteindlocacao);

	$("gerciot").value=cteciot;
	
	$("obsgeral").value=cteobsgeral;
	
	
	$("sefazchave").value=sefazchave;
	$("sefazemissao").value=sefazemissao;
	$("sefazrecebto").value=sefazrecebto;
	$("sefazstatus").value=sefazstatus;
	$("sefazprotocolo").value=sefazprotocolo;
	$("sefazcancchave").value=sefazcancchave;
	$("sefazcancemissao").value=sefazcancemissao;
	$("sefazcancrecebto").value=sefazcancrecebto;
	$("sefazcancstatus").value=sefazcancstatus;
	$("sefazcancprotocolo").value=sefazcancprotocolo;
	
	$("inutmotivo").value=inutmotivo;
	$("inutdata").value=inutdata;	
	
	carregaseguroOK2();
	carreganotaOK2();
	carregapedagioOK2();
	carregaveiculoOK2();
    carregamotoristaOK2();
    carregacontribuinteOK2();
	carregafiscoOK2();
	
	
	gctetomuf = ctetomuf;
	gtomcidcodigoibge = tomcidcodigoibge; 	//dadospesquisaibgetom(ctetomuf,tomcidcodigoibge); 
	
	gcteremuf = cteremuf;
	gremcidcodigoibge = remcidcodigoibge;
	
	gcteexpuf = cteexpuf;
	gexpcidcodigoibge = expcidcodigoibge;

	gcterecuf = cterecuf;
	greccidcodigoibge = reccidcodigoibge;
	
	gctedesuf = ctedesuf;
	gdescidcodigoibge = descidcodigoibge;
	
	dadospesquisaibgeemi(cteemiuf,cteemicidcodigoibge);
	
	
	
	if (tctcodigo==4){
	
		$("radio111").disabled = false;	
		$("radio112").disabled = false;	
		$("radio113").disabled = false;	
		$("chaveacesso").disabled = false;	
		if (ctesubstipo==1){
			document.getElementById("radio111").checked=true;
		}
		else if (ctesubstipo==1){
			document.getElementById("radio112").checked=true;
		}
		else{
			document.getElementById("radio113").checked=true;
		}
		$("chaveacesso").value=ctesubschave;
	}
	else
	{
		document.getElementById("radio111").checked=true;
		$("radio111").disabled = true;	
		$("radio112").disabled = true;	
		$("radio113").disabled = true;	
		$("chaveacesso").disabled = true;	
		$("chaveacesso").value = '';
	}
	
	
	
	
	
}



function itemcombomodal(valor){

	y = document.forms[0].modal.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].modal.options[i].selected = true;
		var l = document.forms[0].modal;
  		var li = l.options[l.selectedIndex].value;
		
		if(li==valor){
			i=y;
		}

	}
}

function itemcomboservico(valor){

	y = document.forms[0].servico.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].servico.options[i].selected = true;
		var l = document.forms[0].servico;
  		var li = l.options[l.selectedIndex].value;
		
		if(li==valor){
			i=y;
		}

	}
}

function itemcombofinalidade(valor){

	y = document.forms[0].finalidade.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].finalidade.options[i].selected = true;
		var l = document.forms[0].finalidade;
  		var li = l.options[l.selectedIndex].value;
		
		if(li==valor){
			i=y;
		}

	}
}

function itemcombopagto(valor){

	y = document.forms[0].pagto.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].pagto.options[i].selected = true;
		var l = document.forms[0].pagto;
  		var li = l.options[l.selectedIndex].value;
		
		if(li==valor){
			i=y;
		}

	}
}

function itemcomboforma(valor){

	y = document.forms[0].forma.options.length;

	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].forma.options[i].selected = true;
		var l = document.forms[0].forma;
  		var li = l.options[l.selectedIndex].value;
		
		if(li==valor){
			i=y;
		}

	}
}





function dadospesquisaibgeemi(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].cidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("cidcodigoibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
 
      
		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			   
			      
			      processXMLibgeemi(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('cidadeibge').innerHTML = '<option id="cidcodigoibge" value="0">____________________________________</option>';
				   dadospesquisaibgetom(gctetomuf,gtomcidcodigoibge);
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgeemi(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].cidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "cidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].cidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].cidadeibge.options.add(novo);

            document.forms[0].cidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].cidadeibge.selected;
		}
		document.getElementById("cidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('cidadeibge').value = ufibge;
	}
	
	
	itemcomboibgeemi(valor2);
	
}


function itemcomboibgeemi(valor){

	
	y = document.forms[0].cidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].cidadeibge.options[i].selected = true;
		var l = document.forms[0].cidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
	
	//alert(2);
	dadospesquisaibgetom(gctetomuf,gtomcidcodigoibge);
	
}


function itemcombotomserv(valor)
{

	//alert(valor);
	y = document.forms[0].tomador.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].tomador.options[i].selected = true;
		var l = document.forms[0].tomador;
		// var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		
		//alert(li);
		
		if(li==valor)
		{
			i=y;
		}
	}
}


function itemcomboestadofim0(valor){
	y = document.forms[0].estadofim.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estadofim.options[i].selected = true;
		var l = document.forms[0].estadofim;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}
	//dadospesquisacidadefim0(valor,0);
}

   function dadospesquisacidadefim0(valor,valor2) {

	  itemcomboestadofim0(valor);

      //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidadefim = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidadefim = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidadefim = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidadefim = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidadefim) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidadefim.options.length = 1;

		 idOpcaoCidfim  = document.getElementById("cidadefim");

       		
		 ajax2Cidadefim.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidadefim.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidadefim.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidadefim.readyState == 1) {
			   idOpcaoCidfim.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidadefim.readyState == 4 ) {
			   if(ajax2Cidadefim.responseXML) {
			   			    			 
			      processXMLcidadefim0(ajax2Cidadefim.responseXML,valor2);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCidfim.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidadefim.send(params);
      }
	  	 
   }



   function processXMLcidadefim0(obj,valor2){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidadefim.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidadefim");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidadefim.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCidfim.innerHTML = "____________________";

	  }
	  
	  itemcombocidadefim0(valor2);	  
	    
   }

function itemcombocidadefim0(valor){


	y = document.forms[0].cidadefim.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidadefim.options[i].selected = true;
		var l = document.forms[0].cidadefim;
		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}			
	}
	
	
}



function dadospesquisaibgetom(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].tomcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("tomcidadeibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			      processXMLibgetom(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('tomcidadeibge').innerHTML = '<option id="tomcidcodigoibge" value="0">____________________________________</option>';
				   dadospesquisaibgerem(gcteremuf,gremcidcodigoibge);
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgetom(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].tomcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "tomcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].tomcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].tomcidadeibge.options.add(novo);

            document.forms[0].tomcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].tomcidadeibge.selected;
		}
		document.getElementById("tomcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('tomcidadeibge').value = ufibge;
	}
	
	
	itemcomboibgetom(valor2);
	
}


function itemcomboibgetom(valor){

	
	y = document.forms[0].tomcidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].tomcidadeibge.options[i].selected = true;
		var l = document.forms[0].tomcidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
	
	
	//alert(gcteremuf +  '   '  +  gremcidcodigoibge);
	
	dadospesquisaibgerem(gcteremuf,gremcidcodigoibge);
	
}



function itemcomboremserv(valor)
{

	//alert(valor);
	y = document.forms[0].remetente.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].remetente.options[i].selected = true;
		var l = document.forms[0].remetente;
		// var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		
		//alert(li);
		
		if(li==valor)
		{
			i=y;
		}
	}
}




function dadospesquisaibgerem(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].remcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("remcidadeibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			      processXMLibgerem(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('remcidadeibge').innerHTML = '<option id="remcidcodigoibge" value="0">____________________________________</option>';
				   dadospesquisaibgeexp(gcteexpuf,gexpcidcodigoibge);
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerem(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].remcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "remcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].remcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].remcidadeibge.options.add(novo);

            document.forms[0].remcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].remcidadeibge.selected;
		}
		document.getElementById("remcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('remcidadeibge').value = ufibge;
	}
	
	
	itemcomboibgerem(valor2);
	
}


function itemcomboibgerem(valor){

	
	y = document.forms[0].remcidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].remcidadeibge.options[i].selected = true;
		var l = document.forms[0].remcidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
	
	dadospesquisaibgeexp(gcteexpuf,gexpcidcodigoibge);
	
}











function itemcomboexpserv(valor)
{

	//alert(valor);
	y = document.forms[0].expedidor.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].expedidor.options[i].selected = true;
		var l = document.forms[0].expedidor;
		// var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		
		//alert(li);
		
		if(li==valor)
		{
			i=y;
		}
	}
	
	
	
}




function dadospesquisaibgeexp(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].expcidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("expcidadeibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			      processXMLibgeexp(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('expcidadeibge').innerHTML = '<option id="expcidcodigoibge" value="0">____________________________________</option>';
				   dadospesquisaibgerec(gcterecuf,greccidcodigoibge);
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgeexp(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].expcidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "expcidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].expcidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].expcidadeibge.options.add(novo);

            document.forms[0].expcidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].expcidadeibge.selected;
		}
		document.getElementById("expcidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('expcidadeibge').value = ufibge;
	}
	
	
	itemcomboibgeexp(valor2);
	
}


function itemcomboibgeexp(valor){

	
	y = document.forms[0].expcidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].expcidadeibge.options[i].selected = true;
		var l = document.forms[0].expcidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
	
	
	dadospesquisaibgerec(gcterecuf,greccidcodigoibge);
	
}





function itemcomborecserv(valor)
{

	//alert(valor);
	y = document.forms[0].recebedor.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].recebedor.options[i].selected = true;
		var l = document.forms[0].recebedor;
		// var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		
		//alert(li);
		
		if(li==valor)
		{
			i=y;
		}
	}
	
	
	
}







function dadospesquisaibgerec(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].reccidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("reccidadeibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			      processXMLibgerec(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('reccidadeibge').innerHTML = '<option id="reccidcodigoibge" value="0">____________________________________</option>';
				   dadospesquisaibgedes(gctedesuf,gdescidcodigoibge);
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgerec(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].reccidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "reccidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].reccidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].reccidadeibge.options.add(novo);

            document.forms[0].reccidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].reccidadeibge.selected;
		}
		document.getElementById("reccidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('reccidadeibge').value = ufibge;
	}
	
	
	itemcomboibgerec(valor2);
	
}


function itemcomboibgerec(valor){

	
	y = document.forms[0].reccidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].reccidadeibge.options[i].selected = true;
		var l = document.forms[0].reccidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
	
	
	dadospesquisaibgedes(gctedesuf,gdescidcodigoibge);
	
}





function itemcombodesserv(valor)
{

	//alert(valor);
	y = document.forms[0].destinatario.options.length;

	for(var i = 0 ; i < y ; i++)
	{
	    document.forms[0].destinatario.options[i].selected = true;
		var l = document.forms[0].destinatario;
		// var li = l.options[l.selectedIndex].text;
  		var li = l.options[l.selectedIndex].value;
		
		//alert(li);
		
		if(li==valor)
		{
			i=y;
		}
	}
	
	
	
}







function dadospesquisaibgedes(valor,valor2)
{

		
	// verifica se o browser tem suporte a ajax
	try
	{
    	ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
    catch(e)
    {
    	try
    	{
        	ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try
        	{
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc)
	        {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
		}
	}
	// se tiver suporte ajax
	if(ajax2)
	{
		
		// deixa apenas o elemento 1 no option, os outros são excluídos
		document.forms[0].descidadeibge.options.length = 1;

		var idOpcaoendx1  = document.getElementById("descidadeibge");

        ajax2.open("POST", "cidadesibge.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1)
			{
			   idOpcaoendx1.innerHTML = "Carregando...!";
	        }
			
			
			
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				
			   if(ajax2.responseXML)
			   {
			      processXMLibgedes(ajax2.responseXML,valor2);
			   }
			   else
			   {
			       // caso não seja um arquivo XML emite a mensagem abaixo
				   $('descidadeibge').innerHTML = '<option id="descidcodigoibge" value="0">____________________________________</option>';
			   }
			}
		}
        var params = "parametro="+valor;
        ajax2.send(params);
	}
}

function processXMLibgedes(obj,valor2)
{

	

	// document.forms[0].listcidades.options.length = 0;
    // document.forms[0].listbairros.options.length = 0;
    var dataArray   = obj.getElementsByTagName("dadoib");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
		document.forms[0].descidadeibge.options.length = 0;
        for(var i = 0 ; i < dataArray.length ; i++)
        {
            var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var codigoib  =  item.getElementsByTagName("codigoib")[0].firstChild.nodeValue;
			var cidadeib 	=  item.getElementsByTagName("cidadeib")[0].firstChild.nodeValue;

			trimjs(codigoib);
      		var codigo = txt;
			trimjs(cidadeib);
			var cidade  = txt;

         	// idOpcao.innerHTML = "";
			
			if(i==0)
			{
				// cria um novo option dinamicamente
				var novo = document.createElement("option");
			
				// atribui um ID a esse elemento
			    novo.setAttribute("id", "descidcodigoibge");
				// atribui um valor
			    novo.value = "0";
				// atribui um texto
			    novo.text  = "Escolha uma Cidade";
				// finalmente adiciona o novo elemento
				document.forms[0].descidadeibge.options.add(novo);
			}
			
			// cria um novo option dinamicamente
			var novo = document.createElement("option");

		    // atribui um ID a esse elemento
		    novo.setAttribute("id", "cidcodigoibge");
			// atribui um valor
		    novo.value = codigoib;
			// atribui um texto
		    novo.text  = cidadeib;
			// finalmente adiciona o novo elemento
			document.forms[0].descidadeibge.options.add(novo);

            document.forms[0].descidadeibge.disabled=false;
            // if(ufibge == codigoib)
            // document.forms[0].descidadeibge.selected;
		}
		document.getElementById("descidcodigoibge").disabled = false;
	}
	// else
	// {
		// caso o XML volte vazio, printa a mensagem abaixo
    // var cidcodigoibge = document.getElementById("cidcodigoibge");
	// cidcodigoibge.innerHTML = "____________________";
	// document.getElementById("cidcodigoibge").disabled = true;
	// }
	
	
	if(ufibge != "")
	{
	$('descidadeibge').value = ufibge;
	}
	
	
	itemcomboibgedes(valor2);
	
}


function itemcomboibgedes(valor){

	
	y = document.forms[0].descidadeibge.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].descidadeibge.options[i].selected = true;
		var l = document.forms[0].descidadeibge;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
}




function itemcombosituacao(valor){

	
	y = document.forms[0].situacao.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].situacao.options[i].selected = true;
		var l = document.forms[0].situacao;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
}


function itemcombopartilha(valor){

	
	y = document.forms[0].partilha.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].partilha.options[i].selected = true;
		var l = document.forms[0].partilha;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
}




function itemcombolotacao(valor){

	y = document.forms[0].lotacao.options.length;
	
	for(var i = 0 ; i < y ; i++) {

	    document.forms[0].lotacao.options[i].selected = true;
		var l = document.forms[0].lotacao;
  		var li = l.options[l.selectedIndex].value;
	
		
		if(li==valor){
			i=y;
		}

	}
}




function format_val2(rnum)
{

	if(rnum.indexOf(',')!=-1)
	{
		rnum = rnum.replace(",",".");		
	}
	
	if (isNaN(rnum)==true){
		grnum = 0;
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
	   	
		grnum = valor2;
		
	}
	else if(rnum <= 0)
   	{		
		valor2='0.00';
	   	
		grnum = valor2;
		
	}
	
}   


function carregaseguroOK2()
{
	//$("tab4").checked = true;	
	new ajax ('infoseguroseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_serv});	
}

function carreganotaOK2()
{
	//$("tab4").checked = true;	
	new ajax ('infonfeseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_nota});	
}


function carregapedagioOK2()
{
	//$("tab5").checked = true;	
	new ajax ('infopedagioseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_pedagio});	
	
}

function carregaveiculoOK2()
{
	//$("tab5").checked = true;	
	new ajax ('infoveiculoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_veiculo});	
	
}

function carregamotoristaOK2()
{
	//$("tab5").checked = true;		
	new ajax ('infomotseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_motorista});	
	
}

function carregacontribuinteOK2()
{
	//$("tab6").checked = true;	
	new ajax ('obscontribuinteseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_contr});	
}

function carregafiscoOK2()
{
	//$("tab6").checked = true;	
	new ajax ('obsfiscoseleciona.php?usucodigo='+ vusuario
        , {onComplete: imprime_fisco});	
}



function dadospesquisacidade0(valor,valor2) {

	  itemcomboestado0(valor);	

      //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidade = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidade = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidade = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidade = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidade) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidade.options.length = 1;

		 idOpcaoCid  = document.getElementById("cidade");

       		
		 ajax2Cidade.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidade.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidade.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidade.readyState == 1) {
			   idOpcaoCid.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidade.readyState == 4 ) {
			   if(ajax2Cidade.responseXML) {
			   			    			 
			      processXMLcidade0(ajax2Cidade.responseXML,valor2);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCid.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidade.send(params);
      }
	  	 
   }



   function processXMLcidade0(obj,valor){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidade.options.length = 0;

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidade");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidade.options.add(novo);

		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCid.innerHTML = "____________________";

	  }
	  
	  itemcombocidade0(valor);	  
	    
   }
   
function itemcombocidade0(valor){
	y = document.forms[0].cidade.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidade.options[i].selected = true;
		var l = document.forms[0].cidade;
		var li = l.options[l.selectedIndex].value;  		
		if(li==valor){
			i=y;
		}			
	}
}   



function dadospesquisacidadeini0(valor,valor2) {

	  itemcomboestadoini0(valor);

	  //verifica se o browser tem suporte a ajax
	  try {
         ajax2Cidadeini = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e) {
         try {
            ajax2Cidadeini = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax2Cidadeini = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2Cidadeini = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax2Cidadeini) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.forms[0].cidadeini.options.length = 1;

		 idOpcaoCidIni  = document.getElementById("cidadeini");

       		
		 ajax2Cidadeini.open("POST", "ibgepesquisacidade.php", true);
		 ajax2Cidadeini.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		 ajax2Cidadeini.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax2Cidadeini.readyState == 1) {
			   idOpcaoCidIni.innerHTML = "Carregando...!";
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax2Cidadeini.readyState == 4 ) {
			   if(ajax2Cidadeini.responseXML) {
			   			    			 
			      processXMLcidadeini0(ajax2Cidadeini.responseXML,valor2);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcaoCidIni.innerHTML = "____________________";
			   }
            }
         }
		 //passa o parametro
	     var params = "parametro="+valor;
         ajax2Cidadeini.send(params);
      }
	  	 
   }



   function processXMLcidadeini0(obj,valor){
      //pega a tag dado
      var dataArray   = obj.getElementsByTagName("dado");

	  //total de elementos contidos na tag dado
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
		 
		

	document.forms[0].cidadeini.options.length = 0;
	

         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(codigo);
	       	codigo = txt;
			trimjs(descricao);
			descricao  = txt;

	        
			//cria um novo option dinamicamente
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "cidadeini");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.forms[0].cidadeini.options.add(novo);
			
	
		 }
		 

		itemcombocidadeini0(valor);	  

		 
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
	    idOpcaoCidIni.innerHTML = "____________________";

	  }
	  
	  
  
   }
   
function itemcombocidadeini0(valor){

	y = document.forms[0].cidadeini.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].cidadeini.options[i].selected = true;
		var l = document.forms[0].cidadeini;
		var li = l.options[l.selectedIndex].value;
		if(li==valor){
			i=y;
		}			
	}
}   



function load_pedido(vusu,numcte)
{	

	vusuario = vusu;

	if(numcte==''){
		carregaCte = 0;
	}
	else {
		carregaCte = numcte;
	}	

	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
        }
    }
	
	  // se tiver suporte ajax
	if(ajax2)
	{	  	

		ajax2.open("POST", "apagatemp.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{			
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{					
			    	processXMLapagaped(ajax2.responseXML,vusu);
			   	}
				else {
					alert('Erro ao apagar as tabelas temporarias!');
				}				
			}
		}
  
        var params = "parametro="+vusu;

        if(vusu!="")		
        ajax2.send(params);
		
	}
	
}   


function processXMLapagaped(obj,vusu)
{
	
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{		

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML 

			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
	
		}
	}		
	
	load_pedido2(vusu);
}	



//------------- Número do pedido e Data --------// 
function load_pedidopesq0(cte,usu0)
{
    
	//window.open('apagatemp2.php?cte=' + cte + "&parametro="+ usu0, "_blank");

	new ajax('apagatemp2.php?cte=' + cte + "&parametro="+ usu0, {onComplete: load_pedidopesq(cte)});
	
	
}






function excluirorcamento(num,vusu)
{	


	if(confirm("Tem certeza que deseja excluir o CTe?\n\t") )
	{
	//alert(num);

		// verifica se o browser tem suporte a ajax
		try {
			 ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e)
		{
			try {
				ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(ex)
			{
				try {
				   ajax2 = new XMLHttpRequest();
				}
				catch(exc) {
				   alert("Esse browser não tem recursos para uso do Ajax");
				   ajax2 = null;
				}
			}
		}
		 
		  // se tiver suporte ajax
		if(ajax2)
		{	  	

			ajax2.open("POST", "apagapedido.php", true);
			ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			ajax2.onreadystatechange = function()
			{			
				if(ajax2.readyState == 4 )
				{
					if(ajax2.responseXML)
					{					
						processXMLapagapedido(ajax2.responseXML,num);
					}
					else {
						alert('Erro ao apagar as tabelas temporarias!');
					}				
				}
			}
	  

			var params = "parametro="+vusu+'&parametro2='+num;

			if(num!="")		
			ajax2.send(params);
			
		}
	
	}
	
}   

  
function processXMLapagapedido(obj,num)
{
	
	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{		

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML 

			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;

			trimjs(descricao);if (txt=='0'){txt='';};descricao = txt;
	
		}
	}		
	
	alert('CTe numero ' + num + ' excluido!');
	
	window.open('alterarcte.php', '_self');
	
}	


function Imprimir(num,vusu)
{

	var valor = 0;

	var params = "parametro="+num;

    window.open('relatoriocte.php?' + params, '_blank' );
	
}

 


function Imprimirxml2(num,vusu)
{


	dadospesquisaparam(1,num);

	/*
	var valor = 0;

	var params = "parametro="+num;

    //window.open('relatorioctexml.php?' + params, '_blank' );

	new ajax('relatorioctexml.php?' + params, {onComplete: imprime_xml});
	
	//alert('Geração XML ainda não disponível');
	*/
	
}   

function imprime_xml(request)
{
    
	var xmldoc=request.responseXML;
	
	var chaveCte = '';
	var erroCte = '';
	
    if(xmldoc!=null)
	{
		var dados = xmldoc.getElementsByTagName('dados')[0];		
	
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			if(itens[0].firstChild.data!=null)
			{
           		if(itens[0].firstChild.data!='_'){ 
					chaveCte = itens[0].firstChild.data;
					$("orcchave").value=itens[0].firstChild.data;
                }
				if(itens[1].firstChild.data!='_'){ 
					erroCte = itens[1].firstChild.data;			
                }	
            }
		}		
		
	}
	
	if(erroCte!=''){	
		erroCte = erroCte.replace(/_/g, '\n');
		
		alert('Não foi possivel gerar o XML devido aos erros:' + '\n' + '\n' + erroCte + '\n');
	}
	else {	
		if(chaveCte=='' || chaveCte=='_'){
			alert('Problema na geração do XML!');
		}
		else {
			alert('XML gerado com sucesso; chave: ' + chaveCte);
		}
	}	
	
}




function verificaFinalidade(codigo){

	if(codigo==0 || codigo==1){
		$("chavefin").disabled = true;	
		$("datatomador").disabled = true;	
		$("chavefin").value = '';	
		$("datatomador").value = '';	
	}
	else if(codigo==2 || codigo==4){
		$("chavefin").disabled = false;	
		$("datatomador").disabled = true;			
		$("datatomador").value = '';	
	}
	else {
		$("chavefin").disabled = false;	
		$("datatomador").disabled = false;		
	}
	

	if(codigo==4)
	{
		$("radio111").disabled = false;	
		$("radio112").disabled = false;	
		$("radio113").disabled = false;	
		$("chaveacesso").disabled = false;	
	}
	else
	{
		$("radio111").disabled = true;	
		$("radio112").disabled = true;	
		$("radio113").disabled = true;	
		$("chaveacesso").disabled = true;	
		$("chaveacesso").value = '';
	}
		
	

}



function fechar1()
{
	
	
    window.open('maxwms.php', '_self' );
	
}



function Imprimirxml(num,vusu)
{

	var erro = 0;

	//tomador
	if (document.forms[0].tomador.value==5){
	
		if ( document.getElementById("radiotom11").checked==true){
			trimjs(document.getElementById('tomcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Tomador')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('tomcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Tomador')
				erro = 1;
			}
			
		}	
		
		
		trimjs(document.getElementById('tomcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Tomador')
			erro = 1;
		}
	
	}
	
	
	//remetente
	if (document.forms[0].remetente.value==1){
	
	
		if ( document.getElementById("radiorem11").checked==true){
			trimjs(document.getElementById('remcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Remetente')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('remcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Remetente')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('remcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Remetente')
			erro = 1;
		}
	
	
	}
	  
	
	//expedidor
	if (document.forms[0].expedidor.value==1){
	
	
		if ( document.getElementById("radioexp11").checked==true){
			trimjs(document.getElementById('expcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Expedidor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('expcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Expedidor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('expcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Expedidor')
			erro = 1;
		}
	
	
	}
	
	
	//recebedor
	if (document.forms[0].recebedor.value==1){
	
	
		if ( document.getElementById("radiorec11").checked==true){
			trimjs(document.getElementById('reccnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Recebedor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('reccpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Recebedor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('reccep').value);
		if (txt==''){
			alert('CEP obrigatório para o Recebedor')
			erro = 1;
		}
	
	
	}	
	  
	  
	
	//destinatario
	if (document.forms[0].destinatario.value==1){
	
	
		if ( document.getElementById("radiodes11").checked==true){
			trimjs(document.getElementById('descnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Destinatario')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('descpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Destinatario')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('descep').value);
		if (txt==''){
			alert('CEP obrigatório para o Destinatario')
			erro = 1;
		}
	
	
	}		  
	  	  
	  
	if (erro==0) {
		
		//Verifica se já foi gerado e se já tem retorno do SEFAZ
		Imprimirxmlverifica(num,vusu);	
		//Imprimirxml2(num,vusu);	
	
	}
	  
	
 
	
}


function Imprimirxmlverifica(num,vusu)
{

	var params = "parametro="+num;    
	new ajax('verificactexml.php?' + params, {onComplete: imprime_xml_verifica});	
	
}   

function imprime_xml_verifica(request)
{
    
	var xmldoc=request.responseXML;
	
	var auxChave = '';
	var auxProtocolo = '';
	var auxRecebto = '';
	var auxMotivo = '';
	
    if(xmldoc!=null)
	{
		var dados = xmldoc.getElementsByTagName('dados')[0];		
	
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			if(itens[0].firstChild.data!=null)
			{
           		if(itens[0].firstChild.data!='_'){ 
					auxChave = itens[0].firstChild.data;					
                }
				if(itens[1].firstChild.data!='_'){ 
					auxProtocolo = itens[1].firstChild.data;			
                }
				if(itens[2].firstChild.data!='_'){ 
					auxRecebto = itens[2].firstChild.data;			
                }
				if(itens[3].firstChild.data!='_'){ 
					auxMotivo = itens[3].firstChild.data;			
                }	
            }
		}		
		
	}
	
	var mensagem = '';
	var cabecalho = '';
	var pergunta = '';
	
	//Situacao 1 - Já foi autorizado o Uso no SEFAZ
	if(auxMotivo=='AUTORIZADO O USO DO CT-E'){
		alert("Já autorizado o uso deste CT-e pelo SEFAZ em " + auxRecebto + " ! Não é permitido continuar !" );
	}
	//Situacao 2 - Foi enviado ao SEFAZ mas não está autorizado
	else if(auxMotivo!="AUTORIZADO O USO DO CT-E" && auxMotivo!=""){
		mensagem = "Atenção CT-e já enviado para o SEFAZ em " + auxRecebto;
		cabecalho = " | Status : " + auxMotivo;
		pergunta = "Você realmente tem certeza que deseja fazer a geração de um novo XML?";		
	}
	//Situacao 3 - Não Foi enviado ao SEFAZ mas já tem Chave
	else if(auxChave!=""){
		mensagem = "Atenção já foi gerado XML para este CT-e";
		cabecalho = " | " + auxChave;
		pergunta = "Você realmente tem certeza que deseja fazer a geração de um novo XML?";		
	}
	else {	
		mensagem = "Confirma geração do XML?";
		cabecalho = "";
		pergunta = "";					
	}
	
	if(mensagem!=''){
	
		$a('#dialog').attr('title', 'CT-E : ' + $("numero").value + cabecalho);

		var html = '<p>' +
            '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>' +
            mensagem +
            '</p><form id="formSituacao" name="formSituacao" method="post" action="#">';


		html += '<p>' + pergunta + '</p>';	
			
		$a('#dialog').html(html);

		$a('#dialog').dialog({
			autoOpen: true,
			width: 600,
			modal: true,
			overlay: {
				background: "white"
			},
			buttons:
					{
						"Não": function ()
						{
							$a(this).dialog("close");
						},

						"Sim": function ()
						{

							$a('#dialog').dialog("close");

							Imprimirxml2($("orcnumero").value,vusuario);	


						}

					},
			close: function (ev, ui)
			{
				$a(this).dialog("destroy");
			}


		});

		$a('#dialog').dialog("open");

	}	
		
}


function itemcomboestadoini0(valor){
	y = document.forms[0].estadoini.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estadoini.options[i].selected = true;
		var l = document.forms[0].estadoini;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}
	//dadospesquisacidadeini(valor,0);
}

function itemcomboestado0(valor){
	y = document.forms[0].estado.options.length;
	for(var i = 0 ; i < y ; i++) {	
	    document.forms[0].estado.options[i].selected = true;
		var l = document.forms[0].estado;
		var li = l.options[l.selectedIndex].text;  		
		if(li==valor){
			i=y;
		}			
	}	
	//dadospesquisacidade(valor,0);	
}



function dadospesquisaparam(valor,num)
{


	// verifica se o browser tem suporte a ajax
	try {
         ajax2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e)
    {
    	try {
            ajax2 = new ActiveXObject("Msxml2.XMLHTTP");
        }
	    catch(ex)
	    {
        	try {
               ajax2 = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax2 = null;
            }
         }
      }
	  // se tiver suporte ajax
	  if(ajax2)
	  {
	  	// deixa apenas o elemento 1 no option, os outros são excluídos
		
		ajax2.open("POST", "parametrospesquisa.php", true);
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		ajax2.onreadystatechange = function()
		{
			// enquanto estiver processando...emite a msg de carregando
			if(ajax2.readyState == 1) {
			  
	        }
			// após ser processado - chama função processXML que vai varrer os
			// dados
            if(ajax2.readyState == 4 )
            {
				if(ajax2.responseXML)
				{
					
			    	processXMLparam(ajax2.responseXML,num);
			   	}
			   	else
			   	{
			    	// caso não seja um arquivo XML emite a mensagem abaixo
				  	
			   	}
			}
		}
		
		valor2 = "1";        
        var params = "parametro="+valor+'&parametro2='+valor2;

        if(valor!="")		
        ajax2.send(params);
		//window.open("clientepesquisa.php?" + params);
	}
}






function processXMLparam(obj,num)
{

	numero_controle = num;

	var valor = 0;
	var params = "parametro="+num;

	// pega a tag dado
    var dataArray   = obj.getElementsByTagName("dado");

	// total de elementos contidos na tag dado
	if(dataArray.length > 0)
	{
		// percorre o arquivo XML paara extrair os dados
	

        for(var i = 0 ; i < dataArray.length ; i++)
        {
        	var item = dataArray[i];
			// contéudo dos campos no arquivo XML
			var descricao7 	=  item.getElementsByTagName("descricao7")[0].firstChild.nodeValue;
			var descricao8 	=  item.getElementsByTagName("descricao8")[0].firstChild.nodeValue;
		
			trimjs(descricao7);if (txt=='0'){txt='';};descricao7 = txt;
			trimjs(descricao8);if (txt=='0'){txt='';};descricao8 = txt;

			if(i==0)     
			{
				
			
				
				if (descricao7=='1'){

					if (descricao8=='1'){
						
						//new ajax('relatorioctexmlass.php?' + params, {onComplete: imprime_xml});
						//window.open('relatorioctexmlass.php?' + params, '_blank' );	
						
						$("tab1").checked = false;	
						$("tab2").checked = false;
						$("tab3").checked = false;
						$("tab4").checked = false;
						$("tab5").checked = false;
						$("tab6").checked = false;
						$("tab7").checked = false;	
						novaJanelaXML("relatorioctexmlass.php?" + params, "Gerando arquivo XML");	
						
					}
					else
					{
						new ajax('relatorioctexml.php?' + params, {onComplete: imprime_xml});
					}
					
				}
				else
				{

					if (descricao8=='1'){
						//new ajax('relatorioctexml2ass.php?' + params, {onComplete: imprime_xml}); 
						//window.open('relatorioctexml2ass.php?' + params, '_blank' );
						
						$("tab1").checked = false;
						$("tab2").checked = false;
						$("tab3").checked = false;
						$("tab4").checked = false;
						$("tab5").checked = false;
						$("tab6").checked = false;
						$("tab7").checked = false;		
						novaJanelaXML("relatorioctexml2ass.php?" + params, "Gerando arquivo XML");	
						
					}
					else
					{
						new ajax('relatorioctexml2.php?' + params, {onComplete: imprime_xml});
					}					
					
				}	

				
			}
		}
		
	}
	else
	{
		
	}
}





function Imprimirproceda(num,vusu)
{

	var erro = 0;

	//tomador
	if (document.forms[0].tomador.value==5){
	
		if ( document.getElementById("radiotom11").checked==true){
			trimjs(document.getElementById('tomcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Tomador')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('tomcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Tomador')
				erro = 1;
			}
			
		}	
		
		
		trimjs(document.getElementById('tomcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Tomador')
			erro = 1;
		}
	
	}
	
	
	//remetente
	if (document.forms[0].remetente.value==1){
	
	
		if ( document.getElementById("radiorem11").checked==true){
			trimjs(document.getElementById('remcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Remetente')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('remcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Remetente')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('remcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Remetente')
			erro = 1;
		}
	
	
	}
	  
	
	//expedidor
	if (document.forms[0].expedidor.value==1){
	
	
		if ( document.getElementById("radioexp11").checked==true){
			trimjs(document.getElementById('expcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Expedidor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('expcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Expedidor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('expcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Expedidor')
			erro = 1;
		}
	
	
	}
	
	
	//recebedor
	if (document.forms[0].recebedor.value==1){
	
	
		if ( document.getElementById("radiorec11").checked==true){
			trimjs(document.getElementById('reccnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Recebedor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('reccpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Recebedor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('reccep').value);
		if (txt==''){
			alert('CEP obrigatório para o Recebedor')
			erro = 1;
		}
	
	
	}	
	  
	  
	
	//destinatario
	if (document.forms[0].destinatario.value==1){
	
	
		if ( document.getElementById("radiodes11").checked==true){
			trimjs(document.getElementById('descnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Destinatario')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('descpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Destinatario')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('descep').value);
		if (txt==''){
			alert('CEP obrigatório para o Destinatario')
			erro = 1;
		}
	
	
	}	  	  
	  
	if (erro==0) {	
		if(confirm("Confirma geração do arquivo Proceda?\n\t") )
		{
			window.open('relatoriocteproceda.php?cte=' + num, '_blank' );	
		}	
	}
	
	
}

function Imprimirdatasul(num,vusu)
{

	var erro = 0;

	//tomador
	if (document.forms[0].tomador.value==5){
	
		if ( document.getElementById("radiotom11").checked==true){
			trimjs(document.getElementById('tomcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Tomador')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('tomcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Tomador')
				erro = 1;
			}
			
		}	
		
		
		trimjs(document.getElementById('tomcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Tomador')
			erro = 1;
		}
	
	}
	
	
	//remetente
	if (document.forms[0].remetente.value==1){
	
	
		if ( document.getElementById("radiorem11").checked==true){
			trimjs(document.getElementById('remcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Remetente')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('remcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Remetente')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('remcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Remetente')
			erro = 1;
		}
	
	
	}
	  
	
	//expedidor
	if (document.forms[0].expedidor.value==1){
	
	
		if ( document.getElementById("radioexp11").checked==true){
			trimjs(document.getElementById('expcnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Expedidor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('expcpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Expedidor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('expcep').value);
		if (txt==''){
			alert('CEP obrigatório para o Expedidor')
			erro = 1;
		}
	
	
	}
	
	
	//recebedor
	if (document.forms[0].recebedor.value==1){
	
	
		if ( document.getElementById("radiorec11").checked==true){
			trimjs(document.getElementById('reccnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Recebedor')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('reccpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Recebedor')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('reccep').value);
		if (txt==''){
			alert('CEP obrigatório para o Recebedor')
			erro = 1;
		}
	
	
	}	
	  
	  
	
	//destinatario
	if (document.forms[0].destinatario.value==1){
	
	
		if ( document.getElementById("radiodes11").checked==true){
			trimjs(document.getElementById('descnpj').value);
       		if (txt==''){
				alert('CNPJ obrigatório para o Destinatario')
				erro = 1;
			}
			
		}
		else{
			trimjs(document.getElementById('descpf').value);
       		if (txt==''){
				alert('CPF obrigatório para o Destinatario')
				erro = 1;
			}
			
		}	
		
		trimjs(document.getElementById('descep').value);
		if (txt==''){
			alert('CEP obrigatório para o Destinatario')
			erro = 1;
		}
	
	
	}	  	  
	  
	if (erro==0) {	
		if(confirm("Confirma geração do arquivo Datasul?\n\t") )
		{
			window.open('relatorioctedatasul.php?cte=' + num, '_blank' );	
		}	
	}
	
	
}





function novaJanelaXML(href,t)
{
	
	$a.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		//height: (325),
		//width: (600),
		
		height: (500),
		width: (980),
		
		animation: true,
		overlay_clickable: false,
		callback: callbackXML,
		caption: t
	});
	 
	$a('#dialog').dialog("open");
	
}

function  callbackXML()
{
	carregaXML();
}
 
function carregaXML()
{


	$("tab1").checked = true;	
	

	new ajax('relatorioctexmlchave.php?parametro=' + numero_controle, {onComplete: imprime_XML1});
	

}

function imprime_XML1(request){

		
	var xmldoc=request.responseXML;
	
	if(xmldoc!=null)
	{
		var dados = xmldoc.getElementsByTagName('dados')[0];		
	
		var registros = xmldoc.getElementsByTagName('registro');
		
		
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[0].getElementsByTagName('item');
						
			var chavecte = itens[0].firstChild.data;
			
			if (chavecte!='_'){
				$("orcchave").value=chavecte;
			}
			else
			{
				$("orcchave").value="";
			}
			
		}		
	}
	else {
		//alert("_"); 
	}


}
