<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['index']];
if(($id = Yii::$app->request->get('id')) != null) {
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['o/publisher/index']];
	$this->params['breadcrumbs'][] = ['label' => $model->publisher->publisher_name, 'url' => ['o/publisher/view', 'id'=>$model->publisher_id]];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'KCKR(s)'), 'url' => ['manage', 'publisher'=>$model->publisher_id]];
}
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckrs-create">

<?php echo $this->render('_form', [
	'model' => $model,
	'setting' => $setting,
]); ?>

</div>
