<?php
/**
 * Kckr Media (kckr-media)
 * @var $this app\components\View
 * @var $this ommu\kckr\controllers\o\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 October 2019, 23:10 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposit'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->kckr->publisher->publisher_name, 'url' => ['admin/view', 'id'=>$model->kckr_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['manage', 'kckr'=>$model->kckr_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Import');
?>

<div class="kckr-media-import">

<?php echo Html::beginForm(Yii::$app->request->absoluteUrl, 'post', [
	'class'=>'form-horizontal form-label-left',
	'enctype'=>'multipart/form-data',
	'onpost'=>'onpost',
]); ?>

<?php echo $this->description && Yii::$app->request->isAjax ? Html::tag('p', $this->description, ['class'=>'mb-4']) : '';?>

<div class="form-group row">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="importFilename"><?php echo Yii::t('app', 'Import File');?></label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<?php echo Html::fileInput('importFilename', '', ['id'=>'importFilename']);?>
		<div class="help-block help-block-error">
			<?php echo Yii::t('app', 'extensions are allowed: {extensions}', ['extensions'=>$model->setting->import_file_type]);?>
		</div>
	</div>
</div>

<hr/>

<div class="form-group row">
	<div class="col-md-9 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-primary']);?>
	</div>
</div>

<?php echo Html::endForm(); ?>

</div>