<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $model KckrMedia
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
		'Kckr Medias'=>array('manage'),
		Yii::t('phrase', 'Delete'),
	);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kckr-media-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="dialog-content">
		<?php echo Yii::t('phrase', 'Are you sure you want to delete this item?');?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Delete'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
