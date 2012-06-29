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
 * Description of ContentNode
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
require_once APPLICATION_PATH.'/models/page.php';
class Model_ContentNode extends Zend_Db_Table_Abstract {
    
    /**
     * Table name
     */
    protected $_name = 'content_node';
    
    /**
     * Table reference map
     */
    protected $_referenceMap = array (
        'Page' => array (
            'columns' => array('page_id'),
            'refTableClass' => 'Model_Page',
            'refColumns' => array('id'),
            'onDelete' => self::CASCADE,
            'onUpdate' => self::RESTRICT
        )
    );

    /**
     * Sets content nodes
     */
    public function setNode($pageId, $node, $value) {
        $select = $this->select();
        $select->where("page_id = ?", $pageId);
        $select->where("node = ?", $node);
        $row = $this->fetchRow($select);
        
        if(!$row){
            $row = $this->createRow();
            $row->page_id = $pageId;
            $row->node = $node;
        }
        
        $row->content = $value;
        $row->save();
    }
    
    /**
     * Updates a Page
     */
    public function updatePage($id, $data) {
        $row = $this->find($id)->current();
        if($row){
            $row->name = $data['name'];
            $row->parent_id = $data['parent_id'];
            $row->save();
            
            unset($data['id']);
            unset($data['name']);
            unset($data['parent_id']);
            
            if(count($data) > 0 ){
                foreach ($data as $key => $value) {
                    $mContentNode->setNode($id,$key,$value);
                }
            }
        }else {
            throw new Zend_Exception('Could not open page to update');
        }
    }
}

?>
