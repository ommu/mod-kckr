<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\kckr\models\KckrPic;
use ommu\selectize\Selectize;
use yii\helpers\ArrayHelper;
?>

<div class="kckrs-form">

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		'enctype' => 'multipart/form-data',
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

<?php $publisherSuggestUrl = Url::to(['o/publisher/suggest']);
$publisher = [];
if($model->publisher_id && isset($model->publisher))
	$publisher = [$model->publisher_id => $model->publisher->publisher_name];

echo $form->field($model, 'publisher_id')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a publisher...'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a publisher..')], $publisher),
		'url' => $publisherSuggestUrl,
		'queryParam' => 'term',
		'pluginOptions' => [
			'valueField' => 'id',
			'labelField' => 'label',
			'searchField' => ['label'],
			'persist' => false,
		],
	])
	->label($model->getAttributeLabel('publisher_id')); ?>

<?php echo $form->field($model, 'letter_number')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('letter_number')); ?>

<?php echo $form->field($model, 'pic_id')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a person in charge..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a person in charge..')], KckrPic::getPic()),
	])
	->label($model->getAttributeLabel('pic_id')); ?>

<?php echo $form->field($model, 'send_type')
	->widget(Selectize::className(), [
		'options' => [
			'placeholder' => Yii::t('app', 'Select a send type..'),
		],
		'items' => ArrayHelper::merge([''=>Yii::t('app', 'Select a send type..')], $model::getSendType()),
	])
	->label($model->getAttributeLabel('send_type')); ?>

<?php echo $form->field($model, 'send_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('send_date')); ?>

<?php echo $form->field($model, 'receipt_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('receipt_date')); ?>

<?php $uploadPath = join('/', [$model::getUploadPath(false), 'photo']);
$photo = !$model->isNewRecord && $model->old_photos != '' ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->old_photos])), ['alt'=>$model->old_photos, 'class'=>'mb-3']) : '';
echo $form->field($model, 'photos', ['template' => '{label}{beginWrapper}<div>'.$photo.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('photos'))
	->hint(Yii::t('app', 'extensions are allowed: {extensions}', ['extensions'=>$setting->photo_file_type])); ?>

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