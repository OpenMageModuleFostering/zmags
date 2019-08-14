<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/22
 * Time: 3:34 PM
 * To change this template use File | Settings | File Templates.
 */


class Tnma_Zmags_Block_Show extends Mage_Core_Block_Template
{



    /**
     * Retrieve current product model
     *
     * @return Tnma_Zmags_Model_Publication
     */
    public function getPublication()
    {

        if (!Mage::registry('publication') && $this->getPublicationId()) {
            $publication = Mage::getModel('zmags/publication')->load($this->getPublicationId());
            Mage::register('publication', $publication);

        }
        return Mage::registry('publication');
    }
}