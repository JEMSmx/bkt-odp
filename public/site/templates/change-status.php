<?php
	

    if(isset($input->post->type) && $input->post->type=='fast'){
        $act = wire('pages')->get($input->post->activity);
        if($act->count()>0){
            $act->of(false);
            $act->bc = $input->post->color;
            $act->bg = $input->post->color;
            $act->save();
            $p = wire('pages')->get($act->odt->id);
            $p->of(false);
            $p->state = $input->post->status;
            $p->save();
            echo 'true';
        }else{
            $tit=str_replace("~", "-", $input->post->activi);
            $tit=str_replace(" ", "-", $tit);
            $tit=str_replace("/", "-", $tit);
            $tit=quitaracentos(strtolower($tit));
            $act1 = $pages->find("template=event, name=$tit");
            $act1[0]->of(false);
            $act1[0]->bc = $input->post->color;
            $act1[0]->bg = $input->post->color;
            $act1[0]->save();
            $p = wire('pages')->get($act1[0]->odt->id);
            $p->of(false);
            $p->state = $input->post->status;
            $p->save();
            echo 'true';
        }
        
        
        
    }else{
        $colores=array('btn-default', 'btn-danger', 'btn-primary', 'btn-success');
    $nombres=array('Pendiente', 'Pausada', 'En Proceso', 'Terminada');
    $color=array('gray', 'red', 'blue', 'green');
    $porcen=array('0', '50', '50', '100');
    $p = wire('pages')->get($input->post->activity);
    $p->of(false);
    $p->state = $input->post->status;
    $p->save(); ?>

    <div class="btn-group">
    <button type="button" class="btn <?= $colores[$input->post->status]; ?> btn-xs"><?= $nombres[$input->post->status]; ?></button>
    <button type="button" class="btn <?= $colores[$input->post->status]; ?> btn-xs dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu" id="<?= $p->id.'/'.$p->id.'/status'; ?>">
        <li data-key="0" data-activity="<?=$p->id?>"><a href="#">Pendiente</a></li>
        <li data-key="2" data-activity="<?=$p->id?>"><a href="#">En Proceso</a></li>
        <li data-key="3" data-activity="<?=$p->id?>"><a href="#">Terminada</a></li>
        <li data-key="1" data-activity="<?=$p->id?>"><a href="#">Pausada</li>
        </ul>
    </div>
    <script type="text/javascript">
        $('.dropdown-menu li').click(function(){
        var key=$(this).data('key');
        var id=$(this).closest("ul").prop("id");
        var find=id.split('/');
        if(find[2]=='status'){
          $.ajax({
            url: "/change-status",
            type: "post",
            data: {status:key,odt:<?=$page->id;?>,activity:$(this).data('activity')},
            dataType: "html",
            }).done(function(msg){
                if(msg)
                    $("#st-"+find[0]).html(msg);
            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
          });
        }else{
          $.ajax({
            url: "/asignar-emp",
            type: "post",
            data: {asig:key,id:id,odt:<?=$page->id;?>},
            dataType: "html",
            }).done(function(msg){
              if(msg){
                  swal({
                title: "Correcto",
                text: "Se actualizo el asignado",
                type: "success",
              })
              .then(willDelete => {
                if (willDelete) {
                  window.location='';
                }
              });
              }
            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
          });
        }
        
     });
    
</script>
<?php } ?>