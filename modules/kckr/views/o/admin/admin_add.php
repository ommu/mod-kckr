<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://github.com/ommu/ommu-kckr
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'pic'=>$pic,
	'publisher'=>$publisher,
)); ?>