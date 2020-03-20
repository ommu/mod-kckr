<?php
/**
 * Kckr Publisher Obligation (kckr-publisher-obligation)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 3 October 2019, 21:46 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['o/publisher/index']];
$this->params['breadcrumbs'][] = ['label' => $model->publisher->publisher_name, 'url' => ['o/publisher/view', 'id'=>$model->publisher->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', ' Obligation'), 'url' => ['manage', 'publisher'=>$model->publisher->id]];
$this->params['breadcrumbs'][] = ['label' => $model->media_title, 'url' => ['view', 'id'=>$model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-success']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
?>

<div class="kckr-publisher-obligation-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>