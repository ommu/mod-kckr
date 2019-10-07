<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 * @var $searchModel ommu\kckr\models\search\Kckrs
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
use app\components\grid\GridView;
use yii\widgets\Pjax;

if($pic != null) {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'KCKR'), 'url' => ['admin/index']];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['setting/admin/index']];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Person In Charge'), 'url' => ['setting/pic/index']];
	$this->params['breadcrumbs'][] = ['label' => $pic->pic_name, 'url' => ['setting/pic/view', 'id'=>$pic->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'KCKR(s)');
} else if($publisher != null) {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'KCKR'), 'url' => ['admin/index']];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['o/publisher/index']];
	$this->params['breadcrumbs'][] = ['label' => $publisher->publisher_name, 'url' => ['o/publisher/view', 'id'=>$publisher->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'KCKR(s)');
} else
	$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Add KCKR'), 'url' => $publisher != null ? Url::to(['create', 'id'=>$publisher->id]) : Url::to(['create']), 'icon' => 'plus-square', 'htmlOptions' => ['class'=>'btn btn-success']],
];
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="kckrs-manage">
<?php Pjax::begin(); ?>

<?php if($pic != null)
	echo $this->render('/setting/pic/admin_view', ['model'=>$pic, 'small'=>true]); ?>

<?php if($publisher != null)
	echo $this->render('/o/publisher/admin_view', ['model'=>$publisher, 'small'=>true]); ?>

<?php //echo $this->render('_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('_option_form', ['model'=>$searchModel, 'gridColumns'=>$searchModel->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

<?php
$columnData = $columns;
array_push($columnData, [
	'class' => 'app\components\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'urlCreator' => function($action, $model, $key, $index) {
		if($action == 'view')
			return Url::to(['view', 'id'=>$key]);
		if($action == 'update')
			return Url::to(['update', 'id'=>$key]);
		if($action == 'delete')
			return Url::to(['delete', 'id'=>$key]);
	},
	'buttons' => [
		'view' => function ($url, $model, $key) {
			if(($publisher = Yii::$app->request->get('publisher')) != null)
				return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title'=>Yii::t('app', 'Detail Kckr'), 'class'=>'modal-btn']);
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title'=>Yii::t('app', 'Detail Kckr'), 'data-pjax'=>0]);
		},
		'update' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title'=>Yii::t('app', 'Update Kckr'), 'data-pjax'=>0]);
		},
		'delete' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete Kckr'),
				'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'data-method'  => 'post',
			]);
		},
	],
	'template' => '{view} {update} {delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>