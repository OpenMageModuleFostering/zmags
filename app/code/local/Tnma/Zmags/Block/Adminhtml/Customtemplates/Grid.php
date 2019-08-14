<?php


class Tnma_Zmags_Block_Adminhtml_Customtemplates_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customtemplatesGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);

    }


/*
    protected function _prepareCollection()
    {


        $collection = Mage::getModel('zmags/customtemplate')->getResourceCollection();
        $resource = Mage::getSingleton('core/resource');
        $this->setCollection($collection);
        var_dump($collection);
        return parent::_prepareCollection();
    }

*/
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('zmags/Customtemplate')->getResourceCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();

        if (!Mage::app()->isSingleStoreMode()) {
            $this->getCollection()->addStoreData();
        }

        return $this;
    }

    protected function _prepareColumns()
    {


        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('zmags')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

       /* $this->addColumn('template_id', array(
            'header'    => Mage::helper('zmags')->__('Template'),
            'align'     =>'left',
            'index'     => 'template_id',
            'width'     => '150px',
            'type'      => 'options',
            'options'   => array(
                1 => 'Test Template 1',
                0 => 'Test Template 2',
            ),
        ));*/
		
        $this->addColumn('template_name', array(
            'header'    => Mage::helper('zmags')->__('Template Name'),
            'width'     => '120px',
            'index'     =>'template_name'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('zmags')->__('Created'),
            'width'     => '120px',
            'index'     =>'created_time',
            'type'      =>'date'
        ));	
		
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('zmags')->__('Modified'),
            'width'     => '120px',
            'index'     =>'update_time',
            'type'      =>'date'
        ));	


        $this->addColumn('status', array(
            'header'    => Mage::helper('zmags')->__('Status'),
            'align'     =>'left',
            'index'     => 'status',
            'width'     => '75px',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                0 => 'Disabled',
            ),

        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('zmags')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('zmags')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'entity_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));






        //$this->addExportType('*/*/exportCsv', Mage::helper('zmags')->__('CSV'));
        //$this->addExportType('*/*/exportXml', Mage::helper('zmags')->__('XML'));

        return parent::_prepareColumns();

    }

    protected function _prepareMassaction()
    {


        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }

}
