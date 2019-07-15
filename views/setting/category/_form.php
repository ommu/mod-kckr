<?php
/**
 * Kckr Categories (kckr-category)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\CategoryController
 * @var $model ommu\kckr\models\KckrCategory
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:52 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
?>

<div class="kckr-category-form">

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

<?php $categoryType = $model::getCategoryType();
echo $form->field($model, 'category_type')
	->dropDownList($categoryType, ['prompt'=>''])
	->label($model->getAttributeLabel('category_type')); ?>

<?php echo $form->field($model, 'category_name_i')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('category_name_i')); ?>

<?php echo $form->field($model, 'category_desc_i')
	->textarea(['rows'=>3, 'cols'=>50, 'maxlength'=>true])
	->label($model->getAttributeLabel('category_desc_i')); ?>

<?php echo $form->field($model, 'category_code')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('category_code')); ?>

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