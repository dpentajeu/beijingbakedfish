<?php

class network{
    public $tree = array();

    public function setSponsorNetwork($id, $level)
    {
        $root = User::model()->findByAttributes(array('id'=>$id));
        $child = User::model()->findAllByAttributes(array('referral'=>$root->id));
        foreach ($child as $node) {
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

    public function setSponsorBonus($id)
    {
        $newMember = User::model()->findByAttributes(array('id'=>$id));
        $package = Package::model()->findByAttributes(array('id'=>$newMember->packageId));
        $referralId = 0;
        for($i = 1; $i <= $package->level; $i++){
            if($i == 1)
            {
                $referralId = $newMember->referral;                
            }

            $referral = User::model()->findByAttributes(array('id'=>$referralId));
            $sponsorTable = SponsorLevel::model()->findByAttributes(array('level'=>$i));

            if($referral->id == 1)
                break;

            Transaction::transferFP($referral, array(
                'amount'=>($package->value * $sponsorTable->rate),
                'type'=>'DEBIT',
                'description'=>'Sponsor bonus from '.$newMember->name.'. (Level '.$i.')',
                ));

            $referralId = $referral->id;
        }
    }
}
?>
