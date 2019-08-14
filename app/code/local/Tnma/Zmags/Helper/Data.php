<?php
/**
 *
 * @category    Tnma
 * @package     Tnma_Zmags
 * @copyright   Copyright (c) 2013 Tnm Agency (http://www.tnma.co.za)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Zmags data helper
 */
class Tnma_Zmags_Helper_Data extends Mage_Core_Helper_Abstract
{


    static function isMobile()

    {

        if(empty($_SERVER['HTTP_USER_AGENT']))
        {
            return false;
        }

        $agents = "iPhone|iPod|BlackBerry|Pre|Palm|Googlebot-Mobile|mobi|Safari Mobile|Windows Mobile|Android|Opera Mini|mobile|IEMobile|BB10";

        $regexp = '/' . trim($agents, '/') . '/';

        if (@preg_match($regexp, $_SERVER['HTTP_USER_AGENT'])) {

            return true;
        }


        return false;
    }
}