<?php
/**
 * Kckr Publisher Obligation (kckr-publisher-obligation)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 3 October 2019, 21:46 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'KCKR'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['o/publisher/index']];
$this->params['breadcrumbs'][] = ['label' => $model->publisher->publisher_name, 'url' => ['o/publisher/view', 'id'=>$model->publisher->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', ' Obligation'), 'url' => ['manage', 'publisher'=>$model->publisher->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-publisher-obligation-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
