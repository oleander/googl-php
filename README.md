# Googl

Google URL Shortener API in PHP

## Usage

### Shorten url

``` php
require_once("Googl.class.php");
$client = new Googl("username@gmail.com", "password");
$short = $client->shorten("http://www.bbc.co.uk/");
if(isset($short["id"])){
  echo $short["id"]; # => "http://goo.gl/wZts"
}
```

Your url should now be visible at [http://goo.gl/](http://goo.gl/).

### Expand url

``` php
require_once("Googl.class.php");
$long = Googl::expand("http://goo.gl/wZts");
if($long["status"] == "OK"){
  echo long["longUrl"]; # => "http://www.bbc.co.uk/"
}
```

## Install

    git clone https://github.com/oleander/googl-php

### Composer

    {
        "require" : {
            "oleander/googl" : "1.*"
        }
    }

## Contributing

1. Fork it ( http://github.com/oleander/googl-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request