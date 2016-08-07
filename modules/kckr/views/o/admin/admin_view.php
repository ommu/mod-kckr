<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
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
			'name'=>'kckr_id',
			'value'=>$model->kckr_id,
			//'value'=>$model->kckr_id != '' ? $model->kckr_id : '-',
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->publish,
		),
		array(
			'name'=>'pic_id',
			'value'=>$model->pic_id,
			//'value'=>$model->pic_id != '' ? $model->pic_id : '-',
		),
		array(
			'name'=>'publisher_id',
			'value'=>$model->publisher_id,
			//'value'=>$model->publisher_id != '' ? $model->publisher_id : '-',
		),
		array(
			'name'=>'category_id',
			'value'=>$model->category_id,
			//'value'=>$model->category_id != '' ? $model->category_id : '-',
		),
		array(
			'name'=>'letter_number',
			'value'=>$model->letter_number,
			//'value'=>$model->letter_number != '' ? $model->letter_number : '-',
		),
		array(
			'name'=>'receipt_date',
			'value'=>!in_array($model->receipt_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->receipt_date, true) : '-',
		),
		array(
			'name'=>'thanks_date',
			'value'=>!in_array($model->thanks_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->thanks_date, true) : '-',
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
