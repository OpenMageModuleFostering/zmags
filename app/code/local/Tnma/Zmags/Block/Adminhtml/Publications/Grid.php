<?php


class Tnma_Zmags_Block_Adminhtml_Publications_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('publicationsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);

    }


/*
    protected function _prepareCollection()
    {


        $collection = Mage::getModel('zmags/publication')->getResourceCollection();
        $resource = Mage::getSingleton('core/resource');
        $this->setCollection($collection);
        var_dump($collection);
        return parent::_prepareCollection();
    }

*/
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('zmags/Publication')->getResourceCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();

        if (!Mage::app()->isSingleStoreMode()) {
            $this->getCollection()->addStoreData();
        }

        return $this;
    }

    protected function _prepareColumns()
    {


        /*$this->addColumn('entity_id', array(
            'header'    => Mage::helper('zmags')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));*/

        $this->addColumn('thumb', array(
            'header'    => Mage::helper('zmags')->__('Publication'),
            'renderer'  => 'zmags/adminhtml_publications_renderer_image',
            'width'     => '50px',
            'index'     =>'publication_id'

        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('zmags')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
            'width'     => '250px',
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

        /*$this->addColumn('custom_root_template', array(
            'header'    => Mage::helper('zmags')->__('Layout'),
            'align'     =>'left',
            'index'     => 'custom_root_template',
            'width'     => '75px',
            'type'      => 'options',
            'options'   => Mage::getSingleton('page/source_layout')->getOptions(),

        ));
          */


        $this->addColumn('publish_from', array(
            'header'    => Mage::helper('zmags')->__('Published From'),
            'width'     => '120px',
            'index'     =>'publish_from',
            'type'      =>'date'
        ));

        $this->addColumn('publish_end', array(
            'header'    => Mage::helper('zmags')->__('Published Until'),
            'width'     => '120px',
            'index'     =>'publish_end',
            'type'      =>'date'
        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('zmags')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getEntityId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('zmags')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'entity_id'
                    ),
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

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('zmags')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        // public function massDeleteAction()
            'confirm' => Mage::helper('zmags')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }

}
