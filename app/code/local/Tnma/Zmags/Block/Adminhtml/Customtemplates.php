<?php


class Tnma_Zmags_Block_Adminhtml_Customtemplates  extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_customtemplates';
        $this->_blockGroup = 'zmags';
        $this->_headerText = Mage::helper('zmags')->__('Custom Templates Manager');
        $this->_addButtonLabel = Mage::helper('zmags')->__('Add New Custom Template');
        parent::__construct();
    }
}
