<?php
/**
 * Admin publications left menu
 *
 * @category   Tnma
 * @package    Tnma_Zmags
 * @author      Wikus Verreynne <wikus@tnma.co.za>
 */
class Tnma_Zmags_Block_Adminhtml_Publications_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('publication_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('zmags')->__('Publication Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('zmags')->__('Publication Information'),
            'title'     => Mage::helper('zmags')->__('Publication Information'),
            'content'   => $this->getLayout()->createBlock('zmags/adminhtml_publications_edit_tab_form')->toHtml(),
        ));


       /* $this->addTab('template_section', array(
            'label'     => Mage::helper('zmags')->__('Poll Answers'),
            'title'     => Mage::helper('zmags')->__('Poll Answers'),
            'content'   => $this->getLayout()->createBlock('zmags/publication_edit_tab_publication')
                ->append($this->getLayout()->createBlock('zmags/publication_edit_tab_template'))
                ->toHtml(),
            'active'    => ( $this->getRequest()->getParam('tab') == 'template_section' ) ? true : false,
        ));      */
        return parent::_beforeToHtml();
    }
}