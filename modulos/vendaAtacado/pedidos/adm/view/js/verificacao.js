$(function() {

        var feitoNovaConsulta = '';
        var countAjax = 0;

//        pedidoCarregado = $("#clipedido").val();
//        chamadoAcessado = $("#saccodigo").val();
//        clienteAcessado = $("#listaPesquisaClientes").val();

function dadosCliente(){
    $("#clinguerra").val(cliente.clinguerra);
    $("#clirazao").val(cliente.clirazao);
    $("#clicod").val(cliente.clicod);
    $("#clicnpj").val(cliente.clicnpj);
    $("#clecidade").val(cliente.enderecoFaturamento.cidade.descricao);
    $("#cleuf").val(cliente.enderecoFaturamento.cidade.uf);
    $("#clefone").val(cliente.enderecoFaturamento.clefone);
    $("#ccfnome0").val(cliente.enderecoFaturamento.contatos.ccfnome);
}


        	$("#listaPesquisaChamados").ajaxComplete(function()
			{
                            feitoNovaConsulta = $("#clicod").val();
                            pedidoCarregado = $("#clipedido").val();
                            chamadoAcessado = $("#saccodigo").val();
                            
                   if(typeof(cliente.clinguerra) != 'undefined' && (feitoNovaConsulta != cliente.clicod && $("#listaPesquisaClientes").html() != "")  ) {

                            feitoNovaConsulta = cliente.clicod;
                            var getUrl = window.location.href;
                            var isInclusaoChamado = (getUrl.substr(-1) == 4)?true:false;
                            
                            if(isInclusaoChamado){
                                dadosCliente();
                            }
//alert("countAjax: "+countAjax);
//countAjax++;

                            if(cliente.sac != 'undefined' && cliente.sac != null ) {
                                dadosCliente();
                                
                                $.each(cliente.sac, function (key, valueSac)
                                           {
                                            if(valueSac.saccodigo == $("#listaPesquisaChamados").val() ){
                                                
                                                $("#usuariosac").html("<em>"+valueSac.usuario.nome+"</em>")
                                                $("#saccodigo").val(valueSac.saccodigo);
                                                $(".dataChamado").html("<strong>"+valueSac.sacdata+"</strong>");
                                                var indexTpAtendimento = Number(valueSac.tp_atendimento)-1;
                                                $('input:radio[name=tpatendimento]')[indexTpAtendimento].checked = true;
                                                $("#sacproblemmacro").val(valueSac.sacproblemmacro);
                                                $("#sacproblem").val(valueSac.sacproblem);
                                                $("#cliobs").val(valueSac.sacdescricao);
                                                $("#nfobs").val(valueSac.sac_nfobs);
                                                $("#sacregiao").val(valueSac.sac_regiao);
                                                $("#sactelalt").val(valueSac.sac_telalternativo);
                                                $("#sacnfcli").val(valueSac.sac_nfcliente);
                                                $("#sacnfclienvio").val(valueSac.sacnfclienvio);
                                                $("#sacnfcliemissao").val(valueSac.sacnfcliemissao);
                                               
                                                $("#dataretorno").val(valueSac.sac_dataretorno);
                                                $("#sacformretorno").val(valueSac.sac_formaretorno);
                                                $("#saccontato").val(valueSac.sac_contato);
                                                $("#saccontatostatus").val(valueSac.sac_contatostatus);
                                                
                                                if (valueSac.tracodigo.tranguerra != 'undefined' && valueSac.tracodigo.tranguerra != null && valueSac.tracodigo.tranguerra != ''){
                                                        populaTransportadora(valueSac.tracodigo.tracodigo,valueSac.tracodigo.tranguerra);
                                                }
                                                $("#sacfretereverso").val(valueSac.sac_fretereverso);
                                                    

                                                    sacproced = (valueSac.sacproced == 't')?"1":(valueSac.sacproced == 'f')?"2":"";
                                                    cliespecial = (valueSac.sac_cliespecial == 't')?"1":(valueSac.sac_cliespecial == 'f')?"2":"";
                                                    sacexcecao = (valueSac.sac_excecao == 't')?"1":(valueSac.sac_excecao == 'f')?"2":"";
                                                    sac_assistencia = (valueSac.sac_assistencia == 't')?"1":(valueSac.sac_assistencia == 'f')?"2":"";

                                                    $("#sacproced").val(sacproced);
                                                    $("#sacassistencia").val(cliespecial);
                                                    $("#saccliespecial").val(sacexcecao);
                                                    $("#sacexcecao").val(sac_assistencia);
                                                    $("#sacstatusobs").val(valueSac.sac_statusobs);
//                                                    $("#listaStatus").val(valueSac.sac_status);
                                                    $("#dataStatus").val(valueSac.sac_data_status);

//                                                    $("#localfaturamento").val(estoque);

//                                            }

                                        var tabelaItens = '';
                                        var countProd = 0;
                                        var t ='Consulta_de_Pedidos_de_Venda';

                                            if(valueSac.sac_item != 'undefined' && valueSac.sac_item != null){
                                                    if(valueSac.sac_item.itensPedido != 'undefined' && valueSac.sac_item.itensPedido != null){
                                                        $.each(valueSac.sac_item.itensPedido, function (key, valueItem)

//                                                        $.each(valueSac.sac_item.itens, function (key, arrayItens)
                                                            {
//                                                                $.each(arrayItens.relacaoItens.itensPedido, function (key, valueItem){
                                                                if( valueItem.pedidoVendaItemEstoque.pviest026 != '' && valueItem.pedidoVendaItemEstoque.pviest026 != null ) {
                                                                     estoque = 'GUARULHOS';
                                                                } else if( valueItem.pedidoVendaItemEstoque.pviest09 != ''  && valueItem.pedidoVendaItemEstoque.pviest09 != null ) {
                                                                     estoque = 'VL. GUILHERME';
                                                                } else if( valueItem.pedidoVendaItemEstoque.pviest09 != ''  && valueItem.pedidoVendaItemEstoque.pviest09 != null ) {
                                                                     estoque = 'VIX';
                                                                } else if( valueItem.pedidoVendaItemEstoque.pviest01 != '' && valueItem.pedidoVendaItemEstoque.pviest01 != null ) {
                                                                     estoque = 'FILIAL';
                                                                } else if( valueItem.pedidoVendaItemEstoque.pviest02 != '' && valueItem.pedidoVendaItemEstoque.pviest02 != null) {
                                                                     estoque = 'MATRIZ';
                                                                }

                                                               qtdItem = Number(valueItem.pvisaldo);
                                                               precoItem = $.mask.string(parseFloat(valueItem.pvipreco).toFixed(2), "decimal");
                                                               totalItemTmp = valueItem.pvisaldo * valueItem.pvipreco;
                                                               totalItem = $.mask.string(parseFloat(totalItemTmp).toFixed(2), 'decimal');

                                                               itemResp = (valueItem.SacItem.sacitresponsavel != null)? valueItem.SacItem.sacitresponsavel:"";
                                                               itemObs = (valueItem.SacItem.sacitresponsavel != null)? valueItem.SacItem.sacitobs:"";
                                                               qtdProd = (valueItem.SacItem.sacitqtd != null)? valueItem.SacItem.sacitqtd:"";

                                                                if (countProd % 2==0){
                                                                        corFundo = "#FFFFFF";
                                                                } else {
                                                                        corFundo = "#EEEEEE";
                                                                }
                                                               tabelaItens += "<tr class='bodyProduto' bgcolor='"+corFundo+"'>";
                                                               tabelaItens += "<td align='center' height='32' id='produtoPedido"+valueItem.SacItem.pvnumero+"_"+countProd+"'>";
                                                               tabelaItens += "<a href='pedvendacons2.php?codped="+valueItem.SacItem.pvnumero+"' target='_blank' >"+valueItem.SacItem.pvnumero+"</a>";
                                                               tabelaItens += "<td align='center' height='32' '>"+valueItem.produto.procod;
                                                               tabelaItens += "<input type='hidden' name='prodcod"+valueItem.SacItem.pvnumero+"_"+countProd+"' id='prodcod"+valueItem.SacItem.pvnumero+"_"+countProd+"' value='"+valueItem.produto.procodigo+"' ></td>";
                                                               tabelaItens += "<td>"+valueItem.produto.prnome+"</td>";
                                                               tabelaItens += "<td align='center'>"+qtdItem+"</td>";
                                                               tabelaItens += "<td align='center'>"+precoItem+"</td>";
                                                               tabelaItens += "<td align='right'>"+totalItem+"</td>";
                                                               tabelaItens += "<td align='center'>"+estoque+"</td>";

                            //                                     tabelaItens += "<td align='center' > <input name='prodqtd"+countProd+"' style='width:20px;'  id='prodqtd"+countProd+"' type='text' value='0' size='20' style='text-align:center;' /></td>";
                                                                 tabelaItens += "<td align='center' > <select name='prodqtd"+valueItem.SacItem.pvnumero+"_"+countProd+"' id='prodqtd"+valueItem.SacItem.pvnumero+"_"+countProd+"'   style='text-align:center;width:50px;height:21px' >";

                                                                  for (i = 0; i <= qtdItem; i++) {
                                                                     tabelaItens += (i == Number(qtdProd))? "<option value='"+i+"' selected>"+i+"</option>":"<option value='"+i+"'>"+i+"</option>";
                                                                  }
                                                                 tabelaItens += "</select></td>";


                                                                tabelaItens += "<td align='center' > <input name='prodresp"+valueItem.SacItem.pvnumero+"_"+countProd+"'  id='prodresp"+valueItem.SacItem.pvnumero+"_"+countProd+"' type='text' value='"+itemResp+"'  style='text-align:center;width:120px' /></td>"+
                                                                "<td align='center' > <input name='prodobs"+valueItem.SacItem.pvnumero+"_"+countProd+"'  id='prodobs"+valueItem.SacItem.pvnumero+"_"+countProd+"' type='text' value='"+itemObs+"'  style='text-align:center;width:120px' /></td>"+
                                                                "<td align='center'> <input type='checkbox' name='prodcount"+valueItem.SacItem.pvnumero+"_"+countProd+"' id='prodcount"+valueItem.SacItem.pvnumero+"_"+countProd+"'";

                                                            if((itemResp != '') || (itemObs != '') ) {
                                                                tabelaItens +="checked class='selectProd' ></td></tr>";
                                                            } else {
                                                                tabelaItens +=" class='selectProd' ></td></tr>";
                                                            }

                                                           countProd++;
                                                           
                                                                 });

                                                            $("#tableproduto").show();

                                                            $('#gridproduto').append(tabelaItens);

                                                            var cloneTest = $(this).parent().parent().clone().end().appendTo('#gridproduto');
                                                    }
                                            }

                                            var statusEData = '';
                                            var imprimirTodosStatus = (valueSac.sac_log.logs.length >= 3)? true:false;
                                            var imprimir2status =  (valueSac.sac_log.logs.length == 2)? true:false;
                                            var i=0;
                                            var qtdRegLog = valueSac.sac_log.logs.length;
                                            $.each(valueSac.sac_log.logs, function (key, valueLogs) {
                                                    statusEData = "<strong>"+valueLogs.lgsdata + " - "+valueLogs.lgsmsgstatus+"</strong>";

                                                       if(i == 0) {
                                                            $("#dataStatus").html(statusEData);
                                                        }
                                                        if(qtdRegLog>2 && i == (qtdRegLog-1)){
                                                            $("#dataStatus3").html(statusEData);
                                                        }else if(i > 0){
                                                            $("#dataStatus2").html(statusEData);
                                                        }

                                                i++;
                                            });


                                        }
                                }); 

                            }

//                            else if(!isInclusaoChamado){
//                                mensagem = 'NÃO HÁ CHAMADO PARA ESSE CLIENTE.<br/>';
//                                $("#retorno").messageBox(mensagem,null,null);
//                                clean();
//                                return false;
//                            }

                            var tabelaItens = '';
                            var countProd = 0;
                            var estoque = '';
                           
                            var tabelaVales = '';

                         
                        }

                     });  // fim ajaxComplete();
                     

});