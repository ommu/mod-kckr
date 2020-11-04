<?php
/**
 * ObligationController
 * @var $this ommu\kckr\controllers\o\ObligationController
 * @var $model ommu\kckr\models\KckrPublisherObligation
 *
 * ObligationController implements the CRUD actions for KckrPublisherObligation model.
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
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 3 October 2019, 21:39 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\controllers\o;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\kckr\models\KckrPublisherObligation;
use ommu\kckr\models\search\KckrPublisherObligation as KckrPublisherObligationSearch;
use ommu\kckr\models\KckrCategory;
use ommu\kckr\models\Kckrs;
use ommu\kckr\models\KckrMedia;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use thamtech\uuid\helpers\UuidHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ObligationController extends Controller
{
	use \ommu\traits\FileTrait;

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();

        if (Yii::$app->request->get('id') || Yii::$app->request->get('publisher')) {
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
	 * Lists all KckrPublisherObligation models.
	 * @return mixed
	 */
	public function actionManage()
	{
        $searchModel = new KckrPublisherObligationSearch();
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

        if (($publisher = Yii::$app->request->get('publisher')) != null) {
			$this->subMenuParam = $publisher;
			$publisher = \ommu\kckr\models\KckrPublisher::findOne($publisher);
		}
        if (($category = Yii::$app->request->get('category')) != null) {
            $category = \ommu\kckr\models\KckrCategory::findOne($category);
        }

		$this->view->title = Yii::t('app', 'Obligations');
        if ($publisher) {
            $this->view->title = Yii::t('app', 'Obligations: Publisher {publisher-name}', ['publisher-name'=>$publisher->publisher_name]);
        }
        if ($category) {
            $this->view->title = Yii::t('app', 'Obligations: Category {category-name}', ['category-name'=>$category->category_name_i]);
        }

		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'publisher' => $publisher,
			'category' => $category,
		]);
	}

	/**
	 * Creates a new KckrPublisherObligation model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
        if (($id = Yii::$app->request->get('id')) == null) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

		$model = new KckrPublisherObligation(['publisher_id'=>$id]);
		$this->subMenuParam = $model->publisher_id;

        if (Yii::$app->request->isPost) {
			$postData = Yii::$app->request->post();
			$model->load($postData);
			$model->media_publish_year = $postData['media_publish_year'] ? $postData['media_publish_year'] : '0000';

            if ($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher obligation success created.'));
                if (!Yii::$app->request->isAjax) {
					return $this->redirect(['manage', 'publisher'=>$model->publisher_id]);
                }
				return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'publisher'=>$model->publisher_id]);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
			}
		}

		$this->view->title = Yii::t('app', 'Add Obligation');
        if (isset($model->publisher)) {
            $this->view->title = Yii::t('app', 'Add Obligation: Publisher {publisher-name}', ['publisher-name'=>$model->publisher->publisher_name]);
        }
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing KckrPublisherObligation model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$this->subMenuParam = $model->publisher_id;

        if (Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher obligation success updated.'));
                if (!Yii::$app->request->isAjax) {
                    return $this->redirect(['update', 'id'=>$model->id]);
                }
				return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'publisher'=>$model->publisher_id]);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
			}
		}

		$this->view->title = Yii::t('app', 'Update Obligation: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single KckrPublisherObligation model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$this->subMenuParam = $model->publisher_id;

		$this->view->title = Yii::t('app', 'Detail Obligation: {media-title}', ['media-title' => $model->media_title]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing KckrPublisherObligation model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

        if ($model->save(false, ['publish', 'modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher obligation success deleted.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'publisher'=>$model->publisher_id]);
		}
	}

	/**
	 * actionPublish an existing KckrPublisherObligation model.
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
			Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher obligation success updated.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage', 'publisher'=>$model->publisher_id]);
		}
	}

	/**
	 * Import a new KckrPublisherObligation model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionImport()
	{
        if (($id = Yii::$app->request->get('id')) == null) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

		$model = new KckrPublisherObligation(['publisher_id'=>$id]);
		$this->subMenuParam = $model->publisher_id;

		$setting = $model->setting;
		$category = KckrCategory::find()
			->select(['id', 'category_code'])
			->andWhere(['publish' => 1])
			->all();
		$category = ArrayHelper::map($category, 'id', 'category_code');
		$category = array_flip($category);

        if (Yii::$app->request->isPost) {
			$kckrPath = Kckrs::getUploadPath();
			$obligationImportPath = join('/', [$kckrPath, 'obligation_import']);
			$verwijderenPath = join('/', [$kckrPath, 'verwijderen']);
			$this->createUploadDirectory($kckrPath, 'obligation_import');

			$errors = [];
			$importFilename = UploadedFile::getInstanceByName('importFilename');
            if ($importFilename instanceof UploadedFile && !$importFilename->getHasError()) {
				$importFileType = $this->formatFileType($setting->import_file_type);
                if (in_array(strtolower($importFilename->getExtension()), $importFileType)) {
					$fileName = join('-', [time(), UuidHelper::uuid()]);
					$fileNameExtension = $fileName.'.'.strtolower($importFilename->getExtension());
                    if ($importFilename->saveAs(join('/', [$obligationImportPath, $fileNameExtension]))) {
						$spreadsheet = IOFactory::load(join('/', [$obligationImportPath, $fileNameExtension]));
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

                                if ($isbn != '') {
									$media = KckrMedia::find()
										->select(['id'])
										->andWhere(['publish' => 1])
										->andWhere(['isbn' => $isbn])
										->one();
                                    if ($media) {
                                        continue;
                                    }
								}

								$cat_id = 1;
                                if ($category_code) {
                                    if (ArrayHelper::keyExists($category_code, $category)) {
                                        $cat_id = trim($category[$category_code]);
                                    }
								}

								$model=new KckrPublisherObligation;
								$model->publisher_id = $id;
								$model->cat_id = $cat_id;
								$model->isbn = $isbn;
								$model->media_title = $media_title;
								$model->media_desc = $media_desc;
								$model->media_publish_year = $media_publish_year;
								$model->media_author = $media_author;
                                if (!$model->save()) {
                                    $errors['row#'.$key+1] = $model->getErrors();
                                }
							}
							Yii::$app->session->setFlash('success', Yii::t('app', 'Kckr publisher obligation success imported.'));
						} catch (\Exception $e) {
							throw $e;
						} catch (\Throwable $e) {
							throw $e;
						}
					}
	
				} else {
					Yii::$app->session->setFlash('error', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', [
						'name'=>$importFilename->name,
						'extensions'=>$setting->import_file_type,
					]));
				}
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'Import file cannot be blank.'));
            }

            if (!empty($errors)) {
				$obligationImportErrorFile = join('/', [$obligationImportPath, $fileName.'.json']);
                if (!file_exists($obligationImportErrorFile)) {
					file_put_contents($obligationImportErrorFile, Json::encode($errors));
                }
			}

            if (!Yii::$app->request->isAjax) {
				return $this->redirect(['import', 'id'=>$id]);
            }
			return $this->redirect(Yii::$app->request->referrer ?: ['import', 'id'=>$id]);
		}

		$this->view->title = Yii::t('app', 'Import Obligation');
        if (isset($model->publisher)) {
			$this->view->title = Yii::t('app', 'Import Obligation: Publisher {publisher-name}', ['publisher-name'=>$model->publisher->publisher_name]);
        }
		$this->view->description = '';
        if (Yii::$app->request->isAjax) {
			$this->view->description = Yii::t('app', 'Are you sure you want to import obligation data?');
        }
		$this->view->keywords = '';
		return $this->oRender('admin_import', [
			'model' => $model,
		]);
	}

	/**
	 * Finds the KckrPublisherObligation model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return KckrPublisherObligation the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = KckrPublisherObligation::findOne($id)) !== null) {
            return $model;
        }

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}