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
    
    protected function _initAutoLoad() {
        $autoLoad = Zend_Loader_Autoloader::getInstance();
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => '',
            'resourceTypes' => array(
                'form' => array(
                    'path' => 'forms/',
                    'namespace' => 'Form_'
                ),
                'model' => array(
                    'path' => 'models/',
                    'namespace' => 'Model_'
                ),
            ),
        ));
        return $autoLoad;
    }

}

