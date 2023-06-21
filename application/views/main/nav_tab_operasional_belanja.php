<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(3)=="pembayaran_pensiun" || $this->uri->segment(2)=="index-pembayaran-pensiun"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/operasional_belanja/pembayaran_pensiun');?>">Pembayaran Pensiun</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="pembayaran_pensiun_cabang"  || $this->uri->segment(2)=="index-pembayaran-pensiun-cabang"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/operasional_belanja/pembayaran_pensiun_cabang');?>">Pembayaran Pensiun Cabang</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="klaim" || $this->uri->segment(2)=="index-klaim"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/operasional_belanja/klaim');?>">Klaim</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="lampiran" || $this->uri->segment(2)=="index-lampiran"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/operasional_belanja/lampiran');?>">Upload Lampiran Pendukung</a></li>

</ul>