<?php
/**
 * Kckr Categories (kckr-category)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\CategoryController
 * @var $model ommu\kckr\models\search\KckrCategory
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:52 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ommu\kckr\models\KckrCategory;
?>

<div class="kckr-category-search search-form">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'data-pjax' => 1
		],
	]); ?>

		<?php echo $form->field($model, 'category_name_i');?>

		<?php echo $form->field($model, 'category_desc_i');?>

		<?php $categoryType = KckrCategory::getCategoryType();
			echo $form->field($model, 'category_type')
			->dropDownList($categoryType, ['prompt'=>'']);?>

		<?php echo $form->field($model, 'category_code');?>

		<?php echo $form->field($model, 'creation_date')
			->input('date');?>

		<?php echo $form->field($model, 'creationDisplayname');?>

		<?php echo $form->field($model, 'modified_date')
			->input('date');?>

		<?php echo $form->field($model, 'modifiedDisplayname');?>

		<?php echo $form->field($model, 'updated_date')
			->input('date');?>

		<?php echo $form->field($model, 'publish')
			->dropDownList($model->filterYesNo(), ['prompt'=>'']);?>

		<div class="form-group">
			<?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']); ?>
			<?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>