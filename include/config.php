<?php

//chamando verificador de edi transportadora.
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Data no passado forчando o nуo armazenamento de cache.
//diretorio principal do sistema
define("DIR_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/' . $root);

//diretorio principal de logs
define("DIR_LOGS", '/home/delta/arquivos/logs');

//diretorio principal de uploads
define("DIR_UPLOADS", '/home/delta/arquivos/uploads');

//Maxtrade ( 1 - Modelo Atual | 2 - Cadastro de Produtos Unico | 3 - Junчуo dos Sistemas [Abortado])
define("MAX_NOVO", 2);

//Cor ( 1 - Produчуo | 2 - Testes)
define("MAX_COR", 1);

define("MAX_LETRA", "T");

// Constantes para os Codigos
define("CLIENTE_OLD", 94);
define("CLIENTE_TOY", 103089);
define("CLIENTE_LOJ", 214113);  //Alterar para ? (precisa cadastrar) apos a virada
define("CLIENTE_CAB", 103088);
define("CLIENTE_ANT", 76498);
define("CLIENTE_SRM", 104081);
define("CLIENTE_MEL", 503345);

// Constantes para os CNPJs
define("CNPJ_TOY", "49329873000565");
define("CNPJ_LOJ", "49329873000301");  //Alterar para 49329873000301 apos a virada
define("CNPJ_OLD", "20548209000100");
define("CNPJ_ANT", "20548209000282");

define("INSCRICAO_TOY", "336.521.740.111");

define("RAZAO_TOY", "CENTRO ATACADISTA BARAO LTDA");

// Constantes para os Estabelecimentos
define("ESTABELECIMENTO_TOY", "50");
define("ESTABELECIMENTO_LOJ", "30");  //Alterar para 30 apos a virada
define("ESTABELECIMENTO_OLD", "300");
define("ESTABELECIMENTO_CAB", "20");
define("ESTABELECIMENTO_ANT", "500");
define("ESTABELECIMENTO_SRM", "10");


define("TABELA_USUARIOS_BETA", "usuariosbeta");
define("TABELA_TIPO_PEDIDO", "tipopedbeta");
define("TABELA_CLIENTES", "clientes");
define("TABELA_CLIENTES_ENDERECO_FATURAMENTO", "cliefat");
define("TABELA_CLIENTES_ENDERECO_ENTREGA", "clieent");
define("TABELA_CLIENTES_ENDERECO_COMPLEMENTAR", "cliecom");
define("TABELA_CLIENTES_ENDERECO_COBRANCA", "cliecob");
define("TABELA_CLIENTES_CONTATO_ENDERECO_ENTREGA", "clicent");
define("TABELA_CLIENTES_CONTATO_ENDERECO_COBRANCA", "cliccob");
define("TABELA_CLIENTES_CONTATO_ENDERECO_FATURAMENTO", "clicfat");
define("TABELA_CLIENTES_ENDERECO_SINTEGRA", "clienteenderecosintegra");
define("TABELA_CLIENTES_ENDERECO_RECEITA", "clienteenderecoreceita");
define("TABELA_LOGCREDITO", "logcredito");
define("TABELA_VENDEDORES", "vendedor");
define("TABELA_PRODUTOS", "produto");
define("TABELA_CLASSIFICACAO_FISCAL_PRODUTO", "clfiscal");
define("TABELA_UNIDADE_MEDIDAS_PRODUTO", "medidas");
define("TABELA_CODIGOS_BARRAS", "cbarras");
define("TABELA_TRANSPORTADORAS", "transportador");
define("TABELA_PEDIDOS", "pvenda");
define("TABELA_PEDIDOS_COMPRAS", "pcompra");
define("TABELA_PEDIDOS_AGEND_COMPRAS", "pcompraagendamento");
define("TABELA_PEDIDOS_CANCELADOS", "pvcance");
define("TABELA_ITENS_PEDIDO", "pvitembeta");
define("TABELA_ITENS_PEDIDO2", "pvitem");
define("TABELA_ITENS_PEDIDO_CANCELADOS", "pvicance");
define("TABELA_ITENS_PEDIDO_ESTOQUES", "pviestoques");
define("TABELA_ESTOQUE", "estoque");
define("TABELA_LOGLIBERACAO", "loglibera");
define("TABELA_LOGCADASTRO", "logcadastro");
define("TABELA_LOGSAC", "logsac");
define("TABELA_LOG_PEDIDO_STATUS", "logpvstatus");
define("TABELA_LOG_CCOMERCIAL", "logcondcomercial");
define("TABELA_ESTOQUE_DESTINO_ORIGEM", "estoqueorigemdestino");
define("TABELA_TIPO_PEDIDO__ESTOQUE", "tipopedestoque");
define("TABELA_ESTOQUE_ATUAL", "estoqueatual");
define("TABELA_ESTOQUE_FISICO", "estoquesfisicos");
define("TABELA_CONDICOES_COMERCIAIS", "condcomerciais");
define("TABELA_COBRANCA", "cobranca");
define("TABELA_FORMAS_PAGAMENTO", "formapag");
define("TABELA_CARTOES", "cartoes");
define("TABELA_FORNECEDORES", "fornecedor");
define("TABELA_FORNECEDOR_ENDERECO_COMERCIAL", "forecom");
define("TABELA_CIDADES", "cidades");
define("TABELA_MOVIMENTACAO_ESTOQUE", "movestoque");
define("TABELA_TECNAL_PRODUTO_NOTA", "tecnalprodutonota");
define("TABELA_GRUPO_PRODUTO", "grupo");
define("TABELA_CIDADES_IBGE", "cidadesibge");
define("TABELA_ESTADOS", "estados");
define("TABELA_PREFECHAMENTO", "prefechamento");
define("TABELA_DEVOLUCAO", "devolucao");
define("TABELA_DEVOLUCAO_VENDA_ITEM", "dvitem");
define("TABELA_TIPO_PEDIDO_ESTOQUE", "tipopedestoque");
define("TABELA_USUARIOS", "usuarios");
define("TABELA_PEDIDO_PARCELAS", "pedparcelas");
define("TABELA_PEDIDO_MOVIMENTACAO", "pedidomovimentacao");
define("TABELA_HISTORICO", "historicos");
define("TABELA_PRAZOS", "prazoexpiracao");
define("TABELA_CLIFAT", "clifaturamento");
define("TABELA_SAC", "sac");
define("TABELA_SAC_ITEM", "sac_item");
define("TABELA_SAC_PROBLEMA", "sacprob");
define("TABELA_SAC_PROBLEMA_MACRO", "sacprobmacro");
define("TABELA_SAC_INTERACAO", "sacinteracao");
define("TABELA_DEPARTAMENTOS", "depto");
define("TABELA_NF_FILIAL", "notafil");
define("TABELA_NF_MATRIZ", "notamat");
define("TABELA_NF_VIX", "notavit");
define("TABELA_NF_GUA", "notagua");
define("TABELA_NF_DEP", "notadep");

define("TABELA_NF_ITEM_FILIAL", "nnitem");
define("TABELA_NF_ITEM_MATRIZ", "nmitem");
define("TABELA_NF_ITEM_VIX", "nvitem");
define("TABELA_NF_ITEM_GUA", "ngitem");

define("TABELA_NF_ENTRADA", "notaent");

define("TABELA_OCORENCIA_TRANS", "ocoren");
define("TABELA_OCORENCIA_REG_342_TRANS", "ocorenreg342");

define("TABELA_CONHECIMENTO_TRANS", "conemb");
define("TABELA_CONHECIMENTO_TRANS_REG_322", "conembreg322");

define("TABELA_COBRANCA_TRANS", "doccob");
define("TABELA_COBRANCA_TRANS_REG_352", "doccobreg352");
define("TABELA_COBRANCA_TRANS_REG_353", "doccobreg353");
define("TABELA_COBRANCA_TRANS_REG_354", "doccobreg354");
