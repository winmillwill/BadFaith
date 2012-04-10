[![Build Status](https://secure.travis-ci.org/winmillwill/BadFaith.png?branch=master)](http://travis-ci.org/winmillwill/BadFaith)

BadFaith is a content negotiation framework which uses the HTTP spec to map variants that the web site supplies to what the user agent says it can use, similar to Apache's mod_negotiation functionality.

For example, a handset in Hong Kong wants a different pic format, different compression, different language, different charset than a desktop browser in the US.

BadFaith content (/kənˈtɛnt/) negotiation has no assumptions about your environment/framework: it takes an array of the Accept and Accept-\* request-header fields you care about, keyed by name, parses them, and tells you which of the supplied variants you should use. If you don't supply that, it assumes you want to use the $\_SERVER variable. If you want to use your framework request object, then you can naturally extend the class.
