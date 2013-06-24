<?php

/**
 * *************************************************************************
 * *                            MathExpression                            **
 * *************************************************************************
 * @package     question                                                  **
 * @subpackage  mathexpression                                            **
 * @name        MathExpression                                            **
 * @copyright   oohoo.biz                                                 **
 * @link        http://oohoo.biz                                          **
 * @author      Raymond Wainman (wainman@ualberta.ca)                     **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

$string['addanswer'] = 'Add Answer';
$string['addexcludedexpression'] = 'Add Excluded Expression';
$string['addvariable'] = 'Add Variable';
$string['answer'] = 'Answer';
$string['answers'] = 'Answers';
$string['buttongroups'] = 'Button Groups';
$string['buttonlist'] = 'Button List';
$string['buttonlist_help'] = 'This list specifies the buttons that will appear within the response'
    .' math editor and that will be available to the student. This should be a comma delimited '
    .'list of button identifiers. (eg. <code>alpha,square_root,plus</code>).';
$string['comparetype'] = 'Compare Type';
$string['comparetype_help'] = 'How the student\'s response is evaluated. Currently there are two '
    .'methods: <ul><li><b>Simple:</b> Performs a simple symbolic comparison between two '
    .'expressions. No expansion or factorization is performed hence expressions like "(x+1)^2" '
    .'and "(1+x)^2" will evaluate as the same but expressions like "(x+1)^2" and "x^2+2*x+1" will '
    .'not.</li><li><b>Full:</b> Performs a full symbolic comparison between two expressions. '
    .'This will involve fully simplifying each and then comparing to see if the result is the '
    .'same.</li></ul>';
$string['configuration'] = 'Configuration';
$string['correctanswer'] = 'Correct Answer';
$string['exclude'] = 'Exclude';
$string['exclude_help'] = 'An optional list of excluded expressions can be defined. If the '
    .'the response matches one of the excluded expressions<br/> using the simple compare method, '
    .'then the comparison will return false. This is to allow questions such as <br/>'
    .'<code>expand (x+1)^2</code> to stop the student just entering <code>(x+1)^2</code> and have SAGE accept it as a '
    .'match to the correct answer.<br/><br/>';
$string['excludedexpressions'] = 'Excluded Expressions';
$string['full'] = 'Full';
$string['greeklower'] = 'Greek Lower Case';
$string['greekupper'] = 'Greek Upper Case';
$string['infinity'] = 'Infinity';
$string['logs/exponential'] = 'Logarithms/Exponential';
$string['matrix'] = 'Matrix';
$string['mustprovideanswer'] = 'Must provide an answer';
$string['operators'] = 'Operators';
$string['pluginname'] = 'Math Expression';
$string['pluginname_help'] = 'Question type that requires a mathematical expression as an answer';
$string['pluginname_link'] = 'question/type/mathexpression';
$string['pluginnameadding'] = 'Adding a Math Expression question';
$string['pluginnameediting'] = 'Editing a Math Expression question';
$string['pluginnamesummary'] = 'Question type that requires a mathematical expression as an '
    .'answer. Evaluates the expression using a sophisticated Math Engine (SAGE) to compare '
    .'correctness';
$string['pleaseeenteranswer'] = 'Please enter an answer';
$string['sageserver'] = 'Sage Server';
$string['sageserver_help'] = 'URL to a Sage server that is needed to perform expression '
    .'comparisons. Please see the documentation within the Math Expression question type folder '
    .'(and more specifically the server folder) for more details. To test your configuration '
    .'visit <a href="'.$CFG->wwwroot.'/question/type/mathexpression/configcheck.php">'
    .$CFG->wwwroot.'/question/type/mathexpression/configcheck.php</a>';
$string['simple'] = 'Simple';
$string['superscript'] = 'Superscript';
$string['trigonometry'] = 'Trigonometry';
$string['variable'] = 'Variable';
$string['variables'] = 'Variables';
$string['vars_help'] = 'Define all the variables in the equation, these will appear in the student\'s '
    .'answer editor for easy access.<br/>These are also used when evaluating the '
    .'correctness of the answer.<br/><br/>';
$string['youranswer'] = 'Your Answer:';
