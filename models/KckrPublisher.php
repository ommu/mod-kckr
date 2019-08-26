<?php
/**
 * KckrPublisher
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:50 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckr_publisher".
 *
 * The followings are the available columns in table "ommu_kckr_publisher":
 * @property integer $id
 * @property integer $publish
 * @property integer $publisher_area
 * @property string $publisher_name
 * @property string $publisher_address
 * @property string $publisher_phone
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property Kckrs[] $kckrs
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\kckr\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use ommu\users\models\Users;

class KckrPublisher extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['publisher_phone', 'publisher_address', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date'];

	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckr_publisher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['publisher_area', 'publisher_name', 'publisher_address'], 'required'],
			[['publish', 'publisher_area', 'creation_id', 'modified_id'], 'integer'],
			[['publisher_name', 'publisher_address', 'publisher_phone'], 'string'],
			[['publisher_phone'], 'safe'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'publish' => Yii::t('app', 'Publish'),
			'publisher_area' => Yii::t('app', 'Area'),
			'publisher_name' => Yii::t('app', 'Publisher'),
			'publisher_address' => Yii::t('app', 'Address'),
			'publisher_phone' => Yii::t('app', 'Phone'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'kckrs' => Yii::t('app', 'KCKR'),
			'medias' => Yii::t('app', 'Karya'),
			'items' => Yii::t('app', 'Items'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @param $type relation|count|media|item
	 * @return \yii\db\ActiveQuery
	 */
	public function getKckrs($type='relation', $publish=1)
	{
		if($type == 'relation')
			return $this->hasMany(Kckrs::className(), ['publisher_id' => 'id'])
				->alias('kckrs')
				->andOnCondition([sprintf('%s.publish', 'kckrs') => $publish]);

		$model = Kckrs::find()
			->alias('t')
			->where(['t.publisher_id' => $this->id]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();

		if($type == 'count')
			$kckrs = $model->count();
		else {
			$model->joinWith('medias medias');
			if($type == 'media')
				$kckrs = $model->count('medias.id');
			else if($type == 'item')
				$kckrs = $model->sum('medias.media_item');
		}

		return $kckrs ? $kckrs : 0;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\query\KckrPublisher the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\kckr\models\query\KckrPublisher(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['publisher_name'] = [
			'attribute' => 'publisher_name',
			'value' => function($model, $key, $index, $column) {
				return $model->publisher_name;
			},
		];
		$this->templateColumns['publisher_address'] = [
			'attribute' => 'publisher_address',
			'value' => function($model, $key, $index, $column) {
				return $model->publisher_address;
			},
		];
		$this->templateColumns['publisher_phone'] = [
			'attribute' => 'publisher_phone',
			'value' => function($model, $key, $index, $column) {
				return $model->publisher_phone;
			},
		];
		$this->templateColumns['publisher_area'] = [
			'attribute' => 'publisher_area',
			'value' => function($model, $key, $index, $column) {
				return self::getPublisherArea($model->publisher_area);
			},
			'filter' => self::getPublisherArea(),
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creationDisplayname'] = [
				'attribute' => 'creationDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
					// return $model->creationDisplayname;
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modifiedDisplayname'] = [
				'attribute' => 'modifiedDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
					// return $model->modifiedDisplayname;
				},
			];
		}
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->updated_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'updated_date'),
		];
		$this->templateColumns['kckrs'] = [
			'attribute' => 'kckrs',
			'value' => function($model, $key, $index, $column) {
				$kckrs = $model->getKckrs('count');
				return Html::a($kckrs, ['admin/manage', 'publisher'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} kckrs', ['count'=>$kckrs]), 'data-pjax' => 0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['medias'] = [
			'attribute' => 'medias',
			'value' => function($model, $key, $index, $column) {
				$medias = $model->getKckrs('media');
				return Html::a($medias, ['admin/manage', 'publisher'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} karya', ['count'=>$medias]), 'data-pjax' => 0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['items'] = [
			'attribute' => 'items',
			'value' => function($model, $key, $index, $column) {
				$items = $model->getKckrs('item');
				return Html::a($items, ['admin/manage', 'publisher'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} items', ['count'=>$items]), 'data-pjax' => 0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return $this->quickAction($url, $model->publish);
				},
				'filter' => $this->filterYesNo(),
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getPermission
	 */
	public static function getPublisherArea($value=null)
	{
		$items = array(
			1 => Yii::t('app', 'D.I. Yogyakarta'),
			0 => Yii::t('app', 'Luar D.I. Yogyakarta'),
		);

		if($value !== null)
			return $items[$value];
		else
			return $items;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
		}
		return true;
	}
}
