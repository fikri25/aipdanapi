<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold;font-size: 14px">     
  Aspek Investasi
</p>
<p style="margin-left:0px;margin-top:10px;margin-bottom:10px;font-weight: bold">     
  d) Karakteristik dan Resiko Investasi
</p>
<table cellpadding="4px" cellspacing="0px" border="1" autosize="1" style="color:#000;background:#fff;font-size: 12px;">
  <thead>
    <tr>
      <th width="40%">Jenis Investasi</th>
      <th>Karakteristik</th>
      <th>Resiko</th>
    </tr>

  </thead>
  <tbody>
    <?php if(isset($data_karakter) && is_array($data_karakter)):?>
    <?php foreach($data_karakter as $beban):?>
      <?php if($beban['type'] == 'P'):?>
        <tr>
          <td style="text-align: left;"><?=$beban['jenis_investasi']?></td>
          <td style="text-align: left;"><?=($beban['karakteristik'] != '' ) ? $beban['karakteristik'] : '-';?></td>
          <td style="text-align: left;"><?=($beban['resiko'] != '' ) ?  $beban['resiko'] : '-';?></td>

        </tr>

      </tr>
    <?php endif;?>
    <?php if($beban['type'] == 'PC'):?>
      <tr>
        <td style="text-align:left;"><?=$beban['jenis_investasi']?></td>
        <td></td>
        <td></td>
      </tr>
    <?php endif;?>
    <?php foreach($beban['child'] as $child):?>
      <tr>
        <td style="text-align:left; padding-left: 30px; color: #6c7275;"><?='- '.$child['jenis_investasi']?></td>
        <td style="text-align: left;"><?=($child['karakteristik'] != '' ) ? $child['karakteristik'] : '-';?></td>
        <td style="text-align: left;"><?=($child['resiko'] != '' ) ? $child['resiko'] : '-';?></td>
      </tr>

    <?php endforeach;?>
  <?php endforeach;?>
  <?php endif;?>
</tbody>
</table>