<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://github.com/ommu/ommu-kckr
 * @contact (+62)856-299-4114
 *
 */
?>

<li id="upload" <?php echo $media_limit != 0 && count($medias) == $media_limit ? 'class="hide"' : '' ?>>
	<a id="upload-gallery" href="<?php echo Yii::app()->controller->createUrl('o/admin/insertcover', array('id'=>$model->article_id,'hook'=>'admin'));?>" title="<?php echo Yii::t('phrase', 'Upload Photo'); ?>"><?php echo Yii::t('phrase', 'Upload Photo'); ?></a>
	<img src="<?php echo Utility::getTimThumb(Yii::app()->request->baseUrl.'/public/article/article_default.png', 320, 250, 1);?>" alt="" />
</li>