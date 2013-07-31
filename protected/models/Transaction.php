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
		list($amount, $type, $description, $date) = array(0.0, 'CREDIT', '', date('Y-m-d H:i:s'));
		foreach ($attributes as $key => $value) ${$key} = $value;
		$type = strtoupper($type);

		if (is_null($user))
			throw new Exception('User cannot be null value.', 1);

		$t = new Transaction;
		$t->checkOperation($type);
		$t->setWalletType(Transaction::TRAN_FP);
		$wallet = $user->wallet;
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
        
    public function checkOperation($type)
	{
		if (!preg_match('/^(DEBIT|CREDIT)$/', $type))
			throw new Exception("No such transaction type: {$type}");
	}
        
    public function setWalletType($w)
	{
		$this->walletType = $w;
	}
        
    public static function getTransaction()
    {     
        if(Yii::app()->user->id ==1)
        {
            $transaction = Transaction::model()->findAll(array('order'=>'tranDate DESC'));
            
            foreach($transaction as $t)
            {                
                $wallet = Wallet::model()->findByAttributes(array('id'=>$t->walletId)); 
                $user = User::model()->findByAttributes(array('id'=>$wallet->userId));
                
                $t->name = $user->name;
            }
        }
        else 
        {            
            $wallet = Wallet::model()->findByAttributes(array('userId'=>Yii::app()->user->id));        
            $transaction = Transaction::model()->findAllByAttributes(array('walletId'=>$wallet->id),array('order'=>'tranDate DESC'));
        }        
        return $transaction;            
    }
}