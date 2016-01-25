# Demo Client for Shutterstock API

PHP client that utilizes Guzzle to interact with the [Shutterstock API](https://developers.shutterstock.com/).

[![Build Status](https://travis-ci.org/jacobemerick/php-shutterstock-api.svg)](https://travis-ci.org/jacobemerick/php-shutterstock-api)
[![Code Climate](https://codeclimate.com/github/jacobemerick/php-shutterstock-api/badges/gpa.svg)](https://codeclimate.com/github/jacobemerick/php-shutterstock-api)
[![Test Coverage](https://codeclimate.com/github/jacobemerick/php-shutterstock-api/badges/coverage.svg)](https://codeclimate.com/github/jacobemerick/php-shutterstock-api/coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jacobemerick/php-shutterstock-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jacobemerick/php-shutterstock-api/?branch=master)

## Installation

Use [Composer](https://getcomposer.org/) to install the dependencies.

```bash
$ composer install
```

## Usage

Instantiating the client requires passing in your client id and secret, which you can register for on the [Shutterstock Developers site](https://developers.shutterstock.com/).

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Shutterstock\Api\Client($clientId, $clientSecret);
```

Interacting with the different endpoints is as simple as reading the [API documentation](https://developers.shutterstock.com/api/v2). There are two main methods of the client to deal with - `Client::get` and `Client::post` - which take an endpoint as their first argument and the client parameters as the second.

```php
// perform an image search for puppies
$client->get('images/search', array('query' => 'puppies'));

// retrieve details for a handful of image ids
$client->get('images', array('id' => array(1, 2, 3)));

// create a lightbox
$client->post('images/collections', array('name' => 'Lightbox Name Here'));
```

Each request will return a PSR-7 response object, which you can read about on the [Guzzle/PSR7 repo](https://github.com/guzzle/psr7). The response object bodies have been decorated with a JsonSerializable interface to allow easier handling of the default API responses.

```php
$imageResponse = $client->get('images', array('id' => array(1, 2, 3)));
if ($imageResponse->getStatusCode() != 200) {
    // error handler
}
$images = $imageResponse->getBody()->jsonSerialize()['data'];
// etc
```

If your application is setup to handle async CURL requests, you can also make `Client::getAsync` and `Client::postAsync` calls, which return [Guzzle Promises](https://github.com/guzzle/promises).

For more examples and a demo application using this client, see [LINK HERE].

## License

Copyright (C) 2016 by Shutterstock Images, LLC

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
