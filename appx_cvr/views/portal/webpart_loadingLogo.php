
<script>
$("document").ready(function () {

  $("#btnloadingCVR").click(function(){ LoadingCVR('convivereLoad', 1, loadingCVRInterval); });

  $("#convivereLoad").load(function() 
   {  $('#convivereLoad').loadgo();
   }).each(function() { if (this.complete) { $(this).load(); } });

});
</script>

   <div class="row" id="divloadingCVR">
    <div class="col-sm-4 col-sm-offset-4">
       <?php echo img( array('id' => "convivereLoad", 'src' => base_url().'style/images/logo/CONVIVERE.png','alt' => "Cargando...",'class'=>"img-responsive logo", "style"=>"margin: 0 auto;","heigth"=>"55")); ?>
    </div>    
    <div class="col-md-12 text-center">
        <div id="loadingCVR-progress-1"  style="margin-bottom:5px;font-size:16px;opacity:0;font-weight:bold;">0 % </div>
        <div id="loadingCVR-msg-1"><?php echo img( array('src' => base_url().'style/images/loading.gif','alt' => "Cargando...")); ?></div>                
    </div>
    </div>
<i class="fa fa-hand-pointer-o pointer" id="btnloadingCVR">CARGAR fdf</i>
    