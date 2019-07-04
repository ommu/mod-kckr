<?php
/**
 * Kckr Media (kckr-media)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-media-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
