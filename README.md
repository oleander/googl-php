# Googl

Google URL shortener API in PHP

## Usage

### Shorten url

``` php
$client = new Googl\Base("username@gmail.com", "password");
$url = $client->shorten("http://www.bbc.co.uk/");
echo $url->short; # => "http://goo.gl/wZts"
```

Your url should now be visible at [http://goo.gl/](http://goo.gl/).

### Expand url

``` php
$long = Googl\Base::expand("http://goo.gl/wZts");
echo $url->original; # => "http://www.bbc.co.uk/"
```

## Install

### Without Composer

Clone the project using `git clone https://github.com/oleander/googl-php` 
and include the source file with `require_once("googl-php/src/Googl.class.php");`

### With Composer

Add the following json to your `composer.json` file and run `composer update`.

    {
      "require" : {
        "oleander/googl" : "dev-master"
      }
    }

## Test

Tests can be found in the `tests` folder and executed by running
`USER="username@gmail.com" PASSWORD="gmail-password" phpunit`. Don't
forget to run `composer update` before you run the test suite.

## Contributing

1. Fork it ( http://github.com/oleander/googl-php/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
