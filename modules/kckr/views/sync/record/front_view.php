<?php
/**
 * Kckr Records (kckr-records)
 * @var $this RecordController
 * @var $model KckrRecords
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 16:44 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Records'=>array('manage'),
		$model->idsurat,
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
			'name'=>'idsurat',
			'value'=>$model->idsurat,
			//'value'=>$model->idsurat != '' ? $model->idsurat : '-',
		),
		array(
			'name'=>'kodeperekam',
			'value'=>$model->kodeperekam,
			//'value'=>$model->kodeperekam != '' ? $model->kodeperekam : '-',
		),
		array(
			'name'=>'nosurat',
			'value'=>$model->nosurat,
			//'value'=>$model->nosurat != '' ? $model->nosurat : '-',
		),
		array(
			'name'=>'tglkirimpos',
			'value'=>!in_array($model->tglkirimpos, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->tglkirimpos, true) : '-',
		),
		array(
			'name'=>'tglkirimls',
			'value'=>!in_array($model->tglkirimls, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->tglkirimls, true) : '-',
		),
		array(
			'name'=>'tglterima',
			'value'=>!in_array($model->tglterima, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->tglterima, true) : '-',
		),
		array(
			'name'=>'ucapan',
			'value'=>!in_array($model->ucapan, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->ucapan, true) : '-',
		),
		array(
			'name'=>'cekucapan',
			'value'=>$model->cekucapan,
			//'value'=>$model->cekucapan != '' ? $model->cekucapan : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
