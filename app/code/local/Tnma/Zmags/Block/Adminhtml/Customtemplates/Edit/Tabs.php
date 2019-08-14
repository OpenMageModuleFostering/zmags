<?php

class Tnma_Zmags_Block_Adminhtml_Customtemplates_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('edit_home_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('zmags')->__('Zmags template'));
    }

    /**
     * add tabs before output
     *
     * @return Tnma_Zmags_Block_Adminhtml_Form_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $this->addTab('general', array(
            'label'     => Mage::helper('zmags')->__('General'),
            'title'     => Mage::helper('zmags')->__('General'),
            'content'   => $this->getLayout()
                ->createBlock('zmags/adminhtml_customtemplates_edit_tab_general')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}