<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/19
 * Time: 3:05 PM
 * To change this template use File | Settings | File Templates.
 */


class Tnma_Zmags_PublicationController extends  Mage_Core_Controller_Front_Action
{



    public function showAction()
    {

        try {

            $slug = $this->getRequest()->getParam('slug');
            $publicationModel  = Mage::getModel('zmags/publication')->load($slug,'slug');

            if(!$publicationModel->getEntityId())
            {
                throw new Mage_Core_Exception($this->__('Publication not found'), 1);

            }else{

                if(!$publicationModel->getStatus() || $publicationModel->getStatus() !='1')
                {
                    Mage::getSingleton('core/session')->addError('This publication is not activated');
                }
                if(!$publicationModel->getHasStatrted())
                {
                    Mage::getSingleton('core/session')->addError('This publication is not activated yet');
                }

                if($publicationModel->gethasExpired())
                {
                    Mage::getSingleton('core/session')->addError('This publication has expired');
                }


                Mage::register('publication',$publicationModel);
            }

            $this->loadLayout();

            if(Mage::helper('zmags')->isMobile())
            {
                Mage::getSingleton('core/design_package')
                    ->setPackageName('zmags')
                    ->setTheme('mobile');

            }else{
                $_theme =  Mage::getStoreConfig( 'zmags/design/theme');
                if ($_theme) {

                        list($package, $theme) = explode('/', $_theme);
                        Mage::getSingleton('core/design_package')
                            ->setPackageName($package)
                            ->setTheme($theme);

                }
            }




            $this->loadLayoutUpdates();



            $layout =  Mage::getStoreConfig( 'zmags/design/layout');
            if ($layout) {



                    $this->getLayout()->helper('page/layout')
                    ->applyTemplate($layout);

            }

            $this->getLayout()->getBlock('head')->setTitle($publicationModel->getTitle());

            $this->renderLayout();

        } catch (Mage_Core_Exception $e) {

            Mage::logException($e);
            $this->_forward('noRoute');
        } catch (Exception $e) {


            Mage::logException($e);
            $this->_forward('noRoute');
        }
    }


    public function cssAction()
    {
        $this->getResponse()->setHeader('Content-type', 'text/css; charset=UTF-8');

        $template_id = Mage::getStoreConfig( 'zmags/design/product_template' );

        $template = Mage::getModel('zmags/customtemplate')->load($template_id);

        Mage::register('zmag_template',$template);

        $this->loadLayout();

        return $this->renderLayout();
    }


}