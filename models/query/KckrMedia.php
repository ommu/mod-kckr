<?php
/**
 * KckrMedia
 *
 * This is the ActiveQuery class for [[\ommu\kckr\models\KckrMedia]].
 * @see \ommu\kckr\models\KckrMedia
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 4 July 2019, 21:48 WIB
 * @link https://bitbucket.org/ommu/kckr
 *
 */

namespace ommu\kckr\models\query;

class KckrMedia extends \yii\db\ActiveQuery
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
		return $this->andWhere(['publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish() 
	{
		return $this->andWhere(['publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted() 
	{
		return $this->andWhere(['publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\KckrMedia[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\kckr\models\KckrMedia|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
