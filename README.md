[![Build Status](https://secure.travis-ci.org/winmillwill/BadFaith.png?branch=master)](http://travis-ci.org/winmillwill/BadFaith)

In Brief
==========
BadFaith is a content negotiation framework which uses the HTTP spec to map variants that the web site supplies to what the user agent says it can use, similar to Apache's mod_negotiation functionality.

For example, a handset in Hong Kong wants a different pic format, different compression, different language, different charset than a desktop browser in the US.

BadFaith content (/kənˈtɛnt/) negotiation has no assumptions about your environment/framework: it takes an array of the Accept and Accept-\* request-header fields you care about, keyed by name, parses them, and tells you which of the supplied variants you should use. If you don't supply that, it assumes you want to use the $\_SERVER variable. If you want to use your framework request object, then you can naturally extend the class.

The Ideal API
==============

```php
<?php
  // If you wish to use $_SERVER
  $negotiator = new \BadFaith\Negotiator();

  // If that is not desirable, furnish these header fields some other way
  $acceptHeaders = array(
    'accept' => 'text/html;level=2;q=0.7,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'accept_encoding' => 'gzip,deflate,sdch',
    'accept_language' => 'en-US,en;q=0.8',
    'accept_charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
  );
  $negotiator = new \BadFaith\Negotiator($acceptHeaders);

  //Get information on what that user-agent wants for one dimension of variation:
  $best_encoding = $negotiator->getPreferred('encoding')
  echo $best_encoding; //Outputs 'gzip'.

  //Get what would suit the UA best in all dimensions:
  $best_all = $negotatiator->getPreferred();
  var_export($best_all)
  //Outputs
  array(
    'accept' => 'text/html',
    'accept_encoding' => 'gzip',
    'accept_language' => 'en-US',
    'accept_charset' => 'ISO-8859-1',
  );

  // Provide the information on the variants you have for the resource
  // ...using a string:
  $negotiator->variants['charset'] = "UTF-8,iso-8859-1;q=0.9,UTF-16;q=0.5"
  // ...using an array:
  $negotiator->variants['charset'] = array(
    array(
      'type' => 'UTF-8',
      'q' => 1.0,
    ),
    array(
      'type' => 'iso-8859-1',
      'q' => 0.9,
    ),
    array(
      'type' => 'UTF-16',
      'q' => 0.5,
    ),
  );

  // Use that information to do real Content Negotiation:
  $negotiator->getBestVariant()

  // Or, if you're in a hurry:
  $negotiator new \BadFaith\Negotiator($headers, $variants);

  // Supply your own negotiation algorithm on the fly if you like
  $best = negotiator->getBestVariant('algoCallable');
?>
```
