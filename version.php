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

$plugin->version = 2013120801;
$plugin->requires = 2013042600;
$plugin->maturity = MATURITY_BETA;
$plugin->release = '1.0.2 (Build: 2013120801)';
$plugin->component = 'qtype_mathexpression';
$plugin->cron = 0;
$plugin->dependencies = array(
    'filter_mathjax' => 2013061400
);
