<?php
/**
 * DefaultController
 * @var $this ommu\archive\controllers\XXXXController
 *
 * Default controller for the `kckr` module
 * Reference start
 * TOC :
 *	Index
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 28 February 2019, 13:26 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\controllers;

use app\components\Controller;
use mdm\admin\components\AccessControl;

class DefaultController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return ['index'];
	}

	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		$this->view->title = 'kckrs';
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('index');
	}
}
