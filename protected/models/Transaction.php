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
	public $name;

	const TRAN_FP = 1;
	const TRAN_CP = 2;

	private $walletType = Transaction::TRAN_FP;
	private static $operation = array('DEBIT'=>1, 'CREDIT'=>-1);

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
			array('walletId, tranType, amount', 'required'),
			array('amount, balance', 'numerical'),
			array('walletId', 'length', 'max'=>10),
			array('tranType, promoCode', 'length', 'max'=>6),
			array('tranType', 'match', 'pattern'=>'/^(DEBIT|CREDIT)$/'),
			array('description, tranDate', 'safe'),
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
		
	public static function transferFP(User $user, array $attributes = array())
	{
		list($amount, $type, $point, $description, $date) = array(0.0, 'CREDIT', 'FP' ,'', date('Y-m-d H:i:s'));
		foreach ($attributes as $key => $value) ${$key} = $value;
		$type = strtoupper($type);

		if (is_null($user))
			throw new Exception('User cannot be null value.', 1);

		$t = new Transaction;
		$t->checkOperation($type);
		$t->setWalletType(Transaction::TRAN_FP);
		$wallet = $user->wallet;
		if($point == 'CP')
			$wallet->cashPoint += $amount * self::$operation[$type];
		else
			$wallet->foodPoint += $amount * self::$operation[$type];
		$wallet->modifiedDate = date('Y-m-d H:i:s');
				
		if($wallet->foodPoint < 0) { throw new Exception("Not enough Food Point!");};

		$t->attributes = array(
			'walletId'=>$wallet->id,
			'tranType'=>$type,
			'amount'=>$amount,
			'balance'=>$wallet->foodPoint,
			'description'=>$description,
			'tranDate'=>$date,
			);
 
		if (!$t->save())
			foreach ($t->getErrors() as $e) throw new Exception($e[0]);

		if (!$wallet->save())
			throw new Exception('Fail to update wallet balance.', 7);

		return $t;
	}

	/**
	 * This static method is able to create a new transaction record and update the respective wallet automatically.
	 * @param User user a valid user object.
	 * @param array attributes this field is optional.
	 * @throws Exception Invalid user object, invalid operation, invalid wallet type or enought points.
	 * @return Transaction the newly created transaction object.
	 */
	public static function create(User $user, array $attributes = array())
	{
		$default = array(
			'amount' => 0.0,
			'type' => 'CREDIT',
			'point' => self::TRAN_FP,
			'description' => '',
			'date' => date('Y-m-d H:i:s'),
			'force' => false,
			);
		$default = array_merge($default, $attributes);
		$default['type'] = strtoupper($default['type']);
		$wallet_op = array(
			self::TRAN_FP => "foodPoint",
			self::TRAN_CP => "cashPoint",
			);

		if (is_null($user))
			throw new Exception('User cannot be null value.', 101);

		$model = new Transaction;
		$model->checkOperation($default['type']);
		$model->setWalletType($default['point']);
		// Following line will change the wallet balance based on which `point` it is.
		$user->wallet->{$wallet_op[$default['point']]} += $default['amount'] * self::$operation[$default['type']];
		$user->wallet->modifiedDate = $default['date'];

		// Check if there is enough credit to deduct from cashPoint or foodPoint. A `force` option can be set to true to bypass this condition.
		if (!$default['force'] && $user->wallet->{$wallet_op[$default['point']]} < 0)
			throw new Exception("Not enough points!");

		$model->attributes = array(
			'walletId' => $user->wallet->id,
			'tranType' => $default['type'],
			'amount' => $default['amount'],
			'balance' => $user->wallet->{$wallet_op[$default['point']]},
			'description' => $default['description'],
			'tranDate' => $default['date'],
			);

		if (!$model->save()) {
			Yii::log("Fail to create transaction for user {$user->name} ({$user->id}). \n" . var_export($model->getErrors(), true), "error", "application.models.Transaction");
			throw new Exception(var_export($model->getErrors(), true), 102);
		}

		if (!$user->wallet->update()) {
			Yii::log("Fail to update user {$user->name} ({$user->id}) for transaction id {$model->id}.", "error", "application.models.Transaction");
			throw new Exception('Fail to update wallet balance.', 103);
		}

		return $model;
	}
		
	public function checkOperation($type)
	{
		if (!preg_match('/^(DEBIT|CREDIT)$/', $type))
			throw new Exception("No such transaction type: {$type}");
	}

	public function setWalletType($w)
	{
		if (!in_array($w, array(self::TRAN_FP, self::TRAN_CP)))
			throw new Exception("Invalid type of wallet.", 111);

		$this->walletType = $w;
	}

	public static function getTransaction($transDesc, $userId)
	{
		if(Yii::app()->user->id ==1)
		{
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$criteria->addSearchCondition('description', $transDesc);
                        
                        if(!is_null($userId))
                        {
                            $user = User::getUser($userId);
                            $criteria->compare('walletId',$user->wallet->id);
                        }
                        
			$transaction = Transaction::model()->findAll($criteria);
			
			foreach($transaction as $t)
			{
				$wallet = Wallet::model()->findByAttributes(array('id'=>$t->walletId));
				$user = User::model()->findByAttributes(array('id'=>$wallet->userId));
				$t->name = $user->name;
			}
		}
		else 
		{
			$model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
			$criteria = new CDbCriteria;
			$criteria->order = "tranDate desc";
			$criteria->compare('walletId',$model->wallet->id);
			$criteria->addSearchCondition('description', $transDesc);
			$transaction = Transaction::model()->findAll($criteria);
		}
		return $transaction;
	}
}