<?php
/**
 * Kckr Books (kckr-books)
 * @var $this BookController
 * @var $data KckrBooks
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 16:44 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsurat')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idsurat), array('view', 'id'=>$data->idsurat)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kodepenerbit')); ?>:</b>
	<?php echo CHtml::encode($data->kodepenerbit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nosurat')); ?>:</b>
	<?php echo CHtml::encode($data->nosurat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkirimpos')); ?>:</b>
	<?php echo CHtml::encode($data->tglkirimpos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkirimls')); ?>:</b>
	<?php echo CHtml::encode($data->tglkirimls); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglterima')); ?>:</b>
	<?php echo CHtml::encode($data->tglterima); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ucapan')); ?>:</b>
	<?php echo CHtml::encode($data->ucapan); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cekucapan')); ?>:</b>
	<?php echo CHtml::encode($data->cekucapan); ?>
	<br />

	*/ ?>

</div>