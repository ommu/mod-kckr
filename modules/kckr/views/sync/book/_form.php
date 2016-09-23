<?php
/**
 * Kckr Books (kckr-books)
 * @var $this BookController
 * @var $model KckrBooks
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 23 September 2016, 16:44 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'kckr-books-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'kodepenerbit'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'kodepenerbit'); ?>
			<?php echo $form->error($model,'kodepenerbit'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'nosurat'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'nosurat',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'nosurat'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'tglkirimpos'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->tglkirimpos != '0000-00-00' ? $model->tglkirimpos = date('d-m-Y', strtotime($model->tglkirimpos)) : '') : '';
			//echo $form->textField($model,'tglkirimpos');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'tglkirimpos',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'tglkirimpos'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'tglkirimls'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->tglkirimls != '0000-00-00' ? $model->tglkirimls = date('d-m-Y', strtotime($model->tglkirimls)) : '') : '';
			//echo $form->textField($model,'tglkirimls');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'tglkirimls',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'tglkirimls'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'tglterima'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->tglterima != '0000-00-00' ? $model->tglterima = date('d-m-Y', strtotime($model->tglterima)) : '') : '';
			//echo $form->textField($model,'tglterima');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'tglterima',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'tglterima'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'ucapan'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->ucapan != '0000-00-00' ? $model->ucapan = date('d-m-Y', strtotime($model->ucapan)) : '') : '';
			//echo $form->textField($model,'ucapan');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'ucapan',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'ucapan'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'cekucapan'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'cekucapan',array('size'=>1,'maxlength'=>1)); ?>
			<?php echo $form->error($model,'cekucapan'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


