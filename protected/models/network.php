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
}
?>
