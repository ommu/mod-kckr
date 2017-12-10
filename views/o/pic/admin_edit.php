<?php
/**
 * Kckr Pics (kckr-pic)
 * @var $this PicController
 * @var $model KckrPic
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link https://github.com/ommu/ommu-kckr
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Pics'=>array('manage'),
		$model->pic_id=>array('view','id'=>$model->pic_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>