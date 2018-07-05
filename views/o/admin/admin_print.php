<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://github.com/ommu/ommu-kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		'Publish',
	);
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'kckrs-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>

	<div class="dialog-content">
		<fieldset>
			<?php //begin.Messages ?>
			<div id="ajax-message">
			<?php
			if(Yii::app()->user->hasFlash('error'))
				echo $this->flashMessage(Yii::app()->user->getFlash('error'), 'error');
			if(Yii::app()->user->hasFlash('success'))
				echo $this->flashMessage(Yii::app()->user->getFlash('success'), 'success');
			?>
			</div>
			<?php //begin.Messages ?>
			
			<?php if($condition == false) {?>
				<div class="mb-15">
					<?php echo Yii::t('phrase', 'Are you sure you want to generated document print?');?>
				</div>
			<?php }?>
				
			<?php if($condition == true) {?>
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
			<?php }?>
			
			<div class="clearfix">
				<?php echo $form->labelEx($model,'thanks_date'); ?>
				<div class="desc">
					<?php
					if(isset($_POST['Kckrs']) && trim($model->thanks_date) == '')
						$model->thanks_date = '';
					else
						$model->thanks_date = !$model->isNewRecord ? (!in_array($model->thanks_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? date('d-m-Y', strtotime($model->thanks_date)) : '') : '';
					//echo $form->textField($model,'thanks_date');
					$this->widget('application.libraries.core.components.system.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'thanks_date',
						//'mode'=>'datetime',
						'options'=>array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'class' => 'span-4',
						 ),
					)); ?>
					<?php echo $form->error($model,'thanks_date'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Yii::t('phrase', 'Generated'), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
