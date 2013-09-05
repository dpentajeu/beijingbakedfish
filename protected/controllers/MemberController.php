<?php

class MemberController extends Controller
{
	public $layout = "main3";
	/**
	 * Declares class-based actions.
	 */
	public $name ='';

	public function filters()
	{
		return array(
			'accessControl',
			);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('login', 'captcha','logout','resetpassword', 'manualsponsorbonus', 'revertsponsorbonus'),
				'users'=>array('*'),
				),
			array('allow',
				'actions'=>array(
					'index',
					'changepassword',
					'setpin',
					'network',
					'transactionhistory',
					'announcement',
					'transferCP',
					'transferCPtoFP',
					'editmember',
					'purchase',
					'withdraw',
					'refermember',
					'binarynetwork',
					'lang',
					),
				'users'=>array('@'),
				),
			array('allow',
				'actions'=>array('approve', 'disapprove', 'transaction', 'sms', 'editannouncement', 'purchasehistory','withdrawhistory', 'manualtransaction', 'refermember', 'binarynetwork', 'transferCP'),
				'roles'=>array('admin'),
				),
			array('allow',
				'actions'=>array('transaction'),
				'roles'=>array('staff'),
				),
			array('deny'),
		);
	}

	protected final function beforeAction($action)
	{
		if(!is_null(Yii::app()->user->id))
		{
			$model = User::getUser(Yii::app()->user->id);
			$this->name = $model->name;  
		}

		return true;
	}
        
        public function init()
	{
		parent::init();
		if (isset(Yii::app()->session['_lang']))
			Yii::app()->language = Yii::app()->session['_lang'];
	}

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function actionLang($_lang)
	{
		$app = Yii::app();
		$app->session['_lang'] = $_lang;
		$this->redirect(array('member/index'));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$CMessage = '';

		if(Yii::app()->user->id == 1)
			$model = User::getAllUser();
		else {
			$model = User::getUser(Yii::app()->user->id);
			if (is_null($model->pin))
				$CMessage = 'Please remember set up your PIN for Redemption Point redemption.';
		}

		$total = count($model);

		$this->render('index',array('model'=>$model,'CMessage'=> $CMessage,'total'=>$total));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = 'login';
		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('member/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('login');
	}

	public function actionEditmember($id = null)
	{
		if (empty($id))
			$id = Yii::app()->user->id;
		$model = User::model()->findByAttributes(array('id'=>$id));
		$packages = Package::getAllPackages();
		$CMessage = '';
                $notice = '';

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];

			try {
				if (!$model->validate())
					throw new Exception("Please fill in all fields in the forms correctly.");
				$model->editUser($id);
				$CMessage = 'Member has been updated succesfully.';

				$this->redirect(array('member/index'));
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('editmember', array('model'=>$model, 'packages'=>$packages, 'CMessage'=>$CMessage,  'notice'=> $notice));
	}

	public function actionApprove($id = null)
	{
		$model = User::getUser($id);
		$CMessage = '';

		try {
			$model->approveUser($id);
			network::setSponsorBonus($id);
			$CMessage = 'Member is approved.';
		} catch (Exception $e) {
			$CMessage = $e->getMessage();
		}

		$this->redirect(array('member/index'));
	}

	public function actionDisapprove($id = null)
	{
		$model = User::getUser($id);
		$CMessage = '';

		try {
			$model->disapproveUser($id);
			$CMessage = 'Member is disapproved.';
		} catch (Exception $e) {
			$CMessage = $e->getMessage();
		}

		$this->redirect(array('member/index'));
	}

	public function actionChangepassword()
	{
		$model = new User;
		$CMessage = '';
		$notice = '';

		if(isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			try {
				$model->changePassword();
				$notice = 'Password changed successfully!';
				$model = new User;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('changepassword',array('model'=>$model, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionSetpin()
	{
		$model = new User;
		$CMessage = '';
		$notice = '';

		try {
			if(isset($_POST['setTac'])) {
				$model->setTac();
				$notice = 'TAC is requested, please wait.';
			} else if(isset($_POST['User'])) {
				$model->attributes = $_POST['User'];
				$model->setPin();
				$notice = 'New PIN is set successfully!';
				$model = new User;
			}
		} catch (Exception $e) {
			$CMessage = $e->getMessage();
		}

		$this->render('setpin',array('model'=>$model, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionResetpassword()
	{
		$this->layout = 'login';

		$model = new User;
		$CMessage = '';
		$notice = '';

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			try {
				$model->resetPassword();
				$notice = 'New password is send!';
				$model = new User;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('resetpassword',array('model'=>$model, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionSms()
	{
		$model = new User;
		$userDropDownList = $model->getUserDropDownList();
		$CMessage = '';
		$notice = '';
		$credit = $model->checkSMSCredit();

		if (isset($_POST['message']) && isset($_POST['member']))
		{
			$msg = $_POST['message'];

			try {
				if (empty($msg))
					throw new Exception('Message cant be empty.');

				if ($_POST['member'] == 1) {
					if (empty($_POST['id']))
						throw new Exception('Please select a customer.');

					User::smsTo($_POST['id'], $msg);
					$notice = 'Message is send!';
				} else if ($_POST['member'] == 2) {
					User::smsToAll($msg);
					$notice = 'All messages is send!';
				}
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('sms', array('CMessage'=>$CMessage, 'notice'=>$notice, 'userDropDownList'=>$userDropDownList, 'credit'=>$credit));
	}

	public function actionTransaction()
	{
		$model = new User;
		$userDropDownList = User::getUserDropDownList();
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amountCP']) && isset($_POST['amountRP']) && isset($_POST['User']))
		{
			$amountCP = $_POST['amountCP'];
			$amountRP = $_POST['amountRP'];
			$model->attributes = $_POST['User'];

			try {
				if(empty($model->id))
					throw new Exception('Please select a customer.');

				if(is_null($amountRP) || $amountRP == 0)
					throw new Exception('Please enter total RP redepmtion amount.');

				if(is_null($amountCP) || $amountCP < 0)
					throw new Exception('Please enter total CP redemption amount.');

				$model->deductFP($amountRP, 'CREDIT');
				$model->deductCP($amountCP, 'CREDIT');
				$user = User::getUser($model->id);
				$wallet = $user->wallet;
				$notice = 'Transaction is done successfully! Name: '.$user->name.' Redepmtion Point: '.$wallet->foodPoint.', Cash Point is '.$wallet->cashPoint;
				$msg = 'Your beijingbakedfish remaining Cash Point is '.$wallet->cashPoint.' & Redepmtion Point is '.$wallet->foodPoint.', thanks and come again.';
				User::send_sms($user->contact,$msg);

				$model = new User;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('transaction',array('model'=>$model, 'userDropDownList'=>$userDropDownList, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionManualtransaction()
	{
		$model = new User;
		$userDropDownList = User::getUserDropDownList();
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amountCP']) && isset($_POST['amountRP']) && isset($_POST['User']) && isset($_POST['date']))
		{
			$amountCP = $_POST['amountCP'];
			$amountRP = $_POST['amountRP'];
			$date = $_POST['date'];
			$model->attributes = $_POST['User'];

			try {
				if(empty($model->id))
					throw new Exception('Please select a customer.');

				if(is_null($amountRP) || $amountRP == 0)
					throw new Exception('Please enter total RP redepmtion amount.');

				if(is_null($amountCP) || $amountCP < 0)
					throw new Exception('Please enter total CP redemption amount.');

				$model->manualCreateBill($model->id, $amountCP, $amountRP, $date);
				$user = User::getUser($model->id);
				$wallet = $user->wallet;
				$notice = 'Transaction is done successfully! Name: '.$user->name.' Redepmtion Point: '.$wallet->foodPoint.', Cash Point is '.$wallet->cashPoint;				
				$model = new User;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('manualtransaction',array('model'=>$model, 'userDropDownList'=>$userDropDownList, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionTransactionhistory()
	{
		list($id, $from, $to) = array(Yii::app()->user->id, null, null);
		$criteria = new CDbCriteria;
		$criteria->alias = 't';
		$criteria->order = 't.trandate desc, t.id desc';
		$filter = 'Deduct Point';
		$model = Transaction::model();
		$userDropDownList = User::getUserDropDownList();
		$title = 'Report : ';

		if (!empty($_POST['filter']))
		{
			$filter = $_POST['filter'];
			$title .= $_POST['filter'];
		}

		if (isset($_POST['DateFilter'])) {
			list($from, $to) = array($_POST['DateFilter']['from'], $_POST['DateFilter']['to']);
			if (empty($to)) $to = date("Y-m-d");
			$criteria->addBetweenCondition('tranDate', "{$from} 0:0", "{$to} 23:59:59");
			$title .= " [{$from} till {$to}]";
		}

		if (!empty($_POST['id']) && Yii::app()->user->roles == 'admin')
		{
			$id = $_POST['id'];
			$model->user($id);
		}

		if(Yii::app()->user->roles != 'admin')
			$model->user($id);

		$title .= ' (Name : '.User::getReferralName($id).')';
		$criteria->addSearchCondition('description', $filter);
		$model = $model->findAll($criteria);
		$total = count($model);
		$this->render('transactionhistory',array('model'=>$model, 'userDropDownList'=>$userDropDownList, 'total'=>$total, 'title'=>$title, 'filter' => compact('filter', 'from', 'to', 'id')));
	}

	public function actionNetwork()
	{
		$user = User::getUser(Yii::app()->user->id);
		$model = new network;
		$model->setSponsorNetwork(Yii::app()->user->id, 1);
		$tree = $model->getSponsorNetwork();

		$this->render('network',array('model'=>$tree, 'user'=>$user));
	}

	public function actionAnnouncement()
	{
		$CMessage = '';
		$notice = '';

		if(isset($_POST['title']) && isset($_POST['message'])) {
			try {
				$a = new Announcement;
				$a->attributes = array(
					'title'=>$_POST['title'],
					'message'=>$_POST['message'],
					'dateCreated'=>date('Y-m-d'),
					);

				if (!$a->save())
					throw new Exception("Fail to create announcement.");

				$notice = 'New announcement is posted!';
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$model = Announcement::model()->findAll(array('order'=>'dateCreated desc'));
		$total = count($model);

		$this->render('announcement', array('model'=>$model, 'CMessage'=>$CMessage, 'notice'=>$notice,'total'=>$total ));
	}

	public function actionEditannouncement($id = null)
	{
		$CMessage = '';
		$notice = '';
		$model = Announcement::model()->findByAttributes(array('id'=>$id));

		if(isset($_POST['Announcement']))
		{
			try {
				$model->attributes = $_POST['Announcement'];
				if (!$model->update())
					throw new Exception("Fail to update announcement.");
				$this->redirect(array("member/announcement"));
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('editannouncement', array('CMessage'=>$CMessage, 'notice'=>$notice, 'model'=>$model, 'id'=>$id));
	}

	public function actionTransferCP()
	{
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amount']) && isset($_POST['ph']))
		{
			$amount = $_POST['amount'];
			$ph = $_POST['ph'];
			if(isset($_POST['pin']))
				$pin = $_POST['pin'];

			try {
				if (empty($ph))
					throw new Exception('Please enter a member contact number.');

				if (empty($amount) || !is_numeric($amount))
					throw new Exception('Please enter a correct cash point.');

				$member = User::getUserByPhone($ph);
				$curUser = User::getUser(Yii::app()->user->id);

				if(Yii::app()->user->roles != 'admin')
				{
					if($pin != $curUser->pin)
						throw new Exception('Please enter a correct pin.');
				}

				User::transferCP($member,$curUser,$amount);

				$wallet = $curUser->wallet;
				$notice = 'Transaction is done successfully! Name: '.$curUser->name.' | Cash Point: '.$wallet->cashPoint;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('transferCP',array('CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionTransferCPtoFP()
	{
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amount']))
		{
			$amount = $_POST['amount'];

			try {
				if (empty($amount))
					throw new Exception('Please enter cash point.');

				$member = User::getUser(Yii::app()->user->id);

				User::transferCPtoFP($member,$amount);

				$wallet = $member->wallet;
				$notice = 'Transaction is done successfully! Name: '.$member->name.' | Cash Point: '.$wallet->cashPoint.' | Food Point: '.$wallet->foodPoint;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('transferCPtoFP',array('CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionPurchase()
	{
		$model = new Purchase;        
		$CMessage = '';
		$notice = '';

		if(isset($_POST['Purchase'])) {
			try{
				$model->attributes = $_POST['Purchase'];
				if (!$model->validate())
					throw new Exception("Please fill up the form correctly.", 1);

				$member = User::model()->findByAttributes(array('id' => Yii::app()->user->id));
				$model->purchaseCredit($member);
				if (!empty($_FILES)) {
					ini_set('upload_max_filesize', '10M');
					$folder = Yii::getPathOfAlias("application") . "/../assets/uploads";
					Yii::trace($folder, "application.controllers.MemberController");
					Yii::trace(var_export($_FILES, true), "application.controllers.MemberController");
					$handle = Yii::app()->imagemod->load($_FILES['statement']['tmp_name']);
					if (!$handle->uploaded)
						throw new Exception ("Fail to upload");

					$file = 'purchase_credit_' . md5($model->id);
					$handle->file_new_name_body = $file;
					$handle->file_new_name_ext = 'jpg';
					$handle->image_resize = true;
					$handle->image_convert = 'jpg';
					$handle->image_x = 600;
					$handle->image_ratio_y = true;
					$handle->Process($folder);

					if (!$handle->processed)
						throw new Exception($handle->error);
					$handle->Clean();
				}

				$model = new Purchase;
				$notice = 'Your purchase is submitted to admin.';

			} catch (Exception $e) {
				$model->delete();
				$CMessage = $e->getMessage();
			}

		}
		$list = $model->getAllPurchase();
		$total = count($list);

		$this->render('purchase', array('list'=>$list, 'model'=>$model,'CMessage'=>$CMessage, 'total'=>$total, 'notice'=>$notice));
	}

	public function actionPurchasehistory($id = null, $action = null)
	{
		$model = new Purchase;
		$CMessage = '';
		$notice = '';
		
		if(!is_null($id))
		{
			try
			{
				$model->handlePurchase($id, $action);
				$notice = 'The purchase request is confirmed / cancelled. Please check the transaction from transaction history.';
			}
			catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}
		
		$list = $model->getAllPurchase();
		$total = count($list);
		$this->render('purchasehistory', array('list'=>$list, 'total'=>$total, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

    public function actionWithdraw()
    { 
        $model = new Withdrawal;        
        $CMessage = '';
        $notice = '';

        if(isset($_POST['Withdrawal']))
        {
            try{
            	$model->attributes = $_POST['Withdrawal'];
                if (!$model->validate())
                    throw new Exception("Please fill up the form and amount correctly.", 1);

                $member = User::getUser(Yii::app()->user->id);
                $model->withdrawCredit($member);
                $model = new Withdrawal;
                $notice = 'Your withdraw request is submitted to admin.';
            }
            catch (Exception $e) {
                $CMessage = $e->getMessage();
            }

        }
        $list = $model->getAllWithdrawal();
        $total = count($list);

        $this->render('withdraw', array('list'=>$list, 'model'=>$model,'CMessage'=>$CMessage, 'total'=>$total, 'notice'=>$notice));
    }
    
    public function actionWithdrawhistory($id = null, $action = null)
    {
    	$model = new Withdrawal;
    	$CMessage = '';
        $notice = '';
    	
    	if(!is_null($id))
    	{
    		try
    		{
    			$model->handleWithdraw($id, $action);
    			$notice = 'The withdraw request is confirmed / cancelled. Please check the transaction from transaction history.';
    		}
    		catch (Exception $e) {
                $CMessage = $e->getMessage();
            }
    	}
    	
    	$list = $model->getAllWithdrawal();
    	$total = count($list);
    	$this->render('withdrawhistory', array('list'=>$list, 'total'=>$total, 'CMessage'=>$CMessage,'notice'=>$notice));
    }

    public function actionPayment()
    { 
        $model = new Bill;        
        $CMessage = '';
        $notice = '';

        if(isset($_POST['Bill']))
        {
            try{
            	$model->attributes = $_POST['Bill'];
                if (!$model->validate())
                    throw new Exception("Please fill up the form and amount correctly.", 1);

                $model->billPayment($model);
                $model = new Bill;
                $notice = 'Your bill payment request is submitted to admin.';
            }
            catch (Exception $e) {
                $CMessage = $e->getMessage();
            }

        }
        $list = $model->getAllBills();
        $total = count($list);

        $this->render('payment', array('list'=>$list, 'model'=>$model,'CMessage'=>$CMessage, 'total'=>$total, 'notice'=>$notice));
    }
    
    public function actionPaymenthistory($id = null, $action = null)
    {
    	$model = new Bill;
    	$CMessage = '';
        $notice = '';
    	
    	if(!is_null($id))
    	{
    		try
    		{
    			$model->handleBills($id, $action);
    			$notice = 'The bill payment request is confirmed / cancelled. Please check the transaction from transaction history.';
    		}
    		catch (Exception $e) {
                $CMessage = $e->getMessage();
            }
    	}
    	
    	$list = $model->getAllBills();
    	$total = count($list);
    	$this->render('paymenthistory', array('list'=>$list, 'total'=>$total, 'CMessage'=>$CMessage,'notice'=>$notice));
    }
    
    public function actionRefermember()
    {
            $model = new User;
            $packages = Package::getAllPackages();
            $CMessage = '';
            $notice = '';

            if(isset($_POST['User']))
            {
                    $model->attributes = $_POST['User'];

                    try {
                            if(!is_numeric($model->contact) || !is_numeric($model->contact))
                            {
                                throw new Exception("Please enter the right format of contact numbers.");
                            }
                        
                            if (!$model->validate())
                                    throw new Exception("Please fill in all fields in the forms correctly.");
                            $model->referMember();
                            $notice = 'Member has been created succesfully and await for administrator approval.';
                            
                            $model = new User;
                            
                    }
                    catch (Exception $e) 
                    {
                            $CMessage = $e->getMessage();
                    }
            }

            $this->render('refermember', array('model'=>$model, 'packages'=>$packages, 'CMessage'=>$CMessage, 'notice'=>$notice));
    }

	public function actionBinarynetwork($id = null)
	{
		$tree = array();
		$param = array();
		$total_level = 5;

		$member_list = User::getUserDropDownList();

		try {
			$selector = empty($_GET['search_id']) ? Yii::app()->user->id : $_GET['search_id'];
			// $model = User::model()->with('binaryNodes')->findByAttributes(array('id'=>$selector));
			$view_model = Binary::model()->with('user')->findByAttributes(array('userId'=>$selector));
			$node_index = 0;

			if (empty($view_model))
				throw new Exception("No such customer found.");

			if (!empty($_POST['insert_id']))
				Binary::create($_POST['insert_id'], array('num_of_nodes' => $_POST['insert_num']));

			if (!empty($_GET['node_index']))
				$node_index = intval($_GET['node_index']);

			$model = $view_model->user->binaryNodes[$node_index];
			if (!empty($id))
				$model = Binary::model()->with('user')->findByAttributes(array('id'=>$id));

			if (!empty($model))
				$tree = $model->getTree($total_level);
		} catch (Exception $e) {
			throw new CHttpException(404, $e->getMessage());
		}

		$view = 'binarynetwork';
		$param = compact('view_model', 'model', 'tree', 'member_list', 'selector', 'total_level', 'node_index');

		$this->render($view, $param);
	}

    public function actionManualsponsorbonus($id = null)
    {
    	network::setSponsorBonus($id);
    	var_dump("Successfully grant Sponsor bonus of {$id}");
    }

    public function actionRevertsponsorbonus($id = null)
    {
    	$user = User::model()->findByAttributes(array('id'=>$id));
    	$criteria = new CDbCriteria;
		$criteria->addSearchCondition('description', "Sponsor bonus from {$user->name}");
		$transaction = Transaction::model()->findAll($criteria);
			
		foreach($transaction as $t)
		{
			$wallet = Wallet::model()->findByAttributes(array('id'=>$t->walletId));
			$wallet->cashPoint -= $t->amount;
			if(!$wallet->save())
				var_dump("Transaction id: {$t->id} failed to deduct from wallet.");

			if(!$t->delete())
				var_dump("Transaction id: {$t->id} failed deleted and amount is deducted from {$wallet->user->name} wallet (CP: {$wallet->cashPoint}).");
			else
				var_dump("Transaction id: {$t->id} deleted and amount is deducted from {$wallet->user->name} wallet (CP: {$wallet->cashPoint}).<br/>");
		}    	
    }
}