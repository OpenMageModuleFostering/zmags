<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/19
 * Time: 2:58 PM
 * To change this template use File | Settings | File Templates.
 */
class Tnma_Zmags_Controller_Router_Publication extends Mage_Core_Controller_Varien_Router_Standard
{




    public function getProductId($key,$value)
    {

        if($key =='id')
        {
            $_product = Mage::getModel('catalog/product')->load($value);
        }else{
            $_product = Mage::getModel('catalog/product')->loadByAttribute($key, $value);
        }

        if($_product){
        return $_product->getId();
        }

        return false;
    }




    public function match(Zend_Controller_Request_Http $request)
    {
        $path = explode('/', trim($request->getPathInfo(), '/'));

        // If path doesn't match your module requirements

        $slug = Mage::getStoreConfig( 'zmags/configuration/slug' );
        if ($path[0] != $slug) {
            return false;
        }

        //if product id
        if($path[1]=="zmags.css")
        {
            // Define initial values for controller initialization
            $module = 'zmags';
            $realModule = 'Tnma_Zmags';
            $controller = 'publication';
            $action = 'css';

        }elseif(is_numeric($path[1]))
        {
            // Define initial values for controller initialization
            $module = 'zmags';
            $realModule = 'Tnma_Zmags';
            $controller = 'product';
            $action = 'view';

            $request->setParam('product_id',$path[1]);

        }elseif( isset($path[1]) && isset($path[2]) )
        {

            $prod_id = $this->getProductId($path[1], $path[2]);
            $module = 'zmags';
            $realModule = 'Tnma_Zmags';
            $controller = 'product';
            $action = 'view';

            $request->setParam('product_id',$prod_id);
        }

        else{ // if publicatiom

            // Define initial values for controller initialization
            $module = 'zmags';
            $realModule = 'Tnma_Zmags';
            $controller = 'publication';
            $action = 'show';

            $request->setParam('url_path', $path[1]);
            $request->setParam('slug',$path[1]);
        }


        $controllerClassName = $this->_validateControllerClassName(
            $realModule,
            $controller
        );
        // If controller was not found
        if (!$controllerClassName) {
            return false;
        }
        // Instantiate controller class
        $controllerInstance = Mage::getControllerInstance(
            $controllerClassName,
            $request,
            $this->getFront()->getResponse()
        );
        // If action is not found
        if (!$controllerInstance->hasAction($action)) {
            return false; //
        }
        // Set request data
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        $request->setControllerModule($realModule);

       // $request->setRouteName('zmags_publication_show');
              //echo $this->getRouteByFrontName($module);
//         /$request->setRouteName('ourextension_' . $this->getRouteByFrontName($module)   );

        $request->setRouteName('zmags');
        // Set your custom request parameter

        // dispatch action
        $request->setDispatched(true);
        $controllerInstance->dispatch($action);
        // Indicate that our route was dispatched
        return true;
    }

}
