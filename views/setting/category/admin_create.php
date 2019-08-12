<?php
/**
 * Kckr Categories (kckr-category)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\setting\CategoryController
 * @var $model ommu\kckr\models\KckrCategory
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:52 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="kckr-category-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
