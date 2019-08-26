<?php
/**
 * Kckrs
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:49 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 * This is the model class for table "ommu_kckrs".
 *
 * The followings are the available columns in table "ommu_kckrs":
 * @property integer $id
 * @property integer $publish
 * @property integer $article_id
 * @property integer $pic_id
 * @property integer $publisher_id
 * @property string $letter_number
 * @property string $send_type
 * @property string $send_date
 * @property string $receipt_date
 * @property string $thanks_date
 * @property string $thanks_document
 * @property integer $thanks_user_id
 * @property string $photos
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property KckrMedia[] $media
 * @property Articles $article
 * @property KckrPic $pic
 * @property KckrPublisher $publisher
 * @property Users $thanksUser
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
use ommu\article\models\Articles;

class Kckrs extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['pic_id', 'thanks_date', 'thanks_document', 'thanksUserDisplayname', 'photos', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date'];

	public $old_photos;
	public $picName;
	public $publisherName;
	public $thanksUserDisplayname;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $document;
	public $article;
	public $regenerate;

	const SCENARIO_DOCUMENT = 'documentForm';

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_kckrs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['pic_id', 'publisher_id', 'letter_number', 'send_type', 'send_date', 'receipt_date'], 'required'],
			[['thanks_date'], 'required', 'on' => self::SCENARIO_DOCUMENT],
			[['publish', 'article_id', 'pic_id', 'publisher_id', 'thanks_user_id', 'creation_id', 'modified_id'], 'integer'],
			[['send_type'], 'string'],
			//[['thanks_document'], 'serialize'],
			[['send_date', 'receipt_date', 'thanks_date', 'thanks_document', 'thanks_user_id', 'photos', 'regenerate'], 'safe'],
			[['letter_number'], 'string', 'max' => 64],
			[['pic_id'], 'exist', 'skipOnError' => true, 'targetClass' => KckrPic::className(), 'targetAttribute' => ['pic_id' => 'id']],
			[['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => KckrPublisher::className(), 'targetAttribute' => ['publisher_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_DOCUMENT] = ['thanks_date', 'thanks_document', 'thanks_user_id', 'regenerate'];
		return $scenarios;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'publish' => Yii::t('app', 'Publish'),
			'article_id' => Yii::t('app', 'Article'),
			'pic_id' => Yii::t('app', 'Person In Charge'),
			'publisher_id' => Yii::t('app', 'Publisher'),
			'letter_number' => Yii::t('app', 'Letter Number'),
			'send_type' => Yii::t('app', 'Send Type'),
			'send_date' => Yii::t('app', 'Send Date'),
			'receipt_date' => Yii::t('app', 'Receipt Date'),
			'thanks_date' => Yii::t('app', 'Thanks Date'),
			'thanks_document' => Yii::t('app', 'Thanks Document'),
			'thanks_user_id' => Yii::t('app', 'Thanks User'),
			'photos' => Yii::t('app', 'Photos'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'old_photos' => Yii::t('app', 'Old Photos'),
			'medias' => Yii::t('app', 'Karya'),
			'items' => Yii::t('app', 'Items'),
			'picName' => Yii::t('app', 'Person In Charge'),
			'publisherName' => Yii::t('app', 'Publisher'),
			'thanksUserDisplayname' => Yii::t('app', 'Thanks User'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'article' => Yii::t('app', 'Article'),
			'document' => Yii::t('app', 'Document'),
			'regenerate' => Yii::t('app', 'Regenerate Document'),
			'documents' => Yii::t('app', 'Documents'),
		];
	}

	/**
	 * @param $type relation|count|sum
	 * @return \yii\db\ActiveQuery
	 */
	public function getMedias($type='relation', $publish=1)
	{
		if($type == 'relation')
			return $this->hasMany(KckrMedia::className(), ['kckr_id' => 'id'])
				->alias('medias')
				->andOnCondition([sprintf('%s.publish', 'medias') => $publish]);

		$model = KckrMedia::find()
			->where(['kckr_id' => $this->id]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();

		if($type == 'sum')
			$media = $model->sum('media_item');
		else
			$media = $model->count();

		return $media ? $media : 0;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getArticle()
	{
		return $this->hasOne(Articles::className(), ['id' => 'article_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPic()
	{
		return $this->hasOne(KckrPic::className(), ['id' => 'pic_id']);
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
	public function getThanksUser()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'thanks_user_id']);
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
	 * @return \ommu\kckr\models\query\Kckrs the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\kckr\models\query\Kckrs(get_called_class());
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
		if(!Yii::$app->request->get('pic')) {
			$this->templateColumns['pic_id'] = [
				'attribute' => 'pic_id',
				'value' => function($model, $key, $index, $column) {
					return isset($model->pic) ? $model->pic->pic_name : '-';
					// return $model->picName;
				},
				'filter' => KckrPic::getPic(),
			];
		}
		if(!Yii::$app->request->get('publisher')) {
			$this->templateColumns['publisherName'] = [
				'attribute' => 'publisherName',
				'value' => function($model, $key, $index, $column) {
					return isset($model->publisher) ? $model->publisher->publisher_name : '-';
					// return $model->publisherName;
				},
			];
		}
		$this->templateColumns['letter_number'] = [
			'attribute' => 'letter_number',
			'value' => function($model, $key, $index, $column) {
				return $model->letter_number;
			},
		];
		$this->templateColumns['send_type'] = [
			'attribute' => 'send_type',
			'label' => Yii::t('app', 'Send'),
			'value' => function($model, $key, $index, $column) {
				return self::getSendType($model->send_type);
			},
			'filter' => self::getSendType(),
		];
		$this->templateColumns['send_date'] = [
			'attribute' => 'send_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDate($model->send_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'send_date'),
		];
		$this->templateColumns['receipt_date'] = [
			'attribute' => 'receipt_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDate($model->receipt_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'receipt_date'),
		];
		$this->templateColumns['photos'] = [
			'attribute' => 'photos',
			'value' => function($model, $key, $index, $column) {
				$uploadPath = self::getUploadPath(false);
				return $model->photos ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->photos])), ['alt'=>$model->photos]) : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['thanks_document'] = [
			'attribute' => 'thanks_document',
			'value' => function($model, $key, $index, $column) {
				return Kckrs::parseDocument($model->thanks_document);
			},
			'filter' => false,
			'format' => 'raw',
		];
		$this->templateColumns['thanks_date'] = [
			'attribute' => 'thanks_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDate($model->thanks_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'thanks_date'),
		];
		if(!Yii::$app->request->get('thanksUser')) {
			$this->templateColumns['thanksUserDisplayname'] = [
				'attribute' => 'thanksUserDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->thanksUser) ? $model->thanksUser->displayname : '-';
					// return $model->thanksUserDisplayname;
				},
			];
		}
		$this->templateColumns['medias'] = [
			'attribute' => 'medias',
			'value' => function($model, $key, $index, $column) {
				$medias = $model->getMedias('count');
				return Html::a($medias, ['o/media/manage', 'kckr'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} karya', ['count'=>$medias]), 'data-pjax' => 0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'raw',
		];
		$this->templateColumns['items'] = [
			'attribute' => 'items',
			'value' => function($model, $key, $index, $column) {
				$items = $model->getMedias('sum');
				return Html::a($items, ['o/media/manage', 'kckr'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} items', ['count'=>$items]), 'data-pjax' => 0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'raw',
		];
		$this->templateColumns['document'] = [
			'attribute' => 'document',
			'value' => function($model, $key, $index, $column) {
				return Html::a($model->thanks_date ? '<span class="glyphicon glyphicon-ok"></span>' : Yii::t('app', 'Document'), ['print', 'id'=>$model->primaryKey], ['title'=>$model->thanks_date ? Yii::t('app', 'Update Document') : Yii::t('app', 'Create Document'), 'class'=>'modal-btn']);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['article'] = [
			'attribute' => 'article',
			'value' => function($model, $key, $index, $column) {
				return isset($model->article) ? 
					Html::a('<span class="glyphicon glyphicon-ok"></span>', ['article', 'id'=>$model->primaryKey, 'aid'=>$model->article_id], ['title'=>Yii::t('app', 'Update Article')]) : 
					Html::a(Yii::t('app', 'Article'), ['article', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Create Article')]);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
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
	 * function getSetting
	 */
	public function getSetting($field=[])
	{
		if(empty($field))
			$field = ['photo_resize', 'photo_resize_size', 'photo_view_size', 'photo_file_type', 'article_cat_id'];

		$setting = KckrSetting::find()
			->select($field)
			->where(['id' => 1])
			->one();
		
		return $setting;
	}

	/**
	 * function getSendType
	 */
	public static function getSendType($value=null)
	{
		$items = array(
			'pos' => Yii::t('app', 'Pos'),
			'langsung' => Yii::t('app', 'Langsung'),
		);

		if($value !== null)
			return $items[$value];
		else
			return $items;
	}

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@public/kckr') : 'kckr');
	}

	/**
	 * function parseDocument
	 */
	public static function parseDocument($documents, $sep='li')
	{
		if(!is_array($documents) || (is_array($documents) && empty($documents)))
			return '-';

		$items = self::getDocumentUrl($documents, true);

		if($sep == 'li') {
			return Html::ul($items, ['item' => function($item, $index) {
				return Html::tag('li', $item);
			}, 'class'=>'list-boxed']);
		}

		return implode($sep, $items);
	}

	/**
	 * function getDocumentUrl
	 */
	public static function getDocumentUrl($documents, $hyperlink=false)
	{
		$uploadPath = self::getUploadPath(false);

		$items = [];
		foreach ($documents as $val) {
			if($hyperlink)
				$items[$val] = Html::a($val, join('/', ['@webpublic', $uploadPath, 'document', $val]), ['title'=>$val, 'target'=>'_blank']);
			else
				$items[$val] = Url::to(join('/', ['@webpublic', $uploadPath, 'document', $val]));
		}

		return $items;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		if(in_array($this->send_date, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']))
			$this->send_date = '';
		if(in_array($this->receipt_date, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']))
			$this->receipt_date = '';
		if(in_array($this->thanks_date, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']))
			$this->thanks_date = '';

		$this->thanks_document = unserialize($this->thanks_document);
		$this->old_photos = $this->photos;
		// $this->picName = isset($this->pic) ? $this->pic->pic_name : '-';
		// $this->publisherName = isset($this->publisher) ? $this->publisher->publisher_name : '-';
		// $this->thanksUserDisplayname = isset($this->thanksUser) ? $this->thanksUser->displayname : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		$this->document = $this->thanks_date ? 1 : 0;
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		$setting = $this->getSetting(['photo_file_type']);

		if(parent::beforeValidate()) {
			// $this->photos = UploadedFile::getInstance($this, 'photos');
			if($this->photos instanceof UploadedFile && !$this->photos->getHasError()) {
				$photoFileType = $this->formatFileType($setting->photo_file_type);
				if(!in_array(strtolower($this->photos->getExtension()), $photoFileType)) {
					$this->addError('photos', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', [
						'name'=>$this->photos->name,
						'extensions'=>$setting->photo_file_type,
					]));
				}
			} /* else {
				if($this->isNewRecord || (!$this->isNewRecord && $this->old_photos == ''))
					$this->addError('photos', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('photos')]));
			} */

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
		$setting = $this->getSetting(['photo_resize', 'photo_resize_size']);

		if(parent::beforeSave($insert)) {
			if(!$insert) {
				$uploadPath = self::getUploadPath();
				$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
				$this->createUploadDirectory(self::getUploadPath());

				// $this->photos = UploadedFile::getInstance($this, 'photos');
				if($this->photos instanceof UploadedFile && !$this->photos->getHasError()) {
					$fileName = join('-', [time(), UuidHelper::uuid(), $this->id]).'.'.strtolower($this->photos->getExtension()); 
					if($this->photos->saveAs(join('/', [$uploadPath, $fileName]))) {
						$photoResize = $setting->photo_resize_size;
						if($setting->photo_resize)
							$this->resizeImage(join('/', [$uploadPath, $fileName]), $photoResize['width'], $photoResize['height']);
						if($this->old_photos != '' && file_exists(join('/', [$uploadPath, $this->old_photos])))
							rename(join('/', [$uploadPath, $this->old_photos]), join('/', [$verwijderenPath, $this->id.'-'.time().'_change_'.$this->old_photos]));
						$this->photos = $fileName;
					}
				} else {
					if($this->photos == '')
						$this->photos = $this->old_photos;
				}

			}
			$this->send_date = Yii::$app->formatter->asDate($this->send_date, 'php:Y-m-d');
			$this->receipt_date = Yii::$app->formatter->asDate($this->receipt_date, 'php:Y-m-d');
			if($this->scenario == self::SCENARIO_DOCUMENT)
				$this->thanks_date = Yii::$app->formatter->asDate($this->thanks_date, 'php:Y-m-d');
			$this->thanks_document = serialize($this->thanks_document);
		}
		return true;
	}

	/**
	 * After save attributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		$setting = $this->getSetting(['photo_resize', 'photo_resize_size']);

		parent::afterSave($insert, $changedAttributes);

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
		$this->createUploadDirectory(self::getUploadPath());

		if($insert) {
			// $this->photos = UploadedFile::getInstance($this, 'photos');
			if($this->photos instanceof UploadedFile && !$this->photos->getHasError()) {
				$fileName = join('-', [time(), UuidHelper::uuid(), $this->id]).'.'.strtolower($this->photos->getExtension()); 
				if($this->photos->saveAs(join('/', [$uploadPath, $fileName]))) {
					$photoResize = $setting->photo_resize_size;
					if($setting->photo_resize)
						$this->resizeImage(join('/', [$uploadPath, $fileName]), $photoResize['width'], $photoResize['height']);
					self::updateAll(['photos' => $fileName], ['id' => $this->id]);
				}
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

		if($this->photos != '' && file_exists(join('/', [$uploadPath, $this->photos])))
			rename(join('/', [$uploadPath, $this->photos]), join('/', [$verwijderenPath, $this->id.'-'.time().'_deleted_'.$this->photos]));

	}
}
