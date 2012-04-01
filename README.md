[![Build Status](https://secure.travis-ci.org/winmillwill/BadFaith.png?branch=master)](http://travis-ci.org/winmillwill/BadFaith)

BadFaith content (/kənˈtɛnt/) negotiation has no assumptions about your environment/framework: it takes an array of the Accept and Accept-\* request-header fields you care about, keyed by name, parses them, and tells you which of the supplied variants you should use. If you don't supply that, it assumes you want to use the $\_SERVER variable. If you want to use your framework request object, then you can naturally extend the class.
