<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this PublisherController
 * @var $model KckrPublisher
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
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

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'publisher_id',
			'value'=>$model->publisher_id,
			//'value'=>$model->publisher_id != '' ? $model->publisher_id : '-',
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->publish,
		),
		array(
			'name'=>'publisher_name',
			'value'=>$model->publisher_name,
			//'value'=>$model->publisher_name != '' ? $model->publisher_name : '-',
		),
		array(
			'name'=>'publisher_area',
			'value'=>$model->publisher_area,
			//'value'=>$model->publisher_area != '' ? $model->publisher_area : '-',
		),
		array(
			'name'=>'publisher_address',
			'value'=>$model->publisher_address != '' ? $model->publisher_address : '-',
			//'value'=>$model->publisher_address != '' ? CHtml::link($model->publisher_address, Yii::app()->request->baseUrl.'/public/visit/'.$model->publisher_address, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'publisher_phone',
			'value'=>$model->publisher_phone,
			//'value'=>$model->publisher_phone != '' ? $model->publisher_phone : '-',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id,
			//'value'=>$model->creation_id != 0 ? $model->creation_id : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id,
			//'value'=>$model->modified_id != 0 ? $model->modified_id : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
