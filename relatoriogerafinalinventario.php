<?php

require('fpdfnew.php');
require_once("include/conexao.inc.php");
require_once("include/relatoriofinalinventario.php");

class PDF extends FPDF {

    public $datainv;
    public $estoque;

    //Page header
    function Header() {
        //Logo
        //$this->Image('logo_pb.png',10,8,33);
        $this->Image('barao.jpg', 10, 8, 50);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        //Move to the right
        $this->Cell(80);
        //Title
        $this->Cell(45, 5, 'Relatório de Resultado de Inventário', 0, 1, 'C');
        $this->Cell(55, 5, '', 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 10, 'Data de Inventário: ' . $this->datainv . ' | Estoque: ' . $this->estoque, 0, 1, 'L');

        //Line break
        $this->Ln(0);
        //$this->Ln(20);
    }

    //Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Page number
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

$cadastro = new banco($conn, $db);

$grupo = trim($_GET["grupo"]);
$subgrupo = trim($_GET["subgrupo"]);
$fornecedor = trim($_GET["nome"]);
$invdata = trim($_GET["invdata"]);
$estoque = trim($_GET["estoque"]);
$custo = trim($_GET["custo"]);

$query = $cadastro->seleciona("etqnome", "estoque", "etqcodigo=$estoque");
$array = pg_fetch_object($query);

//Instanciation of inherited class
$pdf = new PDF();
$pdf->datainv = $invdata;
$pdf->estoque = $array->etqnome;
$pdf->AliasNbPages();
$pdf->AddPage();

$aux = "";
$sobra = "";
$resultado = "";
$resultadogru = "";
$resultadosub = "";
$resultadoforn = "";

$aux = explode("/", $invdata);
$invdata = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' 00:00:00-03';

$auxgrupo = substr_count($grupo, ';');
$auxcg = explode(";", $grupo);

for ($i = 0; $i < $auxgrupo; $i++)
    $grupox[$i] = $auxcg[$i];

$auxsgrupo = substr_count($subgrupo, ';');
$auxcsg = explode(";", $subgrupo);
for ($i = 0; $i < $auxsgrupo; $i++)
    $subgrupox[$i] = $auxcsg[$i];

if(isset($grupox)) {
    $contagrupo = count($grupox);
} else {
    $contagrupo = 0;
}

if(isset($subgrupox)) {
    $contasubgrupo = count($subgrupox);
} else {
    $contasubgrupo = 0;
}

if ($contagrupo > 0) {
    for ($i = 0; $i < $contagrupo; $i++) {
        $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,g.grunome as grupo,i.invantigo as antigo,i.invatual as atual, p.proref as referencia, p.proemb as embalagem, p.proreal as custor, p.profinal as custof", "produto p left join grupo g on p.grucodigo=g.grucodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "p.grucodigo=" . $grupox[$i] . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
        $row = pg_num_rows($query_produto);

        if ($row > 0) {
            for ($j = 0; $j < $row; $j++) {
                $total = 0;
                $aux = 0;

                $array_produto = pg_fetch_object($query_produto);

                if ($j == 0) {
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(17, 15, 'Grupo: ', 0, 0);
                    $pdf->Cell(60, 15, $grupox[$i] . ' - ' . $array_produto->grupo, 0, 1);
                    $pdf->SetFont('Times', 'B', 7);
                    $pdf->Cell(11, 5, 'Código', 1, 0, 'C');
                    $pdf->Cell(85, 5, 'Produto', 1, 0);
                    $pdf->Cell(23, 5, 'Ref. Fornededor', 1, 0, 'C');
                    $pdf->Cell(15, 5, 'Embalagem', 1, 0, 'C');
                    $pdf->Cell(12, 5, 'Digitado', 1, 0, 'C');

                    if ($custo == '1')
                        $pdf->Cell(17, 5, 'Custo Real', 1, 0, 'C');
                    else
                        $pdf->Cell(17, 5, 'Custo Final', 1, 0, 'C');

                    $pdf->Cell(17, 5, 'Total', 1, 1, 'C');
                }

                if ($array_produto->antigo == "")
                    $array_produto->antigo = "0";
                if ($array_produto->atual == "")
                    $array_produto->atual = "0";

                if ($custo == '1') {
                    $total = $array_produto->custor * $array_produto->atual;
                } else {
                    $total = $array_produto->custof * $array_produto->atual;
                }


                $pdf->Cell(11, 5, '' . $array_produto->codigo, 1, 0, 'C');
                $pdf->Cell(85, 5, '' . $array_produto->nome, 1, 0);
                $pdf->Cell(23, 5, '' . $array_produto->referencia, 1, 0, 'L');
                $pdf->Cell(15, 5, '' . $array_produto->embalagem, 1, 0, 'C');
                $pdf->Cell(12, 5, '' . $array_produto->atual, 1, 0, 'R');

                if ($custo == '1')
                    $pdf->Cell(17, 5, '' . number_format($array_produto->custor, 2, ',', ''), 1, 0, 'R');
                else
                    $pdf->Cell(17, 5, '' . number_format($array_produto->custof, 2, ',', ''), 1, 0, 'R');

                $pdf->Cell(17, 5, '' . number_format($total, 2, ',', ''), 1, 1, 'R');
            }
            $pdf->Cell(51, 10, ' ', 0, 1, 'C');
        }
        else {
            $query = $cadastro->seleciona("grunome as nome", "grupo", "grucodigo=" . $grupox[$i]);
            $array = pg_fetch_object($query);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(17, 5, 'Grupo: ', 0, 0);
            $pdf->Cell(60, 5, $grupox[$i] . ' - ' . $array->nome, 0, 1);
            $pdf->Cell(140, 15, 'Nenhum registro encontrado!', 0, 1, 'C');
            $pdf->Cell(51, 10, ' ', 0, 1, 'C');
        }
    }
} else
if ($contasubgrupo > 0) {
    for ($i = 0; $i < $contasubgrupo; $i++) {
        $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,s.subnome as subgrupo,i.invantigo as antigo,i.invatual as atual, p.proref as referencia, p.proemb as embalagem, p.proreal as custor, p.profinal as custof", "produto p left join subgrupo s on p.subcodigo=s.subcodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "p.subcodigo=" . $subgrupox[$i] . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
        $row = pg_num_rows($query_produto);

        if ($row > 0) {
            for ($j = 0; $j < $row; $j++) {
                $array_produto = pg_fetch_object($query_produto);

                if ($j == 0) {
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(24, 15, 'SubGrupo:', 0, 0);
                    $pdf->Cell(60, 15, '' . $subgrupox[$i] . ' - ' . $array_produto->subgrupo, 0, 1);
                    $pdf->SetFont('Times', 'B', 7);
                    $pdf->Cell(11, 5, 'Código', 1, 0, 'C');
                    $pdf->Cell(85, 5, 'Produto', 1, 0);
                    $pdf->Cell(23, 5, 'Ref. Fornededor', 1, 0, 'C');
                    $pdf->Cell(15, 5, 'Embalagem', 1, 0, 'C');
                    $pdf->Cell(12, 5, 'Digitado', 1, 0, 'C');

                    if ($custo == '1')
                        $pdf->Cell(17, 5, 'Custo Real', 1, 0, 'C');
                    else
                        $pdf->Cell(17, 5, 'Custo Final', 1, 0, 'C');

                    $pdf->Cell(17, 5, 'Total', 1, 1, 'C');
                }

                if ($array_produto->antigo == "")
                    $array_produto->antigo = "0";
                if ($array_produto->atual == "")
                    $array_produto->atual = "0";

                if ($custo == '1') {
                    $total = $array_produto->custor * $array_produto->atual;
                } else {
                    $total = $array_produto->custof * $array_produto->atual;
                }

                $pdf->Cell(11, 5, '' . $array_produto->codigo, 1, 0, 'C');
                $pdf->Cell(85, 5, '' . $array_produto->nome, 1, 0);
                $pdf->Cell(23, 5, '' . $array_produto->referencia, 1, 0, 'L');
                $pdf->Cell(15, 5, '' . $array_produto->embalagem, 1, 0, 'C');
                $pdf->Cell(12, 5, '' . $array_produto->atual, 1, 0, 'R');

                if ($custo == '1')
                    $pdf->Cell(17, 5, '' . number_format($array_produto->custor, 2, ',', ''), 1, 0, 'R');
                else
                    $pdf->Cell(17, 5, '' . number_format($array_produto->custof, 2, ',', ''), 1, 0, 'R');

                $pdf->Cell(17, 5, '' . number_format($total, 2, ',', ''), 1, 1, 'R');
            }
            $pdf->Cell(51, 10, ' ', 0, 1, 'C');
        }
        else {
            $query = $cadastro->seleciona("subnome as subgrupo", "subgrupo", "subcodigo=" . $subgrupox[$i]);
            $array = pg_fetch_object($query);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(24, 5, 'SubGrupo: ', 0, 0);
            $pdf->Cell(60, 5, $subgrupox[$i] . ' - ' . $array->subgrupo, 0, 1);
            $pdf->Cell(140, 15, 'Nenhum registro encontrado!', 0, 1, 'C');
            $pdf->Cell(51, 10, ' ', 0, 1, 'C');
        }
    }
} else
if ($fornecedor != "") {
    $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,f.fornguerra as fornecedor,i.invantigo as antigo,i.invatual as atual, p.proref as referencia, p.proemb as embalagem, p.proreal as custor, p.profinal as custof", "produto p left join fornecedor f on p.forcodigo=f.forcodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "f.forcod=" . $fornecedor . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
    $row = pg_num_rows($query_produto);

    if ($row > 0) {
        for ($j = 0; $j < $row; $j++) {
            $array_produto = pg_fetch_object($query_produto);

            if ($j == 0) {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(29, 15, 'Fornecedor:', 0, 0);
                $pdf->Cell(60, 15, '' . $fornecedor . ' - ' . $array_produto->fornecedor, 0, 1);
                $pdf->SetFont('Times', 'B', 7);
                $pdf->Cell(11, 5, 'Código', 1, 0, 'C');
                $pdf->Cell(85, 5, 'Produto', 1, 0);
                $pdf->Cell(23, 5, 'Ref. Fornededor', 1, 0, 'C');
                $pdf->Cell(15, 5, 'Embalagem', 1, 0, 'C');
                $pdf->Cell(12, 5, 'Digitado', 1, 0, 'C');

                if ($custo == '1')
                    $pdf->Cell(17, 5, 'Custo Real', 1, 0, 'C');
                else
                    $pdf->Cell(17, 5, 'Custo Final', 1, 0, 'C');

                $pdf->Cell(17, 5, 'Total', 1, 1, 'C');
            }

            if ($array_produto->antigo == "")
                $array_produto->antigo = "0";
            if ($array_produto->atual == "")
                $array_produto->atual = "0";

            if ($custo == '1') {
                $total = $array_produto->custor * $array_produto->atual;
            } else {
                $total = $array_produto->custof * $array_produto->atual;
            }

            $pdf->Cell(11, 5, '' . $array_produto->codigo, 1, 0, 'C');
            $pdf->Cell(85, 5, '' . $array_produto->nome, 1, 0);
            $pdf->Cell(23, 5, '' . $array_produto->referencia, 1, 0, 'L');
            $pdf->Cell(15, 5, '' . $array_produto->embalagem, 1, 0, 'C');
            $pdf->Cell(12, 5, '' . $array_produto->atual, 1, 0, 'R');

            if ($custo == '1')
                $pdf->Cell(17, 5, '' . number_format($array_produto->custor, 2, ',', ''), 1, 0, 'R');
            else
                $pdf->Cell(17, 5, '' . number_format($array_produto->custof, 2, ',', ''), 1, 0, 'R');


            $pdf->Cell(17, 5, '' . number_format($total, 2, ',', ''), 1, 1, 'R');
        }
        $pdf->Cell(51, 10, ' ', 0, 1, 'C');
    }
    else {
        $query = $cadastro->seleciona("fornguerra as fornome", "fornecedor", "forcod=" . $fornecedor);
        $array = pg_fetch_object($query);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 5, 'Fornecedor: ', 0, 0);
        $pdf->Cell(60, 5, '' . $fornecedor . ' - ' . $array->fornome, 0, 1);
        $pdf->Cell(140, 15, 'Nenhum registro encontrado!', 0, 1, 'C');
        $pdf->Cell(51, 10, ' ', 0, 1, 'C');
    }
}
$pdf->Output();
?>
