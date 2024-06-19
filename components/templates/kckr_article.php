<p>Pada hari <?php echo Utility::getLocalDayName($kckr->receipt_date, false).', '.date('d', strtotime($kckr->receipt_date)).' '.Utility::getLocalMonthName($kckr->receipt_date).' '.date('Y', strtotime($kckr->receipt_date))?> bertempat di Grhatama Pustaka BPAD DIY Jalan Janti, Karangjambe, Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta, Indonesia melalui Subbidang Deposit dan Pengelolaan Bahan Pustaka telah diserahkan Karya Cetak dari <?php echo $kckr->publisher->publisher_name?><?php echo $kckr->publisher->publisher_address != '' ? ' yang beralamat di '.$kckr->publisher->publisher_address : ''?>. Pada Kesempatan ini penyerahan Karya Cetak dari Penerbit <?php echo $kckr->publisher->publisher_name?> di serahkan oleh ___________ sebagai ___________.</p>

<p>Kegiatan Ini sebagai bagian dari Pelaksanaan Undang-undang No.4 Tahun 1990 tentang serah simpan karya cetak dan karya rekam,Peraturan Daerah DIY No.12 Tahun 2005 tentang serah simpan karya cetak dan karya rekam Provinsi Daerah Istimewa Yogyakarta, dan Peraturan Gubernur No.45 Tahun 2006 tentang petunjuk Pelaksanaan Perda No.12Tahun 2005. Adapun judul dan rincian Karya Cetak yang diserahkan terdiri yaitu:</p>

<?php $attachment = $kckr->media_publish;
if (!empty($attachment)) {?>
<table>
    <tbody>
        <tr>
            <th>NO</th>
            <th>JUDUL</th>
            <th>PENULIS</th>
            <th>JUMLAH</th>
        </tr>
		<?php 
		$i = 0;
        foreach ($attachment as $key => $val) {
			$i++;?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $val->media_title;?></td>
				<td><?php echo $val->media_author != '' ? $val->media_author : '-';?></td>
				<td><?php echo $val->media_item;?></td>
			</tr>
		<?php }?>
    </tbody>
</table>
<?php }?>
<br/>
<p>Badan Perpustakaan dan Arsip Daerah DIY menyampaikan ucapan terima kasih dan penghargaan setinggi-tingginya atas diserahkannya Karya Cetak maupun Karya Rekam dari <?php echo $kckr->publisher->publisher_name?></p>