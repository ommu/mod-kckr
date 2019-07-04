<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\PublisherController
 * @var $model ommu\kckr\models\KckrPublisher
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
?>

<div class="kckr-publisher-form">

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

<?php echo $form->field($model, 'publisher_name')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('publisher_name')); ?>

<?php echo $form->field($model, 'publisher_address')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('publisher_address')); ?>

<?php echo $form->field($model, 'publisher_phone')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('publisher_phone')); ?>

<?php echo $form->field($model, 'publisher_area')
	->checkbox()
	->label($model->getAttributeLabel('publisher_area')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>