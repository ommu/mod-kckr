<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this PicController
 * @var $model KckrPic
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Pics'=>array('manage'),
		$model->pic_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			/*
			array(
				'name'=>'pic_id',
				'value'=>$model->pic_id,
			),
			*/
			array(
				'name'=>'pic_name',
				'value'=>$model->pic_name != '' ? $model->pic_name : '-',
			),
			array(
				'name'=>'pic_nip',
				'value'=>$model->pic_nip != '' ? $model->pic_nip : '-',
			),
			array(
				'name'=>'pic_position',
				'value'=>$model->pic_position != '' ? $model->pic_position : '-',
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
