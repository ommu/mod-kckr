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
 * @link https://github.com/ommu/mod-kckr
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('media_id'); ?><br/>
			<?php echo $form->textField($model,'media_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('kckr_id'); ?><br/>
			<?php echo $form->textField($model,'kckr_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('category_id'); ?><br/>
			<?php echo $form->textField($model,'category_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_title'); ?><br/>
			<?php echo $form->textField($model,'media_title'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_desc'); ?><br/>
			<?php echo $form->textArea($model,'media_desc'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_publish_year'); ?><br/>
			<?php echo $form->textField($model,'media_publish_year'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_author'); ?><br/>
			<?php echo $form->textArea($model,'media_author'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('media_total'); ?><br/>
			<?php echo $form->textField($model,'media_total'); ?>
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
