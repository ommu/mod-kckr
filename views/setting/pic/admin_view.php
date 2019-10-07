<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\PicController
 * @var $model ommu\kckr\models\KckrPic
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use ommu\kckr\models\Kckrs;

if(!$small) {
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['setting/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Person In Charge'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->pic_name;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="kckr-pic-view">

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
		'attribute' => 'default',
		'value' => $model->filterYesNo($model->default),
		'visible' => !$small,
	],
	[
		'attribute' => 'pic_name',
		'value' => $model->pic_name ? $model->pic_name : '-',
	],
	[
		'attribute' => 'pic_nip',
		'value' => $model->pic_nip ? $model->pic_nip : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'pic_position',
		'value' => $model->pic_position ? $model->pic_position : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'pic_signature',
		'value' => function ($model) {
			$uploadPath = join('/', [Kckrs::getUploadPath(false), 'pic']);
			return $model->pic_signature ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->pic_signature])), ['alt'=>$model->pic_signature, 'class'=>'mb-3']).'<br/>'.$model->pic_signature : '-';
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'kckrs',
		'value' => function ($model) {
			$kckrs = $model->getKckrs('count');
			return Html::a($kckrs, ['admin/manage', 'pic'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} kckrs', ['count'=>$kckrs])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'medias',
		'value' => function ($model) {
			$medias = $model->getKckrs('media');
			return Html::a($medias, ['o/media/manage', 'picId'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} karya', ['count'=>$medias])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'items',
		'value' => function ($model) {
			$items = $model->getKckrs('item');
			return Html::a($items, ['o/media/manage', 'picId'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} items', ['count'=>$items])]);
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
		'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn btn-primary']),
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