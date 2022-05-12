<?php

require('fpdfnew.php');
require_once("include/conexao.inc.php");
require_once("include/relpedsepara.php");


$pvnumero = trim($_GET["pvnumero"]);
$sql1 = "Update pvenda set pvimpresso = 1 Where pvnumero = '$pvnumero'";
pg_query($sql1);

$pvvia = 0;
$sql1 = "Select pvvia from pvenda Where pvnumero = '$pvnumero'";
$cad = pg_query($sql1);
if ($cad) {
    $pvvia = pg_fetch_result($cad, 0, "pvvia");
}
$pvvia++;


$sql1 = "Update pvenda set pvvia = $pvvia Where pvnumero = '$pvnumero'";
pg_query($sql1);

class PDF extends FPDF {

//Page header
    function Header() {
        //Logo
        //$this->Image('logo_pb.png',10,8,33);

        $radioimp = trim($_GET["radioimp"]);

        if ($radioimp == 0) {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(1, 5, 'NOME DA EMPRESA', 0, 0);
        } else {
            $this->Image('barao.jpg', 10, 8, 50);
        }

        $pedido = trim($_GET["pvnumero"]);

        //Arial bold 15
        $this->SetFont('Arial', 'B', 9);

        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        $hor = date('H');
        $min = date('i');

        $this->Cell(70, 5, '', 0, 0);
        $this->Cell(30, 5, 'PEDIDO DE VENDA (DEPÓSITO)', 0, 0);
        $this->Cell(94, 5, $dia . '/' . $mes . '/' . $ano . ' ' . $hor . ':' . $min . ' ' . trim('Pagina ' . $this->PageNo() . '/{nb}'), 0, 1, 'R');

        $Var1 = $this->PageNo();
        if ($Var1 > 1) {
            $this->Cell(1, 5, 'Pedido: ' . $pedido, 0, 0);
        }

        $this->Cell(30, 5, '', 0, 1, 'C');


        //Line break
        $this->Ln(0);
        //$this->Ln(20);
    }

//Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-10);
        //Arial italic 8

        /*
          $this->SetFont('Arial','',8);

          $this->Cell(63,5,'VENDEDOR : ',1,0);
          $this->Cell(64,5,'CLIENTE : ',1,0);
          $this->Cell(63,5,'NF No. : ',1,1);
         */

        $this->SetFont('Arial', 'I', 8);

        //Page number
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

//Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 8);


//Logo
//$pdf->Image('logo_pb.png',10,8,33);

$pedido = trim($_GET["pvnumero"]);

$pegar = "SELECT a.pvtipoped,a.pvemissao,a.clicodigo,a.pvcondcon,a.pvobserva,a.tracodigo,a.pvorigem,a.pvdestino,a.pvlocal,
	      	  b.clicod,b.clirazao,b.climodo,b.clipessoa,b.clicnpj,b.cliie,b.clirg,b.clicpf,c.vennguerra
	      	  ,d.descricao,a.pvvinculo, e.cleemail  
              FROM pvenda a
	      	  LEFT JOIN clientes as b on a.clicodigo = b.clicodigo
       	      LEFT JOIN vendedor as c on a.vencodigo = c.vencodigo
       	      LEFT JOIN cliefat as e on a.clicodigo = e.clicodigo
       	      LEFT JOIN palm as d on a.palmcodigo = d.palmcodigo
              WHERE a.pvnumero = '$pedido'";

$cad = pg_query($pegar);
$row = pg_num_rows($cad);

$pvtipo = '';
$pvdata = '';
$pvtipoped = '';
$pvcli = '';
$pvmodo = '';
$climodo = '';
$clicodigo = '';
$clipessoa = '';
$clicnpj = '';
$cliie = '';
$clicpf = '';
$clirg = '';
$pvvend = '';
$pvcond = '';
$pvobs = '';
$pvtra = '';
$pvori = '';
$pvdes = '';
$pvlocal = '';
$palm = '';
$pvvinculo = '';

$cubtot = 0;

if ($row) {
    $pvtipo = pg_fetch_result($cad, 0, "pvtipoped");
    $pvdata = pg_fetch_result($cad, 0, "pvemissao");
    $pvcli = trim(pg_fetch_result($cad, 0, "clicod")) . ' - ' . trim(pg_fetch_result($cad, 0, "clirazao")) . ' - ' . trim(pg_fetch_result($cad, 0, "cleemail"));
    $pvmodo = pg_fetch_result($cad, 0, "climodo");
    $clicodigo = pg_fetch_result($cad, 0, "clicodigo");
    $clipessoa = pg_fetch_result($cad, 0, "clipessoa");
    $clicnpj = pg_fetch_result($cad, 0, "clicnpj");
    $cliie = pg_fetch_result($cad, 0, "cliie");
    $clicpf = pg_fetch_result($cad, 0, "clicpf");
    $clirg = pg_fetch_result($cad, 0, "clirg");
    $pvvend = pg_fetch_result($cad, 0, "vennguerra");
    $pvcond = pg_fetch_result($cad, 0, "pvcondcon");
    $pvobs = pg_fetch_result($cad, 0, "pvobserva");
    $pvtra = pg_fetch_result($cad, 0, "tracodigo");
    $pvori = pg_fetch_result($cad, 0, "pvorigem");
    $pvdes = pg_fetch_result($cad, 0, "pvdestino");
    $pvlocal = pg_fetch_result($cad, 0, "pvlocal");
    $pvvinculo = pg_fetch_result($cad, 0, "pvvinculo");

    $palm = pg_fetch_result($cad, 0, "descricao");

    if ($pvmodo == 2) {
        $climodo = '(FIDELIDADE)';
    } else {
        $climodo = '';
    }

    //Verifica o Tipo de Pedido
    $sql2 = "SELECT tipdescricao,tipsigla 
			FROM  tipoped 
			where tipsigla = '$pvtipo'";

    //EXECUTA A QUERY
    $sql2 = pg_query($sql2);

    $row2 = pg_num_rows($sql2);

    if ($row2) {
        $pvtipoped = trim(pg_fetch_result($sql2, 0, "tipdescricao"));
    } else {
        $pvtipoped = '';
    }

    /*
      if ($pvtipo=='N'){
      $pvtipoped ='INTERNO';}
      else if ($pvtipo=='E'){
      $pvtipoped='EXTERNO';}
      else if ($pvtipo=='I'){
      $pvtipoped='INDUSTRIA';}
      else if ($pvtipo=='M'){
      $pvtipoped='MOSTRUARIO';}
      else if ($pvtipo=='C'){
      $pvtipoped='CONSERTO';}
      else if ($pvtipo=='D'){
      $pvtipoped='DEVOLUCAO';}
      else if ($pvtipo=='B'){
      $pvtipoped='BRINDE';}
      else if ($pvtipo=='X'){
      $pvtipoped='BAIXA';}
      else if ($pvtipo=='R'){
      $pvtipoped='RESERVA';}
      else if ($pvtipo=='F'){
      $pvtipoped='BONIFICACAO';}
      else if ($pvtipo=='V'){
      $pvtipoped='VINTE CINCO';}
      else if ($pvtipo=='L'){
      $pvtipoped='LUME TOYS';}
      else if ($pvtipo=='U'){
      $pvtipoped='MULTIBOX';}
      else if ($pvtipo=='T'){
      $pvtipoped='TELEMARKET.';}
      else if ($pvtipo=='A'){
      $pvtipoped='DIRETORIA';}
      else if ($pvtipo=='Y'){
      $pvtipoped='INTERNET';}
      else if ($pvtipo=='Z'){
      $pvtipoped='ALMOXARIF.';}
      else if ($pvtipo=='S'){
      $pvtipoped='ABASTECIMENTO';}
      else if ($pvtipo=='K'){
      $pvtipoped='VL FUNCIONARIO';}
     */
}

$cliender = '';
$clicid = '';
$cliest = '';
$clicep = '';
$clifone = '';

if ($clicodigo != 0) {

    $pegar2 = "SELECT a.cleendereco,a.clecep,a.clefone,b.descricao,b.uf FROM cliefat a	 
		  LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo		     
          Where a.clicodigo = '$clicodigo'";

    $cad2 = pg_query($pegar2);
    $row2 = pg_num_rows($cad2);

    if ($row2) {
        $cliender = trim(pg_fetch_result($cad2, 0, "cleendereco"));
        $clicid = trim(pg_fetch_result($cad2, 0, "descricao"));
        $cliest = trim(pg_fetch_result($cad2, 0, "uf"));
        $clicep = (pg_fetch_result($cad2, 0, "clecep"));
        $clifone = trim(pg_fetch_result($cad2, 0, "clefone"));
    }
}

$traender = '';
$tracid = '';
$traest = '';
$tracep = '';
$tranome = '';

if ($pvtra != 0) {

    $pegar3 = "SELECT a.traendereco,a.tracep,a.tranguerra,b.descricao,b.uf FROM transportador a	 
		  LEFT JOIN cidades as b on a.cidcodigo = b.cidcodigo		     
          Where a.tracodigo = '$pvtra'";

    $cad3 = pg_query($pegar3);
    $row3 = pg_num_rows($cad3);

    if ($row3) {
        $traender = trim(pg_fetch_result($cad3, 0, "traendereco"));
        $tracid = trim(pg_fetch_result($cad3, 0, "descricao"));
        $traest = trim(pg_fetch_result($cad3, 0, "uf"));
        $tracep = (pg_fetch_result($cad3, 0, "tracep"));
        $tranome = trim(pg_fetch_result($cad3, 0, "tranguerra"));
    }
}


//Arial bold 15
$pdf->SetFont('Arial', 'B', 9);

$dia = date('d');
$mes = date('m');
$ano = date('Y');
$hor = date('H');
$min = date('i');

$pdf->Cell(194, 5, 'RUA DA EMPRESA, 1358 - FONE: 0000-0000  FAX: 0000-0001', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(30, 5, '', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 5, 'PEDIDO: ' . $pvtipoped . ' - ' . $pedido, 0, 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(112, 5, 'LOCAL DA VENDA: NOME DA LOJA', 0, 0, 'C');
$pdf->Cell(38, 5, 'DATA VENDA : ' . substr($pvdata, 8, 2) . '/' . substr($pvdata, 5, 2) . '/' . substr($pvdata, 0, 4), 0, 1, 'R');

if ($pvtipo == 'S') {

    $pegar4 = "SELECT a.etqnome FROM estoque a Where a.etqcodigo = '$pvori'";

    $cad4 = pg_query($pegar4);
    $row4 = pg_num_rows($cad4);

    $pvorigem = "";
    if ($row4) {
        $pvorigem = trim(pg_fetch_result($cad4, 0, "etqnome"));
    }

    $pdf->Cell(120, 5, 'ORIGEM : ' . $pvori . ' - ' . $pvorigem, 0, 1);

    $pegar5 = "SELECT a.etqnome FROM estoque a Where a.etqcodigo = '$pvdes'";

    $cad5 = pg_query($pegar5);
    $row5 = pg_num_rows($cad5);

    $pvdestino = "";
    if ($row5) {
        $pvdestino = trim(pg_fetch_result($cad5, 0, "etqnome"));
    }
    $pdf->Cell(120, 5, 'DESTINO : ' . $pvdes . ' - ' . $pvdestino, 0, 1);
    $pdf->Cell(30, 5, '', 0, 1, 'C');
} else {

    if ($pvvinculo <> 0) {
        $pdf->Cell(152, 5, 'CLIENTE : ' . $pvcli . ' ' . $climodo, 0, 0);
        $pdf->Cell(38, 5, 'PEDIDO MÃE : ' . $pvvinculo, 0, 1, 'R');
    } else {
        $pdf->Cell(120, 5, 'CLIENTE : ' . $pvcli . ' ' . $climodo, 0, 1);
    }

    $pdf->Cell(112, 5, 'ENDERECO : ' . $cliender, 0, 0);
    $pdf->Cell(40, 5, 'CIDADE : ' . $clicid . '-' . $cliest, 0, 0);
    $pdf->Cell(38, 5, 'CEP : ' . substr($clicep, 0, 5) . '-' . substr($clicep, 5, 3), 0, 1, 'R');

    if ($clipessoa == '2') {
        $pdf->Cell(112, 5, 'CPF : ' . substr($clicpf, 0, 3) . '.' . substr($clicpf, 3, 3) . '.' . substr($clicpf, 6, 3) . '-' . substr($clicpf, 9, 2), 0, 0);
        $pdf->Cell(40, 5, 'RG : ' . $clirg, 0, 0);
    } else {
        $pdf->Cell(112, 5, 'CNPJ : ' . substr($clicnpj, 0, 2) . '.' . substr($clicnpj, 2, 3) . '.' . substr($clicnpj, 5, 3) . '/' . substr($clicnpj, 8, 4) . '-' . substr($clicnpj, 12, 2), 0, 0);
        $pdf->Cell(40, 5, 'I.E. : ' . $cliie, 0, 0);
    }
    $pdf->Cell(38, 5, 'FONE : ' . $clifone, 0, 1, 'R');
}

$pdf->Cell(112, 5, 'VENDEDOR : ' . $pvvend, 0, 1);
$pdf->Cell(112, 5, 'CONDIÇÕES COMERCIAIS : ' . $pvcond, 0, 1);
$pdf->Cell(112, 5, 'LOCAL DE ENTREGA : ' . $pvlocal, 0, 1);
$pdf->Cell(112, 5, 'OBSERVAÇÕES : ' . $pvobs, 0, 1);
$pdf->Cell(120, 5, 'TRANSPORTADORA : ' . $tranome, 0, 1);
$pdf->Cell(120, 5, 'ENDERECO : ' . $traender . ' ' . $tracid . ' ' . $traest . ' CEP ' . substr($tracep, 0, 5) . '-' . substr($tracep, 5, 3), 0, 0);

if ($palm != '') {
    $pdf->Cell(70, 5, 'PALM : ' . $palm, 0, 1, 'R');
} else {
    $pdf->Cell(70, 5, '', 0, 1, 'R');
}

$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(10, 5, 'COD.', 1, 0);
$pdf->Cell(68, 5, 'PRODUTO', 1, 0);
$pdf->Cell(18, 5, 'REF.FORN.', 1, 0);
$pdf->Cell(26, 5, 'FORNECEDOR', 1, 0);
$pdf->Cell(10, 5, 'QTD.', 1, 0, 'C');
$pdf->Cell(10, 5, 'UN.', 1, 0, 'C');
$pdf->Cell(18, 5, 'LOCAL', 1, 0);
$pdf->Cell(10, 5, 'EMB.', 1, 0);
$pdf->Cell(10, 5, 'RET.', 1, 0);
$pdf->Cell(10, 5, 'CUB.', 1, 1);

//Line break
$pdf->Ln(0);
//$pdf->Ln(20);

$pedido = trim($_GET["pvnumero"]);

//Volumes da Filial
$pegar = "SELECT a.pviest01,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2 FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 1
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  and a.pviest01 > 0	  	  
		  ORDER BY b.procod ";


$cad = pg_query($pegar);

$row = pg_num_rows($cad);

for ($i = 0; $i < $row; $i++) {

    if ($i == 0) {
        $pdf->SetFont('Times', 'B', 8);

        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(68, 5, 'LOJA FILIAL', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(26, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 1, 'R');
        $pdf->SetFont('Times', 'B', 8);
    }

    $campo1 = pg_fetch_result($cad, $i, "pviest01");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");
    $premb = pg_fetch_result($cad, $i, "proemb");

    //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
    $pdf->Cell(10, 5, '' . $procod, 1, 0);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(68, 5, '' . $prnome, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(18, 5, '' . $prref, 1, 0);
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(26, 5, '' . $prfor, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(10, 5, ' ' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $pruni, 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
}

if ($i > 0) {
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}

//Volumes da Matriz
$pegar = "SELECT a.pviest02,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2 FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 2
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  and a.pviest02 > 0	  	  
		  ORDER BY b.procod ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

for ($i = 0; $i < $row; $i++) {

    if ($i == 0) {
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(68, 5, 'LOJA MATRIZ', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(26, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 1, 'R');
        $pdf->SetFont('Times', 'B', 8);
    }

    $campo1 = pg_fetch_result($cad, $i, "pviest02");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");
    $premb = pg_fetch_result($cad, $i, "proemb");

    //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
    $pdf->Cell(10, 5, '' . $procod, 1, 0);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(68, 5, '' . $prnome, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(18, 5, '' . $prref, 1, 0);
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(26, 5, '' . $prfor, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $pruni, 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
}
if ($i > 0) {
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}

//Volumes de Vitória
$pegar = "SELECT a.pviest011,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2 FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 11
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  and a.pviest011 > 0	  	  
		  ORDER BY b.procod ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

for ($i = 0; $i < $row; $i++) {

    if ($i == 0) {
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(68, 5, 'VITÓRIA', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(26, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 1, 'R');
        $pdf->SetFont('Times', 'B', 8);
    }

    $campo1 = pg_fetch_result($cad, $i, "pviest011");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");
    $premb = pg_fetch_result($cad, $i, "proemb");

    //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
    $pdf->Cell(10, 5, '' . $procod, 1, 0);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(68, 5, '' . $prnome, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(18, 5, '' . $prref, 1, 0);
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(26, 5, '' . $prfor, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $pruni, 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
}
if ($i > 0) {
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}


//Pendentes
$pegar = "SELECT a.pviest05,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2 FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 2
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  and a.pviest05 > 0	  	  
		  ORDER BY b.procod ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

for ($i = 0; $i < $row; $i++) {

    if ($i == 0) {
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(68, 5, 'PENDENTES', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(26, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0);
        $pdf->Cell(18, 5, '', 1, 0);
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 0, 'R');
        $pdf->Cell(10, 5, '', 1, 1, 'R');
        $pdf->SetFont('Times', 'B', 8);
    }

    $campo1 = pg_fetch_result($cad, $i, "pviest05");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");
    $premb = pg_fetch_result($cad, $i, "proemb");

    //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
    $pdf->Cell(10, 5, '' . $procod, 1, 0);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(68, 5, '' . $prnome, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(18, 5, '' . $prref, 1, 0);
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(26, 5, '' . $prfor, 1, 0);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $pruni, 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '' . $campo1, 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
}
if ($i > 0) {
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}


$pegar = "SELECT a.pviest09,a.pviest026,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2
          ,b.proaltcx,b.prolarcx,b.procomcx,b.propescx,b.procubcx  
          FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 9
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  ORDER BY e.endlocal ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);
$pdf->SetFont('Times', 'B', 8);

//Looping para imprimir os Volumes
$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(68, 5, 'SEPARAÇÃO DE VOLUMES', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(26, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 1, 'R');

$pdf->SetFont('Times', 'B', 8);

for ($i = 0; $i < $row; $i++) {

    $campo1 = pg_fetch_result($cad, $i, "pviest09") + pg_fetch_result($cad, $i, "pviest026");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $premb = pg_fetch_result($cad, $i, "proemb");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");


    $proaltcx = pg_fetch_result($cad, $i, "proaltcx");
    $procubcx = pg_fetch_result($cad, $i, "procubcx");
    if ($procubcx == '') {
        $procubcx = 0;
    }
    $prolarcx = pg_fetch_result($cad, $i, "prolarcx");
    $procomcx = pg_fetch_result($cad, $i, "procomcx");
    $propescx = pg_fetch_result($cad, $i, "propescx");



    if ($premb > 0) {
        $resto = $campo1 % $premb;
        $prret = ($campo1 - $resto) / $premb;

        if ($procubcx == 0) {
            $cubcx = $prret * $proaltcx * $prolarcx * $procomcx;
        } else {
            $cubcx = $prret * $procubcx;
        }


        $cubtot = $cubtot + $cubcx;

        if ($prret > 0) {
            $pdf->Cell(10, 5, '' . $procod, 1, 0);
            $pdf->SetFont('Times', 'B', 6);
            $pdf->Cell(68, 5, '' . $prnome, 1, 0);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(18, 5, '' . $prref, 1, 0);
            $pdf->SetFont('Times', 'B', 5);
            $pdf->Cell(26, 5, '' . $prfor, 1, 0);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(10, 5, ' ' . $campo1, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . $pruni, 1, 0);
            $pdf->Cell(18, 5, '' . $prend1, 1, 0);
            $pdf->Cell(10, 5, '' . $premb, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . $prret, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . sprintf("%01.4f", Round($cubcx, 4)), 1, 1, 'R');
        }
    }
}

$pdf->SetFont('Times', 'B', 8);

$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(68, 5, '', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(26, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 1, 'R');
$pdf->SetFont('Times', 'B', 8);


//Looping para imprimir o Picking
$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(68, 5, 'SEPARAÇÃO DE PICKING', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(26, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0);
$pdf->Cell(18, 5, '', 1, 0);
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 0, 'R');
$pdf->Cell(10, 5, '', 1, 1, 'R');

$pdf->SetFont('Times', 'B', 8);

$pegar = "SELECT a.pviest09,a.pviest026,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2
          ,proaltura,prolargura,procompr,propeso
          FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 9
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo	  	  
		  ORDER BY e.endlocal2 ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);

for ($i = 0; $i < $row; $i++) {

    $campo1 = pg_fetch_result($cad, $i, "pviest09") + pg_fetch_result($cad, $i, "pviest026");
    $procod = pg_fetch_result($cad, $i, "procod");
    $prnome = pg_fetch_result($cad, $i, "prnome");
    $prref = pg_fetch_result($cad, $i, "proref");
    $prfor = pg_fetch_result($cad, $i, "fornguerra");
    $pruni = pg_fetch_result($cad, $i, "medsigla");
    $prend1 = pg_fetch_result($cad, $i, "endlocal");
    $prend2 = pg_fetch_result($cad, $i, "endlocal2");
    $premb = pg_fetch_result($cad, $i, "proemb");

    $proaltura = pg_fetch_result($cad, $i, "proaltura");
    $prolargura = pg_fetch_result($cad, $i, "prolargura");
    $procompr = pg_fetch_result($cad, $i, "procompr");
    $propeso = pg_fetch_result($cad, $i, "propeso");

    if ($premb > 0) {
        $resto = $campo1 % $premb;
        $prret = ($campo1 - $resto) / $premb;
        $prret2 = $campo1 - ($prret * $premb);
    } else {
        $prret = 0;
        $prret2 = $campo1;
    }

    $cub = $prret2 * $proaltura * $prolargura * $procompr;
    $cub2 = $cub * 1.2;

    $cubtot = $cubtot + $cub2;

    if ($prret2 > 0) {
        //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
        $pdf->Cell(10, 5, '' . $procod, 1, 0);
        $pdf->SetFont('Times', 'B', 6);
        $pdf->Cell(68, 5, '' . $prnome, 1, 0);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(18, 5, '' . $prref, 1, 0);
        $pdf->SetFont('Times', 'B', 5);
        $pdf->Cell(26, 5, '' . $prfor, 1, 0);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(10, 5, ' ' . $campo1, 1, 0, 'R');
        $pdf->Cell(10, 5, '' . $pruni, 1, 0);
        $pdf->Cell(18, 5, '' . $prend2, 1, 0);
        $pdf->Cell(10, 5, '' . $premb, 1, 0, 'R');
        $pdf->Cell(10, 5, '' . $prret2, 1, 0, 'R');
        $pdf->Cell(10, 5, '' . sprintf("%01.4f", Round($cub2, 4)), 1, 1, 'R');
    }
}





if ($i > 0) {
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}



$pegar = "SELECT a.pviest013,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2
		  ,b.proaltcx,b.prolarcx,b.procomcx,b.propescx,b.procubcx  
          FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 13
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo
		  ORDER BY e.endlocal ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);
$pdf->SetFont('Times', 'B', 8);

//Looping para imprimir os Volumes

$ver = 0;
for ($i = 0; $i < $row; $i++) {
    $campo1 = pg_fetch_result($cad, $i, "pviest013");
    if ($campo1 > 0) {
        $ver = 1;
    }
}

if ($ver > 0) {

    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, 'SEPARAÇÃO DE VOLUMES - DAI', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');

    $pdf->SetFont('Times', 'B', 8);


    for ($i = 0; $i < $row; $i++) {

        $campo1 = pg_fetch_result($cad, $i, "pviest013");
        $procod = pg_fetch_result($cad, $i, "procod");
        $prnome = pg_fetch_result($cad, $i, "prnome");
        $prref = pg_fetch_result($cad, $i, "proref");
        $premb = pg_fetch_result($cad, $i, "proemb");
        $prfor = pg_fetch_result($cad, $i, "fornguerra");
        $pruni = pg_fetch_result($cad, $i, "medsigla");
        $prend1 = pg_fetch_result($cad, $i, "endlocal");
        $prend2 = pg_fetch_result($cad, $i, "endlocal2");


        $proaltcx = pg_fetch_result($cad, $i, "proaltcx");
        $procubcx = pg_fetch_result($cad, $i, "procubcx");
        if ($procubcx == '') {
            $procubcx = 0;
        }
        $prolarcx = pg_fetch_result($cad, $i, "prolarcx");
        $procomcx = pg_fetch_result($cad, $i, "procomcx");
        $propescx = pg_fetch_result($cad, $i, "propescx");



        if ($premb > 0) {
            $resto = $campo1 % $premb;
            $prret = ($campo1 - $resto) / $premb;


            if ($procubcx == 0) {
                $cubcx = $prret * $proaltcx * $prolarcx * $procomcx;
            } else {
                $cubcx = $prret * $procubcx;
            }

            $cubtot = $cubtot + $cubcx;

            if ($prret > 0) {
                $pdf->Cell(10, 5, '' . $procod, 1, 0);
                $pdf->SetFont('Times', 'B', 6);
                $pdf->Cell(68, 5, '' . $prnome, 1, 0);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(18, 5, '' . $prref, 1, 0);
                $pdf->SetFont('Times', 'B', 5);
                $pdf->Cell(26, 5, '' . $prfor, 1, 0);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(10, 5, ' ' . $campo1, 1, 0, 'R');
                $pdf->Cell(10, 5, '' . $pruni, 1, 0);
                $pdf->Cell(18, 5, '' . $prend1, 1, 0);
                $pdf->Cell(10, 5, '' . $premb, 1, 0, 'R');
                $pdf->Cell(10, 5, '' . $prret, 1, 0, 'R');
                $pdf->Cell(10, 5, '' . sprintf("%01.4f", Round($cubcx, 4)), 1, 1, 'R');
            }
        }
    }

    $pdf->SetFont('Times', 'B', 8);

    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');
    $pdf->SetFont('Times', 'B', 8);
}



//Looping para imprimir o Picking
$pegar = "SELECT a.pviest013,b.procod,b.prnome,b.proemb,b.proref,c.fornguerra,d.medsigla,e.endlocal,e.endlocal2
          ,proaltura,prolargura,procompr,propeso
          FROM pvitem a,fornecedor c,medidas d,produto b
          LEFT JOIN endereco as e on b.procodigo = e.procodigo and e.etqcodigo = 13
          Where a.pvnumero = '$pedido'
		  And a.procodigo=b.procodigo
		  and b.forcodigo = c.forcodigo
		  and b.medcodigo = d.medcodigo	  	  
		  ORDER BY e.endlocal2 ";

$cad = pg_query($pegar);

$row = pg_num_rows($cad);


$ver = 0;
for ($i = 0; $i < $row; $i++) {
    $campo1 = pg_fetch_result($cad, $i, "pviest013");
    if ($campo1 > 0) {
        $ver = 1;
    }
}

if ($ver > 0) {


    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(68, 5, 'SEPARAÇÃO DE PICKING - DAI', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(26, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0);
    $pdf->Cell(18, 5, '', 1, 0);
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 0, 'R');
    $pdf->Cell(10, 5, '', 1, 1, 'R');

    $pdf->SetFont('Times', 'B', 8);


    for ($i = 0; $i < $row; $i++) {

        $campo1 = pg_fetch_result($cad, $i, "pviest013");
        $procod = pg_fetch_result($cad, $i, "procod");
        $prnome = pg_fetch_result($cad, $i, "prnome");
        $prref = pg_fetch_result($cad, $i, "proref");
        $prfor = pg_fetch_result($cad, $i, "fornguerra");
        $pruni = pg_fetch_result($cad, $i, "medsigla");
        $prend1 = pg_fetch_result($cad, $i, "endlocal");
        $prend2 = pg_fetch_result($cad, $i, "endlocal2");
        $premb = pg_fetch_result($cad, $i, "proemb");

        $proaltura = pg_fetch_result($cad, $i, "proaltura");
        $prolargura = pg_fetch_result($cad, $i, "prolargura");
        $procompr = pg_fetch_result($cad, $i, "procompr");
        $propeso = pg_fetch_result($cad, $i, "propeso");

        if ($premb > 0) {
            $resto = $campo1 % $premb;
            $prret = ($campo1 - $resto) / $premb;
            $prret2 = $campo1 - ($prret * $premb);
        } else {
            $prret = 0;
            $prret2 = $campo1;
        }

        $cub = $prret2 * $proaltura * $prolargura * $procompr;
        $cub2 = $cub * 1.2;

        $cubtot = $cubtot + $cub2;

        if ($prret2 > 0) {
            //$pdf->Cell(0,10,'Printing line number teste '.$i,0,1);
            $pdf->Cell(10, 5, '' . $procod, 1, 0);
            $pdf->SetFont('Times', 'B', 6);
            $pdf->Cell(68, 5, '' . $prnome, 1, 0);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(18, 5, '' . $prref, 1, 0);
            $pdf->SetFont('Times', 'B', 5);
            $pdf->Cell(26, 5, '' . $prfor, 1, 0);
            $pdf->SetFont('Times', 'B', 8);
            $pdf->Cell(10, 5, ' ' . $campo1, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . $pruni, 1, 0);
            $pdf->Cell(18, 5, '' . $prend2, 1, 0);
            $pdf->Cell(10, 5, '' . $premb, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . $prret2, 1, 0, 'R');
            $pdf->Cell(10, 5, '' . sprintf("%01.4f", Round($cub2, 4)), 1, 1, 'R');
        }
    }
}






$pdf->Cell(190, 5, 'TOTAL DA CUBAGEM: ' . sprintf("%01.4f", Round($cubtot, 4)), 1, 1, 'R');

//$pdf->Cell(30,5,'',0,1,'C');
$pdf->Cell(30, 5, '', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(63, 5, 'VENDEDOR : ', 1, 0);
$pdf->Cell(64, 5, 'CLIENTE : ', 1, 0);
$pdf->Cell(63, 5, 'NF No. : ', 1, 1);

$pegar = "SELECT a.pvnewobs FROM pvenda a Where a.pvnumero = '$pedido'";

$cad = pg_query($pegar);
$row = pg_num_rows($cad);

$pvobsnew = '';
if ($row) {
    $pvnewobs = pg_fetch_result($cad, 0, "pvnewobs");
}

$pdf->Cell(30, 5, '', 0, 1, 'C');

$pdf->Cell(28, 5, 'OBSERVAÇÕES:', 0, 0);
$pdf->Cell(80, 5, substr($pvnewobs, 0, 69), 0, 1);

if (!trim(substr($pvnewobs, 69, 69)) == '') {
    $pdf->Cell(28, 5, '', 0, 0);
    $pdf->Cell(80, 5, substr($pvnewobs, 69, 69), 0, 1);
}
if (!trim(substr($pvnewobs, 138, 69)) == '') {
    $pdf->Cell(28, 5, '', 0, 0);
    $pdf->Cell(80, 5, substr($pvnewobs, 138, 69), 0, 1);
}
if (!trim(substr($pvnewobs, 207, 69)) == '') {
    $pdf->Cell(28, 5, '', 0, 0);
    $pdf->Cell(80, 5, substr($pvnewobs, 207, 69), 0, 1);
}
if (!trim(substr($pvnewobs, 276, 69)) == '') {
    $pdf->Cell(28, 5, '', 0, 0);
    $pdf->Cell(80, 5, substr($pvnewobs, 276, 69), 0, 1);
}

$pdf->Output();
?>

