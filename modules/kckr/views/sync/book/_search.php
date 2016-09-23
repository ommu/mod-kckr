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

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('idsurat'); ?><br/>
			<?php echo $form->textField($model,'idsurat'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('kodepenerbit'); ?><br/>
			<?php echo $form->textField($model,'kodepenerbit'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('nosurat'); ?><br/>
			<?php echo $form->textField($model,'nosurat',array('size'=>60,'maxlength'=>100)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('tglkirimpos'); ?><br/>
			<?php echo $form->textField($model,'tglkirimpos'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('tglkirimls'); ?><br/>
			<?php echo $form->textField($model,'tglkirimls'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('tglterima'); ?><br/>
			<?php echo $form->textField($model,'tglterima'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('ucapan'); ?><br/>
			<?php echo $form->textField($model,'ucapan'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cekucapan'); ?><br/>
			<?php echo $form->textField($model,'cekucapan',array('size'=>1,'maxlength'=>1)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
