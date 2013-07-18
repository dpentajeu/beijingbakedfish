<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property string $id
 * @property string $walletId
 * @property string $tranType
 * @property double $amount
 * @property double $balance
 * @property string $description
 * @property string $promoCode
 * @property string $tranDate
 *
 * The followings are the available model relations:
 * @property Wallet $wallet
 */
class Transaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transaction the static model class
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('walletId, tranType, amount, tranDate', 'required'),
			array('amount, balance', 'numerical'),
			array('walletId', 'length', 'max'=>10),
			array('tranType, promoCode', 'length', 'max'=>6),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, walletId, tranType, amount, balance, description, promoCode, tranDate', 'safe', 'on'=>'search'),
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
			'wallet' => array(self::BELONGS_TO, 'Wallet', 'walletId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'walletId' => 'Wallet',
			'tranType' => 'Tran Type',
			'amount' => 'Amount',
			'balance' => 'Balance',
			'description' => 'Description',
			'promoCode' => 'Promo Code',
			'tranDate' => 'Tran Date',
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
		$criteria->compare('walletId',$this->walletId,true);
		$criteria->compare('tranType',$this->tranType,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('promoCode',$this->promoCode,true);
		$criteria->compare('tranDate',$this->tranDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}