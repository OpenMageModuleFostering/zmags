<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/28
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */


class Tnma_Zmags_Block_Css extends Mage_Core_Block_Template
{





    /**
     * @return Tnma_Zmags_Model_Customtemplate
     */
    public function getZmagsTemplate()
    {

        return Mage::registry('zmag_template');
    }

}