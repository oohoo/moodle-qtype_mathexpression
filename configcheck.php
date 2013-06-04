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

require('../../../config.php');

$PAGE->set_pagelayout('admin');

$PAGE->set_url('/question/type/mathexpression/configcheck.php');
$PAGE->set_context(context_system::instance());

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_title('mathexpression');
$PAGE->set_heading('mathexpression');
$PAGE->navbar->add('mathexpression');

echo $OUTPUT->header();

$url = $CFG->qtype_mathexpression_sageserver;
if($url == '') {
    throw new moodle_exception('Must provide a Sage server URL in the Question Type settings');
}

echo 'Full Compare:<br/>';

echo 'Expression 1: \\( \\left(\\alpha + 1\\right)^2 \\)<br/>';
echo 'Expression 2: \\( \\alpha^2 + 2\\alpha + 1 \\)<br/>';

$fields = array('expr1' => '\\left(\\alpha + 1 \\right)^2',
                'expr2' => '\\alpha^2 + 2\\alpha + 1',
                'exclude' => '[]');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url.'/full');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_response = curl_exec($ch);
echo 'Server Response: '.$server_response;

curl_close($ch);

echo $OUTPUT->footer();
