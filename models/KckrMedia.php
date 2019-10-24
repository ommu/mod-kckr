<?php
/**
 * KckrMedia
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
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
 * @property string $isbn
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

	public $gridForbiddenColumn = ['media_desc', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date', 'picId'];

	public $picId;
	public $categoryName;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $publisherName;
	public $publisherId;

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
			[['kckr_id', 'cat_id', 'media_title', 'media_item'], 'required'],
			[['publish', 'kckr_id', 'cat_id', 'media_item', 'creation_id', 'modified_id'], 'integer'],
			[['media_title', 'media_desc', 'media_author'], 'string'],
			[['media_desc', 'isbn', 'media_publish_year', 'media_author'], 'safe'],
			[['isbn'], 'string', 'max' => 32],
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
			'media_title' => Yii::t('app', 'Title'),
			'media_desc' => Yii::t('app', 'Description'),
			'isbn' => Yii::t('app', 'ISBN'),
			'media_publish_year' => Yii::t('app', 'Publish Year'),
			'media_author' => Yii::t('app', 'Author'),
			'media_item' => Yii::t('app', 'Item'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'picId' => Yii::t('app', 'Person In Charge'),
			'categoryName' => Yii::t('app', 'Category'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'publisherName' => Yii::t('app', 'Publisher'),
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

		if(!$this->hasMethod('search'))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['publisherName'] = [
			'attribute' => 'publisherName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->kckr) ? $model->kckr->publisher->publisher_name : '-';
				// return $model->publisherName;
			},
			'visible' => !Yii::$app->request->get('kckr') && !Yii::$app->request->get('publisher') ? true : false,
		];
		$this->templateColumns['picId'] = [
			'attribute' => 'picId',
			'label' => Yii::t('app', 'PIC'),
			'value' => function($model, $key, $index, $column) {
				return isset($model->kckr) ? $model->kckr->pic->pic_name : '-';
				// return $model->picId;
			},
			'filter' => KckrPic::getPic(),
			'visible' => !Yii::$app->request->get('kckr') ? true : false,
		];
		$this->templateColumns['cat_id'] = [
			'attribute' => 'cat_id',
			'value' => function($model, $key, $index, $column) {
				return isset($model->category) ? $model->category->title->message : '-';
				// return $model->categoryName;
			},
			'filter' => KckrCategory::getCategory(),
			'visible' => !Yii::$app->request->get('category') ? true : false,
		];
		$this->templateColumns['isbn'] = [
			'attribute' => 'isbn',
			'value' => function($model, $key, $index, $column) {
				return $model->isbn;
			},
		];
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
		$this->templateColumns['media_author'] = [
			'attribute' => 'media_author',
			'value' => function($model, $key, $index, $column) {
				return $model->media_author;
			},
		];
		$this->templateColumns['media_publish_year'] = [
			'attribute' => 'media_publish_year',
			'label' => Yii::t('app', 'Year'),
			'value' => function($model, $key, $index, $column) {
				return $model->media_publish_year;
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['media_item'] = [
			'attribute' => 'media_item',
			'value' => function($model, $key, $index, $column) {
				return $model->media_item;
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		$this->templateColumns['modifiedDisplayname'] = [
			'attribute' => 'modifiedDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->modified) ? $model->modified->displayname : '-';
				// return $model->modifiedDisplayname;
			},
			'visible' => !Yii::$app->request->get('modified') ? true : false,
		];
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->updated_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'updated_date'),
		];
		$this->templateColumns['publish'] = [
			'attribute' => 'publish',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['publish', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->publish);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
			'format' => 'raw',
			'visible' => !Yii::$app->request->get('trash') ? true : false,
		];
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
	 * function getSetting
	 */
	public function getSetting($field=[])
	{
		if(empty($field))
			$field = ['import_file_type'];

		$setting = KckrSetting::find()
			->select($field)
			->where(['id' => 1])
			->one();
		
		return $setting;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		if(in_array($this->media_publish_year, ['0000','1970','0002','-0001']))
			$this->media_publish_year = '';

		// $this->picId = isset($this->kckr) ? $this->kckr->pic->pic_name : '-';
		// $this->categoryName = isset($this->category) ? $this->category->title->message : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		// $this->publisherName = isset($this->kckr) ? $this->kckr->publisher->publisher_name : '-';
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
