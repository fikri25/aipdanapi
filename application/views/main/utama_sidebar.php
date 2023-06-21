
<style type="text/css">
  .wrap li, .wrap li a {
    white-space: normal;
    word-wrap: break-word;
  }
</style>
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header text-center" style="font-size: 14px">
        <b>Tahun Anggaran&nbsp;<?php echo $this->session->userdata('tahun'); ?></b>
      </li>
      <?php
        $menu = sidebar_menu();
        // echo '<pre>';
        // print_r($menu);exit;
        foreach ($menu as $m) { 
        if($m['type_menu'] == "P"){
      ?>
      <li>
        <a href="<?= site_url($m['url']);?>"><i class="<?= $m['icon_menu'];?>"></i> 
          <span><?= $m['parent'];?></span>
        </a>
      </li>
        <?php } if($m['type_menu'] == "PC") { ?>
          <li class="treeview">
            <a href="#"><i class="<?= $m['icon_menu'];?>"></i>
              <span><?= $m['parent'];?></span> 
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <?php foreach ($m['child'] as $ch) { ?>
              <?php if($ch['type_menu'] == "C") { ?>
                <ul class="treeview-menu wrap">
                  <li>
                    <a href="<?= site_url($ch['url']);?>"><i class="<?= $ch['icon_menu'];?>"></i> 
                    <span><?= $ch['menu'];?></span></a>
                  </li>
                  
                </ul>
              <?php } ?>
            <?php } ?>
          </li>
        <?php } ?>
      <?php } ?>
    </ul>
  </section>
</aside>

<script>
  // class aktif sidebar untuk admin LTE
  var url = window.location;
  $('ul.sidebar-menu a').filter(function(){
    return this.href == url;
  }).parent().addClass('active');
  // for treeview
  $('ul.treeview-menu a').filter(function(){
    return this.href == url;
  }).closest(".treeview").addClass('active');
  
</script>
