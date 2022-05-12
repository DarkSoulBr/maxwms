<?php
$flagmenu = 2;
// Verificador de sessão
require("verifica.php");

$usuario   = $_SESSION["id_usuario"];



?>
<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title Page-->
  <title>Cancelamento de CTe</title>

  <!-- maxnew CSS-->
  <link href="css/max.css" rel="stylesheet" media="all">
</head>

<body>
  <div id="retorno"></div>
  <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>
  <div class="bg-gray p-t-10 font-lucida">
    <div class="wrapper wrapper--w680">
      <div class="card card-4">
        <div class="card-header">
          Cancelamento de CTe
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="row row-space">
              <div class="col-1">
                <div class="input-group m-r-45">
                  <label class="label">Opção</label>
                  <div>
                    <label class="radio-container m-r-15">Número Controle
                      <input type="radio" name="radiobutton" id="radio1" value="radiobutton" checked>
                      <span class="checkmark"></span>
                    </label>
                    <label class="radio-container m-r-15">Número
                      <input type="radio" name="radiobutton" id="radio2" value="radiobutton">
                      <span class="checkmark"></span>
                    </label>
                    <label class="radio-container">Chave
                      <input type="radio" name="radiobutton" id="radio3" value="radiobutton">
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-space">
              <div class="col-2">
                <div class="input-group">
                  <label class="label">Pesquisar</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="pesquisa" type="text" name="pesquisa" size="37" maxlength="30" onKeyPress="maiusculo()" onBlur="convertField(this);">
                  </div>
                </div>
              </div>
              <div class="col-3">
                <div class="input-group">
                  <label class="label">&nbsp;</label>
                  <div class="input-group-icon centraliza">
                    <button class="btn-small btn--radius-2 btn--blue" name="button" type="button" id="button" onClick=dadospesquisa(pesquisa.value)>Pesquisar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-space">
              <div class="col-2">
                <div class="input-group m-r-45">
                  <label class="label">Núm.Controle</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="controle" type="text" name="controle" size="10" disabled>
                  </div>
                </div>
              </div>
              <div class="col-2">
                <div class="input-group m-r-45">
                  <label class="label">Número</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="numero" type="text" name="numero" size="10" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-space">
              <div class="col-1">
                <div class="input-group m-r-15">
                  <label class="label">Chave</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="chave" type="text" name="chave" size="50" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-space">
              <div class="col-1">
                <div class="input-group m-r-15">
                  <label class="label">Nº protocolo</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="protocolo" type="text" name="protocolo" size="50" maxlength="15" onKeyPress="maiusculo()" onBlur="convertField(this);">
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-space">
              <div class="col-1">
                <div class="input-group m-r-15">
                  <label class="label">Motivo Canc.</label>
                  <div class="input-group-icon">
                    <input class="input--style-4" id="motivo" type="text" name="motivo" size="50" maxlength="50" onKeyPress="maiusculo()" onBlur="convertField(this);">
                  </div>
                </div>
              </div>
            </div>
            <div class="p-t-15 centraliza">
              <button class="btn btn--radius-2 btn--blue" type="button" id="botao3" onClick=env("<? echo $usuario ?>")>Confirma</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <input id="ctecodigo" type="hidden" name="ctecodigo" size="10">


  <script src="js/cancelamentocte.js"></script>
  <script src="js/geral.js"></script>

</body>

</html>