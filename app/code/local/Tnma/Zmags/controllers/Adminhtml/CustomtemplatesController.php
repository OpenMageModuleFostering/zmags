<?php

class Tnma_Zmags_Adminhtml_CustomtemplatesController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('zmags/customtemplates')
            ->_addBreadcrumb(Mage::helper('zmags')->__('Custom Templates Manager'), Mage::helper('zmags')->__('Custom Templates Manager'));

        return $this;
    }


    public function indexAction() {
        $this->_initAction()
            ->renderLayout();

    }


    public function deleteAction()
    {

        $entityId     = $this->getRequest()->getParam('entity_id');
        $customtemplateModel  = Mage::getModel('zmags/customtemplate')->load($entityId);

        $customtemplateModel->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zmags')->__('Template Deleted'));
        $this->_redirect('*/*/');



    }


	public function newAction()
    {
        $this->getRequest()->setParam('entity_id', 0);
        $this->_forward('edit');
    }
	
    public function editAction()
    {
        $this->_title($this->__('ZMags'))->_title($this->__('Custom Templates'));

        $entityId     = $this->getRequest()->getParam('entity_id');
        $customtemplateModel  = Mage::getModel('zmags/customtemplate')->load($entityId);

        if ($customtemplateModel->getEntityId() || $entityId == 0) {
            $this->_title($customtemplateModel->getEntityId() ? $customtemplateModel->getTitle() : $this->__('New Custom Template'));

            Mage::register('customtemplate_data', $customtemplateModel);

            $this->loadLayout();
            $this->_setActiveMenu('zmags/customtemplates');
            $this->_addBreadcrumb(Mage::helper('zmags')->__('Custom Template Manager'), Mage::helper('zmags')->__('Custom Template Manager'), $this->getUrl('*/*/'));
            $this->_addBreadcrumb(Mage::helper('zmags')->__('Edit Custom Template'), Mage::helper('zmags')->__('Edit Custom Template'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('zmags/adminhtml_customtemplates_edit'))
                    ->_addLeft($this->getLayout()->createBlock('zmags/adminhtml_customtemplates_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zmags')->__('The custom template does not exist.'));
            $this->_redirect('*/*/');
        }
    }
    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return void
     */
    public function gridAction()
    {
        $this->_registryObject();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('zmags/adminhtml_customtemplates_edit_tab_product')
                ->toHtml()
        );
    }

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return void
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
		
		$data = ($this->getRequest()->getParam('general'));
		//print_r($data);
		
            $model = Mage::getModel('zmags/customtemplate');
            $model->setData($data) ;
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
                }

				//print_r($model);
				//$die();
                if($model->save())
                {
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zmags')->__('Colour Template was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                }else{

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







	
    /**
     * registry form object
     */
    protected function _registryObject()
    {
//        Mage::register('zmags', Mage::getModel('zmags/form'));
    }

}