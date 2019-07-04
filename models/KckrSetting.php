<?php
/**
 * KckrSetting
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:50 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckr_setting".
 *
 * The followings are the available columns in table "ommu_kckr_setting":
 * @property integer $id
 * @property string $license
 * @property integer $permission
 * @property string $meta_description
 * @property string $meta_keyword
 * @property integer $photo_resize
 * @property string $photo_resize_size
 * @property string $photo_view_size
 * @property string $photo_file_type
 * @property integer $article_cat_id
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property Users $modified
 *
 */

namespace ommu\kckr\models;

use Yii;
use ommu\users\models\Users;

class KckrSetting extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = [];

	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckr_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['license', 'permission', 'meta_description', 'meta_keyword', 'photo_resize', 'photo_resize_size', 'photo_view_size', 'photo_file_type', 'article_cat_id'], 'required'],
			[['permission', 'photo_resize', 'article_cat_id', 'modified_id'], 'integer'],
			[['meta_description', 'meta_keyword'], 'string'],
			//[['photo_resize_size', 'photo_view_size', 'photo_file_type'], 'serialize'],
			[['license'], 'string', 'max' => 32],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'license' => Yii::t('app', 'License'),
			'permission' => Yii::t('app', 'Permission'),
			'meta_description' => Yii::t('app', 'Meta Description'),
			'meta_keyword' => Yii::t('app', 'Meta Keyword'),
			'photo_resize' => Yii::t('app', 'Photo Resize'),
			'photo_resize_size' => Yii::t('app', 'Photo Resize Size'),
			'photo_view_size' => Yii::t('app', 'Photo View Size'),
			'photo_file_type' => Yii::t('app', 'Photo File Type'),
			'article_cat_id' => Yii::t('app', 'Article Cat'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
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
		$this->templateColumns['license'] = [
			'attribute' => 'license',
			'value' => function($model, $key, $index, $column) {
				return $model->license;
			},
		];
		$this->templateColumns['permission'] = [
			'attribute' => 'permission',
			'value' => function($model, $key, $index, $column) {
				return self::getPermission($model->permission);
			},
		];
		$this->templateColumns['meta_description'] = [
			'attribute' => 'meta_description',
			'value' => function($model, $key, $index, $column) {
				return $model->meta_description;
			},
		];
		$this->templateColumns['meta_keyword'] = [
			'attribute' => 'meta_keyword',
			'value' => function($model, $key, $index, $column) {
				return $model->meta_keyword;
			},
		];
		$this->templateColumns['photo_resize_size'] = [
			'attribute' => 'photo_resize_size',
			'value' => function($model, $key, $index, $column) {
				return serialize($model->photo_resize_size);
			},
		];
		$this->templateColumns['photo_view_size'] = [
			'attribute' => 'photo_view_size',
			'value' => function($model, $key, $index, $column) {
				return serialize($model->photo_view_size);
			},
		];
		$this->templateColumns['photo_file_type'] = [
			'attribute' => 'photo_file_type',
			'value' => function($model, $key, $index, $column) {
				return serialize($model->photo_file_type);
			},
		];
		$this->templateColumns['article_cat_id'] = [
			'attribute' => 'article_cat_id',
			'value' => function($model, $key, $index, $column) {
				return $model->article_cat_id;
			},
		];
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
		$this->templateColumns['photo_resize'] = [
			'attribute' => 'photo_resize',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->photo_resize);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
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
	 * function getPermission
	 */
	public static function getPermission($value=null)
	{
		$items = array(
			1 => Yii::t('app', 'Yes, the public can view "module name" unless they are made private.'),
			0 => Yii::t('app', 'No, the public cannot view "module name".'),
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

		$this->photo_resize_size = unserialize($this->photo_resize_size);
		$this->photo_view_size = unserialize($this->photo_view_size);
		$this->photo_file_type = unserialize($this->photo_file_type);
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if(!$this->isNewRecord) {
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
			$this->photo_resize_size = serialize($this->photo_resize_size);
			$this->photo_view_size = serialize($this->photo_view_size);
			$this->photo_file_type = serialize($this->photo_file_type);
		}
		return true;
	}
}
