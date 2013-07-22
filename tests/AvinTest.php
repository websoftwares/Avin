<?php
use Websoftwares\AvinClient, Websoftwares\Avin, Websoftwares\AvinException;
/**
 * Class AvinClientTest
 * Provide a valid api key to test the 'online' tests.
 */
class AvinTest extends \PHPUnit_Framework_TestCase
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
            $this->avin = new Avin(new AvinClient(self::TEST_KEY));
        } else {
            $this->avin = new Avin(new AvinClient(self::VALID_KEY));
            $this->debug = false;
        }
        $this->reflection = new \ReflectionClass($this->avin);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Avin', $this->avin);
    }

    public function testClientPropertySucceeds()
    {
        $client = new \stdClass;
        $this->setProperty('client', $client);
        $this->assertEquals($client, $this->getProperty('client'));
    }

    public function testGetWinesByNameSucceeds()
    {
        if ($this->debug) {
            $actual = $this->avin->GetWinesByName('Riesling', $this->debug);
            $expected = 'http://api.avin.cc/rest/v1.0/GetWinesByName/Riesling/&key=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

            $filters = $this->avin
                ->setFilter('vintage', 2011)
                ->setFilter('country', 276)
                ->setFilter('type', '2')
                ->setFilter('producer', 'Leonard Kreusch')
                ->setFilter('page', 1)
                ->setFilter('sortorder', 'asc')
                ->setFilter('sortby', 'name')
                ->GetWinesByName('Riesling', $this->debug);
            $this->assertEquals($expected . '&vintage=2011&country=276&type=2&producer=Leonard+Kreusch&page=1&sortorder=asc&sortby=name', $filters);

            $reset = $this->avin->clearFilter()->GetWinesByName('Riesling', $this->debug);
            $this->assertEquals($expected, $reset);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->GetWinesByName('Riesling');
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('wines', $actual);
            $this->assertArrayHasKey('wines', $actual);
        }
    }

    public function testGetWineByAvinSucceeds()
    {
        if ($this->debug) {
            $actual = $this->avin->GetWineByAvin('AVIN6452997073019', $this->debug);
            $expected = 'http://api.avin.cc/rest/v1.0/GetWineByAvin/AVIN6452997073019/&key=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

            $filters = $this->avin
                ->setFilter('vintage', 2003)
                ->setFilter('country', 620)
                ->setFilter('type', '1')
                ->setFilter('producer', 'Cortes de Cima')
                ->GetWineByAvin('AVIN6452997073019', $this->debug);
            $this->assertEquals($expected . '&vintage=2003&country=620&type=1&producer=Cortes+de+Cima', $filters);

            $reset = $this->avin->clearFilter()->GetWineByAvin('AVIN6452997073019', $this->debug);
            $this->assertEquals($expected, $reset);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->GetWineByAvin('AVIN6452997073019');
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('wines', $actual);
            $this->assertArrayHasKey('wines', $actual);
        }
    }

    public function testGetCountriesSucceeds()
    {
        if ($this->debug) {
            $actual = $this->avin->GetCountries($this->debug);
            $expected = 'http://api.avin.cc/rest/v1.0/GetCountries/&key=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->GetCountries();
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('countries', $actual);
            $this->assertArrayHasKey('countries', $actual);
        }
    }

    public function testGetWineTypesSucceeds()
    {
        if ($this->debug) {
            $actual = $this->avin->GetWineTypes($this->debug);
            $expected = 'http://api.avin.cc/rest/v1.0/GetWineTypes/&key=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->GetWineTypes();
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('wine_types', $actual);
            $this->assertArrayHasKey('wine_types', $actual);
        }
    }

    public function testGetProducerByIDSucceeds()
    {
        if ($this->debug) {
            $expected = 'http://api.avin.cc/rest/v1.0/GetProducerByID/15315/&key=123456789UnitTestKey&format=json';
            $actual = $this->avin->getProducerByID(15315, $this->debug);
            $this->assertEquals($expected,$actual);

            $country = $this->avin->setFilter('country', 203)->getProducerByID(15315, $this->debug);
            $this->assertEquals($expected . '&country=203',$country);

            $reset = $this->avin->clearFilter()->getProducerByID(15315, $this->debug);
            $this->assertEquals($expected, $reset);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->getProducerByID(15315);
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('producers', $actual);
            $this->assertArrayHasKey('producers', $actual);
        }
    }

    public function testGetProducerByNameSucceeds()
    {
        if ($this->debug) {
            $actual = $this->avin->GetProducersByName('Era', $this->debug);
            $expected = 'http://api.avin.cc/rest/v1.0/GetProducersByName/Era/&key=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

            $filters = $this->avin
                ->setFilter('country', 276)
                ->setFilter('page', 1)
                ->setFilter('sortorder', 'asc')
                ->setFilter('sortby', 'name')
                ->GetProducersByName('Era', $this->debug);
            $this->assertEquals($expected . '&country=276&page=1&sortorder=asc&sortby=name', $filters);

            $reset = $this->avin->clearFilter()->GetProducersByName('Era', $this->debug);
            $this->assertEquals($expected, $reset);

        } else {
            $expected = 'ArrayObject';
            $actual = $this->avin->GetProducersByName('Era');
            $this->assertInstanceOf($expected, $actual);
            $this->assertObjectHasAttribute('producers', $actual);
            $this->assertArrayHasKey('producers', $actual);
        }
    }

    public function testDataSucceeds()
    {
        $expected = 'ArrayObject';
        $method = $this->getMethod('data',  array('test' => array(new \stdClass)));
        $actual = $method->invoke($this->avin);
        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testInstantiateAsObjectFails()
    {
        new Avin;
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGGetWineByAvinFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetWineByAvin();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetWineByAvinArgumentFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetWineByAvin('AVIN6452997073019');
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetWinesByNameFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetWinesByName();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetWinesByNameArgumentFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetWinesByName('Riesling');
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetCountriesFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetCountries();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetWineTypesFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetWineTypes();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetProducersByNameFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetProducersByName();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testGetProducersByNameArgumentFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->GetProducersByName('Era');
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testgetProducerByIDFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->getProducerByID();
    }

    /**
     * @expectedException Websoftwares\AvinException
     */
    public function testgetProducerByIDArgumentFails()
    {
        $test = new Avin(new AvinClient(self::TEST_KEY));
        $test->getProducerByID('15315');
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

        return $property->getValue($this->avin);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->avin, $value);
    }
}
