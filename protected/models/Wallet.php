<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property string $id
 * @property double $foodPoint
 * @property string $userId
 * @property string $modifiedDate
 *
 * The followings are the available model relations:
 * @property Transaction[] $transactions
 * @property User $user
 */
class Wallet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wallet the static model class
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
		return 'wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('foodPoint, userId', 'required'),
			array('foodPoint', 'numerical'),
			array('userId', 'length', 'max'=>10),
                        array('modifiedDate','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, foodPoint, userId, modifiedDate', 'safe', 'on'=>'search'),
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
			'transactions' => array(self::HAS_MANY, 'Transaction', 'walletId'),
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
			'foodPoint' => 'Food Point',
			'userId' => 'User',
			'modifiedDate' => 'Modified Date',
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
		$criteria->compare('foodPoint',$this->foodPoint);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('modifiedDate',$this->modifiedDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}