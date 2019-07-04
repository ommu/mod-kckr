<?php
/**
 * KckrPublisher
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
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

	public $gridForbiddenColumn = [];

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
			[['publisher_area', 'publisher_name', 'publisher_address', 'publisher_phone'], 'required'],
			[['publish', 'publisher_area', 'creation_id', 'modified_id'], 'integer'],
			[['publisher_name', 'publisher_address', 'publisher_phone'], 'string'],
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
			'publisher_area' => Yii::t('app', 'Publisher Area'),
			'publisher_name' => Yii::t('app', 'Publisher Name'),
			'publisher_address' => Yii::t('app', 'Publisher Address'),
			'publisher_phone' => Yii::t('app', 'Publisher Phone'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'kckrs' => Yii::t('app', 'Kckrs'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getKckrs($count=false, $publish=1)
	{
		if($count == false)
			return $this->hasMany(Kckrs::className(), ['publisher_id' => 'id'])
			->alias('kckrs')
			->andOnCondition([sprintf('%s.publish', 'kckrs') => $publish]);

		$model = Kckrs::find()
			->where(['publisher_id' => $this->id]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();
		$kckrs = $model->count();

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
				$kckrs = $model->getKckrs(true);
				return Html::a($kckrs, ['admin/manage', 'publisher'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} kckrs', ['count'=>$kckrs])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['publisher_area'] = [
			'attribute' => 'publisher_area',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['publisher-area', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->publisher_area, '0=luar diy, 1=diy');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
			'format' => 'raw',
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
			$model = self::find()
				->select([$column])
				->where(['id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
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
