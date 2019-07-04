<?php
/**
 * Kckr Media (kckr-media)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\kckr\models\KckrCategory;
?>

<div class="kckr-media-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'kckr_id')
	->textInput(['type'=>'number', 'min'=>'1'])
	->label($model->getAttributeLabel('kckr_id')); ?>

<?php $category = KckrCategory::getCategory();
echo $form->field($model, 'cat_id')
	->dropDownList($category, ['prompt'=>''])
	->label($model->getAttributeLabel('cat_id')); ?>

<?php echo $form->field($model, 'media_title')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('media_title')); ?>

<?php echo $form->field($model, 'media_desc')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('media_desc')); ?>

<?php echo $form->field($model, 'media_publish_year')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('media_publish_year')); ?>

<?php echo $form->field($model, 'media_author')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('media_author')); ?>

<?php echo $form->field($model, 'media_item')
	->textInput(['type'=>'number', 'min'=>'1'])
	->label($model->getAttributeLabel('media_item')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>