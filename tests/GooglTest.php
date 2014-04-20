<?php

class GooglTest extends PHPUnit_Framework_TestCase {
  public function testUrlShorten() {
    echo $_ENV["USERNAME"];
    $client = new Googl($_ENV["USER"], $_ENV["PASSWORD"]);
    $short = $client->shorten("http://www.bbc.co.uk/");
    $this->assertNotNull($short["id"]);
  }
}