<?php

/*
  Copyright (C) 2012
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
 * Description of BugController
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class BugController extends Zend_Controller_Action{
 
     public function init(){
        /* Initialize action controller here */
    }

    public function createAction(){
        $this->_helper->layout;
    }
    
    public function submitAction() {
        $bugForm = new Form_BugReportForm();
        $bugForm->setAction('/bug/submit');
        $bugForm->setMethod('post');
        if($this->getRequest()->isPost()){
            if($bugForm->isValid($_POST)){
                $bugModel = new Model_Bug();
                $result = $bugModel->createBug(
                        $bugForm->getValue('author'),
                        $bugForm->getValue('email'),
                        $bugForm->getValue('date'),
                        $bugForm->getValue('url'),
                        $bugForm->getValue('description'),
                        $bugForm->getValue('priority'),
                        $bugForm->getValue('status'));
                //TODO BugController#submitAction - better confirm and checking
                if ($result){
                    $this->_forward('confirm');
                }
            }
        }
        $this->view->form = $bugForm;
    }
    
    /**
     * List All bugs
     */
    public function listAction(){
        
        $listToolsForm = new Form_BugReportListToolsForm();
        $listToolsForm->setAction('/bug/list');
        $listToolsForm->setMethod('post');
        $this->view->listToolsForm = $listToolsForm;
        
        $sort = $this->_request->getParam('sort', null);
        $filter_field = $this->_request->getParam('filter_field', NULL);
        $filterValue = $this->_request->getParam('filter');
       
        if(!empty ($filter_field)){
            $filter[$filter_field] = $filterValue; 
        }else {
            $filter = null;
        }
        
        $listToolsForm->getElement('sort')->setValue($sort);
        $listToolsForm->getElement('filter_field')->setValue($filter_field);
        $listToolsForm->getElement('filter')->setValue($filter);
        
        
        $bugModel = new Model_Bug();
        $adapter = $bugModel->fetchPaginatorAdapter($filter, $sort);
        $paginator = new Zend_Paginator($adapter);
        
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator = $paginator;
    }
    
    /**
     * Edit a bug
     */
    public function editAction() {
        $bugModel = new Model_Bug();
        $bugReportForm = new Form_BugReportForm();
        $bugReportForm->setAction('/bug/edit');
        $bugReportForm->setMethod('post');
        if($this->getRequest()->isPost()){
            if($bugReportForm->isValid($_POST)){
                $bugModel = new Model_Bug();
                $result = $bugModel->updateBug($bugReportForm->getValue('id'),
                        $bugReportForm->getValue('author'),
                        $bugReportForm->getValue('email'),
                        $bugReportForm->getValue('date'),
                        $bugReportForm->getValue('url'),
                        $bugReportForm->getValue('description'),
                        $bugReportForm->getValue('priority'),
                        $bugReportForm->getValue('status'));
                return $this->_forward('list');
            }
        }else {
        $id = $this->_request->getParam('id');
        $bug = $bugModel->find($id)->current();
        $bugReportForm->populate($bug->toArray());
        $bugReportForm->getElement('date')->setValue(date('m-d-y',$bug->date));  
        }
        $this->view->form = $bugReportForm;
    }
    
    /**
     * Delete a bug
     */
    public function deleteAction() {
        $bugModel = new Model_Bug();
        $id = $this->_request->getParam('id');
        $bugModel->deleteBug($id);
        return $this->_forward('list');
    }
}
?>
