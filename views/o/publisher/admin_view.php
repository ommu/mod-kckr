<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this PublisherController
 * @var $model KckrPublisher
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link https://github.com/ommu/ommu-kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckr Publishers'=>array('manage'),
		$model->publisher_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'publisher_id',
				'value'=>$model->publisher_id,
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				'type'=>'raw',
			),
			array(
				'name'=>'publisher_name',
				'value'=>$model->publisher_name ? $model->publisher_name : '-',
			),
			array(
				'name'=>'publisher_area',
				'value'=>$model->publisher_area ? Yii::t('phrase', 'Luar Yogyakarta') : Yii::t('phrase', 'Yogyakarta'),
			),
			array(
				'name'=>'publisher_address',
				'value'=>$model->publisher_address ? $model->publisher_address : '-',
			),
			array(
				'name'=>'publisher_phone',
				'value'=>$model->publisher_phone ? $model->publisher_phone : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation_id ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date, true) : '-',
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
