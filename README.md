# Moodle Math Expression Question Type

A [Moodle](http://www.moodle.org) question type that allows course instructors to create questions that
require the student to submit a mathematical equation as an answer.

**REQUIRES:**
* [Math Editor](https://github.com/oohoo/moodle-tinymce_matheditor)
* [MathJax Filter](https://github.com/oohoo/moodle-filter_mathjax)

![MathExpression](https://github.com/oohoo/moodle-qtype_mathexpression/blob/master/studentview.png?raw=true
 "Math Expression")

### Question Type

#### Installation

1. Get the zip file `mathexpression.zip` ([DOWNLOAD](http://dl.bintray.com/raywainman/generic/mathexpression.zip?direct))
2. To install this plugin, visit the Moodle plugin installation page and upload this zip as a **Question Type**
   the url is typically `http://moodle_root/admin/tool/installaddon/index.php`
3. Go to the Math Expression settings page and update the URL to the Python Sage server, if you don't have one
   see the Server installation instructions below.

If this fails, simply extract the zip into the `moodle_root/question/type` folder and visit the administration
notifications page to complete the installation.

#### References

* http://docs.moodle.org/dev/Question_types

### Python Sage Server

This question type uses [Sage Math](http://www.sagemath.org/) to evaluate the correctness of a student's response.
In order to achieve this, we created a simple Python HTTP server with a REST API. The question type's settings
contain the parameters used to hook up to this service. See the server source code in the `server` directory
for more information. Installation and running instructions are bellow.

#### Server Installation

1. Install [Sage Math](http://www.sagemath.org/) on the server machine, once this is is done running `sage`
  from the command line should work.
2. Download [Web.py](http://webpy.org/) and untar it
3. Navigate to the extracted folder and run the following command ( **NOTE:** it is important to run this using the
  Python that is bundled with Sage) `sudo sage -python setup.py install`
4. Navigate to this project's `server` folder
5. Start the server `sage -python server.py` (a port can be specified by using the `-p` flag)

This will create a server on your machine on port `8080` or the one you specified. Typically the url will be
something like `http://your_machine:8080/sage`.

#### Server API

**Simple Compare**<br/>
`http://your_server/sage/simple?expr1=...&expr2=...`<br/><br/>
Performs a simple comparison of the two given expressions. To perform the comparison, it parses both equations
into the Sage Math symbolic representation and subtracts them. If the result is 0, then the equations can be
deemed equivalent.<br/>
* Parameter: `expr1` - a string representation of an expression, eg. `a+b+c/2`, can also be in LaTeX format
* Parameter: `expr2` - same as above, eg. `\frac{a+b+c}{2}`
* Returns: a JSON object containing three fields:

```javascript
{
  'expr1': 'algebraic notation for expression 1'
  'expr2': 'algebraic notation for expression 2'
  'result': true or false
}
```
The equations are echoed back into their algebraic equivalents, this is mostly for your own debugging purposes.

**Full Compare**<br/>
`http://your_server/sage/full?expr1=...&expr2=...&exclude=[]...`<br/><br/>
Performs a full comparison of the two given expressions. To perform the comparison, it parses both equations
into the Sage Math symbolic representation, simplifies them and then subtracts them. If the result is 0, then
the equations can be deemed equivalent. An optional list of excluded expressions can also be specified
as equations that evaluate to true, would represent an invalid answer. This is used to prevent the student
from simply echoing the initial equation in the case a simplification is requested.<br/>
* Parameter: `expr1` - a string representation of an expression, eg. `a+b+c/2`, can also be in LaTeX format
* Parameter: `expr2` - same as above, eg. `\frac{a+b+c}{2}`
* Parameter: `exclude` - an array of excluded expressions, these expressions can be in algebraic or LaTeX format
* Returns: a JSON object containing three fields:

```javascript
{
  'expr1': 'algebraic notation for expression 1'
  'expr2': 'algebraic notation for expression 2'
  'result': true or false
}
```
The equations are echoed back into their algebraic equivalents, this is mostly for your own debugging purposes.

Examples:<br/>
* `sage/full?expr1=(x+1)(x+2)&expr2=(x+1)(x+2)&exclude=[(x+1)(x+2)]` returns `false`
* `sage/full?expr1=(x+1)(x+2)&expr2=x^2+3x+2&exclude=[(x+1)(x+2)]` returns `true`

#### Server Development

This server uses the [Web.py](http://webpy.org/) library to provide the web server interface. Ensure
this package is installed as part of your Sage Python environment. See the server installation instructions
for details on how to do this.

All server related code is located in the `server` folder.

Breakdown of file functions:
* `algebra.py` - Functionality that converts LaTeX equations into algebraic equivalents that can be understood
  by Sage
* `algebra_test.py` - Unit tests for the LaTeX to algebra conversion
* `sageserver.py` - Interface functions between Python and Sage
* `server.py` - Main server file, contains the GET and POST web handlers

#### Server References

* http://webapp-improved.appspot.com/tutorials/quickstart.nogae.html

### References

* http://docs.moodle.org/dev/Creating_a_web_service_client
* http://docs.moodle.org/20/en/How_to_create_and_enable_a_web_service
* https://github.com/moodlehq/sample-ws-clients/tree/master/PHP-REST

