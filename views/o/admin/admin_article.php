<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://github.com/ommu/ommu-kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		'Add Article',
	);

	$medias = $model->medias;
	$media_image_limit = $articleSetting->media_image_limit;
	$condition = 0;
	if($media_image_limit != 1 && $model->cat->single_photo == 0)
		$condition = 1;

	if($model->isNewRecord || (!$model->isNewRecord && $condition == 0))
		$validation = false;
	else
		$validation = true;
?>

<div class="form" <?php //echo ($articleSetting->media_image_limit != 1) ? 'name="post-on"' : ''; ?>>
	<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
		'id'=>'articles-form',
		'enableAjaxValidation'=>$validation,
		'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php 
			echo $form->errorSummary($model);
			if(Yii::app()->user->hasFlash('error'))
				echo Utility::flashError(Yii::app()->user->getFlash('error'));
			if(Yii::app()->user->hasFlash('success'))
				echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
			?>
		</div>
		<?php //begin.Messages ?>

		<fieldset class="clearfix">
			<div class="clear">
				<div class="left">
					<?php 
					$model->media_type_i = 1;
					echo $form->hiddenField($model,'media_type_i');
					$model->cat_id = $kckrSetting->article_cat_id;
					echo $form->hiddenField($model,'cat_id');?>
		
					<div class="clearfix">
						<label><?php echo $model->getAttributeLabel('title');?> <span class="required">*</span></label>
						<div class="desc">
							<?php 
							if($model->isNewRecord && !$model->getErrors())
								$model->title = 'Penyerahan Bahan Pustaka Karya Cetak Dari '.$kckr->publisher->publisher_name;
							echo $form->textField($model,'title',array('maxlength'=>128,'class'=>'span-8')); ?>
							<?php echo $form->error($model,'title'); ?>
						</div>
					</div>
		
					<?php if(!$model->isNewRecord && $condition == 0) {
						$medias = $model->medias;
						if(!empty($medias)) {
							$media = $model->view->article_cover ? $model->view->article_cover : $medias[0]->cover_filename;
							if(!$model->getErrors())
								$model->old_media_photo_i = $media;
							echo $form->hiddenField($model,'old_media_photo_i');
							$image = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->old_media_photo_i;
							$media = '<img src="'.Utility::getTimThumb($image, 320, 150, 1).'" alt="">';
							echo '<div class="clearfix">';
							echo $form->labelEx($model,'old_media_photo_i');
							echo '<div class="desc">'.$media.'</div>';
							echo '</div>';
						}
					}?>

					<?php if($model->isNewRecord || (!$model->isNewRecord && $condition == 0)) {?>
					<div id="media" class="<?php echo (($model->isNewRecord && !$model->getErrors()) || (($model->isNewRecord && $model->getErrors()) || (!$model->isNewRecord && ($articleSetting->media_image_limit == 1 || ($articleSetting->media_image_limit != 1 && $model->cat->single_photo == 1))))) ? '' : 'hide';?> clearfix filter">
						<?php echo $form->labelEx($model,'media_photo_i'); ?>
						<div class="desc">
							<?php echo $form->fileField($model,'media_photo_i'); ?>
							<?php echo $form->error($model,'media_photo_i'); ?>
							<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType($media_image_type, false);?></span>
						</div>
					</div>
					<?php }?>
					
					<div class="clearfix">
						<?php echo $form->labelEx($model,'keyword_i'); ?>
						<div class="desc">
							<?php 
							if($model->isNewRecord) {
								echo $form->textArea($model,'keyword_i',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller'));
								
							} else {
								//echo $form->textField($model,'keyword_i',array('maxlength'=>32,'class'=>'span-6'));
								$url = Yii::app()->controller->createUrl('article/o/tag/add', array('type'=>'article'));
								$article = $model->article_id;
								$tagId = 'Articles_keyword_input';
								$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
									'model' => $model,
									'attribute' => 'keyword_i',
									'source' => Yii::app()->createUrl('globaltag/suggest'),
									'options' => array(
										//'delay '=> 50,
										'minLength' => 1,
										'showAnim' => 'fold',
										'select' => "js:function(event, ui) {
											$.ajax({
												type: 'post',
												url: '$url',
												data: { article_id: '$article', tag_id: ui.item.id, tag: ui.item.value },
												dataType: 'json',
												success: function(response) {
													$('form #$tagId').val('');
													$('form #keyword-suggest').append(response.data);
												}
											});

										}"
									),
									'htmlOptions' => array(
										'class'	=> 'span-6',
									),
								));
								echo $form->error($model,'keyword_i');							
							}?>
							<div id="keyword-suggest" class="suggest clearfix">
								<?php 
								if($articleSetting->meta_keyword && $articleSetting->meta_keyword != '-') {
									$arrKeyword = explode(',', $articleSetting->meta_keyword);
									foreach($arrKeyword as $row) {?>
										<div class="d"><?php echo $row;?></div>
								<?php }
								}
								if(!$model->isNewRecord) {
									$tags = $model->tags;
									if(!empty($tags)) {
										foreach($tags as $key => $val) {?>
										<div><?php echo $val->tag->body;?><a href="<?php echo Yii::app()->controller->createUrl('article/o/tag/delete',array('id'=>$val->id,'type'=>'article'));?>" title="<?php echo Yii::t('phrase', 'Delete');?>"><?php echo Yii::t('phrase', 'Delete');?></a></div>
									<?php }
									}
								}?>
							</div>
							<?php if($model->isNewRecord) {?><span class="small-px">tambahkan tanda koma (,) jika ingin menambahkan keyword lebih dari satu</span><?php }?>
						</div>
					</div>
		
				</div>
		
				<div class="right">
					<?php
					if(!$model->isNewRecord) {
						$model->old_media_file_i = $model->media_file_i;
						echo $form->hiddenField($model,'old_media_file_i');
						if($model->old_media_file_i != '') {
							$file = Yii::app()->request->baseUrl.'/public/article/'.$model->article_id.'/'.$model->old_media_file_i;
							echo '<div class="clearfix">';
							echo $form->labelEx($model,'old_media_file_i');
							echo '<div class="desc"><a href="'.$file.'" title="'.$model->old_media_file_i.'">'.$model->old_media_file_i.'</a></div>';
							echo '</div>';
						}
					}?>
					
					<div id="file" class="clearfix">
						<?php echo $form->labelEx($model,'media_file_i'); ?>
						<div class="desc">
							<?php echo $form->fileField($model,'media_file_i'); ?>
							<?php echo $form->error($model,'media_file_i'); ?>
							<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType($media_file_type, false);?></span>
						</div>
					</div>
		
					<div class="clearfix">
						<?php echo $form->labelEx($model,'published_date'); ?>
						<div class="desc">
							<?php 
							$model->published_date = $model->isNewRecord && $model->published_date == '' ? date('d-m-Y') : date('d-m-Y', strtotime($model->published_date));
							//echo $form->textField($model,'published_date', array('class'=>'span-7'));
							$this->widget('application.libraries.core.components.system.CJuiDatePicker',array(
								'model'=>$model, 
								'attribute'=>'published_date',
								//'mode'=>'datetime',
								'options'=>array(
									'dateFormat' => 'dd-mm-yy',
								),
								'htmlOptions'=>array(
									'class' => 'span-7',
								 ),
							));	?>
							<?php echo $form->error($model,'published_date'); ?>
						</div>
					</div>
		
					<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
					<div class="clearfix publish">
						<?php echo $form->labelEx($model,'comment_code'); ?>
						<div class="desc">
							<?php echo $form->checkBox($model,'comment_code'); ?><?php echo $form->labelEx($model,'comment_code'); ?>
							<?php echo $form->error($model,'comment_code'); ?>
						</div>
					</div>
					<?php } else {
						$model->comment_code = 0;
						echo $form->hiddenField($model,'comment_code');
					}?>
		
					<?php if($articleSetting->headline == 1) {?>
					<div class="clearfix publish">
						<?php echo $form->labelEx($model,'headline'); ?>
						<div class="desc">
							<?php echo $form->checkBox($model,'headline'); ?><?php echo $form->labelEx($model,'headline'); ?>
							<?php echo $form->error($model,'headline'); ?>
						</div>
					</div>
					<?php } else {
						$model->headline = 0;
						echo $form->hiddenField($model,'headline');
					}?>
		
					<div class="clearfix publish">
						<?php echo $form->labelEx($model,'publish'); ?>
						<div class="desc">
							<?php echo $form->checkBox($model,'publish'); ?><?php echo $form->labelEx($model,'publish'); ?>
							<?php echo $form->error($model,'publish'); ?>
						</div>
					</div>
					
				</div>
			</div>
		</fieldset>

		<fieldset>
			<div class="clearfix" id="quote">
				<?php echo $form->labelEx($model,'quote'); ?>
				<div class="desc">
					<?php 
					//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
					$this->widget('yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
						'model'=>$model,
						'attribute'=>quote,
						// Redactor options
						'options'=>array(
							//'lang'=>'fi',
							'buttons'=>array(
								'html', '|', 
								'bold', 'italic', 'deleted', '|',
							),
						),
						'plugins' => array(
							'fontcolor' => array('js' => array('fontcolor.js')),
							'fullscreen' => array('js' => array('fullscreen.js')),
						),
					)); ?>
					<span class="small-px"><?php echo Yii::t('phrase', 'Note : add {$quote} in description article');?></span>
					<?php echo $form->error($model,'quote'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'body'); ?>
				<div class="desc">
					<?php 
					if($model->isNewRecord && !$model->getErrors()) {
						$template = 'kckr_article';
						$message = $this->renderPartial('application.modules.kckr.components.templates.'.$template, array('kckr'=>$kckr), true, false);
						$model->body = $message;
					}
					//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
					$this->widget('yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
						'model'=>$model,
						'attribute'=>body,
						// Redactor options
						'options'=>array(
							//'lang'=>'fi',
							'buttons'=>array(
								'html', 'formatting', '|', 
								'bold', 'italic', 'deleted', '|',
								'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								'link', '|',
							),
						),
						'plugins' => array(
							'fontcolor' => array('js' => array('fontcolor.js')),
							'table' => array('js' => array('table.js')),
							'fullscreen' => array('js' => array('fullscreen.js')),
						),
					)); ?>
					<?php echo $form->error($model,'body'); ?>
				</div>
			</div>

			<div class="submit clearfix">
				<label>&nbsp;</label>
				<div class="desc">
					<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
				</div>
			</div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>

<?php if($condition == 1) {?>
<div class="boxed mt-15">
	<h3><?php echo Yii::t('phrase', 'Article Photo'); ?></h3>
	<div class="clearfix horizontal-data" name="four">
		<ul id="media-render">
			<?php 
			$this->renderPartial('_form_cover', array('model'=>$model, 'medias'=>$medias, 'media_image_limit'=>$media_image_limit));
			if(!empty($medias)) {
				foreach($medias as $key => $data)
					$this->renderPartial('_form_view_covers', array('data'=>$data));
			}?>
		</ul>
	</div>
</div>
<?php }?>