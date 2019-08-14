<?php

class Tnma_Zmags_Block_Adminhtml_Customtemplates_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare form in tab
     */

    protected function _prepareForm()
    {
	
	
        $helper = Mage::helper('zmags');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('general_');
        $form->setFieldNameSuffix('general');

        $fieldset = $form->addFieldset('display', array(
            'legend'       => $helper->__('Display Settings'),
            'class'        => 'fieldset-wide',
        ));
		
        $fieldset->addField('template_name', 'text', array(
            'name'         => 'template_name',
            'label'        => $helper->__('Template Name'),
			'class'        => 'required-entry',
			'required'     => true,
			'style'        => 'width:200px !important',
        ));
		
        $fieldset->addField('background', 'text', array(
            'name'         => 'background',
            'label'        => $helper->__('Background Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
        $fieldset->addField('product_name', 'text', array(
            'name'         => 'product_name',
            'label'        => $helper->__('Product Name Colour'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        $fieldset->addField('heading_colors', 'text', array(
            'name'         => 'heading_colors',
            'label'        => $helper->__('Heading Colours'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        $fieldset->addField('border_width', 'text', array(
            'name'         => 'border_width',
            'label'        => $helper->__('Container Border Width (px)'),
            'class'        => 'required-entrys',
            'required'     => true,
            'style'        => 'width:25px !important',
        ));


        $fieldset->addField('border_color', 'text', array(
            'name'         => 'border_color',
            'label'        => $helper->__('Container Border Colour'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        $fieldset->addField('border_radius', 'text', array(
            'name'         => 'border_radius',
            'label'        => $helper->__('Container Border Radius (px)'),
            'class'        => 'required-entry',
            'required'     => true,
            'style'        => 'width:25px !important',
        ));

        //thumbnail styles

        $fieldset->addField('tn_border_width', 'text', array(
            'name'         => 'tn_border_width',
            'label'        => $helper->__('Thumbnail Border Width (px)'),
            'class'        => 'required-entrys',
            'required'     => true,
            'style'        => 'width:25px !important',
        ));


        $fieldset->addField('thumbnail_border', 'text', array(
            'name'         => 'thumbnail_border',
            'label'        => $helper->__('Thumbnail Border Colour'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        $fieldset->addField('tn_border_radius', 'text', array(
            'name'         => 'tn_border_radius',
            'label'        => $helper->__('Thumbnail Border Radius (px)'),
            'class'        => 'required-entry',
            'required'     => true,
            'style'        => 'width:25px !important',
        ));

        //description background color
        $fieldset->addField('description_background', 'text', array(
            'name'         => 'description_background',
            'label'        => $helper->__('Description Background'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        //data table rows
        $fieldset->addField('data_table_odd', 'text', array(
            'name'         => 'data_table_odd',
            'label'        => $helper->__('Table Odd Row'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        $fieldset->addField('data_table_even', 'text', array(
            'name'         => 'data_table_even',
            'label'        => $helper->__('Table Even Row'),
            'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
            'required'     => true,
            'style'        => 'width:100px !important',
        ));

        //general text color
        $fieldset->addField('text', 'text', array(
            'name'         => 'text',
            'label'        => $helper->__('Text Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
		
		$fieldset->addField('link', 'text', array(
            'name'         => 'link',
            'label'        => $helper->__('Link Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
		
        $fieldset->addField('hover', 'text', array(
            'name'         => 'hover',
            'label'        => $helper->__('Hover Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
		

		
        $fieldset->addField('special_price', 'text', array(
            'name'         => 'special_price',
            'label'        => $helper->__('Special Price Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
		
        $fieldset->addField('addtocart_bg', 'text', array(
            'name'         => 'addtocart_bg',
            'label'        => $helper->__('Add to Cart BG Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));

        $fieldset->addField('addtocart_font', 'text', array(
            'name'         => 'addtocart_font',
            'label'        => $helper->__('Add to Cart Colour'),
			'class'        => 'required-entry color{pickerPosition:\'right\',pickerClosable:true}',
			'required'     => true,
			'style'        => 'width:100px !important',
        ));
		


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
		
        if (Mage::registry('customtemplate_data')) {
            $form->setValues(Mage::registry('customtemplate_data')->getData());
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }

}