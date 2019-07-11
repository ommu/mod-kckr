<?php
/**
 * PublisherSuggestAction
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 9 July 2019, 15:58 WIB
 * @link https://bitbucket.org/ommu/kckr
 */

namespace ommu\kckr\actions;

use Yii;
use ommu\kckr\models\KckrPublisher;

class PublisherSuggestAction extends \yii\base\Action
{
	/**
	 * {@inheritdoc}
	 */
	protected function beforeRun()
	{
		if (parent::beforeRun()) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			Yii::$app->response->charset = 'UTF-8';
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{
		$term = Yii::$app->request->get('term');

		if($term == null) return [];

		$model = KckrPublisher::find()
			->suggest()
			->andWhere(['like', 'publisher_name', $term])
			->limit(15)
			->all();

		$result = [];
		foreach($model as $val) {
			$result[] = [
				'id' => $val->id, 
				'label' => $val->publisher_name,
			];
		}
		return $result;
	}
}