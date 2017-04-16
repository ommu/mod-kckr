<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this PublisherController
 * @var $model KckrPublisher
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Publishers'=>array('manage'),
		$model->publisher_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			/*
			array(
				'name'=>'publisher_id',
				'value'=>$model->publisher_id,
			),
			*/
			array(
				'name'=>'publisher_name',
				'value'=>$model->publisher_name != '' ? $model->publisher_name : '-',
			),
			array(
				'name'=>'publisher_area',
				'value'=>$model->publisher_area,
				'value'=>$model->publisher_area == 1 ? Yii::t('phrase', 'Yogyakarta') : Yii::t('phrase', 'Luar Yogyakarta'),
			),
			array(
				'name'=>'publisher_address',
				'value'=>$model->publisher_address != '' ? $model->publisher_address : '-',
			),
			array(
				'name'=>'publisher_phone',
				'value'=>$model->publisher_phone != '' ? $model->publisher_phone : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation_id != 0 ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified_id != 0 ? $model->modified->displayname : '-',
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == 1 ? Yii::t('phrase', 'Publish') : Yii::t('phrase', 'Unpublish'),
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
