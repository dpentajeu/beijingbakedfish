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
                'id'=>$node->id,
                'name'=>$node->name,                
                'package'=>Package::getPackageName($node->packageId),
                'referral'=>User::getReferralName($node->referral),
                'date'=>$node->created,
            );
            self::setSponsorNetwork($node->id, ($level + 1));
        }
    }
    
    public function getSponsorNetwork()
    {
//        var_dump($this->tree);
        asort($this->tree);
        return $this->tree;
    }

	public static function setSponsorBonus($id)
	{
		$model = User::model()->with('package')->findByAttributes(array('id'=>$id));
		$rates = Sponsorlevel::model()->getSponsorRates();
		$currentNode = $model;
		$result = array();

		echo "\nNEW MEMBER : " . $model->name . "(package: {$model->package->packageName}, value: {$model->package->value})\n";
		foreach (range(1, 10) as $i) {
			$currentNode = $currentNode->sponsor;
			if (empty($currentNode))
				break ;

			echo " * Level {$i} sponsor: {$currentNode->name}; package: {$currentNode->package->packageName}; entitled level: {$currentNode->package->level}\n";
			if ($currentNode->package->level < $i)
				continue ;

			echo "   >  Enjoyed {$rates[$i]}% of {$model->package->value} : " . ($model->package->value * $rates[$i]) . "\n";
			$result[] = Transaction::create($currentNode, array(
				'amount' => $model->package->value * $rates[$i],
				'type' => 'DEBIT',
				'point' => Transaction::TRAN_CP,
				'description' => 'Sponsor bonus from '.$model->name.'. (Level '.$i.')'
				));
		}
		echo "\n";

		return $result;
	}
}
?>
