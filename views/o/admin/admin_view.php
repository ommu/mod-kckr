<?php
/**
 * Kckrs (kckrs)
 * @var $this AdminController
 * @var $model Kckrs
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 1 July 2016, 07:42 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

	$this->breadcrumbs=array(
		'Kckrs'=>array('manage'),
		$model->kckr_id,
	);
?>

<div class="box">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'kckr_id',
				'value'=>$model->kckr_id,
			),
			array(
				'name'=>'publish',
				'value'=>$this->quickAction(Yii::app()->controller->createUrl('publish', array('id'=>$model->kckr_id)), $model->publish),
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
				'value'=>!in_array($model->send_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $this->dateFormat($model->send_date, 'full', false) : '-',
			),
			array(
				'name'=>'receipt_date',
				'value'=>!in_array($model->receipt_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $this->dateFormat($model->receipt_date, 'full', false) : '-',
			),
			array(
				'name'=>'photos',
				'value'=>$model->photos ? CHtml::link($model->photos, Yii::app()->request->baseUrl.'/public/kckr/'.$model->photos, array('target' => '_blank')) : '-',
				'type' => 'raw',
			),
			array(
				'name'=>'thanks_date',
				'value'=>!in_array($model->thanks_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $this->dateFormat($model->thanks_date, 'full', false) : '-',
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
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date) : '-',
			),
			array(
				'name'=>'creation_search',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date) : '-',
			),
			array(
				'name'=>'modified_search',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
		),
	)); ?>
</div>
