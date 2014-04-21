<?php

class GooglTest extends PHPUnit_Framework_TestCase {
  public function testUrlShorten() {
    $client = new Googl\Base($_ENV["USER"], $_ENV["PASSWORD"]);
    $url = $client->shorten("http://www.bbc.co.uk/");
    $this->assertRegExp("/^http:\/\/goo.gl\/\w+$/", $url->short);
    $this->assertEquals($url->original, "http://www.bbc.co.uk/");
  }

  /**
  * @expectedException Exception
  */
  public function testInvalidUrl(){
    $client = new Googl\Base($_ENV["USER"], $_ENV["PASSWORD"]);
    $client->shorten(null);
  }

  /**
  * @expectedException Exception
  */
  public function testInvalidCredentials(){
    $client = new Googl\Base(null, null);
    $client->shorten("http://www.bbc.co.uk/");
  }

  public function testExpandUrl(){
    $url = Googl\Base::expand("http://goo.gl/wZts");
    $this->assertEquals("http://www.bbc.co.uk/", $url->original);
    $this->assertEquals("http://goo.gl/wZts", $url->short);
  }

  /**
  * @expectedException Exception
  */
  public function testFailedExpandUrl(){
    Googl\Base::expand("http://www.bbc.co.uk/");
  }
}