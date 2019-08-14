<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/19
 * Time: 3:05 PM
 * To change this template use File | Settings | File Templates.
 */


require_once Mage::getModuleDir('controllers', 'Mage_Catalog').DS.'ProductController.php';


class Tnma_Zmags_ProductController extends Mage_Catalog_ProductController
{


    /**
     * Initialize requested product object
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _initProduct()
    {
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId  = (int) $this->getRequest()->getParam('product_id');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);

        return Mage::helper('catalog/product')->initProduct($productId, $this, $params);
    }


    /**
     * Product view action
     */
    public function viewAction()
    {

        // Get initial data from request
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId  = (int) $this->getRequest()->getParam('product_id');
        $specifyOptions = $this->getRequest()->getParam('options');



        // Prepare helper and params
        $viewHelper = Mage::helper('zmags/product_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        // Render page
        try {
            $viewHelper->prepareAndRender($productId, $this, $params);

        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }





}