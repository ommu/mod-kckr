<?php
/**
 * Kckr Publishers (kckr-publisher)
 * @var $this PublisherController
 * @var $model KckrPublisher
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:41 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckr Publishers'=>array('manage'),
		$model->publisher_id=>array('view','id'=>$model->publisher_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>