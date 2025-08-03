<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Settings');
?>

<?php echo $this->renderWidget('/setting/category/admin_manage', [
	'contentMenu' => true,
	'searchModel' => $searchModel,
	'dataProvider' => $dataProvider,
	'columns' => $columns,
	'breadcrumb' => false,
]); ?>

<?php echo $this->renderWidget('/setting/pic/admin_manage', [
	'contentMenu' => true,
	'searchModel' => $picSearchModel,
	'dataProvider' => $picDataProvider,
	'columns' => $picColumns,
	'breadcrumb' => false,
]); ?>

<?php echo $this->renderWidget(!$model->isNewRecord ? 'admin_view' : 'admin_update', [
	'contentMenu' => true,
	'model' => $model,
	'breadcrumb' => false,
]); ?>