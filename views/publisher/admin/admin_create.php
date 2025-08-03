<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\publisher\AdminController
 * @var $model ommu\kckr\models\KckrPublisher
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publisher'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-publisher-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
