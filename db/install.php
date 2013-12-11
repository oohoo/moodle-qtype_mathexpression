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
 * @author      Nicolas Bretin (bretin@ualberta.ca)                       **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
defined('MOODLE_INTERNAL') || die();

/**
 * Post installation procedure
 * 
 * @global moodle_database $DB
 * @global type $CFG
 * @global type $OUTPUT
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_qtype_mathexpression_install()
{
    global $DB, $CFG, $OUTPUT;

    //Preinsert all the default values;

    $groups = array();
    $languages = array();

    $language = new stdClass();
    $language->name = 'Sage Math';
    
    $languages[] = $language;

    $group = new stdClass();
    $group->name = 'General';
    $group->actions = array();

    //Plus
    $group->actions = array();
    $action = new stdClass();
    $action->name = 'mePlus';
    $action->coordinates = json_encode(array('x' => 50, 'y' => 100));
    $action->default_action = 1;
    $action->translation = '%s + %s';
    $group->actions[] = $action;
    //Minus
    $action = new stdClass();
    $action->name = 'meMinus';
    $action->coordinates = json_encode(array('x' => 75, 'y' => 100));
    $action->default_action = 1;
    $action->translation = '%s - %s';
    $group->actions[] = $action;
    //Minus Element
    $action = new stdClass();
    $action->name = 'meMinusElem';
    $action->coordinates = json_encode(array('x' => 75, 'y' => 100));
    $action->default_action = 0;
    $action->translation = '-%s';
    $group->actions[] = $action;
    //Times
    $action = new stdClass();
    $action->name = 'meTimes';
    $action->coordinates = json_encode(array('x' => 100, 'y' => 100));
    $action->default_action = 1;
    $action->translation = '%s * %s';
    $group->actions[] = $action;
    //Division
    $action = new stdClass();
    $action->name = 'meDivision';
    $action->coordinates = json_encode(array('x' => 125, 'y' => 100));
    $action->default_action = 1;
    $action->translation = '%s / %s';
    $group->actions[] = $action;
    
    //Parenthesis
    $action = new stdClass();
    $action->name = 'meParen';
    $action->coordinates = json_encode(array('x' => 175, 'y' => 25));
    $action->default_action = 1;
    $action->translation = '(%s)';
    $group->actions[] = $action;
    //Braces
    $action = new stdClass();
    $action->name = 'meBrace';
    $action->coordinates = json_encode(array('x' => 50, 'y' => 50));
    $action->default_action = 1;
    $action->translation = '{%s}';
    $group->actions[] = $action;
    //Brackets
    $action = new stdClass();
    $action->name = 'meBracket';
    $action->coordinates = json_encode(array('x' => 0, 'y' => 50));
    $action->default_action = 1;
    $action->translation = '[%s]';
    $group->actions[] = $action;

    $groups[] = $group;
    
    $group = new stdClass();
    $group->name = 'Miscellaneous';
    $group->actions = array();
    
    //Cross Product
    $action = new stdClass();
    $action->name = 'meCrossProduct';
    $action->coordinates = json_encode(array('x' => 100, 'y' => 100));
    $action->default_action = 0;
    $action->translation = '(%s).cross_product(%s)';
    $group->actions[] = $action;
    //Dot Product
    $action = new stdClass();
    $action->name = 'meDotProduct';
    $action->coordinates = json_encode(array('x' => 25, 'y' => 0));
    $action->default_action = 0;
    $action->translation = '(%s).dot_product(%s)';
    $group->actions[] = $action;
    //Scalar Product
    $action = new stdClass();
    $action->name = 'meScalarProduct';
    $action->coordinates = json_encode(array('x' => 200, 'y' => 150));
    $action->default_action = 0;
    $action->translation = '(%s)*(%s)';
    $group->actions[] = $action;
    $groups[] = $group;


    foreach($languages as $language)
    {
        $language->id = $DB->insert_record('qtype_mathexpression_lang', $language);
        
        foreach($groups as $group)
        {
            $group->id = $DB->insert_record('qtype_mathexpression_group', $group);
            foreach($group->actions as $action)
            {
                $action->groupid = $group->id;
                $action->id = $DB->insert_record('qtype_mathexpression_action', $action);
                $trad = new stdClass();
                $trad->langid = $language->id;
                $trad->actionid = $action->id;
                $trad->translation = $action->translation;
                $trad->id = $DB->insert_record('qtype_mathexpression_trad', $trad);
            }
        }
        break;
    }

    echo $OUTPUT->notification('Inserted prepared Commands in the database', 'notifysuccess');

    return true;
}
