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
 * Description of PageController
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class PageController extends Zend_Controller_Action {
   
    /**
     * Creates a new page
     * @return type 
     */
    public function createAction() {
        $pageForm = new Form_PageForm();
        if ($this->getRequest()->isPost()){
            if($pageForm->isValid($_POST)){
                //create a new page item
                $itemPage = new CMS_Content_Item_Page();
                $itemPage->name = $pageForm->getValue('name');
                $itemPage->headline = $pageForm->getValue('headline');
                $itemPage->description = $pageForm->getValue('description');
                $itemPage->content = $pageForm->getValue('content');
                
                //upload image
                if($pageForm->image->isUploaded()){
                    $pageForm->image->receive();
                    $itemPage->image = '/images/upload/'.
                    basename($pageForm->image->getFileName());
                }
                //save content item
                $itemPage->save();
                return $this->_forward('list');
            }
        }
        $pageForm->setAction('/page/create');
        $this->view->form = $pageForm;
    }
    
    /**
     * List Available pages
     */
    public function listAction() {
        
        $pageModle = new Model_Page();
        $select = $pageModle->select();
        $select->order('name');
        $currentPages = $pageModle->fetchAll($select);
        if($currentPages->count() > 0){
            $this->view->pages = $currentPages;
        }else {
            $this->view->pages = null;
        }
    }
    
    /**
     * Edits an existing page
     */
    public function editAction() {
        
        $id = $this->_request->getParam('id');
        $itemPage = new CMS_Content_Item_Page($id);
        $pageForm = new Form_PageForm();
        $pageForm->setAction('/page/edit');
        $pageForm->populate($itemPage->toArray());
        
        //create image preview
        $imagePreview = $pageForm->createElement('image', 'image_preview');
        $imagePreview->setLabel('Preview Image: ');
        $imagePreview->setAttrib('style', 'width:200px;height:auto;');
        $imagePreview->setOrder(4);
        $imagePreview->setIgnore($itemPage->image);
        $pageForm->addElement($imagePreview);
        
        $this->view->form = $pageForm;
    }
}

?>
