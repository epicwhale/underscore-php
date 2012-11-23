<?php
include '_startTest.php';

use Underscore\Underscore;
use Underscore\Arrays;

class ArraysTest extends UnderscoreWrapper
{
  // Tests --------------------------------------------------------- /

  public function testCanUseClassDirectly()
  {
    $under = Arrays::get($this->array, 'foo');

    $this->assertEquals('bar', $under);
  }

  public function testCanGetValueFromArray()
  {
    $array = array('foo' => array('bar' => 'bis'));
    $under = Underscore::get($array, 'foo.bar');

    $this->assertEquals('bis', $under);
  }

  public function testCanEachOverAnArray()
  {
    $closure = function($value, $key) {
      echo $key.':'.$value.':';
    };

    underscore($this->array)->each($closure)->obtain();
    Underscore::each($this->array, $closure);
    $result = 'foo:bar:bis:ter:foo:bar:bis:ter:';

    $this->expectOutputString($result);
  }

  public function testCanMapValuesToAnArray()
  {
    $closure = function($value, $key) {
      return $key.':'.$value;
    };

    $underChain  = underscore($this->array)->map($closure)->obtain();
    $underStatic = Underscore::map($this->array, $closure);
    $result = array('foo' => 'foo:bar', 'bis' => 'bis:ter');

    $this->assertEquals($result, $underChain);
    $this->assertEquals($result, $underStatic);
  }

  public function testCanFindAValueInAnArray()
  {
    $under = Underscore::find(array(1, 2, 3), function($value) {
      return $value % 2 == 0;
    });

    $this->assertEquals(2, $under);
  }

  public function testCanFilterValuesFromAnArray()
  {
    $under = Underscore::filter(array(1, 2, 3), function($value) {
      return $value % 2 != 0;
    });

    $this->assertEquals(array(0 => 1, 2 => 3), $under);
  }

  public function testCanFilterRejectedValuesFromAnArray()
  {
    $under = Underscore::reject(array(1, 2, 3), function($value) {
      return $value % 2 != 0;
    });

    $this->assertEquals(array(1 => 2), $under);
  }
}
