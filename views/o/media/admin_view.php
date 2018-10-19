<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $model KckrMedia
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckr Medias'=>array('manage'),
		$model->media_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'media_id',
				'value'=>$model->media_id,
			),
			array(
				'name'=>'publish',
				'value'=>$this->quickAction(Yii::app()->controller->createUrl('publish', array('id'=>$model->media_id)), $model->publish),
				'type'=>'raw',
			),
			array(
				'name'=>'publisher_search',
				'value'=>$model->kckr_id ? $model->kckr->publisher->publisher_name : '-',
			),
			array(
				'name'=>'letter_search',
				'value'=>$model->kckr->letter_number ? $model->kckr->letter_number : '-',
			),
			array(
				'name'=>'category_id',
				'value'=>$model->category_id ? $model->category->category_name : '-',
			),
			array(
				'name'=>'media_title',
				'value'=>$model->media_title ? $model->media_title : '-',
			),
			array(
				'name'=>'media_desc',
				'value'=>$model->media_desc ? $model->media_desc : '-',
			),
			array(
				'name'=>'media_publish_year',
				'value'=>!in_array($model->media_publish_year, array('0000','1970')) ? $model->media_publish_year : '-',
			),
			array(
				'name'=>'media_author',
				'value'=>$model->media_author ? $model->media_author : '-',
			),
			array(
				'name'=>'media_item',
				'value'=>$model->media_item ? $model->media_item : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date) : '-',
			),
			array(
				'name'=>'creation_search',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date) : '-',
			),
			array(
				'name'=>'modified_search',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
