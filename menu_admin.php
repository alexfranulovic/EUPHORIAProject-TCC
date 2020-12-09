<!-------------------------------------------------------------------------------------------------------------------------------->        
<div id="user-nav" class="navbar navbar-inverse hidden-phone hidden-tablet">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
      <i class="icon icon-user"></i>  
      <span class="text">
        <?php
          include_once("seguranca.php");
          echo "".$_SESSION['usuarioNome'];
        ?>
    </span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="visualizar_usuario.php?id=<?php echo $_SESSION['usuarioId']; ?>"><i class="icon-user"></i> Meu perfil</a></li>
        <li class="divider"></li>
        <li><a href="sair.php"><i class="icon-key"></i>Sair</a></li>
      </ul>
    </li>
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Mensagens</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sInbox" title="Listar mensagens" href="listar_mensagens.php"><i class="icon-envelope"></i> Mensagens de contato</a></li>
        <li><a class="sInbox" title="Chat" href="chat.php"><i class="icon-envelope"></i> Chat</a></li>
      </ul>
    </li>
    <!--<li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Configurações</span></a></li>-->
    <li class=""><a title="" href="sair.php"><i class="icon icon-share-alt"></i> <span class="text">Sair</span></a></li>
  </ul>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------> 
<!--<div id="search">
  <input type="text" placeholder="Pesquise aqui..."/>
  <button type="submit" class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
</div>-->
<!--------------------------------------------------------------------------------------------------------------------------------> 
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon-reorder"></i> Menu</a>
  <ul>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li class="submenu hidden-desktop"> <a href="#"><i class="icon icon-user"></i> <span>Perfil</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="visualizar_usuario.php?id=<?php echo $_SESSION['usuarioId']; ?>">Meu perfil</a></li>
        <li><a href="sair.php">Sair</a></li>
      </ul>
    </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li><a href="administrativo.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li><a href="charts.php"><i class="icon icon-signal"></i> <span>Gráficos</span></a> </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li class="submenu"> <a href="#"><i class="icon icon-group"></i> <span>Usuários</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="listar_usuario.php">Listar Usuários</a></li>
        <li><a href="cad_usuario.php">Cadastrar usuário</a></li>
        <li><a href="listar_mensagens.php">Mensagens</a></li>
      </ul>
    </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li class="submenu"> <a href="#"><i class="icon-tags"></i> <span>Produtos</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="listar_produtos.php">Listar Produtos</a></li>
        <li><a href="listar_categoria.php">Listar Categorias</a></li>
        <!--<li><a href="listar_destaque.php">Listar Destaques</a></li>
        <li><a href="controle_estoque.php">Controle de Estoque</a></li>-->
        <li><a href="promocao.php">Promoções</a></li>
      </ul>
    </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li class="submenu"> <a href="#"><i class="icon-envelope-alt"></i> <span>Contatos</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="listar_fornecedor.php">Listar Fornecedores</a></li>
        <li><a href="listar_news.php">Listar Newsletter</a></li>
        <li><a href="msg_email.php">Enviar e-mail (newsletter)</a></li>
      </ul>
    </li>
<!-------------------------------------------------------------------------------------------------------------------------------->
    <li class="submenu"> <a href="#"><i class="icon-shopping-cart"></i> <span>Vendas</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="listar_vendas.php">Listar vendas</a></li>
        <li><a href="chat.php">Chat de vendas</a></li>
        <li><a href="calcular_frete.php">Calculador de frete</a></li>
      </ul>
    </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <!--<li><a href="buttons.php"><i class="icon icon-eye-open"></i> <span>Notificações</span></a></li>-->
<!-------------------------------------------------------------------------------------------------------------------------------->  
    <li><a href="../index.php"><i class="icon icon-home"></i> <span>Loja</span></a> </li>
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <li class="submenu"> <a href="#"><i class="icon-cogs"></i> <span>Configurações</span> 
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="listar_pag.php">Listar páginas</a></li>
        <li><a href="config_email.php">Configuração de e-mail</a></li>
        <li><a href="listar_destaque.php">Listar destaques</a></li>
        <!--<li><a href="cad_destaques.php">Cadastrar Destaques</a></li>-->
      </ul>
    </li>
<!-------------------------------------------------------------------------------------------------------------------------------->

    <!--<li class="submenu"> <a href="#"><i class="icon icon-list"></i> <span>Diversos</span>
      <span style="background-color: transparent;" class="label"><span class="icon-caret-down"></span>
    </a>
      <ul>
        <li><a href="widgets.php"><i class="icon icon-inbox"></i> <span>Widgets</span></a> </li>
        <li><a href="tables.php"><i class="icon icon-th"></i> <span>Tabelas</span></a></li>
        <li><a href="grid.php"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
        <li><a href="form-common.php">Formulários básico</a></li>
        <li><a href="buttons.php"><i class="icon icon-tint"></i> <span>Botões</span></a></li>
        <li><a href="interface.php"><i class="icon icon-pencil"></i> <span>Elementos</span></a></li>
        <li><a href="form-validation.php">Formulário com validação</a></li>
        <li><a href="form-wizard.php">Form with Wizard</a></li>
        <li><a href="index2.php">Dashboard2</a></li>
        <li><a href="gallery.php">Galeria</a></li>
        <li><a href="calendar.php">Calendário</a></li>
        <li><a href="invoice.php">Invoice</a></li
        <li><a href="chat.php">Chat</a></li>
      </ul>
  </ul>
</li>-->
<!--------------------------------------------------------------------------------------------------------------------------------> 
    <!--<li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
      <ul>
        <li><a href="error403.php">Error 403</a></li>
        <li><a href="error404.php">Error 404</a></li>
        <li><a href="error405.php">Error 405</a></li>
        <li><a href="error500.php">Error 500</a></li>
      </ul>
    </li>
    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>-->
</div>
