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
 * Description of BugReportListToolsForm
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class Form_BugReportListToolsForm extends Zend_Form {
    
    public function init() {
        $options = array (
            '0' => 'None',
            'priority' => 'Priority',
            'status' => 'Status',
            'data' => 'Date',
            'url' => 'URL',
            'author' => 'Submitter'
        );
        $sort = new Zend_Form_Element_Select('sort', array(
            'label' => 'Sort Records: ',         
        ));
        $sort->addMultiOption($options);
        $this->addElement($sort);
        
        $filterField = new Zend_Form_Element_Select('filter_field', array(
            'label' => 'Filter Field: ',
        ));
        $filterField->addMultiOption($options);
        $this->addElement($filterField);
        
        $field = $this->createElement('text', 'filter');
        $field->setLabel('Fielter Value: ');
        $field->setAttrib('size', 40);
        $this->addElement($field);
        
        $this->addElement('submit','submit', array(
            'label' => 'Update List'
        ));
    }
}
?>
