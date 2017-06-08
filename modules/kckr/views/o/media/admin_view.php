<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $model KckrMedia
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
		'Kckr Medias'=>array('manage'),
		$model->media_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'media_id',
				'value'=>$model->media_id,
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
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
				'value'=>$model->media_publish_year ? $model->media_publish_year : '-',
			),
			array(
				'name'=>'media_author',
				'value'=>$model->media_author ? $model->media_author : '-',
			),
			array(
				'name'=>'media_total',
				'value'=>$model->media_total ? $model->media_total : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation_id ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified_id ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
