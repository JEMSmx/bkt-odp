<?php include('./_head.php'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('./_lat.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $meses=array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
          $semana=inicio_fin_semana(date('Y-m-d'));
          $inis=explode('-', $semana['fechaInicio']);
          $inif=explode('-', $semana['fechaFin']); ?>
    <div class="col-md-12">
    <h2>Semana <?=date('W');?> <small><?=$inis['2']?> de <?=$meses[intval($inis['1'])]?> al <?=$inif['2']?> de <?=$meses[intval($inif['1'])]?></small></h2>
  </div>
    <section class="content-header">
      <h1>
        <strong>Dashboard</strong>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php $odps=$pages->find("template=work"); ?>
              <h3><?=$odps->count();?></h3>

              <p>ODP Activas</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/ordenes-de-produccion" class="small-box-footer">Más info<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php $acts=$pages->find("template=activities, state!=3"); ?>
              <h3><?=$acts->count();?><sup style="font-size: 20px"></sup></h3>

              <p>Tareas Activas</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <?php      $iniSem=$inis[2]; 
                   $mod_date=$semana['fechaInicio'];
                    $hora='00:00';$ade='00:00';$asi='00:00';
                     for ($i=0; $i < 5 ; $i++) { 
                      $totDis=0; $totCom=0; $totAsi=0;
                      $empleados=$users->find("roles=empleado"); 
                      foreach($empleados as $empleado){  
                        $totDis+=8;
                        foreach ($empleado->children() as $key => $event) {
                          $fechEvento=explode(" ", $event->ini);
                          if($iniSem<10)
                            $inS='0'.$iniSem;
                          else
                            $inS=$iniSem;

                          $hoy=date('Y-m-'.$inS);
                          if($hoy==$fechEvento[0]){
                            if($event->odt->cant<=1)
                              $hora=sumarHoras($hora,$event->odt->duration);
                            else
                              $hora=sumarHoras($hora,mulhours($event->odt->duration,$event->odt->cant));
                            $fecha_actual = strtotime(date("Y-m-d H:i:s",time()));
                            $fecha_entrada = strtotime($event->fin);
                            if($event->odt->cant<=1)
                              $asi=sumarHoras($asi,$event->odt->duration);
                            else
                              $asi=sumarHoras($asi,mulhours($event->odt->duration,$event->odt->cant));

                              if(intval($event->odt->state)==3){
                                if($event->odt->cant<=1)
                                  $ade=sumarHoras($ade,$event->odt->duration);
                                else
                                  $ade=sumarHoras($ade,mulhours($event->odt->duration,$event->odt->cant));
                              }
                          }
                        } 
                        
                      } 
                      $mod_date = strtotime($mod_date."+ 1 days");
                      $iniSem=date("d",$mod_date);
                     }
                      $horTra=$ade;
                      $ade=convertDec($ade); 
                      $asi=convertDec($asi); 
                      $totCom+=$ade;
                      $totAsi+=$asi;
                    $por=($totAsi==0) ? 0:($totCom*100)/$totAsi; ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=round($por,2)?>%</h3>
              <p>Eficiencia semanal</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$horTra?></h3>

              <p>Horas trabajadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/calendario" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- 
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <!-- Tabs within a box 
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales 
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
        </div>-->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      El fracaso es una gran oportunidad para empezar otra vez con más inteligencia
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?=date('Y')?> <a href="http://www.bktmobiliario.com/">BKT Mobiliario Urbano</a>.</strong> Todos los derechos reservados
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include('./_foot.php'); ?>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $(function () {
    $('#example4').DataTable();
  })
  /*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

    
  /* Morris.js Charts */
  // Sales chart
  var area = new Morris.Area({
    element   : 'revenue-chart',
    resize    : true,
    data      : [
      { y: '2011 Q1', item1: 2666, item2: 2666 },
      { y: '2011 Q2', item1: 2778, item2: 2294 },
      { y: '2011 Q3', item1: 4912, item2: 1969 },
      { y: '2011 Q4', item1: 3767, item2: 3597 },
      { y: '2012 Q1', item1: 6810, item2: 1914 },
      { y: '2012 Q2', item1: 5670, item2: 4293 },
      { y: '2012 Q3', item1: 4820, item2: 3795 },
      { y: '2012 Q4', item1: 15073, item2: 5967 },
      { y: '2013 Q1', item1: 10687, item2: 4460 },
      { y: '2013 Q2', item1: 8432, item2: 5713 }
    ],
    xkey      : 'y',
    ykeys     : ['item1', 'item2'],
    labels    : ['Item 1', 'Item 2'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover : 'auto'
  });
  var line = new Morris.Line({
    element          : 'line-chart',
    resize           : true,
    data             : [
      { y: '2011 Q1', item1: 2666 },
      { y: '2011 Q2', item1: 2778 },
      { y: '2011 Q3', item1: 4912 },
      { y: '2011 Q4', item1: 3767 },
      { y: '2012 Q1', item1: 6810 },
      { y: '2012 Q2', item1: 5670 },
      { y: '2012 Q3', item1: 4820 },
      { y: '2012 Q4', item1: 15073 },
      { y: '2013 Q1', item1: 10687 },
      { y: '2013 Q2', item1: 8432 }
    ],
    xkey             : 'y',
    ykeys            : ['item1'],
    labels           : ['Item 1'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  });

  // Donut Chart
  var donut = new Morris.Donut({
    element  : 'sales-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a'],
    data     : [
      { label: 'Download Sales', value: 12 },
      { label: 'In-Store Sales', value: 30 },
      { label: 'Mail-Order Sales', value: 20 }
    ],
    hideHover: 'auto'
  });

  // Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });


});
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
