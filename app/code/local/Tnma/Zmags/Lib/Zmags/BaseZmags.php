<?php
/**
 * Created by Wikus Verreynne.
 * Date: 2013/02/13
 * Time: 10:13 PM

 */

require_once "ZmagsApiException.php";

abstract class BaseZmags
{
    /**
     * Version.
     */
    const VERSION = '0.0.1';

    /**
     * The Application Key.
     *
     * @var string
     */
    protected $appKey;


    /**
     * The Customer ID.
     *
     * @var string
     */
    protected $customerId;


    /**
     * The Base Url.
     *
     * @var string
     */
    protected $baseUrl;


    /**
     * Default options for curl.
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'zmags-php',
    );



    /**
     * Initialize a Zmags.
     *
     * The configuration:
     * - app_key: the application Key
     * - base_url: Base url for api calls
     * - customer_id: Customer Id for acessing customer publications
     *
     * @param array $config The application configuration
     */
    function __construct($config)
    {
        $this->setAppKey( $config['app_key'] );
        $this->setBaseUrl( $config['base_url'] );;
        $this->setCustomerId( $config['customer_id'] );
    }


    /**
     * @param string $appKey
     */
    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * @return string
     */
    public function getAppKey()
    {
        return $this->appKey;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }


    /**
     * @param $path
     * @param null $params
     * @return array
     */
    public function api( $path, $params = null,$baseUrl = null)
    {
        $params['key'] = $this->getAppKey();

        if(!$baseUrl)
        {
            $baseUrl = $this->getBaseUrl();
        }


        if(!empty($params) && $params)
        {
            $params = "?".http_build_query($params);
        }else{
         $params = "";
        }

        $url = $baseUrl.$path.$params;

        $result =  $this->makeRequest($url,$params);

        return json_decode( $result );
    }

    /**
     * Makes an HTTP request. This method can be overridden by subclasses if
     * developers want to do fancier things or use something other than curl to
     * make the request.
     *
     * @param string $url The URL to make the request to
     * @param array $params The parameters to use for the request
     * @param CurlHandler $ch Initialized curl handle
     *
     * @return string The response text
     */
    protected function makeRequest($url, $params, $ch=null) {
        if (!$ch) {
            $ch = curl_init();
        }

        $opts = self::$CURL_OPTS;
       /* if ($this->getFileUploadSupport()) {
            $opts[CURLOPT_POSTFIELDS] = $params;
        } else {
            $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        }
       */

        $opts[CURLOPT_URL] = $url;

        // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
        // for 2 seconds if the server does not support this header.
        if (isset($opts[CURLOPT_HTTPHEADER])) {
            $existing_headers = $opts[CURLOPT_HTTPHEADER];
            $existing_headers[] = 'Expect:';
            $opts[CURLOPT_HTTPHEADER] = $existing_headers;
        } else {
            $opts[CURLOPT_HTTPHEADER] = array('Expect:');
        }

        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);

        if (curl_errno($ch) == 60) { // CURLE_SSL_CACERT
            self::errorLog('Invalid or no certificate authority found, '.
                'using bundled information');
            curl_setopt($ch, CURLOPT_CAINFO,
                dirname(__FILE__) . '/zm_ca_chain_bundle.crt');
            $result = curl_exec($ch);
        }

        // With dual stacked DNS responses, it's possible for a server to
        // have IPv6 enabled but not have IPv6 connectivity. If this is
        // the case, curl will try IPv4 first and if that fails, then it will
        // fall back to IPv6 and the error EHOSTUNREACH is returned by the
        // operating system.
        if ($result === false && empty($opts[CURLOPT_IPRESOLVE])) {
            $matches = array();
            $regex = '/Failed to connect to ([^:].*): Network is unreachable/';
            if (preg_match($regex, curl_error($ch), $matches)) {
                if (strlen(@inet_pton($matches[1])) === 16) {
                    self::errorLog('Invalid IPv6 configuration on server, '.
                        'Please disable or get native IPv6 on your server.');
                    self::$CURL_OPTS[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
                    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                    $result = curl_exec($ch);
                }
            }
        }

        if ($result === false) {
            $e = new ZmagsApiException(array(
                'error_code' => curl_errno($ch),
                'error' => array(
                    'message' => curl_error($ch),
                    'type' => 'CurlException',
                ),
            ));
            curl_close($ch);
            throw $e;
        }
        curl_close($ch);
        return $result;
    }



}
