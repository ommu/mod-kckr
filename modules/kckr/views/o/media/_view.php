<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $data KckrMedia
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('media_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->media_id), array('view', 'id'=>$data->media_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish')); ?>:</b>
	<?php echo CHtml::encode($data->publish); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kckr_id')); ?>:</b>
	<?php echo CHtml::encode($data->kckr_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('media_title')); ?>:</b>
	<?php echo CHtml::encode($data->media_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('media_desc')); ?>:</b>
	<?php echo CHtml::encode($data->media_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('media_publish_year')); ?>:</b>
	<?php echo CHtml::encode($data->media_publish_year); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('media_author')); ?>:</b>
	<?php echo CHtml::encode($data->media_author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('media_total')); ?>:</b>
	<?php echo CHtml::encode($data->media_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_id')); ?>:</b>
	<?php echo CHtml::encode($data->creation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_id')); ?>:</b>
	<?php echo CHtml::encode($data->modified_id); ?>
	<br />

	*/ ?>

</div>