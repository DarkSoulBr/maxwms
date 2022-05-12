<?php

require_once ("include/conexao.inc.php");
require_once ("include/clientes.php");
require_once("include/funcoes/removeCaracterEspecial.php");

//RECEBE PARÂMETR O
Header("Content-type: application/xml; charset=iso-8859-1");
// forma de pesquisar
$parametro = trim($_REQUEST ["parametro"]);
$parametro2 = trim($_REQUEST ["parametro2"]);
$parametro3 = trim($_REQUEST ["parametro3"]);


function recuperaMascara($telefone) {

    if ($telefone == "") {
        $tel = "";
    } else {

        if (strlen($telefone) == 11) {
            $ddd = substr($telefone, 0, 2);
            $primeira = substr($telefone, 2, 5);
            $segunda = substr($telefone, 7, 8);
        } else {
            $ddd = substr($telefone, 0, 2);
            $primeira = substr($telefone, 2, 4);
            $segunda = substr($telefone, 6, 8);
        }
        $p = "(";
        $r = ") ";
        $t = "-";

        $tel = $p . "" . $ddd . "" . $r . "" . $primeira . "" . $t . "" . $segunda;

        return $tel;
    }
}

if ($parametro == "") {
    return;
}

if ($parametro2 == "") {
    return;
}

if (!($parametro > 0 && $parametro < 9999999999) && $parametro2 == 1) {
    return;
}

$tpcliente = trim($_REQUEST ["tpcliente"]);

$cadastro = new banco($conn, $db);

if ($parametro3 == "0") {
    $where = "LIKE '$parametro%'";
} else
if ($parametro3 == "1") {
    $where = "LIKE '%$parametro%'";
} else
if ($parametro3 == "2") {
    $where = "= '$parametro'";
}

if ($parametro2 == "1") {
    $sql = "
	SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn
        ,to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta,
        to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao
        ,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist
	
	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa 
	,a.cliregime 
	
	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo


	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

		WHERE a.clicod $where

	ORDER BY a.clicod";
} else
if ($parametro2 == "2") {
    $sql = "
		SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn, to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta, to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist
	
	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa 
	,a.cliregime 
	
	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo

	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

		WHERE a.clinguerra $where

		ORDER BY a.clinguerra";
} else
if ($parametro2 == "3") {
    $sql = "
		SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn, to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta, to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist

	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa  	
	,a.cliregime 

	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo
	
	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

                                        WHERE a.clirazao $where

		ORDER BY a.clirazao";
} else
if ($parametro2 == "4") {
    $sql = "
		SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn, to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta, to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist

	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa  	
	,a.cliregime 
	
	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo

	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

		WHERE a.clicnpj $where


		ORDER BY a.clicnpj";
} else
if ($parametro2 == "5") {
    $sql = "
		SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn, to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta, to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist

	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa  	
	,a.cliregime 
	
	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo

	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

                                    WHERE a.clicpf $where

		ORDER BY a.clicpf";
} else {
    $sql = "
	SELECT a.clicodigo,a.clinguerra,a.clicod,a.clidat,a.clirazao,a.clipais,a.clicnpj,
	a.cliie,a.clirg,a.clicpf,a.cliobs,a.clicomerc,a.clipessoa,a.catcodigo,a.stccodigo
	,a.clisintegra,a.clisintegrasn, to_char(a.clireceitadataultimaconsulta, 'DD/MM/YYYY') as receitadataconsulta, to_char(a.clisintegradataultimaconsulta, 'DD/MM/YYYY') as sintegradataconsulta
        ,clireceitarazao,clisintegrarazao
        ,clireceitaidprocessamento
        ,clisintegraidprocessamento

	,b.clecep,b.cleendereco,b.clebairro,b.clefone,b.clefax,b.cleemail,b.clecodigo,b.clefone2,b.clefone3,b.clenumero,b.clecomplemento
	,c.clccep,c.clcendereco,c.clcbairro,c.clcfone,c.clcfax,c.clcemail,c.clccodigo,c.clcfone2,c.clcfone3,c.clcnumero,c.clccomplemento
	,d.ceecep,d.ceeendereco,d.ceebairro,d.ceefone,d.ceefax,d.ceeemail,d.ceecodigo,d.ceefone2,d.ceefone3,d.ceenumero,d.ceecomplemento

	,b.cidcodigo,e.descricao,e.uf
	,c.cidcodigo as cidcodigo2,f.descricao as descricao2,f.uf as uf2
	,d.cidcodigo as cidcodigo3,g.descricao as descricao3,g.uf as uf3

	,h.clcomcep,h.clcomendereco,h.clcombairro,h.clcomfone,h.clcomfax,h.clcomemail,h.clcomcodigo,h.clcomfone2,h.clcomfone3
	,h.clcomnsocio,h.clcomsexo,h.clcomip,h.clcomcpf, h.clcomnumero,h.clcomcomplemento
	,h.cidcodigo as cidcodigo4,i.descricao as descricao4,i.uf as uf4

	,a.clifpagto,a.clicanal

	,a.clilimite,a.climodo,a.clifat,a.clifin,a.vencodigo

	,a.cliserasa
	,a.cliinc
	,a.cliserasaexp
	,a.clisintegrainc
	,a.clisintegraalt
	,a.clisintegraexp
	,a.serasaatual
	,a.sintegraaatual
	,a.sintegrahabilitado
	,a.sintegrarestricoes
	,a.clitipo
	,a.clifundacao
	,a.clipercentual
	,a.cliprotesto
	,a.clivtot
	,a.cliperiodo
	,a.cliperiodo2
	,a.clirefin
	,a.clirefindata
	,a.clirefindata2
	,a.clioutrosqtde
	,a.clioutrosdata
	,a.clioutrosdata2
	,a.clibureau
	,a.clifcad
	,a.clicsocial
	,a.cliicom
	,a.clifcaddata
	,a.clicsocialdata
	,a.cliicomdata
	,a.clivtotref
	,a.clivtotoutros
	,a.altusuario
	,a.icfornecedor1
	,a.icfornecedor2
	,a.icfornecedor3
	,a.icfornecedor4
	,a.iccontato1
	,a.iccontato2
	,a.iccontato3
	,a.iccontato4
	,a.icfone1
	,a.icfone2
	,a.icfone3
	,a.icfone4
	,b.cidcodigoibge
 	,c.cidcodigoibge as cidcodigoibgecob
	,d.cidcodigoibge as cidcodigoibgecee
	,a.potencialdecompra
	,a.limiteproposto
                   ,to_char(a.clidatavalida, 'DD/MM/YYYY') as clidatavalida
                   ,us.usunome as usuvalida

  	,cr.numero as receita_numero
  	,cr.complemento as receita_complemento
  	,cr.cep as receita_cep
  	,cr.bairro as receita_bairro
  	,cr.uf as receita_uf
  	,cr.logradouro as receita_logradouro
  	,cr.cidade as receita_cidade
  	,cs.numero as sintegra_numero
  	,cs.complemento as sintegra_complemento
  	,cs.cep as sintegra_cep
  	,cs.bairro as sintegra_bairro
  	,cs.uf as sintegra_uf
  	,cs.logradouro as sintegra_logradouro
  	,cs.cidade as sintegra_cidade
  	,a.portador
    ,b.cleemailxml
	,a.clist

	,a.clioptsimples
    ,a.dataconsimples 	
	,a.cliconsig
	
	,a.clisuframa  	
	,a.cliregime 
	
	,a.clioptinativo
	,to_char(a.datainativo, 'DD/MM/YYYY') as datainativo

	FROM  clientes a

	LEft Join  cliefat as b on b.clicodigo = a.clicodigo
	LEft Join  cliecob as c on c.clicodigo = a.clicodigo
	LEft Join  clieent as d on d.clicodigo = a.clicodigo

	LEft Join  cliecom as h on h.clicodigo = a.clicodigo

	Left Join cidades as e on b.cidcodigo = e.cidcodigo
	Left Join cidades as f on c.cidcodigo = f.cidcodigo
	Left Join cidades as g on d.cidcodigo = g.cidcodigo

	Left Join cidades as i on h.cidcodigo = i.cidcodigo
	LEft Join  clienteenderecoreceita as cr on a.clicodigo = cr.clicodigo
	LEft Join  clienteenderecosintegra as cs on a.clicodigo = cs.clicodigo

                    left join usuarios us on  a.cliusuariovalida = us.usucodigo

	WHERE e.descricao $where

	ORDER BY a.clicpf";
}

$sql = pg_query($sql);
$row = pg_num_rows($sql);

//VERIFICA SE VOLTOU ALGO
if ($row) {
    //XML
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $xml .= "<dados>\n";

    //PERCORRE ARRAY
    for ($i = 0; $i < $row; $i++) {
        $codigo = pg_fetch_result($sql, $i, "clicodigo");

        $sqlLog = "SELECT lg.clicodigo, lg.lgcdata, lg.lgclimite, lg.lgcnovo,
							us.usunome, us.usulogin
							FROM logcredito as lg
							INNER JOIN usuarios as us on us.usucodigo = lg.usucodigo
							WHERE cast(lgctipo as integer) = 3 AND clicodigo = $codigo
							ORDER BY lg.lgcdata DESC LIMIT 1";

        $sqlLog = pg_query($sqlLog);

        if (pg_num_rows($sqlLog)) {
            $usunome = pg_fetch_result($sqlLog, 0, "usunome");
            $usulogin = pg_fetch_result($sqlLog, 0, "usulogin");
            $lgcdata = pg_fetch_result($sqlLog, 0, "lgcdata");
            $lgclimite = pg_fetch_result($sqlLog, 0, "lgclimite");
            $lgcnovo = pg_fetch_result($sqlLog, 0, "lgcnovo");
        } else {
            $usunome = '';
            $usulogin = '';
            $lgcdata = '';
            $lgclimite = '';
            $lgcnovo = '';
        }

        $usunome = $usunome == "" ? 'User' : $usunome;
        $usulogin = $usulogin == "" ? 'not user' : $usulogin;
        $lgcdata = $lgcdata == "" ? '0000-00-00 00:00:00' : $lgcdata;
        $lgclimite = $lgclimite == "" ? '0' : $lgclimite;
        $lgcnovo = $lgcnovo == "" ? '0' : $lgcnovo;

        $descricao = pg_fetch_result($sql, $i, "clinguerra");
        $descricaob = pg_fetch_result($sql, $i, "clicod");
        $clidat = pg_fetch_result($sql, $i, "clidat");
        $descricaoc = pg_fetch_result($sql, $i, "clirazao");
        $descricaod = pg_fetch_result($sql, $i, "clipais");
        $descricaoe = pg_fetch_result($sql, $i, "clicnpj");
        $descricaof = pg_fetch_result($sql, $i, "cliie");
        $descricaog = pg_fetch_result($sql, $i, "clirg");
        $descricaoh = pg_fetch_result($sql, $i, "clicpf");
        $descricaoi = pg_fetch_result($sql, $i, "cliobs");
        $descricaoj = pg_fetch_result($sql, $i, "clicomerc");
        $descricaok = pg_fetch_result($sql, $i, "clipessoa");
        $descricaol = pg_fetch_result($sql, $i, "catcodigo");
        $descricaom = pg_fetch_result($sql, $i, "stccodigo");

        $descricao2a = pg_fetch_result($sql, $i, "clecep");
        $descricao2b = pg_fetch_result($sql, $i, "cleendereco");
        $descricao2c = pg_fetch_result($sql, $i, "clebairro");
        $descricao2d = recuperaMascara(pg_fetch_result($sql, $i, "clefone"));
        $descricao2e = recuperaMascara(pg_fetch_result($sql, $i, "clefax"));
        $descricao2f = pg_fetch_result($sql, $i, "cleemail");
        $descricao2g = recuperaMascara(pg_fetch_result($sql, $i, "clefone2"));
        $descricao2h = recuperaMascara(pg_fetch_result($sql, $i, "clefone3"));
        $descricao2i = pg_fetch_result($sql, $i, "clenumero");
        $descricao2j = pg_fetch_result($sql, $i, "clecomplemento");

        $clecodigo = pg_fetch_result($sql, $i, "clecodigo");

        $descricaon = pg_fetch_result($sql, $i, "cidcodigo");
        $descricaoo = pg_fetch_result($sql, $i, "descricao");
        $descricaop = pg_fetch_result($sql, $i, "uf");

        $descricaon2 = pg_fetch_result($sql, $i, "cidcodigo2");
        $descricaoo2 = pg_fetch_result($sql, $i, "descricao2");
        $descricaop2 = pg_fetch_result($sql, $i, "uf2");

        $descricaon3 = pg_fetch_result($sql, $i, "cidcodigo3");
        $descricaoo3 = pg_fetch_result($sql, $i, "descricao3");
        $descricaop3 = pg_fetch_result($sql, $i, "uf3");

        $descricaoq = pg_fetch_result($sql, $i, "clisintegra");

        $descricaor = pg_fetch_result($sql, $i, "clisintegrasn");

        $clitipo = pg_fetch_result($sql, $i, "clitipo");

        $clifundacao = pg_fetch_result($sql, $i, "clifundacao");
        $clipercentual = pg_fetch_result($sql, $i, "clipercentual");
        $cliprotesto = pg_fetch_result($sql, $i, "cliprotesto");
        $clivtot = pg_fetch_result($sql, $i, "clivtot");
        $cliperiodo = pg_fetch_result($sql, $i, "cliperiodo");
        $cliperiodo2 = pg_fetch_result($sql, $i, "cliperiodo2");
        $clirefin = pg_fetch_result($sql, $i, "clirefin");
        $clirefindata = pg_fetch_result($sql, $i, "clirefindata");
        $clirefindata2 = pg_fetch_result($sql, $i, "clirefindata2");
        $clioutrosqtde = pg_fetch_result($sql, $i, "clioutrosqtde");
        $clioutrosdata = pg_fetch_result($sql, $i, "clioutrosdata");
        $clioutrosdata2 = pg_fetch_result($sql, $i, "clioutrosdata2");
        $clibureau = pg_fetch_result($sql, $i, "clibureau");

        $clifcad = pg_fetch_result($sql, $i, "clifcad");
        $clicsocial = pg_fetch_result($sql, $i, "clicsocial");
        $cliicom = pg_fetch_result($sql, $i, "cliicom");
        $clifcaddata = pg_fetch_result($sql, $i, "clifcaddata");
        $clicsocialdata = pg_fetch_result($sql, $i, "clicsocialdata");
        $cliicomdata = pg_fetch_result($sql, $i, "cliicomdata");
        $clivtotref = pg_fetch_result($sql, $i, "clivtotref");
        $clivtotoutros = pg_fetch_result($sql, $i, "clivtotoutros");
        $altusuario = pg_fetch_result($sql, $i, "altusuario");
        $icfornecedor1 = pg_fetch_result($sql, $i, "icfornecedor1");
        $icfornecedor2 = pg_fetch_result($sql, $i, "icfornecedor2");
        $icfornecedor3 = pg_fetch_result($sql, $i, "icfornecedor3");
        $icfornecedor4 = pg_fetch_result($sql, $i, "icfornecedor4");
        $iccontato1 = pg_fetch_result($sql, $i, "iccontato1");
        $iccontato2 = pg_fetch_result($sql, $i, "iccontato2");
        $iccontato3 = pg_fetch_result($sql, $i, "iccontato3");
        $iccontato4 = pg_fetch_result($sql, $i, "iccontato4");
        $icfone1 = recuperaMascara(pg_fetch_result($sql, $i, "icfone1"));
        $icfone2 = recuperaMascara(pg_fetch_result($sql, $i, "icfone2"));
        $icfone3 = recuperaMascara(pg_fetch_result($sql, $i, "icfone3"));
        $icfone4 = recuperaMascara(pg_fetch_result($sql, $i, "icfone4"));
        $razaocnpj = $descricaoc . " - " . $descricaoe;
        $cleemailxml = pg_fetch_result($sql, $i, "cleemailxml");


        $clioptsimples = pg_fetch_result($sql, $i, "clioptsimples");

        $cliconsig = pg_fetch_result($sql, $i, "cliconsig");
        if (trim($cliconsig) == "") {
            $cliconsig = "0";
        }

        $dataconsimples = pg_fetch_result($sql, $i, "dataconsimples");
        if (trim($clioptsimples) == "") {
            $clioptsimples = "0";
        }
        if ($dataconsimples != "") {
            $dataconsimples = substr($dataconsimples, 8, 2) . '/' . substr($dataconsimples, 5, 2) . '/' . substr($dataconsimples, 0, 4);
        } else {
            $dataconsimples = "0";
        }

        $clisuframa = pg_fetch_result($sql, $i, "clisuframa");
        if ($clisuframa == "") {
            $clisuframa = '0';
        }

        $cliregime = pg_fetch_result($sql, $i, "cliregime");
        if ($cliregime == "") {
            $cliregime = '0';
        }

        $clioptinativo = pg_fetch_result($sql, $i, "clioptinativo");
        $datainativo = pg_fetch_result($sql, $i, "datainativo");

        $clist = pg_fetch_result($sql, $i, "clist");
        if (trim($clist) == "") {
            $clist = "1";
        }


        if (trim($clecodigo) == "") {
            $clecodigo = "0";
        }

        $sql2 = "
       	SELECT ccfnome,ccffone,ccfemail
       	FROM  clicfat
       	WHERE clecodigo = '$clecodigo'
       	ORDER BY ccfcodigo";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);

        if ($row2) {
            for ($a = 0; $a < 4; $a++) {

                if ($a == 0) {
                    $descricao3a0 = pg_fetch_result($sql2, $a, "ccfnome");
                    $descricao3b0 = recuperaMascara(pg_fetch_result($sql2, $a, "ccffone"));
                    $descricao3d0 = pg_fetch_result($sql2, $a, "ccfemail");
                } else
                if ($a == 1) {
                    if ($row2 > 1) {
                        $descricao3a = pg_fetch_result($sql2, $a, "ccfnome");
                        $descricao3b = recuperaMascara(pg_fetch_result($sql2, $a, "ccffone"));
                        $descricao3d = pg_fetch_result($sql2, $a, "ccfemail");
                    }
                } else
                if ($a == 2) {
                    if ($row2 > 2) {
                        $descricao4a = pg_fetch_result($sql2, $a, "ccfnome");
                        $descricao4b = recuperaMascara(pg_fetch_result($sql2, $a, "ccffone"));
                        $descricao4d = pg_fetch_result($sql2, $a, "ccfemail");
                    }
                } else
                if ($a == 3) {
                    if ($row2 > 3) {
                        $descricao5a = pg_fetch_result($sql2, $a, "ccfnome");
                        $descricao5b = recuperaMascara(pg_fetch_result($sql2, $a, "ccffone"));
                        $descricao5d = pg_fetch_result($sql2, $a, "ccfemail");
                    }
                }
            }
        } else {
            $descricao3a0 = "0";
            $descricao3b0 = "0";
            $descricao3d0 = "0";
            $descricao3a = "0";
            $descricao3b = "0";
            $descricao3d = "0";
            $descricao4a = "0";
            $descricao4b = "0";
            $descricao4d = "0";
            $descricao5a = "0";
            $descricao5b = "0";
            $descricao5d = "0";
        }
        $descricao6a = pg_fetch_result($sql, $i, "clccep");
        $descricao6b = pg_fetch_result($sql, $i, "clcendereco");
        $descricao6c = pg_fetch_result($sql, $i, "clcbairro");
        $descricao6d = recuperaMascara(pg_fetch_result($sql, $i, "clcfone"));
        $descricao6e = recuperaMascara(pg_fetch_result($sql, $i, "clcfax"));
        $descricao6f = pg_fetch_result($sql, $i, "clcemail");
        $descricao6g = recuperaMascara(pg_fetch_result($sql, $i, "clcfone2"));
        $descricao6h = recuperaMascara(pg_fetch_result($sql, $i, "clcfone3"));
        $descricao6i = pg_fetch_result($sql, $i, "clcnumero");
        $descricao6j = pg_fetch_result($sql, $i, "clccomplemento");

        $clccodigo = pg_fetch_result($sql, $i, "clccodigo");

        if (trim($clccodigo) == "") {
            $clccodigo = "0";
        }

        $sql2 = "
	    SELECT cccnome,cccfone,cccemail
	    FROM  cliccob
	    WHERE clccodigo = '$clccodigo'
	    ORDER BY ccccodigo";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);

        if ($row2) {
            for ($a = 0; $a < 4; $a++) {
                if ($a == 0) {
                    $descricao7a0 = pg_fetch_result($sql2, $a, "cccnome");
                    $descricao7b0 = recuperaMascara(pg_fetch_result($sql2, $a, "cccfone"));
                    $descricao7d0 = pg_fetch_result($sql2, $a, "cccemail");
                } else
                if ($a == 1) {
                    if ($row2 > 1) {
                        $descricao7a = pg_fetch_result($sql2, $a, "cccnome");
                        $descricao7b = recuperaMascara(pg_fetch_result($sql2, $a, "cccfone"));
                        $descricao7d = pg_fetch_result($sql2, $a, "cccemail");
                    }
                } else
                if ($a == 2) {
                    if ($row2 > 2) {
                        $descricao8a = pg_fetch_result($sql2, $a, "cccnome");
                        $descricao8b = recuperaMascara(pg_fetch_result($sql2, $a, "cccfone"));
                        $descricao8d = pg_fetch_result($sql2, $a, "cccemail");
                    }
                } else
                if ($a == 3) {
                    if ($row2 > 3) {
                        $descricao9a = pg_fetch_result($sql2, $a, "cccnome");
                        $descricao9b = recuperaMascara(pg_fetch_result($sql2, $a, "cccfone"));
                        $descricao9d = pg_fetch_result($sql2, $a, "cccemail");
                    }
                }
            }
        } else {
            $descricao7a0 = "0";
            $descricao7b0 = "0";
            $descricao7d0 = "0";
            $descricao7a = "0";
            $descricao7b = "0";
            $descricao7d = "0";
            $descricao8a = "0";
            $descricao8b = "0";
            $descricao8d = "0";
            $descricao9a = "0";
            $descricao9b = "0";
            $descricao9d = "0";
        }

        $descricao10a = pg_fetch_result($sql, $i, "ceecep");
        $descricao10b = pg_fetch_result($sql, $i, "ceeendereco");
        $descricao10c = pg_fetch_result($sql, $i, "ceebairro");
        $descricao10d = recuperaMascara(pg_fetch_result($sql, $i, "ceefone"));
        $descricao10e = recuperaMascara(pg_fetch_result($sql, $i, "ceefax"));
        $descricao10f = pg_fetch_result($sql, $i, "ceeemail");
        $descricao10g = recuperaMascara(pg_fetch_result($sql, $i, "ceefone2"));
        $descricao10h = recuperaMascara(pg_fetch_result($sql, $i, "ceefone3"));
        $descricao10i = pg_fetch_result($sql, $i, "ceenumero");
        $descricao10j = pg_fetch_result($sql, $i, "ceecomplemento");

        $ceecodigo = pg_fetch_result($sql, $i, "ceecodigo");

        if (trim($ceecodigo) == "") {
            $ceecodigo = "0";
        }

        $sql2 = "
		SELECT ccenome,ccefone,cceemail
		FROM  clicent
		WHERE clecodigo = '$ceecodigo'
		ORDER BY ccecodigo";

        $sql2 = pg_query($sql2);
        $row2 = pg_num_rows($sql2);

        if ($row2) {
            for ($a = 0; $a < 4; $a++) {
                if ($a == 0) {
                    $descricao11a0 = pg_fetch_result($sql2, $a, "ccenome");
                    $descricao11b0 = recuperaMascara(pg_fetch_result($sql2, $a, "ccefone"));
                    $descricao11d0 = pg_fetch_result($sql2, $a, "cceemail");
                } else
                if ($a == 1) {
                    if ($row2 > 1) {
                        $descricao11a = pg_fetch_result($sql2, $a, "ccenome");
                        $descricao11b = recuperaMascara(pg_fetch_result($sql2, $a, "ccefone"));
                        $descricao11d = pg_fetch_result($sql2, $a, "cceemail");
                    }
                } else
                if ($a == 2) {
                    if ($row2 > 2) {
                        $descricao12a = pg_fetch_result($sql2, $a, "ccenome");
                        $descricao12b = recuperaMascara(pg_fetch_result($sql2, $a, "ccefone"));
                        $descricao12d = pg_fetch_result($sql2, $a, "cceemail");
                    }
                } else
                if ($a == 3) {
                    if ($row2 > 3) {
                        $descricao14a = pg_fetch_result($sql2, $a, "ccenome");
                        $descricao14b = recuperaMascara(pg_fetch_result($sql2, $a, "ccefone"));
                        $descricao14d = pg_fetch_result($sql2, $a, "cceemail");
                    }
                }
            }
        } else {
            $descricao11a0 = "0";
            $descricao11b0 = "0";
            $descricao11d0 = "0";
            $descricao11a = "0";
            $descricao11b = "0";
            $descricao11d = "0";
            $descricao12a = "0";
            $descricao12b = "0";
            $descricao12d = "0";
            $descricao14a = "0";
            $descricao14b = "0";
            $descricao14d = "0";
        }

        $des1 = pg_fetch_result($sql, $i, "clcomcep");
        $des2 = pg_fetch_result($sql, $i, "clcomendereco");
        $des3 = pg_fetch_result($sql, $i, "clcombairro");
        $des4 = recuperaMascara(pg_fetch_result($sql, $i, "clcomfone"));
        $des5 = recuperaMascara(pg_fetch_result($sql, $i, "clcomfax"));
        $des6 = pg_fetch_result($sql, $i, "clcomemail");
        $des7 = pg_fetch_result($sql, $i, "clcomcodigo");
        $des8 = recuperaMascara(pg_fetch_result($sql, $i, "clcomfone2"));
        $des9 = recuperaMascara(pg_fetch_result($sql, $i, "clcomfone3"));
        $des10 = pg_fetch_result($sql, $i, "clcomnsocio");
        $des11 = pg_fetch_result($sql, $i, "clcomsexo");
        $des12 = pg_fetch_result($sql, $i, "clcomip");
        $des13 = pg_fetch_result($sql, $i, "clcomcpf");
        $des14 = pg_fetch_result($sql, $i, "cidcodigo4");
        $des15 = pg_fetch_result($sql, $i, "descricao4");
        $des16 = pg_fetch_result($sql, $i, "uf4");
        $des17 = pg_fetch_result($sql, $i, "clcomnumero");
        $des18 = pg_fetch_result($sql, $i, "clcomcomplemento");

        $clifpagto = pg_fetch_result($sql, $i, "clifpagto");
        $clicanal = pg_fetch_result($sql, $i, "clicanal");

        $clilimite = pg_fetch_result($sql, $i, "clilimite");
        $climodo = pg_fetch_result($sql, $i, "climodo");
        $clifat = pg_fetch_result($sql, $i, "clifat");
        $clifin = pg_fetch_result($sql, $i, "clifin");

        $vencodigo = pg_fetch_result($sql, $i, "vencodigo");

        $cliinc = pg_fetch_result($sql, $i, "cliinc");
        $cliserasa = pg_fetch_result($sql, $i, "cliserasa");
        $cliserasainc = pg_fetch_result($sql, $i, "serasaatual");
        //$cliserasaalt = pg_fetch_result($sql, $i, "cliserasaalt");
        $cliserasaexp = pg_fetch_result($sql, $i, "cliserasaexp");
        $clisintegrainc = pg_fetch_result($sql, $i, "clisintegrainc");
        $clisintegraalt = pg_fetch_result($sql, $i, "clisintegraalt");
        $clisintegraexp = pg_fetch_result($sql, $i, "clisintegraexp");

        $serasaatual = pg_fetch_result($sql, $i, "serasaatual");
        $sintegraaatual = pg_fetch_result($sql, $i, "sintegraaatual");
        $sintegrahabilitado = pg_fetch_result($sql, $i, "sintegrahabilitado");
        $sintegrarestricoes = pg_fetch_result($sql, $i, "sintegrarestricoes");
        $clicidcodigoibge = pg_fetch_result($sql, $i, "cidcodigoibge");
        if (trim($clicidcodigoibge) == "" || trim($clicidcodigoibge) == null) {
            $clicidcodigoibge = "0";
        }
        $clicidcodigoibgecob = pg_fetch_result($sql, $i, "cidcodigoibgecob");
        $clicidcodigoibgecee = pg_fetch_result($sql, $i, "cidcodigoibgecee");
        $potencialdecompra = pg_fetch_result($sql, $i, "potencialdecompra");
        $limiteproposto = pg_fetch_result($sql, $i, "limiteproposto");


        $clidatavalida = pg_fetch_result($sql, $i, "clidatavalida");
        if (trim($clidatavalida) == "" || trim($clidatavalida) == null) {
            $clidatavalida = "0";
        }
        $usuvalida = pg_fetch_result($sql, $i, "usuvalida");
        if (trim($usuvalida) == "" || trim($usuvalida) == null) {
            $usuvalida = "0";
        }

        $receitaDataConsulta = pg_fetch_result($sql, $i, "receitadataconsulta");
        $receitaNumero = pg_fetch_result($sql, $i, "receita_numero");
        $receitaComplemento = pg_fetch_result($sql, $i, "receita_complemento");
        $receitaCep = pg_fetch_result($sql, $i, "receita_cep");
        $receitaBairro = pg_fetch_result($sql, $i, "receita_bairro");
        $receitaUf = pg_fetch_result($sql, $i, "receita_uf");
        $receitaLogradouro = pg_fetch_result($sql, $i, "receita_logradouro");
        $receitaCidade = pg_fetch_result($sql, $i, "receita_cidade");
        $sintegraDataConsulta = pg_fetch_result($sql, $i, "sintegradataconsulta");
        $clireceitaRazao = pg_fetch_result($sql, $i, "clireceitarazao");
        $clisintegraRazao = pg_fetch_result($sql, $i, "clisintegrarazao");
        $clireceitaidprocessamento = pg_fetch_result($sql, $i, "clireceitaidprocessamento");
        $clisintegraidprocessamento = pg_fetch_result($sql, $i, "clisintegraidprocessamento");

        $sintegraNumero = pg_fetch_result($sql, $i, "sintegra_numero");
        $sintegraComplemento = pg_fetch_result($sql, $i, "sintegra_complemento");
        $sintegraCep = pg_fetch_result($sql, $i, "sintegra_cep");
        $sintegraBairro = pg_fetch_result($sql, $i, "sintegra_bairro");
        $sintegraUf = pg_fetch_result($sql, $i, "sintegra_uf");
        $sintegraLogradouro = pg_fetch_result($sql, $i, "sintegra_logradouro");
        $sintegraCidade = pg_fetch_result($sql, $i, "sintegra_cidade");
        $portador = pg_fetch_result($sql, $i, "portador");

        if (trim($codigo) == "") {
            $codigo = "0";
        }

        if (trim($descricao) == "") {
            $descricao = "0";
        }
        if (trim($descricaob) == "") {
            $descricaob = "0";
        }
        if (trim($descricaoc) == "") {
            $descricaoc = "0";
        }
        if (trim($descricaod) == "") {
            $descricaod = "0";
        }
        if (trim($descricaoe) == "") {
            $descricaoe = "0";
        }
        if (trim($descricaof) == "") {
            $descricaof = "0";
        }
        if (trim($descricaog) == "") {
            $descricaog = "0";
        }
        if (trim($descricaoh) == "") {
            $descricaoh = "0";
        }
        if (trim($descricaoi) == "") {
            $descricaoi = "0";
        }
        if (trim($descricaoj) == "") {
            $descricaoj = "0";
        }
        if (trim($descricaok) == "") {
            $descricaok = "1";
        }
        if (trim($descricaol) == "") {
            $descricaol = "3";
        }
        if (trim($descricaom) == "") {
            $descricaom = "0";
        }

        if (trim($descricao2a) == "") {
            $descricao2a = "0";
        }
        if (trim($descricao2b) == "") {
            $descricao2b = "0";
        }
        if (trim($descricao2c) == "") {
            $descricao2c = "0";
        }
        if (trim($descricao2d) == "") {
            $descricao2d = "0";
        }
        if (trim($descricao2e) == "") {
            $descricao2e = "0";
        }
        if (trim($descricao2f) == "") {
            $descricao2f = "0";
        }
        if (trim($cleemailxml) == "") {
            $cleemailxml = "0";
        }
        if (trim($descricao2g) == "") {
            $descricao2g = "0";
        }
        if (trim($descricao2h) == "") {
            $descricao2h = "0";
        }
        if (trim($descricao2i) == "") {
            $descricao2i = "0";
        }
        if (trim($descricao2j) == "") {
            $descricao2j = "0";
        }

        if (trim($descricao3a) == "") {
            $descricao3a = "0";
        }
        if (trim($descricao3b) == "") {
            $descricao3b = "0";
        }
        if (trim($descricao3d) == "") {
            $descricao3d = "0";
        }
        if (trim($descricao3a0) == "") {
            $descricao3a0 = "0";
        }
        if (trim($descricao3b0) == "") {
            $descricao3b0 = "0";
        }
        if (trim($descricao3d0) == "") {
            $descricao3d0 = "0";
        }
        if (trim($descricao4a) == "") {
            $descricao4a = "0";
        }
        if (trim($descricao4b) == "") {
            $descricao4b = "0";
        }
        if (trim($descricao4d) == "") {
            $descricao4d = "0";
        }
        if (trim($descricao5a) == "") {
            $descricao5a = "0";
        }
        if (trim($descricao5b) == "") {
            $descricao5b = "0";
        }
        if (trim($descricao5d) == "") {
            $descricao5d = "0";
        }

        if (trim($descricao6a) == "") {
            $descricao6a = "0";
        }
        if (trim($descricao6b) == "") {
            $descricao6b = "0";
        }
        if (trim($descricao6c) == "") {
            $descricao6c = "0";
        }
        if (trim($descricao6d) == "") {
            $descricao6d = "0";
        }
        if (trim($descricao6e) == "") {
            $descricao6e = "0";
        }
        if (trim($descricao6f) == "") {
            $descricao6f = "0";
        }
        if (trim($descricao6g) == "") {
            $descricao6g = "0";
        }
        if (trim($descricao6h) == "") {
            $descricao6h = "0";
        }
        if (trim($descricao6i) == "") {
            $descricao6i = "0";
        }
        if (trim($descricao6j) == "") {
            $descricao6j = "0";
        }

        if (trim($descricao7a0) == "") {
            $descricao7a0 = "0";
        }
        if (trim($descricao7b0) == "") {
            $descricao7b0 = "0";
        }
        if (trim($descricao7d0) == "") {
            $descricao7d0 = "0";
        }
        if (trim($descricao7a) == "") {
            $descricao7a = "0";
        }
        if (trim($descricao7b) == "") {
            $descricao7b = "0";
        }
        if (trim($descricao7d) == "") {
            $descricao7d = "0";
        }
        if (trim($descricao8a) == "") {
            $descricao8a = "0";
        }
        if (trim($descricao8b) == "") {
            $descricao8b = "0";
        }
        if (trim($descricao8d) == "") {
            $descricao8d = "0";
        }
        if (trim($descricao9a) == "") {
            $descricao9a = "0";
        }
        if (trim($descricao9b) == "") {
            $descricao9b = "0";
        }
        if (trim($descricao9d) == "") {
            $descricao9d = "0";
        }

        if (trim($descricao10a) == "") {
            $descricao10a = "0";
        }
        if (trim($descricao10b) == "") {
            $descricao10b = "0";
        }
        if (trim($descricao10c) == "") {
            $descricao10c = "0";
        }
        if (trim($descricao10d) == "") {
            $descricao10d = "0";
        }
        if (trim($descricao10e) == "") {
            $descricao10e = "0";
        }
        if (trim($descricao10f) == "") {
            $descricao10f = "0";
        }
        if (trim($descricao10g) == "") {
            $descricao10g = "0";
        }
        if (trim($descricao10h) == "") {
            $descricao10h = "0";
        }
        if (trim($descricao10i) == "") {
            $descricao10i = "0";
        }
        if (trim($descricao10j) == "") {
            $descricao10j = "0";
        }

        if (trim($descricao11a0) == "") {
            $descricao11a0 = "0";
        }
        if (trim($descricao11b0) == "") {
            $descricao11b0 = "0";
        }
        if (trim($descricao11d0) == "") {
            $descricao11d0 = "0";
        }
        if (trim($descricao11a) == "") {
            $descricao11a = "0";
        }
        if (trim($descricao11b) == "") {
            $descricao11b = "0";
        }
        if (trim($descricao11d) == "") {
            $descricao11d = "0";
        }

        if (trim($descricao12a) == "") {
            $descricao12a = "0";
        }
        if (trim($descricao12b) == "") {
            $descricao12b = "0";
        }
        if (trim($descricao12d) == "") {
            $descricao12d = "0";
        }

        if (trim($descricao14a) == "") {
            $descricao14a = "0";
        }
        if (trim($descricao14b) == "") {
            $descricao14b = "0";
        }
        if (trim($descricao14d) == "") {
            $descricao14d = "0";
        }

        if (trim($descricaon) == "") {
            $descricaon = "0";
        }
        if (trim($descricaoo) == "") {
            $descricaoo = "0";
        }
        if (trim($descricaop) == "") {
            $descricaop = "0";
        }

        if (trim($descricaon2) == "") {
            $descricaon2 = "0";
        }
        if (trim($descricaoo2) == "") {
            $descricaoo2 = "0";
        }
        if (trim($descricaop2) == "") {
            $descricaop2 = "0";
        }

        if (trim($descricaon3) == "") {
            $descricaon3 = "0";
        }
        if (trim($descricaoo3) == "") {
            $descricaoo3 = "0";
        }
        if (trim($descricaop3) == "") {
            $descricaop3 = "0";
        }

        if ($descricaoq != "") {
            $descricaoq = substr($descricaoq, 8, 2) . '/' . substr($descricaoq, 5, 2) . '/' . substr($descricaoq, 0, 4);
        } else {
            $descricaoq = "0";
        }

        if ($cliinc != "") {
            $cliinc = substr($cliinc, 8, 2) . '/' . substr($cliinc, 5, 2) . '/' . substr($cliinc, 0, 4);
        } else {
            $cliinc = "0";
        }
        if ($cliserasa != "") {
            $cliserasa = substr($cliserasa, 8, 2) . '/' . substr($cliserasa, 5, 2) . '/' . substr($cliserasa, 0, 4);
        } else {
            $cliserasa = "0";
        }
//		if ($cliserasainc != "")
//			{
//			$cliserasainc = substr ( $cliserasainc, 8, 2 ) . '/' . substr ( $cliserasainc, 5, 2 ) . '/' . substr ( $cliserasainc, 0, 4 );
//			}
//		else
//			{
//			$cliserasainc = "0";
//			}
        //if($cliserasaalt <> "" ) {$cliserasaalt = substr($cliserasaalt, 8, 2).'/'.substr($cliserasaalt, 5, 2).'/'.substr($cliserasaalt,0, 4) ;}
        //else{$cliserasaalt = "0";}
        if ($cliserasaexp != "") {
            $cliserasaexp = substr($cliserasaexp, 8, 2) . '/' . substr($cliserasaexp, 5, 2) . '/' . substr($cliserasaexp, 0, 4);
        } else {
            $cliserasaexp = "0";
        }
        if ($receitaCep != "") {
            if (version_compare(PHP_VERSION, '7.0.0', '<')) {
                $receitaCep = ereg_replace("[^a-zA-Z0-9 _]", "", strtr($receitaCep, "áàãâéêíóôõúüç??ÀÃÂÉÊ??ÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
            } else {
                $receitaCep = preg_replace("[^a-zA-Z0-9 _]", "", strtr($receitaCep, "áàãâéêíóôõúüç??ÀÃÂÉÊ??ÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
            }
        }
        if ($sintegraCep != "") {
            if (version_compare(PHP_VERSION, '7.0.0', '<')) {
                $sintegraCep = ereg_replace("[^a-zA-Z0-9 _]", "", strtr($sintegraCep, "áàãâéêíóôõúüç??ÀÃÂÉÊ??ÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
            } else {
                $sintegraCep = preg_replace("[^a-zA-Z0-9 _]", "", strtr($sintegraCep, "áàãâéêíóôõúüç??ÀÃÂÉÊ??ÓÔÕÚÜÇ-", "aaaaeeiooouucAAAAEEIOOOUUC"));
            }
        }
        if ($clisintegrainc != "") {
            $clisintegrainc = substr($clisintegrainc, 8, 2) . '/' . substr($clisintegrainc, 5, 2) . '/' . substr($clisintegrainc, 0, 4);
        } else {
            $clisintegrainc = "0";
        }
        //if($clisintegraalt <> "" ) {$clisintegraalt = substr($clisintegraalt, 8, 2).'/'.substr($clisintegraalt, 5, 2).'/'.substr($clisintegraalt,0, 4) ;}
        //else{$clisintegraalt = "0";}
        if ($clisintegraexp != "") {
            $clisintegraexp = substr($clisintegraexp, 8, 2) . '/' . substr($clisintegraexp, 5, 2) . '/' . substr($clisintegraexp, 0, 4);
        } else {
            $clisintegraexp = "0";
        }

        if (trim($descricaor) == "") {
            $descricaor = "0";
        }
        if (trim($des1) == "") {
            $des1 = "0";
        }
        if (trim($des2) == "") {
            $des2 = "0";
        }
        if (trim($des3) == "") {
            $des3 = "0";
        }
        if (trim($des4) == "") {
            $des4 = "0";
        }
        if (trim($des5) == "") {
            $des5 = "0";
        }
        if (trim($des6) == "") {
            $des6 = "0";
        }
        if (trim($des7) == "") {
            $des7 = "0";
        }
        if (trim($des8) == "") {
            $des8 = "0";
        }
        if (trim($des9) == "") {
            $des9 = "0";
        }
        if (trim($des10) == "") {
            $des10 = "0";
        }
        if (trim($des11) == "") {
            $des11 = "0";
        }
        if (trim($des12) == "") {
            $des12 = "0";
        }
        if (trim($des13) == "") {
            $des13 = "0";
        }
        if (trim($des14) == "") {
            $des14 = "0";
        }
        if (trim($des15) == "") {
            $des15 = "0";
        }
        if (trim($des16) == "") {
            $des16 = "0";
        }
        if (trim($des17) == "") {
            $des17 = "0";
        }
        if (trim($des18) == "") {
            $des18 = "0";
        }

        if (trim($clifpagto) == "") {
            $clifpagto = "0";
        }
        if (trim($clicanal) == "") {
            $clicanal = "0";
        }

        if (trim($clilimite) == "") {
            $clilimite = "0";
        }
        if (trim($climodo) == "") {
            $climodo = "0";
        }
        if (trim($clifat) == "") {
            $clifat = "0";
        }
        if (trim($clifin) == "") {
            $clifin = "0";
        }

        if (trim($vencodigo) == "") {
            $vencodigo = "0";
        }

        if (trim($cliinc) == "") {
            $cliinc = "0";
        }
        if (trim($cliserasa) == "") {
            $cliserasa = "0";
        }
//		if (trim ( $cliserasainc ) == "")
//			{
//			$cliserasainc = "0";
//			}
        //if (trim($cliserasaalt)==""){$cliserasaalt = "0";}
        if (trim($cliserasaexp) == "") {
            $cliserasaexp = "0";
        }
        if (trim($clisintegrainc) == "") {
            $clisintegrainc = "0";
        }
        if (trim($clisintegraalt) == "") {
            $clisintegraalt = "0";
        }
        if (trim($clisintegraexp) == "") {
            $clisintegraexp = "0";
        }

        if (trim($serasaatual) == "") {
            $serasaatual = "0";
        }
        if (trim($sintegraaatual) == "") {
            $sintegraaatual = "0";
        }
        if (trim($sintegrahabilitado) == "") {
            $sintegrahabilitado = "0";
        }
        if (trim($sintegrarestricoes) == "") {
            $sintegrarestricoes = "0";
        }

        if (trim($receitaDataConsulta) == "") {
            $receitaDataConsulta = "0";
        }
        if (trim($clireceitaRazao) == "") {
            $clireceitaRazao = "0";
        }
        if (trim($receitaNumero) == "") {
            $receitaNumero = "0";
        }
        if (trim($receitaComplemento) == "") {
            $receitaComplemento = "0";
        }
        if (trim($receitaCep) == "") {
            $receitaCep = "0";
        }
        if (trim($receitaBairro) == "") {
            $receitaBairro = "0";
        }
        if (trim($receitaUf) == "") {
            $receitaUf = "0";
        }
        if (trim($receitaLogradouro) == "") {
            $receitaLogradouro = "0";
        }
        if (trim($receitaCidade) == "") {
            $receitaCidade = "0";
        }
        if (trim($sintegraDataConsulta) == "") {
            $sintegraDataConsulta = "0";
        }
        if (trim($clisintegraRazao) == "") {
            $clisintegraRazao = "0";
        }
        if (trim($clireceitaidprocessamento) == "") {
            $clireceitaidprocessamento = "0";
        }
        if (trim($clisintegraidprocessamento) == "") {
            $clisintegraidprocessamento = "0";
        }
        if (trim($sintegraNumero) == "") {
            $sintegraNumero = "0";
        }

        if (trim($sintegraComplemento) == "") {
            $sintegraComplemento = "0";
        }
        if (trim($sintegraCep) == "") {
            $sintegraCep = "0";
        }
        if (trim($sintegraBairro) == "") {
            $sintegraBairro = "0";
        }
        if (trim($sintegraUf) == "") {
            $sintegraUf = "0";
        }
        if (trim($sintegraLogradouro) == "") {
            $sintegraLogradouro = "0";
        }
        if (trim($sintegraCidade) == "") {
            $sintegraCidade = "0";
        }
        if (trim($portador) == "") {
            $portador = "0";
        }
        if (trim($clidatavalida) == "") {
            $clidatavalida = "0";
        }
        if (trim($usuvalida) == "") {
            $usunome = "0";
        }

        $vendedor1 = "0";
        $vendedor2 = "0";
        $ultimacompra = "";

        $sql3 = "
		SELECT a.pvemissao as ultimacompra,b.vennguerra
		FROM  pvenda a, vendedor b
		WHERE a.clicodigo = '$codigo'
		AND a.vencodigo = b.vencodigo
		ORDER BY a.pvemissao DESC limit 2";
        $sql3 = pg_query($sql3);
        $row3 = pg_num_rows($sql3);
        if ($row3) {
            $ultimacompra = pg_fetch_result($sql3, 0, "ultimacompra");
            for ($k = 0; $k < $row3; $k++) {
                if ($k == 0) {
                    $vendedor1 = pg_fetch_result($sql3, $k, "vennguerra");
                }
                if ($k == 1) {
                    $vendedor2 = pg_fetch_result($sql3, $k, "vennguerra");
                }
            }
        }

        if ($ultimacompra != "") {
            $ultimacompra = substr($ultimacompra, 8, 2) . '/' . substr($ultimacompra, 5, 2) . '/' . substr($ultimacompra, 0, 4);
        } else {
            $ultimacompra = "0";
        }

        if (trim($vendedor1) == "") {
            $vendedor1 = "0";
        }
        if (trim($vendedor2) == "") {
            $vendedor2 = "0";
        }

        if (trim($clitipo) == "") {
            $clitipo = "1";
        }

        if (trim($clifundacao) == "") {
            $clifundacao = "";
        }
        if (trim($clipercentual) == "") {
            $clipercentual = "0";
        }
        if (trim($cliprotesto) == "") {
            $cliprotesto = "";
        }
        if (trim($clivtot) == "") {
            $clivtot = "0";
        }
        if (trim($cliperiodo) == "") {
            $cliperiodo = "";
        }
        if (trim($cliperiodo2) == "") {
            $cliperiodo2 = "";
        }
        if (trim($clirefin) == "") {
            $clirefin = "0";
        }
        if (trim($clirefindata) == "") {
            $clirefindata = "";
        }
        if (trim($clirefindata2) == "") {
            $clirefindata2 = "";
        }
        if (trim($clioutrosqtde) == "") {
            $clioutrosqtde = "0";
        }
        if (trim($clioutrosdata) == "") {
            $clioutrosdata = "";
        }
        if (trim($clioutrosdata2) == "") {
            $clioutrosdata2 = "";
        }
        if (trim($clibureau) == "") {
            $clibureau = "0";
        }

        if (trim($clifcad) == "") {
            $clifcad = "0";
        }
        if (trim($clicsocial) == "") {
            $clicsocial = "0";
        }
        if (trim($cliicom) == "") {
            $cliicom = "0";
        }
        if (trim($clifcaddata) == "") {
            $clifcaddata = "";
        }
        if (trim($clicsocialdata) == "") {
            $clicsocialdata = "";
        }
        if (trim($cliicomdata) == "") {
            $cliicomdata = "";
        }
        if (trim($clivtotref) == "") {
            $clivtotref = "0";
        }
        if (trim($clivtotoutros) == "") {
            $clivtotoutros = "0";
        }
        if (trim($altusuario) == "") {
            $altusuario = "0";
        }
        if (trim($icfornecedor1) == "") {
            $icfornecedor1 = "0";
        }
        if (trim($icfornecedor2) == "") {
            $icfornecedor2 = "0";
        }
        if (trim($icfornecedor3) == "") {
            $icfornecedor3 = "0";
        }
        if (trim($icfornecedor4) == "") {
            $icfornecedor4 = "0";
        }
        if (trim($iccontato1) == "") {
            $iccontato1 = "0";
        }
        if (trim($iccontato2) == "") {
            $iccontato2 = "0";
        }
        if (trim($iccontato3) == "") {
            $iccontato3 = "0";
        }
        if (trim($iccontato4) == "") {
            $iccontato4 = "0";
        }
        if (trim($icfone1) == "") {
            $icfone1 = "0";
        }
        if (trim($icfone2) == "") {
            $icfone2 = "0";
        }
        if (trim($icfone3) == "") {
            $icfone3 = "0";
        }
        if (trim($icfone4) == "") {
            $icfone4 = "0";
        }

        if (trim($clidat) == "") {
            $clidat = "0";
        }

        $total = "";

        $clireceitaRazao = str_replace("&", "E", $clireceitaRazao);
        $clireceitaRazao = removeCaracterEspeciais($clireceitaRazao);

        $clisintegraRazao = str_replace("&", "E", $clisintegraRazao);
        $clisintegraRazao = removeCaracterEspeciais($clisintegraRazao);

        $sql4 = "Select (sum(dvitem.pvipreco * dvitem.pvidevol)) as total from dvitem
		left join devolucao on dvitem.pvvale = devolucao.pvvale
		left join clientes on devolucao.clicodigo = clientes.clicodigo
		left join prefechamento on text(devolucao.pvvale) like prefechamento.fecdocto
		where clientes.clicodigo = " . $codigo . " and (devolucao.pvbaixa ISNULL or cast(devolucao.pvbaixa as varchar) like '')  and prefechamento.fecdocto isNull";

        $sql4 = pg_query($sql4);
        $row4 = pg_num_rows($sql4);
        if ($row4) {
            $total = pg_fetch_result($sql4, 0, "total");
        }

        if (trim($total) == "") {
            $total = "0";
        }

        $xml .= "<dado>\n";
        $xml .= "<codigo>" . $codigo . "</codigo>\n";
        $xml .= "<descricao>" . $descricao . "</descricao>\n";
        $xml .= "<descricaob>" . $descricaob . "</descricaob>\n";
        $xml .= "<clidat>" . $clidat . "</clidat>\n";
        $xml .= "<descricaoc>" . $descricaoc . "</descricaoc>\n";
        $xml .= "<descricaod>" . $descricaod . "</descricaod>\n";
        $xml .= "<descricaoe>" . $descricaoe . "</descricaoe>\n";
        $xml .= "<descricaof>" . $descricaof . "</descricaof>\n";
        $xml .= "<descricaog>" . $descricaog . "</descricaog>\n";
        $xml .= "<descricaoh>" . $descricaoh . "</descricaoh>\n";
        $xml .= "<descricaoi>" . $descricaoi . "</descricaoi>\n";
        $xml .= "<descricaoj>" . $descricaoj . "</descricaoj>\n";
        $xml .= "<descricaok>" . $descricaok . "</descricaok>\n";
        $xml .= "<descricaol>" . $descricaol . "</descricaol>\n";
        $xml .= "<descricaom>" . $descricaom . "</descricaom>\n";

        $xml .= "<descricao2a>" . $descricao2a . "</descricao2a>\n";
        $xml .= "<descricao2b>" . $descricao2b . "</descricao2b>\n";
        $xml .= "<descricao2c>" . $descricao2c . "</descricao2c>\n";
        $xml .= "<descricao2d>" . $descricao2d . "</descricao2d>\n";
        $xml .= "<descricao2e>" . $descricao2e . "</descricao2e>\n";
        $xml .= "<descricao2f>" . $descricao2f . "</descricao2f>\n";
        $xml .= "<descricao2g>" . $descricao2g . "</descricao2g>\n";
        $xml .= "<descricao2h>" . $descricao2h . "</descricao2h>\n";
        $xml .= "<descricao2i>" . $descricao2i . "</descricao2i>\n";
        $xml .= "<descricao2j>" . $descricao2j . "</descricao2j>\n";

        $xml .= "<descricao3a0>" . $descricao3a0 . "</descricao3a0>\n";
        $xml .= "<descricao3b0>" . $descricao3b0 . "</descricao3b0>\n";
        $xml .= "<descricao3d0>" . $descricao3d0 . "</descricao3d0>\n";
        $xml .= "<descricao3a>" . $descricao3a . "</descricao3a>\n";
        $xml .= "<descricao3b>" . $descricao3b . "</descricao3b>\n";
        $xml .= "<descricao3d>" . $descricao3d . "</descricao3d>\n";
        $xml .= "<descricao4a>" . $descricao4a . "</descricao4a>\n";
        $xml .= "<descricao4b>" . $descricao4b . "</descricao4b>\n";
        $xml .= "<descricao4d>" . $descricao4d . "</descricao4d>\n";
        $xml .= "<descricao5a>" . $descricao5a . "</descricao5a>\n";
        $xml .= "<descricao5b>" . $descricao5b . "</descricao5b>\n";
        $xml .= "<descricao5d>" . $descricao5d . "</descricao5d>\n";

        $xml .= "<descricao6a>" . $descricao6a . "</descricao6a>\n";
        $xml .= "<descricao6b>" . $descricao6b . "</descricao6b>\n";
        $xml .= "<descricao6c>" . $descricao6c . "</descricao6c>\n";
        $xml .= "<descricao6d>" . $descricao6d . "</descricao6d>\n";
        $xml .= "<descricao6e>" . $descricao6e . "</descricao6e>\n";
        $xml .= "<descricao6f>" . $descricao6f . "</descricao6f>\n";
        $xml .= "<descricao6g>" . $descricao6g . "</descricao6g>\n";
        $xml .= "<descricao6h>" . $descricao6h . "</descricao6h>\n";
        $xml .= "<descricao6i>" . $descricao6i . "</descricao6i>\n";
        $xml .= "<descricao6j>" . $descricao6j . "</descricao6j>\n";

        $xml .= "<descricao7a0>" . $descricao7a0 . "</descricao7a0>\n";
        $xml .= "<descricao7b0>" . $descricao7b0 . "</descricao7b0>\n";
        $xml .= "<descricao7d0>" . $descricao7d0 . "</descricao7d0>\n";
        $xml .= "<descricao7a>" . $descricao7a . "</descricao7a>\n";
        $xml .= "<descricao7b>" . $descricao7b . "</descricao7b>\n";
        $xml .= "<descricao7d>" . $descricao7d . "</descricao7d>\n";
        $xml .= "<descricao8a>" . $descricao8a . "</descricao8a>\n";
        $xml .= "<descricao8b>" . $descricao8b . "</descricao8b>\n";
        $xml .= "<descricao8d>" . $descricao8d . "</descricao8d>\n";
        $xml .= "<descricao9a>" . $descricao9a . "</descricao9a>\n";
        $xml .= "<descricao9b>" . $descricao9b . "</descricao9b>\n";
        $xml .= "<descricao9d>" . $descricao9d . "</descricao9d>\n";

        $xml .= "<descricao10a>" . $descricao10a . "</descricao10a>\n";
        $xml .= "<descricao10b>" . $descricao10b . "</descricao10b>\n";
        $xml .= "<descricao10c>" . $descricao10c . "</descricao10c>\n";
        $xml .= "<descricao10d>" . $descricao10d . "</descricao10d>\n";
        $xml .= "<descricao10e>" . $descricao10e . "</descricao10e>\n";
        $xml .= "<descricao10f>" . $descricao10f . "</descricao10f>\n";
        $xml .= "<descricao10g>" . $descricao10g . "</descricao10g>\n";
        $xml .= "<descricao10h>" . $descricao10h . "</descricao10h>\n";
        $xml .= "<descricao10i>" . $descricao10i . "</descricao10i>\n";
        $xml .= "<descricao10j>" . $descricao10j . "</descricao10j>\n";

        $xml .= "<descricao11a0>" . $descricao11a0 . "</descricao11a0>\n";
        $xml .= "<descricao11b0>" . $descricao11b0 . "</descricao11b0>\n";
        $xml .= "<descricao11d0>" . $descricao11d0 . "</descricao11d0>\n";
        $xml .= "<descricao11a>" . $descricao11a . "</descricao11a>\n";
        $xml .= "<descricao11b>" . $descricao11b . "</descricao11b>\n";
        $xml .= "<descricao11d>" . $descricao11d . "</descricao11d>\n";
        $xml .= "<descricao12a>" . $descricao12a . "</descricao12a>\n";
        $xml .= "<descricao12b>" . $descricao12b . "</descricao12b>\n";
        $xml .= "<descricao12d>" . $descricao12d . "</descricao12d>\n";
        $xml .= "<descricao14a>" . $descricao14a . "</descricao14a>\n";
        $xml .= "<descricao14b>" . $descricao14b . "</descricao14b>\n";
        $xml .= "<descricao14d>" . $descricao14d . "</descricao14d>\n";

        $xml .= "<descricaon>" . $descricaon . "</descricaon>\n";
        $xml .= "<descricaoo>" . $descricaoo . "</descricaoo>\n";
        $xml .= "<descricaop>" . $descricaop . "</descricaop>\n";

        $xml .= "<descricaon2>" . $descricaon2 . "</descricaon2>\n";
        $xml .= "<descricaoo2>" . $descricaoo2 . "</descricaoo2>\n";
        $xml .= "<descricaop2>" . $descricaop2 . "</descricaop2>\n";

        $xml .= "<descricaon3>" . $descricaon3 . "</descricaon3>\n";
        $xml .= "<descricaoo3>" . $descricaoo3 . "</descricaoo3>\n";
        $xml .= "<descricaop3>" . $descricaop3 . "</descricaop3>\n";

        $xml .= "<descricaoq>" . $descricaoq . "</descricaoq>\n";
        $xml .= "<descricaor>" . $descricaor . "</descricaor>\n";

        $xml .= "<receitaDataConsulta>" . $receitaDataConsulta . "</receitaDataConsulta>\n";
        $xml .= "<sintegraDataConsulta>" . $sintegraDataConsulta . "</sintegraDataConsulta>\n";
        $xml .= "<clireceitaRazao>" . $clireceitaRazao . "</clireceitaRazao>\n";
        $xml .= "<clisintegraRazao>" . $clisintegraRazao . "</clisintegraRazao>\n";

        $xml .= "<clireceitaidprocessamento>" . $clireceitaidprocessamento . "</clireceitaidprocessamento >\n";
        $xml .= "<clisintegraidprocessamento>" . $clisintegraidprocessamento . "</clisintegraidprocessamento>\n";

        $xml .= "<des1>" . $des1 . "</des1>\n";
        $xml .= "<des2>" . $des2 . "</des2>\n";
        $xml .= "<des3>" . $des3 . "</des3>\n";
        $xml .= "<des4>" . $des4 . "</des4>\n";
        $xml .= "<des5>" . $des5 . "</des5>\n";
        $xml .= "<des6>" . $des6 . "</des6>\n";
        $xml .= "<des7>" . $des7 . "</des7>\n";
        $xml .= "<des8>" . $des8 . "</des8>\n";
        $xml .= "<des9>" . $des9 . "</des9>\n";
        $xml .= "<des10>" . $des10 . "</des10>\n";
        $xml .= "<des11>" . $des11 . "</des11>\n";
        $xml .= "<des12>" . $des12 . "</des12>\n";
        $xml .= "<des13>" . $des13 . "</des13>\n";
        $xml .= "<des14>" . $des14 . "</des14>\n";
        $xml .= "<des15>" . $des15 . "</des15>\n";
        $xml .= "<des16>" . $des16 . "</des16>\n";
        $xml .= "<des17>" . $des17 . "</des17>\n";
        $xml .= "<des18>" . $des18 . "</des18>\n";

        $xml .= "<clifpagto>" . $clifpagto . "</clifpagto>\n";
        $xml .= "<clicanal>" . $clicanal . "</clicanal>\n";

        $xml .= "<clilimite>" . number_format($clilimite, 2, '.', '') . "</clilimite>\n";
        $xml .= "<climodo>" . $climodo . "</climodo>\n";
        $xml .= "<clifat>" . $clifat . "</clifat>\n";
        $xml .= "<clifin>" . $clifin . "</clifin>\n";

        $xml .= "<vencodigo>" . $vencodigo . "</vencodigo>\n";

        $xml .= "<cliinc>" . $cliinc . "</cliinc>\n";
        $xml .= "<cliserasa>" . $cliserasa . "</cliserasa>\n";
//		$xml .= "<cliserasainc>" . $cliserasainc . "</cliserasainc>\n";
        //$xml .= "<cliserasaalt>".$cliserasaalt."</cliserasaalt>\n";
        $xml .= "<cliserasaexp>" . $cliserasaexp . "</cliserasaexp>\n";
        $xml .= "<clisintegrainc>" . $clisintegrainc . "</clisintegrainc>\n";
        $xml .= "<clisintegraalt>" . $clisintegraalt . "</clisintegraalt>\n";
        $xml .= "<clisintegraexp>" . $clisintegraexp . "</clisintegraexp>\n";

        $xml .= "<serasaatual>" . $serasaatual . "</serasaatual>\n";
        $xml .= "<sintegraaatual>" . $sintegraaatual . "</sintegraaatual>\n";
        $xml .= "<sintegrahabilitado>" . $sintegrahabilitado . "</sintegrahabilitado>\n";
        $xml .= "<sintegrarestricoes>" . $sintegrarestricoes . "</sintegrarestricoes>\n";

        $xml .= "<ultimacompra>" . $ultimacompra . "</ultimacompra>\n";

        $xml .= "<vendedor1>" . $vendedor1 . "</vendedor1>\n";
        $xml .= "<vendedor2>" . $vendedor2 . "</vendedor2>\n";

        $xml .= "<total>" . $total . "</total>\n";

        $xml .= "<clitipo>" . $clitipo . "</clitipo>\n";

        if ($clifundacao != "")
            $clifundacao = substr($clifundacao, 8, 2) . '/' . substr($clifundacao, 5, 2) . '/' . substr($clifundacao, 0, 4);
        else
            $clifundacao = "0";

        if ($cliprotesto != "")
            $cliprotesto = substr($cliprotesto, 8, 2) . '/' . substr($cliprotesto, 5, 2) . '/' . substr($cliprotesto, 0, 4);
        else
            $cliprotesto = "0";

        if ($cliperiodo != "")
            $cliperiodo = substr($cliperiodo, 8, 2) . '/' . substr($cliperiodo, 5, 2) . '/' . substr($cliperiodo, 0, 4);
        else
            $cliperiodo = "0";

        if ($cliperiodo2 != "")
            $cliperiodo2 = substr($cliperiodo2, 8, 2) . '/' . substr($cliperiodo2, 5, 2) . '/' . substr($cliperiodo2, 0, 4);
        else
            $cliperiodo2 = "0";

        if ($clirefindata != "")
            $clirefindata = substr($clirefindata, 8, 2) . '/' . substr($clirefindata, 5, 2) . '/' . substr($clirefindata, 0, 4);
        else
            $clirefindata = "0";

        if ($clirefindata2 != "")
            $clirefindata2 = substr($clirefindata2, 8, 2) . '/' . substr($clirefindata2, 5, 2) . '/' . substr($clirefindata2, 0, 4);
        else
            $clirefindata2 = "0";

        if ($clioutrosdata != "")
            $clioutrosdata = substr($clioutrosdata, 8, 2) . '/' . substr($clioutrosdata, 5, 2) . '/' . substr($clioutrosdata, 0, 4);
        else
            $clioutrosdata = "0";

        if ($clioutrosdata2 != "")
            $clioutrosdata2 = substr($clioutrosdata2, 8, 2) . '/' . substr($clioutrosdata2, 5, 2) . '/' . substr($clioutrosdata2, 0, 4);
        else
            $clioutrosdata2 = "0";

        $xml .= "<clifundacao>" . $clifundacao . "</clifundacao>\n";
        $xml .= "<clipercentual>" . $clipercentual . "</clipercentual>\n";
        $xml .= "<cliprotesto>" . $cliprotesto . "</cliprotesto>\n";
        $xml .= "<clivtot>" . number_format($clivtot, 2, '.', '') . "</clivtot>\n";
        $xml .= "<cliperiodo>" . $cliperiodo . "</cliperiodo>\n";
        $xml .= "<cliperiodo2>" . $cliperiodo2 . "</cliperiodo2>\n";
        $xml .= "<clirefin>" . $clirefin . "</clirefin>\n";
        $xml .= "<clirefindata>" . $clirefindata . "</clirefindata>\n";
        $xml .= "<clirefindata2>" . $clirefindata2 . "</clirefindata2>\n";
        $xml .= "<clioutrosqtde>" . $clioutrosqtde . "</clioutrosqtde>\n";
        $xml .= "<clioutrosdata>" . $clioutrosdata . "</clioutrosdata>\n";
        $xml .= "<clioutrosdata2>" . $clioutrosdata2 . "</clioutrosdata2>\n";
        $xml .= "<clibureau>" . $clibureau . "</clibureau>\n";

        if ($clifcaddata != "") {
            $clifcaddata = substr($clifcaddata, 8, 2) . '/' . substr($clifcaddata, 5, 2) . '/' . substr($clifcaddata, 0, 4);
        } else {
            $clifcaddata = "0";
        }
        if ($clicsocialdata != "") {
            $clicsocialdata = substr($clicsocialdata, 8, 2) . '/' . substr($clicsocialdata, 5, 2) . '/' . substr($clicsocialdata, 0, 4);
        } else {
            $clicsocialdata = "0";
        }
        if ($cliicomdata != "") {
            $cliicomdata = substr($cliicomdata, 8, 2) . '/' . substr($cliicomdata, 5, 2) . '/' . substr($cliicomdata, 0, 4);
        } else {
            $cliicomdata = "0";
        }

        $xml .= "<clifcad>" . $clifcad . "</clifcad>\n";
        $xml .= "<clicsocial>" . $clicsocial . "</clicsocial>\n";
        $xml .= "<cliicom>" . $cliicom . "</cliicom>\n";
        $xml .= "<clifcaddata>" . $clifcaddata . "</clifcaddata>\n";
        $xml .= "<clicsocialdata>" . $clicsocialdata . "</clicsocialdata>\n";
        $xml .= "<cliicomdata>" . $cliicomdata . "</cliicomdata>\n";
        $xml .= "<clivtotref>" . number_format($clivtotref, 2, '.', '') . "</clivtotref>\n";
        $xml .= "<clivtotoutros>" . number_format($clivtotoutros, 2, '.', '') . "</clivtotoutros>\n";
        $xml .= "<altusuario>" . $altusuario . "</altusuario>\n";
        $xml .= "<icfornecedor1>" . $icfornecedor1 . "</icfornecedor1>\n";
        $xml .= "<icfornecedor2>" . $icfornecedor2 . "</icfornecedor2>\n";
        $xml .= "<icfornecedor3>" . $icfornecedor3 . "</icfornecedor3>\n";
        $xml .= "<icfornecedor4>" . $icfornecedor4 . "</icfornecedor4>\n";
        $xml .= "<iccontato1>" . $iccontato1 . "</iccontato1>\n";
        $xml .= "<iccontato2>" . $iccontato2 . "</iccontato2>\n";
        $xml .= "<iccontato3>" . $iccontato3 . "</iccontato3>\n";
        $xml .= "<iccontato4>" . $iccontato4 . "</iccontato4>\n";
        $xml .= "<icfone1>" . $icfone1 . "</icfone1>\n";
        $xml .= "<icfone2>" . $icfone2 . "</icfone2>\n";
        $xml .= "<icfone3>" . $icfone3 . "</icfone3>\n";
        $xml .= "<icfone4>" . $icfone4 . "</icfone4>\n";
        /////////////
        $xml .= "<descricaoib>" . $clicidcodigoibge . "</descricaoib>\n";

        $xml .= "<cleemailxml>" . $cleemailxml . "</cleemailxml>\n";

        $auxestado = substr($clicidcodigoibge, 0, 2);
        $auxcidade = substr($clicidcodigoibge, 2, 5);

        if ($auxestado == null) {
            $auxestado = 0;
        }
        //Busca no nome da cidade do IBGE
        $sql5 = pg_query("Select descricao from cidadesibge where codestado=$auxestado and codcidade like '$auxcidade'");
        $array5 = pg_fetch_object($sql5);

        if ($array5->descricao == "")
            $array5->descricao = "0";

        $xml .= "<cidadeibge>" . $array5->descricao . "</cidadeibge>\n";

        if ($clicidcodigoibge == "") {
            $clicidcodigoibge = 0;
        }
        $xml .= "<clicidcodigoibge>" . $clicidcodigoibge . "</clicidcodigoibge>\n";
        /////////////
        /////////////COB
        if (trim($clicidcodigoibgecob) == "") {
            $clicidcodigoibgecob = "0";
        }
        $xml .= "<descricaoibcob>" . $clicidcodigoibgecob . "</descricaoibcob>\n";

        $auxestado = substr($clicidcodigoibgecob, 0, 2);
        $auxcidade = substr($clicidcodigoibgecob, 2, 5);

        if ($auxestado == null) {
            $auxestado = 0;
        }

        //Busca no nome da cidade do IBGE
        $sql6 = pg_query("Select descricao from cidadesibge where codestado=$auxestado and codcidade like '$auxcidade'");
        $array6 = pg_fetch_object($sql6);

        if (!$array6) {
            $array6 = (object)[];
            $array6->descricao = "0";
        } else {
            if ($array6->descricao == "")
                $array6->descricao = "0";
        }

        $xml .= "<cidadeibgecob>" . $array6->descricao . "</cidadeibgecob>\n";

        if ($clicidcodigoibgecob == "") {
            $clicidcodigoibgecob = 0;
        }
        $xml .= "<clicidcodigoibgecob>" . $clicidcodigoibge . "</clicidcodigoibgecob>\n";
        /////////////
        /////////////	CEE
        if (trim($clicidcodigoibgecee) == "") {
            $clicidcodigoibgecee = "0";
        }
        $xml .= "<descricaoibcee>" . $clicidcodigoibgecee . "</descricaoibcee>\n";

        $auxestado = substr($clicidcodigoibgecee, 0, 2);
        $auxcidade = substr($clicidcodigoibgecee, 2, 5);

        if ($auxestado == null) {
            $auxestado = 0;
        }
        //Busca no nome da cidade do IBGE
        $sql7 = pg_query("Select descricao from cidadesibge where codestado=$auxestado and codcidade like '$auxcidade'");
        $array7 = pg_fetch_object($sql7);
        
        if (!$array7) {
            $array7 = (object)[];
            $array7->descricao = "0";
        } else {
            if ($array7->descricao == "")
                $array7->descricao = "0";
        }

        $xml .= "<cidadeibgecee>" . $array7->descricao . "</cidadeibgecee>\n";

        if ($clicidcodigoibgecee == "") {
            $clicidcodigoibgecee = 0;
        }
        $xml .= "<clicidcodigoibgecee>" . $clicidcodigoibgecee . "</clicidcodigoibgecee>\n";
        /////////////


        $data = substr($lgcdata, 8, 2) . '/' . substr($lgcdata, 5, 2) . '/' . substr($lgcdata, 0, 4);
        $hora = substr($lgcdata, 11, 2) . ':' . substr($lgcdata, 14, 2) . ':' . substr($lgcdata, 17, 2);






        $sql8 = pg_query("select pv.pvnumero,pv.pvemissao,pv.pvtipoped, ven.vencodigo as codigovendedor,ven.vennguerra
                                                from pvenda pv
                                                inner join vendedor ven on pv.vencodigo = ven.vencodigo
                                                inner join clientes cli on pv.clicodigo = cli.clicodigo
                                                where
                                                pv.clicodigo = '$codigo' and pvlibera notnull and pvhora notnull
                                                order by pv.pvemissao desc limit 1");
        $array8 = pg_fetch_object($sql8);

        if (isset($array8->pvnumero) && $array8->pvnumero != "") {
            $xml .= "<pvnumero>" . $array8->pvnumero . "</pvnumero>\n";

            if ($array8->pvemissao != "") {
                $xml .= "<pvemissao>" . $array8->pvemissao . "</pvemissao>\n";
            } else {
                $xml .= "<pvemissao>" . 0 . "</pvemissao>\n";
            }

            if ($array8->pvtipoped != "") {
                $xml .= "<pvtipoped>" . $array8->pvtipoped . "</pvtipoped>\n";
            } else {
                $xml .= "<pvtipoped>" . 0 . "</pvtipoped>\n";
            }

            if ($array8->codigovendedor != "") {
                $xml .= "<codigovendedor>" . $array8->codigovendedor . "</codigovendedor>\n";
            } else {
                $xml .= "<codigovendedor>" . 0 . "</codigovendedor>\n";
            }
            if ($array8->vennguerra != "") {
                $xml .= "<vennguerra>" . $array8->vennguerra . "</vennguerra>\n";
            } else {
                $xml .= "<vennguerra>" . 0 . "</vennguerra>\n";
            }

            $sql9 = pg_query("select
                                                        pviest01,
                                                        pviest02,
                                                        pviest03,
                                                        pviest04,
                                                        pviest05,
                                                        pviest06,
                                                        pviest07,
                                                        pviest08,
                                                        pviest09,
                                                        pviest010,
                                                        pviest011,
                                                        pviest012,
                                                        pviest013,
                                                        pviest014,
                                                        pviest015,
                                                        pviest016,
                                                        pviest017,
                                                        pviest018,
                                                        pviest019,
                                                        pviest020,
                                                        pviest021,
                                                        pviest022,
                                                        pviest023,
                                                        pviest024,
                                                        pviest025,
                                                        pviest026,
                                                        pviest027,
                                                        pviest028,
                                                        pviest029,
                                                        pviest030,
                                                        pviest031,
                                                        pviest032,
                                                        pviest033,
                                                        pviest034,
                                                        pviest035,
                                                        pviest036,
                                                        pviest037,
                                                        pviest038,
                                                        pviest039,
                                                        pviest040,
                                                        pviest041,
                                                        pviest042,
                                                        pviest043,
                                                        pviest044,
                                                        pviest045,
                                                        pviest046,
                                                        pviest047,
                                                        pviest048,
                                                        pviest049,
                                                        pviest050,
                                                        pviest051,
                                                        pviest052,
                                                        pviest053,
                                                        pviest054,
                                                        pviest055,
                                                        pviest056,
                                                        pviest057,
                                                        pviest058,
                                                        pviest059,
                                                        pviest060,
                                                        pviest061,
                                                        pviest062,
                                                        pviest063,
                                                        pviest064,
                                                        pviest065,
                                                        pviest066,
                                                        pviest067,
                                                        pviest068,
                                                        pviest069,
                                                        pviest070,
                                                        pviest071,
                                                        pviest072,
                                                        pviest073,
                                                        pviest074,
                                                        pviest075,
                                                        pviest076,
                                                        pviest077,
                                                        pviest078,
                                                        pviest079,
                                                        pviest080,
                                                        pviest081,
                                                        pviest082,
                                                        pviest083,
                                                        pviest084,
                                                        pviest085,
                                                        pviest086,
                                                        pviest087,
                                                        pviest088,
                                                        pviest089,
                                                        pviest090,
                                                        pviest091,
                                                        pviest092,
                                                        pviest093,
                                                        pviest094,
                                                        pviest095,
                                                        pviest096,
                                                        pviest097,
                                                        pviest098,
                                                        pviest099
                                                        from pvitem where pvnumero = " . $array8->pvnumero . "  limit 1");
            $array9 = pg_fetch_object($sql9);

            $pviest01 = ($array9->pviest01 == "") ? "0" : $array9->pviest01;
            $pviest02 = ($array9->pviest02 == "") ? "0" : $array9->pviest02;
            $pviest03 = ($array9->pviest03 == "") ? "0" : $array9->pviest03;
            $pviest04 = ($array9->pviest04 == "") ? "0" : $array9->pviest04;
            $pviest05 = ($array9->pviest05 == "") ? "0" : $array9->pviest05;
            $pviest06 = ($array9->pviest06 == "") ? "0" : $array9->pviest06;
            $pviest07 = ($array9->pviest07 == "") ? "0" : $array9->pviest07;
            $pviest08 = ($array9->pviest08 == "") ? "0" : $array9->pviest08;
            $pviest09 = ($array9->pviest09 == "") ? "0" : $array9->pviest09;
            $pviest010 = ($array9->pviest010 == "") ? "0" : $array9->pviest010;
            $pviest011 = ($array9->pviest011 == "") ? "0" : $array9->pviest011;
            $pviest012 = ($array9->pviest012 == "") ? "0" : $array9->pviest012;
            $pviest013 = ($array9->pviest013 == "") ? "0" : $array9->pviest013;
            $pviest014 = ($array9->pviest014 == "") ? "0" : $array9->pviest014;
            $pviest015 = ($array9->pviest015 == "") ? "0" : $array9->pviest015;
            $pviest016 = ($array9->pviest016 == "") ? "0" : $array9->pviest016;
            $pviest017 = ($array9->pviest017 == "") ? "0" : $array9->pviest017;
            $pviest018 = ($array9->pviest018 == "") ? "0" : $array9->pviest018;
            $pviest019 = ($array9->pviest019 == "") ? "0" : $array9->pviest019;
            $pviest020 = ($array9->pviest020 == "") ? "0" : $array9->pviest020;
            $pviest021 = ($array9->pviest021 == "") ? "0" : $array9->pviest021;
            $pviest022 = ($array9->pviest022 == "") ? "0" : $array9->pviest022;
            $pviest023 = ($array9->pviest023 == "") ? "0" : $array9->pviest023;
            $pviest024 = ($array9->pviest024 == "") ? "0" : $array9->pviest024;
            $pviest025 = ($array9->pviest025 == "") ? "0" : $array9->pviest025;
            $pviest026 = ($array9->pviest026 == "") ? "0" : $array9->pviest026;
            $pviest027 = ($array9->pviest027 == "") ? "0" : $array9->pviest027;
            $pviest028 = ($array9->pviest028 == "") ? "0" : $array9->pviest028;
            $pviest029 = ($array9->pviest029 == "") ? "0" : $array9->pviest029;
            $pviest030 = ($array9->pviest030 == "") ? "0" : $array9->pviest030;
            $pviest031 = ($array9->pviest031 == "") ? "0" : $array9->pviest031;
            $pviest032 = ($array9->pviest032 == "") ? "0" : $array9->pviest032;
            $pviest033 = ($array9->pviest033 == "") ? "0" : $array9->pviest033;
            $pviest034 = ($array9->pviest034 == "") ? "0" : $array9->pviest034;
            $pviest035 = ($array9->pviest035 == "") ? "0" : $array9->pviest035;
            $pviest036 = ($array9->pviest036 == "") ? "0" : $array9->pviest036;
            $pviest037 = ($array9->pviest037 == "") ? "0" : $array9->pviest037;
            $pviest038 = ($array9->pviest038 == "") ? "0" : $array9->pviest038;
            $pviest039 = ($array9->pviest039 == "") ? "0" : $array9->pviest039;
            $pviest040 = ($array9->pviest040 == "") ? "0" : $array9->pviest040;
            $pviest041 = ($array9->pviest041 == "") ? "0" : $array9->pviest041;
            $pviest042 = ($array9->pviest042 == "") ? "0" : $array9->pviest042;
            $pviest043 = ($array9->pviest043 == "") ? "0" : $array9->pviest043;
            $pviest044 = ($array9->pviest044 == "") ? "0" : $array9->pviest044;
            $pviest045 = ($array9->pviest045 == "") ? "0" : $array9->pviest045;
            $pviest046 = ($array9->pviest046 == "") ? "0" : $array9->pviest046;
            $pviest047 = ($array9->pviest047 == "") ? "0" : $array9->pviest047;
            $pviest048 = ($array9->pviest048 == "") ? "0" : $array9->pviest048;
            $pviest049 = ($array9->pviest049 == "") ? "0" : $array9->pviest049;
            $pviest050 = ($array9->pviest050 == "") ? "0" : $array9->pviest050;
            $pviest051 = ($array9->pviest051 == "") ? "0" : $array9->pviest051;
            $pviest052 = ($array9->pviest052 == "") ? "0" : $array9->pviest052;
            $pviest053 = ($array9->pviest053 == "") ? "0" : $array9->pviest053;
            $pviest054 = ($array9->pviest054 == "") ? "0" : $array9->pviest054;
            $pviest055 = ($array9->pviest055 == "") ? "0" : $array9->pviest055;
            $pviest056 = ($array9->pviest056 == "") ? "0" : $array9->pviest056;
            $pviest057 = ($array9->pviest057 == "") ? "0" : $array9->pviest057;
            $pviest058 = ($array9->pviest058 == "") ? "0" : $array9->pviest058;
            $pviest059 = ($array9->pviest059 == "") ? "0" : $array9->pviest059;
            $pviest060 = ($array9->pviest060 == "") ? "0" : $array9->pviest060;
            $pviest061 = ($array9->pviest061 == "") ? "0" : $array9->pviest061;
            $pviest062 = ($array9->pviest062 == "") ? "0" : $array9->pviest062;
            $pviest063 = ($array9->pviest063 == "") ? "0" : $array9->pviest063;
            $pviest064 = ($array9->pviest064 == "") ? "0" : $array9->pviest064;
            $pviest065 = ($array9->pviest065 == "") ? "0" : $array9->pviest065;
            $pviest066 = ($array9->pviest066 == "") ? "0" : $array9->pviest066;
            $pviest067 = ($array9->pviest067 == "") ? "0" : $array9->pviest067;
            $pviest068 = ($array9->pviest068 == "") ? "0" : $array9->pviest068;
            $pviest069 = ($array9->pviest069 == "") ? "0" : $array9->pviest069;
            $pviest070 = ($array9->pviest070 == "") ? "0" : $array9->pviest070;
            $pviest071 = ($array9->pviest071 == "") ? "0" : $array9->pviest071;
            $pviest072 = ($array9->pviest072 == "") ? "0" : $array9->pviest072;
            $pviest073 = ($array9->pviest073 == "") ? "0" : $array9->pviest073;
            $pviest074 = ($array9->pviest074 == "") ? "0" : $array9->pviest074;
            $pviest075 = ($array9->pviest075 == "") ? "0" : $array9->pviest075;
            $pviest076 = ($array9->pviest076 == "") ? "0" : $array9->pviest076;
            $pviest077 = ($array9->pviest077 == "") ? "0" : $array9->pviest077;
            $pviest078 = ($array9->pviest078 == "") ? "0" : $array9->pviest078;
            $pviest079 = ($array9->pviest079 == "") ? "0" : $array9->pviest079;
            $pviest080 = ($array9->pviest080 == "") ? "0" : $array9->pviest080;
            $pviest081 = ($array9->pviest081 == "") ? "0" : $array9->pviest081;
            $pviest082 = ($array9->pviest082 == "") ? "0" : $array9->pviest082;
            $pviest083 = ($array9->pviest083 == "") ? "0" : $array9->pviest083;
            $pviest084 = ($array9->pviest084 == "") ? "0" : $array9->pviest084;
            $pviest085 = ($array9->pviest085 == "") ? "0" : $array9->pviest085;
            $pviest086 = ($array9->pviest086 == "") ? "0" : $array9->pviest086;
            $pviest087 = ($array9->pviest087 == "") ? "0" : $array9->pviest087;
            $pviest088 = ($array9->pviest088 == "") ? "0" : $array9->pviest088;
            $pviest089 = ($array9->pviest089 == "") ? "0" : $array9->pviest089;
            $pviest090 = ($array9->pviest090 == "") ? "0" : $array9->pviest090;
            $pviest091 = ($array9->pviest091 == "") ? "0" : $array9->pviest091;
            $pviest092 = ($array9->pviest092 == "") ? "0" : $array9->pviest092;
            $pviest093 = ($array9->pviest093 == "") ? "0" : $array9->pviest093;
            $pviest094 = ($array9->pviest094 == "") ? "0" : $array9->pviest094;
            $pviest095 = ($array9->pviest095 == "") ? "0" : $array9->pviest095;
            $pviest096 = ($array9->pviest096 == "") ? "0" : $array9->pviest096;
            $pviest097 = ($array9->pviest097 == "") ? "0" : $array9->pviest097;
            $pviest098 = ($array9->pviest098 == "") ? "0" : $array9->pviest098;
            $pviest099 = ($array9->pviest099 == "") ? "0" : $array9->pviest099;

            $xml .= "<pviest01>" . $pviest01 . "</pviest01>\n";
            $xml .= "<pviest02>" . $pviest02 . "</pviest02>\n";
            $xml .= "<pviest03>" . $pviest03 . "</pviest03>\n";
            $xml .= "<pviest04>" . $pviest04 . "</pviest04>\n";
            $xml .= "<pviest05>" . $pviest05 . "</pviest05>\n";
            $xml .= "<pviest06>" . $pviest06 . "</pviest06>\n";
            $xml .= "<pviest07>" . $pviest07 . "</pviest07>\n";
            $xml .= "<pviest08>" . $pviest08 . "</pviest08>\n";
            $xml .= "<pviest09>" . $pviest09 . "</pviest09>\n";
            $xml .= "<pviest010>" . $pviest010 . "</pviest010>\n";
            $xml .= "<pviest011>" . $pviest011 . "</pviest011>\n";
            $xml .= "<pviest012>" . $pviest012 . "</pviest012>\n";
            $xml .= "<pviest013>" . $pviest013 . "</pviest013>\n";
            $xml .= "<pviest014>" . $pviest014 . "</pviest014>\n";
            $xml .= "<pviest015>" . $pviest015 . "</pviest015>\n";
            $xml .= "<pviest016>" . $pviest016 . "</pviest016>\n";
            $xml .= "<pviest017>" . $pviest017 . "</pviest017>\n";
            $xml .= "<pviest018>" . $pviest018 . "</pviest018>\n";
            $xml .= "<pviest019>" . $pviest019 . "</pviest019>\n";
            $xml .= "<pviest020>" . $pviest020 . "</pviest020>\n";
            $xml .= "<pviest021>" . $pviest021 . "</pviest021>\n";
            $xml .= "<pviest022>" . $pviest022 . "</pviest022>\n";
            $xml .= "<pviest023>" . $pviest023 . "</pviest023>\n";
            $xml .= "<pviest024>" . $pviest024 . "</pviest024>\n";
            $xml .= "<pviest025>" . $pviest025 . "</pviest025>\n";
            $xml .= "<pviest026>" . $pviest026 . "</pviest026>\n";
            $xml .= "<pviest027>" . $pviest027 . "</pviest027>\n";
            $xml .= "<pviest028>" . $pviest028 . "</pviest028>\n";
            $xml .= "<pviest029>" . $pviest029 . "</pviest029>\n";
            $xml .= "<pviest030>" . $pviest030 . "</pviest030>\n";
            $xml .= "<pviest031>" . $pviest031 . "</pviest031>\n";
            $xml .= "<pviest032>" . $pviest032 . "</pviest032>\n";
            $xml .= "<pviest033>" . $pviest033 . "</pviest033>\n";
            $xml .= "<pviest034>" . $pviest034 . "</pviest034>\n";
            $xml .= "<pviest035>" . $pviest035 . "</pviest035>\n";
            $xml .= "<pviest036>" . $pviest036 . "</pviest036>\n";
            $xml .= "<pviest037>" . $pviest037 . "</pviest037>\n";
            $xml .= "<pviest038>" . $pviest038 . "</pviest038>\n";
            $xml .= "<pviest039>" . $pviest039 . "</pviest039>\n";
            $xml .= "<pviest040>" . $pviest040 . "</pviest040>\n";
            $xml .= "<pviest041>" . $pviest041 . "</pviest041>\n";
            $xml .= "<pviest042>" . $pviest042 . "</pviest042>\n";
            $xml .= "<pviest043>" . $pviest043 . "</pviest043>\n";
            $xml .= "<pviest044>" . $pviest044 . "</pviest044>\n";
            $xml .= "<pviest045>" . $pviest045 . "</pviest045>\n";
            $xml .= "<pviest046>" . $pviest046 . "</pviest046>\n";
            $xml .= "<pviest047>" . $pviest047 . "</pviest047>\n";
            $xml .= "<pviest048>" . $pviest048 . "</pviest048>\n";
            $xml .= "<pviest049>" . $pviest049 . "</pviest049>\n";
            $xml .= "<pviest050>" . $pviest050 . "</pviest050>\n";
            $xml .= "<pviest051>" . $pviest051 . "</pviest051>\n";
            $xml .= "<pviest052>" . $pviest052 . "</pviest052>\n";
            $xml .= "<pviest053>" . $pviest053 . "</pviest053>\n";
            $xml .= "<pviest054>" . $pviest054 . "</pviest054>\n";
            $xml .= "<pviest055>" . $pviest055 . "</pviest055>\n";
            $xml .= "<pviest056>" . $pviest056 . "</pviest056>\n";
            $xml .= "<pviest057>" . $pviest057 . "</pviest057>\n";
            $xml .= "<pviest058>" . $pviest058 . "</pviest058>\n";
            $xml .= "<pviest059>" . $pviest059 . "</pviest059>\n";
            $xml .= "<pviest060>" . $pviest060 . "</pviest060>\n";
            $xml .= "<pviest061>" . $pviest061 . "</pviest061>\n";
            $xml .= "<pviest062>" . $pviest062 . "</pviest062>\n";
            $xml .= "<pviest063>" . $pviest063 . "</pviest063>\n";
            $xml .= "<pviest064>" . $pviest064 . "</pviest064>\n";
            $xml .= "<pviest065>" . $pviest065 . "</pviest065>\n";
            $xml .= "<pviest066>" . $pviest066 . "</pviest066>\n";
            $xml .= "<pviest067>" . $pviest067 . "</pviest067>\n";
            $xml .= "<pviest068>" . $pviest068 . "</pviest068>\n";
            $xml .= "<pviest069>" . $pviest069 . "</pviest069>\n";
            $xml .= "<pviest070>" . $pviest070 . "</pviest070>\n";
            $xml .= "<pviest071>" . $pviest071 . "</pviest071>\n";
            $xml .= "<pviest072>" . $pviest072 . "</pviest072>\n";
            $xml .= "<pviest073>" . $pviest073 . "</pviest073>\n";
            $xml .= "<pviest074>" . $pviest074 . "</pviest074>\n";
            $xml .= "<pviest075>" . $pviest075 . "</pviest075>\n";
            $xml .= "<pviest076>" . $pviest076 . "</pviest076>\n";
            $xml .= "<pviest077>" . $pviest077 . "</pviest077>\n";
            $xml .= "<pviest078>" . $pviest078 . "</pviest078>\n";
            $xml .= "<pviest079>" . $pviest079 . "</pviest079>\n";
            $xml .= "<pviest080>" . $pviest080 . "</pviest080>\n";
            $xml .= "<pviest081>" . $pviest081 . "</pviest081>\n";
            $xml .= "<pviest082>" . $pviest082 . "</pviest082>\n";
            $xml .= "<pviest083>" . $pviest083 . "</pviest083>\n";
            $xml .= "<pviest084>" . $pviest084 . "</pviest084>\n";
            $xml .= "<pviest085>" . $pviest085 . "</pviest085>\n";
            $xml .= "<pviest086>" . $pviest086 . "</pviest086>\n";
            $xml .= "<pviest087>" . $pviest087 . "</pviest087>\n";
            $xml .= "<pviest088>" . $pviest088 . "</pviest088>\n";
            $xml .= "<pviest089>" . $pviest089 . "</pviest089>\n";
            $xml .= "<pviest090>" . $pviest090 . "</pviest090>\n";
            $xml .= "<pviest091>" . $pviest091 . "</pviest091>\n";
            $xml .= "<pviest092>" . $pviest092 . "</pviest092>\n";
            $xml .= "<pviest093>" . $pviest093 . "</pviest093>\n";
            $xml .= "<pviest094>" . $pviest094 . "</pviest094>\n";
            $xml .= "<pviest095>" . $pviest095 . "</pviest095>\n";
            $xml .= "<pviest096>" . $pviest096 . "</pviest096>\n";
            $xml .= "<pviest097>" . $pviest097 . "</pviest097>\n";
            $xml .= "<pviest098>" . $pviest098 . "</pviest098>\n";
            $xml .= "<pviest099>" . $pviest099 . "</pviest099>\n";
        }


        $xml .= "<usunome>" . $usunome . "</usunome>\n";
        $xml .= "<usulogin>" . $usulogin . "</usulogin>\n";
        $xml .= "<lgcdata>" . $data . " as " . $hora . "</lgcdata>\n";
        $xml .= "<lgclimite>" . number_format($lgclimite, 2, '.', '') . "</lgclimite>\n";
        $xml .= "<potencialdecompra>" . number_format($potencialdecompra, 2, '.', '') . "</potencialdecompra>\n";
        $xml .= "<limiteproposto>" . number_format($limiteproposto, 2, '.', '') . "</limiteproposto>\n";

        $xml .= "<clidatavalida>" . $clidatavalida . "</clidatavalida>\n";
        $xml .= "<usuvalida>" . $usuvalida . "</usuvalida>\n";

        $xml .= "<lgcnovo>" . number_format($lgcnovo, 2, '.', '') . "</lgcnovo>\n";
        $xml .= "<razaocnpj>" . $razaocnpj . "</razaocnpj>\n";
        $xml .= "<parametro2>" . $parametro2 . "</parametro2>\n";

        $xml .= "<receitaNumero>" . $receitaNumero . "</receitaNumero>\n";
        $xml .= "<receitaComplemento>" . $receitaComplemento . "</receitaComplemento>\n";
        $xml .= "<receitaCep>" . $receitaCep . "</receitaCep>\n";
        $xml .= "<receitaBairro>" . $receitaBairro . "</receitaBairro>\n";
        $xml .= "<receitaUf>" . $receitaUf . "</receitaUf>\n";
        $xml .= "<receitaLogradouro>" . $receitaLogradouro . "</receitaLogradouro>\n";
        $xml .= "<receitaCidade>" . $receitaCidade . "</receitaCidade>\n";
        $xml .= "<sintegraNumero>" . $sintegraNumero . "</sintegraNumero>\n";
        $xml .= "<sintegraComplemento>" . $sintegraComplemento . "</sintegraComplemento>\n";
        $xml .= "<sintegraCep>" . $sintegraCep . "</sintegraCep>\n";
        $xml .= "<sintegraBairro>" . $sintegraBairro . "</sintegraBairro>\n";
        $xml .= "<sintegraUf>" . $sintegraUf . "</sintegraUf>\n";
        $xml .= "<sintegraLogradouro>" . $sintegraLogradouro . "</sintegraLogradouro>\n";
        $xml .= "<sintegraCidade>" . $sintegraCidade . "</sintegraCidade>\n";
        $xml .= "<portador>" . $portador . "</portador>\n";

        $xml .= "<clist>" . $clist . "</clist>\n";

        $xml .= "<clioptsimples>" . $clioptsimples . "</clioptsimples>\n";
        $xml .= "<cliconsig>" . $cliconsig . "</cliconsig>\n";
        $xml .= "<dataconsimples>" . $dataconsimples . "</dataconsimples>\n";


        if (trim($clioptinativo) == "") {
            $clioptinativo = "1";
        }
        if (trim($datainativo) == "") {
            $datainativo = "0";
        }

        $xml .= "<clioptinativo>" . $clioptinativo . "</clioptinativo>\n";
        $xml .= "<datainativo>" . $datainativo . "</datainativo>\n";

        $xml .= "<clisuframa>" . $clisuframa . "</clisuframa>\n";
        $xml .= "<cliregime>" . $cliregime . "</cliregime>\n";

        $xml .= "</dado>\n";
    } //FECHA FOR


    $xml .= "</dados>\n";
} //FECHA IF (row)
//PRINTA O RESULTADO
echo $xml;
?>