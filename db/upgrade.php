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

function xmldb_qtype_mathexpression_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2013061100) {
        // Define table qtype_mathexpression_vars to be created.
        $table = new xmldb_table('qtype_mathexpression_vars');

        // Adding fields to table qtype_mathexpression_vars.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('variable', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);

        // Adding keys to table qtype_mathexpression_vars.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('questionid', XMLDB_KEY_FOREIGN, array('questionid'), 'question', array('id'));

        // Conditionally launch create table for qtype_mathexpression_vars.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Mathexpression savepoint reached.
        upgrade_plugin_savepoint(true, 2013061100, 'qtype', 'mathexpression');
    }

    if ($oldversion < 2013061300) {
        $table = new xmldb_table('qtype_mathexpression_options');
        $field = new xmldb_field('answer_mathml', XMLDB_TYPE_TEXT, null, null, null, null, null, 'comparetype');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('qtype_mathexpression_exclude');
        $field = new xmldb_field('answer_mathml', XMLDB_TYPE_TEXT, null, null, null, null, null, 'answer');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $table = new xmldb_table('qtype_mathexpression_vars');
        $field = new xmldb_field('variable_mathml', XMLDB_TYPE_TEXT, null, null, null, null, null, 'variable');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Mathexpression savepoint reached.
        upgrade_plugin_savepoint(true, 2013061300, 'qtype', 'mathexpression');
    }
}

