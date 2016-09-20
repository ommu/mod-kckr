<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php if($model->isNewRecord) {?>
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'kckrs-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
			'on_post' => '',
		),
	)); ?>
<?php } else {?>
	<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'kckrs-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>
<?php }?>

<?php if($model->isNewRecord) {?>
	<div class="dialog-content">
<?php }?>

<?php if(!$model->isNewRecord) {?>
<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>
<?php }?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'pic_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'pic_id'); ?>
			<?php echo $form->error($model,'pic_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'publisher_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'publisher_id',array('maxlength'=>11)); ?>
			<?php echo $form->error($model,'publisher_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<div class="desc">
			<?php 
				if($category != null)
					echo $form->dropDownList($model,'category_id', $category, array('prompt'=>Yii::t('phrase', 'Select Category')));
				else
					echo $form->dropDownList($model,'category_id', array('prompt'=>Yii::t('phrase', 'No Category')));?>
			<?php echo $form->error($model,'category_id'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'letter_number'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'letter_number',array('maxlength'=>64)); ?>
			<?php echo $form->error($model,'letter_number'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'receipt_type'); ?>
		<div class="desc">
			<?php 
			$receipt_type = array(
				'pos'=>Yii::t('phrase', 'Pos'),
				'langsung'=>Yii::t('phrase', 'Langsung'),				
			);
			echo $form->dropDownList($model,'receipt_type', $receipt_type, array('prompt'=>Yii::t('phrase', 'Select Type'))); ?>
			<?php echo $form->error($model,'receipt_type'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'receipt_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->receipt_date != '0000-00-00' ? $model->receipt_date = date('d-m-Y', strtotime($model->receipt_date)) : '') : '';
			//echo $form->textField($model,'receipt_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'receipt_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'receipt_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<?php if(!$model->isNewRecord) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'thanks_date'); ?>
			<div class="desc">
				<?php
				!$model->isNewRecord ? ($model->thanks_date != '0000-00-00' ? $model->thanks_date = date('d-m-Y', strtotime($model->thanks_date)) : '') : '';
				//echo $form->textField($model,'thanks_date');
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$model,
					'attribute'=>'thanks_date',
					//'mode'=>'datetime',
					'options'=>array(
						'dateFormat' => 'dd-mm-yy',
					),
					'htmlOptions'=>array(
						'class' => 'span-4',
					 ),
				)); ?>
				<?php echo $form->error($model,'thanks_date'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
	<?php }?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'publish'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<?php if(!$model->isNewRecord) {?>
		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>
	<?php }?>

</fieldset>

<?php if($model->isNewRecord) {?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
<?php }?>

<?php $this->endWidget(); ?>


