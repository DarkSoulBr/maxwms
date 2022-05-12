<?php
// Conex�o com o banco de dados
require_once("include/conexao.inc.php");

// Inicia sess�es
session_start();

// Recupera o login
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
// Recupera a senha, a criptografando em MD5
$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
//$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : FALSE;


// Usu�rio n�o forneceu a senha ou o login
if(!$login || !$senha)
{

    echo "<center><strong> Voc� deve digitar sua senha e login! </strong></center>";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
    exit;

}

/**
* Executa a consulta no banco de dados.
* Caso o n�mero de linhas retornadas seja 1 o login � v�lido,
* caso 0, inv�lido.
*/
$SQL = "SELECT a.usucodigo as id, a.usunome as nome, a.usulogin as login, a.ususenha as senha,'S' as  acesso
        ,b.acesso01,b.acesso02
        FROM usuarios a
        Left Join acessos b on b.usucodigo = a.usucodigo
        WHERE usulogin = '" . $login . "'";

$result_id = @pg_query($SQL) or die("Erro no banco de dados!");
$total = @pg_num_rows($result_id);

// Caso o usu�rio tenha digitado um login v�lido o n�mero de linhas ser� 1..
if($total)
{
    // Obt�m os dados do usu�rio, para poder verificar a senha e passar os demais dados para a sess�o
    $dados = @pg_fetch_array($result_id);

    // Agora verifica a senha
    if(!strcmp($senha, $dados["senha"]))
    {
        // TUDO OK! Agora, passa os dados para a sess�o e redireciona o usu�rio
        $_SESSION["id_usuario"]   = $dados["id"];
        $_SESSION["nome_usuario"] = stripslashes($dados["nome"]);
        $_SESSION["permissao"]    = $dados["acesso"];
        
        $_SESSION["acesso01"]    = $dados["acesso01"];
        $_SESSION["acesso02"]    = $dados["acesso02"];

        header("Location: dtrade.php");
        exit;
    }
    // Senha inv�lida
    else
    {
        echo "<center><strong> Senha inv�lida! </strong></center>";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
        exit;
    }
}
// Login inv�lido
else
{
    echo "<center><strong> O login fornecido por voc� � inexistente! </strong></center>";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
    exit;
}
?>

