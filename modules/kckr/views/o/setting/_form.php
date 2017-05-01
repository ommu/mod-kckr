<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this SettingController
 * @var $model KckrSetting
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 16 September 2016, 23:07 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */
 
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('input[name="KckrSetting[photo_resize]"]').live('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#resize_size').slideDown();
		} else {
			$('div#resize_size').slideUp();
		}
	});
	$('input[name="KckrSetting[article_sync]"]').live('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#article_sync').slideDown();
		} else {
			$('div#article_sync').slideUp();
		}
	});
EOP;
	$cs->registerScript('resize', $js, CClientScript::POS_END); 
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'kckr-setting-form',
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
			<label>
				<?php echo $model->getAttributeLabel('license');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please contact support team.');?></span>
			</label>
			<div class="desc">
				<?php if($model->isNewRecord)
					echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4'));
				else
					echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4','disabled'=>'disabled'));?>
				<?php echo $form->error($model,'license'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'Format: XXXX-XXXX-XXXX-XXXX');?></span>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'permission'); ?>
			<div class="desc">
				<span class="small-px"><?php echo Yii::t('phrase', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the General Settings page.');?></span>
				<?php echo $form->radioButtonList($model, 'permission', array(
					1 => Yii::t('phrase', 'Yes, the public can view KCKR unless they are made private.'),
					0 => Yii::t('phrase', 'No, the public cannot view KCKR.'),
				)); ?>
				<?php echo $form->error($model,'permission'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_keyword'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_keyword'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'meta_description'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
				<?php echo $form->error($model,'meta_description'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo Yii::t('phrase', 'Photo Setting');?> <span class="required">*</span></label>
			<div class="desc">
				<p><?php echo $model->getAttributeLabel('photo_resize');?></p>
				<?php echo $form->radioButtonList($model, 'photo_resize', array(
					0 => Yii::t('phrase', 'No, not resize photo after upload.'),
					1 => Yii::t('phrase', 'Yes, resize photo after upload.'),
				)); ?>
				
				<?php if(!$model->getErrors()) {
					$model->photo_resize_size = unserialize($model->photo_resize_size);
					$model->photo_view_size = unserialize($model->photo_view_size);
				}?>
				
				<div id="resize_size" class="mt-15 <?php echo $model->photo_resize == 0 ? 'hide' : '';?>">
					<?php echo Yii::t('phrase', 'Width').': ';?><?php echo $form->textField($model,'photo_resize_size[width]',array('maxlength'=>4,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
					<?php echo Yii::t('phrase', 'Height').': ';?><?php echo $form->textField($model,'photo_resize_size[height]',array('maxlength'=>4,'class'=>'span-2')); ?>
					<?php echo $form->error($model,'photo_resize_size'); ?>
				</div>
				
				<p><?php echo Yii::t('phrase', 'Large Size');?></p>				
				<?php echo Yii::t('phrase', 'Width').': ';?><?php echo $form->textField($model,'photo_view_size[large][width]',array('maxlength'=>4,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Yii::t('phrase', 'Height').': ';?><?php echo $form->textField($model,'photo_view_size[large][height]',array('maxlength'=>4,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'photo_view_size[large]'); ?>
				
				<p><?php echo Yii::t('phrase', 'Medium Size');?></p>
				<?php echo Yii::t('phrase', 'Width').': ';?><?php echo $form->textField($model,'photo_view_size[medium][width]',array('maxlength'=>3,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Yii::t('phrase', 'Height').': ';?><?php echo $form->textField($model,'photo_view_size[medium][height]',array('maxlength'=>3,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'photo_view_size[medium]'); ?>
				
				<p><?php echo Yii::t('phrase', 'Small Size');?></p>
				<?php echo Yii::t('phrase', 'Width').': ';?><?php echo $form->textField($model,'photo_view_size[small][width]',array('maxlength'=>3,'class'=>'span-2')); ?>&nbsp;&nbsp;&nbsp;
				<?php echo Yii::t('phrase', 'Height').': ';?><?php echo $form->textField($model,'photo_view_size[small][height]',array('maxlength'=>3,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'photo_view_size[small]'); ?>				
			</div>
		</div>

		<?php if($module != null && $module->install == 1 && $module->actived == 1) {
			Yii::import('application.modules.article.models.ArticleCategory');
			$parent = null;
			$category = ArticleCategory::getCategory(null, $parent);
		?>
			<div class="clearfix">
				<label><?php echo Yii::t('phrase', 'Article Setting');?> <span class="required">*</span></label>
				<div class="desc">
					<p><?php echo $model->getAttributeLabel('article_sync');?></p>
					<?php echo $form->radioButtonList($model, 'article_sync', array(
						0 => Yii::t('phrase', 'No, not synchronize this module with article modules.'),
						1 => Yii::t('phrase', 'Yes, synchronize this module with article modules.'),
					)); ?>
					
					<div id="article_sync" class="mt-15 <?php echo $model->article_sync == 0 ? 'hide' : '';?>">
						<p><?php echo $model->getAttributeLabel('article_cat_id');?></p>
						<?php
						if($category != null)
							echo $form->dropDownList($model,'article_cat_id', $category, array('prompt'=>Yii::t('phrase', 'Select Category')));
						else
							echo $form->dropDownList($model,'article_cat_id', array('prompt'=>Yii::t('phrase', 'No Parent')));
						echo $form->error($model,'article_cat_id');?>
					</div>				
				</div>
			</div>
		<?php } else {
			$model->article_sync = 0;
			echo $form->hiddenField($model,'article_sync');			
		}?>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>


