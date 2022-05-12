<?php

require_once("include/conexao.inc.php");
require_once("include/romaneios.php");
require_once("./_app/Config.inc.php");
//require_once('include/classes/PrazoEntrega.php');

$romcodigo = $_REQUEST["romcodigo"];
if (isset($_REQUEST["pvnumero"])) {
    $num = $_REQUEST["pvnumero"];
} else {
    $num = [];
}
if (isset($_REQUEST["rpvolumes"])) {
    $vol = $_REQUEST["rpvolumes"];
} else {
    $vol = [];
}
$romveiculo = $_REQUEST["romveiculo"];
$romsaida = $_REQUEST["romsaida"];
$rommotorista = $_REQUEST["rommotorista"];
$romajudante = $_REQUEST["romajudante"];
$rominicial = $_REQUEST["rominicial"];
$romfinal = $_REQUEST["romfinal"];
$romtipofrete = $_REQUEST["romtipofrete"];
$romobservacao = $_REQUEST["romobservacao"];
$romvalor = $_REQUEST["romvalor"];
$rompercentual = $_REQUEST["rompercentual"];
$tracodigo = $_REQUEST["transp"];
$usucodigo = $_REQUEST["usucodigo"];

$cadastro = new banco($conn, $db);

//Busca os dados para lançar no Log
$sql = "SELECT * FROM romaneios WHERE romcodigo = $romcodigo";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$romveiculoAntes = 0;
$romsaidaAntes = '';
$rommotoristaAntes = '';
$rominicialAntes = '';
$romtipofreteAntes = 0;
$romobservacaoAntes = '';
$romvalorAntes = 0;
$rompercentualAntes = 0;
$romajudanteAntes = '';
$tracodigoAntes = 0;
if ($row) {
    $romveiculoAntes = pg_fetch_result($sql, 0, "romveiculo");
    $romsaidaAntes = pg_fetch_result($sql, 0, "romsaida");
    $rommotoristaAntes = trim(pg_fetch_result($sql, 0, "rommotorista"));
    $rominicialAntes = pg_fetch_result($sql, 0, "rominicial");
    $romtipofreteAntes = pg_fetch_result($sql, 0, "romtipofrete");
    $romobservacaoAntes = pg_fetch_result($sql, 0, "romobservacao");
    $romvalorAntes = pg_fetch_result($sql, 0, "romvalor");
    $rompercentualAntes = pg_fetch_result($sql, 0, "rompercentual");
    $romajudanteAntes = trim(pg_fetch_result($sql, 0, "romajudante"));
    $tracodigoAntes = pg_fetch_result($sql, 0, "tracodigo");
}

$cadastro->alteraromaneio("romaneios", "romveiculo='$romveiculo'
	,romsaida='$romsaida'
	,rommotorista='$rommotorista'
	,rominicial='$rominicial'
	,romfinal='$romfinal'
	,romtipofrete='$romtipofrete'
	,romobservacao='$romobservacao'
	,romvalor='$romvalor'
	,rompercentual='$rompercentual'
	,romajudante='$romajudante'
	,tracodigo='$tracodigo'
	", "$romcodigo");


$dataLog = date('Y-m-d H:i:s');
$cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,tracodigo,operacao)", "('$dataLog','$usucodigo','$romcodigo','$tracodigo',3)");

//Se houve alteração de algum campo grava no log
if ($romveiculoAntes != $romveiculo) {

    //Pesquisa o nome do Veículo para já armazenar no Log
    $sql = "SELECT veimodelo FROM veiculos WHERE veicodigo = $romveiculoAntes";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $romveiculoAntesModelo = '';
    if ($row) {
        $romveiculoAntesModelo = pg_fetch_result($sql, 0, "veimodelo");
    }

    $sql = "SELECT veimodelo FROM veiculos WHERE veicodigo = $romveiculo";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $romveiculoModelo = '';
    if ($row) {
        $romveiculoModelo = pg_fetch_result($sql, 0, "veimodelo");
    }

    $antes = trim($romveiculoAntes) . ' ' . trim($romveiculoAntesModelo);
    $depois = trim($romveiculo) . ' ' . trim($romveiculoModelo);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'VEICULO','$antes','$depois')");
}
if ($romsaidaAntes != $romsaida) {

    $antes = trim($romsaidaAntes);
    $depois = trim($romsaida);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'SAIDA','$antes','$depois')");
}
if ($rommotoristaAntes != $rommotorista) {

    $antes = trim($rommotoristaAntes);
    $depois = trim($rommotorista);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'MOTORISTA','$antes','$depois')");
}
if ($rominicialAntes != $rominicial) {

    $antes = trim($rominicialAntes);
    $depois = trim($rominicial);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'PLACA','$antes','$depois')");
}
if ($romtipofreteAntes != $romtipofrete) {

    $romtipofreteAntesNome = '';
    if ($romtipofreteAntes == 1) {
        $romtipofreteAntesNome = 'VALOR';
    } else if ($romtipofreteAntes == 2) {
        $romtipofreteAntesNome = 'PERCENTUAL';
    } else if ($romtipofreteAntes == 3) {
        $romtipofreteAntesNome = 'PROPRIO';
    }

    $romtipofreteNome = '';
    if ($romtipofrete == 1) {
        $romtipofreteNome = 'VALOR';
    } else if ($romtipofrete == 2) {
        $romtipofreteNome = 'PERCENTUAL';
    } else if ($romtipofrete == 3) {
        $romtipofreteNome = 'PROPRIO';
    }

    $antes = trim($romtipofreteAntes) . ' ' . trim($romtipofreteAntesNome);
    $depois = trim($romtipofrete) . ' ' . trim($romtipofreteNome);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'TIPO FRETE','$antes','$depois')");
}
if ($romobservacaoAntes != $romobservacao) {

    $antes = substr(trim($romobservacaoAntes), 0, 100);
    $depois = substr(trim($romobservacao), 0, 100);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'OBSERVACAO','$antes','$depois')");
}
if ($romvalorAntes != $romvalor) {

    $antes = number_format($romvalorAntes, 2, ",", ".");
    $depois = number_format($romvalor, 2, ",", ".");

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'VALOR','$antes','$depois')");
}
if ($rompercentualAntes != $rompercentual) {

    $antes = number_format($rompercentualAntes, 2, ",", ".");
    $depois = number_format($rompercentual, 2, ",", ".");

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'PERCENTUAL','$antes','$depois')");
}
if ($romajudanteAntes != $romajudante) {

    $antes = trim($romajudanteAntes);
    $depois = trim($romajudante);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'AJUDANTE','$antes','$depois')");
}
if ($tracodigoAntes != $tracodigo) {

    //Pesquisa o nome da Transportadora para já armazenar no Log
    $sql = "SELECT tranguerra FROM transportador WHERE tracodigo = $tracodigoAntes";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $tracodigoAntesNome = '';
    if ($row) {
        $tracodigoAntesNome = pg_fetch_result($sql, 0, "tranguerra");
    }

    $sql = "SELECT tranguerra FROM transportador WHERE tracodigo = $tracodigo";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    $tracodigoNome = '';
    if ($row) {
        $tracodigoNome = pg_fetch_result($sql, 0, "tranguerra");
    }

    $antes = trim($tracodigoAntes) . ' ' . trim($tracodigoAntesNome);
    $depois = trim($tracodigo) . ' ' . trim($tracodigoNome);

    $dataLog = date('Y-m-d H:i:s');
    $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'TRANSPORTADORA','$antes','$depois')");
}

//Joga os pedidos que estão gravados num array
$arrayPedidos = [];

$sql = "SELECT pvnumero,rpvolumes FROM romaneiospedidos WHERE romcodigo = '$romcodigo'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);

if ($row) {

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {

        $pvnumero = pg_fetch_result($sql, $i, "pvnumero");
        $rpvolumes = pg_fetch_result($sql, $i, "rpvolumes");

        $key = array_search($pvnumero, array_column($arrayPedidos, 'pvnumero'));
        if (false !== $key) {

            $arrayPedidos[$key]['antesvol'] = $rpvolumes;
        } else {
            $arrayPedidos[] = ["pvnumero" => $pvnumero,
                "antes" => 1,
                "antesvol" => $rpvolumes,
                "depois" => 0,
                "depoisvol" => 0];
        }

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,pvnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$pvnumero',14)");
    }
}



//Apaga os Pedidos anteiores
$cadastro->apaga1("romaneiospedidos", "$romcodigo");

//Grava os Pedidos Novamente
if (sizeof($num) > 0) {
    for ($ix = 0; $ix < sizeof($num); $ix++) {
        if (trim($num[$ix]) != '0') {

            $pvnumero = trim($num[$ix]);
            $rpvolumes = trim($vol[$ix]);

            $key = array_search($pvnumero, array_column($arrayPedidos, 'pvnumero'));
            if (false !== $key) {
                $arrayPedidos[$key]['depois'] = 1;
                $arrayPedidos[$key]['depoisvol'] = $rpvolumes;
            } else {
                $arrayPedidos[] = ["pvnumero" => $pvnumero,
                    "antes" => 0,
                    "antesvol" => 0,
                    "depois" => 1,
                    "depoisvol" => $rpvolumes];
            }

            //$Prazo = new PrazoEntrega();
            //$prazoentrega = $Prazo->calcular($pvnumero, 1, $romcodigo);
            
            //$promessaentrega = $Prazo->calcularPromessa($pvnumero);
            
            //'romprevisao' => $prazoentrega,
            //'rompromessa' => $promessaentrega

            $Dados = [
                'romcodigo' => $romcodigo,
                'pvnumero' => $pvnumero,
                'rpvolumes' => $rpvolumes                
            ];

            $Cadastra = new Create;
            $Cadastra->ExeCreate('romaneiospedidos', 'romaneiospedidos_rompedcodigo_seq', $Dados);

            $dataLog = date('Y-m-d H:i:s');
            $cadastro->insere("logromaneiosgeral", "(lgrdata,usucodigo,romcodigo,pvnumero,operacao)", "('$dataLog','$usucodigo','$romcodigo','$pvnumero',13)");

            $data = date('Y-m-d H:i:s');

            $sql2 = "SELECT * from pedidosexpedidos where pvnumero = '$pvnumero'";
            $sql2 = pg_query($sql2);
            $row2 = pg_num_rows($sql2);
            if ($row2) {
                
            } else {
                $cadastro->insere("pedidosexpedidos", "(pvnumero,pvdatahora)", "('$pvnumero','$data')");
            }
        }
    }
}

//Verifica se houve mudanças nos pedidos do Romaneio
//Looping no vetor
foreach ($arrayPedidos as $pedido) {

    $pvnumero = $pedido['pvnumero'];
    $antesx = $pedido['antes'];
    $antesvol = $pedido['antesvol'];
    $depoisx = $pedido['depois'];
    $depoisvol = $pedido['depoisvol'];

    //Pedido excluido
    if ($antesx == 1 && $depoisx == 0) {
        $antes = trim($pvnumero);
        $depois = 'EXCLUIDO';

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'PEDIDO','$antes','$depois')");
    } else if ($antesx == 0 && $depoisx == 1) {
        $antes = trim($pvnumero);
        $depois = 'INCLUIDO';

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'PEDIDO','$antes','$depois')");
    } else if ($antesvol != $depoisvol) {
        $antes = trim($pvnumero);
        $depois = 'VOLUMES: ' . trim($antesvol) . '=>' . trim($depoisvol);

        $dataLog = date('Y-m-d H:i:s');
        $cadastro->insere("logromaneios", "(lgrdata,usucodigo,romcodigo,romcampo,romantes,romdepois)", "('$dataLog',$usucodigo,$romcodigo,'PEDIDO','$antes','$depois')");
    }
}

pg_close($conn);

$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
$xml .= "<dados>\n";
$xml .= "<dado>\n";
$xml .= "<retorno>1</retorno>\n";
$xml .= "</dado>\n";
$xml .= "</dados>\n";
Header("Content-type: application/xml; charset=iso-8859-1");

echo $xml;
