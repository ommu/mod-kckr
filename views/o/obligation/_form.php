<?php
/**
 * Kckr Publisher Obligation (kckr-publisher-obligation)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 3 October 2019, 21:46 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\selectize\Selectize;
use yii\helpers\ArrayHelper;
use ommu\kckr\models\KckrCategory;
?>

<div class="kckr-publisher-obligation-form">

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

<?php echo $form->field($model, 'cat_id')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a category..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a category..')], KckrCategory::getCategory()),
	])
	->label($model->getAttributeLabel('cat_id')); ?>

<?php echo $form->field($model, 'isbn')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('isbn')); ?>

<?php echo $form->field($model, 'media_title')
	->textarea(['rows'=>2, 'cols'=>50])
	->label($model->getAttributeLabel('media_title')); ?>

<?php echo $form->field($model, 'media_desc')
	->textarea(['rows'=>3, 'cols'=>50])
	->label($model->getAttributeLabel('media_desc')); ?>

<?php echo $form->field($model, 'media_author')
	->textInput()
	->label($model->getAttributeLabel('media_author')); ?>

<?php echo $form->field($model, 'media_publish_year')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('media_publish_year')); ?>

<?php if($model->isNewRecord && !$model->getErrors())
	$model->publish = 1;
echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>