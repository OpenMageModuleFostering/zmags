<?php


/**
 *
 *@method Tnma_Zmags_Model_Resource_Publication getResource()
 */

class Tnma_Zmags_Model_Customtemplate extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
         $this->_init('zmags/customtemplate');
    }


    public function toOptionArray()
    {
        $options = array();
        $options[] = array('value'=>'default','label'=> "Use site default");

        $collection = $this->getCollection();



        //$collection->load();

        foreach($collection as $template)
        {
            $options[] = array('value'=>$template->getEntityId(), 'label'=>$template->getTemplateName()) ;
        }

        return $options;
    }

}
