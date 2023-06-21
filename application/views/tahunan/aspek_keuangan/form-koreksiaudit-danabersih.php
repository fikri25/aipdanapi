<!-- Main content -->
<style type="text/css">
  td.left{
    text-align: left;
    margin-left: 35px;
  }
  td.right{
    text-align: right;
  }
</style>
<?php $level = $this->session->userdata('level');?>
<?php $tahun = $this->session->userdata('tahun');?>

<form id="form_<?=$acak;?>" method="post" url="<?php echo site_url(); ?>aspek-keuangan-thn-simpan/dana_bersih" enctype="multipart/form-data" >
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
  <input type="hidden" name="editstatus" value="<?php echo !empty($editstatus) ? $editstatus : 'add';?>">
  <input type="hidden" name="jenis_laporan" value="<?php echo !empty($jenis_laporan) ? $jenis_laporan : 'DANABERSIH';?>">
  

  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Koreksi Audit Dana Bersih</h3>
        </div>
        <div class="box-body">
          <table id="example" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th rowspan="2" width="30%">URAIAN</th>
                <th rowspan="2" width="10%">Tahun&nbsp;&nbsp;<span class="tahun"></span></th>
                <th rowspan="2" width="10%">Tahun&nbsp;&nbsp;<span class="tahun_lalu"></span></th>
                <th rowspan="2" width="10%">RKA</th>
                <th rowspan="2" width="10%">Persentase Capaian Tahun <span class="tahun_lalu"></span> terhadap RKA</th>
                <th colspan="2" width="10%">Kenaikan/Penurunan</th>
              </tr>
              <tr>
                <th>Nominal</th>
                <th>Persentase</th>
              </tr>

            </thead>
            <tbody>
              <?php if(isset($data_dana_bersih) && is_array($data_dana_bersih)):?>
              <?php foreach($data_dana_bersih as $dana_bersih):?>
                <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
                  <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
                    <td style="text-align: left;color: #303a3f;">
                      <!-- <?=$dana_bersih['jenis_laporan']?> -->
                      <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $dana_bersih['jenis_laporan'];?>"/> 
                    </td>
                    <td class="right">
                      <input type="hidden" name="saldo_akhir[]" class="form-control" value="0"/>
                    </td>
                    <td class="right"></td>
                    <td class="right">
                      <input type="hidden" name="rka[]" class="form-control" value="0"/>
                    </td>
                    <td class="right">
                      <input type="hidden" name="persentase_rka[]" class="form-control" value="0"/>
                    </td>
                    <td class="right">
                     <input type="hidden" name="nom_naikturun[]" class="form-control" value="0"/>
                   </td>
                   <td class="right">
                    <input type="hidden" name="pers_naikturun[]" class="form-control" value="0"/>
                  </td>
                  </tr>
                <?php endif;?>
                <?php foreach($dana_bersih['child'] as $child):?>
                  <tr>
                    <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;">
                      <!-- <?=$child['judul_head']?> -->
                      <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $child['judul_head'];?>"/>  
                    </td>
                    <td class="right">
                      <input type="hidden" name="saldo_akhir[]" class="form-control" value="0"/>
                    </td>
                    <td class="right"></td>
                    <td class="right">
                      <input type="hidden" name="rka[]" class="form-control" value="0"/>
                    </td>
                    <td class="right">
                      <input type="hidden" name="persentase_rka[]" class="form-control" value="0"/>
                    </td>
                    <td class="right">
                     <input type="hidden" name="nom_naikturun[]" class="form-control" value="0"/>
                   </td>
                   <td class="right">
                    <input type="hidden" name="pers_naikturun[]" class="form-control" value="0"/>
                  </td>
                  </tr>
                  <?php foreach($child['subchild'] as $subchild):?>

                    <?php if($subchild['type'] == 'PC'):?>
                      <tr>
                        <td class="left" style="padding-left: 25px;">
                          <!-- <?=$subchild['jenis_investasi']?> -->
                          <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $subchild['jenis_investasi'];?>"/>  

                        </td>
                        <td class="right">
                          <input type="hidden" name="saldo_akhir[]" class="form-control" value="0"/>
                        </td>
                        <td class="right"></td>
                        <td class="right">
                          <input type="hidden" name="rka[]" class="form-control" value="0"/>
                        </td>
                        <td class="right">
                          <input type="hidden" name="persentase_rka[]" class="form-control" value="0"/>
                        </td>
                        <td class="right">
                           <input type="hidden" name="nom_naikturun[]" class="form-control" value="0"/>
                        </td>
                        <td class="right">
                          <input type="hidden" name="pers_naikturun[]" class="form-control" value="0"/>
                        </td>
                      </tr>
                      <?php else:?>
                        <tr>
                          <td class="left" style="padding-left: 25px;">
                            <!-- <?=$subchild['jenis_investasi']?> -->
                            <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $subchild['jenis_investasi'];?>"/>  

                          </td>
                          <td class="right">
                            <!-- <?=($subchild['saldo_akhir_thn'] != 0 ) ? rupiah($subchild['saldo_akhir_thn']) : '-';?> -->
                            <input type="text" name="saldo_akhir[]" class="form-control" value="<?= rupiah($subchild['saldo_akhir_thn']);?>"/>
                          </td>
                          <td class="right"><?=($subchild['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_thn_lalu']) : '-';?></td>
                          <td class="right">
                            <!-- <?=($subchild['rka_thn'] != 0 ) ? rupiah($subchild['rka_thn']) : '-';?> -->
                            <input type="text" name="rka[]" class="form-control" value="<?= rupiah($subchild['rka_thn']);?>"/>
                          </td>
                          <td class="right">
                            <!-- <?=($subchild['perst_rka_thn'] != 0 ) ? persen($subchild['perst_rka_thn']).'%' : '-';?> -->
                            <input type="text" name="persentase_rka[]" class="form-control" value="<?= persen($subchild['perst_rka_thn']);?>"/>
                          </td>
                          <td class="right">
                            <!-- <?=($subchild['nominal'] != 0 ) ? rupiah($subchild['nominal']) : '-';?> -->
                            <input type="text" name="nom_naikturun[]" class="form-control" value="<?= rupiah($subchild['nominal']);?>"/>
                          </td>
                          <td class="right">
                            <!-- <?=($subchild['persentase'] != 0 ) ? persen($subchild['persentase']).'%' : '-';?> -->
                            <input type="text" name="pers_naikturun[]" class="form-control" value="<?= persen($subchild['persentase']);?>"/>
                          </td>
                        </tr>
                      <?php endif;?>

                      <?php if($subchild['type'] == 'PC'):?>
                        <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                          <tr>
                            <td class="left" style="padding-left: 50px; color: #6c7275;">
                              <!-- <?='- '.$subchild3['jenis_investasi']?> -->
                              <input type="text" name="jenis_investasi[]" class="form-control" value="<?='- '.$subchild3['jenis_investasi']?>"/>
                            </td>
                            <td class="right">
                              <!-- <?=($subchild3['saldo_akhir_thn'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn']) : '-';?> -->
                              <input type="text" name="saldo_akhir[]" class="form-control" value="<?= rupiah($subchild3['saldo_akhir_thn']);?>"/>
                            </td>
                            <td class="right"><?=($subchild3['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn_lalu']) : '-';?></td>
                            <td class="right">
                              <!-- <?=($subchild3['rka_thn'] != 0 ) ? rupiah($subchild3['rka_thn']) : '-';?> -->
                              <input type="text" name="rka[]" class="form-control" value="<?= rupiah($subchild3['rka_thn']);?>"/>
                            </td>
                            <td class="right">
                              <!-- <?=($subchild3['perst_rka_thn'] != 0 ) ? persen($subchild3['perst_rka_thn']).'%' : '-';?> -->
                              <input type="text" name="persentase_rka[]" class="form-control" value="<?= persen($subchild3['perst_rka_thn']);?>"/>
                            </td>
                            <td class="right">
                              <!-- <?=($subchild3['nominal'] != 0 ) ? rupiah($subchild3['nominal']) : '-';?> -->
                              <input type="text" name="nom_naikturun[]" class="form-control" value="<?= rupiah($subchild3['nominal']);?>"/>
                            </td>
                            <td class="right">
                              <!-- <?=($subchild3['persentase'] != 0 ) ? persen($subchild3['persentase']).'%' : '-';?> -->
                              <input type="text" name="pers_naikturun[]" class="form-control" value="<?= persen($subchild3['persentase']);?>"/>
                            </td>
                          </tr>
                        <?php endforeach;?>
                      <?php endif;?>
                    <?php endforeach;?>
                    <tr style="font-weight: bold;">
                      <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;">
                        <!-- <?=$child['judul_total']?> -->
                        <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $child['judul_total'];?>"/>  

                      </td>
                      <td style="text-align: right; background-color:#e6f5fe;">
                        <!-- <?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?> -->
                        <input type="text" name="saldo_akhir[]" class="form-control" value="<?= rupiah($child['sum_lvl2']);?>"/>
                      </td>
                      <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
                      <td style="text-align: right; background-color:#e6f5fe;">
                        <!-- <?=($child['rka_thn_lvl2'] != 0 ) ? rupiah($child['rka_thn_lvl2']) : '-';?> -->
                        <input type="text" name="rka[]" class="form-control" value="<?= rupiah($child['rka_thn_lvl2']);?>"/>
                      </td>
                      <td style="text-align: right; background-color:#e6f5fe;">
                        <!-- <?=($child['sum_perst_rkasem2_lvl2'] != 0 ) ? persen($child['sum_perst_rkasem2_lvl2']).'%' : '-';?> -->
                        <input type="text" name="persentase_rka[]" class="form-control" value="<?= persen($child['sum_perst_rkasem2_lvl2']);?>"/>
                      </td>
                      <td style="text-align: right; background-color:#e6f5fe;">
                        <!-- <?=($child['nominal_lvl2'] != 0 ) ? rupiah($child['nominal_lvl2']) : '-';?> -->
                        <input type="text" name="nom_naikturun[]" class="form-control" value="<?= rupiah($child['nominal_lvl2']);?>"/>
                      </td>
                      <td style="text-align: right; background-color:#e6f5fe;">
                        <!-- <?=($child['persentase_lvl2'] != 0 ) ? persen($child['persentase_lvl2']).'%' : '-';?> -->
                        <input type="text" name="pers_naikturun[]" class="form-control" value="<?= persen($child['persentase_lvl2']);?>"/>
                      </td>
                    </tr>
                  <?php endforeach;?>

                  <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
                    <tr style="font-weight: bold; background-color:#c1e1f3;">
                      <td class="left">
                        <!-- <?=$dana_bersih['total']?> -->
                        <input type="text" name="jenis_investasi[]" class="form-control" value="<?= $dana_bersih['total'];?>"/>
                      </td>
                      <td class="right">
                        <!-- <?=($dana_bersih['sum_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_lvl1']) : '-';?> -->
                        <input type="text" name="saldo_akhir[]" class="form-control" value="<?= rupiah($dana_bersih['sum_lvl1']);?>"/>
                      </td>
                      <td class="right"><?=($dana_bersih['sum_prev_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_prev_lvl1']) : '-';?></td>
                      <td class="right">
                        <!-- <?=($dana_bersih['rka_thn_lvl1'] != 0 ) ? rupiah($dana_bersih['rka_thn_lvl1']) : '-';?> -->
                        <input type="text" name="rka[]" class="form-control" value="<?= rupiah($dana_bersih['rka_thn_lvl1']);?>"/>
                      </td>
                      <td class="right">
                        <!-- <?=($dana_bersih['sum_perst_rkasem2_lvl1'] != 0 ) ? persen($dana_bersih['sum_perst_rkasem2_lvl1']).'%' : '-';?> -->
                         <input type="text" name="persentase_rka[]" class="form-control" value="<?= persen($dana_bersih['sum_perst_rkasem2_lvl1']);?>"/>
                      </td>
                      <td class="right">
                        <!-- <?=($dana_bersih['nominal_lvl1'] != 0 ) ? rupiah($dana_bersih['nominal_lvl1']) : '-';?> -->
                        <input type="text" name="nom_naikturun[]" class="form-control" value="<?= rupiah($dana_bersih['nominal_lvl1']);?>"/>
                      </td>
                      <td class="right">
                        <!-- <?=($dana_bersih['persentase_lvl1'] != 0 ) ? persen($dana_bersih['persentase_lvl1']).'%' : '-';?> -->
                        <input type="text" name="pers_naikturun[]" class="form-control" value="<?= persen($dana_bersih['persentase_lvl1']);?>"/>
                      </td>
                    </tr>

                  <?php endif;?>

                <?php endforeach;?>
              <?php endif;?>

              <?php
              $saldo_akhir_thn_1 = (!empty($total_bersih[0]->saldo_akhir_thn) ? $total_bersih[0]->saldo_akhir_thn : '0');
              $saldo_akhir_thn_2 = (!empty($total_bersih[1]->saldo_akhir_thn) ? $total_bersih[1]->saldo_akhir_thn : '0');
              $saldo_akhir_thn_lalu_1 = (!empty($total_bersih[0]->saldo_akhir_thn_lalu) ? $total_bersih[0]->saldo_akhir_thn_lalu : '0');
              $saldo_akhir_thn_lalu_2 = (!empty($total_bersih[1]->saldo_akhir_thn_lalu) ? $total_bersih[1]->saldo_akhir_thn_lalu : '0');

              $tot = $saldo_akhir_thn_1 - $saldo_akhir_thn_2;
              $tot_prev = $saldo_akhir_thn_lalu_1 - $saldo_akhir_thn_lalu_2;
              $tot_nominal = $tot_prev - $tot;
              $tot_persen = ($tot!=0)?($tot_nominal/$tot)*100:0;

              $dbersih1 = (isset($data_dana_bersih[0]['sum_perst_rkasem2_lvl1']) ? $data_dana_bersih[0]['sum_perst_rkasem2_lvl1'] : 0) ;
              $dbersih2 = (isset($data_dana_bersih[1]['sum_perst_rkasem2_lvl1']) ? $data_dana_bersih[1]['sum_perst_rkasem2_lvl1'] : 0) ;
              $totpers_rka = $dbersih1 - $dbersih2;

              ?>
              <tr style="font-weight: bold; background-color:#d2ebf9;">
                <td style="text-align: left;">DANA BERSIH
                  <!-- <input type="text" name="total" class="form-control" value="DANA BERSIH"/> -->
                </td>
                <td style="text-align: right;"><?=rupiah($tot);?></td>
                <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"><?=persen($totpers_rka);?>%</td>
                <td style="text-align: right;"><?=rupiah($tot_nominal);?></td>
                <td style="text-align: right;"><?=persen($tot_persen);?>%</td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <button href="javascript:void(0);" id="save" class="btn btn-primary btn-flat" type="submit">
        Simpan
      </button> 
      <a href="<?php echo site_url('tahunan/aspek_keuangan');?>" class="btn btn-danger btn-flat"></i>&nbsp;&nbsp;Kembali</a>
    </div>
  </div>
</form>
<script type="text/javascript">
    $(".select2nya").select2( { 'width':'100%' } );
    $('.tahun').text(tahun);
    $('.tahun_lalu').text(tahun - 1);


    $('#example tbody').on('click','tr', function(){
      var data = table.fnGetData( this );
      alert(data);
    });


    // form action
  var rulesnya = {
    id_investasi : "required",
    rka : "required",
    
  };

  var messagesnya = {
    id_investasi : "<i style='color:red'>Harus Diisi</i>",
    rka : "<i style='color:red'>Harus Diisi</i>",
    
  }

  $( "#form_<?=$acak;?>" ).validate( {
    rules: rulesnya,
    messages: messagesnya,
    submitHandler: function(form) {
      $.LoadingOverlay("show");
      submit_form('form_<?=$acak;?>',function(r){
        if(r==1){ 
          $.messager.alert('SMART AIP','Data Tersimpan','info'); 
          $('#cancel').trigger('click');
          setTimeout(function(){
            window.location = host+'/tahunan/aspek_keuangan';
          }, 2000);
        }else{ 
          $.messager.alert('SMART AIP','Proses Simpan Data Gagal '+r,'warning'); 
        }
        $.LoadingOverlay("hide", true);
      });
    
    },
    errorPlacement: function(error, element) {
          var name = element.attr('name');
          var errorSelector = '.validation_error_message[for="' + name + '"]';
          var $element = $(errorSelector);
          if ($element.length) { 
              $(errorSelector).html(error.html());
          } else {
              error.insertAfter(element);
          }
      }
  } );
</script>


