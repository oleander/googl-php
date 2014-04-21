<?php 

namespace Googl;

class Base {
  private $username;
  private $password;
  private $token;

  #
  # @username String Gmail email (username@gmail.com)
  # @password String Gmail password
  #
  public function __construct($username, $password){
    $this->username = $username;
    $this->password = $password;
  }

  #
  # @url String URL to be shorten
  # @return Url
  #
  public function shorten($url){
    if(!$this->isLoggedIn()){
      $this->login();
    }

    $curl = curl_init("https://www.googleapis.com/urlshortener/v1/url");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Content-type: application/json", 
      "Authorization: GoogleLogin auth=$this->token"
    ));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
      "longUrl" => $url
    )));

    $result = json_decode(curl_exec($curl), true);

    if(!isset($result["id"])){
      throw new \Exception("Short url could not be created");
    }

    return new Url(array(
      "short" => $result["id"],
      "original" => $result["longUrl"]
    ));
  }

  #
  # @url String Goo.gl url to be expand
  # @return Url
  #
  public static function expand($url) {
    $curl = curl_init("https://www.googleapis.com/urlshortener/v1/url?shortUrl=$url");
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = json_decode(curl_exec($curl), true);

    if($result["status"] != "OK"){
      throw new \Exception("URL could not be expand");
    }

    return new Url(array(
      "short" => $result["id"],
      "original" => $result["longUrl"]
    ));
  }

  private function isLoggedIn(){
    return isset($this->$token);
  }

  private function login(){
    $fields = array(
      "accountType" => "HOSTED_OR_GOOGLE",
      "service" => "urlshortener",
      "source" => "ra",
      "Email" => $this->username,
      "Passwd" => $this->password
    );

    $curl = curl_init("https://www.google.com/accounts/ClientLogin");

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));

    $response = curl_exec($curl);
    $this->token = str_replace("\n", "", end(explode("=", $response)));

    if($this->token == "BadAuthentication"){
      $this->token = null;
      throw new \Exception("Wrong username or password");
    }
  }
}

class Url {
  public $original;
  public $short;

  public function __construct($result){
    $this->original = $result["original"];
    $this->short = $result["short"];
  }
}
?>