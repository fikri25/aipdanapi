<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(2)=="pendahuluan" && $this->uri->segment(3)=="" ||  $this->uri->segment(2)=="index-pendahuluan"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/pendahuluan').get_uri();?>">Pendahuluan</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="aset_investasi" ||  $this->uri->segment(2)=="index-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/aset_investasi').get_uri();?>">Aset Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="hasil_investasi" ||  $this->uri->segment(2)=="index-hasil-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/hasil_investasi').get_uri();?>">Hasil Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(1)=="beban-investasi" ||  $this->uri->segment(2)=="index-beban-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('beban-investasi').get_uri();?>">Beban Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="bukan_investasi" ||  $this->uri->segment(2)=="index-bukan-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/bukan_investasi').get_uri();?>">Aset Bukan Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="dana_bersih" ||  $this->uri->segment(2)=="index-danabersih"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/dana_bersih').get_uri();?>">Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="perubahan_dana_bersih" ||  $this->uri->segment(2)=="index-perubahan-danabersih"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/perubahan_dana_bersih').get_uri();?>">Perubahan Dana Bersih</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="arus_kas" ||  $this->uri->segment(2)=="index-aruskas"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/arus_kas').get_uri();?>">Arus Kas</a></li>

	<li role="presentation" <?php if($this->uri->segment(2)=="rincian" ||  $this->uri->segment(2)=="index-rincian"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/rincian').get_uri();?>">Rincian</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="pernyataan_direksi" || $this->uri->segment(2)=="index-pernyataan"){echo 'class="active"';}?>><a href="<?php echo site_url('bulanan/pendahuluan/pernyataan_direksi').get_uri();?>">Pernyataan</a></li>

</ul>