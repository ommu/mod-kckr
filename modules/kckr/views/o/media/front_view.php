<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $model KckrMedia
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
		'Kckr Medias'=>array('manage'),
		$model->media_id,
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
			'name'=>'media_id',
			'value'=>$model->media_id,
			//'value'=>$model->media_id != '' ? $model->media_id : '-',
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->publish,
		),
		array(
			'name'=>'kckr_id',
			'value'=>$model->kckr_id,
			//'value'=>$model->kckr_id != '' ? $model->kckr_id : '-',
		),
		array(
			'name'=>'category_id',
			'value'=>$model->category_id,
			//'value'=>$model->category_id != '' ? $model->category_id : '-',
		),
		array(
			'name'=>'media_title',
			'value'=>$model->media_title,
			//'value'=>$model->media_title != '' ? $model->media_title : '-',
		),
		array(
			'name'=>'media_desc',
			'value'=>$model->media_desc != '' ? $model->media_desc : '-',
			//'value'=>$model->media_desc != '' ? CHtml::link($model->media_desc, Yii::app()->request->baseUrl.'/public/visit/'.$model->media_desc, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'media_publish_year',
			'value'=>$model->media_publish_year,
			//'value'=>$model->media_publish_year != '' ? $model->media_publish_year : '-',
		),
		array(
			'name'=>'media_author',
			'value'=>$model->media_author != '' ? $model->media_author : '-',
			//'value'=>$model->media_author != '' ? CHtml::link($model->media_author, Yii::app()->request->baseUrl.'/public/visit/'.$model->media_author, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'media_total',
			'value'=>$model->media_total,
			//'value'=>$model->media_total != '' ? $model->media_total : '-',
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
