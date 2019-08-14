<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/28
 * Time: 9:27 PM
 * To change this template use File | Settings | File Templates.
 */

class Tnma_Zmags_Helper_Product_View extends Mage_Core_Helper_Abstract
{

    // List of exceptions throwable during prepareAndRender() method
    public $ERR_NO_PRODUCT_LOADED = 1;
    public $ERR_BAD_CONTROLLER_INTERFACE = 2;

    /**
     * Inits layout for viewing product page
     *
     * @param Mage_Catalog_Model_Product $product
     * @param Mage_Core_Controller_Front_Action $controller
     *
     * @return Mage_Catalog_Helper_Product_View
     */
    public function initProductLayout($product, $controller)
    {
        $design = Mage::getSingleton('catalog/design');
        $settings = $design->getDesignSettings($product);

        /*if ($settings->getCustomDesign()) {
            $design->applyCustomDesign($settings->getCustomDesign());
        }*/





        if(Mage::helper('zmags')->isMobile())
        {


            $_theme =  "zmags/mobile";

        }else{
            $_theme =  "zmags/default";
        }

        if ($_theme) {

            list($package, $theme) = explode('/', $_theme);
            Mage::getSingleton('core/design_package')
                ->setPackageName($package)
                ->setTheme($theme);


        }



        $update = $controller->getLayout()->getUpdate();


        $update->addHandle('default');


        $controller->addActionLayoutHandles();


        $update->addHandle('PRODUCT_TYPE_' . $product->getTypeId());
        $update->addHandle('PRODUCT_' . $product->getId());
        $controller->loadLayoutUpdates();

        $update->addUpdate($product->getCustomLayoutUpdate());


        //$update->merge(strtolower($controller->getFullActionName()).'_FINAL');

        /*// Apply custom layout update once layout is loaded
        $layoutUpdates = $settings->getLayoutUpdates();
        if ($layoutUpdates) {
            if (is_array($layoutUpdates)) {
                foreach($layoutUpdates as $layoutUpdate) {
                    $update->addUpdate($layoutUpdate);
                }
            }
        }

*/


        $controller->generateLayoutXml()->generateLayoutBlocks();

        // Apply custom layout (page) template once the blocks are generated
        /* if ($settings->getPageLayout()) {
             $controller->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
         }

         $currentCategory = Mage::registry('current_category');
         $root = $controller->getLayout()->getBlock('root');
         if ($root) {
             $controllerClass = $controller->getFullActionName();
             if ($controllerClass != 'catalog-product-view') {
                 $root->addBodyClass('catalog-product-view');
             }
             $root->addBodyClass('product-' . $product->getUrlKey());
             if ($currentCategory instanceof Mage_Catalog_Model_Category) {
                 $root->addBodyClass('categorypath-' . $currentCategory->getUrlPath())
                     ->addBodyClass('category-' . $currentCategory->getUrlKey());
             }
         }*/
        $head = $controller->getLayout()->getBlock('head');

        if( Mage::getStoreConfig( 'zmags/design/product_template' ) !="default" )
        {
            $slug = Mage::getStoreConfig( 'zmags/configuration/slug' );
            $head->addCss('../../../../index.php/'.$slug.'/zmags.css');
        }


        return $this;
    }



    /**
     * Prepares product view page - inits layout and all needed stuff
     *
     * $params can have all values as $params in Mage_Catalog_Helper_Product - initProduct().
     * Plus following keys:
     *   - 'buy_request' - Varien_Object holding buyRequest to configure product
     *   - 'specify_options' - boolean, whether to show 'Specify options' message
     *   - 'configure_mode' - boolean, whether we're in Configure-mode to edit product configuration
     *
     * @param int $productId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param null|Varien_Object $params
     *
     * @return Mage_Catalog_Helper_Product_View
     */
    public function prepareAndRender($productId, $controller, $params = null)
    {
        // Prepare data
        $productHelper = Mage::helper('catalog/product');
        if (!$params) {
            $params = new Varien_Object();
        }

        // Standard algorithm to prepare and rendern product view page
        $product = $this->initProduct($productId, $controller, $params);
        if (!$product) {
            throw new Mage_Core_Exception($this->__('Product is not loaded'), $this->ERR_NO_PRODUCT_LOADED);
        }

        $buyRequest = $params->getBuyRequest();
        if ($buyRequest) {
            $productHelper->prepareProductOptions($product, $buyRequest);
        }

        if ($params->hasConfigureMode()) {
            $product->setConfigureMode($params->getConfigureMode());
        }

        Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));

        if ($params->getSpecifyOptions()) {
            $notice = $product->getTypeInstance(true)->getSpecifyOptionMessage();
            Mage::getSingleton('catalog/session')->addNotice($notice);
        }

        Mage::getSingleton('catalog/session')->setLastViewedProductId($product->getId());


        $this->initProductLayout($product, $controller);

        //$controller->initLayoutMessages(array('catalog/session', 'tag/session', 'checkout/session'))
        $controller->renderLayout();

        return $this;
    }



    /**
     * Inits product to be used for product controller actions and layouts
     * $params can have following data:
     *   'category_id' - id of category to check and append to product as current.
     *     If empty (except FALSE) - will be guessed (e.g. from last visited) to load as current.
     *
     * @param int $productId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param Varien_Object $params
     *
     * @return false|Mage_Catalog_Model_Product
     */
    public function initProduct($productId, $controller, $params = null)
    {
        // Prepare data for routine
        if (!$params) {
            $params = new Varien_Object();
        }

        // Init and load product
        Mage::dispatchEvent('catalog_controller_product_init_before', array(
            'controller_action' => $controller,
            'params' => $params,
        ));

        if (!$productId) {
            return false;
        }

        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);

        if (!$this->canShow($product)) {
            return false;
        }
        if (!in_array(Mage::app()->getStore()->getWebsiteId(), $product->getWebsiteIds())) {
            return false;
        }

        // Load product current category
        $categoryId = $params->getCategoryId();
        if (!$categoryId && ($categoryId !== false)) {
            $lastId = Mage::getSingleton('catalog/session')->getLastVisitedCategoryId();
            if ($product->canBeShowInCategory($lastId)) {
                $categoryId = $lastId;
            }
        } elseif (!$product->canBeShowInCategory($categoryId)) {
            $categoryId = null;
        }

        if ($categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $product->setCategory($category);
            Mage::register('current_category', $category);
        }

        // Register current data and dispatch final events
        Mage::register('current_product', $product);
        Mage::register('product', $product);

        try {
            Mage::dispatchEvent('catalog_controller_product_init', array('product' => $product));
            Mage::dispatchEvent('catalog_controller_product_init_after',
                array('product' => $product,
                    'controller_action' => $controller
                )
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $product;
    }


    /**
     * Check if a product can be shown
     *
     * @param  Mage_Catalog_Model_Product|int $product
     * @return boolean
     */
    public function canShow($product, $where = 'catalog')
    {
        if (is_int($product)) {
            $product = Mage::getModel('catalog/product')->load($product);
        }

        /* @var $product Mage_Catalog_Model_Product */

        if (!$product->getId()) {
            return false;
        }

        return $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility();
    }



}