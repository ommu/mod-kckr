<?php
/**
 * KckrSetting
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
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
 * @property string $import_file_type
 * @property integer $article_cat_id
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property ArticleCategory $articleCategory
 * @property Users $modified
 *
 */

namespace ommu\kckr\models;

use Yii;
use yii\helpers\Html;
use app\models\Users;
use ommu\article\models\ArticleCategory;
use yii\helpers\Json;

class KckrSetting extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

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
			[['license', 'permission', 'meta_description', 'meta_keyword', 'photo_file_type', 'import_file_type', 'article_cat_id'], 'required'],
			[['permission', 'photo_resize', 'article_cat_id', 'modified_id'], 'integer'],
			[['meta_description', 'meta_keyword'], 'string'],
			[['photo_resize', 'photo_resize_size', 'photo_view_size'], 'safe'],
			//[['photo_resize_size', 'photo_view_size', 'photo_file_type'], 'serialize'],
			//[['import_file_type'], 'json'],
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
			'photo_view_size[small]' => Yii::t('app', 'Small'),
			'photo_view_size[medium]' => Yii::t('app', 'Medium'),
			'photo_view_size[large]' => Yii::t('app', 'Large'),
			'photo_file_type' => Yii::t('app', 'Photo File Type'),
			'import_file_type' => Yii::t('app', 'Import File Type'),
			'article_cat_id' => Yii::t('app', 'Article Category'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'width' => Yii::t('app', 'Width'),
			'height' => Yii::t('app', 'Height'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getArticleCategory()
	{
		return $this->hasOne(ArticleCategory::className(), ['id' => 'article_cat_id']);
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

        if (!(Yii::$app instanceof \app\components\Application)) {
            return;
        }

        if (!$this->hasMethod('search')) {
            return;
        }

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class' => 'text-center'],
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
		$this->templateColumns['photo_resize'] = [
			'attribute' => 'photo_resize',
			'value' => function($model, $key, $index, $column) {
				return self::getPhotoResize($model->photo_resize);
			},
			'filter' => self::getPhotoResize(),
			'contentOptions' => ['class' => 'text-center'],
		];
		$this->templateColumns['photo_resize_size'] = [
			'attribute' => 'photo_resize_size',
			'value' => function($model, $key, $index, $column) {
				return self::getSize($model->photo_resize_size);
			},
		];
		$this->templateColumns['photo_view_size'] = [
			'attribute' => 'photo_view_size',
			'value' => function($model, $key, $index, $column) {
				return self::parsePhotoViewSize($model->photo_view_size);
			},
			'format' => 'html',
		];
		$this->templateColumns['photo_file_type'] = [
			'attribute' => 'photo_file_type',
			'value' => function($model, $key, $index, $column) {
				return $model->photo_file_type;
			},
		];
		$this->templateColumns['import_file_type'] = [
			'attribute' => 'import_file_type',
			'value' => function($model, $key, $index, $column) {
				return $model->import_file_type;
			},
		];
		$this->templateColumns['article_cat_id'] = [
			'attribute' => 'article_cat_id',
			'value' => function($model, $key, $index, $column) {
				return isset($model->articleCategory) ? $model->articleCategory->name_i : '-';
			},
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
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
        if ($column != null) {
            $model = self::find();
            if (is_array($column)) {
                $model->select($column);
            } else {
                $model->select([$column]);
            }
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
	public static function getPermission($value=null)
	{
		$moduleName = "module name";
		$module = strtolower(Yii::$app->controller->module->id);
        if (($module = Yii::$app->moduleManager->getModule($module)) != null) {
            $moduleName = strtolower($module->getName());
        }

		$items = array(
			1 => Yii::t('app', 'Yes, the public can view {module} unless they are made private.', ['module' => $moduleName]),
			0 => Yii::t('app', 'No, the public cannot view {module}.', ['module' => $moduleName]),
		);

        if ($value !== null) {
            return $items[$value];
        } else {
            return $items;
        }
	}

	/**
	 * function getPhotoResize
	 */
	public static function getPhotoResize($value=null)
	{
		$items = array(
			1 => Yii::t('app', 'Yes, resize photo after upload.'),
			0 => Yii::t('app', 'No, not resize photo after upload.'),
		);

        if ($value !== null) {
            return $items[$value];
        } else {
            return $items;
        }
	}

	/**
	 * function getSize
	 */
	public function getSize($size)
	{
        if (empty($size)) {
            return '-';
        }

		$width = $size['width'] ? $size['width'] : '~';
		$height = $size['height'] ? $size['height'] : '~';
		return $width.' x '.$height;
	}

	/**
	 * function parsePhotoViewSize
	 */
	public function parsePhotoViewSize($view_size)
	{
        if (empty($view_size)) {
            return '-';
        }

		$views = [];
		foreach ($view_size as $key => $value) {
			$views[] = ucfirst($key).": ".self::getSize($value);
		}
		return Html::ul($views, ['encode' => false, 'class' => 'list-boxed']);
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		$this->photo_resize_size = unserialize($this->photo_resize_size);
		$this->photo_view_size = unserialize($this->photo_view_size);
		$photo_file_type = unserialize($this->photo_file_type);
        if (!empty($photo_file_type)) {
            $this->photo_file_type = $this->formatFileType($photo_file_type, false);
        }
		$import_file_type = Json::decode($this->import_file_type);
        if (!empty($import_file_type)) {
            $this->import_file_type = $this->formatFileType($import_file_type, false);
        }
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
        if (parent::beforeValidate()) {
            if (!$this->isNewRecord) {
                if ($this->modified_id == null) {
                    $this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            }

            if ($this->photo_resize_size['width'] == '') {
                $this->addError('photo_resize_size', Yii::t('app', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel('photo_resize_size')]));
            }

            if ($this->photo_view_size['small']['width'] == '' || $this->photo_view_size['medium']['width'] == '' || $this->photo_view_size['large']['width'] == '') {
                $this->addError('photo_view_size', Yii::t('app', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel('photo_view_size')]));
            }
        }
        return true;
	}

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
        if (parent::beforeSave($insert)) {
			$this->photo_resize_size = serialize($this->photo_resize_size);
			$this->photo_view_size = serialize($this->photo_view_size);
			$this->photo_file_type = serialize($this->formatFileType($this->photo_file_type));
			$this->import_file_type = Json::encode($this->formatFileType($this->import_file_type));
        }
        return true;
	}
}
