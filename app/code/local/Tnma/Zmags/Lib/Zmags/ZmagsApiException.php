<?php
/**
 * Created by Wikus Verreynne.
 * Date: 2013/02/13
 * Time: 10:58 PM
 */


if (!function_exists('curl_init')) {
    throw new Exception('Zmags needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Zmags needs the JSON PHP extension.');
}


class ZmagsApiException extends  Exception
{
    /**
     * The result from the API server that represents the exception information.
     */
    protected $result;

    /**
     * Make a new API Exception with the given result.
     *
     * @param array $result The result from the API server
     */
    public function __construct($result)
    {
        $this->result = $result;
        $code = isset($result['error_code']) ? $result['error_code'] : 0;

        if (isset($result['error_msg'])) {
            // Rest server style
            $msg = $result['error_msg'];
        } else {
            $msg = 'Unknown Error. Check getResult()';
        }

        parent::__construct($msg, $code);

    }



    /**
     * To make debugging easier.
     *
     * @return string The string representation of the error
     */
    public function __toString() {
        $str = $this->getType() . ': ';
        if ($this->code != 0) {
            $str .= $this->code . ': ';
        }
        return $str . $this->message;
    }
}
