/**
 * @author Wellington
 *
 * Verificação dos dados para envio de formulario.
 *
 * Criação    18/05/2010
 *
 */ 

//var GB_ANIMATION = true;

$(function()
{
    var msgSelecionadasArray = new Array();
    var pedidoVerLiberacao;
//    var pedidoEnvia;
    
    $("#btnConsultaPedidos").click(function()
    {
        if ($("#formEstoqueFisico").validate().form())
        {
            var dataInicio = new Date().dateBr(($('#dataInicio').val()));
            var horaInicio = $('#horaInicio').val();
            var dataFim = new Date().dateBr(($('#dataFim').val()));
            var horaFim = $('#horaFim').val();
            var anularValidacaoIbge = false;
            var pvlibdep = '';
            var pvlibvit = '';
            var pvlibfil = '';
            var pvlibmat = '';
            //var tipoStatusLiberacao = $("input[type=radio][name=opcaoTipoPesquisa]:checked").val();

            titulo = "PROCESSANDO, AGUARDE...";
            mensagem = "EXECUTANDO PESQUISA DE ESTACIONAMENTO.";

            $("#retorno").messageBoxModal(titulo, mensagem);

            dataInicio.setTimes(horaInicio);
            dataFim.setTimes(horaFim);
            nivelUsuario = Number(usuario.nivel);

            var aTipo = new Array();
            $('#listaTipoPedidos option:selected').each(function()
            {
                if($(this).val())
                {
                    aTipo.push(tiposPedido[$(this).val()].sigla);
                }
            });

            var aEstoque = new Array();
            $('#listaEstoqueFisico option:selected').each(function()
            {
                if($(this).val())
                {
                    aEstoque.push(estoquesFisico[$(this).val()].etqfcodigo);
                }
            });
            /*var aLiberacao = new Array();
			$('#listaTipoLiberacao option:selected').each(function()
			{
				if($(this).val())
				{
					aLiberacao.push(tiposLiberacao[$(this).val()].idpvencer2);
				}
			});*/



            $.post('modulos/vendaAtacado/pedidos/adm/controller/getEstacionamento.php',
            {
                //variaveis a ser enviadas metodo POST

                dataInicio:dataInicio.format("Y-m-d H:i:s"),
                dataFim:dataFim.format("Y-m-d H:i:s"),
                aTipo:JSON.stringify(aTipo),
                aEstoque:JSON.stringify(aEstoque),
                //aLiberacao:JSON.stringify(aLiberacao),
                nivelUsuario:nivelUsuario,
                //tipoStatusLiberacao:tipoStatusLiberacao,
                acao:1
            },
            function(data)
            {
                if (Boolean(Number(data.retorno)))
                {
                    var dataAtual = new Date();
                    var numLinha = 0;

                    var codHtml = "<table id='listaEstoques' border='0' cellpadding='0' cellspacing='0'>"+
                    "<tbody>";
                    resultado = data.aEstacionamento;
                    totalRows = Number(data.rows);

                    $.each(data.aEstacionamento, function (key, value)
                    {
                        var cidade = "";
                        var uf = "";

                        var txtPendencia = "";
                        var cor = "#77DD98";
                        //var cor2 = "#CCCCCC";
                        var cor2 = "#FF1493";
                        var cor3 = "#9370DB";

                        var status = "AUTORIZADO";
                        var status2 = "PENDENTE";
                        var status3 = "NEGADO";
                        var status4 = "NAO AUTORIZADO";

                        var tipoStatus = 0;
                        var stringData = "";

                                           var prazolimiteInt = 0;
                        var prazolimiteCad = 0;
                        var prazolimiteSer = 0;


                        $.each(value.cliente.prazoExpiracao.resultado, function (key, value2){
//                                                                        alert( "value2.pedescricao: "+ value2.pedescricao +"\n value2.peprazo"+value2.peprazo);
                                        if(value2.pedescricao === 'INTERFIX')
                                        {
                                                prazolimiteInt = value2.peprazo;
                                        } else if (value2.pedescricao === 'CADASTRO') {
                                                prazolimiteCad = value2.peprazo;
                                        } else if (value2.pedescricao === 'SERASA') {
                                                prazolimiteSer = value2.peprazo;
                                        }
                        });

                        

//                        var limite = new Date();
//                        limite.setDate(limite.getDate()-180);
//                        limite = new Date(limite);

                        limitePrazo = new Date();
// alert ( "Look a test: "+limitePrazo );
                        limitePrazo.setDate( limitePrazo.getDate() - prazolimiteInt );
                        dataLimiteInt = new Date(limitePrazo);
// alert ( "Look a testInt: "+limitePrazo );
                        limitePrazo = new Date();
                        limitePrazo.setDate( limitePrazo.getDate() - prazolimiteCad );
                        dataLimiteCad = new Date(limitePrazo);
// alert ( "Look a test Cad: "+limitePrazo );
                        limitePrazo = new Date();
                        limitePrazo.setDate( (limitePrazo.getDate()-1) - prazolimiteSer );
                        dataLimiteSer = new Date(limitePrazo);

//if (value.cliente.cliserasaexp) {
if (value.cliente.cliserasa) {
//    var stringData = value.cliente.cliserasaexp;
    stringData = value.cliente.cliserasa;
    var dataSemGMT = stringData.substr(0, 19);

    var tokens = dataSemGMT.split("-");
    var tokens2 = tokens[2].split(" ");
    var tokens3 = tokens2[1].split(":");

    var anoSerasa = tokens[0];
    var mesSerasa = tokens[1]-1;
    var diaSerasa = tokens2[0];
    var horaSerasa = tokens3[0];
    var minutoSerasa = tokens3[1];
    var segundoSerasa = tokens3[2];
}



//                     var dataSerasaExp = value.cliente.cliserasaexp ? new Date().date(value.cliente.cliserasaexp) : '';

//                    var dataSerasaExp = stringData ? new Date(anoSerasa,mesSerasa,diaSerasa,horaSerasa,minutoSerasa,segundoSerasa) : '';
                        var dataSerasaExpTemp = stringData ? new Date(anoSerasa,mesSerasa,diaSerasa,horaSerasa,minutoSerasa,segundoSerasa) : '';
                        var serasaDate = dataSerasaExpTemp ? Number(dataSerasaExpTemp.getDate()) : 0;
                        var dataSerasaLimite =  serasaDate + Number(prazolimiteSer);
                        var dataSerasaExp = dataSerasaExpTemp ? new Date(dataSerasaExpTemp.setDate(dataSerasaLimite)) : '';

//alert("value.cliente.cliserasa: "+value.cliente.cliserasa
//    +"\n stringData: "+stringData
//    +"\n anoSerasa: "+anoSerasa
//    +"\n mesSerasa: "+mesSerasa
//    +"\n diaSerasa: "+diaSerasa
//    +"\n horaSerasa: "+horaSerasa
//    +"\n minutoSerasa: "+minutoSerasa
//    +"\n segundoSerasa: "+segundoSerasa
//    +"\n dataSerasaExp: "+dataSerasaExp
//    +"\n serasaDate: "+serasaDate
//    +"\n dataSerasaLimite: "+dataSerasaLimite
//    +"\n dataSerasaExpTemp: "+dataSerasaExpTemp
//);
                        /*
                         *              limitePrazo.setDate( limitePrazo.getDate() - prazolimiteSer );
                                         dataLimiteSer = new Date(limitePrazo);
                         **/
                        var dataSintegraExp = value.cliente.clisintegradataultimaconsulta ? new Date().date(value.cliente.clisintegradataultimaconsulta) : '';
                        var dataReceitaExp = value.cliente.clireceitadataultimaconsulta ? new Date().date(value.cliente.clireceitadataultimaconsulta) : '';
                        var dataValidaExp = value.cliente.clidatavalida ? new Date().date(value.cliente.clidatavalida) : '';
                        var dataAnulaValidacaoIbge = value.cliente.clilibibgediferente ? new Date().date(value.cliente.clilibibgediferente) : '';

//alert ("value.cliente.cliserasaexp: "+value.cliente.cliserasaexp
//+"\n dataSerasaExp: "+dataSerasaExp
//+"\n novaDataSerasaExp: "+novaDataSerasaExp
//+"\n dataSemGMT: "+dataSemGMT
//+"\n tokens[0]: "+tokens[0]
//+"\n tokens[1]: "+tokens[1]
//+"\n tokens[2]: "+tokens[2]
//+"\n tokens2 [0]: "+tokens2[0]
//+"\n tokens2 [1]: "+tokens2[1]
//+"\n tokens2 [2]: "+tokens2[2]
//+"\n tokens3 [0]: "+tokens3[0]
//+"\n tokens3 [1]: "+tokens3[1]
//+"\n tokens3 [2]: "+tokens3[2]
//);
                        valP = Number(value.pvvalor);
                        valPDesc = Number(value.pvvaldesc);
                        valorPedido = valP - valPDesc;
                        var txtDataSerasa = '';
                        var txtDataSintegra = '';
                        var txtDataReceita = '';
                        var txtDataValidacao = '';
                        var txtCodStatus = '';
                        var txtFormaPgto = '';
                        var z = 0;
                        $.each(value.formaPagto, function (key, valuePagto){
                            var textoPagto = valuePagto;
                            var infPagto = '';
                                 if(textoPagto.match(/VISTA/i)) {
                                    infPagto = 'VI';

                                 } else if(textoPagto.match(/DESCONTOS COMERCIAIS/i)){
                                     infPagto = 'DC';
                                 } else if(textoPagto.match(/DESCONTOS FINANCEIRO/i)) {
                                    infPagto = 'DF';
                                 }
                                 else {
                                     infPagto = textoPagto.substr(0, 3);
                                 }


//                                'DUPLICATAS'
//                                'CHEQUE-PRE'
//                                'ORDEM PAGTO'
//                                'VALES'
//                                'CHEQUE A VISTA'
//                                'CARTAO'
//                                'DESCONTOS COMERCIAIS'
//                                'DESCONTOS FINANCEIRO'
//                                'BRINDES'
                                

                                if(z === 0 ){
                                                txtFormaPgto += "<a tooltip="+textoPagto+" class='greybox' > "+infPagto+"</a>";
                                            } else {
                                                txtFormaPgto += " | <a tooltip="+textoPagto+" class='greybox' > "+infPagto+"</a>";
                                            }
                                                z++;
                        });
                        
                        if(usuario.nivel=='1')
                        {
                            var situacao = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+value.pvnumero+'" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" class="greybox" name="liberacao">LIBERAR</a>';
                        }
                        else if(usuario.nivel=='2')
                        {
                        situacao = '<a href="#" title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+value.pvnumero+'" log="'+JSON.stringify(value)+'" name="liberacao1" valprefechamento="'+Number(value.valorPreFechamento).toFixed(2) +'" valorpedido="'+valorPedido.toFixed(2)+'">LIBERAR</a>';
                        }
                        //var enviarPendencia = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'"  name="enviarPendencia">EMAIL</a>';
                        if(value.pvtipoped=='BF')
                        {
                            email = 'filial@centroatacadista.com.br;';
                        }else if(value.pvtipoped=='BM')
                        {
                            email = 'roberto@baraobrinquedos.com.br;andreia.matriz@baraobrinquedos.com.br';
                        }else{
                            email = value.usuario.usuemail+';';
                        }
                        var liberarFinanceiro = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'" email="'+email+'" prefechamento="'+value.prefechamento+'" name="financeiro">FINANCEIRO</a>';
                        status4 = '<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+value.pvnumero+'"  name="financeiro">NAO AUTORIZADO</a>';
                        var observacaoFinanceiro = '';

                        if(value.obsfinanceiro!=undefined || value.obsfinanceiro!=null)
                        {
                            observacaoFinanceiro = value.obsfinanceiro;
                        }

                        var manutencaoPedido = '<a href="'+HTTP_ROOT+'alterarpvendanovo.php?pvnumero='+value.pvnumero+'" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">EDITAR</a> - <a href="'+HTTP_ROOT+'alterarpvendasimples.php?flagmenu=9&pgcodigo=16&pvnumero='+value.pvnumero+'&popup=1" title="MANUTENCAO" tooltip="CLIQUE PARA EFETUAR ALTERAÇÃO SIMPLES DO PEDIDO" class="greybox" id="'+value.pvnumero+'" name="manutencao">SIMPLES</a>';
                        var consultaPedido = '<a href="'+HTTP_ROOT+'pedvendacons2.php?flagmenu=9&popup=1&codped='+value.pvnumero+'" title="CONSULTA PEDIDO" tooltip="CLIQUE PARA REALIZAR CONSULTAR PEDIDO." class="greybox" id="'+value.pvnumero+'" name="consulta">'+value.pvnumero+'</a>';
                        var analiseCredido = '<a href="'+HTTP_ROOT+'analisecredclientessimples.php?popup=1&clicod='+value.cliente.clicod+'" title="ANALISE DE CREDITO" tooltip="CLIQUE PARA VISUALIZAR ANALISE DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="analiseCredito">ANALISE CREDITO</a>';
                        var manutencaoCredito = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">'+$.mask.string(Number(value.cliente.clilimite).toFixed(2), 'decimal')+'</a>';
//                        var formaPagto = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="formaPagto">MANUTENCAO CREDITO</a>';
                        var manutencaoCredito2 = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">MANUTENCAO CREDITO</a>';
                        //var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="FINANCEIRO INTERFIX" tooltip="CLIQUE PARA ATUALIZAÇÃO FINANCEIRO INTERFIX." class="greybox" id="'+value.cliente.clicod+'" name="interfix">ATUALIZAR</a>';
                        var atualizaInterfix = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">ATUALIZAR</a>';

                        var situacaoReceita = value.cliente.clireceitasituacaocadastral;
                        var situacaoSintegra = value.cliente.clisintegrasituacaocadastral;
                        var dataReceita = value.cliente.clireceitadataultimaconsulta;
                        var dataSintegra = value.cliente.clisintegradataultimaconsulta;
                        var dataValidacao = value.cliente.clidatavalida;
                        var cliie = value.cliente.cliie;

                        var limiteIbge = new Date();
                        limiteIbge.setDate(limiteIbge.getDate()-2);
                        limiteIbge = new Date(limiteIbge);



                        var limiteDisponivel = Number(value.cliente.clilimite) - (Number(value.cliente.vendasEmAberto.totalVendas)-Number(value.pvvalor));
                        var totalLiquido = Number(value.pvvalor) - Number(value.pvvaldesc);

                        if(usuario.nivel == "1")
                        {
                            var dataEmissao = new Date().date(value.pvemissao);
                        }
                        else if(usuario.nivel == "2")
                        {
                        dataEmissao = new Date().date(value.pvliberafinanceiro);
                        }

                        if (value.cliente.enderecoFaturamento)
                        {
                            uf = value.cliente.enderecoFaturamento.cidade == null ? "" : value.cliente.enderecoFaturamento.cidade.uf;
                            cidade = value.cliente.enderecoFaturamento.cidade == null ? "" : value.cliente.enderecoFaturamento.cidade.descricao;;
                        }

                        if((value.condicaoComercial.codigo == 1 || value.condicaoComercial.codigo == 49) && (Number(value.preFechamento.fecforma) == 103 || Number(value.preFechamento.fecforma) == 110))
                        {
                            cor = '#FFFFBB';
                            status = 'EM ANALISE';
                            situacao = liberarFinanceiro;
                            tipoStatus = 0;
                            txtPendencia += "PEDIDO A VISTA FORMA DE PAGAMENTO CHEQUE.\n";
//                            txtCodStatus += 'CQ';

                            if (!txtCodStatus) {
                                              txtCodStatus = '<a tooltip="PGTO VISTA CHEQUE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">CQ</a>';
                                      } else {
                                          txtCodStatus += '<a tooltip="PGTO VISTA CHEQUE." class="greybox" > | CQ</a>';
                                      }

                        }
                        else if (value.condicaoComercial.codigo != 1)
                        {
                            /*
							if (Number(value.pvencer) == 3)
							{
								cor = '#FFFFBB';
								status = 'EM ANALISE';
								situacao = liberarFinanceiro;
								tipoStatus = 2;
							//}
							//else
							//{*/
                            if (Number(value.cliente.clifat) == 1)
                            {
                                txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
                                cor = '#FFFFBB';
                                status = 'SOMENTE A VISTA';
                                situacao = liberarFinanceiro;
                                tipoStatus = 0;
                                txtPendencia += "CLIENTE PAGAMENTO SOMENTE A VISTA.\n";
//                                txtCodStatus += 'PV';
                                    if (!txtCodStatus) {
                                              txtCodStatus = '<a tooltip="PAGAMENTO SOMENTE A VISTA." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">PV</a>';
                                      }else {
                                          txtCodStatus += '<a tooltip="PAGAMENTO SOMENTE A VISTA." class="greybox" > | PV</a>';
                                      }

                            //txtDataSerasa = dataSerasaExp.format("d/m/Y");
                            }
                            else if (Number(value.cliente.clifat) == 3)
                            {
                                txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
                                //alert(value.cliente.clifat);
                                cor = '#FA5050';
                                status = 'PROIBIDO';
                                situacao = liberarFinanceiro;
                                tipoStatus = 0;
                                txtPendencia += "CLIENTE PROIBIDO.\n";

                            //txtDataSerasa = dataSerasaExp.format("d/m/Y");
                            }else

                            if (Number(value.cliente.clifat) == 4)
                            {
                                txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
                                cor = '#FA5050';
                                status = 'PROIBIDO MATEL';
                                situacao = liberarFinanceiro;
                                tipoStatus = 0;
                                txtPendencia += "CLIENTE PROIBIDO MATTEL.\n";
                            ///txtDataSerasa = dataSerasaExp.format("d/m/Y");
                            }
                            else
                            {

                                if (!dataSerasaExp || dataSerasaExp == '')
                                                {
                                                    cor = '#FFFFBB';
                                                    status = atualizaInterfix;
                                                    situacao = liberarFinanceiro;
                                                    tipoStatus = 0;
                                                    //txtCodStatus += 'SER';
                                                    if (!txtCodStatus) {
                                                              txtCodStatus = '<a tooltip="SERASA NAO CONSULTADO" class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">SER</a>';
                                                      } else {
                                                          txtCodStatus += '<a tooltip="SERASA NAO CONSULTADO" class="greybox" > | SER</a>';
                                                      }

                                                }

//                                if (!dataSintegraExp || !dataReceitaExp)
//                                {
//                                    cor = '#FFFFBB';
//                                    status = atualizaInterfix;
//                                    situacao = liberarFinanceiro;
//                                    tipoStatus = 0;
//                                    txtPendencia += "ATUALIZAR INTERFIX.\n";
//                                }
                                else
                                {
                                    //dataSintegraExp.addMonths(1);
                                    txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';
                                    //txtDataSintegra = dataSintegraExp ? dataSintegraExp.format("d/m/Y") : '';

                                    if (Number(value.pvvalor) > limiteDisponivel)
                                    {
                                        cor = '#FFFFBB';
                                        status = 'LIMITE EXCEDIDO';
                                        situacao = liberarFinanceiro;
                                        tipoStatus = 0;
                                        txtPendencia += "LIMITE DE CREDITO EXCEDIDO.\n";
//                                        txtCodStatus += 'LE';
                                         if (!txtCodStatus) {
                                              txtCodStatus = '<a tooltip="LIMITE EXCEDIDO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">LE</a>';
                                          } else {
                                              txtCodStatus += '<a tooltip="LIMITE EXCEDIDO." class="greybox" > | LE</a>';
                                          }

                                    }
//dataSerasaExpVazio ='';
//   if (dataSerasaExp == "") {
//        dataSerasaExpVazio = 'dataSerasaExp EH \' \'';
//    }
//
//alert(dataAtual +" => dataAtual\n"
//    +value.cliente.cliserasaexp+" => value.cliente.cliserasaexp "
//    +dataSerasaExp+" => dataSerasaExp\n"
//    +dataSerasaExpVazio

//    +dataAtual.getMonthsBetween(dataSerasaExp)+" => dataAtual.getMonthsBetween(dataSerasaExp)"
//);

//                             if (dataSerasaExp == "" )
//                                    {
//                                        cor = '#FFFFBB';
//                                        status = atualizaInterfix;
//                                        situacao = liberarFinanceiro;
//                                        tipoStatus = 0;
//                                        txtPendencia += "ATUALIZACAO SERASA DESATUALIZADA.\n";
//                                        txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO SERASA EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
//                                    } else



                                    if (dataAtual.getMonthsBetween(dataSerasaExp) < 0)
                                    {
                                        cor = '#FFFFBB';
                                        status = atualizaInterfix;
                                        situacao = liberarFinanceiro;
                                        tipoStatus = 0;
                                        txtPendencia += "ATUALIZACAO SERASA DESATUALIZADA.\n";
                                        txtDataSerasa = '<a href="javascript:;" tooltip="DATA DA ATUALIZAÇÃO DO SERASA EXPIRADA!\n CLIQUE EM ATUALIZAR."><font color="red"><b>'+dataSerasaExp.format("d/m/Y")+'<b></font></a>';
                                           if (!txtCodStatus) {
                                              txtCodStatus = '<a tooltip="SERASA EXPIRADO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">SERX</a>';
                                          } else {
                                              txtCodStatus += '<a tooltip="SERASA EXPIRADO." class="greybox" > | SERX</a>';
                                          }
                                    }
                                }
                            }
                        //}
                        }
                        else
                        {
                            enviarPendencia = '';
                        }


//                        if(value.cliente.clireceitasituacaocadastral==null || value.cliente.clireceitasituacaocadastral=='0')
//                        {
//                            clireceitasituacaocadastral = 'IRREGULAR';
//                            //cor = '#FA5050';
//                            txtDataReceita = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA CONSULTAR O RECEITA DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito"><font color="red"><b>'+clireceitasituacaocadastral+'</b></font></a>';
//                        }else{
//                            clireceitasituacaocadastral = 'ATIVO';
//                            txtDataReceita = 'ATIVO';
//                        }
//
//                        if(value.cliente.clisintegrasituacaocadastral==null || value.cliente.clisintegrasituacaocadastral=='0')
//                        {
//                            clisintegrasituacaocadastral = 'INATIVO';
//                            //cor = '#FA5050';
//                            txtDataSintegra = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA CONSULTAR O SINTEGRA DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito"><font color="red"><b>'+clisintegrasituacaocadastral+'</b></font></a>';
//                        }else{
//                            clisintegrasituacaocadastral = 'ATIVO';
//                            txtDataSintegra = 'ATIVO';
//                        }

                        if( dataReceita != undefined  &&  dataReceita != null && dataReceita != "") {
//                                dataReceita = value.cliente.clireceitadataultimaconsulta;
                                tokens = dataReceita.split("-");
                                hora = tokens[2].split(" ");
                                dataReceita = new Date (tokens[0],(tokens[1]-1),hora[0]);

                            }

                            if( dataSintegraExp != undefined  &&  dataSintegraExp != null  && dataSintegraExp !="") {
//                                dataSintegra = value.cliente.clisintegradataultimaconsulta;
                                tokens = dataSintegra.split("-");
                                hora = tokens[2].split(" ");
                                dataSintegra = new Date (tokens[0],(tokens[1]-1),hora[0]);
                            }

                            if(( dataReceitaExp >= dataLimiteInt ) && situacaoReceita != undefined && situacaoReceita.match(/ativ/i)) {
                               txtDataReceita = 'ATIVO';

                            }else {
                                 if( value.cliente.clipessoa != '2' ) {
                                     clireceitasituacaocadastral = 'IRREGULAR';

                                    cor = '#FA5050';
                                    txtDataReceita = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA CONSULTAR O RECEITA DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">'+clireceitasituacaocadastral+'</a>';
    //                                txtCodStatus = 'INT';

                                     if(situacaoReceita == undefined ) {
                                         if (!txtCodStatus) {
                                                  txtCodStatus = '<a tooltip="INTERFIX - RECEITA NAO CONSULTADA." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTR</a>';
                                          } else {
                                                  txtCodStatus += '<a tooltip="INTERFIX - RECEITA NAO CONSULTADA." class="greybox" > | INTR</a>';
                                          }

                                     }else if ( !situacaoReceita.match(/ativ/i) ){
                                         if (!txtCodStatus) {
                                              txtCodStatus = '<a tooltip="INTERFIX - RECEITA IRREGULAR." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTRI</a>';
                                          }else {
                                              txtCodStatus += '<a tooltip="INTERFIX - RECEITA IRREGULAR." class="greybox" > | INTRI</a>';
                                          }
                                      }else {

                                                if (!txtCodStatus) {
                                                  txtCodStatus = '<a tooltip="INTERFIX - RECEITA EXPIRADA." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTRX</a>';
                                              } else {
                                                  txtCodStatus += '<a tooltip="INTERFIX - RECEITA EXPIRADA." class="greybox" > | INTRX</a>';
                                              }

                                      }
                                   }
                                }

                            if ((
                               ( dataSintegraExp >= dataLimiteInt &&
                                situacaoSintegra != undefined &&
                                situacaoSintegra != "" && situacaoSintegra != null &&
                                !situacaoSintegra.match(/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i)) &&
                                cliie.match(/[0-9]/i)
                                ))  {
                                  txtDataSintegra = 'ATIVO';
                            } else if (!cliie.match(/[0-9]/i)) {
                                  txtDataSintegra = 'ISENTO';
                            } else  {
                                  if(value.cliente.clipessoa != '2') {
                                  clisintegrasituacaocadastral = 'INATIVO';
                                  cor = '#FA5050';
                                  txtDataSintegra = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=19&popup=1&clicod='+value.cliente.clicod+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA CONSULTAR O SINTEGRA DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="manutencaoCredito">'+clisintegrasituacaocadastral+'</a>';

                                  if(situacaoSintegra == undefined) {
                                        if (!txtCodStatus) {
                                                  txtCodStatus = '<a tooltip="INTERFIX - SINTEGRA NAO CONSULTADO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTS</a>';
                                          } else {
                                                  txtCodStatus += '<a tooltip="INTERFIX - SINTEGRA NAO CONSULTADO." class="greybox" > | INTS</a>';
                                          }

                                  } else if (situacaoSintegra.match(/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i)){
                                            if (!txtCodStatus) {
                                                  txtCodStatus = '<a tooltip="INTERFIX - SINTEGRA IRREGULAR." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTSI</a>';
            //                                      txtCodStatus = 'INT';
                                              }else {
                                                  txtCodStatus += '<a tooltip="INTERFIX IRREGULAR." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'"> | INTSI</a>';
            //                                      txtCodStatus += '| INT';
                                              }
                                  }else {
                                             if (!txtCodStatus) {
                                                  txtCodStatus = '<a tooltip="INTERFIX - SINTEGRA EXPIRADO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">INTSX</a>';
            //                                      txtCodStatus = 'INT';
                                              } else {
                                                  txtCodStatus += '<a tooltip="INTERFIX - SINTEGRA EXPIRADO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'"> | INTSX</a>';
            //                                      txtCodStatus += '| INT';
                                              }
                                  }
                                }
                            }

                        if( (dataAnulaValidacaoIbge == '' || dataAnulaValidacaoIbge <limiteIbge) && value.cliente.enderecoFaturamento.cidade.descricao  !=  value.cliente.enderecoFaturamento.cidadeIbge.descricao) {
                                                       txtDataValidacao = 'CIDADE IBGE DIFERENTE';
                                                        cor = '#FFFFBB';
                                                        situacao = liberarFinanceiro;
                                                        status = 'CIDADE IBGE DIFERENTE';
                                                        tipoStatus = 0;

                                                        txtDataValidacao = '<a href="'+HTTP_ROOT+'clienteendereco.php?c='+value.cliente.clicod+'" title="VALIDACAO DE ENDERECO" tooltip="CLIQUE PARA VALIDAR O ENDERECO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="validacaoCliente">'+txtDataValidacao+'</a>';
//                                                        txtCodStatus += 'CAD';
                                                         if (!txtCodStatus) {
//                                                              txtCodStatus = 'CAD';
                                                              txtCodStatus = '<a tooltip="CIDADE IBGE DIFERENTE DA CIDADE ENDERECO FATURAMENTO." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">IBGE</a>';
                                                          } else {
//                                                              txtCodStatus += '| CAD';
                                                              txtCodStatus += '<a tooltip="CIDADE IBGE DIFERENTE DA CIDADE ENDERECO FATURAMENTO." class="greybox" > | IBGE</a>';
                                                          }

                                                    }


                        if( dataValidacao == undefined || dataValidacao == '' || dataValidacao == '0' || dataValidacao == null) {
                                                       txtDataValidacao = 'NAO VALIDADO';
//                                                        cor = '#FFFFBB';
                                                        cor = '#805361';
                                                        situacao = liberarFinanceiro;
                                                        status = 'CADASTRO NAO VALIDADO';
                                                        tipoStatus = 0;

                                                        txtDataValidacao = '<a href="'+HTTP_ROOT+'clienteendereco.php?c='+value.cliente.clicod+'" title="VALIDACAO DE ENDERECO" tooltip="CLIQUE PARA VALIDAR O ENDERECO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="validacaoCliente">'+txtDataValidacao+'</a>';
//                                                        txtCodStatus += 'CAD';
                                                         if (!txtCodStatus) {
//                                                              txtCodStatus = 'CAD';
                                                              txtCodStatus = '<a tooltip="CADASTRO NAO VALIDADO." class="greybox" id="cad'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'">CAD</a>';
                                                          } else {
//                                                              txtCodStatus += '| CAD';
                                                              txtCodStatus += '<a tooltip="CADASTRO NAO VALIDADO." class="greybox" id="cad'+value.cliente.clicod+'"> | CAD</a>';
                                                          }

                                                    }else if ( dataValidaExp < dataLimiteCad ) {
                                                        txtDataValidacao = 'VALIDACAO EXPIRADA';
                                                        situacao = liberarFinanceiro;
                                                        cor = '#805361';

                                                        txtDataValidacao = '<a href="'+HTTP_ROOT+'clienteendereco.php?c='+value.cliente.clicod+'" title="VALIDACAO DE ENDERECO" tooltip="CLIQUE PARA VALIDAR O ENDERECO DO CLIENTE." class="greybox" id="'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'" name="validacaoCliente">'+txtDataValidacao+'</a>';
                                                        if (!txtCodStatus) {
                                                              txtCodStatus = '<a tooltip="CADASTRO EXPIRADO." class="greybox" id="cadx'+value.cliente.clicod+'" pvnumero="'+value.pvnumero+'"> CADX</a>';
                                                        }else {
                                                              txtCodStatus += '<a tooltip="CADASTRO EXPIRADO." class="greybox" id="cadx'+value.cliente.clicod+'"> | CADX</a>';
                                                          }
                                                    }
                                                    else {
                                                         txtDataValidacao = 'ATIVO';
                                                     }



                        var isPrint = false;
                        if(usuario.nivel == "2" && (value.pvencer2== "3" || value.pvencer2=="4"))
                        {
                            if(tipoStatus == 2 || tipoStatus == 0)
                            {

                                isPrint = true;
                            }
                        }
                        else
                        {
                            if(tipoStatus == 1 || tipoStatus == 0)
                            {
                                isPrint = true;
                            }
                        }

                        if(isPrint)
                        {

                            if(usuario.nivel=='1')
                            {
                                if(value.pvencer2=='4')
                                {
                                    codHtml += "<tr style='background: "+cor2+";' id="+value.pvnumero+">";
                                }
                                else if(value.pvencer2=='5')
                                {
                                    codHtml += "<tr style='background: "+cor3+";' id="+value.pvnumero+">";
                                }
                                else
                                {
                                    codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">";
                                }

                                codHtml += "<td>"+(++numLinha)+"</td>"+
                                "<td>"+value.tipoPedido.sigla+"</td>"+
                                "<td><span id='dvConsultaPedido"+value.pvnumero+"'>"+consultaPedido+"</span></td>" +
                                //href="'+HTTP_ROOT+'clienteendereco.php?c='+value.cliente.clicod+'"
                                "<td><a href='"+HTTP_ROOT+"clientescons.php?c="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
                                "<td><a href='"+HTTP_ROOT+"clientescons.php?c="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>" +
                                "<td>";

                                codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
                                codHtml += "</td> <td>";
                                codHtml += value.tipolocal == 1 ? "CD" : "VIX";
                                codHtml += "</td>";

                                if(value.pvencer2=='3' && value.pvfinanceiro=='0')
                                {
                                    codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+liberarFinanceiro+"</span></td>";
                                }
                                else
                                {
                                    codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+situacao+"</span></td>";
                                }

                                codHtml +="<td><span id='dvManutencao"+value.pvnumero+"'>"+manutencaoPedido+"</span></td>" +
                                "<td>"+cidade+"</td>"+
                                "<td>"+uf+"</td>" +
                                "<td>"+value.vendedor.vencodigo+" "+value.vendedor.vennguerra+"</td>" +
                                "<td>";

                                codHtml += dataEmissao.format("d/m/Y H:i:s");

                                codHtml +="</td>" +
                                "<td>"+$.mask.string(Number(value.totalMattel).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+$.mask.string(Number(value.totalBarao).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+$.mask.string(Number(value.pvvalor).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+$.mask.string(Number(value.pvperdesc).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+$.mask.string(Number(value.pvvaldesc).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+$.mask.string(Number(totalLiquido).toFixed(2), 'decimal')+"</td>" +
                                "<td>"+value.condicaoComercial.descricao+"</td>" +
                                "<td>";

                                codHtml += value.pvtipofrete == 1 ? 'CIF' : 'FOB';

                                codHtml +="</td>"+
                                "<td>"+value.transportadora.tranguerra+"</td>" +
                                "<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+analiseCredido+"</span></td>" +
                                "<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+manutencaoCredito2+"</span></td>" +
                                "<td><span id='dvLimite"+value.pvnumero+"'>"+manutencaoCredito+"</span></td>" ;

                                codHtml +=   "<td><span id='dvSerasa"+value.pvnumero+"'>"+txtDataSerasa+"</span></td>";
                                codHtml +=   "<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
                                codHtml +=   "<td><span id='dvReceita"+value.pvnumero+"'>"+txtDataReceita+"</span></td>";
                                codHtml +="<td><span id='dvValEndereco"+value.pvnumero+"'>"+txtDataValidacao+"</span></td>";
                                codHtml +="<td><span id='dvCodStatus"+value.pvnumero+"'>"+txtCodStatus+"</span></td>";



                                if(value.pvencer2=='4'){
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status2+"</span></td>" ;
                                }else if(value.pvencer2=='5'){
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status3+"</span></td>" ;
                                }else {
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" ;
                                }
                                codHtml +="<td><span id='obs"+value.pvnumero+"'>"+observacaoFinanceiro+"</span></td>" ;


                            }else
                            /*if(usuario.nivel=='2')
								{
									codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status2+"</span></td>" ;
								}
								else if(value.pvencer2=='5')
								{
									codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status3+"</span></td>" ;
								}
								else
								{
									codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" ;
								}

								codHtml +="<td><span id='obs"+value.pvnumero+"'>"+observacaoFinanceiro+"</span></td>" ;

								//codHtml +="<td><span id='dvPendencia"+value.pvnumero+"'>"+enviarPendencia+"</span></td>" ;

								"</tr>";
							}
							else*/ if(usuario.nivel=='2')
                            {
                                if(value.pvencer2=='4')
                                {
                                    codHtml += "<tr style='background: "+cor2+";' id="+value.pvnumero+">";
                                }
                                else if(value.pvencer2=='5')
                                {
                                    codHtml += "<tr style='background: "+cor3+";' id="+value.pvnumero+">";
                                }
                                else
                                {
                                    codHtml += "<tr style='background: "+cor+";' id="+value.pvnumero+">";
                                }

                                codHtml += "<td>"+(++numLinha)+"</td>"+
                                "<td>"+value.tipoPedido.sigla+"</td>"+
                                "<td><span id='dvConsultaPedido"+value.pvnumero+"'>"+consultaPedido+"</span></td>" +
                                "<td><a href='"+HTTP_ROOT+"clientesedit.php?c="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clicod+"</a></td>" +
                                "<td><a href='"+HTTP_ROOT+"clientesedit.php?c="+value.cliente.clicod+"' title='CONSULTA CLIENTE' tooltip='CLIQUE PARA EFETUAR CONSULTA CLIENTE' class='greybox' id='"+value.cliente.clicod+"' name='cliente'>"+value.cliente.clirazao+"</a></td>";

                                if(value.pvencer2=='3' && value.pvfinanceiro=='0')
                                {
                                    codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+liberarFinanceiro+"</span></td>";
                                }
                                else
                                {
                                    codHtml += "<td><span id='dvSituacao"+value.pvnumero+"'>"+situacao+"</span></td>";
                                }

                                codHtml += "<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+analiseCredido+"</span></td>" +
                                "<td><span id='dvLimite"+value.pvnumero+"'>"+manutencaoCredito+"</span></td>" +
                                "<td><span id='dvAnaliseCredito"+value.pvnumero+"'>"+manutencaoCredito2+"</span></td>";
                                codHtml +=   "<td><span id='dvSerasa"+value.pvnumero+"'>"+txtDataSerasa+"</span></td>";

                                if(value.pvencer2=='4')
                                {
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status2+"</span></td>";
                                }
                                else if(value.pvencer2=='5')
                                {
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status3+"</span></td>" ;
                                }
                                else
                                {
                                    codHtml +="<td><span id='dvStatus"+value.pvnumero+"'>"+status+"</span></td>" ;
                                }

                                codHtml +="<td>";
                                codHtml += value.cliente.climodo == 2 ? "FIDELIDADE" : "NORMAL";
                                codHtml += "</td>";

                                codHtml +="<td><span id='dvSintegra"+value.pvnumero+"'>"+txtDataSintegra+"</span></td>";
                                codHtml +="<td><span id='dvReceita"+value.pvnumero+"'>"+txtDataReceita+"</span></td>";
                                codHtml +="<td><span id='dvValEndereco"+value.pvnumero+"'>"+txtDataValidacao+"</span></td>";
                                codHtml +="<td><span id='dvCodStatus"+value.pvnumero+"'>"+txtCodStatus+"</span></td>";
                                codHtml +="<td>"+value.condicaoComercial.descricao+"</td>";
                                codHtml +="<td><span id='dvFormPagto"+value.pvnumero+"'>"+txtFormaPgto+"</span></td>";
                                codHtml +="<td>"+uf+"</td>";
                                codHtml +="<td>"+value.vendedor.vencodigo+" "+value.vendedor.vennguerra+"</td>";

                                //codHtml += "<td><a href='javascript:;'   title='LIBERACAO'  tooltip='CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO'  name='enviarPendencias'>LIBERAR</a></td>" +
                                codHtml += "<td>"+dataEmissao.format("d/m/Y H:i:s")+"</td>" +
                                "</tr>";
                            }

                            codHtml += "<input type='hidden' id='pendencia"+value.pvnumero+"' value='"+txtPendencia+"'/>";
                        }
                    });

                    codHtml += 	"</tbody></table>";

                    $('#tblResultado').html(codHtml);

                    $("#accordion").accordion( "activate" , 1);

                    width = (screen.width - (((screen.width * 5)/100)*2));

                    if(usuario.nivel=='1')
                    {
                        $("#tblResultado").flexigrid(
                        {
                            width: width,
                            height:400,
                            striped:false,
                            colModel : [
                            {
                                display: '',
                                name : 'canal',
                                width : 40,
                                align: 'center'
                            },

                            {
                                display: 'CANAL',
                                name : 'canal',
                                width : 40,
                                align: 'center'
                            },

                            {
                                display: 'PEDIDO',
                                name : 'pedido',
                                width : 50,
                                align: 'center'
                            },

                            {
                                display: 'COD.CLI.',
                                name : 'cod_cliente',
                                width : 60,
                                align: 'center'
                            },

                            {
                                display: 'RAZAO SOCIAL',
                                name : 'razao_social',
                                width : 250,
                                align: 'left'
                            },

                            {
                                display: 'CLIENTE',
                                name : 'tipo_cliente',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'LOCAL',
                                name : 'local',
                                width : 40,
                                align: 'center'
                            },

                            {
                                display: 'SITUACAO',
                                name : 'situacao',
                                width : 90,
                                align: 'center'
                            },

                            {
                                display: 'MANUTENCAO',
                                name : 'manutencao',
                                width : 90,
                                align: 'center'
                            },

                            {
                                display: 'CIDADE',
                                name : 'cidade',
                                width : 150,
                                align: 'center'
                            },

                            {
                                display: 'UF',
                                name : 'estado',
                                width : 30,
                                align: 'center'
                            },

                            {
                                display: 'COD/VEND.',
                                name : 'vendedor',
                                width : 130,
                                align: 'center'
                            },

                            {
                                display: 'EMISSAO/HORA',
                                name : 'data_emissao',
                                width : 150,
                                align: 'center'
                            },

                            {
                                display: 'MATTEL',
                                name : 'valor_mattel',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'BARAO',
                                name : 'valor_barao',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'TOTAL',
                                name : 'total',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'DESC.%',
                                name : 'desconto_percentual',
                                width : 50,
                                align: 'center'
                            },

                            {
                                display: 'DESC.$',
                                name : 'desconto_valor',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'TOTAL LIQ.',
                                name : 'total_liquido',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'COND. COM.',
                                name : 'condicao_com',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'FRETE',
                                name : 'tipo_frete',
                                width : 50,
                                align: 'center'
                            },

                            {
                                display: 'TRANSP.',
                                name : 'transportadora',
                                width : 200,
                                align: 'center'
                            },

                            {
                                display: 'ANALISE CREDITO',
                                name : 'manutencao',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'MANUTENCAO CREDITO',
                                name : 'manutencao',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'LIMITE',
                                name : 'limite_cliente',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'SERASA',
                                name : 'serasa',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'SINTEGRA',
                                name : 'sintegra',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'RECEITA',
                                name : 'receita',
                                width : 100,
                                align: 'center'
                            },
                            {
                                display: 'CADASTRO',
                                name : 'val_endereco',
                                width : 140,
                                align: 'center'
                            },
                            {
                                display: 'STATUS',
                                name : 'cod_status',
                                width : 140,
                                align: 'center'
                            },

                            {
                                display: 'STATUS FINANC',
                                name : 'status',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'OBS',
                                name : 'obs',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'PENDENCIAS',
                                name : 'pendencias',
                                width : 120,
                                align: 'center'
                            }
                            ]
                        });

                    }else
                    if(usuario.nivel=='2')
                    {

                        $("#tblResultado").flexigrid(
                        {
                            width: width,
                            height:300,
                            striped:false,
                            colModel : [
                            {
                                display: '',
                                name : 'canal',
                                width : 40,
                                align: 'center'
                            },

                            {
                                display: 'CANAL',
                                name : 'canal',
                                width : 40,
                                align: 'center'
                            },

                            {
                                display: 'PEDIDO',
                                name : 'pedido',
                                width : 50,
                                align: 'center'
                            },

                            {
                                display: 'COD.CLI.',
                                name : 'cod_cliente',
                                width : 60,
                                align: 'center'
                            },

                            {
                                display: 'RAZAO SOCIAL',
                                name : 'razao_social',
                                width : 250,
                                align: 'left'
                            },

                            {
                                display: 'SITUACAO',
                                name : 'situacao',
                                width : 90,
                                align: 'center'
                            },

                            {
                                display: 'ANALISE CREDITO',
                                name : 'manutencao',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'LIMITE',
                                name : 'limite_cliente',
                                width : 100,
                                align: 'center'
                            },
                         

                            {
                                display: 'MANUTENCAO CREDITO',
                                name : 'manutencao',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'SERASA',
                                name : 'serasa',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'STATUS FINANC',
                                name : 'status',
                                width : 120,
                                align: 'center'
                            },

                            {
                                display: 'CLIENTE',
                                name : 'tipo_cliente',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'SINTEGRA',
                                name : 'sintegra',
                                width : 100,
                                align: 'center'
                            },

                            {
                                display: 'RECEITA',
                                name : 'receita',
                                width : 100,
                                align: 'center'
                            },
                             {
                                display: 'CADASTRO',
                                name : 'val_endereco',
                                width : 140,
                                align: 'center'
                            },
                            {
                                display: 'STATUS',
                                name : 'cod_status',
                                width : 140,
                                align: 'center'
                            },

                            {
                                display: 'COND. COM.',
                                name : 'condicao_com',
                                width : 100,
                                align: 'center'
                            },
                             {
                                display: 'FORMA PAGAMENTO',
                                name : 'forma_pagamento',
                                width : 150,
                                align: 'center'
                            },

                            {
                                display: 'UF',
                                name : 'estado',
                                width : 30,
                                align: 'center'
                            },

                            {
                                display: 'COD/VEND.',
                                name : 'vendedor',
                                width : 130,
                                align: 'center'
                            },

                            {
                                display: 'EMISSAO/HORA',
                                name : 'data_emissao',
                                width : 150,
                                align: 'center'
                            }
                            ]
                        });
                    }

                    $('a[name=liberacao1]').click(function()
                                    {
                                        var id = $(this).attr("id");
                                        var valprefe = $(this).attr("valprefechamento");
                                        var valorped = $(this).attr("valorpedido");

                                        $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                        {
                                            //variaveis a ser enviadas metodo POST
                                            id:id,
                                            acao:11

                                        },
                                        function(data)
                                        {


                                            if (Boolean(data.retorno))
                                            {
                                                    pedidosRecebe = data.pedidos;
                                                    $.each(pedidosRecebe, function (key, value0){
                                                        pedidoVerLiberacao = value0;
                                                    });

//                                                    pedidoVerLiberacao
                                                    interfixNaoConsultado = false;
                                                    dataReceita = "";
                                                    dataSintegra = "";
                                                    consultaReceita = false;
                                                    consultaSintegra = false;


                                                     var   prazolimiteInt = 0;
                                                     var   prazolimiteCad = 0;
                                                     var   prazolimiteSer = 0;

                                                    if(pedidoVerLiberacao.cliente !== undefined)    {
                                                            $.each(pedidoVerLiberacao.cliente.prazoExpiracao.resultado, function (key, value2){
                                                        //                                                                                                       alert( "value2.pedescricao: "+ value2.pedescricao +"\n value2.peprazo"+value2.peprazo);
                                                                                                                                if(value2.pedescricao === 'INTERFIX')
                                                                                                                                {
                                                                                                                                        prazolimiteInt = value2.peprazo;
                                                                                                                                } else if (value2.pedescricao === 'CADASTRO') {
                                                                                                                                        prazolimiteCad = value2.peprazo;
                                                                                                                                } else if (value2.pedescricao === 'SERASA') {
                                                                                                                                        prazolimiteSer = value2.peprazo;
                                                                                                                                }
                                                                                                                });
                                                                                                            }

//                                                        var limite = new Date();
//                                                        limite.setDate(limite.getDate()-180);
//                                                        limite = new Date(limite);

                                                        limitePrazo = new Date();
                                // alert ( "Look a test: "+limitePrazo );
                                                        limitePrazo.setDate( limitePrazo.getDate() - prazolimiteInt );
                                                        dataLimiteInt = new Date(limitePrazo);
                                // alert ( "Look a testInt: "+limitePrazo );
                                                        limitePrazo = new Date();
                                                        limitePrazo.setDate( limitePrazo.getDate() - prazolimiteCad );
                                                        dataLimiteCad = new Date(limitePrazo);
                                // alert ( "Look a test Cad: "+limitePrazo );
                                                        limitePrazo = new Date();
                                                        limitePrazo.setDate( (limitePrazo.getDate()+1) - prazolimiteSer );
                                                        dataLimiteSer = new Date(limitePrazo);


//                                                    var limite = new Date();
//                                                    limite.setDate(limite.getDate()-180);
//                                                    limite = new Date(limite);
                                                    clienteIsento = false; // Verifica se o cliente é isento de I.E.

                                                    var limiteIbge = new Date();
                                                    limiteIbge.setDate(limiteIbge.getDate()-2);
                                                    limiteIbge = new Date(limiteIbge);
                                                        //pedidoVerLiberacao.cliente.enderecoFaturamento.cidade.descricao

                                                    var dataAnulaValidacaoIbge = pedidoVerLiberacao.cliente.clilibibgediferente ? new Date().date(pedidoVerLiberacao.cliente.clilibibgediferente) : '';
                                                    var opcoes = '';
                                                    $.each(pedidosRecebe, function (key, value)
                                                    {

                                                        pedidoVerLiberacao = value;


                                                    });






                                                    //                                $("#"+id).attr("style", "background: #4682B4");
                                                    //                                $("#"+id).hide();

                                                     // VERIFICARÁ SE É POSSÍVEL REALIZAR A LIBERAÇÃO
                                                    // CÓDIGO SEMELHANTE AO /modulos/vendaAtacado/liberacao/view/js/liberaPedido.js

                                                    if(pedidoVerLiberacao.tipoPedido.sigla=='R'){

                                                        msg = "<br> - PEDIDO RESERVA NÃO PODE SER LIBERADO";
                                                        alert('PEDIDO RESERVA NÃO PODE SER LIBERADO');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', 'disabled');
                                                        return false;

                                                    }

                                                    //limiteDisponivel = pedidoVerLiberacao.cliente.clilimite - pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas;


                                                    limit = pedidoVerLiberacao.cliente.clilimite;
                                                    
                                                    pvlibdep = '';
                                                    pvlibvit = '';
                                                    pvlibfil = '';
                                                    pvlibmat = '';

                                                    if(pedidoVerLiberacao.tipoPedido.sigla=='I' && pedidoVerLiberacao.pvvinculo!=null)
                                                    {
                                                        pedidoValor = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                    }else{
                                                        $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                        {
                                                            if(value.pedidoVendaItemEstoque.pviest011 > '0')
                                                            {
                                                                limitvall = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                pvlibvit = '1';
                                                            }else if(value.pedidoVendaItemEstoque.pviest09 > '0' || value.pedidoVendaItemEstoque.pviest026 > '0')
                                                            {
                                                                limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                pvlibdep = '1';
                                                            } else if(value.pedidoVendaItemEstoque.pviest01 > '0')
                                                            {
                                                                limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                pvlibfil = '1';
                                                            } else if(value.pedidoVendaItemEstoque.pviest02 > '0' )
                                                            {
                                                                limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                pvlibmat = '1';
                                                            }

                                                        });

                                                    }


                                                    //limiteDisponivel = Number(pedidoVerLiberacao.cliente.clilimite) - (Number(pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas)- Number(limitvall));

                                                    var msg="";
                                                    //msg +="NECESSARIO INFORMAR O(S) CAMPO(S) ABAIXO PARA LIBERAR PEDIDO:<br>";

//				if(pedidoVerLiberacao.TotalItensEstoque==undefined || pedidoVerLiberacao.TotalItensPedidos==undefined)
//				{
//					msg += "<br> - PEDIDOS SEM ITENS OU ESTOQUE VAZIO";
//					alert('PEDIDOS SEM ITENS OU ESTOQUE VAZIO');
//					$("#retorno").messageBox(msg,false, false);
//					return false;
//				}
//
//				if(pedidoVerLiberacao.TotalItensEstoque != pedidoVerLiberacao.TotalItensPedidos)
//				{
//					 alert('PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR');
//					 msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
//					 $("#retorno").messageBox(msg,false, false);
//					 return false;
//				}
                                                    msgPvitem = "";

                                                     if ((dataAnulaValidacaoIbge = '' ||dataAnulaValidacaoIbge < limiteIbge) && usuario.nivel == "2" && (pedidoVerLiberacao.cliente.enderecoFaturamento.cidade.descricao  !=  pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao)) {

                                                        msg += "<br> - CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO";
                                                        alert('CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }


                                                     if (usuario.nivel == "2" && (pedidoVerLiberacao.cliente.clidatavalida == undefined || pedidoVerLiberacao.cliente.clidatavalida == '' ||
                                                     pedidoVerLiberacao.cliente.clidatavalida == null || pedidoVerLiberacao.cliente.clidatavalida == '0')) {

                                                        msg += "<br> - DADOS CADASTRAIS DO CLIENTE NÃO ESTÃO VALIDADOS";
                                                        alert('DADOS CADASTRAIS DO CLIENTE NÃO ESTÃO VALIDADOS ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }


                                                     if ( usuario.nivel == "2" && (new Date().date(pedidoVerLiberacao.cliente.clidatavalida) < dataLimiteCad) ) {

                                                        msg += "<br> - DADOS CADASTRAIS DO CLIENTE ESTÃO DESATUALIZADOS";
                                                        alert('DADOS CADASTRAIS DO CLIENTE ESTÃO DESATUALIZADOS ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }


                                                    cliie = pedidoVerLiberacao.cliente.cliie;


                                                    if(pedidoVerLiberacao.itensPedido==null || pedidoVerLiberacao.itensPedido==undefined || pedidoVerLiberacao.itensPedido=="")
                                                    {
                                                        msg += "<br> - PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR";
                                                        alert('PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;
                                                    }

                                                    if  (!cliie.match(/[0-9]/i)) {
                                                       clienteIsento = true;
                                                   }

                                                    if( pedidoVerLiberacao.cliente.clireceitadataultimaconsulta != undefined
                                                        &&  pedidoVerLiberacao.cliente.clireceitadataultimaconsulta != null ) {
                                                        dataReceita = pedidoVerLiberacao.cliente.clireceitadataultimaconsulta;
                                                        tokens = dataReceita.split("-");
                                                        hora = tokens[2].split(" ");
                                                        dataReceita = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                                        consultaReceita = true;
                                                    }

                                                    if( pedidoVerLiberacao.cliente.clisintegradataultimaconsulta != undefined
                                                        &&  pedidoVerLiberacao.cliente.clisintegradataultimaconsulta != null
                                                        &&  cliie.match(/[0-9]/i)) {
                                                        dataSintegra = pedidoVerLiberacao.cliente.clisintegradataultimaconsulta;
                                                        tokens = dataSintegra.split("-");
                                                        hora = tokens[2].split(" ");
                                                        dataSintegra = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                                        consultaSintegra = true;

                                                    }

                                                    if(pedidoVerLiberacao.cliente.clipessoa != '2' ){
                                                        if( consultaReceita == false || (consultaSintegra == false && clienteIsento == false ))
                                                        {
                                                            msg += "<br> - CLIENTE NAO CONSULTADO NO INTERFIX";
                                                            alert('CLIENTE NAO CONSULTADO NO INTERFIX ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        }else if(( dataReceita < dataLimiteInt ) ||  ( dataSintegra < dataLimiteInt && clienteIsento == false)) {
                                                            msg += "<br> - CONSULTA INTERFIX EXPIRADA";
                                                            alert('CONSULTA INTERFIX EXPIRADA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;

                                                        }else if ( !pedidoVerLiberacao.cliente.clireceitasituacaocadastral.match(/ativ/i)) {
                                                            msg += "<br> - CLIENTE IRREGULAR NA RECEITA";
                                                            alert('CLIENTE IRREGULAR NA RECEITA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        } else if ( (pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == undefined || pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == "" || pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == null ||
                                                        pedidoVerLiberacao.cliente.clisintegrasituacaocadastral.match(/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i)) && clienteIsento == false) {
                                                            msg += "<br> - CLIENTE INATIVO NO SINTEGRA";
                                                            alert('CLIENTE INATIVO NO SINTEGRA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        }
                                                    }


                                                    $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                    {

                                                        var pviest01 = Number(value.pedidoVendaItemEstoque.pviest01);
                                                        var pviest02 = Number(value.pedidoVendaItemEstoque.pviest02);
                                                        var pviest03 = Number(value.pedidoVendaItemEstoque.pviest03);
                                                        var pviest04 = Number(value.pedidoVendaItemEstoque.pviest04);
                                                        var pviest05 = Number(value.pedidoVendaItemEstoque.pviest05);
                                                        var pviest06 = Number(value.pedidoVendaItemEstoque.pviest06);
                                                        var pviest07 = Number(value.pedidoVendaItemEstoque.pviest07);
                                                        var pviest08 = Number(value.pedidoVendaItemEstoque.pviest08);
                                                        var pviest09 = Number(value.pedidoVendaItemEstoque.pviest09);
                                                        //var pviest10 = Number(value.pedidoVendaItemEstoque.pviest10);
                                                        var pviest010 = Number(value.pedidoVendaItemEstoque.pviest010);
                                                        var pviest011= Number(value.pedidoVendaItemEstoque.pviest011);
                                                        var pviest012 = Number(value.pedidoVendaItemEstoque.pviest012);
                                                        var pviest013 = Number(value.pedidoVendaItemEstoque.pviest013);
                                                        var pviest014 = Number(value.pedidoVendaItemEstoque.pviest014);
                                                        var pviest015 = Number(value.pedidoVendaItemEstoque.pviest015);
                                                        var pviest016 = Number(value.pedidoVendaItemEstoque.pviest016);
                                                        var pviest017 = Number(value.pedidoVendaItemEstoque.pviest017);
                                                        var pviest018 = Number(value.pedidoVendaItemEstoque.pviest018);
                                                        var pviest019 = Number(value.pedidoVendaItemEstoque.pviest019);
                                                        var pviest020 = Number(value.pedidoVendaItemEstoque.pviest020);
                                                        var pviest021 = Number(value.pedidoVendaItemEstoque.pviest021);
                                                        var pviest022 = Number(value.pedidoVendaItemEstoque.pviest022);
                                                        var pviest023 = Number(value.pedidoVendaItemEstoque.pviest023);
                                                        var pviest024 = Number(value.pedidoVendaItemEstoque.pviest024);
                                                        var pviest025 = Number(value.pedidoVendaItemEstoque.pviest025);
                                                        var pviest026 = Number(value.pedidoVendaItemEstoque.pviest026);
                                                        var pviest027 = Number(value.pedidoVendaItemEstoque.pviest027);
                                                        var pviest028 = Number(value.pedidoVendaItemEstoque.pviest028);
                                                        var pviest029 = Number(value.pedidoVendaItemEstoque.pviest029);
                                                        var pviest030 = Number(value.pedidoVendaItemEstoque.pviest030);
                                                        var pviest031 = Number(value.pedidoVendaItemEstoque.pviest031);
                                                        var pviest032 = Number(value.pedidoVendaItemEstoque.pviest032);
                                                        var pviest033 = Number(value.pedidoVendaItemEstoque.pviest033);
                                                        var pviest034 = Number(value.pedidoVendaItemEstoque.pviest034);
                                                        var pviest035 = Number(value.pedidoVendaItemEstoque.pviest035);
                                                        var pviest036 = Number(value.pedidoVendaItemEstoque.pviest036);
                                                        var pviest037 = Number(value.pedidoVendaItemEstoque.pviest037);
                                                        var pviest038 = Number(value.pedidoVendaItemEstoque.pviest038);
                                                        var pviest039 = Number(value.pedidoVendaItemEstoque.pviest039);
                                                        var pviest040 = Number(value.pedidoVendaItemEstoque.pviest040);
                                                        var pviest041 = Number(value.pedidoVendaItemEstoque.pviest041);
                                                        var pviest042 = Number(value.pedidoVendaItemEstoque.pviest042);
                                                        var pviest043 = Number(value.pedidoVendaItemEstoque.pviest043);
                                                        var pviest044 = Number(value.pedidoVendaItemEstoque.pviest044);
                                                        var pviest045 = Number(value.pedidoVendaItemEstoque.pviest045);
                                                        var pviest046 = Number(value.pedidoVendaItemEstoque.pviest046);
                                                        var pviest047 = Number(value.pedidoVendaItemEstoque.pviest047);
                                                        var pviest048 = Number(value.pedidoVendaItemEstoque.pviest048);
                                                        var pviest049 = Number(value.pedidoVendaItemEstoque.pviest049);
                                                        var pviest050 = Number(value.pedidoVendaItemEstoque.pviest050);
                                                        var pviest051 = Number(value.pedidoVendaItemEstoque.pviest051);
                                                        var pviest052 = Number(value.pedidoVendaItemEstoque.pviest052);
                                                        var pviest053 = Number(value.pedidoVendaItemEstoque.pviest053);
                                                        var pviest054 = Number(value.pedidoVendaItemEstoque.pviest054);
                                                        var pviest055 = Number(value.pedidoVendaItemEstoque.pviest055);
                                                        var pviest056 = Number(value.pedidoVendaItemEstoque.pviest056);
                                                        var pviest057 = Number(value.pedidoVendaItemEstoque.pviest057);
                                                        var pviest058 = Number(value.pedidoVendaItemEstoque.pviest058);
                                                        var pviest059 = Number(value.pedidoVendaItemEstoque.pviest059);
                                                        var pviest060 = Number(value.pedidoVendaItemEstoque.pviest060);
                                                        var pviest061 = Number(value.pedidoVendaItemEstoque.pviest061);
                                                        var pviest062 = Number(value.pedidoVendaItemEstoque.pviest062);
                                                        var pviest063 = Number(value.pedidoVendaItemEstoque.pviest063);
                                                        var pviest064 = Number(value.pedidoVendaItemEstoque.pviest064);
                                                        var pviest065 = Number(value.pedidoVendaItemEstoque.pviest065);
                                                        var pviest066 = Number(value.pedidoVendaItemEstoque.pviest066);
                                                        var pviest067 = Number(value.pedidoVendaItemEstoque.pviest067);
                                                        var pviest068 = Number(value.pedidoVendaItemEstoque.pviest068);
                                                        var pviest069 = Number(value.pedidoVendaItemEstoque.pviest069);
                                                        var pviest070 = Number(value.pedidoVendaItemEstoque.pviest070);
                                                        var pviest071 = Number(value.pedidoVendaItemEstoque.pviest071);
                                                        var pviest072 = Number(value.pedidoVendaItemEstoque.pviest072);
                                                        var pviest073 = Number(value.pedidoVendaItemEstoque.pviest073);
                                                        var pviest074 = Number(value.pedidoVendaItemEstoque.pviest074);
                                                        var pviest075 = Number(value.pedidoVendaItemEstoque.pviest075);
                                                        var pviest076 = Number(value.pedidoVendaItemEstoque.pviest076);
                                                        var pviest077 = Number(value.pedidoVendaItemEstoque.pviest077);
                                                        var pviest078 = Number(value.pedidoVendaItemEstoque.pviest078);
                                                        var pviest079 = Number(value.pedidoVendaItemEstoque.pviest079);
                                                        var pviest080 = Number(value.pedidoVendaItemEstoque.pviest080);
                                                        var pviest081 = Number(value.pedidoVendaItemEstoque.pviest081);
                                                        var pviest082 = Number(value.pedidoVendaItemEstoque.pviest082);
                                                        var pviest083 = Number(value.pedidoVendaItemEstoque.pviest083);
                                                        var pviest084 = Number(value.pedidoVendaItemEstoque.pviest084);
                                                        var pviest085 = Number(value.pedidoVendaItemEstoque.pviest085);
                                                        var pviest086 = Number(value.pedidoVendaItemEstoque.pviest086);
                                                        var pviest087 = Number(value.pedidoVendaItemEstoque.pviest087);
                                                        var pviest088 = Number(value.pedidoVendaItemEstoque.pviest088);
                                                        var pviest089 = Number(value.pedidoVendaItemEstoque.pviest089);
                                                        var pviest090 = Number(value.pedidoVendaItemEstoque.pviest090);
                                                        var pviest091 = Number(value.pedidoVendaItemEstoque.pviest091);
                                                        var pviest092 = Number(value.pedidoVendaItemEstoque.pviest092);
                                                        var pviest093 = Number(value.pedidoVendaItemEstoque.pviest093);
                                                        var pviest094 = Number(value.pedidoVendaItemEstoque.pviest094);
                                                        var pviest095 = Number(value.pedidoVendaItemEstoque.pviest095);
                                                        var pviest096 = Number(value.pedidoVendaItemEstoque.pviest096);
                                                        var pviest097 = Number(value.pedidoVendaItemEstoque.pviest097);
                                                        var pviest098 = Number(value.pedidoVendaItemEstoque.pviest098);
                                                        var pviest099 = Number(value.pedidoVendaItemEstoque.pviest099);
                                                        var pviindustria = Number(value.pedidoVendaItemEstoque.pviindustria);

                                                        var pvisaldo = Number(value.pedidoVendaItemEstoque.pvisaldo);
                                                        var codigo = value.pedidoVendaItemEstoque.pvicodigo;
                                                        var procodigo = value.pedidoVendaItemEstoque.procodigo;
                                                        var preco = value.pedidoVendaItemEstoque.pvipreco;
                                                        var descricao = value.produto.prnome;
                                                        var procod = value.produto.procod;


                                                        if(preco < 0.02 && preco >=0.01)
                                                        {
                                                            alert("FALHA NO PRECO DO PRODUTO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
                                                            msg += "<br> - FALHA NO PRECO DO PRODUTO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
                                                            $("#retorno").messageBox(msg,false, false);
                                                        //return false;
                                                        }


                                                        if(preco==0 || preco==0.00 || preco==null)
                                                        {
                                                            alert("PRODUTO COM PRECO ZERADO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
                                                            msgPvitem += "<br> - PRODUTO COM PRECO ZERADO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
                                                            $("#retorno").messageBox(msgPvitem,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        }

                                                        if(pviest01 != 0)
                                                        {
                                                            if(pviest01 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 01";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest02 != 0)
                                                        {
                                                            if(pviest02 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 02";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest03 != 0)
                                                        {
                                                            if(pviest03 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 03";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest04 != 0)
                                                        {
                                                            if(pviest04 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 04";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest05 != 0)
                                                        {
                                                            if(pviest05 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 05";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }


                                                        if(pviest06 != 0)
                                                        {
                                                            if(pviest06 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 06";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest07 != 0)
                                                        {
                                                            if(pviest07 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 07";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest08 != 0)
                                                        {
                                                            if(pviest08 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 08";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                   //     if(pviest09 != 0)
                                                        if(pviest026 != 0)
                                                        {
                                                      //      if(pviest09 != pvisaldo)
                                                            if(pviest026 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 09";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        /*	if(pviest10 != 0)
										{
												if(pviest10 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 10";
														$("#retorno").messageBox(msgPvitem,false, false);
														//$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}*/

                                                        if(pviest010 != 0)
                                                        {
                                                            if(pviest010 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 010";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest011 != 0)
                                                        {
                                                            if(pviest011 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 011";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest012 != 0)
                                                        {
                                                            if(pviest012 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 012";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest013 != 0)
                                                        {
                                                            if(pviest013 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 013";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest014 != 0)
                                                        {
                                                            if(pviest014 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 014";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest015 != 0)
                                                        {
                                                            if(pviest015 != pvisaldo)
                                                            {
                                                                alert("CODIGO:  " +  codigo );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 015";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest016 != 0)
                                                        {
                                                            if(pviest016 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 016";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest017 != 0)
                                                        {
                                                            if(pviest017 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 017";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest018 != 0)
                                                        {
                                                            if(pviest018 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 018";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest019 != 0)
                                                        {
                                                            if(pviest019 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 019";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest020 != 0)
                                                        {
                                                            if(pviest020 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 020";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest021 != 0)
                                                        {
                                                            if(pviest021 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 021";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest022 != 0)
                                                        {
                                                            if(pviest022 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 022";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest023 != 0)
                                                        {
                                                            if(pviest023 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 023";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest024 != 0)
                                                        {
                                                            if(pviest024 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 024";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest025 != 0)
                                                        {
                                                            if(pviest025 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 025";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest026 != 0)
                                                        {
                                                            if(pviest026 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 026";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest027 != 0)
                                                        {
                                                            if(pviest027 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 027";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest028 != 0)
                                                        {
                                                            if(pviest028 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 028";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest029 != 0)
                                                        {
                                                            if(pviest029 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 029";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest030 != 0)
                                                        {
                                                            if(pviest030 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 030";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest031 != 0)
                                                        {
                                                            if(pviest031 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 031";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest032 != 0)
                                                        {
                                                            if(pviest032 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 032";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest033 != 0)
                                                        {
                                                            if(pviest033 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 033";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest034 != 0)
                                                        {
                                                            if(pviest034 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 034";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest035 != 0)
                                                        {
                                                            if(pviest035 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 035";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest036 != 0)
                                                        {
                                                            if(pviest036 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 036";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest037 != 0)
                                                        {
                                                            if(pviest037 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 037";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest038 != 0)
                                                        {
                                                            if(pviest038 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 038";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest039 != 0)
                                                        {
                                                            if(pviest039 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 039";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest040 != 0)
                                                        {
                                                            if(pviest040 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 040";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest041 != 0)
                                                        {
                                                            if(pviest041 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 041";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest042 != 0)
                                                        {
                                                            if(pviest042 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 042";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest043 != 0)
                                                        {
                                                            if(pviest043 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 043";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest044 != 0)
                                                        {
                                                            if(pviest044 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 044";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest045 != 0)
                                                        {
                                                            if(pviest045 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 045";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest046 != 0)
                                                        {
                                                            if(pviest046 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 046";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest047 != 0)
                                                        {
                                                            if(pviest047 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 047";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest048 != 0)
                                                        {
                                                            if(pviest048 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 048";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest049 != 0)
                                                        {
                                                            if(pviest049 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 049";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest050 != 0)
                                                        {
                                                            if(pviest050 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 050";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest051 != 0)
                                                        {
                                                            if(pviest051 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 051";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest052 != 0)
                                                        {
                                                            if(pviest052 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 052";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest053 != 0)
                                                        {
                                                            if(pviest053 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 053";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest054 != 0)
                                                        {
                                                            if(pviest054 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 054";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest055 != 0)
                                                        {
                                                            if(pviest055 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 055";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest056 != 0)
                                                        {
                                                            if(pviest056 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 056";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest057 != 0)
                                                        {
                                                            if(pviest057 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 057";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest058 != 0)
                                                        {
                                                            if(pviest058 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 058";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest059 != 0)
                                                        {
                                                            if(pviest059 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 059";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest060 != 0)
                                                        {
                                                            if(pviest060 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 060 ";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest061 != 0)
                                                        {
                                                            if(pviest061 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 061";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest062 != 0)
                                                        {
                                                            if(pviest062 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 062";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest063 != 0)
                                                        {
                                                            if(pviest063 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 063";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest064 != 0)
                                                        {
                                                            if(pviest064 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 064";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest065 != 0)
                                                        {
                                                            if(pviest065 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 065";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest066 != 0)
                                                        {
                                                            if(pviest066 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 066";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest067 != 0)
                                                        {
                                                            if(pviest067 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 067";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest068 != 0)
                                                        {
                                                            if(pviest068 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 068";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest069 != 0)
                                                        {
                                                            if(pviest069 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 069";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest070 != 0)
                                                        {
                                                            if(pviest070 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 070";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest071 != 0)
                                                        {
                                                            if(pviest071 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 071";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest072 != 0)
                                                        {
                                                            if(pviest072 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 072";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest073 != 0)
                                                        {
                                                            if(pviest073 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 073";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest074 != 0)
                                                        {
                                                            if(pviest074 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 074";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest075 != 0)
                                                        {
                                                            if(pviest075 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 075";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest076 != 0)
                                                        {
                                                            if(pviest076 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 076";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest077 != 0)
                                                        {
                                                            if(pviest077 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 077";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                return false;
                                                            }

                                                        }if(pviest078 != 0)
                                                        {
                                                            if(pviest078 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 078";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest079 != 0)
                                                        {
                                                            if(pviest079 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 079";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest080 != 0)
                                                        {
                                                            if(pviest080 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 080";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest081 != 0)
                                                        {
                                                            if(pviest081 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 081";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest082 != 0)
                                                        {
                                                            if(pviest082 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 082";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }

                                                        if(pviest083 != 0)
                                                        {
                                                            if(pviest083 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 083";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest084 != 0)
                                                        {
                                                            if(pviest084 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 084";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest085 != 0)
                                                        {
                                                            if(pviest085 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 085";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest086 != 0)
                                                        {
                                                            if(pviest086 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 086";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest087 != 0)
                                                        {
                                                            if(pviest087 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 087";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest088 != 0)
                                                        {
                                                            if(pviest088 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 088";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest089 != 0)
                                                        {
                                                            if(pviest089 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 089";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest090 != 0)
                                                        {
                                                            if(pviest090 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 090";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest091 != 0)
                                                        {
                                                            if(pviest091 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 091";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest092 != 0)
                                                        {
                                                            if(pviest092 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 092";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }if(pviest093 != 0)
                                                        {
                                                            if(pviest093 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 093";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest094 != 0)
                                                        {
                                                            if(pviest094 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 094";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest095 != 0)
                                                        {
                                                            if(pviest095 != pvisaldo)
                                                            {
                                                                alert("CODIGO:  " +  codigo );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 095";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest096 != 0)
                                                        {
                                                            if(pviest096 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 096";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest097 != 0)
                                                        {
                                                            if(pviest097 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 097";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest098 != 0)
                                                        {
                                                            if(pviest098 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviest099 != 0)
                                                        {
                                                            if(pviest099 != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 099";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }
                                                        if(pviindustria != 0)
                                                        {
                                                            if(pviindustria != pvisaldo)
                                                            {
                                                                alert("ERRO: 425 CODIGO:  " +  procod );
                                                                msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
                                                                $("#retorno").messageBox(msgPvitem,false, false);
                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                return false;
                                                            }

                                                        }



                                                    });

                                                    if(msgPvitem != "")
                                                    {
                                                        msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                    }

				msgEstoque = "";

				 if(pedidoVerLiberacao.tipoPedido.sigla!='I' && pedidoVerLiberacao.pvvinculo==null)
				 {
				$.each(pedidoVerLiberacao.itensPedido, function (key, value)
						{
					$.each(value.pedidoVendaItemEstoque, function (key, value2)
							{
                                                            if (value2 == null ) {return !false;} // caso o campo seja null o each não terminará
                                if(value2.pviest011 < 0)
				{
					msgEstoque += "Estoque".value2.pviecodigo;

				}
							});
						});
				if(msgEstoque!="")
				{
				msg += msgEstoque;
				alert(msg);
				$("#retorno").messageBox(msg,false, false);
				return false;
				}
				 }

				valorPrefechamento = 0;
				$.each(pedidoVerLiberacao.preFechamento, function (key, value)
						{
					if(value.fecforma=='101' || value.fecforma=='103' || value.fecforma=='110')
					{
							valorPrefechamento += Number(value.fecvalor);
					}

						});
                                                
                                totalDebts = Number(pedidoVerLiberacao.cliente.vendasEmAberto.cobrancaAberto)+Number(valorPrefechamento);

//				if(valorPrefechamento >= pedidoVerLiberacao.cliente.clilimite)
                                if(totalDebts > pedidoVerLiberacao.cliente.clilimite)
				{
					msg += "<br> - PARCELAMENTO MAIOR QUE O LIMITE";
					alert('PARCELAMENTO MAIOR QUE O LIMITE');
					$("#retorno").messageBox(msg,false, false);
					return false;
				}
                                                    /*
			if(pedidoVerLiberacao.pvlibera!=null && pedidoVerLiberacao.pvhora!=null)
			{
				msg += "<br> - ESTE PEDIDO JA FOI LIBERADO";
				alert('ESTE PEDIDO JA FOI LIBERADO');
				$("#retorno").messageBox(msg,false, false);
				//$("#btnLiberacaoPedido").attr('disabled', '');
				return false;

			}
			*/

                                                    data = new Date();
                                                    dia = data.getDate();
                                                    mes = data.getMonth();
                                                    ano = data.getFullYear();
                                                    hora = data.getHours();
                                                    min = data.getMinutes();
                                                    seg = data.getSeconds();

                                                    meses = new Array(12);

                                                    meses[0] = "01";
                                                    meses[1] = "02";
                                                    meses[2] = "03";
                                                    meses[3] = "04";
                                                    meses[4] = "05";
                                                    meses[5] = "06";
                                                    meses[6] = "07";
                                                    meses[7] = "08";
                                                    meses[8] = "09";
                                                    meses[9] = "10";
                                                    meses[10] = "11";
                                                    meses[11] = "12";

                                                    dias = new Array(12);

                                                    dias[0] = "00";
                                                    dias[1] = "01";
                                                    dias[2] = "02";
                                                    dias[3] = "03";
                                                    dias[4] = "04";
                                                    dias[5] = "05";
                                                    dias[6] = "06";
                                                    dias[7] = "07";
                                                    dias[8] = "08";
                                                    dias[9] = "09";
                                                    dias[10] = "10";
                                                    dias[11] = "11";
                                                    dias[12] = "12";
                                                    dias[13] = "13";
                                                    dias[14] = "14";
                                                    dias[15] = "15";
                                                    dias[16] = "16";
                                                    dias[17] = "17";
                                                    dias[18] = "18";
                                                    dias[19] = "19";
                                                    dias[20] = "20";
                                                    dias[21] = "21";
                                                    dias[22] = "22";
                                                    dias[23] = "23";
                                                    dias[24] = "24";
                                                    dias[25] = "25";
                                                    dias[26] = "26";
                                                    dias[27] = "27";
                                                    dias[28] = "28";
                                                    dias[29] = "29";
                                                    dias[30] = "30";
                                                    dias[31] = "31";

                                                    dataHoje  =  ano+'-'+meses[mes]+'-'+dias[dia]+' '+hora+':'+min+':'+seg;

                                                    dataSerasa = new Date().date(pedidoVerLiberacao.cliente.cliserasa);


                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='S')
                                                    {
                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='Z')
                                                        {
                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='M')
                                                            {
                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='D')
                                                                {
                                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='F')
                                                                    {
                                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='B')
                                                                        {
                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='X')
                                                                            {
                                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='EP')
                                                                                {



                                                                                    if(pedidoVerLiberacao.cliente.enderecoFaturamento.clenumero==undefined ||pedidoVerLiberacao.cliente.enderecoFaturamento.clenumero==null)
                                                                                    {
                                                                                        msg += "<br> - ENDERECO PREENCHIDO DE FORMA INCORRETA";
                                                                                        alert('ENDERECO PREENCHIDO DE FORMA INCORRETA');
                                                                                        $('#tblAlteraNumero').show();
                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                        return false;
                                                                                    }


                                                                                    if(pedidoVerLiberacao.cliente.enderecoFaturamento.clecep==undefined || pedidoVerLiberacao.cliente.enderecoFaturamento.clecep==null)
                                                                                    {
                                                                                        msg += "INFORME UM CEP VERDADEIRO";
                                                                                        alert('INFORME UM CEP VERDADEIRO');
                                                                                        $('#tblAlteraNumero').show();
                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                        return false;
                                                                                    }

                                                                                    if(usuario.nivel == "2" && (pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao==null ||pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao=="" ||pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao==undefined))
                                                                                    {
                                                                                        msg += "<br> - CIDADE IBGE NAO ESTA PREENCHIDA";
                                                                                        alert('CIDADE IBGE NAO ESTA PREENCHIDA');
                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                        return false;
                                                                                    }

                                                                                    if(pedidoVerLiberacao.fecreserva!='1')
                                                                                    {
                                                                                        if(pedidoVerLiberacao.preFechamento==undefined || pedidoVerLiberacao.preFechamento==null)
                                                                                        {
                                                                                            msg += "<br> - NECESSARIO FAZER O PREFECHAMENTO";
                                                                                            alert('NECESSARIO FAZER O PREFECHAMENTO');
                                                                                            $("#retorno").messageBox(msg,false, false);
                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                            return false;
                                                                                        }
                                                                                    }
                                                                                    msgPreFec = "";

                                                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='R')
                                                                                    {
                                                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='I')
                                                                                        {

                                                                                            $.each(pedidoVerLiberacao.preFechamento, function (key, value)
                                                                                            {

                                                                                                if(value.fecforma !='100')
                                                                                                {
                                                                                                    if(value.fecforma !='102')
                                                                                                    {
                                                                                                        if(value.fecforma !='105')
                                                                                                        {
                                                                                                            if(value.fecforma !='104')
                                                                                                            {
//                                                                                                                if(pedidoVerLiberacao.cliente.cliserasaexp < dataHoje)
                                                                                                                if(dataSerasa < dataLimiteSer)
                                                                                                                {
                                                                                                                    msg += "SERASA EXPIRADO";
                                                                                                                    alert('SERASA EXPIRADO');
                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                    msgPreFec +="SERASA EXPIRADO";
                                                                                                                    return false;
                                                                                                                }

                                                                                                                if((value.fecforma == '101' || value.fecforma == '103') && value.fecdia == '0') {
                                                                                                                    msg += "PREFECHAMENTO COM DIA DE VENCIMENTO = 0";
                                                                                                                    alert('PREFECHAMENTO COM DIA DE VENCIMENTO = 0');
                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                    msgPreFec +="PREFECHAMENTO COM DIA DE VENCIMENTO = 0";
                                                                                                                    return false;
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                
//                                                                                                if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && value.fecforma=='101')
//                                                                                                {
//                                                                                                    msg += "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA";
//                                                                                                    alert('FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }
//                                                                                                if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && (value.fecforma=='103' || value.fecforma=='110'))
//                                                                                                {
//                                                                                                    msg += "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE";
//                                                                                                    alert('FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }
//
//                                                                                                if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && value.fecforma=='101')
//                                                                                                {
//                                                                                                    msg += "<br> - FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA";
//                                                                                                    alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }
//
//                                                                                                if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && (value.fecforma=='103' || value.fecforma=='110'))
//                                                                                                {
//                                                                                                    msg += "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA CHEQUE";
//                                                                                                    alert('FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA CHEQUE');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }
//                                                                                                if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (value.fecforma=='101'))
//                                                                                                {
//                                                                                                    msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
//                                                                                                    alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }
//
//                                                                                                if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (value.fecforma=='103' || value.fecforma=='110'))
//                                                                                                {
//                                                                                                    msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
//                                                                                                    alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
//                                                                                                    $("#retorno").messageBox(msg,false, false);
//                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                    return false;
//                                                                                                }

                                                                                                if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3 || (totalDebts > pedidoVerLiberacao.cliente.clilimite)) && (value.fecforma=='101' ||value.fecforma=='103' || value.fecforma=='110'))
                                                                                                {
                                                                                                    msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
                                                                                                    alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                    msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
                                                                                                    return false;
                                                                                                }


                                                                                            });
                                                                                        }
                                                                                    }

                                                                                    if(msgPreFec!="")
                                                                                    {
//                                                                                        msg += msgPreFec;
//                                                                                        alert("NO msgPreFec"+msg);
//                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                        return false;
                                                                                    }

                                                                                    //alert (pedidoVerLiberacao.preFechamento.fecforma);
                                                                                    //if((pedidoVerLiberacao.cliente.vendasEmAberto) > pedidoVerLiberacao.cliente.clilimite))
                                                                                    //{
                                                                                    //	msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
                                                                                    //	alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                    //	$("#retorno").messageBox(msg,false, false);
                                                                                    //	return false;
                                                                                    //}

                                                                                    if(pedidoVerLiberacao.tipoPedido.sigla=='I' && pedidoVerLiberacao.pvvinculo!=null)
                                                                                    {
                                                                                        valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                    }else{
                                                                                        $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                        {
                                                                                            if(value.pedidoVendaItemEstoque.pviest011 > '0')
                                                                                            {
                                                                                                estoqueOrigem = "VIX";
                                                                                            }else
                                                                                            {
                                                                                                estoqueOrigem = "SP";
                                                                                            }
                                                                                        });
                                                                                        estoqueDestino = pedidoVerLiberacao.cliente.enderecoFaturamento.cidade.uf;


                                                                                        if((estoqueOrigem=="SP" && estoqueDestino=="BA") || (estoqueOrigem=="SP" && estoqueDestino=="MG") || (estoqueOrigem=="SP" && estoqueDestino=="RS"))
                                                                                        {
                                                                                            valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc) + pedidoVerLiberacao.calculoSt.substituicao;
                                                                                        }else
                                                                                        if((estoqueOrigem=="SP" && estoqueDestino=="SC") || (estoqueOrigem=="SP" && estoqueDestino=="RJ"))
                                                                                        {
                                                                                            valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                        }else
                                                                                        if((estoqueOrigem=="ES" && estoqueDestino=="BA") || (estoqueOrigem=="ES" && estoqueDestino=="MG") || (estoqueOrigem=="ES" && estoqueDestino=="SC") || (estoqueOrigem=="ES" && estoqueDestino=="RJ") || (estoqueOrigem=="ES" && estoqueDestino=="RS"))
                                                                                        {
                                                                                            valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                        }else{
                                                                                            valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                        }
                                                                                    }

                                                                                    valPreFechamento = parseFloat(pedidoVerLiberacao.TotalValorPreFechamento);
                                                                                    if(pedidoVerLiberacao.fecreserva!='1')
                                                                                    {
                                                                                        if(valPreFechamento.toFixed(2) != valPedido.toFixed(2))
                                                                                        {
                                                                                            msg += "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
                                                                                            alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
                                                                                            $("#retorno").messageBox(msg,false, false);
                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                            return false;
                                                                                        }
                                                                                    }

                                                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='R')
                                                                                    {
                                                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='I')
                                                                                        {
                                                                                            if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && pedidoVerLiberacao.preFechamento.fecforma=='101')
                                                                                            {
                                                                                                msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
                                                                                                alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                return false;
                                                                                            }
                                                                                            if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && (pedidoVerLiberacao.preFechamento.fecforma=='103' || pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                            {
                                                                                                msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA CHEQUE";
                                                                                                alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                return false;
                                                                                            }

                                                                                            if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && pedidoVerLiberacao.preFechamento.fecforma=='101')
                                                                                            {
                                                                                                msg += "<br> - LIMITE ZERO. NAO ACEITA DUPLICATA";
                                                                                                alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                return false;
                                                                                            }
                                                                                            if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && (pedidoVerLiberacao.preFechamento.fecforma=='103' || pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                            {
                                                                                                msg += "<br> - LIMITE ZERO. NAO ACEITA CHEQUE";
                                                                                                alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                return false;
                                                                                            }

                                                                                            if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (pedidoVerLiberacao.preFechamento.fecforma=='101' || pedidoVerLiberacao.preFechamento.fecforma=='103' ||pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                            {
                                                                                                msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
                                                                                                alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                return false;
                                                                                            }
                                                                                        }
                                                                                    }

                                                                                    $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                    {
                                                                                        //alert(value.produto.grupo.grucodigo  + value.produto.grupo.grunome + pedidoVerLiberacao.cliente.clifat);
                                                                                        if(pedidoVerLiberacao.cliente.clifat== 4 && value.produto.grupo.grucodigo == 6)
                                                                                        {
                                                                                            msg += "<br> - CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL";
                                                                                            alert('CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL ');
                                                                                            $("#retorno").messageBox(msg,false, false);
                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                            return false;
                                                                                        }
                                                                                    });


                                                                                    msgCodB = "";
                                                                                    $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                    {
                                                                                        //alert(value.produto.classificacaoFiscal.clanumero);
                                                                                        if(value.produto.classificacaoFiscal.clanumero==0 || value.produto.classificacaoFiscal.clanumero=="")
                                                                                        {
                                                                                            msgCodB += "<br /> - PRODUTO SEM CLASSIFICACAO FISCAL"+ value.clacodigo;
                                                                                            alert("PRODUTO SEM CLASSIFICACAO FISCAL" + value.produto.classificacaoFiscal.clacodigo);
                                                                                            $("#retorno").messageBox(msgCodB,false, false);
                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                            return false;
                                                                                        }
                                                                                        //alert(value.produto.codigoBarra.barunidade);
                                                                                        if(value.produto.codigoBarra.barunidade==null || value.produto.codigoBarra.barunidade==0 || value.produto.codigoBarra.barunidade=="")
                                                                                        {
                                                                                            msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA UNIDADE"+ value.produto.prnome;
                                                                                            alert("PRODUTO SEM CODIGO DE BARRA NA UNIDADE" +  value.produto.prnome);
                                                                                            $("#retorno").messageBox(msgCodB,false, false);
                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                            return false;
                                                                                        }
                                                                                    //alert(value.produto.codigoBarra.barcaixa);
                                                                                    //if(value.produto.codigoBarra.barcaixa==null || value.produto.codigoBarra.barcaixa==0 || value.produto.codigoBarra.barcaixa=="")
                                                                                    //{
                                                                                    //	msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA CAIXA"+ value.produto.prnome;
                                                                                    //	alert("PRODUTO SEM CODIGO DE BARRA NA CAIXA" +  value.produto.prnome);
                                                                                    ///	$("#retorno").messageBox(msgCodB,false, false);
                                                                                    //	return false;
                                                                                    //}
                                                                                    });
                                                                                    if(msgCodB != "")
                                                                                    {
                                                                                        msg += "<br> - PRODUTO SEM CODIGO DE BARRA";
                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                        return false;

                                                                                    }

                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }


//alert(
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibdep+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibfil+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibmat+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibvit
//
//);
                                    pedidoEnvia = new Object();
                                    pedidoEnvia.pvemissao =  pedidoVerLiberacao.pvemissao;
                                    pedidoEnvia.pvlibera =  $('#dataAtual').val();
                                    pedidoEnvia.pvhora = $('#horaAtual').val();
                                    pedidoEnvia.pvurgente = '0';
                                    pedidoEnvia.pvnumero = pedidoVerLiberacao.pvnumero;
                                    pedidoEnvia.usuario = usuario.codigo;
//                                    pedidoEnvia.pvlibdep = (pedidoVerLiberacao.pvlibdep == null || pedidoVerLiberacao.pvlibdep == undefined)? pvlibdep : pedidoVerLiberacao.pvlibdep; //pedidoVerLiberacao.pvlibdep;
//                                    pedidoEnvia.pvlibfil = (pedidoVerLiberacao.pvlibfil == null || pedidoVerLiberacao.pvlibfil == undefined)? pvlibfil : pedidoVerLiberacao.pvlibfil;  //pedidoVerLiberacao.pvlibfil;
//                                    pedidoEnvia.pvlibmat = (pedidoVerLiberacao.pvlibfil == null || pedidoVerLiberacao.pvlibfil == undefined)? pvlibmat : pedidoVerLiberacao.pvlibmat; //pedidoVerLiberacao.pvlibmat;
//                                    pedidoEnvia.pvlibvit = (pedidoVerLiberacao.pvlibfil == null || pedidoVerLiberacao.pvlibfil == undefined)? pvlibvit : pedidoVerLiberacao.pvlibvit; //pedidoVerLiberacao.pvlibvit;
                                    pedidoEnvia.pvlibdep = ((pedidoVerLiberacao.pvlibdep != "" && pedidoVerLiberacao.pvlibdep != null && pedidoVerLiberacao.pvlibdep != undefined) || pvlibdep != '')? '1' : null; //pedidoVerLiberacao.pvlibdep;
                                    pedidoEnvia.pvlibfil = ((pedidoEnvia.pvlibdep !== '1') && ((pedidoVerLiberacao.pvlibfil != "" && pedidoVerLiberacao.pvlibfil != null && pedidoVerLiberacao.pvlibfil != undefined) || pvlibfil != '' ))? '1' : null;  //pedidoVerLiberacao.pvlibfil;
                                    pedidoEnvia.pvlibmat = ((pedidoEnvia.pvlibdep !== '1' && pedidoEnvia.pvlibfil !== '1' ) && ((pedidoVerLiberacao.pvlibmat != "" && pedidoVerLiberacao.pvlibmat != null && pedidoVerLiberacao.pvlibmat != undefined) || pvlibmat != '') )? '1' : null; //pedidoVerLiberacao.pvlibmat;
                                    pedidoEnvia.pvlibvit = ((pedidoEnvia.pvlibdep !== '1' && pedidoEnvia.pvlibfil !== '1'  && pedidoEnvia.pvlibmat !== '1' ) &&  ((pedidoVerLiberacao.pvlibvit != "" && pedidoVerLiberacao.pvlibvit != null && pedidoVerLiberacao.pvlibvit != undefined) || pvlibvit != '') )? '1' : null; //pedidoVerLiberacao.pvlibvit;

                                    loglibera =  new Object();
                                    loglibera.usucodigo = usuario.codigo;
                                    loglibera.clicodigo = pedidoVerLiberacao.cliente.clicodigo;
                                    loglibera.lglpedido = pedidoVerLiberacao.pvnumero;
                                    loglibera.lgltipo = pedidoVerLiberacao.tipoPedido.sigla;
                                    loglibera.lgldata =  $('#dataAtual').val();
                                    loglibera.lglhora = $('#horaAtual').val();


                                   //Envio do pedido para validação
//                                   $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
//                                    {
//                                        //variaveis a ser enviadas metodo POST
//                                        id2:id,
//                                        usuario:usuario.codigo,
//                                        acao:9
//
//                                    },

//alert(
//
//                                 "3248\n pedidoEnvia.pvemissao " +  pedidoEnvia.pvemissao
//                                 +"\n pedidoEnvia.pvlibera " +  pedidoEnvia.pvlibera
//                                 +"\n pedidoEnvia.pvhora " + pedidoEnvia.pvhora
//                                 +"\n pedidoEnvia.pvurgente " + pedidoEnvia.pvurgente
//                                 +"\n pedidoEnvia.pvnumero " + pedidoEnvia.pvnumero
//                                 +"\n pedidoEnvia.usuario " + pedidoEnvia.usuario
//                                 +"\n pedidoEnvia.pvlibdep " + pedidoEnvia.pvlibdep
//                                 +"\n pedidoEnvia.pvlibfil " + pedidoEnvia.pvlibfil
//                                 +"\n pedidoEnvia.pvlibmat " + pedidoEnvia.pvlibmat
//                                 +"\n pedidoEnvia.pvlibvit " + pedidoEnvia.pvlibvit
//
//                                 +"\n loglibera.usucodigo " + loglibera.usucodigo
//                                 +"\n loglibera.clicodigo " + loglibera.clicodigo
//                                 +"\n loglibera.lglpedido " + loglibera.lglpedido
//                                 +"\n loglibera.lgltipo " + loglibera.lgltipo
//                                 +"\n loglibera.lgldata " +  loglibera.lgldata
//                                 +"\n loglibera.lglhora " + loglibera.lglhora
//
//);
                                   $.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
                                                                {
                                                                    pedido2:JSON.stringify(pedidoEnvia),
                                                                    loglibera:JSON.stringify(loglibera),
                                                                    acao:2
                                                                },
                                    function(data)
                                    {
                                                //                                        if (Boolean(data.retorno))
                                                if (Boolean(Number(data.retorno)))
                                                {
                                                    alert(data.mensagem);

                                                    $("#"+id).attr("style", "background: #4682B4");
                                                    $("#"+id).hide();
                                                } else {



                                                    if ( data.codigo == '424') {
                                                        $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                                        {
                                                            //variaveis a ser enviadas metodo POST
                                                            id2:id,
                                                            usuario:usuario.codigo,
                                                            acao:9

                                                        },
                                                        function(data2)
                                                        {
                                                            if (Boolean(data2.retorno))
                                                            {
                                                                alert(data2.mensagem);

                                                                $("#"+id).attr("style", "background: #4682B4");
                                                                $("#"+id).hide();
                                                            }
                                                            else if (pvlibdep == '1'){

                                                                $.get('exportawmspedidos.php',
                                                                {
                                                                    pedido:id

                                                                }
                                                                );

                                                            }
                                                            alert(data2.mensagem);
                                                            $("#"+id).hide();
                                                        },'json');
                                                    } else if ( data.codigo == '2') {
                                                        alert(data.mensagem);
                                                    //                                                            $("#dvSituacao"+id).html('<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+pedidoVerLiberacao.pvnumero+'" email="'+usuario.email+'" prefechamento="'+valorPrefechamento+'" name="financeiro">FINANCEIRO</a>');
                                                    }
                                                    else {
                                                        
                                                        
                                                        if (pvlibdep == '1'){
                                                            $.get('exportawmspedidos.php',
                                                            {
                                                                pedido:id

                                                            }
                                                            );
                                                        }
                                                        $("#"+id).hide();
                                                        alert(data.mensagem);
                                                    }

                                                }
                                            },'json');
                                    $("#"+id).attr("style", "background: #4682B4");

                                    


                                                } // FIM ANÁLISE PARA REALIZAR A LIBERAÇÃO DO PEDIDO
                                                                                                    else{
                                                                                                        alert("FALHA EM REALIZAR A LIBERAÇÃO");
                                                                                                    }
                                                                                                },'json');

                                });


                    $('a[name=enviarPendencias]').click(function()
                    {
                        var pvnumero = $(this).attr("pvnumero");

                        $('#dialog').attr('title','ENVIAR PENDENCIAS');

                        var mensagem = "PEDIDO COM PENDENCIAS, ENVIAR MENSAGEM PARA O(S) RESPONSAVEL(EIS).";

                        var html = '<p>'+
                        '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                        mensagem+
                        '</p><form id="formEnvio" name="formEnvio" method="post" action="#">';

                        html += 'email: <input align="middle" type="text" id="txtMail" name="txtMail" size="65">'+
                        '<hr size="1">'+
                        '<textarea name="txtObs" id="txtObs" cols="70" rows="3">'+$('#pendencia'+pvnumero).val()+'</textarea>'+
                        '</form><h5>OBS.: MAIS DE UM EMAIL UTILIZAR PONTO E VIRGULA(;) PARA SEPARAR.<h5>';

                        $('#dialog').html(html);

                        $('#dialog').dialog(
                        {
                            autoOpen: true,
                            modal: true,
                            width: 480,
                            buttons:
                            {
                                "ENVIAR": function()
                                {
                                    if ($("#formEnvio").validate().form())
                                    {
                                        $.post('modulos/vendaAtacado/pedidos/adm/controller/enviarMensagem.php',
                                        {
                                            //variaveis a ser enviadas metodo POST
                                            txtMail:$('#txtMail').val(),
                                            txtObs:$('#txtObs').val().toUpperCase(),
                                            pvnumero:pvnumero,
                                            from:usuario.email
                                        },
                                        function(data)
                                        {
                                            var mensagem = "";
                                            if (Boolean(data))
                                            {
                                                mensagem = "EMAIL(S) PENDENCIA(S) ENVIADO(S) COM SUCESSO PARA '"+$('#txtMail').val()+"'.";
                                            }
                                            else
                                            {
                                                mensagem = "EMAIL(S) PENDENCIA(S) NAO ENVIADO(S) PARA '"+$('#txtMail').val()+"'";
                                            }

                                            $("#retorno").messageBox(mensagem, data, data);

                                            $('#dialog').dialog("close");

                                        },'json');


                                    }
                                },
                                "FECHAR": function()
                                {
                                    $(this).dialog("close");
                                }
                            },
                            close: function(ev, ui)
                            {
                                $(this).dialog("destroy");
                            }
                        });

                        // Validar formulario ao clicar enviar
                        $("#formEnvio").validate(
                        {
                            rules:
                            {
                                txtMail:
                                {
                                    required: true,
                                    multiemail: true
                                }
                            },
                            messages:
                            {
                                txtMail:
                                {
                                    required: "Preencha Campo Obrigatorio!"
                                }
                            }
                        });
                    });

                    $('a[name=financeiro]').click(function()
                    {


                        var id = $(this).attr("id");
                        prefechamento = $(this).attr("prefechamento");
                        email = $(this).attr("email");
                        dados = $(this).attr("dados");

                         var   prazolimiteInt = 0;
                         var   prazolimiteCad = 0;
                         var   prazolimiteSer = 0;


//                        var limite = new Date();
//                        limite.setDate(limite.getDate()-180);
//                        limite = new Date(limite);

                        var limiteIbge = new Date();
                        limiteIbge.setDate(limiteIbge.getDate()-2);
                        limiteIbge = new Date(limiteIbge);


                        $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                        {
                            //variaveis a ser enviadas metodo POST
                            id:id,
                            acao:10

                        },
                        function(data)
                        {
                            pedido2 = data;
                            clicodigo = pedido2.estacionamento.cliente.clicodigo;
                            consultaReceita = false;
                            consultaSintegra = false;
                            dataReceita = "";
                            dataSintegra = "";
                            cliie = pedido2.estacionamento.cliente.cliie;
                            clienteIsento = false; // Verifica se o cliente é isento de I.E.

                            $.each(pedido2.estacionamento.cliente.prazoExpiracao.resultado, function (key, value2){
//                                                                            alert( "value2.pedescricao: "+ value2.pedescricao +"\n value2.peprazo"+value2.peprazo);
                                            if(value2.pedescricao === 'INTERFIX')
                                            {
                                                    prazolimiteInt = value2.peprazo;
                                            } else if (value2.pedescricao === 'CADASTRO') {
                                                    prazolimiteCad = value2.peprazo;
                                            } else if (value2.pedescricao === 'SERASA') {
                                                    prazolimiteSer = value2.peprazo;
                                            }
                            });


                            limitePrazo = new Date();
    // alert ( "Look a test: "+limitePrazo );
                            limitePrazo.setDate( limitePrazo.getDate() - prazolimiteInt );
                            dataLimiteInt = new Date(limitePrazo);
    // alert ( "Look a testInt: "+limitePrazo );
                            limitePrazo = new Date();
                            limitePrazo.setDate( limitePrazo.getDate() - prazolimiteCad );
                            dataLimiteCad = new Date(limitePrazo);
    // alert ( "Look a test Cad: "+limitePrazo );
                            limitePrazo = new Date();
                            limitePrazo.setDate( limitePrazo.getDate() - prazolimiteSer );
                            dataLimiteSer = new Date(limitePrazo);



                            var dataAnulaValidacaoIbge = pedido2.estacionamento.cliente.clilibibgediferente ? new Date().date(pedido2.estacionamento.cliente.clilibibgediferente) : '';

                           if  (!cliie.match(/[0-9]/i)) {
                               clienteIsento = true;
                           }

//var dataSerasaExp = data.estacionamento.cliente.cliserasaexp ? new Date().date(data.estacionamento.cliente.cliserasaexp) : '';
//alert(dataAtual.getMonthsBetween(dataSerasaExp));

                            if( pedido2.estacionamento.cliente.clireceitadataultimaconsulta != undefined
                                &&  pedido2.estacionamento.cliente.clireceitadataultimaconsulta != null ) {
                                dataReceita = pedido2.estacionamento.cliente.clireceitadataultimaconsulta;
                                tokens = dataReceita.split("-");
                                hora = tokens[2].split(" ");
                                dataReceita = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                consultaReceita = true;
                            }

                            if( pedido2.estacionamento.cliente.clisintegradataultimaconsulta != undefined
                                &&  pedido2.estacionamento.cliente.clisintegradataultimaconsulta != null
                                &&  cliie.match(/[0-9]/i)) {
                                dataSintegra = pedido2.estacionamento.cliente.clisintegradataultimaconsulta;
                                tokens = dataSintegra.split("-");
                                hora = tokens[2].split(" ");
                                dataSintegra = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                consultaSintegra = true;

                            }

                            if(pedido2.estacionamento.valorPreFechamento== null ||pedido2.estacionamento.valorPreFechamento=='0')
                            {
                                $('#dialog').attr('title','PEDIDO SEM PREFECHAMENTO');

                                mensagem = "PEDIDO SEM PREFECHAMENTO NAO PODERA IR PARA O FINANCEIRO";

                                html = '<p>'+
                                '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                mensagem;

                                $('#dialog').html(html);

                                $('#dialog').dialog(
                                {
                                    autoOpen: true,
                                    modal: true,
                                    width: 480,
                                    buttons:
                                    {
                                        "FECHAR": function()
                                        {
                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function(ev, ui)
                                    {
                                        $(this).dialog("destroy");
                                    }
                                });



                            }else 
                                        if(pedido2.estacionamento.cliente.clipessoa != '2' && (consultaReceita == false || (consultaSintegra == false && clienteIsento == false )))
                                        {
                                        $('#dialog').attr('title','SEM CONSULTA NO INTERFIX');

        //                                mensagem = "CLIENTE NAO CONSULTADO NO INTERFIX: NAO PODERA IR PARA O FINANCEIRO";
                                        mensagem = "CLIENTE NAO CONSULTADO NO INTERFIX";

                                        html = '<p>'+
                                        '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                        mensagem;

                                        $('#dialog').html(html);

                                        $('#dialog').dialog(
                                        {
                                            autoOpen: true,
                                            modal: true,
                                            width: 480,
                                            buttons:
                                            {
                                                "FECHAR": function()
                                                {
                                                    $(this).dialog("close");
                                                }
                                            },
                                            close: function(ev, ui)
                                            {
                                                $(this).dialog("destroy");
                                            }
                                        });

                                    }
                                    else

                                       if(pedido2.estacionamento.cliente.clipessoa != '2' && (( dataReceita < dataLimiteInt ) ||  ( dataSintegra < dataLimiteInt && clienteIsento == false)))
                                    {
                                        $('#dialog').attr('title','CONSULTA INTERFIX EXPIRADA');

        //                                mensagem = "CONSULTA INTERFIX EXPIRADA: NAO PODERA IR PARA O FINANCEIRO";
                                        mensagem = "CONSULTA INTERFIX EXPIRADA";

                                        html = '<p>'+
                                        '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                        mensagem;

                                        $('#dialog').html(html);

                                        $('#dialog').dialog(
                                        {
                                            autoOpen: true,
                                            modal: true,
                                            width: 480,
                                            buttons:
                                            {
                                                "FECHAR": function()
                                                {
                                                    $(this).dialog("close");
                                                }
                                            },
                                            close: function(ev, ui)
                                            {
                                                $(this).dialog("destroy");
                                            }
                                        });

                                    }
                                    else if(pedido2.estacionamento.cliente.clipessoa != '2' && (!pedido2.estacionamento.cliente.clireceitasituacaocadastral.match(/ativ/i)))
                                    {
                                        $('#dialog').attr('title','CLIENTE IRREGULAR NA RECEITA');

        //                                mensagem = "CLIENTE IRREGULAR NA RECEITA: NAO PODERA IR PARA O FINANCEIRO";
                                        mensagem = "CLIENTE IRREGULAR NA RECEITA";

                                        html = '<p>'+
                                        '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                        mensagem;

                                        $('#dialog').html(html);

                                        $('#dialog').dialog(
                                        {
                                            autoOpen: true,
                                            modal: true,
                                            width: 480,
                                            buttons:
                                            {
                                                "FECHAR": function()
                                                {
                                                    $(this).dialog("close");
                                                }
                                            },
                                            close: function(ev, ui)
                                            {
                                                $(this).dialog("destroy");
                                            }
                                        });

                                    }
                                    else if(pedido2.estacionamento.cliente.clipessoa != '2' && ( (pedido2.estacionamento.cliente.clisintegrasituacaocadastral == undefined || pedido2.estacionamento.cliente.clisintegrasituacaocadastral == "" || pedido2.estacionamento.cliente.clisintegrasituacaocadastral == null ||
                                                            pedido2.estacionamento.cliente.clisintegrasituacaocadastral.match(/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i)) && clienteIsento == false))
                                        {
                                        $('#dialog').attr('title','CLIENTE INATIVO NO SINTEGRA');

        //                                mensagem = "CLIENTE INATIVO NO SINTEGRA': NAO PODERA IR PARA O FINANCEIRO";
                                        mensagem = "CLIENTE INATIVO NO SINTEGRA";

                                        html = '<p>'+
                                        '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                        mensagem;

                                        $('#dialog').html(html);

                                        $('#dialog').dialog(
                                        {
                                            autoOpen: true,
                                            modal: true,
                                            width: 480,
                                            buttons:
                                            {
                                                "FECHAR": function()
                                                {
                                                    $(this).dialog("close");
                                                }
                                            },
                                            close: function(ev, ui)
                                            {
                                                $(this).dialog("destroy");
                                            }
                                        });

                                    }

                       



    //                                {
//                                $('#dialog').attr('title','DADOS DIVERGENTES');
//
//                                mensagem = "CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO";
//
//                                html = '<p>'+
//                                '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
//                                mensagem;
//
//                                $('#dialog').html(html);
//
//                                $('#dialog').dialog(
//                                {
//                                    autoOpen: true,
//                                    modal: true,
//                                    width: 480,
//                                    buttons:
//                                    {
//                                        "FECHAR": function()
//                                        {
//                                            $(this).dialog("close");
//                                        }
//                                    },
//                                    close: function(ev, ui)
//                                    {
//                                        $(this).dialog("destroy");
//                                    }
//                                });
//
//                            }

/*
                            else if( usuario.nivel == "2" && (pedido2.estacionamento.cliente.clidatavalida == undefined || pedido2.estacionamento.cliente.clidatavalida == '' || pedido2.estacionamento.cliente.clidatavalida == null || pedido2.estacionamento.cliente.clidatavalida == '0'))
                                {
                                $('#dialog').attr('title','DADOS CADASTRAIS NÃO VALIDADOS');

                                mensagem = "DADOS CADASTRAIS DO CLIENTE NÃO ESTÃO VALIDADOS";

                                html = '<p>'+
                                '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                mensagem;

                                $('#dialog').html(html);

                                $('#dialog').dialog(
                                {
                                    autoOpen: true,
                                    modal: true,
                                    width: 480,
                                    buttons:
                                    {
                                        "FECHAR": function()
                                        {
                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function(ev, ui)
                                    {
                                        $(this).dialog("destroy");
                                    }
                                });

                            }
                            else if( usuario.nivel == "2" && (new Date().date(pedido2.estacionamento.cliente.clidatavalida) < dataLimiteCad) )
                                {
                                $('#dialog').attr('title','DADOS CADASTRAIS DESATUALIZADOS');

                                mensagem = "DADOS CADASTRAIS DO CLIENTE ESTÃO DESATUALIZADOS";

                                html = '<p>'+
                                '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                mensagem;

                                $('#dialog').html(html);

                                $('#dialog').dialog(
                                {
                                    autoOpen: true,
                                    modal: true,
                                    width: 480,
                                    buttons:
                                    {
                                        "FECHAR": function()
                                        {
                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function(ev, ui)
                                    {
                                        $(this).dialog("destroy");
                                    }
                                });

                            }

                            else if((dataAnulaValidacaoIbge == '' || dataAnulaValidacaoIbge < limiteIbge) && usuario.nivel == "2" && (pedido2.estacionamento.cliente.enderecoFaturamento.cidade.descricao != pedido2.estacionamento.cliente.enderecoFaturamento.cidadeIbge.descricao))
                                 {
                                                                    $('#dialog').attr('title','DADOS DIVERGENTES');

                                                                    var mensagem = "CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO";
                                                                    var pw = '';
//                                                                                        var usuario = usuario.codigo;
                                                                    var html = '<p>'+
                                                                    '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                                                    mensagem;
                                                                    html +='<p>DIGITE A SENHA PARA LIBERAR: <input type=password name="pw" id="pw"></p>';

                                                                    $('#dialog').html(html);

                                                                    $('#dialog').dialog(
                                                                    {
                                                                            autoOpen: true,
                                                                            modal: true,
                                                                            width: 480,
                                                                            buttons:
                                                                            {
                                                                                    "FECHAR": function()
                                                                                    {
                                                                                            $(this).dialog("close");
                                                                                    },
                                                                                    "LIBERAR": function()
                                                                                    {
//                                                                                                               $val('#pw');
                                                                                            pw = $('#pw').val() ;
                                                                                            $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                                                                                {
                                                                                                    //variaveis a ser enviadas metodo POST
                                                                                                    clicodigo:clicodigo,
                                                                                                    usuario:usuario.codigo,
                                                                                                    pw:pw,
                                                                                                    acao:12

                                                                                                },
                                                                                                function(data)
                                                                                                {


                                                                                                    if (Boolean(data))
                                                                                                    {
                                                                                                        anularValidacaoIbge = true;
                                                                                                        alert("LIBERACAO REALIZADA COM SUCESSO");

                                                                                                            $('#'+id).css("background-color",'#77DD98');
//                                                                                                            $(this).dialog("close");
//                                                                                                        txtDataValidacao = 'CIDADE IBGE ESTA OK';
//alert("anularValidacaoIbge: "+anularValidacaoIbge);
                                                                                                    }else{
                                                                                                        alert("FALHA EM REALIZAR A LIBERACAO");
                                                                                                    }
                                                                                                },'json');
//                                                                                                                   alert(pw + "\n"+usuario.codigo);
                                                                                            //$(this).dialog("close");
                                                                                    }
                                                                            },
                                                                            close: function(ev, ui)
                                                                            {
                                                                                    $(this).dialog("destroy");
                                                                            }

                                                                    });
                                }
*/
                            else{

                                $('#SECTION_1_collapse').click(function(){
                                      $('#wait_dialog').dialog("open");
                                      $('#SECTION_1').toggle('slow', function(){
                                        $('#wait_dialog').dialog("close");
                                      });
                                    });

                                $('#dialog').attr('title','SITUACAO PEDIDO');

                                mensagem = "DESEJA ALTERAR A SITUACAO DO PEDIDO PARA...";

                                html = '<p>'+
                                '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                mensagem+
                                '</p><form id="formSituacao" name="formSituacao" method="post" action="#">';

                                if(usuario.nivel == "2")
                                {


                                    html += '<input align="middle" type="radio" checked="checked" value="4" id="pendentes" name="opcoesSituacao">PENDENTE'+
                                    '<input align="middle" type="radio" value="5" id="negado" name="opcoesSituacao">NEGADO'+
                                    '<input align="middle" type="radio" value="22" id="negado" name="opcoesSituacao">AUTORIZAR';

                                    html += '<p>email: <input align="middle" type="text" value="'+email+'" id="txtMail" name="txtMail" size="65">'+
                                    '</p>';

                                    html += '<p>Motivo:<br/>';
                                    html += '<input type="checkbox" name="emailmsg" class="emailopcao1" id="emailmsgPdt1" value="1"><label id="lblemailmsg1">Dados Cadastrais</label><br/>'+
                                                '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt2" value="2"><label id="lblemailmsg2">Boletos | Notas Fiscais</label><br/>'+
                                                '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt3" value="3"><label id="lblemailmsg3">Carta de Anuencia</label><br/>'+
                                                '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt4" value="4"><label id="lblemailmsg4">Contrato Social</label><br/>'+
                                                '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt5" value="5"><label id="lblemailmsg5">Titulos Vencidos</label><br/>'+
                                                '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt0" value="0"><label id="lblemailmsg6">Outros</label><br/>';

//                                    html += '<textarea style=" name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>';
                                    html += '<textarea style="display:none" name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>';

                                    html += '</form><h5 id ="obsNota">OBS.: INFORME O MOTIVO DA ALTERACAO DA SITUACAO DO PEDIDO.<h5>';

                                    html +='<h5>OBS.: MAIS DE UM EMAIL UTILIZAR PONTO E VIRGULA(;) PARA SEPARAR.<h5>';
                                }
                                else
                                {
                                    html += '<input align="middle" type="radio" checked="checked" value="3" id="liberarFinanceiro" name="opcoesSituacao">LIBERAR FINANCEIRO';
                                }

                                $('#dialog').html(html);

                                $('#dialog').dialog(
                                {
                                    autoOpen: true,
                                    modal: true,
                                    width: 480,
                                    buttons:
                                    {
                                        "Alterar": function()
                                        {
                                            var msgSelecionadas = '';
                                            var i = 0;

                                            if(!($('#emailmsgPdt0').is(':checked') ||
                                                $('#emailmsgNgd4').is(':checked') ||
                                                $('#emailmsgNgd5').is(':checked') )
                                                && $("input[name='emailmsg']").is(':checked')
                                                ){
                                                     $("#txtObsSituacao").val('_');
                                                }

                                            $("input[name='emailmsg']:checked").each(function() {
                                                   if (i===0){
                                                                msgSelecionadas +=  $(this).val();
                                                            }else {
                                                                msgSelecionadas +=  ','+$(this).val();
                                                            }
                                               i++;
                                            });

                                            if($("#formSituacao").validate(
                                            {
                                                rules:{
                                                    txtObsSituacao:{
                                                        required: true
                                                    }
                                                },
                                                messages:{
                                                    txtObsSituacao:{
//                                                        required: "Obrigatório o preenchimento do campo observação."
                                                        required: "Obrigatório selecionar ao menos um motivo."
                                                    }
                                                }
                                            }).form()) {

if(usuario.nivel == "2") {
                                            titulo = "REALIZANDO ALTERACAO AGUARDE!";
                                            mensagem = "AO TERMINO VOCE RECEBERA UM EMAIL DE NOTIFICACAO";

                                            $('#formSituacao').messageBoxElement(titulo, mensagem);
}


                                                $.post('modulos/vendaAtacado/pedidos/adm/controller/alteraSituacao.php',
                                                {
                                                    //variaveis a ser enviadas metodo POST
                                                    pvnumero:id,
                                                    situacao:$("input[name='opcoesSituacao']:checked").val(),
                                                    txtMail:$('#txtMail').val(),
                                                    from:usuario.email,
                                                    observacao:$("#txtObsSituacao").val(),
                                                    msgSelecionadas:msgSelecionadas


                                                },
                                                function(data)
                                                {

                                                    if (Boolean(data.retorno))
                                                    {

mensagem = "";
$("#formSituacao").unblock();

                                                        if($("input[name='opcoesSituacao']:checked").val() == 3)
                                                        {
                                                            $("#"+id).hide();
                                                        }
                                                        else if($("input[name='opcoesSituacao']:checked").val() == 4)
                                                        {
                                                            $("#"+id).attr("style", "background: #FF1493");
                                                            $("#dvStatus"+id).html("PENDENTE");
                                                            $("#dvManutencao"+id).show();
                                                        }
                                                        else if($("input[name='opcoesSituacao']:checked").val() == 5)
                                                        {
                                                            //$("#"+id).attr("style", "background: #FA5050");
                                                            //$("#dvStatus"+id).html("NEGADO");
                                                            //$("#dvManutencao"+id).hide();
                                                            $("#"+id).hide();
                                                        }
                                                        else if($("input[name='opcoesSituacao']:checked").val() == 22)
                                                        {

                                                            $("#"+id).attr("style", "background: #77DD98");
                                                            $("#dvSituacao"+id).html('<a href="javascript:;"   title="LIBERACAO '+id+'" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO '+id+'" id="'+id+'" name="liberacao3">LIBERAR</a>');
                                                            $("#dvStatus"+id).html("AUTORIZADO");
                                                            $("#dvManutencao"+id).show();



                                                            $('a[name=liberacao3]').click(function()
                                                            {


                                                                var id = $(this).attr("id");
                                                                var valprefe = $(this).attr("valprefechamento");
                                                                var valorped = $(this).attr("valorpedido");

                                                                $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                                                                                    {
                                                                                                        //variaveis a ser enviadas metodo POST
                                                                                                        id:id,
                                                                                                        acao:11

                                                                                                    },
                                                                                                    function(data)
                                                                                                    {


                                                                                                        if (Boolean(data.retorno))
                                                                                                        {
                                                                                                            pedidosRecebe = data.pedidos;
                                                                                                            pedidoVerLiberacao = new Object();
                                                                                                            interfixNaoConsultado = false;
                                                                                                            dataReceita = "";
                                                                                                            dataSintegra = "";
//                                                                                                            var  limite = new Date();
//                                                                                                            limite.setDate(limite.getDate()-180);
//                                                                                                            limite = new Date(limite);
                                                                                                            cliie = pedido2.estacionamento.cliente.cliie;
                                                                                                            clienteIsento = false; // Verifica se o cliente é isento de I.E.
                                                                                                           if  (!cliie.match(/[0-9]/i)) {
                                                                                                               clienteIsento = true;
                                                                                                           }

                                                                                                             var   prazolimiteInt = 0;
                                                                                                             var   prazolimiteCad = 0;
                                                                                                             var   prazolimiteSer = 0;

                                                                                                                $.each(pedido2.estacionamento.cliente.prazoExpiracao.resultado, function (key, value2){
                                                                                        //                                                                        alert( "value2.pedescricao: "+ value2.pedescricao +"\n value2.peprazo"+value2.peprazo);
                                                                                                                                if(value2.pedescricao === 'INTERFIX')
                                                                                                                                {
                                                                                                                                        prazolimiteInt = value2.peprazo;
                                                                                                                                } else if (value2.pedescricao === 'CADASTRO') {
                                                                                                                                        prazolimiteCad = value2.peprazo;
                                                                                                                                } else if (value2.pedescricao === 'SERASA') {
                                                                                                                                        prazolimiteSer = pedido2.estacionamento.peprazo;
                                                                                                                                }
                                                                                                                });

                                                                                                                limitePrazo = new Date();
                                                                                        // alert ( "Look a test: "+limitePrazo );
                                                                                                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteInt );
                                                                                                                dataLimiteInt = new Date(limitePrazo);
                                                                                        // alert ( "Look a testInt: "+limitePrazo );
                                                                                                                limitePrazo = new Date();
                                                                                                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteCad );
                                                                                                                dataLimiteCad = new Date(limitePrazo);
                                                                                        // alert ( "Look a test Cad: "+limitePrazo );
                                                                                                                limitePrazo = new Date();
                                                                                                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteSer );
                                                                                                                dataLimiteSer = new Date(limitePrazo);

                                                                                                            var opcoes = '';
                                                                                                            $.each(pedidosRecebe, function (key, value)
                                                                                                            {

                                                                                                                pedidoVerLiberacao = value;


                                                                                                            });


                                                                                                            //                                $("#"+id).attr("style", "background: #4682B4");
                                                                                                            //                                $("#"+id).hide();

                                                                                                            // INÍCIO DA VERIFICAÇÃO PARA REALIZAR A LIBERAÇÃO
                                                                                                            // CÓDIGO SEMELHANTE AO /modulos/vendaAtacado/liberacao/view/js/liberaPedido.js

                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla=='R'){

                                                                                                                msg = "<br> - PEDIDO RESERVA NÃO PODE SER LIBERADO";
                                                                                                                alert('PEDIDO RESERVA NÃO PODE SER LIBERADO');
                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', 'disabled');
                                                                                                                return false;

                                                                                                            }

                                                                                                            //limiteDisponivel = pedidoVerLiberacao.cliente.clilimite - pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas;

                                                        if (usuario.nivel == "2" && (pedidoVerLiberacao.cliente.enderecoFaturamento.cidade.descricao  !=  pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao)) {

                                                        msg += "<br> - CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO";
                                                        alert('CIDADE IBGE DIFERENTE DA CIDADE CADASTRADA NO ENDERECO FATURAMENTO ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }


                                                     if (usuario.nivel == "2" && (pedidoVerLiberacao.cliente.clidatavalida == undefined || pedidoVerLiberacao.cliente.clidatavalida == '' ||
                                                     pedidoVerLiberacao.cliente.clidatavalida == null || pedidoVerLiberacao.cliente.clidatavalida == '0')) {

                                                        msg = "<br> - DADOS CADASTRAIS DO CLIENTE NÃO ESTÃO VALIDADOS";
                                                        alert('DADOS CADASTRAIS DO CLIENTE NÃO ESTÃO VALIDADOS ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }

                                                     if ( usuario.nivel == "2" && (new Date().date(pedidoVerLiberacao.cliente.clidatavalida) < dataLimiteCad) ) {

                                                        msg = "<br> - DADOS CADASTRAIS DO CLIENTE ESTÃO DESATUALIZADOS";
                                                        alert('DADOS CADASTRAIS DO CLIENTE ESTÃO DESATUALIZADOS ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;

                                                         }

                                                    cliie = pedidoVerLiberacao.cliente.cliie;


                                                    if(pedidoVerLiberacao.itensPedido==null || pedidoVerLiberacao.itensPedido==undefined || pedidoVerLiberacao.itensPedido=="")
                                                    {
                                                        msg += "<br> - PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR";
                                                        alert('PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR ');
                                                        $("#retorno").messageBox(msg,false, false);
                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                        return false;
                                                    }

                                                    if  (!cliie.match(/[0-9]/i)) {
                                                       clienteIsento = true;
                                                   }

                                                    if( pedidoVerLiberacao.cliente.clireceitadataultimaconsulta != undefined
                                                        &&  pedidoVerLiberacao.cliente.clireceitadataultimaconsulta != null ) {
                                                        dataReceita = pedidoVerLiberacao.cliente.clireceitadataultimaconsulta;
                                                        tokens = dataReceita.split("-");
                                                        hora = tokens[2].split(" ");
                                                        dataReceita = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                                        consultaReceita = true;
                                                    }

                                                    if( pedidoVerLiberacao.cliente.clisintegradataultimaconsulta != undefined
                                                        &&  pedidoVerLiberacao.cliente.clisintegradataultimaconsulta != null
                                                        &&  cliie.match(/[0-9]/i)) {
                                                        dataSintegra = pedidoVerLiberacao.cliente.clisintegradataultimaconsulta;
                                                        tokens = dataSintegra.split("-");
                                                        hora = tokens[2].split(" ");
                                                        dataSintegra = new Date (tokens[0],(tokens[1]-1),hora[0]);

                                                        consultaSintegra = true;

                                                    }


                                                    if(pedidoVerLiberacao.cliente.clipessoa != '2') {
                                                        if( consultaReceita == false || (consultaSintegra == false && clienteIsento == false ))
                                                        {
                                                            msg += "<br> - CLIENTE NAO CONSULTADO NO INTERFIX";
                                                            alert('CLIENTE NAO CONSULTADO NO INTERFIX ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        } else if(( dataReceita < dataLimiteInt ) ||  ( dataSintegra < dataLimiteInt && clienteIsento == false)) {
                                                            msg += "<br> - CONSULTA INTERFIX EXPIRADA";
                                                            alert('CONSULTA INTERFIX EXPIRADA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;

                                                        }else if ( !pedidoVerLiberacao.cliente.clireceitasituacaocadastral.match(/ativ/i)) {
                                                            msg += "<br> - CLIENTE IRREGULAR NA RECEITA";
                                                            alert('CLIENTE IRREGULAR NA RECEITA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        }else if ( (pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == undefined || pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == "" || pedidoVerLiberacao.cliente.clisintegrasituacaocadastral == null ||
                                                        pedidoVerLiberacao.cliente.clisintegrasituacaocadastral.match(/CANCEL|NAO|BAIXADO|FALH|INAB|IRREG|INAT|INVA|0/i)) && clienteIsento == false) {
                                                            msg += "<br> - CLIENTE INATIVO NO SINTEGRA";
                                                            alert('CLIENTE INATIVO NO SINTEGRA ');
                                                            $("#retorno").messageBox(msg,false, false);
                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                            return false;
                                                        }
                                                    }




                                                                                                            limit = pedidoVerLiberacao.cliente.clilimite;
                                                                                                             pvlibdep = '';
                                                                                                             pvlibvit = '';
                                                                                                             pvlibfil = '';
                                                                                                             pvlibmat = '';
                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla=='I' && pedidoVerLiberacao.pvvinculo!=null)
                                                                                                            {

                                                                                                                pedidoValor = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                            }else{

                                                                                                                $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                                {
                                                                                                                    if(value.pedidoVendaItemEstoque.pviest011 > '0')
                                                                                                                    {
                                                                                                                        limitvall = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                                    }
//                                                                                                                    else
//                                                                                                                    {
//                                                                                                                        limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
//                                                                                                                        pvlibdep = '1';
//                                                                                                                    }
                                                                                                                    else if(value.pedidoVendaItemEstoque.pviest09 > '0' || value.pedidoVendaItemEstoque.pviest026 > '0')
                                                                                                                    {
                                                                                                                        limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                                                                        pvlibdep = '1';
                                                                                                                    } else if(value.pedidoVendaItemEstoque.pviest01 > '0')
                                                                                                                    {
                                                                                                                        limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                                                                        pvlibfil = '1';
                                                                                                                    } else if(value.pedidoVendaItemEstoque.pviest02 > '0' )
                                                                                                                    {
                                                                                                                        limitvall = (pedidoVerLiberacao.calculoSt.notavalor);
                                                                                                                        pvlibmat = '1';
                                                                                                                    }

                                                                                                                });

                                                                                                            }


                                                                                                            //limiteDisponivel = Number(pedidoVerLiberacao.cliente.clilimite) - (Number(pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas)- Number(limitvall));

                                                                                                            var msg="";
                                                                                                            //msg +="NECESSARIO INFORMAR O(S) CAMPO(S) ABAIXO PARA LIBERAR PEDIDO:<br>";

//                                                                                                            if(pedidoVerLiberacao.TotalItensEstoque==undefined || pedidoVerLiberacao.TotalItensPedidos==undefined)
//                                                                                                            {
//                                                                                                                msg += "<br> - PEDIDOS SEM ITENS OU ESTOQUE VAZIO";
//                                                                                                                alert('PEDIDOS SEM ITENS OU ESTOQUE VAZIO');
//                                                                                                                $("#retorno").messageBox(msg,false, false);
//                                                                                                                return false;
//                                                                                                            }
//
//                                                                                                            if(pedidoVerLiberacao.TotalItensEstoque != pedidoVerLiberacao.TotalItensPedidos)
//                                                                                                            {
//                                                                                                                alert('PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR');
//                                                                                                                msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
//                                                                                                                $("#retorno").messageBox(msg,false, false);
//                                                                                                                return false;
//                                                                                                            }
                                                                                                            msgPvitem = "";


                                                                                                            if(pedidoVerLiberacao.itensPedido==null || pedidoVerLiberacao.itensPedido==undefined || pedidoVerLiberacao.itensPedido=="")
                                                                                                            {

                                                                                                                msg += "<br> - PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR";
                                                                                                                alert('PEDIDO COM PROBLEMA NOS ITENS FALE COM O ADMINISTRADOR ');
                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                return false;
                                                                                                            }

                                                                                                            $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                            {

                                                                                                                var pviest01 = Number(value.pedidoVendaItemEstoque.pviest01);
                                                                                                                var pviest02 = Number(value.pedidoVendaItemEstoque.pviest02);
                                                                                                                var pviest03 = Number(value.pedidoVendaItemEstoque.pviest03);
                                                                                                                var pviest04 = Number(value.pedidoVendaItemEstoque.pviest04);
                                                                                                                var pviest05 = Number(value.pedidoVendaItemEstoque.pviest05);
                                                                                                                var pviest06 = Number(value.pedidoVendaItemEstoque.pviest06);
                                                                                                                var pviest07 = Number(value.pedidoVendaItemEstoque.pviest07);
                                                                                                                var pviest08 = Number(value.pedidoVendaItemEstoque.pviest08);
                                                                                                                var pviest09 = Number(value.pedidoVendaItemEstoque.pviest09);
                                                                                                                //var pviest10 = Number(value.pedidoVendaItemEstoque.pviest10);
                                                                                                                var pviest010 = Number(value.pedidoVendaItemEstoque.pviest010);
                                                                                                                var pviest011= Number(value.pedidoVendaItemEstoque.pviest011);
                                                                                                                var pviest012 = Number(value.pedidoVendaItemEstoque.pviest012);
                                                                                                                var pviest013 = Number(value.pedidoVendaItemEstoque.pviest013);
                                                                                                                var pviest014 = Number(value.pedidoVendaItemEstoque.pviest014);
                                                                                                                var pviest015 = Number(value.pedidoVendaItemEstoque.pviest015);
                                                                                                                var pviest016 = Number(value.pedidoVendaItemEstoque.pviest016);
                                                                                                                var pviest017 = Number(value.pedidoVendaItemEstoque.pviest017);
                                                                                                                var pviest018 = Number(value.pedidoVendaItemEstoque.pviest018);
                                                                                                                var pviest019 = Number(value.pedidoVendaItemEstoque.pviest019);
                                                                                                                var pviest020 = Number(value.pedidoVendaItemEstoque.pviest020);
                                                                                                                var pviest021 = Number(value.pedidoVendaItemEstoque.pviest021);
                                                                                                                var pviest022 = Number(value.pedidoVendaItemEstoque.pviest022);
                                                                                                                var pviest023 = Number(value.pedidoVendaItemEstoque.pviest023);
                                                                                                                var pviest024 = Number(value.pedidoVendaItemEstoque.pviest024);
                                                                                                                var pviest025 = Number(value.pedidoVendaItemEstoque.pviest025);
                                                                                                                var pviest026 = Number(value.pedidoVendaItemEstoque.pviest026);
                                                                                                                var pviest027 = Number(value.pedidoVendaItemEstoque.pviest027);
                                                                                                                var pviest028 = Number(value.pedidoVendaItemEstoque.pviest028);
                                                                                                                var pviest029 = Number(value.pedidoVendaItemEstoque.pviest029);
                                                                                                                var pviest030 = Number(value.pedidoVendaItemEstoque.pviest030);
                                                                                                                var pviest031 = Number(value.pedidoVendaItemEstoque.pviest031);
                                                                                                                var pviest032 = Number(value.pedidoVendaItemEstoque.pviest032);
                                                                                                                var pviest033 = Number(value.pedidoVendaItemEstoque.pviest033);
                                                                                                                var pviest034 = Number(value.pedidoVendaItemEstoque.pviest034);
                                                                                                                var pviest035 = Number(value.pedidoVendaItemEstoque.pviest035);
                                                                                                                var pviest036 = Number(value.pedidoVendaItemEstoque.pviest036);
                                                                                                                var pviest037 = Number(value.pedidoVendaItemEstoque.pviest037);
                                                                                                                var pviest038 = Number(value.pedidoVendaItemEstoque.pviest038);
                                                                                                                var pviest039 = Number(value.pedidoVendaItemEstoque.pviest039);
                                                                                                                var pviest040 = Number(value.pedidoVendaItemEstoque.pviest040);
                                                                                                                var pviest041 = Number(value.pedidoVendaItemEstoque.pviest041);
                                                                                                                var pviest042 = Number(value.pedidoVendaItemEstoque.pviest042);
                                                                                                                var pviest043 = Number(value.pedidoVendaItemEstoque.pviest043);
                                                                                                                var pviest044 = Number(value.pedidoVendaItemEstoque.pviest044);
                                                                                                                var pviest045 = Number(value.pedidoVendaItemEstoque.pviest045);
                                                                                                                var pviest046 = Number(value.pedidoVendaItemEstoque.pviest046);
                                                                                                                var pviest047 = Number(value.pedidoVendaItemEstoque.pviest047);
                                                                                                                var pviest048 = Number(value.pedidoVendaItemEstoque.pviest048);
                                                                                                                var pviest049 = Number(value.pedidoVendaItemEstoque.pviest049);
                                                                                                                var pviest050 = Number(value.pedidoVendaItemEstoque.pviest050);
                                                                                                                var pviest051 = Number(value.pedidoVendaItemEstoque.pviest051);
                                                                                                                var pviest052 = Number(value.pedidoVendaItemEstoque.pviest052);
                                                                                                                var pviest053 = Number(value.pedidoVendaItemEstoque.pviest053);
                                                                                                                var pviest054 = Number(value.pedidoVendaItemEstoque.pviest054);
                                                                                                                var pviest055 = Number(value.pedidoVendaItemEstoque.pviest055);
                                                                                                                var pviest056 = Number(value.pedidoVendaItemEstoque.pviest056);
                                                                                                                var pviest057 = Number(value.pedidoVendaItemEstoque.pviest057);
                                                                                                                var pviest058 = Number(value.pedidoVendaItemEstoque.pviest058);
                                                                                                                var pviest059 = Number(value.pedidoVendaItemEstoque.pviest059);
                                                                                                                var pviest060 = Number(value.pedidoVendaItemEstoque.pviest060);
                                                                                                                var pviest061 = Number(value.pedidoVendaItemEstoque.pviest061);
                                                                                                                var pviest062 = Number(value.pedidoVendaItemEstoque.pviest062);
                                                                                                                var pviest063 = Number(value.pedidoVendaItemEstoque.pviest063);
                                                                                                                var pviest064 = Number(value.pedidoVendaItemEstoque.pviest064);
                                                                                                                var pviest065 = Number(value.pedidoVendaItemEstoque.pviest065);
                                                                                                                var pviest066 = Number(value.pedidoVendaItemEstoque.pviest066);
                                                                                                                var pviest067 = Number(value.pedidoVendaItemEstoque.pviest067);
                                                                                                                var pviest068 = Number(value.pedidoVendaItemEstoque.pviest068);
                                                                                                                var pviest069 = Number(value.pedidoVendaItemEstoque.pviest069);
                                                                                                                var pviest070 = Number(value.pedidoVendaItemEstoque.pviest070);
                                                                                                                var pviest071 = Number(value.pedidoVendaItemEstoque.pviest071);
                                                                                                                var pviest072 = Number(value.pedidoVendaItemEstoque.pviest072);
                                                                                                                var pviest073 = Number(value.pedidoVendaItemEstoque.pviest073);
                                                                                                                var pviest074 = Number(value.pedidoVendaItemEstoque.pviest074);
                                                                                                                var pviest075 = Number(value.pedidoVendaItemEstoque.pviest075);
                                                                                                                var pviest076 = Number(value.pedidoVendaItemEstoque.pviest076);
                                                                                                                var pviest077 = Number(value.pedidoVendaItemEstoque.pviest077);
                                                                                                                var pviest078 = Number(value.pedidoVendaItemEstoque.pviest078);
                                                                                                                var pviest079 = Number(value.pedidoVendaItemEstoque.pviest079);
                                                                                                                var pviest080 = Number(value.pedidoVendaItemEstoque.pviest080);
                                                                                                                var pviest081 = Number(value.pedidoVendaItemEstoque.pviest081);
                                                                                                                var pviest082 = Number(value.pedidoVendaItemEstoque.pviest082);
                                                                                                                var pviest083 = Number(value.pedidoVendaItemEstoque.pviest083);
                                                                                                                var pviest084 = Number(value.pedidoVendaItemEstoque.pviest084);
                                                                                                                var pviest085 = Number(value.pedidoVendaItemEstoque.pviest085);
                                                                                                                var pviest086 = Number(value.pedidoVendaItemEstoque.pviest086);
                                                                                                                var pviest087 = Number(value.pedidoVendaItemEstoque.pviest087);
                                                                                                                var pviest088 = Number(value.pedidoVendaItemEstoque.pviest088);
                                                                                                                var pviest089 = Number(value.pedidoVendaItemEstoque.pviest089);
                                                                                                                var pviest090 = Number(value.pedidoVendaItemEstoque.pviest090);
                                                                                                                var pviest091 = Number(value.pedidoVendaItemEstoque.pviest091);
                                                                                                                var pviest092 = Number(value.pedidoVendaItemEstoque.pviest092);
                                                                                                                var pviest093 = Number(value.pedidoVendaItemEstoque.pviest093);
                                                                                                                var pviest094 = Number(value.pedidoVendaItemEstoque.pviest094);
                                                                                                                var pviest095 = Number(value.pedidoVendaItemEstoque.pviest095);
                                                                                                                var pviest096 = Number(value.pedidoVendaItemEstoque.pviest096);
                                                                                                                var pviest097 = Number(value.pedidoVendaItemEstoque.pviest097);
                                                                                                                var pviest098 = Number(value.pedidoVendaItemEstoque.pviest098);
                                                                                                                var pviest099 = Number(value.pedidoVendaItemEstoque.pviest099);
                                                                                                                var pviindustria = Number(value.pedidoVendaItemEstoque.pviindustria);

                                                                                                                var pvisaldo = Number(value.pedidoVendaItemEstoque.pvisaldo);
                                                                                                                var codigo = value.pedidoVendaItemEstoque.pvicodigo;
                                                                                                                var procodigo = value.pedidoVendaItemEstoque.procodigo;
                                                                                                                var preco = value.pedidoVendaItemEstoque.pvipreco;
                                                                                                                var descricao = value.produto.prnome;
                                                                                                                var procod = value.produto.procod;


                                                                                                                if(preco < 0.02 && preco >=0.01)
                                                                                                                {
                                                                                                                    alert("FALHA NO PRECO DO PRODUTO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
                                                                                                                    msg += "<br> - FALHA NO PRECO DO PRODUTO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                //return false;
                                                                                                                }


                                                                                                                if(preco==0 || preco==0.00 || preco==null)
                                                                                                                {
                                                                                                                    alert("PRODUTO COM PRECO ZERADO, CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco);
                                                                                                                    msgPvitem += "<br> - PRODUTO COM PRECO ZERADO,  CODIGO PRODUTO: " + procod + " NOME: " + descricao + " PRECO: " + preco;
                                                                                                                    $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                    return false;
                                                                                                                }

                                                                                                                if(pviest01 != 0)
                                                                                                                {
                                                                                                                    if(pviest01 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 01";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest02 != 0)
                                                                                                                {
                                                                                                                    if(pviest02 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 02";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest03 != 0)
                                                                                                                {
                                                                                                                    if(pviest03 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 03";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest04 != 0)
                                                                                                                {
                                                                                                                    if(pviest04 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 04";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest05 != 0)
                                                                                                                {
                                                                                                                    if(pviest05 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 05";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }


                                                                                                                if(pviest06 != 0)
                                                                                                                {
                                                                                                                    if(pviest06 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 06";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest07 != 0)
                                                                                                                {
                                                                                                                    if(pviest07 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 07";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest08 != 0)
                                                                                                                {
                                                                                                                    if(pviest08 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 08";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                    //            if(pviest09 != 0)
                                                                                                                if(pviest026 != 0)
                                                                                                                {
                                                                                                    //                if(pviest09 != pvisaldo)
                                                                                                                    if(pviest026 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 09";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                /*	if(pviest10 != 0)
										{
												if(pviest10 != pvisaldo)
												{
													alert("ERRO: 425 CODIGO:  " +  procod );
														 msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 10";
														$("#retorno").messageBox(msgPvitem,false, false);
														//$("#btnLiberacaoPedido").attr('disabled', '');
														return false;
												}

										}*/

                                                                                                                if(pviest010 != 0)
                                                                                                                {
                                                                                                                    if(pviest010 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 010";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest011 != 0)
                                                                                                                {
                                                                                                                    if(pviest011 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 011";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest012 != 0)
                                                                                                                {
                                                                                                                    if(pviest012 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 012";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest013 != 0)
                                                                                                                {
                                                                                                                    if(pviest013 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 013";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest014 != 0)
                                                                                                                {
                                                                                                                    if(pviest014 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 014";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest015 != 0)
                                                                                                                {
                                                                                                                    if(pviest015 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("CODIGO:  " +  codigo );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 015";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest016 != 0)
                                                                                                                {
                                                                                                                    if(pviest016 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 016";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest017 != 0)
                                                                                                                {
                                                                                                                    if(pviest017 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 017";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest018 != 0)
                                                                                                                {
                                                                                                                    if(pviest018 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 018";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest019 != 0)
                                                                                                                {
                                                                                                                    if(pviest019 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 019";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest020 != 0)
                                                                                                                {
                                                                                                                    if(pviest020 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 020";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest021 != 0)
                                                                                                                {
                                                                                                                    if(pviest021 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 021";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest022 != 0)
                                                                                                                {
                                                                                                                    if(pviest022 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 022";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest023 != 0)
                                                                                                                {
                                                                                                                    if(pviest023 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 023";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest024 != 0)
                                                                                                                {
                                                                                                                    if(pviest024 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 024";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest025 != 0)
                                                                                                                {
                                                                                                                    if(pviest025 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 025";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest026 != 0)
                                                                                                                {
                                                                                                                    if(pviest026 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 026";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest027 != 0)
                                                                                                                {
                                                                                                                    if(pviest027 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 027";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest028 != 0)
                                                                                                                {
                                                                                                                    if(pviest028 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 028";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest029 != 0)
                                                                                                                {
                                                                                                                    if(pviest029 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 029";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest030 != 0)
                                                                                                                {
                                                                                                                    if(pviest030 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 030";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest031 != 0)
                                                                                                                {
                                                                                                                    if(pviest031 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 031";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest032 != 0)
                                                                                                                {
                                                                                                                    if(pviest032 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 032";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest033 != 0)
                                                                                                                {
                                                                                                                    if(pviest033 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 033";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest034 != 0)
                                                                                                                {
                                                                                                                    if(pviest034 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 034";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest035 != 0)
                                                                                                                {
                                                                                                                    if(pviest035 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 035";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest036 != 0)
                                                                                                                {
                                                                                                                    if(pviest036 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 036";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest037 != 0)
                                                                                                                {
                                                                                                                    if(pviest037 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 037";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest038 != 0)
                                                                                                                {
                                                                                                                    if(pviest038 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 038";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest039 != 0)
                                                                                                                {
                                                                                                                    if(pviest039 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 039";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest040 != 0)
                                                                                                                {
                                                                                                                    if(pviest040 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 040";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest041 != 0)
                                                                                                                {
                                                                                                                    if(pviest041 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 041";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest042 != 0)
                                                                                                                {
                                                                                                                    if(pviest042 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 042";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest043 != 0)
                                                                                                                {
                                                                                                                    if(pviest043 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 043";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest044 != 0)
                                                                                                                {
                                                                                                                    if(pviest044 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 044";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest045 != 0)
                                                                                                                {
                                                                                                                    if(pviest045 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 045";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest046 != 0)
                                                                                                                {
                                                                                                                    if(pviest046 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 046";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest047 != 0)
                                                                                                                {
                                                                                                                    if(pviest047 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 047";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest048 != 0)
                                                                                                                {
                                                                                                                    if(pviest048 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 048";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest049 != 0)
                                                                                                                {
                                                                                                                    if(pviest049 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 049";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest050 != 0)
                                                                                                                {
                                                                                                                    if(pviest050 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 050";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest051 != 0)
                                                                                                                {
                                                                                                                    if(pviest051 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 051";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest052 != 0)
                                                                                                                {
                                                                                                                    if(pviest052 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 052";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest053 != 0)
                                                                                                                {
                                                                                                                    if(pviest053 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 053";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest054 != 0)
                                                                                                                {
                                                                                                                    if(pviest054 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 054";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest055 != 0)
                                                                                                                {
                                                                                                                    if(pviest055 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 055";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest056 != 0)
                                                                                                                {
                                                                                                                    if(pviest056 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 056";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest057 != 0)
                                                                                                                {
                                                                                                                    if(pviest057 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 057";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest058 != 0)
                                                                                                                {
                                                                                                                    if(pviest058 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 058";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest059 != 0)
                                                                                                                {
                                                                                                                    if(pviest059 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 059";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest060 != 0)
                                                                                                                {
                                                                                                                    if(pviest060 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 060 ";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest061 != 0)
                                                                                                                {
                                                                                                                    if(pviest061 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 061";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest062 != 0)
                                                                                                                {
                                                                                                                    if(pviest062 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 062";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest063 != 0)
                                                                                                                {
                                                                                                                    if(pviest063 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 063";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest064 != 0)
                                                                                                                {
                                                                                                                    if(pviest064 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 064";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest065 != 0)
                                                                                                                {
                                                                                                                    if(pviest065 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 065";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest066 != 0)
                                                                                                                {
                                                                                                                    if(pviest066 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 066";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest067 != 0)
                                                                                                                {
                                                                                                                    if(pviest067 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 067";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest068 != 0)
                                                                                                                {
                                                                                                                    if(pviest068 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 068";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest069 != 0)
                                                                                                                {
                                                                                                                    if(pviest069 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 069";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest070 != 0)
                                                                                                                {
                                                                                                                    if(pviest070 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 070";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest071 != 0)
                                                                                                                {
                                                                                                                    if(pviest071 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 071";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest072 != 0)
                                                                                                                {
                                                                                                                    if(pviest072 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 072";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest073 != 0)
                                                                                                                {
                                                                                                                    if(pviest073 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 073";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest074 != 0)
                                                                                                                {
                                                                                                                    if(pviest074 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 074";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest075 != 0)
                                                                                                                {
                                                                                                                    if(pviest075 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 075";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest076 != 0)
                                                                                                                {
                                                                                                                    if(pviest076 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 076";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest077 != 0)
                                                                                                                {
                                                                                                                    if(pviest077 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 077";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest078 != 0)
                                                                                                                {
                                                                                                                    if(pviest078 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 078";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest079 != 0)
                                                                                                                {
                                                                                                                    if(pviest079 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 079";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest080 != 0)
                                                                                                                {
                                                                                                                    if(pviest080 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 080";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest081 != 0)
                                                                                                                {
                                                                                                                    if(pviest081 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 081";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest082 != 0)
                                                                                                                {
                                                                                                                    if(pviest082 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 082";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }

                                                                                                                if(pviest083 != 0)
                                                                                                                {
                                                                                                                    if(pviest083 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 083";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest084 != 0)
                                                                                                                {
                                                                                                                    if(pviest084 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 084";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest085 != 0)
                                                                                                                {
                                                                                                                    if(pviest085 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 085";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest086 != 0)
                                                                                                                {
                                                                                                                    if(pviest086 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 086";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest087 != 0)
                                                                                                                {
                                                                                                                    if(pviest087 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 087";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest088 != 0)
                                                                                                                {
                                                                                                                    if(pviest088 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 088";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest089 != 0)
                                                                                                                {
                                                                                                                    if(pviest089 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 089";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest090 != 0)
                                                                                                                {
                                                                                                                    if(pviest090 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 090";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest091 != 0)
                                                                                                                {
                                                                                                                    if(pviest091 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 091";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest092 != 0)
                                                                                                                {
                                                                                                                    if(pviest092 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 092";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }if(pviest093 != 0)
                                                                                                                {
                                                                                                                    if(pviest093 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 093";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest094 != 0)
                                                                                                                {
                                                                                                                    if(pviest094 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 094";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest095 != 0)
                                                                                                                {
                                                                                                                    if(pviest095 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("CODIGO:  " +  codigo );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 095";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest096 != 0)
                                                                                                                {
                                                                                                                    if(pviest096 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 096";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest097 != 0)
                                                                                                                {
                                                                                                                    if(pviest097 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 097";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest098 != 0)
                                                                                                                {
                                                                                                                    if(pviest098 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviest099 != 0)
                                                                                                                {
                                                                                                                    if(pviest099 != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 099";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }
                                                                                                                if(pviindustria != 0)
                                                                                                                {
                                                                                                                    if(pviindustria != pvisaldo)
                                                                                                                    {
                                                                                                                        alert("ERRO: 425 CODIGO:  " +  procod );
                                                                                                                        msgPvitem += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR - 098";
                                                                                                                        $("#retorno").messageBox(msgPvitem,false, false);
                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                        return false;
                                                                                                                    }

                                                                                                                }



                                                                                                            });

                                                                                                            if(msgPvitem != "")
                                                                                                            {

                                                                                                                msg += "<br> - PEDIDO COM PROBLEMAS NOS ITENS FALE COM O ADMINISTRADOR";
                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                return false;

                                                                                                            }

                                                                                                            msgEstoque = "";

                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='I' && pedidoVerLiberacao.pvvinculo==null)
                                                                                                            {

                                                                                                                $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                                {

                                                                                                                    $.each(value.pedidoVendaItemEstoque, function (key, value2)
                                                                                                                    {

                                                                                                                        if (value2 == null ) {return !false;} // caso o campo seja null o each não terminará


                                                                                                                        if(value2.pviest011 < 0)
                                                                                                                        {

                                                                                                                            msgEstoque += "Estoque".value2.pviecodigo;

                                                                                                                        }
                                                                                                                    });
                                                                                                                });

                                                                                                                if(msgEstoque!="")
                                                                                                                {

                                                                                                                    msg += msgEstoque;
                                                                                                                    alert(msg);
                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                    return false;
                                                                                                                }
                                                                                                            }
                                                                                                            valorPrefechamento = 0;
                                                                                                            totalDebts = 0;
                                                                                                            $.each(pedidoVerLiberacao.preFechamento, function (key, value)
                                                                                                            {
                                                                                                                if(value.fecforma=='101' || value.fecforma=='103' || value.fecforma=='110')
                                                                                                                {
                                                                                                                    valorPrefechamento += Number(value.fecvalor);
                                                                                                                }

                                                                                                            });

                                                                                                            totalDebts = Number(pedidoVerLiberacao.cliente.vendasEmAberto.cobrancaAberto)+Number(valorPrefechamento);

//                                                                                                            if(valorPrefechamento >= pedidoVerLiberacao.cliente.clilimite)
                                                                                                            if(totalDebts > pedidoVerLiberacao.cliente.clilimite)
                                                                                                            {
                                                                                                                msg += "<br> - PARCELAMENTO MAIOR QUE O LIMITE";
                                                                                                                alert('PARCELAMENTO MAIOR QUE O LIMITE');
                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                return false;
                                                                                                            }
                                                                                                            /*
			if(pedidoVerLiberacao.pvlibera!=null && pedidoVerLiberacao.pvhora!=null)
			{
				msg += "<br> - ESTE PEDIDO JA FOI LIBERADO";
				alert('ESTE PEDIDO JA FOI LIBERADO');
				$("#retorno").messageBox(msg,false, false);
				//$("#btnLiberacaoPedido").attr('disabled', '');
				return false;

			}
			*/

                                                                                                            data = new Date();
                                                                                                            dia = data.getDate();
                                                                                                            mes = data.getMonth();
                                                                                                            ano = data.getFullYear();
//                                                                                                            hora = data.getHours();
//                                                                                                            min = data.getMinutes();
//                                                                                                            seg = data.getSeconds();
                                                                                                            hora = "00";
                                                                                                            min = "00";
                                                                                                            seg = "00";

                                                                                                            meses = new Array(12);

                                                                                                            meses[0] = "01";
                                                                                                            meses[1] = "02";
                                                                                                            meses[2] = "03";
                                                                                                            meses[3] = "04";
                                                                                                            meses[4] = "05";
                                                                                                            meses[5] = "06";
                                                                                                            meses[6] = "07";
                                                                                                            meses[7] = "08";
                                                                                                            meses[8] = "09";
                                                                                                            meses[9] = "10";
                                                                                                            meses[10] = "11";
                                                                                                            meses[11] = "12";

                                                                                                            dias = new Array(12);

                                                                                                            dias[0] = "00";
                                                                                                            dias[1] = "01";
                                                                                                            dias[2] = "02";
                                                                                                            dias[3] = "03";
                                                                                                            dias[4] = "04";
                                                                                                            dias[5] = "05";
                                                                                                            dias[6] = "06";
                                                                                                            dias[7] = "07";
                                                                                                            dias[8] = "08";
                                                                                                            dias[9] = "09";
                                                                                                            dias[10] = "10";
                                                                                                            dias[11] = "11";
                                                                                                            dias[12] = "12";
                                                                                                            dias[13] = "13";
                                                                                                            dias[14] = "14";
                                                                                                            dias[15] = "15";
                                                                                                            dias[16] = "16";
                                                                                                            dias[17] = "17";
                                                                                                            dias[18] = "18";
                                                                                                            dias[19] = "19";
                                                                                                            dias[20] = "20";
                                                                                                            dias[21] = "21";
                                                                                                            dias[22] = "22";
                                                                                                            dias[23] = "23";
                                                                                                            dias[24] = "24";
                                                                                                            dias[25] = "25";
                                                                                                            dias[26] = "26";
                                                                                                            dias[27] = "27";
                                                                                                            dias[28] = "28";
                                                                                                            dias[29] = "29";
                                                                                                            dias[30] = "30";
                                                                                                            dias[31] = "31";

                                                                                                            dataHoje  =  ano+'-'+meses[mes]+'-'+dias[dia-1]+' '+hora+':'+min+':'+seg;
//alert("dataHoje"+dataHoje)

                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='S')
                                                                                                            {
                                                                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='Z')
                                                                                                                {
                                                                                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='M')
                                                                                                                    {
                                                                                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='D')
                                                                                                                        {
                                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='F')
                                                                                                                            {
                                                                                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='B')
                                                                                                                                {
                                                                                                                                    if(pedidoVerLiberacao.tipoPedido.sigla!='X')
                                                                                                                                    {
                                                                                                                                        if(pedidoVerLiberacao.tipoPedido.sigla!='EP')
                                                                                                                                        {


                                                                                                                                            if(pedidoVerLiberacao.cliente.enderecoFaturamento.clenumero==undefined ||pedidoVerLiberacao.cliente.enderecoFaturamento.clenumero==null)
                                                                                                                                            {
                                                                                                                                                msg += "<br> - ENDERECO PREENCHIDO DE FORMA INCORRETA";
                                                                                                                                                alert('ENDERECO PREENCHIDO DE FORMA INCORRETA');
                                                                                                                                                $('#tblAlteraNumero').show();
                                                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                                                return false;
                                                                                                                                            }


                                                                                                                                            if(pedidoVerLiberacao.cliente.enderecoFaturamento.clecep==undefined || pedidoVerLiberacao.cliente.enderecoFaturamento.clecep==null)
                                                                                                                                            {
                                                                                                                                                msg += "INFORME UM CEP VERDADEIRO";
                                                                                                                                                alert('INFORME UM CEP VERDADEIRO');
                                                                                                                                                $('#tblAlteraNumero').show();
                                                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                return false;
                                                                                                                                            }

                                                                                                                                            if(usuario.nivel == "2" && (pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao==null ||pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao=="" ||pedidoVerLiberacao.cliente.enderecoFaturamento.cidadeIbge.descricao==undefined))
                                                                                                                                            {
                                                                                                                                                msg += "<br> - CIDADE IBGE NAO ESTA PREENCHIDA";
                                                                                                                                                alert('CIDADE IBGE NAO ESTA PREENCHIDA');
                                                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                return false;
                                                                                                                                            }

                                                                                                                                            if(pedidoVerLiberacao.fecreserva!='1')
                                                                                                                                            {
                                                                                                                                                if(pedidoVerLiberacao.preFechamento==undefined || pedidoVerLiberacao.preFechamento==null)
                                                                                                                                                {
                                                                                                                                                    msg += "<br> - NECESSARIO FAZER O PREFECHAMENTO";
                                                                                                                                                    alert('NECESSARIO FAZER O PREFECHAMENTO');
                                                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            msgPreFec = "";

                                                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='R')
                                                                                                                                            {
                                                                                                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='I')
                                                                                                                                                {

                                                                                                                                                    $.each(pedidoVerLiberacao.preFechamento, function (key, value)
                                                                                                                                                    {

                                                                                                                                                        if(value.fecforma !='100')
                                                                                                                                                        {
                                                                                                                                                            if(value.fecforma !='102')
                                                                                                                                                            {
                                                                                                                                                                if(value.fecforma !='105')
                                                                                                                                                                {
                                                                                                                                                                    if(value.fecforma !='104')
                                                                                                                                                                    {
//                                                                                                                                                                        if(pedidoVerLiberacao.cliente.cliserasaexp < dataHoje)
                                                                                                                                                                        if(pedidoVerLiberacao.cliente.cliserasa < dataLimiteSer)
                                                                                                                                                                        {
                                                                                                                                                                            msg += "SERASA EXPIRADO";
                                                                                                                                                                            alert('SERASA EXPIRADO');
                                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
                                                                                                                                                                            //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                                            msgPreFec +="SERASA EXPIRADO";
                                                                                                                                                                            return false;
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                        }

//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && value.fecforma=='101')
//                                                                                                                                                        {
//                                                                                                                                                            msg = "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA";
////                                                                                                                                                            msg += "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA";
//                                                                                                                                                            alert('FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA DUPLICATA');
//                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
//                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            return false;
//                                                                                                                                                        }
//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && (value.fecforma=='103' || value.fecforma=='110'))
//                                                                                                                                                        {
//                                                                                                                                                            msg += "<br> - FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE";
//                                                                                                                                                            alert('FORMA DE PAGAMENTO SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO. NAO ACEITA CHEQUE');
//                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
//                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            return false;
//                                                                                                                                                        }
//
//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && value.fecforma=='101')
//                                                                                                                                                        {
//                                                                                                                                                            msg += "<br> - FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA";
//                                                                                                                                                            alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO. LIMITE ZERO. NAO ACEITA DUPLICATA');
//                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
//                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            return false;
//                                                                                                                                                        }
//
//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (value.fecforma=='101'))
//                                                                                                                                                        {
//                                                                                                                                                            msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
//                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
//                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            return false;
//                                                                                                                                                        }
//
//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (value.fecforma=='103' || value.fecforma=='110'))
//                                                                                                                                                        {
//                                                                                                                                                            msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
//                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
//                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
//                                                                                                                                                            return false;
//                                                                                                                                                        }

//                                                                                                                                                        if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (value.fecforma=='101' || value.fecforma=='103' || value.fecforma=='110'))
                                                                                                                                                        if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3 || (totalDebts > pedidoVerLiberacao.cliente.clilimite)) && (value.fecforma=='101' || value.fecforma=='103' || value.fecforma=='110'))
                                                                                                                                                        {
                                                                                                                                                            msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
                                                                                                                                                            alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
                                                                                                                                                            $("#retorno").messageBox(msg,false, false);
                                                                                                                                                            msgPreFec +="FORMA SÓ PODE SER A VISTA OU COM CARTAO OU ORDEM PAGTO";
                                                                                                                                                            return false;
                                                                                                                                                        }


                                                                                                                                                    });
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            if(msgPreFec!="")
                                                                                                                                            {
//                                                                                                                                                msg += "NO msgPreFec"+msgPreFec;
//                                                                                                                                                alert(msg);
//                                                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                                                return false;
                                                                                                                                            }

                                                                                                                                            //alert (pedidoVerLiberacao.preFechamento.fecforma);
                                                                                                                                            //if((pedidoVerLiberacao.cliente.vendasEmAberto) > pedidoVerLiberacao.cliente.clilimite))
                                                                                                                                            //{
                                                                                                                                            //	msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
                                                                                                                                            //	alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                                                            //	$("#retorno").messageBox(msg,false, false);
                                                                                                                                            //	return false;
                                                                                                                                            //}

                                                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla=='I' && pedidoVerLiberacao.pvvinculo!=null)
                                                                                                                                            {
                                                                                                                                                valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                                                            }else{
                                                                                                                                                $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                                                                {
                                                                                                                                                    if(value.pedidoVendaItemEstoque.pviest011 > '0')
                                                                                                                                                    {
                                                                                                                                                        estoqueOrigem = "VIX";
                                                                                                                                                        pvlibvit = '1';
                                                                                                                                                    }else if(value.pedidoVendaItemEstoque.pviest09 > '0' || value.pedidoVendaItemEstoque.pviest026 > '0')
                                                                                                                                                    {
                                                                                                                                                        estoqueOrigem = "SP";
                                                                                                                                                        pvlibdep = '1';
                                                                                                                                                    } else if(value.pedidoVendaItemEstoque.pviest01 > '0')
                                                                                                                                                    {
                                                                                                                                                        estoqueOrigem = "SP";
                                                                                                                                                        pvlibfil = '1';
                                                                                                                                                    }else if(value.pedidoVendaItemEstoque.pviest02 > '0' )
                                                                                                                                                    {
                                                                                                                                                        estoqueOrigem = "SP";
                                                                                                                                                        pvlibmat = '1';
                                                                                                                                                    }


                                                                                                                                                });
                                                                                                                                                estoqueDestino = pedidoVerLiberacao.cliente.enderecoFaturamento.cidade.uf;


                                                                                                                                                if((estoqueOrigem=="SP" && estoqueDestino=="BA") || (estoqueOrigem=="SP" && estoqueDestino=="MG") || (estoqueOrigem=="SP" && estoqueDestino=="RS"))
                                                                                                                                                {
                                                                                                                                                    valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc) + pedidoVerLiberacao.calculoSt.substituicao;
                                                                                                                                                }else
                                                                                                                                                if((estoqueOrigem=="SP" && estoqueDestino=="SC") || (estoqueOrigem=="SP" && estoqueDestino=="RJ"))
                                                                                                                                                {
                                                                                                                                                    valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                                                                }else
                                                                                                                                                if((estoqueOrigem=="ES" && estoqueDestino=="BA") || (estoqueOrigem=="ES" && estoqueDestino=="MG") || (estoqueOrigem=="ES" && estoqueDestino=="SC") || (estoqueOrigem=="ES" && estoqueDestino=="RJ") || (estoqueOrigem=="ES" && estoqueDestino=="RS"))
                                                                                                                                                {
                                                                                                                                                    valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                                                                }else{
                                                                                                                                                    valPedido = (pedidoVerLiberacao.pvvalor-pedidoVerLiberacao.pvvaldesc);
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            valPreFechamento = parseFloat(pedidoVerLiberacao.TotalValorPreFechamento);
                                                                                                                                            if(pedidoVerLiberacao.fecreserva!='1')
                                                                                                                                            {
                                                                                                                                                if(valPreFechamento.toFixed(2) != valPedido.toFixed(2))
                                                                                                                                                {
                                                                                                                                                    msg += "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
                                                                                                                                                    alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
                                                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            if(pedidoVerLiberacao.tipoPedido.sigla!='R')
                                                                                                                                            {
                                                                                                                                                if(pedidoVerLiberacao.tipoPedido.sigla!='I')
                                                                                                                                                {
                                                                                                                                                    if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && pedidoVerLiberacao.preFechamento.fecforma=='101')
                                                                                                                                                    {
                                                                                                                                                        msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA DUPLICATA";
                                                                                                                                                        alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                        return false;
                                                                                                                                                    }
                                                                                                                                                    if((pedidoVerLiberacao.cliente.clilimite < pedidoVerLiberacao.cliente.vendasEmAberto.totalVendas) && (pedidoVerLiberacao.preFechamento.fecforma=='103' || pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                                                                                    {
                                                                                                                                                        msg += "<br> - LIMITE MENOR QUE O VALOR DA COMPRA. NAO ACEITA CHEQUE";
                                                                                                                                                        alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                        return false;
                                                                                                                                                    }

                                                                                                                                                    if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && pedidoVerLiberacao.preFechamento.fecforma=='101')
                                                                                                                                                    {
                                                                                                                                                        msg += "<br> - LIMITE ZERO. NAO ACEITA DUPLICATA";
                                                                                                                                                        alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                        return false;
                                                                                                                                                    }
                                                                                                                                                    if((pedidoVerLiberacao.cliente.clilimite=='0'|| pedidoVerLiberacao.cliente.clilimite==null) && (pedidoVerLiberacao.preFechamento.fecforma=='103' || pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                                                                                    {
                                                                                                                                                        msg += "<br> - LIMITE ZERO. NAO ACEITA CHEQUE";
                                                                                                                                                        alert('FORMA DE PAGAMENTO A VISTA OU COM CARTAO OU ORDEM PAGTO');
                                                                                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                        return false;
                                                                                                                                                    }

                                                                                                                                                    if((pedidoVerLiberacao.cliente.clifat==1 || pedidoVerLiberacao.cliente.clifat==3) && (pedidoVerLiberacao.preFechamento.fecforma=='101' || pedidoVerLiberacao.preFechamento.fecforma=='103' || pedidoVerLiberacao.preFechamento.fecforma=='110'))
                                                                                                                                                    {
                                                                                                                                                        msg += "<br> - CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO";
                                                                                                                                                        alert('CLIENTE SO EFETUA COMPRA A VISTA OU NO CARTAO OU ORDEM PAGTO');
                                                                                                                                                        $("#retorno").messageBox(msg,false, false);
                                                                                                                                                        //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                        return false;
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            }

                                                                                                                                            $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                                                            {
                                                                                                                                                //alert(value.produto.grupo.grucodigo  + value.produto.grupo.grunome + pedidoVerLiberacao.cliente.clifat);
                                                                                                                                                if(pedidoVerLiberacao.cliente.clifat== 4 && value.produto.grupo.grucodigo == 6)
                                                                                                                                                {
                                                                                                                                                    msg += "<br> - CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL";
                                                                                                                                                    alert('CLIENTE NAO PODE COMPRAR PRODUTOS MATTEL ');
                                                                                                                                                    $("#retorno").messageBox(msg,false, false);
                                                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            });


                                                                                                                                            msgCodB = "";
                                                                                                                                            $.each(pedidoVerLiberacao.itensPedido, function (key, value)
                                                                                                                                            {
                                                                                                                                                //alert(value.produto.classificacaoFiscal.clanumero);
                                                                                                                                                if(value.produto.classificacaoFiscal.clanumero==0 || value.produto.classificacaoFiscal.clanumero=="")
                                                                                                                                                {
                                                                                                                                                    msgCodB += "<br /> - PRODUTO SEM CLASSIFICACAO FISCAL"+ value.clacodigo;
                                                                                                                                                    alert("PRODUTO SEM CLASSIFICACAO FISCAL" + value.produto.classificacaoFiscal.clacodigo);
                                                                                                                                                    $("#retorno").messageBox(msgCodB,false, false);
                                                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                                //alert(value.produto.codigoBarra.barunidade);
                                                                                                                                                if(value.produto.codigoBarra.barunidade==null || value.produto.codigoBarra.barunidade==0 || value.produto.codigoBarra.barunidade=="")
                                                                                                                                                {
                                                                                                                                                    msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA UNIDADE"+ value.produto.prnome;
                                                                                                                                                    alert("PRODUTO SEM CODIGO DE BARRA NA UNIDADE" +  value.produto.prnome);
                                                                                                                                                    $("#retorno").messageBox(msgCodB,false, false);
                                                                                                                                                    //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                    return false;
                                                                                                                                                }
                                                                                                                                            //alert(value.produto.codigoBarra.barcaixa);
                                                                                                                                            //if(value.produto.codigoBarra.barcaixa==null || value.produto.codigoBarra.barcaixa==0 || value.produto.codigoBarra.barcaixa=="")
                                                                                                                                            //{
                                                                                                                                            //	msgCodB += "<br /> - PRODUTO SEM CODIGO DE BARRA NA CAIXA"+ value.produto.prnome;
                                                                                                                                            //	alert("PRODUTO SEM CODIGO DE BARRA NA CAIXA" +  value.produto.prnome);
                                                                                                                                            ///	$("#retorno").messageBox(msgCodB,false, false);
                                                                                                                                            //	return false;
                                                                                                                                            //}
                                                                                                                                            });
                                                                                                                                            if(msgCodB != "")
                                                                                                                                            {
                                                                                                                                                msg += "<br> - PRODUTO SEM CODIGO DE BARRA";
                                                                                                                                                $("#retorno").messageBox(msg,false, false);
                                                                                                                                                //$("#btnLiberacaoPedido").attr('disabled', '');
                                                                                                                                                return false;

                                                                                                                                            }

                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                }
                                                                                                            }

//alert(
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibdep+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibfil+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibmat+"\n"+
//"pedidoVerLiberacao.pvlibdep: "+pedidoVerLiberacao.pvlibvit
//
//);

                                                                
                                    pedidoEnvia = new Object();
                                    pedidoEnvia.pvemissao =  pedidoVerLiberacao.pvemissao;
                                    pedidoEnvia.pvlibera =  $('#dataAtual').val();
                                    pedidoEnvia.pvhora = $('#horaAtual').val();
                                    pedidoEnvia.pvurgente = '0';
                                    pedidoEnvia.pvnumero = pedidoVerLiberacao.pvnumero;
                                    pedidoEnvia.usuario = usuario.codigo;
//                                                                    pedidoEnvia.pvlibdep = pvlibdep; //pedidoVerLiberacao.pvlibdep;
//                                                                    pedidoEnvia.pvlibfil = pvlibfil; //pedidoVerLiberacao.pvlibfil;
//                                                                    pedidoEnvia.pvlibmat = pvlibmat; //pedidoVerLiberacao.pvlibmat;
//                                                                    pedidoEnvia.pvlibvit = pvlibvit; //pedidoVerLiberacao.pvlibvit;
                                    pedidoEnvia.pvlibdep = ((pedidoVerLiberacao.pvlibdep != "" && pedidoVerLiberacao.pvlibdep != null && pedidoVerLiberacao.pvlibdep != undefined)|| pvlibdep != '')? '1' : null; //pedidoVerLiberacao.pvlibdep;
                                    pedidoEnvia.pvlibfil = ((pedidoEnvia.pvlibdep !== '1') && ((pedidoVerLiberacao.pvlibfil != "" && pedidoVerLiberacao.pvlibfil != null && pedidoVerLiberacao.pvlibfil != undefined) || pvlibfil != '' ))? '1' : null;  //pedidoVerLiberacao.pvlibfil;
                                    pedidoEnvia.pvlibmat = ((pedidoEnvia.pvlibdep !== '1' && pedidoEnvia.pvlibfil !== '1' ) && ((pedidoVerLiberacao.pvlibmat != "" && pedidoVerLiberacao.pvlibmat != null && pedidoVerLiberacao.pvlibmat != undefined) || pvlibmat != '') )? '1' : null; //pedidoVerLiberacao.pvlibmat;
                                    pedidoEnvia.pvlibvit = ((pedidoEnvia.pvlibdep !== '1' && pedidoEnvia.pvlibfil !== '1'  && pedidoEnvia.pvlibmat !== '1' ) &&  ((pedidoVerLiberacao.pvlibvit != "" && pedidoVerLiberacao.pvlibvit != null && pedidoVerLiberacao.pvlibvit != undefined) || pvlibvit != '') )? '1' : null; //pedidoVerLiberacao.pvlibvit;

                                    loglibera =  new Object();
                                    loglibera.usucodigo = usuario.codigo;
                                    loglibera.clicodigo = pedidoVerLiberacao.cliente.clicodigo;
                                    loglibera.lglpedido = pedidoVerLiberacao.pvnumero;
                                    loglibera.lgltipo = pedidoVerLiberacao.tipoPedido.sigla;
                                    loglibera.lgldata =  $('#dataAtual').val();
                                    loglibera.lglhora = $('#horaAtual').val();


                                                                //Aqui o pedido será liberado

//alert(
//
//                                 "6064\n pedidoEnvia.pvemissao " +  pedidoEnvia.pvemissao
//                                 +"\n pedidoEnvia.pvlibera " +  pedidoEnvia.pvlibera
//                                 +"\n pedidoEnvia.pvhora " + pedidoEnvia.pvhora
//                                 +"\n pedidoEnvia.pvurgente " + pedidoEnvia.pvurgente
//                                 +"\n pedidoEnvia.pvnumero " + pedidoEnvia.pvnumero
//                                 +"\n pedidoEnvia.usuario " + pedidoEnvia.usuario
//                                 +"\n pedidoEnvia.pvlibdep " + pedidoEnvia.pvlibdep
//                                 +"\n pedidoEnvia.pvlibfil " + pedidoEnvia.pvlibfil
//                                 +"\n pedidoEnvia.pvlibmat " + pedidoEnvia.pvlibmat
//                                 +"\n pedidoEnvia.pvlibvit " + pedidoEnvia.pvlibvit
//
//                                 +"\n loglibera.usucodigo " + loglibera.usucodigo
//                                 +"\n loglibera.clicodigo " + loglibera.clicodigo
//                                 +"\n loglibera.lglpedido " + loglibera.lglpedido
//                                 +"\n loglibera.lgltipo " + loglibera.lgltipo
//                                 +"\n loglibera.lgldata " +  loglibera.lgldata
//                                 +"\n loglibera.lglhora " + loglibera.lglhora
//
//                                 +"\n\n pvlibdep " + pvlibdep
//                                 +"\n pvlibfil " + pvlibfil
//                                 +"\n pvlibmat " + pvlibmat
//                                 +"\n pvlibvit " + pvlibvit
//
//                                 +"\n pedidoVerLiberacao.pvlibdep " + pedidoVerLiberacao.pvlibdep
//                                 +"\n pedidoVerLiberacao.pvlibfil " + pedidoVerLiberacao.pvlibfil
//                                 +"\n pedidoVerLiberacao.pvlibmat " + pedidoVerLiberacao.pvlibmat
//                                 +"\n pedidoVerLiberacao.pvlibvit " + pedidoVerLiberacao.pvlibvit
//
//
//);
                                                                $.post('modulos/vendaAtacado/pedidos/liberacao/controller/acoes.php',
{
                                                                                        pedido2:JSON.stringify(pedidoEnvia),
                                                                                        loglibera:JSON.stringify(loglibera),
                                                                                        acao:2
                                                                                    },
                                                                                    function(data)
                                                                                    {
                                                                                        //                                        if (Boolean(data.retorno))
                                                                                        if (Boolean(Number(data.retorno)))
                                                                                        {
                                                                                            alert(data.mensagem);

                                                                                            $("#"+id).attr("style", "background: #4682B4");
                                                                                            $("#"+id).hide();
                                                                                        } else {



                                                                                            if ( data.codigo == '424') {
                                                                                                $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                                                                                {
                                                                                                    //variaveis a ser enviadas metodo POST
                                                                                                    id2:id,
                                                                                                    usuario:usuario.codigo,
                                                                                                    acao:9

                                                                                                },
                                                                                                function(data2)
                                                                                                {
                                                                                                    if (Boolean(data2.retorno))
                                                                                                    {
                                                                                                        alert(data2.mensagem);

                                                                                                        $("#"+id).attr("style", "background: #4682B4");
                                                                                                        $("#"+id).hide();
                                                                                                    }
                                                                                                    else if (pvlibdep == '1'){

                                                                                                        $.get('exportawmspedidos.php',
                                                                                                        {
                                                                                                            pedido:id

                                                                                                        }
                                                                                                        );

                                                                                                    }
                                                                                                    alert(data2.mensagem);
                                                                                                    $("#"+id).hide();
                                                                                                },'json');
                                                                                            } else if ( data.codigo == '2') {
                                                                                                alert(data.mensagem);
                                                                                            //                                                            $("#dvSituacao"+id).html('<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+pedidoVerLiberacao.pvnumero+'" email="'+usuario.email+'" prefechamento="'+valorPrefechamento+'" name="financeiro">FINANCEIRO</a>');
                                                                                            }
                                                                                            else {
                                                                                                
                                                                                                if (pvlibdep == '1'){
                                                                                                    $.get('exportawmspedidos.php',
                                                                                                    {
                                                                                                        pedido:id

                                                                                                    }
                                                                                                    );

                                                                                                }
                                                                                                alert(data.mensagem);
                                                                                                $("#"+id).hide();
                                                                                            }

                                                                                        }
                                                                                    },'json');
                                                                                    $("#"+id).attr("style", "background: #4682B4");




                                                                                } // FIM ANÁLISE PARA REALIZAR A LIBERAÇÃO DO PEDIDO
                                                                                else{
                                                                                    alert("FALHA EM REALIZAR A LIBERAÇÃO");
                                                                                }
                                                                            },'json');



//                                                                $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
//                                                                {
//                                                                    //variaveis a ser enviadas metodo POST
//                                                                    id2:id,
//                                                                    usuario:usuario.codigo,
//                                                                    acao:9
//
//                                                                },
//                                                                function(data)
//                                                                {
//                                                                    if (Boolean(data.retorno))
//                                                                    {
//                                                                        alert(data.mensagem);
//                                                                        $("#"+id).attr("style", "background: #4682B4");
//                                                                        $("#"+id).hide();
//                                                                    }
//                                                                    else if (pvlibdep == '1') {
//                                                                         $.get('exportawmspedidos.php',
//                                                                                    {
//                                                                                        pedido:id
//
//                                                                                    }
//                                                                           );
//                                                                        alert(data.mensagem);
//                                                                    }
//                                                                },'json');
//                                                                $("#"+id).attr("style", "background: #4682B4");
//                                                                $("#"+id).hide();

//                                                                                                        } // FIM ANÁLISE PARA REALIZAR A LIBERAÇÃO DO PEDIDO
//                                                                                                        else{
//                                                                                                            alert("FALHA EM REALIZAR A LIBERAÇÃO");
//                                                                                                        }
//                                                                                                    },'json');





                                                            }); // FIM click(function());
                                                        }

                                                        $('#dialog').dialog("close");
                                                    }
                                                    else
                                                    {
                                                        $('#dialog').dialog("close");
                                                        alerta("SITUACAO PEDIDO", "NAO FOI POSSIVEL ALTERAR SITUACAO DO PEDIDO.");
                                                    }
                                                },'json');
                                            }
                                        },


                                        "Cancelar": function()
                                        {

                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function(ev, ui)
                                    {
                                        $(this).dialog("destroy");
                                    }
                                });

                                $("input[name='opcoesSituacao']").change(function(){
                                    $(".emailopcao1").parent().show();
                                    if ($("input[name='opcoesSituacao']:checked").val() == '5'){


                                        $('#lblemailmsg1').text('Excedeu o Prazo para entrega de documento(s)');
                                        $('#lblemailmsg2').text('Restricoes na praca');
                                        $('#lblemailmsg3').text('Titulo(s) vencido(s)');
                                        $('#lblemailmsg4').text('Vinculo(s) com restricoes');
                                        $('#lblemailmsg5').text('Vinculo(s) com titulo em atraso');

                                        $("#emailmsgPdt1").attr(
                                        {'id':'emailmsgNgd1',
                                            'value':'6'});
                                        $("#emailmsgPdt2").attr(
                                        {'id':'emailmsgNgd2',
                                             'value':'7'});
                                        $("#emailmsgPdt3").attr(
                                        {'id':'emailmsgNgd3',
                                             'value':'8'});
                                        $("#emailmsgPdt4").attr(
                                        {'id':'emailmsgNgd4',
                                             'value':'9'});
                                        $("#emailmsgPdt5").attr(
                                        {'id':'emailmsgNgd5',
                                             'value':'10'});
$("input[name='emailmsg']").attr("checked", "");
//$("#emailmsgNgd1").attr("checked", "checked");
//          alert($("input[name='emailmsg']:checked").val() );
                                          if ( $("input[name='emailmsg']:checked").val() == '6') {
//                                                $("#txtObsSituacao").val($('#lblemailmsg1').text());
                                                $("#txtObsSituacao").hide();
                                            }
                                    } else if ($("input[name='opcoesSituacao']:checked").val() == '4'){


                                                        $('#lblemailmsg1').text('Dados Cadastrais');
                                                        $('#lblemailmsg2').text('Boletos | Notas Fiscais');
                                                        $('#lblemailmsg3').text('Carta de Anuencia');
                                                        $('#lblemailmsg4').text('Contrato Social');
                                                        $('#lblemailmsg5').text('Títulos Vencidos');

                                                        $("#emailmsgNgd1").attr(
                                                        {'id':'emailmsgPdt1',
                                                            'value':'1'});
                                                        $("#emailmsgNgd2").attr(
                                                        {'id':'emailmsgPdt2',
                                                             'value':'2'});
                                                        $("#emailmsgNgd3").attr(
                                                        {'id':'emailmsgPdt3',
                                                             'value':'3'});
                                                        $("#emailmsgNgd4").attr(
                                                        {'id':'emailmsgPdt4',
                                                             'value':'4'});
                                                        $("#emailmsgNgd5").attr(
                                                        {'id':'emailmsgPdt5',
                                                             'value':'5'});
$("input[name='emailmsg']").attr("checked", "");
//$("#emailmsgPdt1").attr("checked", "checked");
                                            if ( $("input[name='emailmsg']:checked").val() == '1') {
//                                                $("#txtObsSituacao").val($('#lblemailmsg1').text());
                                                $("#txtObsSituacao").hide();
                                            }

                                    } else {
                                        $("#obsNota").hide();
                                        $(".emailopcao1").parent().hide();
                                        $("#txtObsSituacao").val('_');
                                    }
                                });
//HABILITA O CAMPO OBS
                                $("input[name='emailmsg']").change(function(){
//                                    if ($("input[name='emailmsg']:checked").val() == '1' || $("input[name='emailmsg']:checked").val() == '6') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg1').text());
//                                    } else if ($("input[name='emailmsg']:checked").val() == '2' || $("input[name='emailmsg']:checked").val() == '7') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg2').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '3' || $("input[name='emailmsg']:checked").val() == '8') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg3').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '4' || $("input[name='emailmsg']:checked").val() == '9') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg4').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '5' || $("input[name='emailmsg']:checked").val() == '10') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg5').text());
//                                    }
//                                    if ($("input[name='emailmsg']:checked").val() != '0' ){
//                                          $("#txtObsSituacao").val('_');
//                                      }
//                                    else if($("input[name='emailmsg']:checked").val() >= '1' && {
//                                         $("#txtObsSituacao").val('');
//                                    }

//                                    if ($("input[name='emailmsg']:checked").val() == '0' || $("input[name='emailmsg']:checked").val() == '9' || $("input[name='emailmsg']:checked").val() == '10'){
                                    if ($('#emailmsgPdt0').is(':checked') || $('#emailmsgNgd4').is(':checked') || $('#emailmsgNgd5').is(':checked')){
//                                        alert($("input[name='emailmsg']:checked").val());
//                                        $("#option").attr("checked", "checked");
//
//                                        if ($("input[name='emailmsg']:checked").val() == '9') {
                                        if ($('#emailmsgNgd4').is(':checked')) {
                                            $("#txtObsSituacao").val($('#lblemailmsg4').text());
//                                        } else if ($("input[name='emailmsg']:checked").val() == '10') {
                                        } else if ($('#emailmsgNgd5').is(':checked')) {
                                            $("#txtObsSituacao").val($('#lblemailmsg5').text());
                                        } else {
                                             $("#txtObsSituacao").val('');
                                        }
                                        $("#txtObsSituacao").show();
                                    } else {
                                        $("#txtObsSituacao").hide();
                                    }
                                });



                            }

                        },'json');


                    });

                    $('#divResultado a[tooltip]').each(function()
                    {
                        $(this).qtip(
                        {
                            content: $(this).attr('tooltip'),
                            position:
                            {
                                corner:
                                {
                                    target: 'topMiddle',
                                    tooltip: 'bottomMiddle'
                                }
                            },
                            style:
                            {
                                border:
                                {
                                    width: 1,
                                    radius: 10
                                },
                                padding: 5,
                                textAlign: 'left',
                                tip: true,
                                name: 'dark'
                            }
                        });
                    });
                }
                else
                {
                    alert(data.mensagem);
                }

                $.unblockUI();

                $("a.greybox").click(function()
                {
                    var t = $(this).attr("title") || $(this).attr("text") || $(this).attr("href");
                    var href = $(this).attr("href");
                    var tipo = $(this).attr("name");
                    var id = $(this).attr("id");
                    pvnumero = 	$(this).attr("pvnumero");
//                    var= new Date();
//                    limite.setDate(limite.getDate()-180);
//                    limite = new Date(limite);

                    var callback = function()
                    {
                        var usucodigo = null;

//                        if (tipo == "manutencao" || tipo == "liberacao" || tipo == "manutencaoCredito" )
                        if (tipo == "manutencao" || tipo == "liberacao" || tipo == "manutencaoCredito" || tipo == "validacaoCliente")
                        {

//                            if(tipo == "manutencaoCredito" )
                            if(tipo == "manutencaoCredito" || tipo == "validacaoCliente")
                            {
                                id = pvnumero;
                            }

                            //Envia os dados via metodo post
                            $.post('modulos/vendaAtacado/pedidos/manutencao/controller/acoes.php',
                            {
                                //variaveis a ser enviadas metodo POST
                                acao:13,
                                pvnumero:id,
                                usucodigo:usucodigo
                            },
                            function(data){}, "json");
                        }

                        //Envia os dados via metodo post
                        $.post('modulos/vendaAtacado/pedidos/adm/controller/getPedidoEstacionamento.php',
                        {
                            pvnumero:id
                        },
                        function(data)
                        {
                            if(data.retorno)
                            {
                                var   limiteDisponivel = Number(data.estacionamento.cliente.clilimite) - (Number(data.estacionamento.cliente.vendasEmAberto.totalVendas)-Number(data.estacionamento.pvvalor));
                                var   dataValidacaoCadastro = data.estacionamento.cliente.clidatavalida ? new Date().date(data.estacionamento.cliente.clidatavalida) : '';
                                var   codcliente = data.estacionamento.cliente.clicod;
                                var   manCred = '<a href="'+HTTP_ROOT+'dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+codcliente+'" title="MANUTENCAO DE CREDITO" tooltip="CLIQUE PARA EFETUAR MANUTEÇÃO DE CREDITO DO CLIENTE." class="greybox" id="'+codcliente+'" pvnumero="'+id+'" name="manutencaoCredito">ATUALIZAR</a>';

                                var   prazolimiteInt = 0;
                                var   prazolimiteCad = 0;
                                var   prazolimiteSer = 0;

                                $.each(data.estacionamento.cliente.prazoExpiracao.resultado, function (key, value2){
        //                                                                        alert( "value2.pedescricao: "+ value2.pedescricao +"\n value2.peprazo"+value2.peprazo);
                                                if(value2.pedescricao === 'INTERFIX')
                                                {
                                                        prazolimiteInt = value2.peprazo;
                                                } else if (value2.pedescricao === 'CADASTRO') {
                                                        prazolimiteCad = value2.peprazo;
                                                } else if (value2.pedescricao === 'SERASA') {
                                                        prazolimiteSer = value2.peprazo;
                                                }
                                });

                                limitePrazo = new Date();
        // alert ( "Look a test: "+limitePrazo );
                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteInt );
                                dataLimiteInt = new Date(limitePrazo);
        // alert ( "Look a testInt: "+limitePrazo );
                                limitePrazo = new Date();
                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteCad );
                                dataLimiteCad = new Date(limitePrazo);
        // alert ( "Look a test Cad: "+limitePrazo );
                                limitePrazo = new Date();
                                limitePrazo.setDate( limitePrazo.getDate() - prazolimiteSer );
                                dataLimiteSer = new Date(limitePrazo);



//                                if(data.estacionamento.pvlibera && data.estacionamento.pvlibera && dataValidacaoCadastro != '' && dataValidacao > limiteDisponivel )
                                if(data.estacionamento.pvlibera && data.estacionamento.pvlibera )
                                {
                                    if (Number(data.estacionamento.pvvalor) < limiteDisponivel)
                                    {
                                        $("#"+id).attr("style", "background: #87CEFA");
                                        $("#dvSituacao"+id).html("LIBERADO");
                                        $("#dvManutencao"+id).html("");
                                    }
                                }

                                if (tipo == "validacaoCliente") {

                                        status = $("#dvCodStatus"+id).html();

                                    if(dataValidacaoCadastro != '' && dataValidacaoCadastro > dataLimiteCad){

                                        if (status.match(/\| CADX/i)) {
                                             $("#"+id).attr("style", "background: #FFFFBB");
                                             $("#cadx"+codcliente).html("");
                                        } else if (status.match(/\| CAD/i)) {
                                            $("#"+id).attr("style", "background: #FFFFBB");
                                             $("#cad"+codcliente).html("");
                                        } else  {
                                            $("#"+id).attr("style", "background: #77DD98");
                                            $("#dvStatus"+id).html("AUTORIZADO");
                                            $("#dvCodStatus"+id).html("");
                                        }

                                        $("#dvValEndereco"+id).html("ATIVO");

                                        if (status.match(/PV/)) {
                                            $("#dvStatus"+id).html("SOMENTE A VISTA");
                                        }
                                        else if(status.match(/SER/)) {
                                            $("#dvStatus"+id).html(manCred);
                                        }
                                        else if(status.match(/SERX/)) {
                                            $("#dvStatus"+id).html(manCred);
                                        }
                                        else if(status.match(/LE/)) {
                                            $("#dvStatus"+id).html("LIMITE EXCEDIDO");
                                        }

                                    }
                                }



                                if(tipo == "manutencaoCredito" )
                                {

                                    var dataSerasaExp = data.estacionamento.cliente.cliserasaexp ? new Date().date(data.estacionamento.cliente.cliserasaexp) : '';
                                    txtDataSerasa = dataSerasaExp ? dataSerasaExp.format("d/m/Y") : '';

                                    //alert(data.estacionamento.cliente.cliserasaexp);
                                    $("#dvSerasa"+id).html(txtDataSerasa);
                                    $("#dvLimite"+id).html($.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal'));




                                    if(Number(data.estacionamento.cliente.clifat) == 3)
                                    {

                                        $("#"+id).attr("style", "background: #FA5050");
                                        $("#dvStatus"+id).html("PROIBIDO");
                                        $("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">PROIBIDO MATTEL</a>');
                                        $("#dvManutencao"+id).html("");
                                        $("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
                                        $("#dvSerasa"+id).html(txtDataSerasa);

                                    }else

                                    if(Number(data.estacionamento.cliente.clifat) == 4)
                                    {
                                        $("#"+id).attr("style", "background: #FA5050");
                                        $("#dvStatus"+id).html("PROIBIDO MATTEL");
                                        $("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">PROIBIDO MATTEL</a>');
                                        $("#dvManutencao"+id).html("");
                                        $("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO" target="_blank">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
                                        $("#dvSerasa"+id).html(txtDataSerasa);
                                    }else

//                                    if (dataAtual.getMonthsBetween(dataSerasaExp) > 0 && (Number(data.estacionamento.pvvalor) < limiteDisponivel) && (Number(data.estacionamento.cliente.clifat) != 3 || Number(data.estacionamento.cliente.clifat) != 4))
                                    if (dataSerasa < dataLimiteSer && (Number(data.estacionamento.pvvalor) < limiteDisponivel) && (Number(data.estacionamento.cliente.clifat) != 3 || Number(data.estacionamento.cliente.clifat) != 4))
                                    {

                                        //$("#"+id).attr("style", "background: #77DD98");
                                        $("#"+id).attr("style", "background: #FFA500");
                                        $("#dvLimite"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=6&popup=1&clicod='+data.estacionamento.cliente.clicod+'"  title="MANUTENÇÃO DE CRÉDITO" tooltip="CLIQUE PARA REALIZAR MANUTENÇÃO DE CRÉDITO">'+$.mask.string(Number(data.estacionamento.cliente.clilimite).toFixed(2), 'decimal')+'</a>');
                                        //$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+id+'"  title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" target="_blank">LIBERAR</a>');
                                        $("#dvStatus"+id).html('<a href="javascript:;" title="ALTERAR SITUACAO" tooltip="CLIQUE PARA ALTERAR SITUACAO DO PEDIDO." id="'+id+'" name="naoAnalisado">NAO ANALISADO</a>');
                                        //$("#dvStatus"+id).html("AUTORIZADO");




                                        $('a[name=naoAnalisado]').click(function()
                                        {
                                            var id = $(this).attr("id");

                                            $('#dialog').attr('title','SITUACAO PEDIDO');

                                            var mensagem = "DESEJA ALTERAR A SITUACAO DO PEDIDO PARA...";

                                            var html = '<p>'+
                                            '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>'+
                                            mensagem+
                                            '</p><form id="formSituacao" name="formSituacao" method="post" action="#">';

                                            if(usuario.nivel == "2")
                                            {
                                                html += '<input align="middle" type="radio" checked="checked" value="4" id="pendentes" name="opcoesSituacao">PENDENTE'+
                                                '<input align="middle" type="radio" value="5" id="negado" name="opcoesSituacao">NEGADO'+
                                                '<input align="middle" type="radio" value="22" id="negado" name="opcoesSituacao">AUTORIZAR';

                                                html += '<p>Motivo:<br/>';
                                                html += '<input type="checkbox" name="emailmsg" class="emailopcao1" id="emailmsgPdt1" value="1"><label id="lblemailmsg1">Dados Cadastrais</label><br/>'+
                                                            '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt2" value="2"><label id="lblemailmsg2">Boletos | Notas Fiscais</label><br/>'+
                                                            '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt3" value="3"><label id="lblemailmsg3">Carta de Anuência</label><br/>'+
                                                            '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt4" value="4"><label id="lblemailmsg4">Contrato Social</label><br/>'+
                                                            '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt5" value="5"><label id="lblemailmsg5">Títulos Vencidos</label><br/>'+
                                                            '<input type="checkbox"  name="emailmsg" class="emailopcao1" id="emailmsgPdt0" value="0"><label id="lblemailmsg6">Outros</label><br/>';

//                                                html += '<textarea name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>';
                                                html += '<textarea style="display:none" name="txtObsSituacao" id="txtObsSituacao" cols="70" rows="3"></textarea>';

                                                html += '</form><h5 id ="obsNota">OBS.: INFORME O MOTIVO DA ALTERACAO DA SITUACAO DO PEDIDO.<h5>';
                                            }
                                            else
                                            {
                                                html += '<input align="middle" type="radio" checked="checked" value="3" id="liberarFinanceiro" name="opcoesSituacao">LIBERAR FINANCEIRO';
                                            }


                                            $('#dialog').html(html);



                                            $('#dialog').dialog(
                                            {
                                                autoOpen: true,
                                                modal: true,
                                                width: 480,
                                                buttons:
                                                {
                                                    "Alterar": function()
                                                    {

if(usuario.nivel == "2") {
                                            titulo = "REALIZANDO ALTERACAO AGUARDE!";
                                            mensagem = "AO TERMINO VOCE RECEBERA UM EMAIL DE NOTIFICACAO";

                                            $('#formSituacao').messageBoxElement(titulo, mensagem);
}
                                                    /*if($("#formSituacao").validate(
																	{
																		rules:{txtObsSituacao:{required: true}},
																		messages:{txtObsSituacao:{required: "Obrigatório o preenchimento do campo observação."}}
																	}).form())*/
                                                    {

                                                            $.post('modulos/vendaAtacado/pedidos/adm/controller/alteraSituacao.php',
                                                            {
                                                                //variaveis a ser enviadas metodo POST
                                                                pvnumero:id,
                                                                situacao:$("input[name='opcoesSituacao']:checked").val(),
                                                                observacao:$("#txtObsSituacao").val(),
                                                                msgSelecionadas:msgSelecionadas
                                                            },
                                                            function(data)
                                                            {

                                                                if (Boolean(data.retorno))
                                                                {

                                                            mensagem = "";
                                                            $("#formSituacao").unblock();
                                                                    if($("input[name='opcoesSituacao']:checked").val() == 22)
                                                                    {
                                                                        $("#"+id).attr("style", "background: #77DD98");
                                                                        //$("#dvSituacao"+id).html('<a href="dtrade.php?flagmenu=9&pgcodigo=11&popup=1&pvnumero='+id+'"  title="LIBERACAO" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" target="_blank">LIBERAR</a>');
                                                                        $("#dvSituacao"+id).html('<a href="javascript:;"   title="LIBERACAO '+id+'" tooltip="CLIQUE PARA REALIZAR LIBERAÇÃO DO PEDIDO" id="'+id+'"  name="liberacao2">LIBERAR</a>');
                                                                        $("#dvStatus"+id).html("AUTORIZADO");


                                                                        $('a[name=liberacao2]').click(function()
                                                                        {
                                                                            var id = $(this).attr("id");

                                                                            var valprefe = $(this).attr("valprefechamento");
                                                                            var valorped = $(this).attr("valorpedido");



                                                                            if(valorped != valprefe)
                                                                            {

                                                                                var msgprefec = "<br> - VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO";
                                                                                alert('VALOR DO PEDIDO NAO CONFERE COM O VALOR DO PREFECHAMENTO');
                                                                                $("#retorno").messageBox(msgprefec,false, false);
                                                                                return false;
                                                                            }


                                                                            $.post('modulos/vendaAtacado/pedidos/adm/controller/acoes.php',
                                                                            {
                                                                                //variaveis a ser enviadas metodo POST
                                                                                id2:id,
																				usuario:usuario.codigo,
                                                                                acao:9

                                                                            },
                                                                            function(data)
                                                                            {
                                                                                if (Boolean(data.retorno))
                                                                                {
                                                                                    alert(data.mensagem);
                                                                                    $("#"+id).attr("style", "background: #4682B4");
                                                                                    $("#"+id).hide();
                                                                                }
                                                                                else if (pvlibdep == '1'){
                                                                                    $.get('exportawmspedidos.php',
                                                                                                {
                                                                                                    pedido:id

                                                                                                }
                                                                                       );
                                                                                    alert(data.mensagem);
                                                                                }
                                                                            },'json');
                                                                            $("#"+id).attr("style", "background: #4682B4");
                                                                            $("#"+id).hide();
                                                                        });
                                                                    }

                                                                    $('#dialog').dialog("close");
                                                                }
                                                                else
                                                                {
                                                                    $('#dialog').dialog("close");
                                                                    alerta("SITUACAO PEDIDO", "NAO FOI POSSIVEL ALTERAR SITUACAO DO PEDIDO.");
                                                                }
                                                            },'json');
                                                        }
                                                    },
                                                    "Cancelar": function()
                                                    {
                                                        $(this).dialog("close");
                                                    }
                                                },
                                                close: function(ev, ui)
                                                {
                                                    $(this).dialog("destroy");
                                                }
                                            });

                               $("input[name='opcoesSituacao']").change(function(){
                                   $(".emailopcao1").parent().show();
                                    if ($("input[name='opcoesSituacao']:checked").val() == '5'){

                                        $('#lblemailmsg1').text('Excedeu o Prazo para entrega de documento(s)');
                                        $('#lblemailmsg2').text('Restricoes na praca');
                                        $('#lblemailmsg3').text('Titulo(s) vencido(s)');
                                        $('#lblemailmsg4').text('Vínculo(s) com restricoes');
                                        $('#lblemailmsg5').text('Vínculo(s) com titulo em atraso');

                                        $("#emailmsgPdt1").attr(
                                        {'id':'emailmsgNgd1',
                                            'value':'6'});
                                        $("#emailmsgPdt2").attr(
                                        {'id':'emailmsgNgd2',
                                             'value':'7'});
                                        $("#emailmsgPdt3").attr(
                                        {'id':'emailmsgNgd3',
                                             'value':'8'});
                                        $("#emailmsgPdt4").attr(
                                        {'id':'emailmsgNgd4',
                                             'value':'9'});
                                        $("#emailmsgPdt5").attr(
                                        {'id':'emailmsgNgd5',
                                             'value':'10'});
$("input[name='emailmsg']").attr("checked", "");
//$("#emailmsgNgd1").attr("checked", "checked");
//          alert($("input[name='emailmsg']:checked").val() );
//                                          if ( $("input[name='emailmsg']:checked").val() == '6') {
//                                                $("#txtObsSituacao").val($('#lblemailmsg1').text());
//                                                $("#txtObsSituacao").hide();
//                                            }
                                    } else if ($("input[name='opcoesSituacao']:checked").val() == '4'){


                                                        $('#lblemailmsg1').text('Dados Cadastrais');
                                                        $('#lblemailmsg2').text('Boletos | Notas Fiscais');
                                                        $('#lblemailmsg3').text('Carta de Anuência');
                                                        $('#lblemailmsg4').text('Contrato Social');
                                                        $('#lblemailmsg5').text('Titulos Vencidos');

                                                        $("#emailmsgNgd1").attr(
                                                        {'id':'emailmsgPdt1',
                                                            'value':'1'});
                                                        $("#emailmsgNgd2").attr(
                                                        {'id':'emailmsgPdt2',
                                                             'value':'2'});
                                                        $("#emailmsgNgd3").attr(
                                                        {'id':'emailmsgPdt3',
                                                             'value':'3'});
                                                        $("#emailmsgNgd4").attr(
                                                        {'id':'emailmsgPdt4',
                                                             'value':'4'});
                                                        $("#emailmsgNgd5").attr(
                                                        {'id':'emailmsgPdt5',
                                                             'value':'5'});
$("input[name='emailmsg']").attr("checked", "");
//$("#emailmsgPdt1").attr("checked", "checked");
//                                            if ( $("input[name='emailmsg']:checked").val() == '1') {
//                                                $("#txtObsSituacao").val($('#lblemailmsg1').text());
//                                                $("#txtObsSituacao").hide();
//                                            }

                                    } else {
                                        $(".emailopcao1").parent().hide();
                                        $("#obsNota").hide();
                                        $("#txtObsSituacao").val('_');
                                    }
                                });
//HABILITA O CAMPO OBS
                                $("input[name='emailmsg']").change(function(){
//                                    if ($("input[name='emailmsg']:checked").val() == '1' || $("input[name='emailmsg']:checked").val() == '6') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg1').text());
//                                    } else if ($("input[name='emailmsg']:checked").val() == '2' || $("input[name='emailmsg']:checked").val() == '7') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg2').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '3' || $("input[name='emailmsg']:checked").val() == '8') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg3').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '4' || $("input[name='emailmsg']:checked").val() == '9') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg4').text());
//                                    }
//                                    else  if ($("input[name='emailmsg']:checked").val() == '5' || $("input[name='emailmsg']:checked").val() == '10') {
//                                         $("#txtObsSituacao").val($('#lblemailmsg5').text());
//                                    }
                                      if ($("input[name='emailmsg']:checked").val() != '0' ){
                                          $("#txtObsSituacao").val('_');
                                      }
                                    else {
                                         $("#txtObsSituacao").val('');
                                    }

//                                    if ($("input[name='emailmsg']:checked").val() == '0' || $("input[name='emailmsg']:checked").val() == '9' || $("input[name='emailmsg']:checked").val() == '10'){
                        if ($('#emailmsgPdt0').is(':checked') || $('#emailmsgNgd4').is(':checked') || $('#emailmsgNgd5').is(':checked')){
//                                        alert($("input[name='emailmsg']:checked").val());
//                                        $("#option").attr("checked", "checked");
//
//                                        if ($("input[name='emailmsg']:checked").val() == '9') {
//                                        if ($('#emailmsgNgd4').is(':checked')) {
//                                            $("#txtObsSituacao").val($('#lblemailmsg4').text());
//                                        }
//                                        else if ($("input[name='emailmsg']:checked").val() == '10') {
//                                        else if ($('#emailmsgNgd5').is(':checked')) {
//                                            $("#txtObsSituacao").val($('#lblemailmsg5').text());
//                                        }
//                                        else {
//                                             $("#txtObsSituacao").val('');
//                                        }
                                        $("#txtObsSituacao").show();
                                    } else {
                                        $("#txtObsSituacao").hide();
                                    }
                                });
                                        });
                                    }
                                }
                            }
                        }, "json");

                    };

                    $.GB_show(href,
                    {
                        height: (document.body.scrollHeight - 80),
                        width: (document.body.scrollWidth - 30),
                        animation: true,
                        overlay_clickable: false,
                        callback: callback,
                        caption: t
                    });

                    return false;
                });
            }, "json");
        }
    });
});
                                 