<?php
/**
 * Kckrs
 *
 * Kckrs represents the model behind the search form about `ommu\kckr\models\Kckrs`.
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:56 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\kckr\models\Kckrs as KckrsModel;

class Kckrs extends KckrsModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'publish', 'article_id', 'pic_id', 'publisher_id', 'thanks_user_id', 'creation_id', 'modified_id', 'document', 'article'], 'integer'],
			[['letter_number', 'send_type', 'send_date', 'receipt_date', 'thanks_date', 'thanks_document', 'photos', 'creation_date', 'modified_date', 'updated_date', 'picName', 'publisherName', 'thanksUserDisplayname', 'creationDisplayname', 'modifiedDisplayname'], 'safe'],
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
        if (!($column && is_array($column))) {
            $query = KckrsModel::find()->alias('t');
        } else {
            $query = KckrsModel::find()->alias('t')->select($column);
        }
		$query->joinWith([
			'pic pic', 
			'publisher publisher', 
			'thanksUser thanksUser', 
			'creation creation', 
			'modified modified'
		]);

		$query->groupBy(['id']);

        // add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
        // disable pagination agar data pada api tampil semua
        if (isset($params['pagination']) && $params['pagination'] == 0) {
            $dataParams['pagination'] = false;
        }
		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['pic_id'] = [
			'asc' => ['pic.pic_name' => SORT_ASC],
			'desc' => ['pic.pic_name' => SORT_DESC],
		];
		$attributes['picName'] = [
			'asc' => ['pic.pic_name' => SORT_ASC],
			'desc' => ['pic.pic_name' => SORT_DESC],
		];
		$attributes['publisherName'] = [
			'asc' => ['publisher.publisher_name' => SORT_ASC],
			'desc' => ['publisher.publisher_name' => SORT_DESC],
		];
		$attributes['thanksUserDisplayname'] = [
			'asc' => ['thanksUser.displayname' => SORT_ASC],
			'desc' => ['thanksUser.displayname' => SORT_DESC],
		];
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['id' => SORT_DESC],
		]);

        if (Yii::$app->request->get('id')) {
            unset($params['id']);
        }
		$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		// grid filtering conditions
		$query->andFilterWhere([
			't.id' => $this->id,
			't.article_id' => $this->article_id,
			't.pic_id' => isset($params['pic']) ? $params['pic'] : $this->pic_id,
			't.publisher_id' => isset($params['publisher']) ? $params['publisher'] : $this->publisher_id,
			't.send_type' => $this->send_type,
			'cast(t.send_date as date)' => $this->send_date,
			'cast(t.receipt_date as date)' => $this->receipt_date,
			'cast(t.thanks_date as date)' => $this->thanks_date,
			't.thanks_user_id' => isset($params['thanksUser']) ? $params['thanksUser'] : $this->thanks_user_id,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'cast(t.updated_date as date)' => $this->updated_date,
		]);

        if (isset($params['trash'])) {
            $query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
        } else {
            if (!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == '')) {
                $query->andFilterWhere(['IN', 't.publish', [0,1]]);
            } else {
                $query->andFilterWhere(['t.publish' => $this->publish]);
            }
        }

        if (isset($params['document']) && $params['document'] != '') {
            if ($params['document'] == 1) {
                $query->andFilterWhere(['NOT IN', 't.thanks_date', ['0000-00-00', '1970-01-01', '0002-12-02', '-0001-11-30']]);
            } else if ($params['document'] == 0) {
                $query->andFilterWhere(['IN', 't.thanks_date', ['0000-00-00', '1970-01-01', '0002-12-02', '-0001-11-30']]);
            }
        }

        if (isset($params['article']) && $params['article'] != '') {
            if ($params['article'] == 1) {
				$query->andFilterWhere(['is not', 't.article_id', null])
					->andFilterWhere(['<>', 't.article_id', '0']);
			} else if ($params['article'] == 0) {
				$query->andFilterWhere(['is', 't.article_id', null])
					->andFilterWhere(['t.article_id' => '0']);
			}
		}

		$query->andFilterWhere(['like', 't.letter_number', $this->letter_number])
			->andFilterWhere(['like', 't.thanks_document', $this->thanks_document])
			->andFilterWhere(['like', 't.photos', $this->photos])
			->andFilterWhere(['like', 'pic.pic_name', $this->picName])
			->andFilterWhere(['like', 'publisher.publisher_name', $this->publisherName])
			->andFilterWhere(['like', 'thanksUser.displayname', $this->thanksUserDisplayname])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname]);

		return $dataProvider;
	}
}
