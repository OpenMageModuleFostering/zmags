<?php

/**
 * Poll edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Wikus Verreynne <wikus@tnma.co.za>
 */

class Tnma_Zmags_Block_Adminhtml_Publications_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $pubs =   $form->addFieldset('select_publication',array('legend'=>Mage::helper('zmags')->__('Select Publication')));
        $pubs->addType('publication_selector','Tnma_Zmags_Lib_Varien_Data_Form_Element_Publication_Selector');
        $pubs->addField('publication_id', 'publication_selector', array(
            'label'     => Mage::helper('zmags')->__('Publication ID'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'publication_id',
        ));

        $fieldset = $form->addFieldset('publication_form', array('legend'=>Mage::helper('zmags')->__('Publication information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('zmags')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
        $fieldset->addField('slug', 'text', array(
            'label'     => Mage::helper('zmags')->__('Choose slug'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'slug',
        ));


        $fieldset->addField('height', 'text', array(
            'label'     => Mage::helper('zmags')->__('Publication height'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'height',
        ));



        /*$fieldset->addField('template_id', 'select', array(
            'label'     => Mage::helper('zmags')->__('Choose template'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'template_id',
            'values'    => array(
                array(
                    'value'     => '',
                    'label'     => Mage::helper('zmags')->__('Please Select'),
                ),
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('zmags')->__('Test template'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('zmags')->__('Test template 2'),
                ),
            ),

        ));
        */


        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('zmags')->__('Status'),
            'name'      => 'status',
            'required'  => true,
            'values'    => array(
                array(
                    'value'     => '',
                    'label'     => Mage::helper('zmags')->__('Please Select'),
                ),
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('zmags')->__('Enabled'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('zmags')->__('Disabled'),
                ),
            ),
        ));


        $dateFormatIso = Mage::app()->getLocale() ->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);;


        $fieldset->addField('publish_from', 'date', array(
            'label'     => Mage::helper('zmags')->__('Publish From'),
            'name'      => 'publish_from',
            'format'       => $dateFormatIso,
            'value' => 'publish_from',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
        ));


        $fieldset->addField('publish_end', 'date', array(
            'label'     => Mage::helper('zmags')->__('Publish Until'),
            'name'      => 'publish_end',

            'format'       => $dateFormatIso,
            'value'=> 'publish_end',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
        ));


       /* $fieldset->addField('custom_theme', 'select', array(
            'name'      => 'custom_theme',
            'label'     => Mage::helper('cms')->__('Custom Theme'),
            'values'    => Mage::getModel('core/design_source_design')->getAllOptions(),
            'disabled'  => false
        ));


        $fieldset->addField('custom_root_template', 'select', array(
            'name'      => 'custom_root_template',
            'label'     => Mage::helper('zmags')->__('Custom Layout'),
            'values'    => Mage::getSingleton('page/source_layout')->toOptionArray(true),
            'disabled'  => false
        ));

         */




        $fieldset->addField('thumb', 'hidden', array(

            'name'      => 'thumb',
        ));





        $form->setValues(Mage::registry('publication_data')->getData());




        $this->setForm($form);
        return parent::_prepareForm();
    }
}