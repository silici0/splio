# splio api access via PHP

This library provides an objected-oriented wrapper of a PHP class to access SPLIO REST api

## Installation

```
composer required silici0/splio:dev-master
```

## Configuration

Create a file in your root folder called "config-splio.json" as the follow example code :
```
{
  "universe": "accountname",
  "apiKey": "api-key"
}
```

## Usage example

```
require "vendor/autoload.php";
use silici0\Splio\SplioService;

$s = new SplioService();

/**
 * Get Email Lists
 * 
 */
$r = $s->getLists();
var_dump($r);


/**
 * Save New Contact
 * 
 */
$contactData = array();
$contactData['email'] = 'email@gmail.com';
$contactData['firstname']='Firstname';
$contactData['lastname']='Lastname';
$contactData['lists'][0] = ['id' => '0'];

$r = $v->saveNewContact($contactData);
var_dump($r);
```
