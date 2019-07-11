<?php
use ommu\kckr\models\KckrPic;
?>

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
		font-size: 13px; 
		line-height: 17px;
		font-weight: 400;
	}
	table {width: 100%; border-collapse: collapse; border-spacing: 0;}
	div.copyright,
	div.copyright * {
		font-size: 12px;
		line-height: 15px;
		color: #bbb;
	}
	div.copyright {
		position: absolute;
		left: 0;
		bottom: 25mm;
		width: 100%;
		padding: 0 0 20px 0;
		text-align: center;
	}
	div.copyright a {
		text-decoration: none;
		font-weight: bold;
	}
</style>

<page tyle="font-size: 12pt">
<div style="height: 99%;">
	<?php $kop = join('/', [$kckrAsset->basePath, 'images', '{$letter_kop}']);
	if(!file_exists($kop))
		$kop = join('/', [$kckrAsset->basePath, 'images', 'bpad_kop.png']);?>
	<img style="width: 100%;" src="<?php echo $kop;?>" alt="">
	
	<div style="padding-left: 30mm; padding-right: 30mm; width: 71%;">
		<table style="width: 100%;">
			<tr>
				<td style="vertical-align: top; width: 10%;">No</td>
				<td style="vertical-align: top;">:&nbsp;&nbsp;</td>
				<td style="vertical-align: top; width: 45%;"></td>
				<td style="vertical-align: top; width: 40%; text-align: right;">Yogyakarta, <?php echo Yii::$app->formatter->asDate($model->thanks_date, 'long');?></td>
			</tr>
			<tr>
				<td style="vertical-align: top; width: 10%;">Lamp</td>
				<td style="vertical-align: top;">:&nbsp;&nbsp;</td>
				<td style="vertical-align: top; width: 85%;" colspan="2"></td>
			</tr>
			<tr>
				<td style="vertical-align: top; width: 10%;">Perihal</td>
				<td style="vertical-align: top;">:&nbsp;&nbsp;</td>
				<td style="vertical-align: top; width: 85%;" colspan="2">Ucapan terima kasih</td>
			</tr>
		</table>
		<br/><br/>
		
		<div>
			Kepada Yth,<br/>
			<?php echo $model->publisher->publisher_name?>
			<br/><br/>
			Dengan hormat kami beritahukan bahwa Karya Cetak/Karya Rekam yang saudara kirim, sebagai pelaksanaan Perda Prov. DIY No. 12 Tahun 2005 tentang Sejarah Simpan Karya Cetak dan Karya Rekam Provinsi DIY dengan surat pengantar :
			<br/><br/>
			Nomor&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $model->letter_number?><br/>
			Hari/Tanggal&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo !in_array($model->send_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? /*Utility::getLocalDayName($model->send_date, false).', '.*/Yii::$app->formatter->asDate($model->send_date, 'long') : '-';?><br/>
			Sebanyak&nbsp;&nbsp;:&nbsp;&nbsp;<?php $count = $model->getMedias('count'); echo $count ? $count.' judul '.$model->getMedias('sum').' eks.' : '-';?>
			<br/><br/>
			telah diterima dengan baik dan lengkap seperti daftar lampir.<br/>
			Demikian atas perhatian dan kerjasama yang baik selama ini diucapkan terimakasih.	
		</div>
		<br/><br/><br/>
		
		<table style="width: 100%;">
			<tr>
				<td style="vertical-align: top; width: 50%;"></td>
				<td style="vertical-align: top; width: 50%;">
					<?php echo $model->pic->pic_position?>
					<?php if($model->pic->pic_signature != '') {
						$images = join('/', [KckrPic::getUploadPath(), $model->pic->pic_signature]);?>
						<br/><br/>
						<img src="<?php echo $images;?>" style="height: 100px;">
						<br/><br/>
					<?php } else {?>
						<br/><br/><br/><br/><br/><br/>
					<?php }?>
					<?php echo $model->pic->pic_name?><br/>
					NIP. <?php echo $model->pic->pic_nip?>
				</td>
			</tr>
		</table>
	</div>
</div>
</page>