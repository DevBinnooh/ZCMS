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
 * Description of BugReportForm
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class Form_BugReportForm extends Zend_Form{
    
    public function init() {
    
        //Author text element
        $authorField = $this->createElement('text', 'author');
        $authorField->setLabel('Enter Your Name: ');
        $authorField->setRequired(TRUE);
        $authorField->setAttrib('size', 30);
        $this->addElement($authorField);
        
        //Email Field
        $emailField = $this->createElement('text', 'email');
        $emailField->setLabel('Your Email: ');
        $emailField->setRequired(TRUE);
        $emailField->addValidator(new Zend_Validate_EmailAddress());
        $emailField->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToLower()
        ));
        $emailField->setAttrib('size', 40);
        $this->addElement($emailField);
        
        //Date Field
        $dateField = $this->createElement('text', 'date');
        $dateField->setLabel('Date the Issue Occured (MM-DD-YY): ');
        $dateField->setRequired(TRUE);
        $dateField->addValidator(new Zend_Validate_Date());
        $dateField->setAttrib('size', 20);
        $this->addElement($dateField);
        
        //URL Field
        $urlField = $this->createElement('text', 'url');
        $urlField->setLabel('Issue URL: ');
        $urlField->setRequired(FALSE);
        $urlField->setAttrib('size', 50);
        $this->addElement($urlField);
        
        //Description
        $descriptionField = $this->createElement('text', 'description');
        $descriptionField->setLabel('Issue Description: ');
        $descriptionField->setRequired(TRUE);
        $descriptionField->setAttrib('cols', 50);
        $descriptionField->setAttrib('rows', 4);
        $this->addElement($descriptionField);
        
        //Priority Field
        $priorityField =  new Zend_Form_Element_Select('priority',
                array(
                    'Label' => 'Issue Priority: ',
                    'Required' => TRUE
                ));
        $priorityField->addMultiOptions(array(
            'low' => 'Low',
            'med' => 'Medium',
            'high' => 'High'
        ));
        $this->addElement($priorityField);
        
        //Status Field
        $statusField = new Zend_Form_Element_Select( 'status', array (
            'Label' => 'Issue Status: '  
        ));
        $statusField->addMultiOptions(array(
            'new' => 'New',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved'
        ));
        $this->addElement($statusField);
        
        //submit button
        $this->addElement('submit','submit', array('label' => 'Submit'));
        
        
    }
}

?>
