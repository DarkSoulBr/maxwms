// JavaScript Document
function pesquisarOpcoes() {    
    let consulta = document.getElementById('pesquisaOpcao').value;    
    window.open('consultafavoritosnovo.php?pesquisa=' + consulta, '_self');  
}
