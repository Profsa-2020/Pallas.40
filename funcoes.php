<?php

function envia_email($end_ema, $asu_ema, $tex_env, $nom_usu){
     ini_set("smtp_port", 25);    // 25 - 143 - 110 - 587 - 465
    if ($asu_ema == "") {
        $asu_ema ="Re-envio de login e senha a usuário do sistema !";
    }
    $headers  = 'From: comercial@mylogbox.com' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $envio = mail($end_ema, $asu_ema, $tex_env, $headers);
    if ($envio == true):
        return 1;
    else:
        return 0;
    endif;
 }
 
function manda_email($end_ema, $asu_ema, $tex_ema, $nom_usu, $anexo_1, $anexo_2){
     include_once "class.smtp.php";
     include_once "class.phpmailer.php";
     if ($asu_ema == "") {
         $asu_ema = "Re-envio de login e senha a usuário do sistema";
     }
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
       $mail = new PHPMailer();
       $mail->SMTPDebug = 0; // 1 = erros e mensagens || 2 = apenas mensagens
       $mail->IsSMTP();	// $mail->IsMail();
       $mail->SMTPAuth = true;
       $mail->IsHTML(true);

       if ($anexo_1 != "") { $mail->AddAttachment($anexo_1); }
       if ($anexo_2 != "") { $mail->AddAttachment($anexo_2); }   

       $mail->Port = 587;    // 25 - 587 - 465
       $mail->CharSet = 'UTF-8';
       $mail->Host = 'cpl04.main-hosting.eu';   // cpl04.main-hosting.eu - smtp.medicamentos-importados.com - mail.medicamentos-importados.com - smtp.hostinger.com.br ;
       $mail->Username = 'contato@figueiracosta.com.br';
       $mail->Password = 'profsa1993';
       $mail->Subject = $asu_ema . " - ". date("d/m/Y H:i:s");
       $mail->SetFrom('contato@figueiracosta.com.br','Raphael F. Costa Assessoria');
       $mail->AddAddress($end_ema, $nom_usu);
       $mail->MsgHTML($tex_ema);
       $ret = $mail->Send();
       return $ret;
  }	

  function envio_email($email_1, $asu_ema, $tex_ema, $nom_usu, $des_usu, $anexo_1, $anexo_2) {
    if (getenv("REMOTE_ADDR") == "127.0.0.1") {$email_1 = "suporte@profsa.com.br"; }
    include_once("PHPMailerAutoload.php");
    if ($asu_ema == "") {$asu_ema ="Re-envio de login e senha a usuário do sistema !!!";}
    $mail = new PHPMailer();
    $mail->IsSMTP();	// $mail->IsMail();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "SSL";
    $mail->SMTPDebug = 0; // 1 = erros e mensagens || 2 = apenas mensagens
    $mail->IsHTML(true);

    if ($anexo_1 != "") { $mail->AddAttachment($anexo_1); }
    if ($anexo_2 != "") { $mail->AddAttachment($anexo_2); }   

     $mail->Port = 587;    // 25 - 587 - 465 - 995
    $mail->Host = 'cpl04.main-hosting.eu'; 
    $mail->Username = 'contato@figueiracosta.com.br';
    $mail->Password = 'profsa1993';
    $mail->SetFrom('contato@figueiracosta.com.br','Raphael F. Costa Assessoria');
    $mail->AddAddress($email_1, $nom_usu);
    $mail->Subject = $asu_ema;
    $mail->MsgHTML($tex_ema);
    $ret = $mail->Send();
    return $ret;
}

function gravar_log($ope = 0, $obs = "", $cod = "") {
    date_default_timezone_set("America/Sao_Paulo");

    $ser = substr(getenv("REMOTE_ADDR") . "|" . getenv("HTTP_USER_AGENT") . "|" . getenv("REMOTE_HOST") . "|" . getenv("SERVER_NAME") . "|" . getenv("SERVER_SOFTWARE") ,0,255) ;

    $ip  = getenv("REMOTE_ADDR");
    $nav = getenv("HTTP_USER_AGENT");
    $nom = "";
    $cid = "";
    $est = "";
    $sta = "";
    $sen = 00;
    $emp = 00;
    $nro = 00;
    $doc = 00;
    $ema = "";
    $ant = "";
    $cam = "";
    $prg = "";
    $tam = 00;
    $mod = 01;
    $ext = "";
    $end = buscar_ip($ip);
    $pro = getenv("SERVER_SOFTWARE");
    $tip = 00;
    $gap = 00;

    if (isset($_SESSION['wrkcodemp']) == true) {$emp = $_SESSION['wrkcodemp'];}
    if (isset($_SESSION['wrkstasen']) == true) {$sta = $_SESSION['wrkstasen'];}
    if (isset($_SESSION['wrknomusu']) == true) {$nom = $_SESSION['wrknomusu'];}
    if (isset($_SESSION['wrkideusu']) == true) {$sen = $_SESSION['wrkideusu'];}
    if (isset($_SESSION['wrktipusu']) == true) {$tip = $_SESSION['wrktipusu'];}
    if (isset($_SESSION['wrkemausu']) == true) {$ema = $_SESSION['wrkemausu'];}
    if (isset($_SESSION['wrknompro']) == true) {$prg = $_SESSION['wrknompro'];}
    if (isset($_SESSION['wrknomant']) == true) {$ant = $_SESSION['wrknomant'];}
    if (isset($_SESSION['wrknumdoc']) == true) {$doc = $_SESSION['wrknumdoc'];}
    if (isset($_SESSION['wrknumcha']) == true) {$nro = $_SESSION['wrknumcha'];}
    if (isset($_SESSION['wrkcidusu']) == true) {$cid = $_SESSION['wrkcidusu'];}
    if (isset($_SESSION['wrkestusu']) == true) {$est = $_SESSION['wrkestusu'];}

    if ($tam == "") { $tam = 0; }
    $prg = str_replace(__DIR__ . "\\", "", $prg);

    $dat = date("Y/m/d H:i:s");
    $sql = "Insert into tb_log ";
    $sql .= "(logdatahora, logempresa, logmodulo, lognumero, logdocto, logusuario, logtipo, logidsenha, logemail, logip, lognavegador, logprovedor, logoperacao,  logprograma, loganterior, logcidade, logestado, logobservacao)";
    $sql .= " values " . "(";
    $sql .= "'" . $dat . "',";
    $sql .= "'" . $emp . "',";
    $sql .= "'" . $mod . "',";
    $sql .= "'" . $nro . "',";
    $sql .= "'" . $doc . "',";
    $sql .= "'" . $nom . "',";
    $sql .= "'" . $tip . "',";
    $sql .= "'" . $sen . "',";
    $sql .= "'" . $ema . "',";
    $sql .= "'" . $ip  . "',";		
    $sql .= "'" . $nav . "',";
    $sql .= "'" . $pro . "',";
    $sql .= "'" . $ope . "',";
    $sql .= "'" . limpa_pro($prg) . "',";
    $sql .= "'" . limpa_pro($ant) . "',";
    $sql .= "'" . $cid . "',";
    $sql .= "'" . $est . "',";
    $sql .= "'" . $obs . "')";
    $ret = comando_tab($sql, $nro, $ult, $men); 
    if ($ret == false) {
        print_r($sql);
        echo '<script>alert("Erro na gravação de Log de acessos ao sistema !");</script>'; exit();
    } 
}

function limpa_cpo($string){
return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U c C"),$string);
}

function limpa_nro($string){ 
$str = preg_replace('/[^0-9]/','',$string); 
return ($str == '' ? 0 : $str);
}

function mascara_cpo($cpo, $mas) {	// Formata campos com máscara
$ret = '';
$nro = 00;
$tmc = strlen($cpo);
$tmm = strlen($mas);
if ($tmm == 0) { $tmm = $tmc; }
for ($ind = 0; $ind < $tmm; $ind++) {
    if (trim($mas[$ind]) == "") {
        if (isset($cpo[$nro]) == true) {
            $ret = $ret . $cpo[$nro];
            $nro = $nro + 1;
        }
    } else {
        $ret = $ret . $mas[$ind];
    }
}
return $ret;
}

function buscar_ip($ip) {
    $end = curl_init('http://ipinfo.io/' . $ip . '/json');
    curl_setopt($end, CURLOPT_RETURNTRANSFER, true);    
    curl_setopt($end, CURLOPT_SSL_VERIFYPEER, false);
    $ret = curl_exec($end);
    $dad = json_decode($ret);
    curl_close($end);    
    $_SESSION['wrkcidusu'] = 'florianopolis';
    $_SESSION['wrkestusu'] = 'sc';
if (isset($dad->bogon) == true) {
        $_SESSION['wrkcidusu'] = 'Florianopolis';
        $_SESSION['wrkestusu'] = 'Sc';
    }else if (isset($dad->city) == true) {
        $_SESSION['wrkcidusu'] = $dad->city;
        $_SESSION['wrkestusu'] = $dad->region;
        if ($_SESSION['wrkestusu'] == "São Paulo") { $_SESSION['wrkestusu'] = "SP"; }
        if ($_SESSION['wrkestusu'] == "Sao Paulo") { $_SESSION['wrkestusu'] = "SP"; }
        if ($_SESSION['wrkestusu'] == "Minas Gerais") { $_SESSION['wrkestusu'] = "MG"; }
        if ($_SESSION['wrkestusu'] == "Santa Catarina") { $_SESSION['wrkestusu'] = "SC"; }
    }
    return $dad;
}

function diferenca_dat($dat_i = "", $dat_f = "") {
$dia = 0;
if ($dat_i == "") { $dat_i = date("Y-m-d"); }
if (substr($dat_f, 2, 1) == '-' || substr($dat_f, 2, 1) == '/') {
    $dat_f = substr($dat_f, 6, 4) . "-" . substr($dat_f, 3, 2) . "-" . substr($dat_f, 0, 2);
}
$data1 = new DateTime($dat_i);
$data2 = new DateTime($dat_f);
$intervalo = $data1->diff($data2);
$dia = $intervalo->days;
if ($dat_i > $dat_f) { $dia = $dia * -1; }
return $dia;
}

function valida_dat($tes) {
    $sta = 0;
    if ($tes == "" || $tes == "//") { return 1; }
    $dat = explode("/",substr($tes, 0, 10));  
    if (is_numeric($dat[0]) == false || is_numeric($dat[1]) == false || is_numeric($dat[2]) == false) {
        $sta = 2;
    }
    if ($sta == 0) {
        if (checkdate($dat[1],$dat[0],$dat[2]) == false) {
            $sta = 3;
        }
    }
    return $sta;
}

function valida_hor($tes) {
    $sta = 0;
    $hor = explode(":", $tes);  
    if (is_numeric($hor[0]) == false || is_numeric($hor[1]) == false) {
        $sta = 1;
    }
    if (count($hor) == 2) {
        if ($hor[0] > 23) { $sta = 2; }
        if ($hor[1] > 59) { $sta = 3; }
    }else{
        $sta = 4;
    }
    return $sta;
}

function valida_val($tes) { // Pega um caracter dentro de uma string como uma array usando o for - colchete
    $sta = 0; $nro = strlen(trim($tes));
    if (trim($tes) == "" || trim($tes) == "." || trim($tes) == ",") { return 1; }
    for ($ind = 0; $ind < $nro ; $ind++) {
        $let = ord(trim($tes{$ind})); 
        if ($let != 44) {
            if ($let < 48 || $let > 57) {
                $sta = 1;
            }
        }
    }
    return $sta;
}

function valida_per($tes) { 
    $sta = 0; $nro = strlen(trim($tes));
    if (trim($tes) == "%" || trim($tes) == "." || trim($tes) == ",") { return 1; }
    for ($ind = 0; $ind < $nro ; $ind++) {
        $let = ord(trim($tes{$ind})); 
        if ($let != 37) {
            if ($let < 48 || $let > 57) {
                $sta = 1;
            }
        }
    }
    return $sta;
}

function dia_mes($dat) {
    $dia = 0;
    $mes = substr($dat, 3, 2);
    $ano = substr($dat, 6, 4);
    if ($mes == 1)  { $dia = 31; }
    if ($mes == 2)  { $dia = 28; }
    if ($mes == 3)  { $dia = 31; }
    if ($mes == 4)  { $dia = 30; }
    if ($mes == 5)  { $dia = 31; }
    if ($mes == 6)  { $dia = 30; }
    if ($mes == 7)  { $dia = 31; }
    if ($mes == 8)  { $dia = 31; }
    if ($mes == 9)  { $dia = 30; }
    if ($mes == 10) { $dia = 31; }
    if ($mes == 11) { $dia = 30; }
    if ($mes == 12) { $dia = 31; }
    if ($mes == 2 && ($ano % 4) == 0) { $dia = 29; }
    return $dia;
}

function mes_ano($dat) {
    $nom = '';
    if (strlen($dat) <= 2) {
        $mes = $dat;
    }else{
        $mes = substr($dat, 3, 2);
    }
    if ($mes == 1)  { $nom = 'Janeiro'; }
    if ($mes == 2)  { $nom = 'Fevereiro'; }
    if ($mes == 3)  { $nom = 'Março'; }
    if ($mes == 4)  { $nom = 'Abril'; }
    if ($mes == 5)  { $nom = 'Maio'; }
    if ($mes == 6)  { $nom = 'Junho'; }
    if ($mes == 7)  { $nom = 'Julho'; }
    if ($mes == 8)  { $nom = 'Agosto'; }
    if ($mes == 9)  { $nom = 'Setembro'; }
    if ($mes == 10) { $nom = 'Outubro'; }
    if ($mes == 11) { $nom = 'Novembro'; }
    if ($mes == 12) { $nom = 'Dezembro'; }
    return $nom;
}

function inverte_dat($dat) {
    $bar = strpos($dat,'/');
    $tra = strpos($dat,'-');
    if ($bar > 0) {
        if ($bar == 2) {
            $dat = substr($dat,6,4) . '/' . substr($dat,3,2) . '/' . substr($dat,0,2);
        }
        if ($bar == 4) {
            $dat = substr($dat,8,2) . '/' . substr($dat,5,2) . '/' . substr($dat,0,4);
        }
    }
    if ($tra > 0) {
        if ($tra == 2) {
            $dat = substr($dat,6,4) . '-' . substr($dat,3,2) . '-' . substr($dat,0,2);
        }
        if ($tra == 4) {
            $dat = substr($dat,8,2) . '-' . substr($dat,5,2) . '-' . substr($dat,0,4);
        }
    }
    return $dat;
}

function limpa_pro($nom)  {
    $ind = strrpos ($nom,"/");
    if ($ind > 0) {
        $nom = substr($nom,$ind + 1);  
        $ind = strrpos ($nom,".php");
        $nom = substr($nom,0, $ind);  
    } 
    $ind = strrpos ($nom,"\\");
    if ($ind > 0) {
        $nom = substr($nom,$ind + 1);  
        $ind = strrpos ($nom,".php");
        $nom = substr($nom,0, $ind);  
    }
    return $nom;
}

function valida_est($est) {
     $sta = 0;
     $lis = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');
     $sta = array_search(trim($est), $lis);
     return $sta;
 }
 
 function valida_cgc ($cgc) {
     if (strlen($cgc) < 14) { return 1; }
     $sta = 0;
     $som = 0;
     $cgc = preg_replace('/[^0-9]/','',$cgc);    // Troca não numeros por branco.
     for ($ind = 0, $nro = 5; $ind <= 11 ; $ind++, $nro--) {
         $som = $som + $cgc[$ind] * $nro;
          if ($nro == 2) {$nro = 10; }
     }
     $res1 = 11 - $som % 11;
     if ($res1 == 10 || $res1 == 11) { $res1 = 0; }
     $cgc = $cgc . $res1;
     $som = 0;
     for ($ind=0, $nro=6; $ind <= 11 ; $ind++, $nro--) {
         $som = $som + $cgc[$ind] * $nro;
          if ($nro == 2) {$nro = 10; }
     }
     $som = $som + $res1 * 2;
     $res2 = 11 - $som % 11;
     if ($res2 == 10 || $res2 == 11) { $res2 = 0; }
     if ($res1 != $cgc[12] || $res2 != $cgc[13]) { $sta = 1; }
     return $sta;
 }
 
 function valida_cpf ($cpf) {
     $sta = 0; $som = 0;
     if ($cpf == '0') { return 0; }
     $cpf = preg_replace('/[^0-9]/','',$cpf);  // Troca não numeros por branco.
     for ($ind = 0, $nro = 10; $ind <= 8 ; $ind++, $nro--) {
         $som = $som + $cpf[$ind] * $nro;
     }
     $res1 = 11 - $som % 11;
     if ($res1 == 10 || $res1 == 11) { $res1 = 0; }
     $cpf = $cpf . $res1;
     $som = 0;
     for ($ind=0, $nro=11; $ind <= 9 ; $ind++, $nro--) {
         $som = $som + $cpf[$ind] * $nro;
     }
     $res2 = 11 - $som % 11;
     if ($res2 == 10 || $res2 == 11) { $res2 = 0; }
     if ($res1 != $cpf[9] || $res2 != $cpf[10]) { $sta = 1; }
     return $sta;
 }

 function primeiro_nom($nom) {
     $pos = strpos($nom," "); 
     if ($pos > 0) {
         $nom = trim(substr($nom, 0, $pos));
     }
     return $nom;
 }

function valida_ent($sen,$ema){
    $nro = 0;
    $nro += stripos($ema,"'");
    $nro += stripos($sen,"'");
    $nro += stripos($ema,"=");
    $nro += stripos($sen,"=");
    $nro += stripos($ema,";");
    $nro += stripos($sen,";");
    $nro += stripos($ema,"\"");
    $nro += stripos($sen,"\"");
    $nro += stripos($ema,"<");
    $nro += stripos($sen,"<");
    $nro += stripos($ema,"\/");
    $nro += stripos($sen,"\/");
    $nro += stripos($ema,">");
    $nro += stripos($sen,">");
    $nro += stripos(strtoupper($ema),"DROP");
    $nro += stripos(strtoupper($sen),"DROP");
    $nro += stripos(strtoupper($ema),"UNION");
    $nro += stripos(strtoupper($sen),"UNION");
    $nro += stripos(strtoupper($ema),"SELECT");
    $nro += stripos(strtoupper($sen),"SELECT");
    $nro += stripos(strtoupper($ema),"DELETE");
    $nro += stripos(strtoupper($sen),"DELETE");
    $nro += stripos(strtoupper($ema),"WHERE");
    $nro += stripos(strtoupper($sen),"WHERE");
    return $nro;
}

?>
