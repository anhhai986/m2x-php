PHP M2X API Client
========================

The AT&T M2X API provides all the needed operations to connect your device to AT&T's [M2X](http://m2x.att.com) service. 
This client provides an easy to use interface for your favorite language, PHP.


Getting Started
==========================
1. Signup for an [M2X Account](https://m2x.att.com/signup).
2. Obtain your _Master Key_ from the Master Keys tab of your [Account Settings](https://m2x.att.com/account) screen.
2. Create your first [Data Source Blueprint](https://m2x.att.com/blueprints) and copy its _Feed ID_.
3. Review the [M2X API Documentation](https://m2x.att.com/developer/documentation/overview).

Please consult the [M2X glossary](https://m2x.att.com/developer/documentation/glossary) if you have questions about any M2X specific terms.

## Installation

Simply add a dependency on attm2x/m2x-php to your project's composer.json file if you use Composer to manage the dependencies of your project.

```json
{
	"require": {
		"attm2x/m2x-php": "2.0.0"
	}
}
```

## Using the lib and creating the instance ##


```php
<?php
use Att\M2X\M2X;

$api_key = "<API KEY HERE>";
$feed_id = "<FEED>";

$m2x = new M2X($api_key);
```

## Endpoints ##

### List/Search Feeds ###
Reference: https://m2x.att.com/developer/documentation/feed#List-Search-Feeds

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->all();
```

### Get details of an existing feed ###
Reference: https://m2x.att.com/developer/documentation/feed#View-Feed-Details

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->view('<FEED-ID>');
```

### View Request Log ###
Reference: https://m2x.att.com/developer/documentation/feed#View-Request-Log

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->log('<FEED-ID>');
```

### Read Datasource Location ###
Reference: https://m2x.att.com/developer/documentation/feed#Read-Datasource-Location

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->location('<FEED-ID>');
```

### List Data Streams ###
Reference: https://m2x.att.com/developer/documentation/feed#List-Data-Streams

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->streams('<FEED-ID>');
```

### View Data Stream ###
Reference: https://m2x.att.com/developer/documentation/feed#View-Data-Stream

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->stream('<FEED-ID>', $stream);
```

### Create/Update Data Stream ###
Reference: https://m2x.att.com/developer/documentation/feed#Create-Update-Data-Stream

```php
<?php
$m2x = new M2X($api_key);

$data = array(
  'value' => 1.23,
  'unit'  => array('label' => 'Celsius')
);
$response = $m2x->feeds()->update_stream('<FEED-ID>', $stream, $data);
```

### Update Datasource Location ###
Reference: https://m2x.att.com/developer/documentation/feed#Update-Datasource-Location

```php
<?php
$m2x = new M2X($api_key);

$data = array(
  'name'      => 'Seattle',
  'latitude'  => 47.6097,
  'longitude' => 122.3331
);
$response = $m2x->feeds()->update_location('<FEED-ID>', $data);
```

### List Data Stream Values ###
Reference: https://m2x.att.com/developer/documentation/feed#List-Data-Stream-Values

```php
<?php
$m2x = new M2X($api_key);

$response = $m2x->feeds()->stream_values('<FEED-ID>', $stream);
```

### Post Data Stream Values ###
Reference: https://m2x.att.com/developer/documentation/feed#Post-Data-Stream-Values

```php
<?php
$m2x = new M2X($api_key);

$data = array(
  array('value' => 456),
  array('value' => 789),
  array('value' => 123.145)
);
$response = $m2x->feeds()->add_stream_values('<FEED-ID>', $stream, $data);
```

License
=======

This library is released under the MIT license. See [`LICENSE`](LICENSE) for the terms.
