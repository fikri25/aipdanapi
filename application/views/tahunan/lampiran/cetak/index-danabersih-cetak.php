<?php
  $tahun = $this->session->userdata('tahun');
?>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
  Lampiran Pendukung
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
  Dana Bersih
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th width="40%">URAIAN</th>
      <th width="27%">Tahun <?= $tahun; ?></th>
      <th width="27%">Tahun <?= $tahun - 1; ?></th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_dana_bersih) && is_array($data_dana_bersih)):?>
    <?php foreach($data_dana_bersih as $dana_bersih):?>
      <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
        <tr style="font-weight: bold; background-color:#c1e1f3;font-size: 14px;">
          <td style="text-align: left;color: #303a3f;" colspan="3"><?=$dana_bersih['jenis_laporan']?></td>
        </tr>
      <?php endif;?>
      <?php foreach($dana_bersih['child'] as $child):?>
        <tr>
          <td style="text-align: left; background-color:#d2ebf9;font-size: 14px;" colspan="3"><?=$child['judul_head']?></td>
        </tr>
        <?php foreach($child['subchild'] as $subchild):?>

          <?php if($subchild['type'] == 'PC'):?>
            <tr>
              <td style="text-align: left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"></td>
            </tr>
            <?php else:?>
              <tr>
                <td style="text-align: left" style="padding-left: 25px;"><?=$subchild['jenis_investasi']?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn'] != 0 ) ? rupiah($subchild['saldo_akhir_thn']) : '-';?></td>
                <td style="text-align: right;"><?=($subchild['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild['saldo_akhir_thn_lalu']) : '-';?></td>
              </tr>
            <?php endif;?>

            <?php if($subchild['type'] == 'PC'):?>
              <?php foreach($subchild['subchild_sub'] as $subchild3):?>
                <tr>
                  <td style="text-align: left" style="padding-left: 50px; color: #6c7275;"><?='- '.$subchild3['jenis_investasi']?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn']) : '-';?></td>
                  <td style="text-align: right;"><?=($subchild3['saldo_akhir_thn_lalu'] != 0 ) ? rupiah($subchild3['saldo_akhir_thn_lalu']) : '-';?></td>
                </tr>
              <?php endforeach;?>
            <?php endif;?>
          <?php endforeach;?>
          <tr style="font-weight: bold;">
            <td style="text-align: left; background-color:#e6f5fe;font-size: 14px;"><?=$child['judul_total']?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_lvl2'] != 0 ) ? rupiah($child['sum_lvl2']) : '-';?></td>
            <td style="text-align: right; background-color:#e6f5fe;"><?=($child['sum_prev_lvl2'] != 0 ) ? rupiah($child['sum_prev_lvl2']) : '-';?></td>
          </tr>
        <?php endforeach;?>

        <?php if($dana_bersih['jenis_laporan'] == 'ASET'):?>
          <tr style="font-weight: bold; background-color:#c1e1f3;">
            <td style="text-align: left"><?=$dana_bersih['total']?></td>
            <td style="text-align: right;"><?=($dana_bersih['sum_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_lvl1']) : '-';?></td>
            <td style="text-align: right;"><?=($dana_bersih['sum_prev_lvl1'] != 0 ) ? rupiah($dana_bersih['sum_prev_lvl1']) : '-';?></td>
          </tr>

        <?php endif;?>

      <?php endforeach;?>
    <?php endif;?>
    
    <?php
      $saldo_akhir1 = (!empty($total_bersih[0]->saldo_akhir_thn) ? $total_bersih[0]->saldo_akhir_thn : '0');
      $saldo_akhir2 = (!empty($total_bersih[1]->saldo_akhir_thn) ? $total_bersih[1]->saldo_akhir_thn : '0');
      $saldo_akhir_thn_lalu1 = (!empty($total_bersih[0]->saldo_akhir_thn_lalu) ? $total_bersih[0]->saldo_akhir_thn_lalu : '0');
      $saldo_akhir_thn_lalu2 = (!empty($total_bersih[1]->saldo_akhir_thn_lalu) ? $total_bersih[1]->saldo_akhir_thn_lalu : '0');

      $tot = $saldo_akhir1 - $saldo_akhir2;
      $tot_prev = $saldo_akhir_thn_lalu1 - $saldo_akhir_thn_lalu2;

    ?>
    <tr style="font-weight: bold; background-color:#d2ebf9;">
      <td style="text-align: left;">DANA BERSIH</td>
      <td style="text-align: right;"><?=rupiah($tot);?></td>
      <td style="text-align: right;"><?=rupiah($tot_prev);?></td>
    </tr>

  </tbody>
</table>