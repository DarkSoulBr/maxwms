<?php
// Verificador de sessão
require("verifica2.php");
session_destroy();
echo "<center><strong> Sessao Encerrada </strong></center>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=login.html'>";
exit;
?>
