<?php

class network{
    public $tree = array();

    public function setSponsorNetwork($id, $level)
    {
        $root = User::model()->findByAttributes(array('id'=>$id));
        $child = User::model()->findAllByAttributes(array('referral'=>$root->id));
        foreach ($child as $node) {
            if($node->isApproved == 0)$node->name = "<span style='color: red;'>".$node->name."</span>";
            $this->tree[] = array(
                'level'=>$level,
                'referral'=>User::getReferralName($node->referral),
                'id'=>$node->id,
                'name'=>$node->name,                
                'package'=>Package::getPackageName($node->packageId),
                'date'=>$node->created,
            );
            self::setSponsorNetwork($node->id, ($level + 1));
        }
    }
    
    public function getSponsorNetwork()
    {
        asort($this->tree);
        return $this->tree;
    }

	public static function setSponsorBonus($id)
	{
		$model = User::model()->with('package')->findByAttributes(array('id'=>$id));
		$rates = Sponsorlevel::model()->getSponsorRates();
		$currentNode = $model;
		$result = array();

		foreach (range(1, 10) as $i) {
			$currentNode = $currentNode->sponsor;
			if (empty($currentNode))
				break ;

			if ($currentNode->package->level < $i)
				continue ;

			$result[] = Transaction::create($currentNode, array(
				'amount' => $model->package->value * $rates[$i],
				'type' => 'DEBIT',
				'point' => Transaction::TRAN_CP,
				'description' => 'Sponsor bonus from '.$model->name.'. (Level '.$i.')'
				));
		}

		return $result;
	}
}
?>
