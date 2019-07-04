<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
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
use yii\widgets\DetailView;
use ommu\kckr\models\Kckrs;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kckrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->pic->pic_name;

if(!$small) {
$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-success']],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="kckrs-view">

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
		'attribute' => 'article_id',
		'value' => $model->article_id ? $model->article_id : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'picName',
		'value' => function ($model) {
			$picName = isset($model->pic) ? $model->pic->pic_name : '-';
			if($picName != '-')
				return Html::a($picName, ['pic/view', 'id'=>$model->pic_id], ['title'=>$picName, 'class'=>'modal-btn']);
			return $picName;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'publisherName',
		'value' => function ($model) {
			$publisherName = isset($model->publisher) ? $model->publisher->publisher_name : '-';
			if($publisherName != '-')
				return Html::a($publisherName, ['publisher/view', 'id'=>$model->publisher_id], ['title'=>$publisherName, 'class'=>'modal-btn']);
			return $publisherName;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'letter_number',
		'value' => $model->letter_number ? $model->letter_number : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'send_type',
		'value' => Kckrs::getSendType($model->send_type),
		'visible' => !$small,
	],
	[
		'attribute' => 'send_date',
		'value' => Yii::$app->formatter->asDate($model->send_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'receipt_date',
		'value' => Yii::$app->formatter->asDate($model->receipt_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'thanks_date',
		'value' => Yii::$app->formatter->asDate($model->thanks_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'thanks_document',
		'value' => serialize($model->thanks_document),
		'visible' => !$small,
	],
	[
		'attribute' => 'thanksUserDisplayname',
		'value' => isset($model->thanksUser) ? $model->thanksUser->displayname : '-',
		'visible' => !$small,
	],
	[
		'attribute' => 'photos',
		'value' => $model->photos ? $model->photos : '-',
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
		'attribute' => 'media',
		'value' => function ($model) {
			$media = $model->getMedias(true);
			return Html::a($media, ['media/manage', 'kckr'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} media', ['count'=>$media])]);
		},
		'format' => 'html',
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