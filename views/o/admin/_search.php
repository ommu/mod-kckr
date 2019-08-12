<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('kckr_id'); ?><br/>
			<?php echo $form->textField($model,'kckr_id', array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('pic_id'); ?><br/>
			<?php echo $form->textField($model,'pic_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publisher_id'); ?><br/>
			<?php echo $form->textField($model,'publisher_id', array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('letter_number'); ?><br/>
			<?php echo $form->textField($model,'letter_number', array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('receipt_date'); ?><br/>
			<?php echo $form->textField($model,'receipt_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('thanks_date'); ?><br/>
			<?php echo $form->textField($model,'thanks_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id', array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id', array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
