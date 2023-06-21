<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(3)=="mst_pihak" || $this->uri->segment(2)=="index-mst-pihak"){echo 'class="active"';}?>><a href="<?php echo site_url('master/master_data/mst_pihak');?>">Nama Pihak</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="master_nama_pihak" || $this->uri->segment(2)=="index-master-nama-pihak"){echo 'class="active"';}?>><a href="<?php echo site_url('master/master_data/master_nama_pihak');?>">Nama Pihak Per Jenis Investasi</a></li>
	
</ul>