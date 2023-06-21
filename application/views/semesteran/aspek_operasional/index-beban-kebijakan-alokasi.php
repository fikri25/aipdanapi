<div class="tab-pane fade in" id="beban_3">
	<p style="margin-left:10px;margin-top:20px;margin-bottom:20px;font-weight: bold">	  
		Kebijakan alokasi pembebanan biaya sumber daya manusia, sarana dan prasarana 
	</p>
	<form class="form-horizontal" action="<?php echo base_url().'semesteran/aspek_operasional/save_keterangan'?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">

		<input type="hidden" name="jns_lap" value="ket_kebijakan_alokasi_smt">
		<input type="hidden" name="nmdok" value="Kebijakan_Alokasi_Semester">
		<input type="hidden" name="semester" value="1">
		<div class="form-group">
			<div class="col-sm-12">
				<textarea name="keterangan" class="form-control" style="height:130px;width:100%;" id="keterangan" rows="10"><?php echo (isset($data_kebijakan_ket_smt1[0]->keterangan_lap) ? $data_kebijakan_ket_smt1[0]->keterangan_lap : '');?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="keterangan">Unggah Dokumen</label>
			<div class="col-sm-10">
				<input type="hidden" name="id" value="<?php echo (isset($data_kebijakan_ket_smt1[0]->id) ? $data_kebijakan_ket_smt1[0]->id : '');?>">
				<input type="hidden" name="filedata_lama" value="<?php echo (isset($data_kebijakan_ket_smt1[0]->file_lap) ? $data_kebijakan_ket_smt1[0]->file_lap : '');?>">
				<input type="file" name="filedata">
				<p style="margin-top:10px;">File harus bertipe pdf,doc atau docx.</p>
				<a href="<?php echo site_url('semesteran/aspek_operasional/get_file/'.(isset($data_kebijakan_ket_smt1[0]->id) ? $data_kebijakan_ket_smt1[0]->id : ''));?>"><p><?php echo (isset($data_kebijakan_ket_smt1[0]->file_lap) ? $data_kebijakan_ket_smt1[0]->file_lap : '');?></p></a>
			</div>
		</div>
		<?php if($level != "DJA"){?>
			<button style="height:30px; margin-bottom:10px; margin-left:10px;" class="btn btn-primary btn-md btn-flat" type="submit">
				Simpan
			</button>
		<?php } ?>
	</form>
</div>