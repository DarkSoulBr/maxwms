// JavaScript Document   
var liberped = 0;
var modo = 3;

var vercor = 0;

var t = '';
var vfpedido = '';

var nivel = 0; 

var opcao1 = 0;
var opcao2 = 0;
var opcao3 = 0;
var opcao4 = 0;

var email = '';

 
var codigox = 0;
var codx = 0;
var descricaox = 0;
var	textox = 0;

var	usuario1 = 0;

var pviest011x=1;
var tipoestoque = 0;
var msg = '';

var finalizar=0;

var liber = 0; 
var liberX = 0;

var flagx = 0;

var vetorx = '';

var vet = new Array(5000);

for(var i = 0 ; i < 5000 ; i++) {
   vet[i] = new Array(40);
}

for(var i = 0 ; i < 5000 ; i++) {
	   vet[i][0]=0;
	   vet[i][1]=0;
	   vet[i][2]=0;
	   vet[i][3]=0;
	   vet[i][4]=0;
	   vet[i][5]=0;
	   vet[i][6]=0;
	   vet[i][7]=0;
	   vet[i][8]=0;
	   vet[i][9]=0;
	   vet[i][10]=0;
	   vet[i][11]=0;
	   vet[i][12]=0;
	   vet[i][13]=0;
	   vet[i][14]=0;
	   vet[i][15]=0;
	   vet[i][16]=0;
	   vet[i][17]=0;
	   vet[i][18]=0;
	   vet[i][19]=0;
	   vet[i][20]=0;
	   vet[i][21]=0;
	   vet[i][22]=0;
	   vet[i][23]=0;
	   vet[i][24]=0;
	   vet[i][25]=0;
	   vet[i][26]=0;
	   vet[i][27]=0;
	   vet[i][28]=0;
	   vet[i][29]=0;
	   vet[i][30]=0;
	   vet[i][31]=0;
	   vet[i][32]=0;
	   vet[i][33]=0;
	   vet[i][34]=0;
	   vet[i][35]=0;
	   vet[i][36]=0;
	   vet[i][37]=0;
	   vet[i][38]=0;
	   vet[i][39]=0;
	   vet[i][40]=0;	   
}

function inicia(usuario,flag,dataInicio,horaInicio,dataFim,horaFim,vx,pagina,cancelados)
{
	
	if (flag==1){
		
		document.getElementById("dataInicio").value=dataInicio;
		document.getElementById("horaInicio").value=horaInicio;
		document.getElementById("dataFim").value=dataFim;
		document.getElementById("horaFim").value=horaFim;
		document.getElementById("pagina").value = pagina;
		
		if(cancelados==1){
			document.getElementById("chkcanc").checked=true;
		}
		else {
			document.getElementById("chkcanc").checked=false;
		}
		
		vetorx = vx;
		
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );	
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );
		vetorx = vetorx.replace( "_", "&" );	

	}
	
	flagx = flag;
	
	usuario1 = usuario;
	nivel = 0;
	load_grid_tipopedido();
	//new ajax('admpedidousuario.php?usuario='+usuario, {onComplete: verificanivel});

}


function verificanivel(request)
{
    
	
	
	var xmldoc=request.responseXML;
	
    if(xmldoc!=null)
	{
		var dados = xmldoc.getElementsByTagName('dados')[0];
		
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++)
		{
			var itens = registros[i].getElementsByTagName('item');
			if(itens[0].firstChild.data!=null)
			{
           		nivel = itens[0].firstChild.data;				
            }
		}
		
	}	
	
	load_grid_tipopedido();
	
}

//------------ Tipo de Pedido -------------------------//
function load_grid_tipopedido()
{
	
	/*
	tiposPedido = new Array();
	var multiple = $('.populaTipoPedidos').attr('multiple');
	var opcoes = '<option value="">Carregando ...</option>';
		
	$('.populaTipoPedidos').html(opcoes);

	//Envia os dados via metodo post
	$.post('admdemandastatus.php',
	{}, 
	function(data)
	{
		opcoes = '';
		
		if (Boolean(Number(data.retorno)))
		{
			statusDemanda = data.statusDemandas;
			
			if (multiple)
			{
				opcoes += "<option value=\"\" selected>TODOS OS STATUS</option>";
			}
			else
			{
				opcoes += "<option value=\"\">Selecione o Status</option>";
			}
	
			$.each(statusDemanda, function (key, value)
			{			
				
				opcoes += '<option value="' + value.codigo + '">' + value.descricao + '</option>';
				
			});
			opcoes += '<option value="' + 999 + '">' + 'SEM INTERACAO' + '</option>';
			
		}
		else
		{
			opcoes += '<option value="">Não carregou lista! Contate Admin!</option>';
		}
		
		$('.populaTipoPedidos').html(opcoes);
	}, "json");
	
	//load_grid_estoque();
	*/
	
	if (flagx==1){
	   imprimirconsulta();
	   flagx=0;
	}
	
}


function imprimirconsulta(){

		$("#accordion h3 a:first").click(function()
        {

            //location.reload(true)
			
			window.open('admcte.php?flag=0', '_self');
			
			
//            window.open('tracking.php?flag=1', '_self');
        });

/*
	if (nivel!=2){
	   alert("O usuario deve ser nível 2!");
	   //return;
	}
*/	

	/*
	if (document.getElementById("opcao_modo1").checked==true){
	   modo = 1;
	}
	else if (document.getElementById("opcao_modo2").checked==true){
	   modo = 2;
	}
	else{
	   modo = 3;
	}
	*/

	modo = 3;

	for(var i = 0 ; i < 5000 ; i++) {
		   vet[i][0]=0;
		   vet[i][1]=0;
		   vet[i][2]=0;
		   vet[i][3]=0;
		   vet[i][4]=0;
		   vet[i][5]=0;
		   vet[i][6]=0;
		   vet[i][7]=0;
		   vet[i][8]=0;
		   vet[i][9]=0;
		   vet[i][10]=0;
		   vet[i][11]=0;
		   vet[i][12]=0;
		   vet[i][13]=0;
		   vet[i][14]=0;
		   vet[i][15]=0;
		   vet[i][16]=0;
		   vet[i][17]=0;
		   vet[i][18]=0;
		   vet[i][19]=0;
		   vet[i][20]=0;
		   vet[i][21]=0;
		   vet[i][22]=0;
		   vet[i][23]=0;
		   vet[i][24]=0;
		   vet[i][25]=0;
		   vet[i][26]=0;
		   vet[i][27]=0;
		   vet[i][28]=0;
		   vet[i][29]=0;
		   vet[i][30]=0;
		   vet[i][31]=0;
		   vet[i][32]=0;
		   vet[i][33]=0;
		   vet[i][34]=0;
		   vet[i][35]=0;
		   vet[i][36]=0;
		   vet[i][37]=0;
		   vet[i][38]=0;
		   vet[i][39]=0;
		   vet[i][40]=0;		   
	}

	var chk1 = 0;		
	if(document.getElementById("chkcanc").checked==true){chk1=1;}
	

	var horaInicio = $('#horaInicio').val();
	var horaFim = $('#horaFim').val();
		
	nivelUsuario = nivel;
	

	
	var aTipo = new Array();
	var aEstoque = new Array();
		
	var nTipo = 0;
	var nEstoque = 0;
	
	var campovet1="";
	var campovet2="";

	
	titulo = "PROCESSANDO, AGUARDE...";
    mensagem = "EXECUTANDO PESQUISA DE CTE.";
	
	var campovet1="";
	var campovet2="";	
	
	
	var dataInicio = $('#dataInicio').val();
	dataInicio = dataInicio.substring(6,10) + '-' + dataInicio.substring(3,5) + '-' + dataInicio.substring(0,2) + ' ' + horaInicio;
	
	var dataFim = $('#dataFim').val();
	dataFim = dataFim.substring(6,10) + '-' + dataFim.substring(3,5) + '-' + dataFim.substring(0,2) + ' ' + horaFim;
		
    $("#retorno").messageBoxModal(titulo, mensagem);
	
	new ajax('admcteconsultapaginas.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+'&usuario='+usuario1+'&cancelados='+chk1+campovet1  , {onLoading: carregando, onComplete: imprimepagina});
	
	//window.open('admcteconsultapaginas.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+'&usuario='+usuario1+'&cancelados='+chk1+campovet1  , '_blank');
			
}

function imprimepagina(request) {

    var xmldoc = request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];
    var paginas = 0;
    if (dados != null)
    {
        var registros = xmldoc.getElementsByTagName('registro');
        var itens = registros[0].getElementsByTagName('item');
        paginas = itens[0].firstChild.data;
    }
    
    //Carrega combo das Páginas
    document.getElementById('listpaginas').options.length = 0;
    //var tabela = '<select id="lispaginas" name="listpaginas" size="' + i +'">';
    for (var i = 1; i <= paginas; i++)
    {        
        var novo = document.createElement("option");        
        novo.setAttribute("id", "opcoespaginas");        
        novo.value = i;   
        if(i<10){
            novo.text = '0' + i;
        }
        else {
            novo.text = i;
        }        
        document.getElementById('listpaginas').options.add(novo);        
    }  
    
    var pagina = document.getElementById("pagina").value;
    
    //Posiciona na Pagina
    y = document.getElementById("listpaginas").options.length;

    for (var i = 0; i < y; i++)
    {    
        var verifica = i + 1;
        if(verifica==pagina){
            document.getElementById("listpaginas").options[i].selected = true;        
        }
    }
        
    var chk1 = 0;		
	if(document.getElementById("chkcanc").checked==true){chk1=1;}
	

	var horaInicio = $('#horaInicio').val();
	var horaFim = $('#horaFim').val();
		
	nivelUsuario = nivel;
	

	
	var aTipo = new Array();
	var aEstoque = new Array();
		
	var nTipo = 0;
	var nEstoque = 0;
	
	var campovet1="";
	var campovet2="";
	
	var dataInicio = $('#dataInicio').val();
	dataInicio = dataInicio.substring(6,10) + '-' + dataInicio.substring(3,5) + '-' + dataInicio.substring(0,2) + ' ' + horaInicio;
	
	var dataFim = $('#dataFim').val();
	dataFim = dataFim.substring(6,10) + '-' + dataFim.substring(3,5) + '-' + dataFim.substring(0,2) + ' ' + horaFim;
	
	new ajax('admcteconsulta.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+ '&pagina=' + pagina +'&usuario='+usuario1+'&cancelados='+chk1+campovet1  , {onLoading: carregando, onComplete: imprime});	
	//window.open('admcteconsulta.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+ '&pagina=' + pagina +'&usuario='+usuario1+'&cancelados='+chk1+campovet1  , '_blank');	
    
}


function carregando(){

	document.getElementById('msg').style.visibility="visible";
	document.getElementById('btnConsultaPedidos').disabled=true;
	
}

function atualizapedido(npedido){
   
   titulo = "PROCESSANDO, AGUARDE...";
   mensagem = "ATUALIZANDO CTE.";

    $("#retorno").messageBoxModal(titulo, mensagem);
   
   new ajax('admcteconsulta.php?npedido='+npedido+'&usuario='+usuario1, {onLoading: carregando, onComplete: atualizavetor});
   
      
}

function atualizavetor(request){

    var xmldoc=request.responseXML;
    var dados = xmldoc.getElementsByTagName('dados')[0];
	if(dados!=null) 
	{
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){
		    
			var itens = registros[i].getElementsByTagName('item');
			
			
			for(i2=0;i2<5000;i2++){
				if(vet[i2][1]==itens[1].firstChild.data && itens[1].firstChild.data!=0){					
					//Comeca do 1 para nao alterar a sequencia
					for(j=1;j<itens.length;j++){					
						vet[i2][j]=itens[j].firstChild.data;												
					}			
					i2=5000;
				}
			}			
			if(i2==5001){
				imprime2();				
			}
			else {
				callback2();
			}	
			
		}
	}

}

function imprime(request){

    document.getElementById('msg').style.visibility="hidden"; 
	document.getElementById('btnConsultaPedidos').disabled=false;

    $("#accordion").accordion( "activate" , 1);

	//$("msg").style.visibility="hidden";
	var xmldoc=request.responseXML;

    var dados = xmldoc.getElementsByTagName('dados')[0];

	if(dados!=null) 
	{
		
		var width = (screen.width*0.8);
		var numLinha = 0;

		var codHtml = "<table id='listaAgendamentos' border='0' cellpadding='0' cellspacing='0'>";
		codHtml +=  "<tbody>";
		
		var tabela="";
		
		var registros = xmldoc.getElementsByTagName('registro');
		for(i=0;i<registros.length;i++){

			var itens = registros[i].getElementsByTagName('item');
			tabela+="<tr id=linha"+i+">"
			
			for(j=0;j<itens.length;j++){
				vet[i][j]=itens[j].firstChild.data;
			}
				
			var codHtmlTmp = '';
			var cor = itens[27].firstChild.data;
			
			var vpvnumero = itens[1].firstChild.data;												
			
			codHtml += "<tr style='background: "+cor+";' id="+vpvnumero+"><td >"+itens[0].firstChild.data+"</td>";
							
			//Número da Demanda terá Link para a opção de Alteração que ainda será criada.
			t = 'MANUTENCAO_CTE';
			var consultaPedido = '<a href=javascript:novaJanela("alterarcte.php?numcte='+vpvnumero+'","'+t+'") title="MANUTENÇÃO DE CTE" tooltip="CLIQUE PARA ALTERAR CTE." class="greybox" id="dvPedido"'+vpvnumero+'" name="consulta" >'+vpvnumero+'</a>';				
			
			codHtml += "<td onClick='func("+vpvnumero+")' > "+consultaPedido+"</td>";
			
			codHtml +="<td ><span id='dvSerie"+vpvnumero+"'>"+itens[2].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvNum"+vpvnumero+"'>"+itens[3].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvEmissao"+vpvnumero+"'>"+itens[4].firstChild.data+"</span></td>";			
			codHtml +="<td ><span id='dvHora"+vpvnumero+"'>"+itens[5].firstChild.data+"</span></td>";	

			codHtml +="<td ><span id='dvnf"+vpvnumero+"'>"+itens[28].firstChild.data+"</span></td>";	
			
			if(itens[30].firstChild.data=='_'){
				codHtml +="<td ><span id='dvprotocolo"+vpvnumero+"'></span></td>";
			}
			else {
				codHtml +="<td ><span id='dvprotocolo"+vpvnumero+"'>"+itens[30].firstChild.data+"</span></td>";
			}
			if(itens[31].firstChild.data=='_'){
				codHtml +="<td ><span id='dvsefaz"+vpvnumero+"'></span></td>";	
			}
			else {
				codHtml +="<td ><span id='dvsefaz"+vpvnumero+"'>"+itens[31].firstChild.data+"</span></td>";	
			}
			if(itens[32].firstChild.data=='_'){
				codHtml +="<td ><span id='dvpdf"+vpvnumero+"'></span></td>";	
			}
			else {
				var urlPDF = '<a href=javascript:gerapdf("' + itens[32].firstChild.data + '") ><img width="16px" src="images/pdf.png" border="0" title="PDF" align="absmiddle"></a>';	
				codHtml +="<td ><span id='dvpdf"+vpvnumero+"'>"+urlPDF+"</span></td>";	
			}
			if(itens[33].firstChild.data=='_'){
				codHtml +="<td ><span id='dvxml"+vpvnumero+"'></span></td>";
			}
			else {
				var urlXML = '<a href=javascript:geraxml("' + itens[33].firstChild.data + '") ><img width="16px" src="images/xml.png" border="0" title="XML" align="absmiddle"></a>';
				codHtml +="<td ><span id='dvxml"+vpvnumero+"'>"+urlXML+"</span></td>";
			}
			
			
			
			
			
			codHtml +="<td ><span id='dvCfop"+vpvnumero+"'>"+itens[6].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvModal"+vpvnumero+"'>"+itens[7].firstChild.data+"</span></td>";					
			codHtml +="<td ><span id='dvServico"+vpvnumero+"'>"+itens[8].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvFinalidade"+vpvnumero+"'>"+itens[9].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvLocalEmissao"+vpvnumero+"'>"+itens[10].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvLocalInicio"+vpvnumero+"'>"+itens[11].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvLocalFinal"+vpvnumero+"'>"+itens[12].firstChild.data+"</span></td>";			
			codHtml +="<td ><span id='dvEmitente"+vpvnumero+"'>"+itens[13].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvTomador"+vpvnumero+"'>"+itens[14].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvRemetente"+vpvnumero+"'>"+itens[15].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvExpedidor"+vpvnumero+"'>"+itens[16].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvRecebedor"+vpvnumero+"'>"+itens[17].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvDestinatario"+vpvnumero+"'>"+itens[18].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvServicos"+vpvnumero+"'>"+itens[19].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvReceber"+vpvnumero+"'>"+itens[20].firstChild.data+"</span></td>";
			codHtml +="<td ><span id='dvTributos"+vpvnumero+"'>"+itens[21].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvProduto"+vpvnumero+"'>"+itens[22].firstChild.data+"</span></td>";		
			codHtml +="<td ><span id='dvValor"+vpvnumero+"'>"+itens[23].firstChild.data+"</span></td>";			
			
			codHtml +="<td ><span id='dvdtcanc"+vpvnumero+"'>"+itens[29].firstChild.data+"</span></td>";	
			
			codHtml +="<td ><span id='dvVeiculo"+vpvnumero+"'>"+itens[24].firstChild.data+"</span></td>";			
			codHtml +="<td ><span id='dvMotorista"+vpvnumero+"'>"+itens[25].firstChild.data+"</span></td>";			
			codHtml +="<td ><span id='dvObs"+vpvnumero+"'>"+itens[26].firstChild.data+"</span></td>";			
			
			/*
			t = 'EXCLUI_DEMANDA';
			var excluiPedido = '<a href=javascript:novaJanela2("excluirdemanda.php?dmnumero='+vpvnumero+'","'+t+'") title="EXCLUI DEMANDA" tooltip="CLIQUE PARA EXCLUIR DEMANDA." class="greybox" id="dvPedido"'+vpvnumero+'" name="consulta" >EXCLUIR</a>';				
						   
			codHtml += "<td onClick='funcEx("+vpvnumero+")' > "+excluiPedido+"</td>";			
			*/
			
			if(codHtmlTmp.length > 1)
			{
				codHtml += "<td  id='detalhar"+numLinha+"' onclick='mostrar("+numLinha+");'>+</td>";
			}
			else {
				codHtml += "<td> </td>";
			}
			codHtml += "</tr>";

				
				 for (z = codHtmlTmp.length; z > 0; z--) {
					count = z-2;
						if(count< 0){
							break;
						}
					codHtml += codHtmlTmp[count];
					}

			numLinha++;
			
		}
		
		codHtml += 	"</tbody></table>";
		$("#accordion").accordion( "activate" , 1);
		$("#tblResultado").html(codHtml);

		width = (screen.width - (((screen.width * 5)/100)*2));
								
		$("#tblResultado").flexigrid(
		{
			width: width,
			height:400,
			striped:false,
			colModel : [
			{
				display: 'SEQ',
				name : 'seq',
				width : width * 0.02,
				align: 'center'
			},

			{
				display: 'No.',
				name : 'ncte',
				width : width * 0.04,
				align: 'center'
			},
						
			{
				display: 'SERIE',
				name : 'serie',
				width : width * 0.03,
				align: 'center'
			},
			
			{
				display: 'NUMERO',
				name : 'numero',
				width : width * 0.07,
				align: 'center'
			},

			{
				display: 'EMISSAO',
				name : 'emissao',
				width : width * 0.07,
				align: 'center'
			},
			
			{
				display: 'HORA',
				name : 'hora',
				width : width * 0.04,
				align: 'center'
			},
			
			
			{
				display: 'NFe',
				name : 'nf',
				width : width * 0.07,
				align: 'center'
			},
			
			{
				display: 'PROTOCOLO',
				name : 'protocolo',
				width : width * 0.10,
				align: 'center'
			},
			
			{
				display: 'SEFAZ',
				name : 'sefaz',
				width : width * 0.20,
				align: 'center'
			},
			
			{
				display: 'PDF',
				name : 'pdf',
				width : width * 0.03,
				align: 'center'
			},
			
			{
				display: 'XML',
				name : 'xml',
				width : width * 0.03,
				align: 'center'
			},

			{
				display: 'CFOP',
				name : 'cfop',
				width : width * 0.04,
				align: 'center'
			},

			{
				display: 'MODAL',
				name : 'modal',
				width : width * 0.10,
				align: 'center'
			},

			{
				display: 'SERVICO',
				name : 'servico',
				width : width * 0.10,
				align: 'center'
			},

			{
				display: 'FINALIDADE',
				name : 'finalidade',
				width : width * 0.10,
				align: 'center'
			},
			
			{
				display: 'LOCAL',
				name : 'local',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'INICIO',
				name : 'inicio',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'TERMINO',
				name : 'termino',
				width : width * 0.12,
				align: 'center'
			},

			{
				display: 'EMITENTE',
				name : 'emitente',
				width : width * 0.12,
				align: 'center'
			},			
			
			{
				display: 'TOMADOR',
				name : 'tomador',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'REMETENTE',
				name : 'remetente',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'EXPEDIDOR',
				name : 'expedidor',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'RECEBEDOR',
				name : 'recebedor',
				width : width * 0.12,
				align: 'center'
			},
			{
				display: 'DESTINATARIO',
				name : 'destinatario',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'SERVICOS',
				name : 'servicos',
				width : width * 0.10,
				align: 'center'
			},
			
			{
				display: 'A RECEBER',
				name : 'areceber',
				width : width * 0.10,
				align: 'center'
			},
			
			{
				display: 'TRIBUTOS',
				name : 'tributos',
				width : width * 0.10,
				align: 'center'
			},
			
			{
				display: 'PRODUTO',
				name : 'produto',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'VALOR',
				name : 'valor',
				width : width * 0.10,
				align: 'center'
			},

			{
				display: 'CANCELAMENTO',
				name : 'dtcanc',
				width : width * 0.08,
				align: 'center'
			},
			
			{
				display: 'INUTILIZACAO',
				name : 'veiculo',
				width : width * 0.08,
				align: 'center'
			},
			
			{
				display: 'MOTORISTA',
				name : 'motorista',
				width : width * 0.12,
				align: 'center'
			},
			
			{
				display: 'OBSERVACAO',
				name : 'obs',
				width : width * 0.36,
				align: 'center'
			}			
			

			],
			sortname: "seq",
			sortorder: "asc"

		});
			   

	}
	else
	{
		//$("resultado").innerHTML="Nenhum registro encontrado...";
		tabela = ""
		$('#tblResultado').html(tabela);		
	}	
	
	//alert('xxx');
	//imprime2();
	
	$.unblockUI();
		
}

function geraxml(arq) {
		
	
    var values = new Array(arq,usuario1);
    var keys = new Array("nome", "usuario");           
                
    openWindowWithPost('downloadxmlcte.php', '', keys, values);
    
}

function gerapdf(arq) {		
	
    window.open(arq, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');			
    
}


function imprime2(){


    document.getElementById('msg').style.visibility="hidden"; 
	document.getElementById('btnConsultaPedidos').disabled=false;

    $("#accordion").accordion( "activate" , 1);
	
	
			
	var excluir = 1;
	
	for(i=0;i<5000;i++){
	
		if (vet[i][0]!=0 && vet[i][1]==vfpedido){
		
			excluir = 0;
						
			var cor = vet[i][27];
			
			$("#"+vfpedido).attr("style", "background: " + cor );				
			
			
			$("#dvSerie"+vfpedido).html(vet[i][2]);		
			$("#dvNum"+vfpedido).html(vet[i][3]);		
			$("#dvEmissao"+vfpedido).html(vet[i][4]);		
			$("#dvHora"+vfpedido).html(vet[i][5]);
			$("#dvCfop"+vfpedido).html(vet[i][6]);
			$("#dvModal"+vfpedido).html(vet[i][7]);
			$("#dvServico"+vfpedido).html(vet[i][8]);
			$("#dvFinalidade"+vfpedido).html(vet[i][9]);
			$("#dvLocalEmissao"+vfpedido).html(vet[i][10]);
			$("#dvLocalInicio"+vfpedido).html(vet[i][11]);
			$("#dvLocalFinal"+vfpedido).html(vet[i][12]);
			$("#dvEmitente"+vfpedido).html(vet[i][13]);
			$("#dvTomador"+vfpedido).html(vet[i][14]);
			$("#dvRemetente"+vfpedido).html(vet[i][15]);
			$("#dvExpedidor"+vfpedido).html(vet[i][16]);
			$("#dvRecebedor"+vfpedido).html(vet[i][17]);
			$("#dvDestinatario"+vfpedido).html(vet[i][18]);
			$("#dvServicos"+vfpedido).html(vet[i][19]);
			$("#dvReceber"+vfpedido).html(vet[i][20]);
			$("#dvTributos"+vfpedido).html(vet[i][21]);
			$("#dvProduto"+vfpedido).html(vet[i][22]);
			$("#dvValor"+vfpedido).html(vet[i][23]);
			$("#dvVeiculo"+vfpedido).html(vet[i][24]);
			$("#dvMotorista"+vfpedido).html(vet[i][25]);
			$("#dvObs"+vfpedido).html(vet[i][26]);			
			//$("#dvprotocolo"+vfpedido).html(vet[i][30]);		
			//$("#dvsefaz"+vfpedido).html(vet[i][31]);		
			//$("#dvpdf"+vfpedido).html(vet[i][32]);		
			//$("#dvxml"+vfpedido).html(vet[i][33]);		

			
		}	
		
	}
	
	if(excluir==1){			
		$("#"+vfpedido).hide();		
	}
			
		   
	
	$.unblockUI();
		
		
}







function result(){

	codHtml = "XXXXXX"

	$('#tblResultado').html(codHtml);
					
	$("#accordion").accordion( "activate" , 1);

}
					
function result2(){
	
	$("#accordion").accordion( "activate" , 0);

}

function novaJanela(href,t)
{

	liberped=0;
	
    //alert(href);
    //t = '';
	
	hrefx = href.substring(0,21)
	//alert(hrefx);
	
		

	
	$.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (750),
		width: (1200),
		
		animation: true,
		overlay_clickable: false,
		callback: callback,
		caption: t
	});
	  	 
	 //alert();
	 $('#dialog').dialog("open");
	 
	
}


function  callback()
{

	vercor = 0; 
	
	atualizapedido(vfpedido);
	
}

function func(varfunc)
{
    liber = 0;
	//t =  t1;
	vfpedido = varfunc;
	
	//alert(varfunc);

}


function func2(varfunc)
{
    liber = 1;
	//t =  t1;
	vfpedido = varfunc;
	//alert(varfunc);

}

function func3(varfunc)
{
	liber = 0;
    liberX = 1;
	//t =  t1;
	vfpedido = varfunc;
	//alert(varfunc);

}

function removeitem(codigoitem){

 
	for(var i = 0 ; i < 5000 ; i++) {
	   if (vet[i][2]==codigoitem){
		   vet[i][0]=0;
		   vet[i][1]=0;
		   vet[i][2]=0;
		   vet[i][3]=0;
		   vet[i][4]=0;
		   vet[i][5]=0;
		   vet[i][6]=0;
		   vet[i][7]=0;
		   vet[i][8]=0;
		   vet[i][9]=0;
		   vet[i][10]=0;
		   vet[i][11]=0;
		   vet[i][12]=0;
		   vet[i][13]=0;
		   vet[i][14]=0;
		   vet[i][15]=0;
		   vet[i][16]=0;
		   vet[i][17]=0;
		   vet[i][18]=0;
		   vet[i][19]=0;
		   vet[i][20]=0;
		   vet[i][21]=0;
		   vet[i][22]=0;
		   vet[i][23]=0;
		   vet[i][24]=0;
		   vet[i][25]=0;
		   vet[i][26]=0;
		   vet[i][27]=0;
		   vet[i][28]=0;
		   vet[i][29]=0;
		   vet[i][30]=0;
		   vet[i][31]=0;
		   vet[i][32]=0;
		   vet[i][33]=0;
		   vet[i][34]=0;
		   vet[i][35]=0;
		   vet[i][36]=0;
		   vet[i][37]=0;
		   vet[i][38]=0;
		   vet[i][39]=0;
		   vet[i][40]=0;		   
	   }
	}

	imprime2();
	
}

function trocacor2(cod){
     
	vercor = 1;

    for(i=0;i<5000;i++){
	    if (vet[i][2]==cod){
			if(vet[i][32]!='#F8F8FF'){
			   vet[i][32]='#F8F8FF';
			}
			else
			{
				atualizapedido(cod);
			}
		}
	}

    imprime2();
	
}



function excel(){

	modo = 3;

	for(var i = 0 ; i < 5000 ; i++) {
		   vet[i][0]=0;
		   vet[i][1]=0;
		   vet[i][2]=0;
		   vet[i][3]=0;
		   vet[i][4]=0;
		   vet[i][5]=0;
		   vet[i][6]=0;
		   vet[i][7]=0;
		   vet[i][8]=0;
		   vet[i][9]=0;
		   vet[i][10]=0;
		   vet[i][11]=0;
		   vet[i][12]=0;
		   vet[i][13]=0;
		   vet[i][14]=0;
		   vet[i][15]=0;
		   vet[i][16]=0;
		   vet[i][17]=0;
		   vet[i][18]=0;
		   vet[i][19]=0;
		   vet[i][20]=0;
		   vet[i][21]=0;
		   vet[i][22]=0;
		   vet[i][23]=0;
		   vet[i][24]=0;
		   vet[i][25]=0;
		   vet[i][26]=0;
		   vet[i][27]=0;
		   vet[i][28]=0;
		   vet[i][29]=0;
		   vet[i][30]=0;
		   vet[i][31]=0;
		   vet[i][32]=0;
		   vet[i][33]=0;
		   vet[i][34]=0;
		   vet[i][35]=0;
		   vet[i][36]=0;
		   vet[i][37]=0;
		   vet[i][38]=0;
		   vet[i][39]=0;
		   vet[i][40]=0;		   
	}

	var chk1 = 0;		
	if(document.getElementById("chkcanc").checked==true){chk1=1;}
	
	var horaInicio = $('#horaInicio').val();
	var horaFim = $('#horaFim').val();
		
	nivelUsuario = nivel;
	
	
	var aTipo = new Array();
	var aEstoque = new Array();
		
	var nTipo = 0;
	var nEstoque = 0;
	
		
	var campovet1="";
	var campovet2="";
	
	var dataInicio = $('#dataInicio').val();
	dataInicio = dataInicio.substring(6,10) + '-' + dataInicio.substring(3,5) + '-' + dataInicio.substring(0,2) + ' ' + horaInicio;
	
	var dataFim = $('#dataFim').val();
	dataFim = dataFim.substring(6,10) + '-' + dataFim.substring(3,5) + '-' + dataFim.substring(0,2) + ' ' + horaFim;
		
			
	window.open('admcteexcel.php?dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+'&usuario='+usuario1+'&cancelados='+chk1+campovet1, 'Report', 'status=yes, scrollbars=yes, location=no, toolbar=no, directories=no, resizable=no, fullscreen=yes');
	
	
}


function novaJanela2(href,t)
{


	
	$.GB_show(href,
	{
		//height: (document.body.scrollHeight - 80),
		//width: (document.body.scrollWidth - 30),
		
		height: (750),
		width: (1200),
		
		animation: true,
		overlay_clickable: false,
		callback: callback2,
		caption: t
	});
	  	 
	 //alert();
	 $('#dialog').dialog("open");
	 
	
}


function  callback2()
{
	
	//imprimirconsulta();
	
	
	
	var dataInicio = $('#dataInicio').val();
	var horaInicio = $('#horaInicio').val();
	var dataFim = $('#dataFim').val();
	var horaFim = $('#horaFim').val();

	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );	
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );	
	
	var pagina = document.getElementById("listpaginas").options[document.getElementById("listpaginas").selectedIndex].value;
	
	var chk1 = 0;		
	if(document.getElementById("chkcanc").checked==true){chk1=1;}
	
	window.open('admcte.php?flag=1&dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+'&pagina='+pagina+'&cancelados='+chk1+'&vetorx='+vetorx, '_self');
	
		
}

function  atualizargrid()
{
	
	//imprimirconsulta();
	
	
	
	var dataInicio = $('#dataInicio').val();
	var horaInicio = $('#horaInicio').val();
	var dataFim = $('#dataFim').val();
	var horaFim = $('#horaFim').val();

	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );	
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );
	vetorx = vetorx.replace( "&", "_" );	
	
	var pagina = document.getElementById("listpaginas").options[document.getElementById("listpaginas").selectedIndex].value;
	
	var chk1 = 0;		
	if(document.getElementById("chkcanc").checked==true){chk1=1;}
	
	window.open('admcte.php?flag=1&dataInicio='+dataInicio+'&horaInicio='+horaInicio+'&dataFim='+dataFim+'&horaFim='+horaFim+'&pagina='+pagina+'&cancelados='+chk1+'&vetorx='+vetorx, '_self');
	
		
}

function openWindowWithPost(url, name, keys, values)
{
	
    var winl = (screen.width - 960) / 2;
   
    var newWindow = window.open(url, name, 'status=yes, location=no, toolbar=no, directories=no, height=240,width=440,top=25,left=' + winl + ',scrollbars=yes,resizable=no');

    if (!newWindow)
        return false;

    var html = "";
    html += "<html><head></head><body><form id='formid' method='post' action='" + url + "'>";

    if (keys && values && (keys.length == values.length))
        for (var i = 0; i < keys.length; i++)
            html += "<input type='hidden' name='" + keys[i] + "' value='" + values[i] + "'/>";

    html += "</form><script type='text/javascript'>document.getElementById(\"formid\").submit()</sc" + "ript></body></html>";

    newWindow.document.write(html);
    return newWindow;
}