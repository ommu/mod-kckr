<?php
/**
 * KckrMedia
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:48 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckr_media".
 *
 * The followings are the available columns in table "ommu_kckr_media":
 * @property integer $id
 * @property integer $publish
 * @property integer $kckr_id
 * @property integer $cat_id
 * @property string $media_title
 * @property string $media_desc
 * @property string $media_publish_year
 * @property string $media_author
 * @property integer $media_item
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property Kckrs $kckr
 * @property KckrCategory $category
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\kckr\models;

use Yii;
use yii\helpers\Url;
use ommu\users\models\Users;

class KckrMedia extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = [];

	public $kckrPicId;
	public $categoryName;
	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckr_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['kckr_id', 'cat_id', 'media_title', 'media_desc', 'media_publish_year', 'media_author', 'media_item'], 'required'],
			[['publish', 'kckr_id', 'cat_id', 'media_item', 'creation_id', 'modified_id'], 'integer'],
			[['media_title', 'media_desc', 'media_author'], 'string'],
			[['media_publish_year'], 'safe'],
			[['kckr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kckrs::className(), 'targetAttribute' => ['kckr_id' => 'id']],
			[['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => KckrCategory::className(), 'targetAttribute' => ['cat_id' => 'id']],
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
			'kckr_id' => Yii::t('app', 'Kckr'),
			'cat_id' => Yii::t('app', 'Category'),
			'media_title' => Yii::t('app', 'Media Title'),
			'media_desc' => Yii::t('app', 'Media Desc'),
			'media_publish_year' => Yii::t('app', 'Media Publish Year'),
			'media_author' => Yii::t('app', 'Media Author'),
			'media_item' => Yii::t('app', 'Media Item'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'kckrPicId' => Yii::t('app', 'Kckr'),
			'categoryName' => Yii::t('app', 'Category'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getKckr()
	{
		return $this->hasOne(Kckrs::className(), ['id' => 'kckr_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory()
	{
		return $this->hasOne(KckrCategory::className(), ['id' => 'cat_id']);
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
	 * @return \ommu\kckr\models\query\KckrMedia the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\kckr\models\query\KckrMedia(get_called_class());
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
		if(!Yii::$app->request->get('kckr')) {
			$this->templateColumns['kckrPicId'] = [
				'attribute' => 'kckrPicId',
				'value' => function($model, $key, $index, $column) {
					return isset($model->kckr) ? $model->kckr->pic->pic_name : '-';
					// return $model->kckrPicId;
				},
			];
		}
		if(!Yii::$app->request->get('category')) {
			$this->templateColumns['cat_id'] = [
				'attribute' => 'cat_id',
				'value' => function($model, $key, $index, $column) {
					return isset($model->category) ? $model->category->title->message : '-';
					// return $model->categoryName;
				},
				'filter' => KckrCategory::getCategory(),
			];
		}
		$this->templateColumns['media_title'] = [
			'attribute' => 'media_title',
			'value' => function($model, $key, $index, $column) {
				return $model->media_title;
			},
		];
		$this->templateColumns['media_desc'] = [
			'attribute' => 'media_desc',
			'value' => function($model, $key, $index, $column) {
				return $model->media_desc;
			},
		];
		$this->templateColumns['media_publish_year'] = [
			'attribute' => 'media_publish_year',
			'value' => function($model, $key, $index, $column) {
				return $model->media_publish_year;
			},
		];
		$this->templateColumns['media_author'] = [
			'attribute' => 'media_author',
			'value' => function($model, $key, $index, $column) {
				return $model->media_author;
			},
		];
		$this->templateColumns['media_item'] = [
			'attribute' => 'media_item',
			'value' => function($model, $key, $index, $column) {
				return $model->media_item;
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

		// $this->kckrPicId = isset($this->kckr) ? $this->kckr->pic->pic_name : '-';
		// $this->categoryName = isset($this->category) ? $this->category->title->message : '-';
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

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			$this->media_publish_year = Yii::$app->formatter->asDate($this->media_publish_year, 'php:Y-m-d');
		}
		return true;
	}
}
