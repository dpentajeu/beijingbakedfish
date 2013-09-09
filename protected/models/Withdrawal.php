<?php

/**
 * This is the model class for table "withdrawal".
 *
 * The followings are the available columns in table 'withdrawal':
 * @property string $id
 * @property string $walletId
 * @property double $amount
 * @property double $balance
 * @property string $tranDate
 * @property integer $status
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property Wallet $wallet
 */
class Withdrawal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Withdrawal the static model class
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
		return 'withdrawal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('amount, balance', 'numerical'),
			array('amount', 'numerical', 'min'=>100),
			array('walletId', 'length', 'max'=>10),
			array('remark', 'length', 'max'=>500),
			array('tranDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, walletId, amount, balance, tranDate, status, remark', 'safe', 'on'=>'search'),
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
			'amount' => 'Amount',
			'balance' => 'Balance',
			'tranDate' => 'Tran Date',
			'status' => 'Status',
			'remark'=>'Remark',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('tranDate',$this->tranDate,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('remark',$this->remark);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	*	Purchase create
	**/
	public function withdrawCredit($user)
	{
		if($user->wallet->cashPoint < ($this->amount + 5))
			throw new Exception("Insufficient cash point for withdrawal request.", 1);			

		$model = new Withdrawal;
		$model->attributes = array(
			'walletId' => $user->wallet->id,
			'amount' => $this->amount,
			'remark'=>$this->remark,
			'balance' => $user->wallet->cashPoint,
			'tranDate' => date('Y-m-d H:i:s'),
			);

		if(!$model->save()){
			Yii::log("Fail to create withdraw for user {$user->name} ({$user->id}). \n" . var_export($model->getErrors(), true), "error", "application.models.Purchase");
			throw new Exception(var_export($model->getErrors(), true), 100);
		}			
	}

	/**
	*	Get all purchase
	**/
	public function getAllWithdrawal()
	{
		if(Yii::app()->user->id ==1)
		{
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$withdraw = Withdrawal::model()->findAll($criteria);
		}
		else 
		{
			$model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$criteria->compare('walletId',$model->wallet->id);
			$withdraw = Withdrawal::model()->findAll($criteria);
		}
		return $withdraw;
	}

	/**
	*	Approve purchase
	**/
	public function handleWithdraw($id, $status)
	{
		if($status == "true")
		{
			$model = Withdrawal::model()->findByAttributes(array('id'=>$id));
			Transaction::create($model->wallet->user, array(
			'amount'=>($model->amount + 5),
			'point'=>Transaction::TRAN_CP,
			'type'=>'CREDIT',
			'description'=>'Withdraw Cash Point RM'.$model->amount.'.',
			));
			$model->status = 1;
			if(!$model->save())
				throw new Exception('Fail to confirm this withdrawal.', 101);
		}
		else
		{
			$model = Withdrawal::model()->findByAttributes(array('id'=>$id));
			$model->status = 2;
			if(!$model->save())
				throw new Exception('Fail to cancel this withdrawal.', 102);
		}
	}
}