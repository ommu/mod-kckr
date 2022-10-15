<?php
/**
 * Kckr Publisher Obligation (kckr-publisher-obligation)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\publisher\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 * @var $searchModel ommu\kckr\models\search\KckrPublisherObligation
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 3 October 2019, 21:46 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
if ($publisher != null) {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['publisher/admin/index']];
	$this->params['breadcrumbs'][] = ['label' => $publisher->publisher_name, 'url' => ['publisher/admin/view', 'id' => $publisher->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'Obligations');
} else if ($category != null) {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Setting'), 'url' => ['setting/admin/index']];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category'), 'url' => ['setting/category/index']];
	$this->params['breadcrumbs'][] = ['label' => $category->title->message, 'url' => ['setting/category/view', 'id' => $category->id]];
	$this->params['breadcrumbs'][] = Yii::t('app', 'Obligations');
} else {
    $this->params['breadcrumbs'][] = $this->title;
}

if ($publisher != null) {
	$this->params['menu']['content'] = [
		['label' => Yii::t('app', 'Add Obligation'), 'url' => Url::to(['create', 'id' => $publisher->id]), 'icon' => 'plus-square', 'htmlOptions' => ['class' => 'btn btn-success modal-btn']],
		['label' => Yii::t('app', 'Import'), 'url' => Url::to(['import', 'id' => $publisher->id]), 'icon' => 'plus-square', 'htmlOptions' => ['class' => 'btn btn-default modal-btn']],
		['label' => Yii::t('app', 'Export'), 'url' => Url::to(['export', 'id' => $publisher->id]), 'icon' => 'plus-square', 'htmlOptions' => ['class' => 'btn btn-dark modal-btn']],
	];
}
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Export'), 'url' => 'javascript:void(0);'],
];
?>

<div class="kckr-publisher-obligation-manage">
<?php Pjax::begin(); ?>

<?php if ($publisher != null) {
    echo $this->render('/publisher/admin/admin_view', ['model' => $publisher, 'small' => true]);
} ?>

<?php if ($category != null) {
    echo $this->render('/setting/category/admin_view', ['model' => $category, 'small' => true]);
} ?>

<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

<?php echo $this->render('_option_form', ['model' => $searchModel, 'gridColumns' => $searchModel->activeDefaultColumns($columns), 'route' => $this->context->route]); ?>

<?php
$columnData = $columns;
array_push($columnData, [
	'class' => 'app\components\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'urlCreator' => function($action, $model, $key, $index) {
        if ($action == 'view') {
            return Url::to(['view', 'id' => $key]);
        }
        if ($action == 'update') {
            return Url::to(['update', 'id' => $key]);
        }
        if ($action == 'delete') {
            return Url::to(['delete', 'id' => $key]);
        }
	},
	'buttons' => [
		'view' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'Detail Obligation'), 'class' => 'modal-btn']);
		},
		'update' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update Obligation'), 'class' => 'modal-btn']);
		},
		'delete' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete Obligation'),
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