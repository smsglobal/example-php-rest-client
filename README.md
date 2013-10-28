PHP example client for SMS Global REST API
================================
This is a simplified version of the PHP REST API Client, mainly to showcase how the API can be easily consumed :)
For a full version that can actually be included as part of more serious projects, please check out these 2 bundles
 * PHP 5.2 or below: https://github.com/smsglobal/rest-api-client-php-5.2
 * PHP 5.3 or above: https://github.com/smsglobal/rest-api-client-php

Requirements
--------------------------------
 - PHP 5.3.0 or above (type ```php -v``` to check the version of your PHP and see if it supports CLI.)

Preparation & Compile
--------------------------------
 - Download Composer.phar to the project folder and follow the instructions to install it.
~~~
   /> curl -sS https://getcomposer.org/installer | php
~~~
  - Use Composer to download the libraries used in this example
~~~
    /> php composer.phar install
~~~
 - Make sure your user has the right to execute the file SMSGlobalAPIConsumer.rb if you intend to run it as a script
~~~
/> chmod u+x SMSGlobalAPIConsumer.php
~~~

Execution
--------------------------------
The consumer file will be your 'main' method, this file can be run as a ruby script and accepts 2 arguments and 1 option
~~~
/> ./SMSGlobalAPIConsumer.php [-v] [-s] -k <key> -s <Secret>
/> ./SMSGlobalAPIConsumer.php -h
~~~
Usage:
 * -k : API Key String (required) [1]
 * -s : Secret String (required) [1]
 * [-v] : (verbose) turn on or off debugging (optional)
 * [-s] : turn on or off SSL mode (optional) [2]

Notes:
 * [1] Find your \<APIKey\> and \<Secret\> from within MXT at http://mxt.smsglobal.com/api-key.
 * [2] We're disabling SSL Certificate Verification for ease of development and less braincells burned, please consider turn in it back on by commenting out the following line

Example result would look like this

~~~
    ./SMSGlobalAPIConsumer.php -v -k 27a657ff3aec742ddca08e3d918f9ccd -e 1d23ea091399a98f6c20faf1108c63a6

    == Getting Balance ==
    "
    * About to connect() to api.smsglobal.com port 80 (#0)
    *   Trying 203.89.193.162... * connected
    * Connected to api.smsglobal.com (203.89.193.162) port 80 (#0)
    > GET /v1/balance HTTP/1.1
    Host: api.smsglobal.com
    User-Agent: Httpful/0.1.7 (cURL/7.21.4 PHP/5.3.15 (Darwin) Apple_Terminal/303.2)
    Accept: */*; q=0.5, text/plain; q=0.8, text/html;level=3;q=0.9, application/json
    Authorization: MAC id="27a657ff3aec742ddca08e3d918f9ccd", ts="1372641043", nonce="5530c86c4f4c86074b24ae32f20b4276", mac="ImKhXhfXr7cpFFW/sW8+OKk3KFbC3kwBaJ8MkRHY5QQ="

    < HTTP/1.1 200 OK
    < Server: nginx
    < Date: Mon, 01 Jul 2013 01:10:37 GMT
    < Content-Type: application/json
    < Content-Length: 107
    < Connection: keep-alive
    < Cache-Control: private
    < X-UA-Compatible: IE=Edge,chrome=1
    < Set-Cookie: NSC_MC_203.89.193.162=ffffffffc3a00f3045525d5f4f58455e445a4a423660;expires=Mon, 01-Jul-2013 11:10:37 GMT;path=/;httponly
    <
    * Connection #0 to host api.smsglobal.com left intact
    * Closing connection #0

    Your balance is: 5.744
    Country code: AU
    Cost per SMS: 0.1
    Cost per MMS: 0.38
    SMS available: 56
    MMS available: 15
~~~
