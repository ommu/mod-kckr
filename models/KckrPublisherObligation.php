<?php
/**
 * KckrPublisherObligation
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 3 October 2019, 21:25 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckr_media".
 *
 * The followings are the available columns in table "ommu_kckr_media":
 * @property integer $id
 * @property integer $publish
 * @property integer $publisher_id
 * @property integer $cat_id
 * @property string $media_title
 * @property string $media_desc
 * @property string $isbn
 * @property string $media_publish_year
 * @property string $media_author
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property KckrPublisher $publisher
 * @property KckrCategory $category
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\kckr\models;

use Yii;
use yii\helpers\Url;
use ommu\users\models\Users;

class KckrPublisherObligation extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['media_desc', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date'];

	public $publisherName;
	public $categoryName;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $handover;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckr_publisher_obligation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['publisher_id', 'cat_id', 'media_title'], 'required'],
			[['publish', 'publisher_id', 'cat_id', 'creation_id', 'modified_id'], 'integer'],
			[['media_title', 'media_desc', 'media_author'], 'string'],
			[['media_desc', 'isbn', 'media_publish_year', 'media_author'], 'safe'],
			[['isbn'], 'string', 'max' => 32],
			[['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => KckrPublisher::className(), 'targetAttribute' => ['publisher_id' => 'id']],
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
			'publisher_id' => Yii::t('app', 'Publisher'),
			'cat_id' => Yii::t('app', 'Category'),
			'media_title' => Yii::t('app', 'Title'),
			'media_desc' => Yii::t('app', 'Description'),
			'isbn' => Yii::t('app', 'ISBN'),
			'media_publish_year' => Yii::t('app', 'Publish Year'),
			'media_author' => Yii::t('app', 'Author'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'publisherName' => Yii::t('app', 'Publisher'),
			'categoryName' => Yii::t('app', 'Category'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'handover' => Yii::t('app', 'Handover'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPublisher()
	{
		return $this->hasOne(KckrPublisher::className(), ['id' => 'publisher_id']);
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
	 * @param $type relation|count
	 * @return \yii\db\ActiveQuery
	 */
	public function getHandovers($type='relation', $publish=1)
	{
		if($type == 'relation')
			return $this->hasMany(KckrMedia::className(), ['isbn' => 'isbn'])
				->alias('handovers')
				->andOnCondition([sprintf('%s.publish', 'handovers') => $publish]);

		$model = KckrMedia::find()
			->alias('t')
			->where(['t.isbn' => $this->isbn]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();
			
		$media = $model->count();

		return $media ? $media : 0;
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\query\KckrPublisherObligation the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\kckr\models\query\KckrPublisherObligation(get_called_class());
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
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['publisherName'] = [
			'attribute' => 'publisherName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->publisher) ? $model->publisher->publisher_name : '-';
				// return $model->publisherName;
			},
			'visible' => !Yii::$app->request->get('publisher') ? true : false,
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
			'contentOptions' => ['class'=>'text-center'],
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
		$this->templateColumns['handover'] = [
			'attribute' => 'handover',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->handover);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['publish'] = [
			'attribute' => 'publish',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['publish', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->publish);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
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

		// $this->publisherName = isset($this->publisher) ? $this->publisher->publisher_name : '-';
		// $this->categoryName = isset($this->category) ? $this->category->title->message : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		$this->handover = $this->getHandovers('count') ? 1 : 0;
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
