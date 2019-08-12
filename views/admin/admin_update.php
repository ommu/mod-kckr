<?php
/**
 * Kckrs (kckrs)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\AdminController
 * @var $model ommu\kckr\models\Kckrs
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kckrs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pic->pic_name, 'url' => ['view', 'id'=>$model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="kckrs-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>