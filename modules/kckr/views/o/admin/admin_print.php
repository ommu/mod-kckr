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

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		'Publish',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'kckrs-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>

	<div class="dialog-content">
		<?php if($condition == false)
			echo Yii::t('phrase', 'Are you sure you want to generated document print?');
		else {?>
			<fieldset>
				<?php //begin.Messages ?>
				<div id="ajax-message">
				<?php
				if(Yii::app()->user->hasFlash('error'))
					echo Utility::flashError(Yii::app()->user->getFlash('error'));
				if(Yii::app()->user->hasFlash('success'))
					echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
				?>
				</div>
				<?php //begin.Messages ?>
				
				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'thanks_document'); ?>
					<div class="desc">
						<?php $document = unserialize($model->thanks_document);
						if(!empty($document)) {
							echo '<ul>';
							foreach($document as $val) {?>
								<li><a target="_blank" href="<?php echo Yii::app()->request->baseUrl?>/public/kckr/document_pdf/<?php echo $val;?>" title="<?php echo $val;?>"><?php echo $val;?></a></li>
							<?php }
							echo '</ul>';
						}?>
						<?php echo $form->error($model,'thanks_document'); ?>
					</div>
				</div>

				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'regenerate_input'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'regenerate_input'); ?>
						<?php echo $form->labelEx($model,'regenerate_input'); ?>
						<?php echo $form->error($model,'regenerate_input'); ?>
					</div>
				</div>
			</fieldset>
		<?php }?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Generated'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
