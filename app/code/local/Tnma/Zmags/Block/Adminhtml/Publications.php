<?php


class Tnma_Zmags_Block_Adminhtml_Publications  extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_publications';
        $this->_blockGroup = 'zmags';
        $this->_headerText = Mage::helper('zmags')->__('Publications Manager');
        $this->_addButtonLabel = Mage::helper('zmags')->__('Add New Publication');
        parent::__construct();
    }
}
