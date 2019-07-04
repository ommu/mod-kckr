<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->renderWidget('/setting/category/admin_manage', [
	'contentMenu' => true,
	'searchModel' => $searchModel,
	'dataProvider' => $dataProvider,
	'columns' => $columns,
]); ?>

<?php echo $this->renderWidget(!$model->isNewRecord ? 'admin_view' : 'admin_update', [
	'model'=>$model,
]); ?>