<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description"
          content="Profsa Informática - Raphael C. Figueira - Apuração Gerencial de Vendas de Varejo - NIelsen" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="icon" href="https://www.figueiracosta.com.br/wp-content/uploads/2017/09/cropped-favicon-32x32.png"
          sizes="32x32" />
     <link rel="icon" href="https://www.figueiracosta.com.br/wp-content/uploads/2017/09/cropped-favicon-192x192.png"
          sizes="192x192" />
     <link rel="apple-touch-icon-precomposed"
          href="https://www.figueiracosta.com.br/wp-content/uploads/2017/09/cropped-favicon-180x180.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link href="css/pallas40.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Controle Gerencial de Apuração e Análise de Vendas - Menu</title>
</head>

<script>
$(document).ready(function() {

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

     $('#cli_carrega').bind("click", function() {
          $('#cli_janela').click();
     });
     $('#cli_janela').change(function() {
          var path = $('#cli_janela').val();
          $('#arq_a').val(path);
     });

     $('#pre_carrega').bind("click", function() {
          $('#pre_janela').click();
     });
     $('#pre_janela').change(function() {
          var path = $('#pre_janela').val();
          $('#arq_b').val(path);
     });

     $('#var_carrega').bind("click", function() {
          $('#var_janela').click();
     });
     $('#var_janela').change(function() {
          var path = $('#var_janela').val();
          $('#arq_c').val(path);
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $err_t = array();
     $ret = 0; $nro = 0; $err_n = 0;
     include_once "dados.php";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     $_SESSION['wrkcodreg'] = getmypid();
     if ($_SESSION['wrktipusu'] < 0) {
          echo '<script>alert("Nível de usuário não permite manutenção em parâmetros");</script>';
          echo '<script>history.go(-1);</script>';
     }     
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10, "Entrada na página de processamento de planilhas Pallas.40 - Figueira Costa");  
          }
     }
     if (isset($_SESSION['wrknumerr']) == false) { $_SESSION['wrknumerr'] = 0; }
     if (isset($_SESSION['wrkparpro']) == false) { $_SESSION['wrkparpro'] = array(); }
     $fat_a = (isset($_REQUEST['fat_a']) == false ? ''  : $_REQUEST['fat_a']);
     $mar_a = (isset($_REQUEST['mar_a']) == false ? ''  : $_REQUEST['mar_a']);
     $vol_a = (isset($_REQUEST['vol_a']) == false ? '' : $_REQUEST['vol_a']);
     $fat_b = (isset($_REQUEST['fat_b']) == false ? ''  : $_REQUEST['fat_b']);
     $mar_b = (isset($_REQUEST['mar_b']) == false ? ''  : $_REQUEST['mar_b']);
     $vol_b = (isset($_REQUEST['vol_b']) == false ? '' : $_REQUEST['vol_b']);
     $fat_c = (isset($_REQUEST['fat_c']) == false ? ''  : $_REQUEST['fat_c']);
     $mar_c = (isset($_REQUEST['mar_c']) == false ? ''  : $_REQUEST['mar_c']);
     $vol_c = (isset($_REQUEST['vol_c']) == false ? '' : $_REQUEST['vol_c']);

     if (file_exists('nielsen.xml') == false) {
          echo "Arquivo com parâmetros básicos do sistema não encontrado [nielsen.xml] !"; 
     } else {
          $xml = simplexml_load_file('nielsen.xml') or die ("Erro: Parâmetros não encontrado para carregar");
          $fat_a = (string) $xml->parametro->variavel_fat;
          $fat_b = (string) $xml->parametro->variavel_mar;
          $fat_c = (string) $xml->parametro->variavel_vol;
          $mar_a = (string) $xml->parametro->margem_fat;
          $mar_b = (string) $xml->parametro->margem_mar;
          $mar_c = (string) $xml->parametro->margem_vol;
          $vol_a = (string) $xml->parametro->volume_fat;
          $vol_b = (string) $xml->parametro->volume_mar;
          $vol_c = (string) $xml->parametro->volume_vol;
          $_SESSION['wrkparpro']['fat_a'] = $fat_a; $_SESSION['wrkparpro']['fat_b'] = $fat_b; $_SESSION['wrkparpro']['fat_c'] = $fat_c;
          $_SESSION['wrkparpro']['mar_a'] = $mar_a; $_SESSION['wrkparpro']['mar_b'] = $mar_b; $_SESSION['wrkparpro']['mar_c'] = $mar_c;
          $_SESSION['wrkparpro']['vol_a'] = $vol_a; $_SESSION['wrkparpro']['vol_b'] = $vol_b; $_SESSION['wrkparpro']['vol_c'] = $vol_c;
     }
     if (isset($_REQUEST['sub']) == true) { 
          if (isset($_FILES['arq_cli']) == true) {
               $cli = upload_doc(0, $_SESSION['wrkcodreg'], $_FILES, $cam, $tip, $ext);
               $_SESSION['wrkparpro']['opc_c'] = $cli;
               $_SESSION['wrkparpro']['cam_c'] = $cam;
          }
          if (isset($_FILES['arq_pre']) == true) {
               $pre = upload_doc(1, $_SESSION['wrkcodreg'], $_FILES, $cam, $tip, $ext);
               $_SESSION['wrkparpro']['opc_p'] = $pre;
               $_SESSION['wrkparpro']['cam_p'] = $cam;
          }
          if (isset($_FILES['arq_var']) == true) {
               $var = upload_doc(2, $_SESSION['wrkcodreg'], $_FILES, $cam, $tip, $ext);
               $_SESSION['wrkparpro']['opc_v'] = $var;
               $_SESSION['wrkparpro']['cam_v'] = $cam;
          }
     }
     if (isset($_REQUEST['pro']) == true) { 
          $nro = 0; $_SESSION['wrknumerr'] = 0;
          if (isset($_SESSION['wrkparpro']['opc_c']) == true) { $nro = $nro + 1; }
          if (isset($_SESSION['wrkparpro']['opc_p']) == true) { $nro = $nro + 2; }
          if (isset($_SESSION['wrkparpro']['opc_v']) == true) { $nro = $nro + 3; }
          if ($nro != 6) {
               echo '<script>alert("Falta arquivo de informações (.csv) para ser feito UpLoad");</script>';
          } else {
               $err_n = validar_dad($err_t); $_SESSION['wrknumerr'] = $err_n;
          }
     }
     if (isset($_REQUEST['dow']) == true) { 

     }
?>

<body id="box00">
     <h1 class="cab-0">Menu Figueira Costa - Controle Gerencial de Apuração e Análise de Vendas - Profsa Informática
     </h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row">
                    <div class="qua-2 col-md-12 text-left">
                         <span>Processamentos de Dados</span>
                    </div>
               </div>
               <form name="frmTelPro" action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                         <div class="col-md-8">
                              <label>Dados do Cliente</label>
                              <input type="text" class="form-control" maxlength="150" id="arq_a" name="arq_a" value=""
                                   disabled />
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <button type="button" class="bot-2" name="cli_carrega" id="cli_carrega"
                                   title="Abre janela para carregar arquivo com dados do cliente."><i
                                        class="fa fa-upload fa-2x" aria-hidden="true"></i> <strong>Localizar</strong> </button>
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <a href="Template-Cl.csv"  id="dow_carrega" title="Efetua Download de um Template (Môdelo) do arquivo de dados do cliente.">
                                   <i class="fa fa-download fa-2x" aria-hidden="true"></i> <strong>Template</strong> </a>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-8">
                              <label>Nielsen Preços</label>
                              <input type="text" class="form-control" maxlength="150" id="arq_b" name="arq_b" value=""
                                   disabled />
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <button type="button" class="bot-2" name="pre_carrega" id="pre_carrega"
                                   title="Abre janela para carregar arquivo com parâmetros de Nielsen preços do cliente."><i
                                        class="fa fa-upload fa-2x" aria-hidden="true"></i> <strong>Localizar</strong> </button>
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <a href="Template-Pr.csv" id="pre_download"
                                   title="Efetua Download de um Template (Môdelo) do arquivo Nielsen de preços de dados do cliente."><i
                                        class="fa fa-download fa-2x" aria-hidden="true"></i> <strong>Template</strong> </a>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-8">
                              <label>Nielsen Variações</label>
                              <input type="text" class="form-control" maxlength="150" id="arq_c" name="arq_c" value=""
                                   disabled />
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <button type="button" class="bot-2" name="var_carrega" id="var_carrega"
                                   title="Abre janela para carregar arquivo com parâmetros de Nielsen de variações de dados do cliente."><i
                                        class="fa fa-upload fa-2x" aria-hidden="true"></i> <strong>Localizar</strong> </button>
                         </div>
                         <div class="col-md-2 text-center"><br />
                              <a href="Template-Va.csv" id="var_download"
                                   title="Efetua Download de um Template (Môdelo) com parâmetros de Nielsen preços arquivo de dados."><i
                                        class="fa fa-download fa-2x" aria-hidden="true"></i> <strong>Template</strong> </a>
                         </div>
                    </div>
                    <br /><hr /><br />       
                    <div class="row">
                         <div class="col-md-4">
                              <span><strong>Ponderação Variável</strong></span><br />
                         </div>
                         <div class="col-md-4">
                              <span><strong>Formatação Condicional de Preço</strong></span>
                         </div>
                         <div class="col-md-4">
                              <span><strong>Formatação Condicional de Percentual</strong></span>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-2">
                              <span>Faturamento %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="fat_a" name="fat_a" value="<?php echo $fat_a; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Faturamento %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="fat_b" name="fat_b" value="<?php echo $fat_b; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Faturamento %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="fat_c" name="fat_c" value="<?php echo $fat_c; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-2">
                              <span>Margem %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="mar_a" name="mar_a" value="<?php echo $mar_a; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Margem %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="mar_b" name="mar_b" value="<?php echo $mar_b; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Margem %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="mar_c" name="mar_c" value="<?php echo $mar_c; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-2">
                              <span>Volume %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="vol_a" name="vol_a" value="<?php echo $vol_a; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Volume %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="vol_b" name="vol_b" value="<?php echo $vol_b; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <span>Volume %: </span>
                              <input type="text" class="form-control text-center" maxlength="6" id="vol_c" name="vol_c" value="<?php echo $vol_c; ?>" disabled />
                         </div>
                         <div class="col-md-2"></div>
                    </div>

                    <br /><hr /><br />       
                    <?php
                         if ($err_n > 0) {
                              $txt = '<table class="table table-sm">
                                   <thead class="thead-dark">
                                        <tr>
                                             <th>Número</th>
                                             <th>Descrição do Erro Ocorrido no Processamento</th>
                                        </tr>
                                   </thead>
                                   <tbody>';
                              for ($ind = 0; $ind < $err_n ; $ind++) {
                                   $txt .=  '<tr>';
                                   $txt .= '<td>' . ($ind + 1) . '</td>';
                                   $txt .= '<td>' . $err_t[$ind] . '</td>';
                                   $txt .=  '</tr>';
                              }                          
                              $txt .= '</tbody>
                              </table>';
                              echo $txt;
                              echo '<hr /><br />';       
                         }
                    ?>

                    <div class="row text-center">
                         <div class="col-md-3"></div>
                         <div class="col-md-2">
                              <button type="submit" name="sub" class="bot-1">Upload</button>
                         </div>
                         <div class="col-md-2">
                              <button type="submit" name="pro" class="bot-1">Processar</button>
                         </div>
                         <div class="col-md-2">
                              <button type="submit" name="dow" class="bot-1">Download</button>
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <br />
                    <input name="arq_cli" type="file" id="cli_janela" class="bot-3" accept=".csv, .CSV" />
                    <input name="arq_pre" type="file" id="pre_janela" class="bot-3" accept=".csv, .CSV" />
                    <input name="arq_var" type="file" id="var_janela" class="bot-3" accept=".csv, .CSV" />
               </form>
          </div>
          <br /><br />
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php

function upload_doc ($tpo, $nro, $fil , &$cam, &$tip, &$ext) {
     $sta =0; $des = null;
     if ($tpo == 0) { $arq = (isset($fil['arq_cli']) ? $fil['arq_cli'] : false); }
     if ($tpo == 1) { $arq = (isset($fil['arq_pre']) ? $fil['arq_pre'] : false); }
     if ($tpo == 2) { $arq = (isset($fil['arq_var']) ? $fil['arq_var'] : false); }
     if ($arq == false) {
         return 1;
     } else if ($arq['name'] == "") {
         return 2;
     }            
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     if ($arq['error'] != 0) {
         echo "<script>alert(" . $erro[$arq['error']] . "')</script>";
         return 3; 
     }
     if ($sta == 0) {
         $tip = array('csv', 'CSV');
         $nom = $arq['name'];
         $des = limpa_cpo($arq['name']);
         $tam = $arq['size'];
         $fim = explode('.', $des);
         $ext = end($fim);
         if (array_search($ext, $tip) === false) {
              echo "<script>alert('Extensão de arquivo de boleto informado deve ser .csv')</script>";
              $sta = 4; 
         }
     }
     if ($sta == 0) {
         $tip = explode('.', $des);
         $des = $tip[0] . "." . $ext;
         $pas = "doctos"; 
         if (file_exists($pas) == false) { mkdir($pas);  }

         if ($tpo == 0) { $cam = $pas . "/" . 'Cli_' . str_pad($nro, 6, "0", STR_PAD_LEFT) . "_" . '000' . "." . $ext; }
         if ($tpo == 1) { $cam = $pas . "/" . 'Pre_' . str_pad($nro, 6, "0", STR_PAD_LEFT) . "_" . '000' . "." . $ext; }
         if ($tpo == 2) { $cam = $pas . "/" . 'Var_' . str_pad($nro, 6, "0", STR_PAD_LEFT) . "_" . '000' . "." . $ext; }

         $ret = move_uploaded_file($arq['tmp_name'], $cam);
         if ($ret == false) {
              echo "<script>alert('Erro na cópia do arquivo informado para upload')</script>";
              $sta = 5; 
         } else {
             $sta = gravar_log(20 + $tpo,"UpLoad de planilha de clientes - movimento Nome: " . $nom . " Tamanho: " . $tam);
         }      
     }    
     return $des;
 }

 function validar_dad(&$err) {
     $ord = 0; $nro = 0; $err = array();
     $dad = fopen($_SESSION['wrkparpro']['cam_c'], "r");  
     while (!feof ($dad)) {
          $ord = $ord + 1;
          $lin = explode(";", fgets($dad));
          if (count($lin) != 30) {
               if (fgets($dad) == true) {                    
                    $err[] = "Número de colunas do arquivo de dados do cliente difere de 30 - Linha: " . $ord; $nro = $nro + 1;
               }
          } else if ($ord > 1) {
               if (is_numeric($lin[0]) == false) {
                    $err[] = "Coluna (0) não é somente numérica [" . $lin[0] . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (trim($lin[2]) == "") {
                    $err[] = "Coluna (2) não é pode ficar em branco [" . $lin[2] . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (trim($lin[3]) == "") {
                    $err[] = "Coluna (3) não é pode ficar em branco [" . $lin[3] . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (trim($lin[4]) == "") {
                    $err[] = "Coluna (4) não é pode ficar em branco [" . $lin[4] . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (valida_dat($lin[23]) != 0) {
                    $err[] = "Coluna (23) não é uma data informada válida [" . $lin[23] . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               $let = trim($lin[24]); $let = str_replace("R", "", $let); $let = str_replace("$", "", $let); $let = trim($let); $let = str_replace(".", "", $let);
               if (valida_val($let) != 0) {
                    $err[] = "Coluna (24) não é somente um valor [" . trim($lin[24]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               $let = trim($lin[26]); $let = str_replace("R", "", $let); $let = str_replace("$", "", $let); $let = trim($let); $let = str_replace(".", "", $let);
               if (valida_val($let) != 0) {
                    $err[] = "Coluna (26) não é somente um valor [" . trim($lin[26]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               $let = trim($lin[27]); $let = str_replace("R", "", $let); $let = str_replace("$", "", $let); $let = trim($let); $let = str_replace(".", "", $let);
               if (valida_val($let) != 0) {
                    $err[] = "Coluna (27) não é somente um valor [" . trim($lin[27]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               $let = trim($lin[29]); $let = str_replace("R", "", $let); $let = str_replace("$", "", $let); $let = trim($let); $let = str_replace(".", "", $let);
               if (valida_val($let) != 0) {
                    $err[] = "Coluna (29) não é somente um valor [" . trim($lin[29]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (valida_per($lin[25]) != 0) {
                    $err[] = "Coluna (25) não é somente um percentual [" . trim($lin[25]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
               if (valida_per($lin[28]) != 0) {
                    $err[] = "Coluna (28) não é somente um percentual [" . trim($lin[28]) . "] - Linha: " . $ord; $nro = $nro + 1;
               } 
          }
     } 
     fclose($dad);
     
     return $nro;
}

?>

</html>