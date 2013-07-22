<?php
use Websoftwares\AvinClient;
/**
 * Class AvinClientTest
 * Provide a valid api key to test the 'online' tests.
 */
class AvinClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Taken from the documentation found @link http://www.avin.cc/api-documentation/
     * The AVIN API requires a developer key which you can ask us using this email address: info@avin.cc.
     */
    CONST VALID_KEY = '';
    CONST TEST_KEY  = '123456789UnitTestKey';

    /**
     * $debug
     * @var boolean
     */
    private $debug = true;

    /**
     * $reflection
     * @var object
     */
    protected $reflection;

    public function setUp()
    {
        if (! self::VALID_KEY) {
            $this->avinClient = new AvinClient(self::TEST_KEY);
        } else {
            $this->avinClient = new AvinClient(self::VALID_KEY);
            $this->debug = false;
        }
        $this->reflection = new \ReflectionClass($this->avinClient);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\AvinClient', $this->avinClient);
    }

    public function testPropertiesSucceeds()
    {
        $baseUrl = 'http://api.avin.cc/rest';
        $this->setProperty('baseUrl', $baseUrl);
        $this->assertEquals($baseUrl, $this->getProperty('baseUrl'));

        $curlOptions = array('1','2','3', 'TEST');
        $this->setProperty('curlOptions', $baseUrl);
        $this->assertEquals($baseUrl, $this->getProperty('curlOptions'));

        $url = 'this.is.a.test.to';
        $this->setProperty('url', $url);
        $this->assertEquals($url, $this->getProperty('url'));

        $filter = array('key', 'value');
        $this->setProperty('filter', $filter);
        $this->assertEquals($filter, $this->getProperty('filter'));
    }

    public function testSetUrlSucceeds()
    {
        $actual = $this->avinClient->setUrl('getTheUnitTestMethod', 'ExpectedResult');
        $key = self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY;
        $expected = 'http://api.avin.cc/rest/v1.0/getTheUnitTestMethod/ExpectedResult/&key='.$key.'&format=json';
        $this->assertEquals($expected, $this->getProperty('url'));
    }

    public function testGeturlSucceeds()
    {
        $actual = $this->avinClient->setUrl('getTheUnitTestMethod', 'ExpectedResult');
        $key = self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY;
        $expected = 'http://api.avin.cc/rest/v1.0/getTheUnitTestMethod/ExpectedResult/&key='.$key.'&format=json';
        $this->assertEquals($expected, $this->avinClient->getUrl());
    }

    public function testGetCurlOptionsSucceeds()
    {
        $expected = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => true,
            CURLOPT_URL => '',
            CURLOPT_USERAGENT => 'Websoftwares Avin PHP api client'
        );
        $method = $this->getMethod('getCurlOptions');
        $actual = $method->invoke($this->avinClient);
        $this->assertEquals($expected,$actual);
    }

    public function testGetBaseUrlSucceeds()
    {
        $expected = "http://api.avin.cc/rest";
        $method = $this->getMethod('getBaseUrl');
        $actual = $method->invoke($this->avinClient);
        $this->assertEquals($expected,$actual);
    }

    public function testBuildQueryStringSucceeds()
    {
        $expected = "foo=bar";
        $method = $this->getMethod('BuildQueryString');
        $actual = $method->invoke($this->avinClient, array('foo' => 'bar'));
        $this->assertEquals($expected,$actual);
    }

    public function testSetGetClearFilterSucceeds()
    {
        $expected  = array('PHPUnit' => 'Test', 'key' => self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY, 'format' => 'json');
        $cleared = array('key' => self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY, 'format' => 'json');

        $this->avinClient->setFilter('PHPUnit', 'Test');
        $method = $this->getMethod('getFilter');
        $this->assertEquals($expected,$method->invoke($this->avinClient));

        $this->avinClient->clearFilter();
        $this->assertEquals($cleared,$method->invoke($this->avinClient));
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testInstantiateAsObjectFails()
    {
        new AvinClient;
    }

    public function getMethod($method)
    {
        $method = $this->reflection->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }

    public function getProperty($property)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($this->avinClient);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->avinClient, $value);
    }
}
