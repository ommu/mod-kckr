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
 * @created date 8 July 2019, 23:15 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\kckr\models\Kckrs;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'KCKR'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->publisher->publisher_name, 'url' => ['view', 'id'=>$model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Print');
?>

<div class="kckrs-print">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
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

<?php echo $this->description && !$model->thanks_date && Yii::$app->request->isAjax ? Html::tag('p', $this->description, ['class'=>'mb-4']) : '';?>

<?php if($model->document) {
	$thanksDocument = Kckrs::parseDocument($model->thanks_document);
	echo $form->field($model, 'thanks_document', ['template' => '{label}{beginWrapper}'.$thanksDocument.'{endWrapper}'])
		->textInput()
		->label($model->getAttributeLabel('thanks_document')); ?>

	<div class="ln_solid"></div>

	<?php echo $form->field($model, 'regenerate')
		->checkbox()
		->label($model->getAttributeLabel('regenerate'));
} ?>

<?php echo $form->field($model, 'thanks_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('thanks_date')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(['button'=>Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-primary'])]); ?>

<?php ActiveForm::end(); ?>

</div>