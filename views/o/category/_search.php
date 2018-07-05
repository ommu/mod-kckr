<?php
/**
 * Kckr Categories (kckr-category)
 * @var $this CategoryController
 * @var $model KckrCategory
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:40 WIB
 * @link https://github.com/ommu/ommu-kckr
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('category_id'); ?><br/>
			<?php echo $form->textField($model,'category_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('category_type'); ?><br/>
			<?php echo $form->textField($model,'category_type'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('category_code'); ?><br/>
			<?php echo $form->textField($model,'category_code'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('category_name'); ?><br/>
			<?php echo $form->textField($model,'category_name'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('category_desc'); ?><br/>
			<?php echo $form->textArea($model,'category_desc'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
