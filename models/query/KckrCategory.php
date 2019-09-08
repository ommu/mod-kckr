<?php
/**
 * KckrCategory
 *
 * This is the ActiveQuery class for [[\ommu\kckr\models\KckrCategory]].
 * @see \ommu\kckr\models\KckrCategory
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:48 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\models\query;

class KckrCategory extends \yii\db\ActiveQuery
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
	 * @return \ommu\kckr\models\KckrCategory[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\KckrCategory|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
