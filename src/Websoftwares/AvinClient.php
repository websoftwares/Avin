<?php
namespace Websoftwares;
/**
 * AvinClient class
 * Client for interacting with the avin.cc JSON RESTful api.
 * @link http://www.avin.cc/api-documentation
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
class AvinClient implements AvinInterface
{
    CONST API_VERSION = 'v1.0';

    /**
     * @var string
     */
    protected $baseUrl = "http://api.avin.cc/rest";
    /**
     * @var array
     */
    protected $curlOptions = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR => true,
        CURLOPT_URL => '',
        CURLOPT_USERAGENT => 'Websoftwares Avin PHP api client'
        );
    /**
     * @var string
     */
    protected $url = null;

    /**
     * @var array
     */
    protected $filter = array();

    /**
     * __construct
     * @param string $apiKey
     */
    public function __construct($apiKey = null)
    {
        if (! $apiKey) {
            throw new AvinException('An apiKey must be provided');
        }
        // Set API key
        $this->setFilter('key', $apiKey);
        // Only interacting with the JSON Api
        $this->setFilter('format', 'json');
    }

    /**
     * setUrl
     * @return string
     */
    public function setUrl($method, $argument = null)
    {
        // Start with blank url
        $this->url = '';
        $appendix =  '/';
        // Create url
        $this->url .= $this->getBaseUrl() . $appendix;
        $this->url .= self::API_VERSION . $appendix;

        if ($argument) {
            $this->url .=  $method . $appendix . rawurlencode($argument) . $appendix;
        } else {
            $this->url .=  $method . $appendix;
        }
        // Get filters and append
        $this->url .= '&' . $this->buildQueryString($this->getFilter());

        return $this;
    }

    /**
     * getUrl
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Getter for curlOptions
     *
     * @return array
     */
    protected function getCurlOptions()
    {
        $this->curlOptions[CURLOPT_URL] = $this->getUrl();

        return $this->curlOptions;
    }

    /**
     * getBaseUrl
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * buildQueryString
     *
     * @param $params array
     * @return string
     */
    protected function buildQueryString(array $params = array())
    {
        return http_build_query($params, null, '&');
    }

    /**
     * execute
     *
     * @return mixed
     */
    public function execute()
    {
        // Get curl options
        $curlOptions = $this->getCurlOptions();

        // Init curl
        $curl = curl_init();

        // Set options
        curl_setopt_array($curl, $curlOptions);

        // Execute and save response to $response
        if (!$response = curl_exec($curl)) {
            throw new AvinException('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }

        // Close request to clear up some resources
        curl_close($curl);

        // Decode response result
        $result = json_decode($response);

        // Invalid response
        if ($result->response->stat === 'KO') {
            throw new AvinException($result->response->aml->error->message);
        }

        return $result->response;
    }

    /**
     * Getter for filter
     *
     * @return mixed
     */
    protected function getFilter()
    {
        return $this->filter;
    }

    /**
     * Setter for filter
     * for a complete list of available filters:
     * @link http://www.avin.cc/api-documentation
     *
     * @param $key the filter name
     * @param $value the filter value
     * @return self
     */
    public function setFilter($key = null, $value = null)
    {
        $this->filter[$key] = $value;

        return $this;
    }

    /**
     * clearFilter empties filters
     * @return self
     */
    public function clearFilter()
    {
       // Get current filters extract key and format
        $current = $this->getFilter();

        $this->filter = array(
            'key' => isset($current['key']) ? $current['key'] : null,
            'format' => isset($current['format']) ? $current['format'] : null,
        );

        return $this;
    }
}
