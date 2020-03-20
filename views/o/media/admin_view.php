<?php
/**
 * Kckr Media (kckr-media)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\MediaController
 * @var $model ommu\kckr\models\KckrMedia
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

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kckr->publisher->publisher_name, 'url' => ['admin/view', 'id'=>$model->kckr_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['manage', 'kckr'=>$model->kckr_id]];
$this->params['breadcrumbs'][] = $model->media_title;

if(!$small) {
$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="kckr-media-view">

<?php
$attributes = [
	[
		'attribute' => 'id',
		'value' => $model->id ? $model->id : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'publish',
		'value' => $model->quickAction(Url::to(['publish', 'id'=>$model->primaryKey]), $model->publish),
		'format' => 'raw',
		'visible' => !$small,
	],
	[
		'attribute' => 'picId',
		'value' => function ($model) {
			$picId = isset($model->kckr) ? $model->kckr->pic->pic_name : '-';
			if($picId != '-')
				return Html::a($picId, ['setting/pic/view', 'id'=>$model->kckr->pic_id], ['title'=>$picId, 'class'=>'modal-btn']);
			return $picId;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'publisherName',
		'value' => function ($model) {
			$publisherName = isset($model->kckr) ? $model->kckr->publisher->publisher_name : '-';
			if($publisherName != '-')
				return Html::a($publisherName, ['o/publisher/view', 'id'=>$model->kckr->publisher_id], ['title'=>$publisherName, 'class'=>'modal-btn']);
			return $publisherName;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'categoryName',
		'value' => function ($model) {
			$categoryName = isset($model->category) ? $model->category->title->message : '-';
			if($categoryName != '-')
				return Html::a($categoryName, ['setting/category/view', 'id'=>$model->cat_id], ['title'=>$categoryName, 'class'=>'modal-btn']);
			return $categoryName;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'media_title',
		'value' => $model->media_title ? $model->media_title : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'media_desc',
		'value' => $model->media_desc ? $model->media_desc : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'media_publish_year',
		'value' => $model->media_publish_year ? $model->media_publish_year : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'media_author',
		'value' => $model->media_author ? $model->media_author : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'media_item',
		'value' => $model->media_item ? $model->media_item : '-',
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
		'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn btn-success btn-sm']),
		'format' => 'html',
		'visible' => !$small && Yii::$app->request->isAjax ? true : false,
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