<?php

/**
 * This is the model class for table "bill".
 *
 * The followings are the available columns in table 'bill':
 * @property string $id
 * @property string $walletId
 * @property integar $provider
 * @property double $amount
 * @property double $balance
 * @property datetime $tranDate
 * @property integer $status
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property Wallet $wallet
 */
class Bill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bill the static model class
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
		return 'bill';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider, amount', 'required'),
			array('status, provider', 'numerical', 'integerOnly'=>true),
			array('amount, balance, provider', 'numerical'),
			array('walletId', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>500),
			array('tranDate, provider', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, walletId, provider, amount, balance, tranDate, status, remark', 'safe', 'on'=>'search'),
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
			'service' => array(self::HAS_MANY, 'Provider', 'id'),
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
			'provider' => 'Provider',
			'amount' => 'Amount',
			'balance' => 'Balance',
			'tranDate' => 'Tran Date',
			'status' => 'Status',
			'remark' => 'Remark',
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
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('tranDate',$this->tranDate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	*	Bill create
	**/
	public function billPayment(Bill $bill)
	{
		$user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));

		if($user->wallet->cashPoint < ($this->amount + 1))
			throw new Exception("Insufficient cash point for bill payment request.", 1);
		
		$this->attributes = array(
			'walletId' => $user->wallet->id,
			'amount' => $this->amount,
			'provider' => $this->provider,
			'balance' => $user->wallet->cashPoint,
			'tranDate' => date('Y-m-d H:i:s'),
			'remark' => $this->remark,
			);

		if(!$this->save()){
			Yii::log("Fail to create bill payment for user {$user->name} ({$user->id}). \n" . var_export($this->getErrors(), true), "error", "application.models.Purchase");
			throw new Exception(var_export($this->getErrors(), true), 100);
		}
		return $this;
	}

	/**
	*	Get all bill payment
	**/
	public function getAllBills()
	{
		if(Yii::app()->user->id ==1)
		{
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$bill = Bill::model()->findAll($criteria);
		}
		else 
		{
			$model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$criteria->compare('walletId',$model->wallet->id);
			$bill = Bill::model()->findAll($criteria);
		}
		return $bill;
	}

	/**
	*	Approve bill payment
	**/
	public function handleBills($id, $status)
	{
		if($status == "true")
		{
			$model = Bill::model()->findByAttributes(array('id'=>$id));
			$provider = Provider::model()->findByAttributes(array('id'=>$model->provider));
			Transaction::create($model->wallet->user, array(
				'amount'=>($model->amount + 1),
				'point'=>Transaction::TRAN_CP,
				'type'=>'CREDIT',
				'description'=>"Bill payment for {$provider->name}.",
				));
			$model->status = 1;
			if(!$model->save())
				throw new Exception('Fail to confirm this bill payment.', 101);
		}
		else
		{
			$model = Bill::model()->findByAttributes(array('id'=>$id));
			$model->status = 2;
			if(!$model->save())
				throw new Exception('Fail to cancel this bill payment.', 102);
		}
	}

	public function getProviders()
	{
		$providers = Provider::model()->findAll();
		$result = array();

		foreach ($providers as $provider) {
			$result[$provider->id] = $provider->name;
		}

		return $result;
	}

	public static function getProvider($id)
	{
		$provider = Provider::model()->findByAttributes(array('id'=>$id));
		return $provider->name;
	}
}