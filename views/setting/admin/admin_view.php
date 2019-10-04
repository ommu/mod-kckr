<?php
/**
 * Kckr Settings (kckr-setting)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\AdminController
 * @var $model ommu\kckr\models\KckrSetting
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:54 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = $this->title;

if(!$small) {
$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Reset'), 'url' => Url::to(['delete']), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to reset this setting?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="kckr-setting-view">

<?php
$attributes = [
	[
		'attribute' => 'id',
		'value' => $model->id ? $model->id : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'license',
		'value' => $model->license ? $model->license : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'permission',
		'value' => $model::getPermission($model->permission),
		'visible' => !$small,
	],
	[
		'attribute' => 'meta_description',
		'value' => $model->meta_description ? $model->meta_description : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'meta_keyword',
		'value' => $model->meta_keyword ? $model->meta_keyword : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'photo_resize',
		'value' => $model::getPhotoResize($model->photo_resize),
		'visible' => !$small,
	],
	[
		'attribute' => 'photo_resize_size',
		'value' => $model::getSize($model->photo_resize_size),
		'visible' => !$small,
	],
	[
		'attribute' => 'photo_view_size',
		'value' => $model::parsePhotoViewSize($model->photo_view_size),
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'photo_file_type',
		'value' => $model->photo_file_type,
		'visible' => !$small,
	],
	[
		'attribute' => 'import_file_type',
		'value' => $model->import_file_type,
		'visible' => !$small,
	],
	[
		'attribute' => 'article_cat_id',
		'value' => isset($model->articleCategory) ? $model->articleCategory->name_i : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'modified_date',
		'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'modifiedDisplayname',
		'value' => isset($model->modified) ? $model->modified->displayname : '-',
		'visible' => !$small,
	],
	[
		'attribute' => '',
		'value' => Html::a(Yii::t('app', 'Update'), ['update'], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn btn-primary']),
		'format' => 'html',
	],
];

echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => $attributes,
]); ?>

</div>