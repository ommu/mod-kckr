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
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'kckr-pic-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => true,
	),
)); ?>
<div class="dialog-content">
	<fieldset>
		
		<?php /*
		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>
		*/ ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'pic_name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'pic_name', array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'pic_name'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'pic_nip'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'pic_nip', array('maxlength'=>32)); ?>
				<?php echo $form->error($model,'pic_nip'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'pic_position'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'pic_position', array('maxlength'=>64)); ?>
				<?php echo $form->error($model,'pic_position'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		
		<?php if(!$model->isNewRecord && $model->pic_signature != '') {
			$model->old_pic_signature = $model->pic_signature;
			echo $form->hiddenField($model,'old_pic_signature');
			$picPhoto = Yii::app()->request->baseUrl.'/public/kckr/pic/'.$model->old_pic_signature;?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'old_pic_signature'); ?>
				<div class="desc">
					<img src="<?php echo $picPhoto;?>">
					<?php echo $form->error($model,'old_pic_signature'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'pic_signature'); ?>
			<div class="desc">
				<?php echo $form->fileField($model,'pic_signature'); ?>
				<?php echo $form->error($model,'pic_signature'); ?>
				<div class="small-px silent">extensions are allowed: bmp, gif, jpg, png and<br/>image size width=250px height=150px</div>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'default'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'default'); ?>
				<?php echo $form->labelEx($model,'default'); ?>
				<?php echo $form->error($model,'default'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') , array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


