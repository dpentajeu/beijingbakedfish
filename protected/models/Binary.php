<?php

/**
 * This is the model class for table "binarytree".
 *
 * The followings are the available columns in table 'binarytree':
 * @property string $id
 * @property string $userId
 * @property string $level
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Binary extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Binary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'binarytree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, level', 'required'),
			array('userId, level', 'length', 'max'=>10),
			array('created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, level, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'level' => 'Level',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Get the binary tree with the given starting root id.
	 * @param integer root_id the first id to act as the root.
	 * @param integer level total number of levels to search for. The default is set to 10.
	 * @return array a 2D array where the 1st dimension represents the level of the tree. The second dimension holds the nodes in that level.
	 */
	public function getTree($root_id, $level = 10)
	{
		$root = $this->findByAttributes(array('userId' => $root_id));
		if (empty($root))
			throw new Exception("Node not found.", 101);

		$result = array();
		$criteria = new CDbCriteria;
		// the following condition is extremely important!!! Do not simply change.
		$criteria->condition = '(id = :root AND level = :level) OR (id > :root AND level BETWEEN (:level + 1) AND :maxlevel AND floor(id / pow(2, level - :level)) = :root)';
		$criteria->params = array(':root' => $root->id, ':level' => $root->level, ':maxlevel' => $root->level + $level);
		$criteria->order = 'id';

		$model = $this->findAll($criteria);
		if (empty($model))
			return array();

		// Re-structure the result into 2D array.
		// The startlevel is to make sure the array is starting from 0, 1, 2... and so on.
		$startlevel = 0;
		foreach ($model as $index => $binary) {
			// Use the first node to initialize the startlevel.
			if ($index == 0)
				$startlevel = $binary->level - 1;
			$result[$binary->level - $startlevel][] = $binary;
		}

		return $result;
	}

	/**
	 * Auto placing nodes into the global binary tree. Number of nodes to place depends on the package value.
	 * @param User user valid user object.
	 * @return array the list of nodes placed in the global binary tree.
	 */
	public static function create(User $user)
	{
		// Determine the number of nodes to create into the global binary tree.
		$num_of_nodes = 1;
		if (!empty($user->package))
			$num_of_nodes = $user->package->value / 500;

		$models = array();
		foreach (range(1, $num_of_nodes) as $i) {
			$model = new Binary;
			$model->attributes = array('userId' => $user->id, 'level' => 0);
			// The level cannot be determined until the id is known. Hence, default is set to 0 which is invalid.
			if (!$model->save())
				throw new Exception("Fail to create binary node.");

			// After successfully insert the record into the table, use the auto incremental id to determine the correct level the node is in with the following formula.
			$model->level = floor(number_format(log($model->id,2), 8)) + 1;

			if (!$model->update())
				throw new Exception("Fail to update binary node level.");

			$models[] = $model;
		}

		return $models;
	}
}