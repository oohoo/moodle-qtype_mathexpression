### Python Sage Server

This question type uses [Sage Math](http://www.sagemath.org/) to evaluate the correctness of a student's response.
In order to achieve this, we created a simple Python HTTP server with a REST API. The question type's settings
contain the parameters used to hook up to this service. See the server source code in the `server` directory
for more information. Installation and running instructions are bellow:

#### Server Installation

1. Install [Sage Math](http://www.sagemath.org/) on the server machine, once this is is done running `sage`
  from the command line should work.
2. Download [Web.py](http://webpy.org/) and untar it
3. Navigate to the extracted folder and run the following command ( **NOTE:** it is important to run this using the
  Python that is bundled with Sage) `sudo sage -python setup.py install`
4. Navigate to this project's `server` folder
5. Start the server `sage -python server.py` (a port can be specified by using the `-p` flag)

#### Server API

**Simple Compare**<br/>
`http://your_server/sage/simple?expr1=...&expr2=...&vars=...`<br/><br/>
Performs a simple comparison of the two given expressions and the list of variables.<br/>
* Parameter: `expr1` - a string representation of an expression, eg. `a+b+c/2`
* Parameter: `expr2` - see `expr1`
* Parameter: `vars` - a list of the variables that are found in the expressions, must be comma delimited,
  eg. `a,b,c`
* Returns: `true` or `false`

Examples:<br/>
* `sage/simple?expr1=a+b+c/2&expr2=a+b+(c/2)&vars=a,b,c` returns `false`
* `sage/simple?expr1=a+b+c/2&expr2=(a+b+c)/2&vars=a,b,c` returns `true`

#### Server References

* http://webapp-improved.appspot.com/tutorials/quickstart.nogae.html

### References

* http://docs.moodle.org/dev/Creating_a_web_service_client
* http://docs.moodle.org/20/en/How_to_create_and_enable_a_web_service
* https://github.com/moodlehq/sample-ws-clients/tree/master/PHP-REST

