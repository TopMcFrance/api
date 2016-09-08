Top MC France - Vote Checker
===================

Check a code to vote on the site of TopMcFrance before giving a reward for his vote.
 
[![Build Status](https://scrutinizer-ci.com/g/TopMcFrance/api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/TopMcFrance/api/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TopMcFrance/api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TopMcFrance/api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/TopMcFrance/api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/TopMcFrance/api/?branch=master)
[![StyleCI](https://styleci.io/repos/62471634/shield)](https://styleci.io/repos/62471634)

For each vote on the site TopMcFrance with enabled API.  
The site generates a verification code to enter the site. 
This class allows check TopMcFrance about the validity of a code.
 
Each generated code is unique to the server and can only be used one time.

The Api is currently on developement.

Installation by composer
-------------

Add into you composer.json : 

```
"topmcfrance/api-client": "dev-master"
```


Installation by autoload
-------------
If you haven't composer, you can include the autoload.php into you webpage
```
require_once "topmcfrance-api/autoload.php";
```

Usage
-------------

```php
use TopMcFrance\Api\VoteChecker;
use TopMcFrance\Api\ApiException;

$serverId = 1; // Your server Id
$code = '123456789' // Code take by our user after voting;

$voteChecker = new VoteChecker($serverId);

try{
	$voteChecker->checkCode($code);
	// vote confirmed, you can give so many diamond !
} catch(ApiException $e){
	$error = $e->getApiMessage();
	// error in check, see ApiException for more option
}
```
