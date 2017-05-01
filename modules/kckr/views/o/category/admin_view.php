<?php
/**
 * Kckr Categories (kckr-category)
 * @var $this CategoryController
 * @var $model KckrCategory
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:40 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Categories'=>array('manage'),
		$model->category_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			/*
			array(
				'name'=>'category_id',
				'value'=>$model->category_id,
			),
			*/
			array(
				'name'=>'category_type',
				'value'=>$model->category_type,
				'value'=>$model->publish == 'book' ? Yii::t('phrase', 'Book') : Yii::t('phrase', 'Record'),
			),
			array(
				'name'=>'category_name',
				'value'=>$model->category_name != '' ? $model->category_name : '-',
			),
			array(
				'name'=>'category_desc',
				'value'=>$model->category_desc != '' ? $model->category_desc : '-',
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
