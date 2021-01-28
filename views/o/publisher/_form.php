<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\PublisherController
 * @var $model ommu\kckr\models\KckrPublisher
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
?>

<div class="kckr-publisher-form">

<?php $form = ActiveForm::begin([
	'options' => ['class' => 'form-horizontal form-label-left'],
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

<?php $publisherArea = $model::getPublisherArea();
echo $form->field($model, 'publisher_area')
	->dropDownList($publisherArea, ['prompt' => ''])
	->label($model->getAttributeLabel('publisher_area')); ?>

<?php echo $form->field($model, 'publisher_name')
	->textarea(['rows' => 3, 'cols' => 50])
	->label($model->getAttributeLabel('publisher_name')); ?>

<?php echo $form->field($model, 'publisher_address')
	->textarea(['rows' => 4, 'cols' => 50])
	->label($model->getAttributeLabel('publisher_address')); ?>

<?php echo $form->field($model, 'publisher_phone')
	->textInput()
	->label($model->getAttributeLabel('publisher_phone')); ?>

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