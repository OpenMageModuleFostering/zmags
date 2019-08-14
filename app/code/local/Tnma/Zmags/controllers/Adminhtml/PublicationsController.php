<?php


require_once ("Tnma/Zmags/Lib/Zmags/Zmags.php");

class Tnma_Zmags_Adminhtml_PublicationsController extends Mage_Adminhtml_Controller_Action
{

    /**
     * @var Zmags
     */
    protected $zmags;


    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = array('jsondata');


    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('zmags/publications')
            ->_addBreadcrumb(Mage::helper('zmags')->__('Publications Manager'), Mage::helper('zmags')->__('Publication Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();

    }


    public function newAction()
    {
        $slug = Mage::getStoreConfig( 'zmags/configuration/slug' );
        $cust_id = Mage::getStoreConfig( 'zmags/configuration/customer_id' );
        $app_key = Mage::getStoreConfig( 'zmags/configuration/application_key' );
        $base_url = Mage::getStoreConfig( 'zmags/configuration/api_base_url' );

        if(!$slug || !$cust_id || !$app_key || !$base_url)
        {

            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zmags')->__('PLease configure the plugin first'));

            $this->_redirect('*/*/');
            return;
        }
        $this->getRequest()->setParam('entity_id', 0);
        $this->_forward('edit');
    }



    public function editAction()
    {
        $this->_title($this->__('ZMags'))->_title($this->__('Publications'));

        $publicationId     = $this->getRequest()->getParam('entity_id');
        $publicationModel  = Mage::getModel('zmags/publication')->load($publicationId);

        if ($publicationModel->getEntityId() || $publicationId == 0) {
            //$this->_title($publicationModel->getEntityId() ? $publicationModel->getTitle() : $this->__('New Publication'));

            Mage::register('publication_data', $publicationModel);

            $this->loadLayout();
            $this->_setActiveMenu('zmags/publications');
            $this->_addBreadcrumb(Mage::helper('zmags')->__('Publication Manager'), Mage::helper('zmags')->__('Publication Manager'), $this->getUrl('*/*/'));
            $this->_addBreadcrumb(Mage::helper('zmags')->__('Edit Publication'), Mage::helper('zmags')->__('Edit Publication'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('zmags/adminhtml_publications_edit'))
                    ->_addLeft($this->getLayout()->createBlock('zmags/adminhtml_publications_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zmags')->__('The publication does not exist.'));
            $this->_redirect('*/*/');
        }
    }


    public function deleteAction()
    {

        $publicationId     = $this->getRequest()->getParam('entity_id');
        $publicationModel  = Mage::getModel('zmags/publication')->load($publicationId);

        $publicationModel->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zmags')->__('Publication deleted'));
        $this->_redirect('*/*/');



    }


    public function massDeleteAction()
    {
        $pubIds = $this->getRequest()->getParam('entity_id');      // $this->getMassactionBlock()->setFormFieldName('entity_id');
        if(!is_array($pubIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zmags')->__('Please select publication(s).'));
        } else {
            try {
                $publicationModel = Mage::getModel('zmags/publication');
                foreach ($pubIds as $pubId) {
                    $publicationModel->load($pubId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('zmags')->__(
                        'Total of %d record(s) were deleted.', count($pubIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');

    }

    public function saveAction() {

        if ($data = $this->getRequest()->getPost()) {


            $model = Mage::getModel('zmags/publication');
            $model->setData($data) ;



            if($data['publish_from'] != NULL )
            {

                $date = Mage::app()->getLocale()->date($data['publish_from'], Zend_Date::DATE_SHORT);
                $model->setPublishFrom($date->toString('YYYY-MM-dd 00:00:00'));


            }
            if($data['publish_end'] != NULL)
            {
                $date1 = Mage::app()->getLocale()->date($data['publish_end'], Zend_Date::DATE_SHORT);
                $model->setPublishEnd($date1->toString('YYYY-MM-dd 00:00:00'));

            }

            if($this->getRequest()->getParam('entity_id'))
            {
                $model->setEntityId($this->getRequest()->getParam('entity_id'));
            }
                //



            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                    $model->setPublishEnd(now());
                }






                if($model->save())
                {
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zmags')->__('Publication was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                }else{
                    throw new Mage_Core_Exception($this->__('Could not save'), 1);
                }
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $model->getEntityId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zmags')->__('Could not save item'));
        $this->_redirect('*/*/');
    }

    public function jsondataAction()
    {

        $config = array(
            'app_key'=> Mage::getStoreConfig( 'zmags/configuration/application_key' ),
            'customer_id'=>Mage::getStoreConfig( 'zmags/configuration/customer_id' ),
            'base_url'=>Mage::getStoreConfig( 'zmags/configuration/api_base_url' )
        );

            $this->zmags = new Zmags($config);

        $page = $this->getRequest()->getParam('page') ? $this->getRequest()->getParam('page'):1;

        $publications = $this->getPublicationsForPage($page);

        $json = array();

        $json['page'] = 1;
        $json['pages'] = count($this->getPublicationIds());

        foreach($publications as $k=>$pub)
        {
            //print_r($pub['bundle_info']->{1});exit();
            $json['publications'][$k] = array(
                'name'=> $pub['bundle_info']->publicationDescriptor->name,
                'thumb'=> $pub['publication_info']->baseURL. $pub['bundle_info']->{1}
                    ->pageRepresentationDescriptors[0]->pageRepresentation->resourcePath
            );
        }


        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Zend_Json::encode($json));


    }


    private function getPublicationIds()
    {



        $cacheKey = 'ZMAGS_PUBLICATION_IDS_' . Mage::app()->getStore()->getCode();
        $cache = Mage::app()->loadCache($cacheKey);

        if (Mage::app()->useCache('config') && $cache) {
            $publicationList = unserialize($cache);
        }else{

            $publicationList = array_chunk($this->zmags->getCustomerPublicationList(),10,true);

            if (Mage::app()->useCache('config')) {
                Mage::app()->saveCache(serialize($publicationList), $cacheKey, array('config'));
            }


        }

        return $publicationList;

    }

    private function getPublicationsForPage($page = null)
    {
        $page = (!$page) ? 1:$page;
        $cacheKey = 'ZMAGS_PUBLICATIONS_PAGE_' . Mage::app()->getStore()->getCode();
        $cache = Mage::app()->loadCache($cacheKey);
        if (Mage::app()->useCache('config') && $cache) {
            $publications = unserialize($cache);
        }else{
            $key = ($page - 1);
            $publicationIds = $this->getPublicationIds();

            $page = $publicationIds[$key];

            foreach($page as $k=>$v)
            {
                $page[$k]['publication_info'] = $this->zmags->getPublicationInfo($k);



                if ( isset( $page[$k]['publication_info']->publicationDescriptor) )
                {
                $path = $page[$k]['publication_info']->publicationDescriptor->bundlePath;

                $baseUrl = $page[$k]['publication_info']->baseURL;

                $page[$k]['bundle_info'] =  $this->zmags->api($path,null,$baseUrl);
                }else{
                    unset($page[$k]);
                }

            }

            $publications = $page;
        }

        return $publications;

    }




}
