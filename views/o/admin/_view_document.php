<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://github.com/ommu/ommu-kckr
 *
 */
?>

<?php if(!empty($thanks_document)) {?>
	<ul>
	<?php 
	foreach($thanks_document as $key => $val) {?>
		<li><a target="_blank" href="<?php echo Yii::app()->request->baseUrl?>/public/kckr/document_pdf/<?php echo $val;?>" title="<?php echo $val;?>"><?php echo $val;?></a></li>
	<?php }?>		
	</ul>
<?php } else
	echo '-';?>
