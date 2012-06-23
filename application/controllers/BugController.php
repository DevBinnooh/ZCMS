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
        
        $listToolsForm = new Form_BugReportForm();
        $sort = null;
        $filter = null;
        if ($this->getRequest()->isPost()){
            if ($listToolsForm->isValid($_POST)){
                $sortValue = $listToolsForm->getValue('sort');
                if('0' != $sortValue){
                    $sort = $sortValue;
                }
                $filterValues = $listToolsForm->getValue('filter_field');
                if ('0' != $filterValues){
                    $filter[$filterValues] = $listToolsForm->getValue('filter');
                }
            }
        }
        $bugModel = new Model_Bug();
        $this->view->bugs = $bugModel->fetchBugs();
       
        $listToolsForm->setAction('/bug/list');
        $listToolsForm->setMethod('post');
        $this->view->listToolsForm = $listToolsForm;
    }
}
?>
