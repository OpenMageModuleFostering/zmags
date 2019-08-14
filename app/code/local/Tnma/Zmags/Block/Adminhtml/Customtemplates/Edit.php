<?php

class Tnma_Zmags_Block_Adminhtml_Customtemplates_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Constructor
     */
    public function __construct()
    {


        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_customtemplates';
        $this->_blockGroup = 'zmags';

        $this->_updateButton('save', 'label', Mage::helper('zmags')->__('Save Custom Template'));
        $this->_updateButton('delete', 'label', Mage::helper('zmags')->__('Delete Custom Template'));
        parent::__construct();
       // $this->setValidationUrl($this->getUrl('*/*/validate', array('entity_id' => $this->getRequest()->getParam($this->_objectId))));
    }

    public function getHeaderText()
    {
        if( Mage::registry('customtemplate_data') && Mage::registry('customtemplate_data')->getId() ) {
            return Mage::helper('zmags')->__("Edit Custom Template '%s'", $this->htmlEscape(Mage::registry('customtemplate_data')->getTemplateName()));
        } else {
            return Mage::helper('zmags')->__('New Custom Template');
        }
    }
}
