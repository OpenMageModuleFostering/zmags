<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Wickass
 * Date: 2013/02/19
 * Time: 1:44 PM
 * To change this template use File | Settings | File Templates.
 */
class Tnma_Zmags_Block_Adminhtml_Publications_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $html = '<img width="50"';
        $html .= 'id="' . $row->getEntityId() . '" ';
        $html .= 'src="' . $row->getThumb() . '"';
        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        $html .= '<span>'.$row->getPublicationId().'</span>';
        return $html;
    }

}
