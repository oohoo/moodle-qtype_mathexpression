### Python Sage Server

This question type uses [Sage Math](http://www.sagemath.org/) to evaluate the correctness of a student's response.
In order to achieve this, we created a simple Python HTTP server with a REST API. The question type's settings
contain the parameters used to hook up to this service. See the server source code in the `server` directory
for more information. Installation and running instructions are bellow:

#### Server Installation

1. Install [Sage Math](http://www.sagemath.org/) on the server machine, once this is is done running `sage`
  from the command line should work.
2. Download 

#### Server References

* http://webapp-improved.appspot.com/tutorials/quickstart.nogae.html

### References

* http://docs.moodle.org/dev/Creating_a_web_service_client
* http://docs.moodle.org/20/en/How_to_create_and_enable_a_web_service
* https://github.com/moodlehq/sample-ws-clients/tree/master/PHP-REST

