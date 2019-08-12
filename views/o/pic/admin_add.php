<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this PicController
 * @var $model KckrPic
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckr Pics'=>array('manage'),
		Yii::t('phrase', 'Create'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>