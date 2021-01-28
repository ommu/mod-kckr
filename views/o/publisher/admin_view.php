<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\PublisherController
 * @var $model ommu\kckr\models\KckrPublisher
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

if (!$small) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $model->publisher_name;

    $this->params['menu']['content'] = [
        ['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id' => $model->id]), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
        ['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id' => $model->id]), 'htmlOptions' => ['data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method' => 'post', 'class' => 'btn btn-danger'], 'icon' => 'trash'],
    ];
} ?>

<div class="kckr-publisher-view">

<?php
$attributes = [
	[
		'attribute' => 'id',
		'value' => $model->id ? $model->id : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'publish',
		'value' => $model->quickAction(Url::to(['publish', 'id' => $model->primaryKey]), $model->publish),
		'format' => 'raw',
		'visible' => !$small,
	],
	[
		'attribute' => 'publisher_area',
		'value' => $model::getPublisherArea($model->publisher_area),
	],
	[
		'attribute' => 'publisher_name',
		'value' => $model->publisher_name ? $model->publisher_name : '-',
	],
	[
		'attribute' => 'publisher_address',
		'value' => $model->publisher_address ? $model->publisher_address : '-',
	],
	[
		'attribute' => 'publisher_phone',
		'value' => $model->publisher_phone ? $model->publisher_phone : '-',
	],
	[
		'attribute' => 'obligations',
		'value' => function ($model) {
			$obligations = $model->getObligations('count');
			return Html::a($obligations, ['o/obligation/manage', 'publisher' => $model->primaryKey, 'publish' => 1], ['title' => Yii::t('app', '{count} obligations', ['count' => $obligations])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'kckrs',
		'value' => function ($model) {
			$kckrs = $model->getKckrs('count');
			return Html::a($kckrs, ['admin/manage', 'publisher' => $model->primaryKey, 'publish' => 1], ['title' => Yii::t('app', '{count} kckrs', ['count' => $kckrs])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'medias',
		'value' => function ($model) {
			$medias = $model->getKckrs('media');
			return Html::a($medias, ['o/media/manage', 'publisher' => $model->primaryKey, 'publish' => 1], ['title' => Yii::t('app', '{count} karya', ['count' => $medias])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'items',
		'value' => function ($model) {
			return $model->getKckrs('item');
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'creation_date',
		'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'creationDisplayname',
		'value' => isset($model->creation) ? $model->creation->displayname : '-',
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
		'attribute' => 'updated_date',
		'value' => Yii::$app->formatter->asDatetime($model->updated_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => '',
		'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->primaryKey], ['title' => Yii::t('app', 'Update'), 'class' => 'btn btn-success btn-sm']),
		'format' => 'html',
		'visible' => !$small && Yii::$app->request->isAjax ? true : false,
	],
];

echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class' => 'table table-striped detail-view',
	],
	'attributes' => $attributes,
]); ?>

</div>