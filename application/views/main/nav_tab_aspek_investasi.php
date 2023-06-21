<ul class="nav nav-tabs">
	<li role="presentation" <?php if($this->uri->segment(2)=="aspek_investasi"  AND $this->uri->segment(3)=="" OR $this->uri->segment(2)=="index-penempatan-investasi"  AND $this->uri->segment(3)==""){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/aspek_investasi');?>">Penempatan Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="hasil_investasi" || $this->uri->segment(2)=="index-hasil-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/aspek_investasi/hasil_investasi');?>">Penerimaan Hasil Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="beban_investasi" || $this->uri->segment(2)=="index-beban-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/aspek_investasi/beban_investasi');?>">Beban Investasi</a></li>

	<li role="presentation" <?php if($this->uri->segment(3)=="karakteristik_invest" || $this->uri->segment(2)=="index-karakteristik-investasi"){echo 'class="active"';}?>><a href="<?php echo site_url('semesteran/aspek_investasi/karakteristik_invest');?>">Karakteristik dan Resiko Invest</a></li>
</ul>