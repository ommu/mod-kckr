<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\PicController
 * @var $model ommu\kckr\models\KckrPic
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\kckr\models\Kckrs;
?>

<div class="kckr-pic-form">

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		'enctype' => 'multipart/form-data',
		'onPost' => true,
	],
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

<?php echo $form->field($model, 'pic_name')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('pic_name')); ?>

<?php echo $form->field($model, 'pic_nip')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('pic_nip')); ?>

<?php echo $form->field($model, 'pic_position')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('pic_position')); ?>

<?php $uploadPath = join('/', [Kckrs::getUploadPath(false), 'pic']);
$picSignature = !$model->isNewRecord && $model->old_pic_signature != '' ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->old_pic_signature])), ['alt' => $model->old_pic_signature, 'class' => 'd-block border border-width-3 mb-4']).$model->old_pic_signature.'<hr/>' : '';
echo $form->field($model, 'pic_signature', ['template' => '{label}{beginWrapper}<div>'.$picSignature.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('pic_signature')); ?>

<?php echo $form->field($model, 'default')
	->checkbox()
	->label($model->getAttributeLabel('default')); ?>

<?php 
if ($model->isNewRecord && !$model->getErrors()) {
    $model->publish = 1;
}
echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>