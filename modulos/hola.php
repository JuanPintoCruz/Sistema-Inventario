<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-white-white elevation-4" style="background-color: rgb(30, 114, 189); color: #fff;">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light" style="color:white;font-size:25px;">Admin de Tienda</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="color:white;font-size:25px;">Bienvenido</a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Admin principal -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="30" alt=""> <!-- Ícono de Admin -->
            <p style="color:white;font-size:25px;">
              Admin principal
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <!-- Clientes -->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <img src="img/iconos/clientes.png" width="30" alt=""> <!-- Ícono de Clientes -->
                <p style="color:white;">Clientes</p>
                <i class="right fas fa-angle-left white"></i>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="clientes-nuevos.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color:white;">Nuevos Clientes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="clientes-viejos.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color:white;">Clientes Antiguos</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>