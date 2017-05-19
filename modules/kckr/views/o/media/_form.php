<?php
/**
 * Kckr Medias (kckr-media)
 * @var $this MediaController
 * @var $model KckrMedia
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'kckr-media-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<?php if($model->isNewRecord && !isset($_GET['id'])) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'kckr_id'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'kckr_id',array('maxlength'=>11)); ?>
				<?php echo $form->error($model,'kckr_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'category_id'); ?>
			<div class="desc">
				<?php 
				$category = KckrCategory::getCategory();
				if($category != null)
					echo $form->dropDownList($model,'category_id', $category, array('prompt'=>Yii::t('phrase', 'Select Category')));
				else
					echo $form->dropDownList($model,'category_id', array('prompt'=>Yii::t('phrase', 'No Category')));?>
				<?php echo $form->error($model,'category_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_title'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'media_title',array('class'=>'span-8')); ?>
				<?php echo $form->error($model,'media_title'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_desc'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'media_desc',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller')); ?>
				<?php echo $form->error($model,'media_desc'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_author'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'media_author',array('class'=>'span-6')); ?>
				<?php echo $form->error($model,'media_author'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_publish_year'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'media_publish_year',array('maxlength'=>4, 'class'=>'span-4')); ?>
				<?php echo $form->error($model,'media_publish_year'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'media_total'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'media_total', array('class'=>'span-3')); ?>
				<?php echo $form->error($model,'media_total'); ?>
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
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


