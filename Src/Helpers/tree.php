<?php
class Node
{

    public $value;    // contains the node item
    public $left;     // the left child BinaryNode
    public $right;
    function __construct($data)
    {
        $this->value = $data;
        // new nodes are leaf nodes
        $this->left = null;
        $this->right = null;
    }
    
    
}

class TreeDS
{
    protected $root; // the root node of our tree

    public function __construct() {
        $this->root = null;
    }

    public function isEmpty() {
        return $this->root === null;
    }
    
    function insert()
    {

    }

    function search()
    {

    }

    function delete()
    {

    }


}