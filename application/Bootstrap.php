<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initView() {
        //init View
        $view = new Zend_View();
        $view->docType('XHTML1_STRICT');
        $view->headTitle('ZCMS');
        $view->skin = 'simpleBlue';
        
        //Adding View Rander
        $viewRander = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRander->setView($view);
        
        return $view;
        
    }

}

