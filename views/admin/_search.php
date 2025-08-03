<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\search\Kckrs
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ommu\kckr\models\KckrPic;
?>

<div class="kckrs-search search-form">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'data-pjax' => 1
		],
	]); ?>

		<?php echo $form->field($model, 'article_id');?>

		<?php $pic = KckrPic::getPic();
		echo $form->field($model, 'pic_id')
			->dropDownList($pic, ['prompt' => '']);?>

		<?php echo $form->field($model, 'publisherName');?>

		<?php echo $form->field($model, 'letter_number');?>

		<?php $sendType = $model::getSendType();
			echo $form->field($model, 'send_type')
			->dropDownList($sendType, ['prompt' => '']);?>

		<?php echo $form->field($model, 'send_date')
			->input('date');?>

		<?php echo $form->field($model, 'receipt_date')
			->input('date');?>

		<?php echo $form->field($model, 'thanks_date')
			->input('date');?>

		<?php echo $form->field($model, 'thanks_document');?>

		<?php echo $form->field($model, 'thanksUserDisplayname');?>

		<?php echo $form->field($model, 'photos');?>

		<?php echo $form->field($model, 'creation_date')
			->input('date');?>

		<?php echo $form->field($model, 'creationDisplayname');?>

		<?php echo $form->field($model, 'modified_date')
			->input('date');?>

		<?php echo $form->field($model, 'modifiedDisplayname');?>

		<?php echo $form->field($model, 'updated_date')
			->input('date');?>

		<?php echo $form->field($model, 'publish')
			->dropDownList($model->filterYesNo(), ['prompt' => '']);?>

		<div class="form-group">
			<?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']); ?>
			<?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>