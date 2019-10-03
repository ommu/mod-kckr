<?php
/**
 * KckrMedia
 *
 * KckrMedia represents the model behind the search form about `ommu\kckr\models\KckrMedia`.
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:55 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\kckr\models\KckrMedia as KckrMediaModel;

class KckrMedia extends KckrMediaModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'publish', 'kckr_id', 'cat_id', 'media_item', 'creation_id', 'modified_id', 'publisherId'], 'integer'],
			[['media_title', 'media_desc', 'isbn', 'media_publish_year', 'media_author', 'creation_date', 'modified_date', 'updated_date', 'picId', 'categoryName', 'creationDisplayname', 'modifiedDisplayname', 'publisherName'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
		if(!($column && is_array($column)))
			$query = KckrMediaModel::find()->alias('t');
		else
			$query = KckrMediaModel::find()->alias('t')->select($column);
		$query->joinWith([
			'kckr kckr', 
			'category.title category', 
			'creation creation', 
			'modified modified',
			'kckr.pic pic', 
			'kckr.publisher publisher', 
		])
		->groupBy(['id']);

		// add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
		// disable pagination agar data pada api tampil semua
		if(isset($params['pagination']) && $params['pagination'] == 0)
			$dataParams['pagination'] = false;
		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['picId'] = [
			'asc' => ['pic.pic_name' => SORT_ASC],
			'desc' => ['pic.pic_name' => SORT_DESC],
		];
		$attributes['cat_id'] = [
			'asc' => ['category.message' => SORT_ASC],
			'desc' => ['category.message' => SORT_DESC],
		];
		$attributes['categoryName'] = [
			'asc' => ['category.message' => SORT_ASC],
			'desc' => ['category.message' => SORT_DESC],
		];
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$attributes['publisherName'] = [
			'asc' => ['publisher.publisher_name' => SORT_ASC],
			'desc' => ['publisher.publisher_name' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['id' => SORT_DESC],
		]);

		if(Yii::$app->request->get('id'))
			unset($params['id']);
		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.id' => $this->id,
			't.kckr_id' => isset($params['kckr']) ? $params['kckr'] : $this->kckr_id,
			't.cat_id' => isset($params['category']) ? $params['category'] : $this->cat_id,
			'cast(t.media_publish_year as date)' => $this->media_publish_year,
			't.media_item' => $this->media_item,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'cast(t.updated_date as date)' => $this->updated_date,
			'kckr.pic_id' => $this->picId,
			'kckr.publisher_id' => $this->publisherId,
		]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

		$query->andFilterWhere(['like', 't.media_title', $this->media_title])
			->andFilterWhere(['like', 't.media_desc', $this->media_desc])
			->andFilterWhere(['like', 't.isbn', $this->isbn])
			->andFilterWhere(['like', 't.media_author', $this->media_author])
			->andFilterWhere(['like', 'category.message', $this->categoryName])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname])
			->andFilterWhere(['like', 'publisher.publisher_name', $this->publisherName]);

		return $dataProvider;
	}
}
