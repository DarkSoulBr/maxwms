<?php

$var = $_GET["var"];


//Transforma em variaveis
$caux = '';		
$naux = 0;

$cEcho = "<chart palette='4' showPercentageValues='1'>";

for($aux=0; $aux<strlen($var); $aux++){
								
	if(substr($var,$aux,1)==';')
	{
		$naux = $naux + 1;
		if($naux==1){
		
			$fim = $caux;
			$caux = '';
			if($fim<>''){	
				$cEcho = $cEcho . "<set label='" . $fim . "'";
			}	
		}
		if($naux==2){
			$ponteiro = $caux;
			$caux = '';
			if($fim<>''){	
				$cEcho = $cEcho . "value='" . $ponteiro . "' color='FF0000' />"    ;
			}	
		}		
		if($naux==3){
			$fim2 = $caux;
			$caux = '';
			if($fim2<>''){	
				$cEcho = $cEcho . "<set label='" . $fim2 . "'";
			}	
		}
		if($naux==4){
			$ponteiro2 = $caux;
			$caux = '';
			if($fim2<>''){	
				$cEcho = $cEcho . "value='" . $ponteiro2 . "' color='006400' />"    ;
			}	
		}						
	}
	else {
		$caux = $caux . substr($var,$aux,1);
	}
}

$ponteiro2 = $caux;

$cEcho = $cEcho . "value='" . $ponteiro2 . "' color='006400' />"    ;


$caux = '';

$cEcho = $cEcho . "</chart>";

echo $cEcho;

/*
echo "
<chart palette='4'>
  <set label='Item A' value='4' /> 
  <set label='Item B' value='5' /> 
  <set label='Item C' value='2' /> 
  <set label='Item D' value='4' /> 
  <set label='Item E' value='5' isSliced='1' /> 
  <set label='Item F' value='5' isSliced='1' /> 
  <set label='Item G' value='4' /> 
  <set label='Item H' value='5' /> 
  <set label='Item I' value='2' /> 
</chart>";
*/

/*
echo "
<chart palette='2' caption='Comparativo Mensal' xAxisName='Datas' yAxisName='Horário' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>
<set label=\"$fim\" value=\"$ponteiro\" color=\"$code\" />
<set label=\"$fim2\" value=\"$ponteiro2\" color=\"$code2\" />
<set label=\"$fim3\" value=\"$ponteiro3\" color=\"$code3\" />
<set label=\"$fim4\" value=\"$ponteiro4\" color=\"$code4\" />
<set label=\"$fim5\" value=\"$ponteiro5\" color=\"$code5\" />
<set label=\"$fim6\" value=\"$ponteiro6\" color=\"$code6\" />
<set label=\"$fim7\" value=\"$ponteiro7\" color=\"$code7\" />
<set label=\"$fim8\" value=\"$ponteiro8\" color=\"$code8\" />
<set label=\"$fim9\" value=\"$ponteiro9\" color=\"$code9\" />
<set label=\"$fim10\" value=\"$ponteiro10\" color=\"$code10\" />
<set label=\"$fim11\" value=\"$ponteiro11\" color=\"$code11\" />
<set label=\"$fim12\" value=\"$ponteiro12\" color=\"$code12\" />
<set label=\"$fim13\" value=\"$ponteiro13\" color=\"$code13\" />
<set label=\"$fim14\" value=\"$ponteiro14\" color=\"$code14\" />
<set label=\"$fim15\" value=\"$ponteiro15\" color=\"$code15\" />
<set label=\"$fim16\" value=\"$ponteiro16\" color=\"$code16\" />
<set label=\"$fim17\" value=\"$ponteiro17\" color=\"$code17\" />
<set label=\"$fim18\" value=\"$ponteiro18\" color=\"$code18\" />
<set label=\"$fim19\" value=\"$ponteiro19\" color=\"$code19\" />
<set label=\"$fim20\" value=\"$ponteiro20\" color=\"$code20\" />
<set label=\"$fim21\" value=\"$ponteiro21\" color=\"$code21\" />
<set label=\"$fim22\" value=\"$ponteiro22\" color=\"$code22\" />
<set label=\"$fim23\" value=\"$ponteiro23\" color=\"$code23\" />
<set label=\"$fim24\" value=\"$ponteiro24\" color=\"$code24\" />
<set label=\"$fim25\" value=\"$ponteiro25\" color=\"$code25\" />
<set label=\"$fim26\" value=\"$ponteiro26\" color=\"$code26\" />
<set label=\"$fim27\" value=\"$ponteiro27\" color=\"$code27\" />
<set label=\"$fim28\" value=\"$ponteiro28\" color=\"$code28\" />
<set label=\"$fim29\" value=\"$ponteiro29\" color=\"$code29\" />
<set label=\"$fim30\" value=\"$ponteiro30\" color=\"$code30\" />

</chart>";
*/

?>