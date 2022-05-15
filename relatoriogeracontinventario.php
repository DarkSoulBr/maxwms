<?php

require('fpdfnew.php');
require_once("include/conexao.inc.php");
require_once("include/relatoriocontinventario.php");

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
        $this->Cell(45, 5, 'Relatório de Contagem para Inventário', 0, 1, 'C');
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
$estoqueimpresso = trim($_GET["estoqueimpresso"]);

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
        $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,g.grunome as grupo,i.invantigo as antigo, p.proref as referencia", "produto p left join grupo g on p.grucodigo=g.grucodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "p.grucodigo=" . $grupox[$i] . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
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
                    $pdf->SetFont('Times', 'B', 8);
                    $pdf->Cell(12, 5, 'Código', 1, 0, 'C');
                    $pdf->Cell(89, 5, 'Produto', 1, 0);
                    $pdf->Cell(28, 5, 'Ref. Fornededor', 1, 0, 'C');

                    if ($estoqueimpresso == '1')
                        $pdf->Cell(20, 5, 'Estoque', 1, 0, 'C');

                    $pdf->Cell(20, 5, '1º. Contagem', 1, 0, 'C');
                    $pdf->Cell(20, 5, 'Conferência', 1, 1, 'C');
                }

                if ($array_produto->antigo == "")
                    $array_produto->antigo = "0";

                $pdf->Cell(12, 5, '' . $array_produto->codigo, 1, 0, 'C');
                $pdf->Cell(89, 5, '' . $array_produto->nome, 1, 0);
                $pdf->Cell(28, 5, '' . $array_produto->referencia, 1, 0, 'L');

                if ($estoqueimpresso == '1')
                    $pdf->Cell(20, 5, '' . $array_produto->antigo, 1, 0, 'R');

                $pdf->Cell(20, 5, ' ', 1, 0);
                $pdf->Cell(20, 5, ' ', 1, 1);
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
        $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,s.subnome as subgrupo,i.invantigo as antigo,p.proref as referencia", "produto p left join subgrupo s on p.subcodigo=s.subcodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "p.subcodigo=" . $subgrupox[$i] . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
        $row = pg_num_rows($query_produto);

        if ($row > 0) {
            for ($j = 0; $j < $row; $j++) {
                $array_produto = pg_fetch_object($query_produto);

                if ($j == 0) {
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Cell(24, 15, 'SubGrupo:', 0, 0);
                    $pdf->Cell(60, 15, '' . $subgrupox[$i] . ' - ' . $array_produto->subgrupo, 0, 1);
                    $pdf->SetFont('Times', 'B', 8);
                    $pdf->Cell(12, 5, 'Código', 1, 0, 'C');
                    $pdf->Cell(89, 5, 'Produto', 1, 0);
                    $pdf->Cell(28, 5, 'Ref. Fornededor', 1, 0, 'C');

                    if ($estoqueimpresso == '1')
                        $pdf->Cell(20, 5, 'Estoque', 1, 0, 'C');

                    $pdf->Cell(20, 5, '1º. Contagem', 1, 0, 'C');
                    $pdf->Cell(20, 5, 'Conferência', 1, 1, 'C');
                }

                if ($array_produto->antigo == "")
                    $array_produto->antigo = "0";

                $pdf->Cell(12, 5, '' . $array_produto->codigo, 1, 0, 'C');
                $pdf->Cell(89, 5, '' . $array_produto->nome, 1, 0);
                $pdf->Cell(28, 5, '' . $array_produto->referencia, 1, 0, 'L');

                if ($estoqueimpresso == '1')
                    $pdf->Cell(20, 5, '' . $array_produto->antigo, 1, 0, 'R');

                $pdf->Cell(20, 5, ' ', 1, 0);
                $pdf->Cell(20, 5, ' ', 1, 1);
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
    $query_produto = $cadastro->seleciona("p.procod as codigo, p.prnome as nome,f.fornguerra as fornecedor,i.invantigo as antigo,p.proref as referencia", "produto p left join fornecedor f on p.forcodigo=f.forcodigo left join inventario i on p.procodigo=i.procodigo and i.estcodigo=$estoque", "f.forcod=" . $fornecedor . " and p.procodigo=i.procodigo and i.invdata='$invdata'");
    $row = pg_num_rows($query_produto);

    if ($row > 0) {
        for ($j = 0; $j < $row; $j++) {
            $array_produto = pg_fetch_object($query_produto);

            if ($j == 0) {
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(29, 15, 'Fornecedor:', 0, 0);
                $pdf->Cell(60, 15, '' . $fornecedor . ' - ' . $array_produto->fornecedor, 0, 1);
                $pdf->SetFont('Times', 'B', 8);
                $pdf->Cell(12, 5, 'Código', 1, 0, 'C');
                $pdf->Cell(89, 5, 'Produto', 1, 0);
                $pdf->Cell(28, 5, 'Ref. Fornededor', 1, 0, 'C');

                if ($estoqueimpresso == '1')
                    $pdf->Cell(20, 5, 'Estoque', 1, 0, 'C');

                $pdf->Cell(20, 5, '1º. Contagem', 1, 0, 'C');
                $pdf->Cell(20, 5, 'Conferência', 1, 1, 'C');
            }

            if ($array_produto->antigo == "")
                $array_produto->antigo = "0";

            $pdf->Cell(12, 5, '' . $array_produto->codigo, 1, 0, 'C');
            $pdf->Cell(89, 5, '' . $array_produto->nome, 1, 0);
            $pdf->Cell(28, 5, '' . $array_produto->referencia, 1, 0, 'L');

            if ($estoqueimpresso == '1')
                $pdf->Cell(20, 5, '' . $array_produto->antigo, 1, 0, 'R');

            $pdf->Cell(20, 5, ' ', 1, 0);
            $pdf->Cell(20, 5, ' ', 1, 1);
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
