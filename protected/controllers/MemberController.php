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
				'actions'=>array('login','logout','resetpassword'),
				'users'=>array('*'),
				),
			array('allow',
				'actions'=>array(
					'test4',
					'index',
					'changepassword',
					'setpin',
					'network',
					'transaction',
					'transactionhistory',
					'announcement',
					'transferCP',
					),
				'users'=>array('@'),
				),
			array('allow',
				'actions'=>array('editmember', 'approve', 'disapprove', 'sms', 'editannouncement'),
				'roles'=>array('admin'),
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
				$CMessage = 'Please remember set up your PIN for Food Point redemption.';
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
		$model=new LoginForm;

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
		$model = User::getUser($id);
		$packages = Package::getAllPackages();
		$CMessage = '';

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

		$this->render('editmember', array('model'=>$model, 'packages'=>$packages, 'CMessage'=>$CMessage));
	}

	public function actionApprove($id = null)
	{
		$model = User::getUser($id);
		$CMessage = '';

		try {
			$model->approveUser($id);
			//network::setSponsorBonus($id);
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
		$userDropDownList = User::getUserDropDownList();
		$CMessage = '';
		$notice = '';

		if (isset($_POST['message']) && isset($_POST['member']))
		{
			$msg = $_POST['message'];

			try {
				if (empty($msg))
					throw new Exception('Message cant be empty.');

				if ($_POST['member'] == 1) {
					if (empty($_POST['id']))
						throw new Exception('Please select a customer.');

					User::smsTo($id, $msg);
					$notice = 'Message is send!';
				} else if ($_POST['member'] == 2) {
					User::smsToAll($msg);
					$notice = 'All messages is send!';
				}
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('sms', array('CMessage'=>$CMessage, 'notice'=>$notice, 'userDropDownList'=>$userDropDownList));
	}

	public function actionTransaction()
	{
		if (Yii::app()->user->id != 1) $this->redirect('login');

		$model = new User;
		$userDropDownList = User::getUserDropDownList();
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amount']) && isset($_POST['User']))
		{
			$amount = $_POST['amount'];
			$model->attributes = $_POST['User'];

			try {
				if(empty($model->id))
					throw new Exception('Please select a customer.');

				if(is_null($amount) || $amount == 0)
					throw new Exception('Please enter total bill amount.');

				$model->transferFP($amount/2, 'CREDIT');
				$user = User::getUser($model->id);
				$wallet = $user->wallet;
				$notice = 'Transaction is done successfully! Name: '.$user->name.' Balance: '.$wallet->foodPoint;
				$msg = 'Your beijingbakedfish bill is RM '.$amount.', remaining  Food Point is '.$wallet->foodPoint.', thanks and come again.';
				User::send_sms($user->contact,$msg);

				$model = new User;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('transaction',array('model'=>$model, 'userDropDownList'=>$userDropDownList, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionTransactionhistory()
	{
		$filter = 'Deduct Food Point';

		if (!empty($_POST['filter']))
			$filter = $_POST['filter'];

		$model = Transaction::getTransaction($filter);
		$total = count($model);
		$this->render('transactionhistory',array('model'=>$model, 'total'=>$total));
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
		$userDropDownList = User::getUserDropDownList();
		$CMessage = '';
		$notice = '';

		if(isset($_POST['amount']) && isset($_POST['id']))
		{
			$amount = $_POST['amount'];
			$id = $_POST['id'];

			try {
				if (empty($id))
					throw new Exception('Please select a customer.');

				if (empty($amount))
					throw new Exception('Please enter cash point.');

				$member = User::getUser($id);
				$curUser = User::getUser(Yii::app()->user->id);

				User::transferCP($member,$curUser,$amount);

				$wallet = $curUser->wallet;
				$notice = 'Transaction is done successfully! Name: '.$curUser->name.' Cash Point: '.$wallet->cashPoint;
			} catch (Exception $e) {
				$CMessage = $e->getMessage();
			}
		}

		$this->render('transferCP',array('userDropDownList'=>$userDropDownList, 'CMessage'=>$CMessage,'notice'=>$notice));
	}

	public function actionTest4()
	{
		$criteria = new CDbCriteria;
		$criteria->order = "tranDate desc";
		$criteria->addSearchCondition('description', 'Sponsor bonus');
		$transactions = Transaction::model()->findAll($criteria);

		foreach ($transactions as $item) {
			# code...
			$item->wallet->foodPoint -= $item->amount;
			$item->wallet->cashPoint = $item->amount;
			if(!$item->wallet->save())
				var_dump("Error Processing Request");
		}
	}
}