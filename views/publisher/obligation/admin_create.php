<?php
/**
 * Kckr Publisher Obligation (kckr-publisher-obligation)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\publisher\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 3 October 2019, 21:46 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['publisher/admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->publisher->publisher_name, 'url' => ['publisher/admin/view', 'id' => $model->publisher->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', ' Obligation'), 'url' => ['manage', 'publisher' => $model->publisher->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-publisher-obligation-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
