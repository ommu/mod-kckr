<?php
/**
 * KckrPic
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:49 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckr_pic".
 *
 * The followings are the available columns in table "ommu_kckr_pic":
 * @property integer $id
 * @property integer $publish
 * @property integer $default
 * @property string $pic_name
 * @property string $pic_nip
 * @property string $pic_position
 * @property string $pic_signature
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
use yii\web\UploadedFile;
use thamtech\uuid\helpers\UuidHelper;
use ommu\users\models\Users;

class KckrPic extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['pic_signature', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date'];

	public $old_pic_signature;
	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckr_pic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['pic_name', 'pic_nip', 'pic_position'], 'required'],
			[['publish', 'default', 'creation_id', 'modified_id'], 'integer'],
			[['pic_signature'], 'safe'],
			[['pic_name', 'pic_position'], 'string', 'max' => 64],
			[['pic_nip'], 'string', 'max' => 32],
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
			'default' => Yii::t('app', 'Default'),
			'pic_name' => Yii::t('app', 'Name'),
			'pic_nip' => Yii::t('app', 'NIP'),
			'pic_position' => Yii::t('app', 'Position'),
			'pic_signature' => Yii::t('app', 'Signature'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'old_pic_signature' => Yii::t('app', 'Old Signature'),
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
			return $this->hasMany(Kckrs::className(), ['pic_id' => 'id'])
				->alias('kckrs')
				->andOnCondition([sprintf('%s.publish', 'kckrs') => $publish]);

		$model = Kckrs::find()
			->alias('t')
			->where(['t.pic_id' => $this->id]);
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
	 * @return \ommu\kckr\models\query\KckrPic the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\kckr\models\query\KckrPic(get_called_class());
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
		$this->templateColumns['pic_name'] = [
			'attribute' => 'pic_name',
			'value' => function($model, $key, $index, $column) {
				return $model->pic_name;
			},
		];
		$this->templateColumns['pic_nip'] = [
			'attribute' => 'pic_nip',
			'value' => function($model, $key, $index, $column) {
				return $model->pic_nip;
			},
		];
		$this->templateColumns['pic_position'] = [
			'attribute' => 'pic_position',
			'value' => function($model, $key, $index, $column) {
				return $model->pic_position;
			},
		];
		$this->templateColumns['pic_signature'] = [
			'attribute' => 'pic_signature',
			'value' => function($model, $key, $index, $column) {
				$uploadPath = self::getUploadPath(false);
				return $model->pic_signature ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->pic_signature])), ['alt'=>$model->pic_signature]) : '-';
			},
			'format' => 'html',
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
				return Html::a($kckrs, ['admin/manage', 'pic'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} kckrs', ['count'=>$kckrs])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['medias'] = [
			'attribute' => 'medias',
			'value' => function($model, $key, $index, $column) {
				$medias = $model->getKckrs('media');
				return Html::a($medias, ['admin/manage', 'pic'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} karya', ['count'=>$medias])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['items'] = [
			'attribute' => 'items',
			'value' => function($model, $key, $index, $column) {
				$items = $model->getKckrs('item');
				return Html::a($items, ['admin/manage', 'pic'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} items', ['count'=>$items])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['default'] = [
			'attribute' => 'default',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->default);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['setting/pic/publish', 'id'=>$model->primaryKey]);
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
	 * function getPic
	 */
	public static function getPic($publish=null, $array=true) 
	{
		$model = self::find()->alias('t')
			->select(['t.id', 't.pic_name']);
		if($publish != null)
			$model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.pic_name ASC')->all();

		if($array == true)
			return \yii\helpers\ArrayHelper::map($model, 'id', 'pic_name');

		return $model;
	}

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@public/kckr/pic') : 'kckr/pic');
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		$this->old_pic_signature = $this->pic_signature;
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			// $this->pic_signature = UploadedFile::getInstance($this, 'pic_signature');
			if($this->pic_signature instanceof UploadedFile && !$this->pic_signature->getHasError()) {
				$picSignatureFileType = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
				if(!in_array(strtolower($this->pic_signature->getExtension()), $picSignatureFileType)) {
					$this->addError('pic_signature', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', [
						'name'=>$this->pic_signature->name,
						'extensions'=>$this->formatFileType($picSignatureFileType, false),
					]));
				}
			} else {
				if($this->isNewRecord || (!$this->isNewRecord && $this->old_pic_signature == ''))
					$this->addError('pic_signature', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('pic_signature')]));
			}

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
			if(!$insert) {
				$uploadPath = self::getUploadPath();
				$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
				$this->createUploadDirectory(self::getUploadPath());

				// $this->pic_signature = UploadedFile::getInstance($this, 'pic_signature');
				if($this->pic_signature instanceof UploadedFile && !$this->pic_signature->getHasError()) {
					$fileName = join('-', [time(), UuidHelper::uuid(), $this->id]).'.'.strtolower($this->pic_signature->getExtension()); 
					if($this->pic_signature->saveAs(join('/', [$uploadPath, $fileName]))) {
						if($this->old_pic_signature != '' && file_exists(join('/', [$uploadPath, $this->old_pic_signature])))
							rename(join('/', [$uploadPath, $this->old_pic_signature]), join('/', [$verwijderenPath, $this->id.'-'.time().'_change_'.$this->old_pic_signature]));
						$this->pic_signature = $fileName;
					}
				} else {
					if($this->pic_signature == '')
						$this->pic_signature = $this->old_pic_signature;
				}

			}
		}
		return true;
	}

	/**
	 * After save attributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
		$this->createUploadDirectory(self::getUploadPath());

		if($insert) {
			// $this->pic_signature = UploadedFile::getInstance($this, 'pic_signature');
			if($this->pic_signature instanceof UploadedFile && !$this->pic_signature->getHasError()) {
				$fileName = join('-', [time(), UuidHelper::uuid(), $this->id]).'.'.strtolower($this->pic_signature->getExtension()); 
				if($this->pic_signature->saveAs(join('/', [$uploadPath, $fileName])))
					self::updateAll(['pic_signature' => $fileName], ['id' => $this->id]);
			}

		}
	}

	/**
	 * After delete attributes
	 */
	public function afterDelete()
	{
		parent::afterDelete();

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);

		if($this->pic_signature != '' && file_exists(join('/', [$uploadPath, $this->pic_signature])))
			rename(join('/', [$uploadPath, $this->pic_signature]), join('/', [$verwijderenPath, $this->id.'-'.time().'_deleted_'.$this->pic_signature]));

	}
}
