<?php

define('BC_API_BASE_URL', 'https://api.bibliocommons.com/v1');
define('BC_API_PRIVATE_KEY', '[YOUR_API_KEY]');
define('BC_API_LIBRARY', '[MY_LIBRARY_ID]'); //The library ID. Each library's BiblioCommons catalog will have a hostname of the form {id}.bibliocommons.com. The {id} portion of the hostname is the library's ID.

/* Pass the following set of parameters to the api along with a custom search string from a biblioCore advanced search page.
*	- Note: this string is only configured to work with a custom search string
	@TODO - Parameterized function(s), classes, etc should be developed to use UI elements to dynamically generate varialbles for other API methods 
	
*/ 
define('BC_API_PARAMS', 'search_type=custom&limit=20&page=1&metadata=1&date_format=iso8601&locale=en-US');
