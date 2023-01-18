<nav class="navbar navbar-expand-lg navbar-dark bg-dark md-3" style="margin-bottom:10px;">
  <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">Sobre</a>
          </li>          
        



       <!--FAZ A VERIFICAÇÃO SE O USUÁRIO É ADMINISTRADOR, SE SIM CARREGA OS MENUS DE CADASTRO-->
         <?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type']) == "admin") : ?>           
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastros
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/estabelecimentos">Estabelecimento</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/atendimentos">Atendimento</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/filas">Filas</a>               
              </div>
            </li>





        <?php endif; ?>         
        </ul>


        <ul class="navbar-nav ml-auto">
         <?php if(isset($_SESSION['user_id'])) : ?>
         <li class="nav-item">
            <a class="nav-link" href="#">Bem vindo <?php echo $_SESSION['user_name']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Sair</a>
          </li>
         <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Se registrar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Entrar</a>
          </li> 
        <?php endif; ?>         
        </ul>

      </div>
  </div>
</nav>