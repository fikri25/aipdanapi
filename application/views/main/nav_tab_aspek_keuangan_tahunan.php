<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(2)=="aspek_keuangan" AND $this->uri->segment(3)=="" OR $this->uri->segment(2)=="index-danabersih" AND $this->uri->segment(3)=="" ){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/aspek_keuangan');?>">Ikhtisar Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="lkak_perubahan_danabersih" || $this->uri->segment(2)=="index-perubahan-danabersih"){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/aspek_keuangan/lkak_perubahan_danabersih');?>">Perubahan Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="lkak_yoi" || $this->uri->segment(2)=="index-lkak-yoi"){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/aspek_keuangan/lkak_yoi');?>">LKAK YOI</a></li>
</ul>