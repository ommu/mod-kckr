<style type="text/css">
	html, body, div, span, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, code,
	del, dfn, em, img, q, dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	input, button, select, textarea,
	table, caption, tbody, tfoot, thead, tr, th, td,
	article, aside, details, figcaption, figure, footer, header,
	hgroup, nav, section {
		color: #111; 
		font-size: 12px; 
		line-height: 16px;
		font-weight: 400;
	}
	table {width: 100%; border-collapse: collapse; border-spacing: 0;}
	table.attachment th,
	table.attachment td {
		padding: 7px 7px;
	}
	table.attachment th {
		background: #bbb;
		border: 1px solid #aaa;
		font-weight: bold;
		text-align: center;
	}
	table.attachment td {
		border: 1px solid #ccc;
	}
	table.attachment td.center {
		text-align: center;
	}
	table.attachment tr.even td {
		background: #f9f9f9;
		border: 1px solid #ccc;
	}
	div.copyright,
	div.copyright * {
		font-size: 12px;
		line-height: 15px;
		color: #bbb;
	}
	div.copyright {
		position: absolute;
		left: 0;
		top: 100%;
		width: 100%;
		padding: 0 0 20px 0;
		text-align: center;
	}
	div.copyright a {
		text-decoration: none;
		font-weight: bold;
	}
</style>

<page backtop="15mm" backbottom="15mm" backleft="55mm" backright="30mm" style="font-size: 12pt">
<div style="position: relative;">
	<table class="attachment" style="width: 100%;">
		<tr>
			<th style="vertical-align: middle; width: 1px;"><strong><?php echo strtoupper('No');?></strong></th>
			<th style="vertical-align: middle; width: 170px;"><strong><?php echo strtoupper('Judul Karya Cetak/ Rekam');?></strong></th>
			<th style="vertical-align: middle; width: 140px;"><strong><?php echo strtoupper('Penulis/ Pencipta/ Komposer/ Pengaransir/ Sutradara');?></strong></th>
			<th style="vertical-align: middle; width: 180px;"><strong><?php echo strtoupper('Nama Perusahaan Penerbit/ Rekaman');?></strong></th>
			<th style="vertical-align: middle; width: 50px;"><strong><?php echo strtoupper('Tahun Terbit/ Rekam');?></strong></th>
			<th style="vertical-align: middle; width: 90px;"><strong><?php echo strtoupper('Tanggal Terima');?></strong></th>
			<th style="vertical-align: middle; width: 50px;"><strong><?php echo strtoupper('Jumlah Rekaman');?></strong></th>
			<th style="vertical-align: middle; width: 120px;"><strong><?php echo strtoupper('Keterangan');?></strong></th>
		</tr>
		<?php 
		$i=0;
		foreach($model as $key => $val) {
		$i++; ?>
		<tr <?php echo $i%2 == 0 ? 'class="even"' : '';?>>
			<td class="center" style="vertical-align: middle; width: 1px;"><?php echo $i;?></td>
			<td style="vertical-align: middle; width: 170px;"><?php echo $val->media_title;?></td>
			<td style="vertical-align: middle; width: 140px;"><?php echo $val->media_author != '' ? $val->media_author : '-';?></td>
			<td style="vertical-align: middle; width: 180px;"><?php echo $val->kckr->publisher->publisher_name;?></td>
			<td class="center" style="vertical-align: middle; width: 50px;"><?php echo $val->media_publish_year != '' && $val->media_publish_year != '0000' ? $val->media_publish_year : '';?></td>
			<td class="center" style="vertical-align: middle; width: 90px;"><?php echo $val->kckr->send_type != '' ? ($val->kckr->send_type == 'pos' ? 'POS<br/>' : 'Langsung<br/>') : '';?><?php echo date('d', strtotime($val->kckr->send_date)).' '.Utility::getLocalMonthName($val->kckr->send_date).' '.date('Y', strtotime($val->kckr->send_date));?></td>
			<td class="center" style="vertical-align: middle; width: 50px;"><?php echo $val->media_item;?></td>
			<td style="vertical-align: middle; width: 120px;"><?php echo $val->media_desc != '' ? $val->media_desc : '-';?></td>
		</tr>
		<?php }?>
	</table>
	<br/><br/>
		
	<table style="width: 100%;">
		<tr>
			<td style="vertical-align: bottom; width: 60%;">
				<strong>Keterangan :</strong><br/>
				Lembar:&nbsp;&nbsp;1. Untuk menyerahkan (Penerbit/Pengusaha Rekaman)<br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Untuk yang menerima (Badan Perpustakaan dan Arsip Daerah Prop. DIY)<br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Untuk Bidang DPBP (Subbid Deposit)
			</td>
			<td style="vertical-align: top; width: 40%;">
				<?php $data = $model[0]->kckr->thanks_date;?>
				Yogyakarta, <?php echo date('d', strtotime($data)).' '.Utility::getLocalMonthName($data).' '.date('Y', strtotime($data));?><br/>
				<?php echo $model[0]->kckr->pic->pic_position?>
				<?php if($model[0]->kckr->pic->pic_signature != '') {
					$images = YiiBase::getPathOfAlias('webroot.public.kckr.pic').'/'.$model[0]->kckr->pic->pic_signature;?>
					<br/><br/>
					<img src="<?php echo $images;?>" style="height: 100px;">
					<br/><br/>
				<?php } else {?>
					<br/><br/><br/><br/><br/><br/>
				<?php }?>
				<?php echo $model[0]->kckr->pic->pic_name?><br/>
				NIP. <?php echo $model[0]->kckr->pic->pic_nip?>
			</td>
		</tr>
	</table>
</div>
</page>