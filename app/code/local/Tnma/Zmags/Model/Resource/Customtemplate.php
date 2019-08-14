<?php


/**
* customtemplate Mysql4 resource model
*
* @category    Tnma
* @package     Tnma_Zmags
* @author      Wikus Verreynne <wikus@tnma.co.za>
 */
class Tnma_Zmags_Model_Resource_Customtemplate extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Initialize resource
     *
     */
    protected function _construct()
    {
        $this->_init('zmags/customtemplate', 'entity_id');
    }

}