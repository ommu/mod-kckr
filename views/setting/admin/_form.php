<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\article\models\ArticleCategory;
use ommu\kckr\models\Kckrs;
?>

<div class="kckr-setting-form">

<?php $form = ActiveForm::begin([
	'options' => ['class' => 'form-horizontal form-label-left'],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php 
if ($model->isNewRecord && !$model->getErrors()) {
	$model->license = $model->licenseCode();
}
echo $form->field($model, 'license')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('license'))
	->hint(Yii::t('app', 'Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please contact support team.').'<br/>'.Yii::t('app', 'Format: XXXX-XXXX-XXXX-XXXX')); ?>

<?php $permission = $model::getPermission();
echo $form->field($model, 'permission', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($permission)
	->label($model->getAttributeLabel('permission'))
	->hint(Yii::t('app', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the General Settings page.')); ?>

<?php echo $form->field($model, 'meta_description')
	->textarea(['rows' => 6, 'cols' => 50])
	->label($model->getAttributeLabel('meta_description')); ?>

<?php echo $form->field($model, 'meta_keyword')
	->textarea(['rows' => 6, 'cols' => 50])
	->label($model->getAttributeLabel('meta_keyword')); ?>

<hr/>

<?php $uploadPath = Kckrs::getUploadPath(false);
$letterhead = $model->letterhead != '' ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->letterhead])), ['alt' => $model->letterhead, 'class' => 'd-block border border-width-3 mb-4']).$model->letterhead.'<hr/>' : '';
echo $form->field($model, 'letterhead', ['template' => '{label}{beginWrapper}<div>'.$letterhead.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('letterhead')); ?>

<hr/>

<?php $photoResize = $model::getPhotoResize();
echo $form->field($model, 'photo_resize')
	->radioList($photoResize)
	->label($model->getAttributeLabel('photo_resize')); ?>

<?php $photo_resize_size_height = $form->field($model, 'photo_resize_size[height]', ['template' => '{beginWrapper}{input}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-5 col-xs-6'], 'options' => ['tag' => null]])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('height')])
	->label($model->getAttributeLabel('photo_resize_size[height]')); ?>

<?php echo $form->field($model, 'photo_resize_size[width]', ['template' => '{hint}{beginWrapper}{input}{endWrapper}'.$photo_resize_size_height.'{error}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-4 col-xs-6 col-sm-offset-3', 'error' => 'col-sm-9 col-xs-12 col-sm-offset-3', 'hint' => 'col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('width')])
	->label($model->getAttributeLabel('photo_resize_size'))
	->hint(Yii::t('app', 'If you have selected "Yes" above, please input the maximum dimensions for the project image. If your users upload a image that is larger than these dimensions, the server will attempt to scale them down automatically. This feature requires that your PHP server is compiled with support for the GD Libraries.')); ?>

<?php $photo_view_size_small_height = $form->field($model, 'photo_view_size[small][height]', ['template' => '{beginWrapper}{input}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-5 col-xs-6'], 'options' => ['tag' => null]])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('height')])
	->label($model->getAttributeLabel('photo_view_size[small][height]')); ?>

<?php echo $form->field($model, 'photo_view_size[small][width]', ['template' => '{label}<div class="h5 col-sm-9 col-xs-12">'.$model->getAttributeLabel('photo_view_size[small]').'</div>{beginWrapper}{input}{endWrapper}'.$photo_view_size_small_height.'{error}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-4 col-xs-6 col-sm-offset-3', 'error' => 'col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('width')])
	->label($model->getAttributeLabel('photo_view_size')); ?>

<?php $photo_view_size_medium_height = $form->field($model, 'photo_view_size[medium][height]', ['template' => '{beginWrapper}{input}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-5 col-xs-6'], 'options' => ['tag' => null]])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('height')])
	->label($model->getAttributeLabel('photo_view_size[medium][height]')); ?>

<?php echo $form->field($model, 'photo_view_size[medium][width]', ['template' => '<div class="h5 col-sm-9 col-xs-12 col-sm-offset-3 mt-0">'.$model->getAttributeLabel('photo_view_size[medium]').'</div>{beginWrapper}{input}{endWrapper}'.$photo_view_size_medium_height.'{error}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-4 col-xs-6 col-sm-offset-3', 'error' => 'col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('width')])
	->label($model->getAttributeLabel('photo_view_size[medium][width]')); ?>

<?php $photo_view_size_large_height = $form->field($model, 'photo_view_size[large][height]', ['template' => '{beginWrapper}{input}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-5 col-xs-6'], 'options' => ['tag' => null]])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('height')])
	->label($model->getAttributeLabel('photo_view_size[large][height]')); ?>

<?php echo $form->field($model, 'photo_view_size[large][width]', ['template' => '<div class="h5 col-sm-9 col-xs-12 col-sm-offset-3 mt-0">'.$model->getAttributeLabel('photo_view_size[large]').'</div>{beginWrapper}{input}{endWrapper}'.$photo_view_size_large_height.'{error}', 'horizontalCssClasses' => ['wrapper' => 'col-sm-4 col-xs-6 col-sm-offset-3', 'error' => 'col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput(['type' => 'number', 'min' => 0, 'maxlength' => '4', 'placeholder' => $model->getAttributeLabel('width')])
	->label($model->getAttributeLabel('photo_view_size[large][width]')); ?>

<?php echo $form->field($model, 'photo_file_type')
	->textInput()
	->label($model->getAttributeLabel('photo_file_type'))
	->hint(Yii::t('app', 'pisahkan jenis file dengan koma (,). example: "jpg, jpeg, bmp, gif, png"')); ?>

<hr/>

<?php echo $form->field($model, 'import_file_type')
	->textInput()
	->label($model->getAttributeLabel('import_file_type'))
	->hint(Yii::t('app', 'pisahkan jenis file dengan koma (,). example: "xls, xlsx, ods, csv"')); ?>

<hr/>

<?php $category = ArticleCategory::getCategory();
echo $form->field($model, 'article_cat_id')
	->dropDownList($category, ['prompt' => ''])
	->label($model->getAttributeLabel('article_cat_id')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>