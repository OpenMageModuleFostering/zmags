<?php

class Tnma_Zmags_Lib_Varien_Data_Form_Element_Publication_Selector extends Varien_Data_Form_Element_Abstract
{
    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('hidden');


    }


    /**
     * Return element html code
     *
     * @return string
     */
    public function getElementHtml()
    {


        $mod = Mage::registry('publication_data');

        $img = $mod->getThumb();
        $title = $mod->getTitle();
        if($img)
        {
            $drop ='<div class="thumbnail well-nice"><img src="'.$img.'" /><p>'.$title.'</p></div>';
        }else{
            $drop ="Drop Here";
        }
        //$this->setTemplate('test.phtml');
        //$this->getLayout()->createBlock('zmags/adminhtml_publications_edit_tab_wiki')->toHtml();

        $appkey = Mage::getStoreConfig( 'zmags/configuration/application_key' );
        $customer_id = Mage::getStoreConfig( 'zmags/configuration/customer_id' );
        $base_url =  Mage::getStoreConfig( 'zmags/configuration/api_base_url' );
        $html='';
        $html .='<div class="grid"><table class="data"><thead><tr class="headings"><td></td><th class="pager">'

            .'Page<img id="previous" class="arrow" alt="Go to Previous page" src="/skin/adminhtml/default/default/images/tnma/pager_arrow_left.gif">'

            .'<input type="text" id="currpage" onkeypress="" class="input-text page" value="1"  name="page">'

            .'<img id="next" class="arrow" alt="Go to Next page" src="/skin/adminhtml/default/default/images/tnma/pager_arrow_right.gif">'

            .'of <span id="pagetotal">1</span> pages <span class="separator">|</span>'

            .'Total <span id="listtotal">0</span> records found</th>'
            .'<th><label>Search</label> <input placeholder="Publication ID" type="text" id="search" value="" /> <button id="search_but" class="scalable " style="" onclick="findPubById($(\'search\').value);" type="button" title="Reset">'
            .'<span><span><span>Search</span></span></span></button>'
        .'</th></tr></thead>';
        $html .="<tr><td><div class='widget widget-box'><div class='widget-content'><div id='drop_here' class='widget-body'>{$drop}</div></div></div></td>";
        $html .= '<td colspan="2"><div id="publications_container" class="thumbnails"></div></td></tr></table></div>';
        $html .= parent::getElementHtml();
        //$html .= $this->_getDeleteCheckbox();
        $html .=<<<EndSCRIPT
<script type="text/javascript">


    jQuery(document).ready(function(){
          loadPublications('{$base_url}/publications/{$customer_id}?key={$appkey}',"{$appkey}","{$base_url}");

         Droppables.add("drop_here", {
            accept: 'draggable',
            hoverclass: 'hover',
            onDrop: function(el) {

                 var copy = $(el).clone(true);
                 console.log(copy);
                 $(copy).removeClassName('draggable');
                 $(copy).setStyle({left:'5px',top:'15px',opacity:1 });
                $(copy).id = "active_"+$(copy).id;
                $('drop_here').update(copy);
                $('drop_here').highlight();

                $('publication_id').value =  el.id;
                var img = $('img_'+el.id).src;

                $('thumb').value = img;

                var publication = publications[el.id];

                var title = publication.bundle_data.publicationDescriptor.name;

                $('title').value = title;
                $('slug').value = slugify(title);
        }
});
    });


</script>
EndSCRIPT;

        return $html;
    }
}