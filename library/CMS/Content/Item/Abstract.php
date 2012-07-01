<?php
/*
  Copyright (C) 2012 DevBinnooh <http://www.binnooh.com>
  Redistribution and use in source and binary forms, with or without modification,
  are permitted provided that the following conditions are met:

 * *Redistributions of source code must retain the above copyright notice, 
  this list of conditions and the following disclaimer.
 * *Redistributions in binary form must reproduce the above copyright notice, 
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
  IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
  INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
  BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
  DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
  LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
  OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
  OF THE POSSIBILITY OF SUCH DAMAGE. */

/**
 * Description of Abstract
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class CMS_Content_Item_Abstract {
    
    /**
     * Id
     */
    public $id;
    
    /**
     * name
     */
    public $name;
    
    /**
     * page parent id
     */
    public $parent_id = 0;
    
    /**
     * namespace
     */
    protected $_namespace = 'page';
    
    /**
     * page Model
     */
    protected $_pageModel;
    
    const NO_SETTER = 'Setter method does not exist';
    
    public function __construct() {
        $this->_pageModel = new page();
        if (null != $pageId){
            $this->loadPageObject(intval($pageId));
        }
    }
    
    /**
     * Returns a row of data
     */
    public function _getInnerRow($id = null) {
        if (null == $id){
            $id = $this->id;
        }
        return $this->_pageModel->find($id)->current();
    }
    
    /**
     * Returns class proprities
     */
    protected function _getProperties() {
        
        $protectedArray = array();
        $class = new Zend_Reflection_Class($this);
        $properties = $class->getProperties();
        foreach($properties as $property){
            if ($property->isPublic()){
                $protectedArray[] = $property->getName();
            }
        }
        return $protectedArray;
    }
    
    /**
     * Sets a method name
     */
    protected function _callSetterMethod($property, $data) {
        
        $method = Zend_Filter::filterStatic($property, 'Word_UnderscoreToCamelCase');
        $methodName = '_set'.$method;
        if(method_exists($this, $methodName)){
            return $this->$methodName($data);
        }else {
            return self::NO_SETTER;
        }
    }
    
    /**
     * Loads page as an object
     */
    public function loadPageObject($id) {
        
        $this->id = $id;
        $row = $this->getInnerRow();
        if($row){
            if($row->namespace != $this->_namespace){
                throw new Zend_Exception('unable to cast page type:'.
                        $row->namespace . ' to type:'. $this->_namespace);
            }
            $this->name = $row->name;
            $this->parent_id = $row->parent_id;
            $currentNode = new Model_ContentNode();
            $nodes = $row->findDependentRowset($currentNode);
            if($nodes){
                $properties = $this->_getProperties();
                foreach ($node as $node){
                    $key = $node['node'];
                    if(in_array($key, $properties)){
                        $value = $this->_callSetterMethod($key, $nodes);
                        if($value === self::NO_SETTER){
                            $value = $node['content'];
                        }
                        $this->$key = $value;
                    }
                }
            }
        }else {
                throw new Zend_Exception("Unable to load content item");
            }
    }
    
    /**
     * Utility method that returns array of class proprities
     */
    public function toArray() {
        
        $properties = $this->_getProperties();
        foreach ($properties as $property){
            $array[$property] = $this->$property;
        }
        return $array;
    }
    
    /**
     * Saves current data
     */
    public function save() {
        
        if(isset($this->$id)){
            $this->_update();
        }else {
            $this->_insert();
        }
    }
    
    /**
     * inserts data
     */
    protected function _insert() {
        $pageId = $this->_pageModel->createPage(
                $this->name,$this->_namespace,$this->parent_id);
        $this->id = $pageId;
        $this->_update();
    }
    
    /**
     * update current data
     */
    protected function _update() {
        
        $data = $this->toArray();
        $this->_pageModel->updatePage($this->id,$data);
    }
    
    /**
     * Deletes data
     */
    protected function delete() {
        
        if(isset ($this->$id)){
            $this->_pageModel->deletePage($this->$id);
        }else {
            throw new Zend_Exception('Unable to delete item; the item is empty!');
        }
        
    }
}
?>
