<!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo $config->urls->templates ?>dist/img/logo-mini.png" width="50%" alt=""></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo $config->urls->templates ?>dist/img/logo.png" width="50%" alt=""></span>
    </a>

  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php $image=$user->images->first();
                if($image){
                  $imgpro = $image->size(160, 160, array('quality' => 80, 'upscaling' => false, 'cropping' => true));
                } ?>
          <img src="<?php if($image) echo $imgpro->url; ?>" class="img-circle" alt="<?=$user->namefull;?>">
        </div>
        <div class="pull-left info">
          <p><?=$user->namefull;?></p>
          <!-- Status -->
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>

      <!-- search form (Optional) -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="/calendario"><i class="fa fa-calendar"></i> <span>Calendario de Producción</span></a></li>
        <li><a href="/ordenes-de-trabajo"><i class="fa fa-newspaper-o"></i> <span>Ordenes de Producción</span></a></li>
        <li><a href="/recursos-humanos"><i class="fa fa-users"></i> <span>Trabajadores</span></a></li>
        <li><a href="/productos"><i class="fa fa-circle"></i> <span>Productos</span></a></li>
        <li><a href="/"><i class="fa fa-plus-square"></i> <span>Agregar Producto</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
