<?php
/**
 * MediaController
 * @var $this ommu\kckr\controllers\publisher\MediaController
 * @var $model ommu\kckr\models\KckrMedia
 *
 * MediaController implements the CRUD actions for KckrMedia model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *	Import
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://github.com/ommu/mod-kckr
 *
 */

namespace ommu\kckr\controllers\publisher;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\kckr\models\KckrMedia;
use ommu\kckr\models\search\KckrMedia as KckrMediaSearch;
use ommu\kckr\models\KckrCategory;
use ommu\kckr\models\Kckrs;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use thamtech\uuid\helpers\UuidHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MediaController extends Controller
{
	use \ommu\traits\FileTrait;

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();

        if (Yii::$app->request->get('id') || Yii::$app->request->get('kckr')) {
            $this->subMenu = $this->module->params['kckr_submenu'];
        }
        if (Yii::$app->request->get('publisher')) {
            $this->subMenu = $this->module->params['publisher_submenu'];
        }
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'publish' => ['POST'],
                ],
            ],
        ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
        return $this->redirect(['manage']);
	}

	/**
	 * Lists all KckrMedia models.
	 * @return mixed
	 */
	public function actionManage()
	{
        $searchModel = new KckrMediaSearch();
        if (($publisher = Yii::$app->request->get('publisher')) != null) {
            $searchModel = new KckrMediaSearch(['publisherId' => $publisher]);
        }
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $gridColumn = Yii::$app->request->get('GridColumn', null);
        $cols = [];
        if ($gridColumn != null && count($gridColumn) > 0) {
            foreach ($gridColumn as $key => $val) {
                if ($gridColumn[$key] == 1) {
                    $cols[] = $key;
                }
            }
        }
        $columns = $searchModel->getGridColumn($cols);

        if (($kckr = Yii::$app->request->get('kckr')) != null) {
            $this->subMenuParam = $kckr;
			$kckr = \ommu\kckr\models\Kckrs::findOne($kckr);
		}
        if (($category = Yii::$app->request->get('category')) != null) {
            $category = \ommu\kckr\models\KckrCategory::findOne($category);
        }
        if ($publisher != null) {
            $this->subMenuParam = $publisher;
			$publisher = \ommu\kckr\models\KckrPublisher::findOne($publisher);
		}
        if (($pic = Yii::$app->request->get('picId')) != null) {
            $pic = \ommu\kckr\models\KckrPic::findOne($pic);
        }

		$this->view->title = Yii::t('app', 'Medias');
        if ($kckr) {
            $this->view->title = Yii::t('app', 'Medias: Publisher {publisher-name}', ['publisher-name' => $kckr->publisher->publisher_name]);
        }
        if ($category) {
            $this->view->title = Yii::t('app', 'Medias: Category {category-name}', ['category-name' => $category->category_name_i]);
        }
        if ($publisher) {
            $this->view->title = Yii::t('app', 'Medias: Publisher {publisher-name}', ['publisher-name' => $publisher->publisher_name]);
        }

		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'kckr' => $kckr,
			'category' => $category,
			'publisher' => $publisher,
			'pic' => $pic,
		]);
	}

	/**
	 * Creates a new KckrMedia model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
        if (($id = Yii::$app->request->get('id')) == null) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

		$model = new KckrMedia(['kckr_id' => $id]);
		$this->subMenuParam = $model->kckr_id;

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            $model->load($postData);
            $model->media_publish_year = $postData['media_publish_year'] ? $postData['media_publish_year'] : '0000';

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success created.'));
                if (!Yii::$app->request->isAjax) {
					return $this->redirect(['manage', 'kckr' => $model->kckr_id]);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'kckr' => $model->kckr_id]);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Add Media');
        if (isset($model->kckr)) {
            $this->view->title = Yii::t('app', 'Add Media: Publisher {publisher-name}', ['publisher-name' => $model->kckr->publisher->publisher_name]);
        }
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing KckrMedia model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->subMenuParam = $model->kckr_id;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success updated.'));
                if (!Yii::$app->request->isAjax) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }
                return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'kckr' => $model->kckr_id]);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Update Media: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single KckrMedia model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
        $model = $this->findModel($id);
		$this->subMenuParam = $model->kckr_id;

		$this->view->title = Yii::t('app', 'Detail Media: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
			'small' => false,
		]);
	}

	/**
	 * Deletes an existing KckrMedia model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success deleted.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'kckr' => $model->kckr_id]);
		}
	}

	/**
	 * actionPublish an existing KckrMedia model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr media success updated.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'kckr' => $model->kckr_id]);
		}
	}

	/**
	 * Import a new KckrMedia model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionImport()
	{
        if (($id = Yii::$app->request->get('id')) == null) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $kckrAsset = \ommu\kckr\components\assets\KckrAsset::register($this->getView());
        $template = join('/', [$kckrAsset->baseUrl, 'import_media_template.xlsx']);

		$model = new KckrMedia(['kckr_id' => $id]);
		$this->subMenuParam = $model->kckr_id;

		$setting = $model->setting;
		$category = KckrCategory::find()
			->select(['id', 'category_code'])
			->andWhere(['publish' => 1])
			->all();
		$category = ArrayHelper::map($category, 'id', 'category_code');
		$category = array_flip($category);

        if (Yii::$app->request->isPost) {
			$kckrPath = Kckrs::getUploadPath();
			$mediaImportPath = join('/', [$kckrPath, 'media_import']);
			$verwijderenPath = join('/', [$kckrPath, 'verwijderen']);
			$this->createUploadDirectory($kckrPath, 'media_import');

			$errors = [];
			$importFilename = UploadedFile::getInstanceByName('importFilename');
            if ($importFilename instanceof UploadedFile && !$importFilename->getHasError()) {
				$importFileType = $this->formatFileType($setting->import_file_type);
                if (in_array(strtolower($importFilename->getExtension()), $importFileType)) {
					$fileName = join('-', [time(), UuidHelper::uuid()]);
					$fileNameExtension = $fileName.'.'.strtolower($importFilename->getExtension());
                    if ($importFilename->saveAs(join('/', [$mediaImportPath, $fileNameExtension]))) {
						$spreadsheet = IOFactory::load(join('/', [$mediaImportPath, $fileNameExtension]));
						$sheetData = $spreadsheet->getActiveSheet()->toArray();

						try {
							foreach ($sheetData as $key => $value) {
                                if ($key == 0) {
									continue;
                                }
								$category_code			= trim($value[0]);
								$isbn					= trim($value[1]);
								$media_title			= trim($value[2]);
								$media_desc				= trim($value[3]);
								$media_publish_year		= trim($value[4]);
								$media_author			= trim($value[5]);
								$media_item				= trim($value[6]);

								$cat_id = 1;
                                if ($category_code) {
                                    if (ArrayHelper::keyExists($category_code, $category)) {
										$cat_id = trim($category[$category_code]);
                                    }
								}

								$model=new KckrMedia;
								$model->kckr_id = $id;
								$model->cat_id = $cat_id;
								$model->isbn = $isbn;
								$model->media_title = $media_title;
								$model->media_desc = $media_desc;
								$model->media_publish_year = $media_publish_year;
								$model->media_author = $media_author;
								$model->media_item = $media_item;
                                if (!$model->save()) {
									$errors['row#'.$key+1] = $model->getErrors();
                                }
							}
							Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher media success imported.'));
						} catch (\Exception $e) {
							throw $e;
						} catch (\Throwable $e) {
							throw $e;
						}
					}
	
				} else {
					Yii::$app->session->setFlash('error', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', [
						'name' => $importFilename->name,
						'extensions' => $setting->import_file_type,
					]));
				}
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Import file cannot be blank.'));
            }

            if (!empty($errors)) {
				$mediaImportErrorFile = join('/', [$mediaImportPath, $fileName.'.json']);
                if (!file_exists($mediaImportErrorFile)) {
					file_put_contents($mediaImportErrorFile, Json::encode($errors));
                }
			}

            if (!Yii::$app->request->isAjax) {
				return $this->redirect(['import', 'id' => $id]);
            }
			return $this->redirect(Yii::$app->request->referrer ?: ['import', 'id' => $id]);
		}

		$this->view->title = Yii::t('app', 'Import Media');
        if (isset($model->kckr->publisher)) {
			$this->view->title = Yii::t('app', 'Import Media: Publisher {publisher-name}', ['publisher-name' => $model->kckr->publisher->publisher_name]);
        }
		$this->view->description = '';
        if (Yii::$app->request->isAjax) {
			$this->view->description = Yii::t('app', 'Are you sure you want to import media data?');
        }
		$this->view->keywords = '';
		return $this->oRender('admin_import', [
			'model' => $model,
			'template' => $template,
		]);
	}

	/**
	 * Finds the KckrMedia model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return KckrMedia the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = KckrMedia::findOne($id)) !== null) {
            return $model;
        }

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
