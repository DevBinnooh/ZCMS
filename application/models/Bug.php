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
 * Model for bug reporting
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class Model_Bug extends Zend_Db_Table_Abstract {
    protected $_name = 'bugs';
    
    public function createBug($name, $email, $date,
            $url,$description, $priority,
            $status) {
        
        $tmpDate = new Zend_Date($date);
        $tmpDate->get(Zend_Date::TIMESTAMP);
        $row = $this->createRow(array(
            'author' => $name,
            'email' => $email,
            //date will be set auto or
            'date' => $tmpDate,
            'url' => $url,
            'description' => $description,
            'priority' => $priority,
            'status' => $status
        ));
        
        $row->save();
        
        //return database generated id
        return $this->_db->lastInsertId();
    }
    
    /**
     * Function that returns all stored bugs
     * @return Zend_db_Table_Rowset 
     */
    public function fetchAllBugs() {
        return $this->fetchAll($this->select());
        
    }
    
    /**
     * Fetch filtered bugs
     * TODO Model_Bug#fetchBugs - doc
     */
    public function fetchBugs($filters = array(), $sortField = null, $limit=null, $page=1) {
        $select = $this->select();
        if (count($filters) > 0){
            foreach ($filters as $field => $filter){
                $select->where($field . ' = ?', $filter);
            }
        }
        //add sorted field
        if (null != $sortField){
            $select->order($sortField);
        }
        
        if(null != $limit){
            $select->limit($limit, $page);
        }
        
//        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $this->fetchAll($select);
        
    }
    
     /**
     * Fetch filtered bugs
     * TODO Model_Bug#fetchPagInatorAdaptor - doc
     * @return Zend_Paginator_Adapter_DbTableSelect 
     */
    public function fetchPaginatorAdapter($filters = array(), $sortField = null, $limit=null, $page=1) {
        $select = $this->select();
        if (count($filters) > 0){
            foreach ($filters as $field => $filter){
                $select->where($field . ' = ?', $filter);
            }
        }
        //add sorted field
        if (null != $sortField){
            $select->order($sortField);
        }
        
//        if(null != $limit){
//            $select->limit($limit, $page);
//        }
        
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
        
    }
    
}

?>
