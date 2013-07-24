<?php

class network{
    public $tree = array();

    public function setSponsorNetwork($id, $level)
    {
        $root = User::model()->findByAttributes(array('id'=>$id));
        $child = User::model()->findAllByAttributes(array('referral'=>$root->id));
        foreach ($child as $node) {
            $this->tree[] = array(
                'id'=>$node->id,
                'name'=>$node->name,
                'level'=>$level,
                'package'=>Package::getPackageName($node->packageId),
            );
            self::setSponsorNetwork($node->id, ($level + 1));
        }
    }
    
    public function getSponsorNetwork()
    {
//        var_dump($this->tree);
        return $this->tree;
    }
}
?>
