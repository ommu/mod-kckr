<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Reset'), 'url' => Url::to(['delete']), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to reset this setting?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
?>

<div class="kckr-setting-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>