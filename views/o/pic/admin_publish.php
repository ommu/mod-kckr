<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this PicController
 * @var $model KckrPic
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckr Pics'=>array('manage'),
		Yii::t('phrase', 'Publish'),
	);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kckr-pic-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="dialog-content">
		<?php echo $model->publish == 1 ? Yii::t('phrase', 'Are you sure you want to unpublish this item?') : Yii::t('phrase', 'Are you sure you want to publish this item?')?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($title, array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
