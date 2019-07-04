<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use ommu\kckr\models\Kckrs;
use ommu\kckr\models\KckrPic;
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

<?php echo $form->field($model, 'article_id')
	->textInput(['type'=>'number', 'min'=>'1'])
	->label($model->getAttributeLabel('article_id')); ?>

<?php $pic = KckrPic::getPic();
echo $form->field($model, 'pic_id')
	->dropDownList($pic, ['prompt'=>''])
	->label($model->getAttributeLabel('pic_id')); ?>

<?php echo $form->field($model, 'publisher_id')
	->textInput(['type'=>'number', 'min'=>'1'])
	->label($model->getAttributeLabel('publisher_id')); ?>

<?php echo $form->field($model, 'letter_number')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('letter_number')); ?>

<?php $sendType = Kckrs::getSendType();
echo $form->field($model, 'send_type')
	->dropDownList($sendType, ['prompt'=>''])
	->label($model->getAttributeLabel('send_type')); ?>

<?php echo $form->field($model, 'send_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('send_date')); ?>

<?php echo $form->field($model, 'receipt_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('receipt_date')); ?>

<?php echo $form->field($model, 'thanks_date')
	->textInput(['type'=>'date'])
	->label($model->getAttributeLabel('thanks_date')); ?>

<?php echo $form->field($model, 'thanks_document')
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('thanks_document')); ?>

<?php echo $form->field($model, 'thanks_user_id')
	->textInput(['type'=>'number', 'min'=>'1'])
	->label($model->getAttributeLabel('thanks_user_id')); ?>

<?php $uploadPath = Kckrs::getUploadPath(false);
$photo = !$model->isNewRecord && $model->old_photos != '' ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->old_photos])), ['class'=>'mb-3']) : '';
echo $form->field($model, 'photos', ['template' => '{label}{beginWrapper}<div>'.$photo.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('photos')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>