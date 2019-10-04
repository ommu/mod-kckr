<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kckrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->pic->pic_name;
?>

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
		'value' => function ($model) {
			$articleTitle = isset($model->article) ? $model->article->title : '-';
			if($articleTitle != '-')
				return Html::a($articleTitle, ['/article/admin/view', 'id'=>$model->article_id], ['title'=>$articleTitle, 'class'=>'modal-btn']);
			return $articleTitle;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'picName',
		'value' => function ($model) {
			$picName = isset($model->pic) ? $model->pic->pic_name : '-';
			if($picName != '-')
				return Html::a($picName, ['setting/pic/view', 'id'=>$model->pic_id], ['title'=>$picName, 'class'=>'modal-btn']);
			return $picName;
		},
		'format' => 'html',
	],
	[
		'attribute' => 'publisherName',
		'value' => function ($model) {
			$publisherName = isset($model->publisher) ? $model->publisher->publisher_name : '-';
			if($publisherName != '-')
				return Html::a($publisherName, ['o/publisher/view', 'id'=>$model->publisher_id], ['title'=>$publisherName, 'class'=>'modal-btn']);
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
		'value' => $model::getSendType($model->send_type),
		'visible' => !$small,
	],
	[
		'attribute' => 'send_date',
		'value' => Yii::$app->formatter->asDate($model->send_date, 'medium'),
	],
	[
		'attribute' => 'receipt_date',
		'value' => Yii::$app->formatter->asDate($model->receipt_date, 'medium'),
	],
	[
		'attribute' => 'photos',
		'value' => function ($model) {
			$uploadPath = $model::getUploadPath(false);
			return $model->photos ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->photos])), ['alt'=>$model->photos, 'class'=>'mb-3']).'<br/>'.$model->photos : '-';
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'medias',
		'value' => function ($model) {
			$medias = $model->getMedias('count');
			return Html::a($medias, ['o/media/manage', 'kckr'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} medias', ['count'=>$medias])]);
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'items',
		'value' => function ($model) {
			return $model->getMedias('sum');
		},
		'format' => 'html',
		'visible' => !$small,
	],
	[
		'attribute' => 'thanks_document',
		'value' => $model::parseDocument($model->thanks_document),
		'format' => 'raw',
		'visible' => !$small,
	],
	[
		'attribute' => 'thanks_date',
		'value' => Yii::$app->formatter->asDate($model->thanks_date, 'medium'),
		'visible' => !$small,
	],
	[
		'attribute' => 'thanksUserDisplayname',
		'value' => isset($model->thanksUser) ? $model->thanksUser->displayname : '-',
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