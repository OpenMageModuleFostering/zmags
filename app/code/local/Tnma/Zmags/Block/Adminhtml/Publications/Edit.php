<?php
/**
 * Publication edit form
 *
 * @category   Tnma
 * @package    Tnma_Zmags
 * @author      Wikus Verreynne <wikus@tnma.co.za>
 */

class Tnma_Zmags_Block_Adminhtml_Publications_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {


        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_publications';
        $this->_blockGroup = 'zmags';

        $this->_updateButton('save', 'label', Mage::helper('zmags')->__('Save Publication'));
        //$this->_updateButton('delete', 'label', Mage::helper('zmags')->__('Delete Publication'));


        parent::__construct();

       // $this->setValidationUrl($this->getUrl('*/*/validate', array('entity_id' => $this->getRequest()->getParam($this->_objectId))));
    }

    public function getHeaderText()
    {
        if( Mage::registry('publication_data') && Mage::registry('publication_data')->getId() ) {
            return Mage::helper('zmags')->__("Edit Publication '%s'", $this->htmlEscape(Mage::registry('publication_data')->getTitle()));
        } else {
            return Mage::helper('zmags')->__('New Publication');
        }
    }



}
