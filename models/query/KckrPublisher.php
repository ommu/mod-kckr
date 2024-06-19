<?php
/**
 * KckrPublisher
 *
 * This is the ActiveQuery class for [[\ommu\kckr\models\KckrPublisher]].
 * @see \ommu\kckr\models\KckrPublisher
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 4 July 2019, 21:50 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\models\query;

class KckrPublisher extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 */
	public function published()
	{
		return $this->andWhere(['t.publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish()
	{
		return $this->andWhere(['t.publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted()
	{
		return $this->andWhere(['t.publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function suggest()
	{
		return $this->select(['id', 'publisher_name'])
			->published();
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\KckrPublisher[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\KckrPublisher|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
