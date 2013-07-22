<?php
namespace Websoftwares;
/**
 * Avin class
 *
 * @link http://www.avin.cc/api-documentation
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
class Avin
{
    /**
     * $client
     * @var object
     */
    private $client = null;

    /**
     * __construct description
     * @param object $client the api client
     */
    public function __construct(AvinInterface $client = null)
    {
        if (! $client) {
            throw new AvinException('A client must be provided');
        }
        $this->client = $client;
    }

    /**
     * GetWineByAvin returns wines list
     *
     * @param  string  $avin  the avin number
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetWineByAvin($avin = null, $debug = false)
    {
        if (! $avin) {
            throw new AvinException('Please provide an AVIN code');
        }
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__, $avin);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return wines
        return $this->data(array(
            'wines' => $response->aml->wines->count  > 0
            ? $response->aml->wines->wine
            : array()
            )
        );
    }

    /**
     * GetWinesByName returns wines list
     *
     * @param  string  $name  the wine name
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetWinesByName($name = null, $debug = false)
    {
        if (! $name) {
            throw new AvinException('Please provide a Wine name');
        }
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__, $name);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return wines
        return $this->data(array(
            'wines' => $response->aml->wines->count  > 0
            ? $response->aml->wines->wine
            : array()
            )
        );
    }

    /**
     * GetCountries returns countries list
     *
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetCountries($debug = false)
    {
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return countries
        return $this->data(array(
            'countries' => $response->aml->countries->country
            )
        );
    }

    /**
     * GetWineTypes returns wine_types list
     *
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetWineTypes($debug = false)
    {
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return wine_types
        return $this->data(array(
            'wine_types' => $response->aml->wine_types->wine_type
            )
        );
    }

    /**
     * GetProducersByName returns producers list
     *
     * @param  string  $name  the producer name
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetProducersByName($name = null, $debug = false)
    {
        if (! $name) {
            throw new AvinException('Please provide a Producer name');
        }
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__, $name);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return producers
        return $this->data(array(
            'producers' => $response->aml->producers->count  > 0
            ? $response->aml->producers->producer
            : array()
            )
        );
    }

    /**
     * GetProducerByID returns producers list
     *
     * @param  int     $id    the producer id
     * @param  boolean $debug
     * @return mixed   ArrayObject|string
     */
    public function GetProducerByID($id = null, $debug = false)
    {
        if (! $id) {
            throw new AvinException('Please provide a Producer #ID');
        }
        // Create url for making the request
        $this->client->setUrl(__FUNCTION__, $id);

        // For testing
        if ($debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        $response = $this->client->execute();

        // Return producers
        return $this->data(array(
            'producers' => $response->aml->producers->count  > 0
            ? $response->aml->producers->producer
            : array()
            )
        );
    }

    /**
     * data returns wines|wine_types|countries|producers lists
     * @param  array       $data
     * @return ArrayObject
     */
    private function data(array $data = array())
    {
        return new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * __call overloading client methods
     * @param  string $method
     * @param  mixed  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (! method_exists($this,$method)) {
            call_user_func_array(array($this->client, $method), $args);

            return $this;
        }
    }
}
