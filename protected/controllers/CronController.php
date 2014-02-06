<?php

class CronController extends Controller
{
	protected static $config = array();
	protected $response = array();

	protected function beforeAction($action)
	{
		ini_set('max_execution_time', 0);
		$file = Yii::getPathOfAlias('application.config') . "/cron.php";
		if (file_exists($file)) {
			$config = require($file);
			if (is_array($config))
				self::$config = $config;
		}
		return true;
	}

	public function filters()
	{
		return array(
			// 'sourceControl'
			);
	}

	public function filterSourceControl($filterChain)
	{
		if (Yii::app()->request->userHostAddress != '127.0.0.1')
			throw new CHttpException(404, "Page not found.");
		$filterChain->run();
	}

	public function actionMonthly()
	{
		$placement = array();
		$datetime = date("Y-m-d H:i:s");
		$today = date("Y-m-d");
		$default = array(
			'start' => date("Y-m-d", strtotime($today . ' - 1month')) . ' 0:0',
			'end' => date("Y-m-d", strtotime($today . ' - 1day')) . ' 23:59:59'
			);

		// set the placement configuration parameters
		if (isset(self::$config['monthly']['placement']))
			$placement = self::$config['monthly']['placement'];

		// configure default value from the configuration
		foreach ($placement as $key => $value)
			if (!empty($value))
				$default[$key] = $value;

		$sales = User::model()->with('package')->between($default['start'], $default['end'])->activated()->sales()->find();
		$total_nodes = floatval(Binary::model()->between($default['start'], $default['end'])->count());
		$total_sales = floatval($sales->total_sales);
		$admin_bonus = 0;
		$total_bonus = 0;
		$special_bonus = 0;
		$model = Binary::model()->findAll();

		foreach ($model as $b) {
			$id = $b->id;
			$tree = $b->between($default['start'], $default['end'])->tree(10)->find(array(
				'select' => 'COUNT(*) as total_nodes',
				'condition' => 'userId != :id',
				'params' => array(':id' => $b->userId),
				));
			$bonus = $tree->total_nodes * 5;

			if ($b->id == 1) {
				$admin_bonus = $bonus;
				$special_bonus = $admin_bonus / ($total_nodes);
				continue ;
			}

			$total_bonus += $bonus + $special_bonus;

			if ($bonus > 0) {
				Transaction::create($b->user, array(
					'amount' => $bonus,
					'type' => 'DEBIT',
					'point' => Transaction::TRAN_CP,
					'description' => "Autoplacement CP bonus (key:{$b->id})",
					));
				Transaction::create($b->user, array(
					'amount' => $bonus,
					'type' => 'DEBIT',
					'point' => Transaction::TRAN_FP,
					'description' => "Autoplacement RP bonus (key:{$b->id})",
					));
			}
			// if ($special_bonus > 0) {
			// 	Transaction::create($b->user, array(
			// 		'amount' => $special_bonus,
			// 		'type' => 'DEBIT',
			// 		'point' => Transaction::TRAN_CP,
			// 		'description' => "Autoplacement CP special bonus (key:{$b->id})",
			// 		));
			// 	Transaction::create($b->user, array(
			// 		'amount' => $special_bonus,
			// 		'type' => 'DEBIT',
			// 		'point' => Transaction::TRAN_FP,
			// 		'description' => "Autoplacement RP special bonus (key:{$b->id})",
			// 		));
			// }
		}
		$this->response = compact('datetime', 'total_nodes', 'total_sales', 'admin_bonus', 'total_bonus', 'special_bonus');
		$this->response = array_merge($default, $this->response);
		header("content-type: text/plain");
		var_export($this->response);
	}

	/*
	*	Flush Admin received bonus from autoplacement cron back to downline members
	*/
	public function actionFlushbonus()
	{
		$bonus = 0;
		$count = 0;
		$total_bonus = 0;
		$members = array(7,12,17,20,21,48,50,51,54,56,57,62,64,73,74,77,78);
		$model = User::model()->findAll();

		foreach ($model as $b) {
			if(!in_array($b->wallet->id, $members))
				continue;

			if($b->id > 4)
			{
				switch ($b->packageId) {
					case 1:
						# code...
						$bonus = 40;
						break;
					case 2:
						$bonus = (45 * 3);
						break;
					case 3:
						$bonus = (50 * 7);
					default:
						# code...						
						break;
				}
				$total_bonus += $bonus;
				$count += 1;

				if ($bonus > 0) {
					Transaction::create($b, array(
						'amount' => $bonus,
						'type' => 'DEBIT',
						'point' => Transaction::TRAN_CP,
						'description' => "Autoplacement CP special bonus (key:{$b->id})",
						));
					echo("{$b->name} Autoplacement CP special bonus RM {$bonus}\n");
				}
			}
		}
		header("content-type: text/plain");
		echo "Total bonus is {$total_bonus} out of {$count} of nodes.";
	}

	/*
	*	Run first time before network tree is formed only, extremely dangerous
	*/
	public function actionAutoplacement()
	{
		$model = User::model()->activated()->findAll();
		$added = array();
		foreach ($model as $user) {
			$b = Binary::model()->findByAttributes(array('userId'=>$user->id));
			if (!empty($b))
				continue ;
			Binary::create($user, array('created' => $user->created));
			$added[] = $user->id . " " . $user->created;
		}
		header("content-type: text/plain");
		var_export($added);
	}
}