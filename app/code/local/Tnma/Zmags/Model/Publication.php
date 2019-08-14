<?php


/**
 *
 *@method Tnma_Zmags_Model_Resource_Publication getResource()
 */

class Tnma_Zmags_Model_Publication extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
         $this->_init('zmags/publication');
    }



    public function gethasExpired()
    {
        $now = date('Y-m-d h:i:s');
        if( $this->getPublishEnd() && ($now > $this->getPublishEnd() ))
        {
            return true;
        }
        return false;
    }

    public function getHasStatrted()
    {
        $now = date('Y-m-d h:i:s');

        if($now > $this->getPublishFrom())
        {
            return true;
        }

        return false;
    }

}
