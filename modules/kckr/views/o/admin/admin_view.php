<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		$model->kckr_id,
	);
?>

<div class="box">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'kckr_id',
				'value'=>$model->kckr_id,
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				'type'=>'raw',
			),
			array(
				'name'=>'pic_id',
				'value'=>$model->pic_id ? $model->pic->pic_name : '-',
			),
			array(
				'name'=>'publisher_id',
				'value'=>$model->publisher_id ? $model->publisher->publisher_name : '-',
			),
			array(
				'name'=>'letter_number',
				'value'=>$model->letter_number ? $model->letter_number : '-',
			),
			array(
				'name'=>'send_type',
				'value'=>$model->send_type ? ($model->send_type != 'pos' ? Yii::t('phrase', 'Pos') : Yii::t('phrase', 'Langsung')) : '-',
			),
			array(
				'name'=>'send_date',
				'value'=>!in_array($model->send_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->send_date) : '-',
			),
			array(
				'name'=>'receipt_date',
				'value'=>!in_array($model->receipt_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->receipt_date) : '-',
			),
			array(
				'name'=>'photos',
				'value'=>$model->photos ? CHtml::link($model->photos, Yii::app()->request->baseUrl.'/public/kckr/'.$model->photos, array('target' => '_blank')) : '-',
				'type' => 'raw',
			),
			array(
				'name'=>'thanks_date',
				'value'=>!in_array($model->thanks_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->thanks_date) : '-',
			),
			array(
				'name'=>'thanks_document',
				'value'=>$model->thanks_document ? $this->renderPartial('_view_document', array('thanks_document'=>unserialize($model->thanks_document)), true, false) : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'thanks_user_id',
				'value'=>$model->thanks_user_id ? $model->thanks_user_id : '-',
			),
			array(
				'name'=>'article_id',
				'value'=>$model->article_id ? $model->article->body : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>
