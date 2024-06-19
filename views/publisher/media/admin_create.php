<?php
/**
 * Kckr Media (kckr-media)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\publisher\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kckr->publisher->publisher_name, 'url' => ['admin/view', 'id' => $model->kckr_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['manage', 'kckr' => $model->kckr_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-media-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
