<?php 
$url_base = "http://localhost/admin3/";
?>
<style>
.nav-icon {
    background-color: #000; /* Color negro */
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-white-white elevation-4" style="background-color: rgb(35, 114, 189); color: #fff;">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo $url_base;?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light" style="color:white;font-size:24px;">Admin de Tienda</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $url_base;?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"style="color:white;font-size:24px;">Bienvenido</a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <!--0-->
      <li class="nav-item ">
          <a href="<?php echo $url_base;?>index.php" class="nav-link">
            <p style="color:white;font-size:24px;">
                Panel de control  
                <i class="fas fa-tools"></i>
            </p>
          </a> 
      </li>
      <!-- primero -->
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <p style="color:white;font-size:24px;">
              Admin principales
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
               <a href="<?php echo $url_base;?>views/clientes.php" class="nav-link">
                 <img src="<?php echo $url_base;?>assets/img/iconos/clientes.png" width="35" alt="">
                <p style="color:white;">Clientes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $url_base;?>views/usuario.php" class="nav-link">
              <img src="<?php echo $url_base;?>assets/img/iconos/usuarios.png" width="35" alt=""> 
                <p style="color:white;">Usuario</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- segundo -->
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="35" alt="">
            <p style="color:white;font-size:24px;">
              Almacen
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo $url_base;?>views/categorias.php" class="nav-link">
            <img src="<?php echo $url_base;?>assets/img/iconos2/categorias.png" width="35" alt="">
                <p style="color:white;">Categorias</p>
              </a>
            </li>
            <li class="nav-item">
               <a href="<?php echo $url_base;?>views/productos.php" class="nav-link">
                 <img src="<?php echo $url_base;?>assets/img/iconos2/productos.png" width="35" alt="">
                <p style="color:white;">Productos</p>
              </a>
            </li>
             <li class="nav-item">
            <a href="<?php echo $url_base;?>views/sucursal.php" class="nav-link">
            <img src="<?php echo $url_base;?>assets/img/iconos2/sucursal.jpg" width="35" alt="">
                <p style="color:white;">Sucursales</p>
              </a>
            </li>
          </ul>
        </li>
       <!-- tercero -->
       <li class="nav-item ">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="35" alt="">
            <p style="color:white;font-size:24px;">
                Compras
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo $url_base;?>views/proveedor.php" class="nav-link">
            <img src="<?php echo $url_base;?>assets/img/iconos3/proveedor.png" width="35" alt="">
                <p style="color:white;">Proveedor</p>
              </a>
            </li>
            <li class="nav-item">
            <a href="<?php echo $url_base;?>views/ingresos.php" class="nav-link">
            <img src="<?php echo $url_base;?>assets/img/iconos3/ingresos.png" width="35" alt="">
                <p style="color:white;">Ingresos</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- cuarto -->
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="35" alt="">
            <p style="color:white;font-size:24px;">
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="<?php echo $url_base;?>servicios.php" class="nav-link">
              <img src="<?php echo $url_base;?>img/iconos/servicios.png" width="35" alt="">
                <p style="color:white;">Servicios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $url_base;?>servicios.php" class="nav-link">
              <img src="<?php echo $url_base;?>img/iconos/servicios.png" width="35" alt="">
                <p style="color:white;">Servicios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $url_base;?>servicios.php" class="nav-link">
              <img src="<?php echo $url_base;?>img/iconos/servicios.png" width="35" alt="">
                <p style="color:white;">Servicios</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- quinto -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="30" alt=""> <!-- Ícono de Admin -->
            <p style="color:white;font-size:25px;">
             Web
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <!-- Clientes -->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <img src="img/iconos/clientes.png" width="30" alt=""> <!-- Ícono de Clientes -->
                <p style="color:white;"> Banners</p>
                <i class="right fas fa-angle-left white"></i>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="<?php echo $url_base;?>web/banners/banner1.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color:white;">Banner1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo $url_base;?>web/banners/banner2.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color:white;">Banner2</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo $url_base;?>web/banners/banner3.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color:white;">Banner3</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>     <!-- quinto -->

        <!-- noveno -->
        <li class="nav-item ">
          <a href="#" class="nav-link">
            <img src="img/iconos/admin.png" width="35" alt="">
            <p style="color:white;font-size:24px;">
              Configuraciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
          <li class="nav-item">
               <a href="<?php echo $url_base;?>clientes.php" class="nav-link">
                 <img src="<?php echo $url_base;?>img/iconos/clientes.png" width="35" alt="">
                <p style="color:white;">Datos de Empresa</p>
              </a>
            </li>
            <li class="nav-item">
            <a href="<?php echo $url_base;?>proveedor.php" class="nav-link">
            <img src="<?php echo $url_base;?>img/iconos/proveedor.png" width="35" alt="">
                <p style="color:white;">Mi cuenta</p>
              </a>
            </li>
            <li class="nav-item">
            <a href="<?php echo $url_base;?>articulos.php" class="nav-link">
              <a href="articulos.php" class="nav-link">
                <p style="color:white;"> Mi Foto</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usuario.php" class="nav-link">
              <a href="<?php echo $url_base;?>usuario.php" class="nav-link">
              <img src="<?php echo $url_base;?>img/iconos/usuarios.png" width="35" alt=""> 
                <p style="color:white;">Usuario</p>
              </a>
            </li>

          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>