<?php 
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");

     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif (isset($_SESSION['wrktipban']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "login.php"</script>');   
     }   
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação do menu principal">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="menu01.php">
          <img id="logo-2" src="img/logo-2.png">
     </a>
     <div class="collapse navbar-collapse align-self-center" id="navbarNav">
          <ul class="navbar-nav mr-auto text-center">
               <li class="nav-item">
               <a class="nav-link" href="man-empresa.php"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i><br /> Parâmetro </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="upload-pla.php?ope=1&cod=0"> <i class="fa fa-cloud-upload fa-2x" aria-hidden="true"></i><br /> Upload </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="processa-pla.php"><i class="fa fa-cogs fa-2x" aria-hidden="true"></i><br /> Processamento </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="download-pla.php"><i class="fa fa-cloud-download fa-2x" aria-hidden="true"></i><br /> DownLoad </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="consulta-dad.php"><i class="fa fa-search fa-2x" aria-hidden="true"></i><br /> Consultas </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="impressao-dad.php"><i class="fa fa-print fa-2x" aria-hidden="true"></i><br /> Relatórios </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-usuario.php"><i class="fa fa-group fa-2x" aria-hidden="true"></i><br /> Usuários </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="log-usuario.php"><i class="fa fa-list fa-2x" aria-hidden="true"></i><br /> Log </a>
               </li>
          </ul>
          <span class="navbar-text text-center">
               <?php 
                    echo '<div class="lit-1">';
                    echo '<strong>' . $_SESSION['wrknomusu'] . '</strong>' . '<br />';
                    echo date('d/m/Y H:i:s') . '<br />';
                    echo '<a class="nav-link" href="saida.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i><br /></a>';
                    echo '</div>';
               ?>
          </span>
     </div>
</nav>

<br /><br /><br /><br /><br /><br /><br /><br />
