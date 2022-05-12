<?php
// Conexão com o banco de dados
require_once("include/conexao.inc.php");

// Inicia sessões
session_start();

// Recupera o login
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
// Recupera a senha, a criptografando em MD5
$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
//$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : FALSE;


// Usuário não forneceu a senha ou o login
if(!$login || !$senha)
{

    echo "<center><strong> Você deve digitar sua senha e login! </strong></center>";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
    exit;

}

/**
* Executa a consulta no banco de dados.
* Caso o número de linhas retornadas seja 1 o login é válido,
* caso 0, inválido.
*/
$SQL = "SELECT a.usucodigo as id, a.usunome as nome, a.usulogin as login, a.ususenha as senha,'S' as  acesso
        ,b.acesso01,b.acesso02
        FROM usuarios a
        Left Join acessos b on b.usucodigo = a.usucodigo
        WHERE usulogin = '" . $login . "'";

$result_id = @pg_query($SQL) or die("Erro no banco de dados!");
$total = @pg_num_rows($result_id);

// Caso o usuário tenha digitado um login válido o número de linhas será 1..
if($total)
{
    // Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão
    $dados = @pg_fetch_array($result_id);

    // Agora verifica a senha
    if(!strcmp($senha, $dados["senha"]))
    {
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
        $_SESSION["id_usuario"]   = $dados["id"];
        $_SESSION["nome_usuario"] = stripslashes($dados["nome"]);
        $_SESSION["permissao"]    = $dados["acesso"];
        
        $_SESSION["acesso01"]    = $dados["acesso01"];
        $_SESSION["acesso02"]    = $dados["acesso02"];

        header("Location: dtrade.php");
        exit;
    }
    // Senha inválida
    else
    {
        echo "<center><strong> Senha inválida! </strong></center>";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
        exit;
    }
}
// Login inválido
else
{
    echo "<center><strong> O login fornecido por você é inexistente! </strong></center>";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
    exit;
}
?>

