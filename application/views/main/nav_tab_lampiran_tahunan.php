<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(3)=="dana_bersih" || $this->uri->segment(2)=="index-lampiran-danabersih"){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/lampiran/dana_bersih');?>">Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="perubahan_danabersih" || $this->uri->segment(2)=="index-lampiran-perubahan-danabersih"){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/lampiran/perubahan_danabersih');?>">Perubahan Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="aruskas" || $this->uri->segment(2)=="index-lampiran-aruskas"){echo 'class="active"';}?>><a href="<?php echo site_url('tahunan/lampiran/aruskas');?>">Arus Kas</a></li>
</ul>