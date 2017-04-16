<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		$model->kckr_id,
	);
?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		/*
		array(
			'name'=>'kckr_id',
			'value'=>$model->kckr_id,
		),
		*/
		array(
			'name'=>'publisher_id',
			'value'=>$model->publisher_id != '' ? $model->publisher->publisher_name : '-',
		),
		array(
			'name'=>'letter_number',
			'value'=>$model->letter_number != '' ? $model->letter_number : '-',
		),
		array(
			'name'=>'pic_id',
			'value'=>$model->pic_id != '' ? $model->pic->pic_name : '-',
		),
		array(
			'name'=>'send_type',
			'value'=>$model->send_type != 'pos' ? Yii::t('phrase', 'Pos') : Yii::t('phrase', 'Langsung'),
		),
		array(
			'name'=>'receipt_date',
			'value'=>!in_array($model->receipt_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->receipt_date) : '-',
		),
		array(
			'name'=>'photos',
			'value'=>CHtml::link($model->photos, Yii::app()->request->baseUrl.'/public/kckr/'.$model->photos, array('target' => '_blank')),
			'type' => 'raw',
		),
		array(
			'name'=>'thanks_date',
			'value'=>!in_array($model->thanks_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->thanks_date) : '-',
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
