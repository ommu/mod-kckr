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

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'kckrs-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>

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
		<?php echo $form->labelEx($publisher,'publisher_name'); ?>
		<div class="desc">
			<?php 
			//echo $form->textField($publisher,'publisher_name',array('maxlength'=>64,'class'=>'span-7'));		
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model' => $publisher,
				'attribute' => 'publisher_name',
				'source' => Yii::app()->controller->createUrl('o/publisher/suggest'),
				'options' => array(
					//'delay '=> 50,
					'minLength' => 1,
					'showAnim' => 'fold',
					'select' => "js:function(event, ui) {
						$('form #KckrPublisher_publisher_name').val(ui.item.value);
						$('form #Kckrs_publisher_id').val(ui.item.id);
					}"
				),
				'htmlOptions' => array(
					'class'	=> 'span-6',
					'maxlength'=>64,
				),
			));
			echo $form->hiddenField($model,'publisher_id');?>
			<?php echo $form->error($publisher,'publisher_name'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'letter_number'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'letter_number',array('maxlength'=>64,'class'=>'span-6')); ?>
			<?php echo $form->error($model,'letter_number'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($pic,'pic_name'); ?>
		<div class="desc">
			<?php 
			//echo $form->textField($model,'pic_name',array('maxlength'=>64,'class'=>'span-7'));	
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model' => $pic,
				'attribute' => 'pic_name',
				'source' => Yii::app()->controller->createUrl('o/pic/suggest'),
				'options' => array(
					//'delay '=> 50,
					'minLength' => 1,
					'showAnim' => 'fold',
					'select' => "js:function(event, ui) {
						$('form #KckrPic_pic_name').val(ui.item.value);
						$('form #Kckrs_pic_id').val(ui.item.id);
					}"
				),
				'htmlOptions' => array(
					'class'	=> 'span-6',
					'maxlength'=>64,
				),
			));
			echo $form->hiddenField($model,'pic_id'); ?>
			<?php echo $form->error($pic,'pic_name'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'send_type'); ?>
		<div class="desc">
			<?php 
			$send_type = array(
				'pos'=>Yii::t('phrase', 'Pos'),
				'langsung'=>Yii::t('phrase', 'Langsung'),				
			);
			echo $form->dropDownList($model,'send_type', $send_type, array('prompt'=>Yii::t('phrase', 'Select Type'))); ?>
			<?php echo $form->error($model,'send_type'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'send_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->send_date != '0000-00-00' ? $model->send_date = date('d-m-Y', strtotime($model->send_date)) : '') : '';
			//echo $form->textField($model,'send_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'send_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'send_date'); ?>
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
	
	<?php if(!$model->isNewRecord) {
		$model->photo_old_input = $model->photos;
		echo $form->hiddenField($model,'photo_old_input');
		if($model->photos != '') {
			$setting = KckrSetting::getInfo(1);
			$resizeSize = unserialize($setting->photo_view_size);
			$filePhoto = Yii::app()->request->baseUrl.'/public/kckr/'.$model->photo_old_input;
			$photo = '<img src="'.Utility::getTimThumb($filePhoto, $resizeSize['small']['width'], $resizeSize['small']['height'], 1).'" alt="">';
			echo '<div class="clearfix">';
			echo $form->labelEx($model,'photo_old_input');
			echo '<div class="desc">'.$photo.'</div>';
			echo '</div>';
		}
	}?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'photos'); ?>
		<div class="desc">
			<?php echo $form->fileField($model,'photos'); ?>
			<?php echo $form->error($model,'photos'); ?>
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


