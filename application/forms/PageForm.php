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
 * Description of PageForm
 *
 * @author devBinnooh <devBinnooh@gmail.com>
 */
class Form_PageForm extends Zend_Form {
    
    public function init(){
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        $this->addElement($id);
        
        //name element
        $name = $this->createElement('text', 'name');
        $name->setLabel('Page Name: ');
        $name->setRequired(TRUE);
        $name->setAttrib('size', 40);
        $this->addElement($name);
        
        $headline = $this->createElement('text', 'headline');
        $headline->setLabel('Headline: ');
        $headline->setRequired(TRUE);
        $headline->setAttrib('size', 50);
        $this->addElement($name);
        
        //Image 
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Image: ');
        $image->setRequired(FALSE);
        $image->setDestination(APPLICATION_PATH . '/../public/images/upload');
        $image->addValidator('Count', false,1);
        //size limit 100K bytes
        $image->addValidator('Size',false,102400);
        $image->addValidator('Extension',false,'jpg,png,gif');
        $this->addElement($image);
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description: ');
        $description->setRequired(TRUE);
        $description->setAttrib('cols', 40);
        $description->setAttrib('rows', 4);
        $this->addElement($name);
        
        //content
        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        $content->setRequired(True);
        $content->setAttrib('cols', 50);
        $content->setAttrib('rows', 12);
        $this->addElement($content);
    }
}

?>
