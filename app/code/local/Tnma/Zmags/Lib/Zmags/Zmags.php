<?php
/**
 * Created by Wikus Verreynne.
 * Date: 2013/02/13
 * Time: 11:11 PM
 */

require_once "BaseZmags.php";


class Zmags extends BaseZmags
{

    protected $publications =array();

    /**
     * Identical to the parent constructor,
     *
     * @param Array $config the zmags configuration.
     * @see BaseFacebook::__construct in facebook.php
     */
    public function __construct($config)
    {
        parent::__construct($config);

    }

    /**
     * @param null $customer_id
     * @return array
     */
    public function getCustomerPublicationList($customer_id = null)
    {

        if(empty($this->publications))
        {
            $customer_id = ($customer_id) ? $customer_id : $this->getCustomerId();
            $path = "/publications/".$customer_id;
            foreach($this->api($path)->publicationIDs as $pubId)
            {
                $this->publications[$pubId]=array();
            }


        }

        return $this->publications;
    }


    public  function buildPublications()
    {
        foreach($this->publications as $pubId=>$v)
        {
            $this->publications[$pubId]['publication_info'] = $this->getPublicationInfo($pubId);
        }
    }

    /**
     * @param $publication_id
     * @return array
     */
    public function getPublicationInfo($publication_id)
    {
       $path ='/publication/'.$publication_id;

        return $this->api($path);
    }




    public function getPublications()
    {
        return $this->publications;
    }
}
