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
 * Description of Page
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
require_once APPLICATION_PATH.'/models/ContentNode.php';
class Model_Page extends Zend_Db_Table_Abstract {
    
    /**
     * Table name
     */
    protected $_name = 'page';
    
    /**
     * Table Dependence
     */
    protected $_dependentTables = array('Model_ContentNode');
    
    /**
     * Table reference map
     */
    protected $_referenceMap = array (
        'Page' => array (
            'columns' => array('parent_id'),
            'refTableClass' => 'Model_Page',
            'refColumns' => array('id'),
            'onDelete' => self::CASCADE,
            'onUpdate' => self::RESTRICT
        )
    );
    
    /**
     * Creates a page
     */
    public function createPage($name, $namespace, $parentId = 0) {
        $row = $this->createRow();
        $row->name = $name;
        $row->namespace = $namespace;
        $row->parent_id = $parentId;
        $row->date_created = time();
        $row->save();
        
        $id = $this->_db->lastInsertId();
        return $id;
    }
    
    /**
     * Deletes a page
     */
    public function deletePage($id) {
        $row = $this->find($id)->current();
        
        if($row){
            $row->delete();
            return true;
        }else {
            return false;
            //or Throw exception
        }
        
    }
}

?>
