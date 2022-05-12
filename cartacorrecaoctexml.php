<?php

require_once("include/conexao.inc.php");

$usuario = $_GET["usuario"];
$ctecodigo = $_GET["ctecodigo"];

$c01 = $_REQUEST["grupo"];
$c02 = $_REQUEST["campo"];
$c03 = $_REQUEST["item"];
$c04 = $_REQUEST["valor"];

$data = date("Y-m-d H:i:s");

$fuso = date("P");

$sql = "SELECT parambiente,parversao,parcodigos,ctesegnome,ctesegapolice,cterntrc,cteperservico,ctelayoutversao FROM  parametros";
$sql = $sql . " WHERE parcod = '1'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $parambiente = pg_fetch_result($sql, 0, "parambiente");
    $ctelayoutversao = pg_fetch_result($sql, 0, "ctelayoutversao");
    if (trim($parambiente) == "") {
        $parambiente = "1";
    }
    if (trim($ctelayoutversao) == "") {
        $ctelayoutversao = "1";
    }
}


if ($ctelayoutversao == "1") {
    $versao = '2.00';
} else {
    $versao = '3.00';
}

//Verifica o número sequencial do Evento de Carta de Correcao
$sql = "SELECT max(cccseq) as seq FROM ctecartacorrecao WHERE ctenumero={$ctecodigo}";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
$seq = 0;
if ($row) {
    $seq = (int) pg_fetch_result($sql, 0, "seq");
}
$seq++;

$sql = "INSERT INTO ctecartacorrecao (cccusuario,cccdata,ctenumero,cccseq) values ('$usuario','$data','$ctecodigo','$seq')";
pg_query($sql);

$idcce = 0;

$b = 0;
while ($b < 1000) {
    $sql = "SELECT ccccodigo FROM ctecartacorrecao WHERE cccdata='{$data}' AND ctenumero={$ctecodigo}";
    $sql = pg_query($sql);
    $row = pg_num_rows($sql);
    if ($row) {
        $idcce = pg_fetch_result($sql, 0, "ccccodigo");
        break;
    } else {
        $b++;
    }
}

if (sizeof($c01) > 0) {
    for ($i = 0; $i < sizeof($c01); $i++) {
        if ($c01[$i] != '') {
         
            $sql = "INSERT INTO ctecartacorrecaoitem (ccccodigo,ccigrupo,ccicampo,cciitem,cciobs) values ({$idcce},'$c01[$i]','$c02[$i]','$c03[$i]','$c04[$i]')";
            pg_query($sql);
            
        }
    }
}

$sql = "Select * FROM cte where ctenumero  = '$ctecodigo'";

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    for ($i = 0; $i < $row; $i++) {

        $cteemicnpj = pg_fetch_result($cad, $i, "cteemicnpj");

        $cteemicnpj = str_replace('.', '', $cteemicnpj);
        $cteemicnpj = str_replace('/', '', $cteemicnpj);
        $cteemicnpj = str_replace('-', '', $cteemicnpj);

        $ctechave = pg_fetch_result($cad, $i, "ctechave");
    }
}

$tpEvento = '110110';
$nSeqEvento = $seq;
$id = 'ID' . $tpEvento . $ctechave . str_pad($nSeqEvento, 2, '0', STR_PAD_LEFT);
$cOrgao = '35';

$name = "/home/delta/cte/" . $ctechave . "_" . $tpEvento . "_" . str_pad($nSeqEvento, 2, '0', STR_PAD_LEFT) . ".xml";

//Gravar a chave da Carta de Correcao 
$update = "UPDATE ctecartacorrecao SET cccchave='$id' WHERE ccccodigo  = '$idcce'";
pg_query($update);

$text = '<eventoCTe xmlns="http://www.portalfiscal.inf.br/cte" versao="' . $versao . '">';
$text .= '<infEvento Id="' . $id . '">';            //Identificador da TAG a ser assinada, a regra de formação do Id é: “ID”+ tpEvento+ chave do CT-e+ nSeqEvento

$text .= '<cOrgao>35</cOrgao>';            //Código do órgão de recepção do Evento. Utilizar a Tabela do IBGE extendida, utilizar 90 para identificar SUFRAMA 
$text .= '<tpAmb>1</tpAmb>';               //1 – Produção 2 – Homologação
$text .= '<CNPJ>' . $cteemicnpj . '</CNPJ>';         //Informar o CNPJ do autor do Evento
$text .= '<chCTe>' . $ctechave . '</chCTe>';         //Chave de Acesso do CT-e vinculado ao Evento
$text .= '<dhEvento>' . substr($data, 0, 10) . 'T' . substr($data, 11, 8) . $fuso . '</dhEvento>';        //Data e hora do evento no formato AAAAMM-DDThh:mm:ss	
//$text.= '<dhEvento>'.substr($data,0,10) . 'T' . substr($data,11,8) .'</dhEvento>';								//Data e hora do evento no formato AAAAMM-DDThh:mm:ss	
$text .= '<tpEvento>' . $tpEvento . '</tpEvento>';       //Tipo do Evento
$text .= '<nSeqEvento>' . $nSeqEvento . '</nSeqEvento>';      //Sequencial do evento para o mesmo tipo de evento. Para maioria dos eventos será 1, nos casos em que possa existir mais de um evento o autor do evento deve numerar de forma sequencial.
$text .= '<detEvento versaoEvento="' . $versao . '">';

$text .= '<evCCeCTe>';

$text .= '<descEvento>Carta de Correcao</descEvento>';

if (sizeof($c01) > 0) {
    for ($i = 0; $i < sizeof($c01); $i++) {
        if ($c01[$i] != '') {
         
            $text .= '<infCorrecao>';            
            $text .= '<grupoAlterado>' . trim($c01[$i]) . '</grupoAlterado>';
            $text .= '<campoAlterado>' . trim($c02[$i]) . '</campoAlterado>';
            $text .= '<valorAlterado>' . trim($c04[$i]) . '</valorAlterado>';
            $text .= '<nroItemAlterado>' . trim($c03[$i]) . '</nroItemAlterado>';            
            $text .= '</infCorrecao>';
            
        }
    }
}

//$text .= '<xCondUso>A Carta de Correcao e disciplinada pelo Art. 58-B do CONVENIO/SINIEF 06/89: Fica permitida a Projeto Conhecimento de Transporte Eletronico MOC 3.00a Pagina 108 / 153 utilizacao de carta de correcao, para regularizacao de erro ocorrido na emissao de documentos fiscais relativos a prestacao de servico de transporte, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da prestacao;II - a correcao de dados cadastrais que implique mudanca do emitente, tomador, remetente ou do destinatario;III - a data de emissao ou de saida.</xCondUso>';

/*
"<xCondUso>" .
            "A Carta de Correcao e disciplinada pelo Art. 58-B do " .
            "CONVENIO/SINIEF 06/89: Fica permitida a utilizacao de carta de " .
            "correcao, para regularizacao de erro ocorrido na emissao de " .
            "documentos fiscais relativos a prestacao de servico de transporte, " .
            "desde que o erro nao esteja relacionado com: I - as variaveis que " .
            "determinam o valor do imposto tais como: base de calculo, " .
            "aliquota, diferenca de preco, quantidade, valor da prestacao;II - " .
            "a correcao de dados cadastrais que implique mudanca do emitente, " .
            "tomador, remetente ou do destinatario;III - a data de emissao ou " .
            "de saida." .
            "</xCondUso>"
 * 
 */


$text .= "<xCondUso>" . 
"A Carta de Correcao e disciplinada pelo " . 
"Art. 58-B do CONVENIO/SINIEF 06/89: Fica " .
"permitida a utilizacao de carta de correcao, " .
"para regularizacao de erro ocorrido na ".
"emissao de documentos fiscais relativos a " .
"prestacao de servico de transporte, desde " .
"que o erro nao esteja relacionado com: I - as " .
"variaveis que determinam o valor do imposto " .  
"tais como: base de calculo, aliquota, " . 
"diferenca de preco, quantidade, valor da " .
"prestacao;II - a correcao de dados " . 
"cadastrais que implique mudanca do " .
"emitente, tomador, remetente ou do " .
"destinatario;III - a data de emissao ou de " .
"saida." . "</xCondUso>";

$text .= '</evCCeCTe>';
$text .= '</detEvento>';
$text .= '</infEvento>';
$text .= '</eventoCTe>';

$file = fopen($name, 'w');
fwrite($file, $text);
fclose($file);

pg_close($conn);
exit();

