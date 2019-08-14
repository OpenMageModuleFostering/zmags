<?php

/**
* Pool Mysql4 collection model resource
*
* @category    Tnma
* @package     Tnma_Zmags
* @author      Wikus Verreynne <wikus@tnma.co.za>
 */
class Tnma_Zmags_Model_Resource_Publication_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Initialize collection
     *
     */
    public function _construct()
    {
        $this->_init('zmags/publication');
    }


    public function addStoreData()
    {
        return $this;
    }
}