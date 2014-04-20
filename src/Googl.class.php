<?php 

class Googl {
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
  # @return Array (
  #   [kind] => urlshortener#url
  #   [id] => http://goo.gl/njUr95
  #   [longUrl] => http://google.com/
  # )
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

    return json_decode(curl_exec($curl), true);
  }

  #
  # @url String Goo.gl url to be expand
  # @return Array (
  #   [kind] => urlshortener#url
  #   [id] => http://goo.gl/njUr95
  #   [longUrl] => http://google.com/
  #   [status] => OK
  # )
  #
  public static function expand($url) {
    $curl = curl_init("https://www.googleapis.com/urlshortener/v1/url?shortUrl=$url");
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    return json_decode(curl_exec($curl), true);
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
      throw new Exception("Wrong username or password");
    }
  }
}
?>