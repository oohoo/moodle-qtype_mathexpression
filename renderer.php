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

defined('MOODLE_INTERNAL') || die();

class qtype_mathexpression_renderer extends qtype_renderer {

    /**
     * Generates the display for the question, including the input fields and feedback items
     * (if any).
     *
     * @param question_attempt $qa the question attempt to display.
     * @param question_display_options $options controls what should and should not be displayed.
     * @return string HTML fragment.
     */
    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {
        $question = $qa->get_question();
        $currentanswer = $qa->get_last_qt_var('answer');
        $inputname = $qa->get_qt_field_name('answer');

        $editor = editors_get_preferred_editor(null);

        $editor->use_editor($inputname, array(), array());

        $result = html_writer::tag('div', $question->format_questiontext($qa), array('class' => 'qtext'));

        if($options->readonly) {
            $result .= html_writer::tag('div', get_string('youranswer', 'qtype_mathexpression'));
            $result .= html_writer::tag('div', $qa->get_response_summary());
        } else {
            $result .= html_writer::tag('div', html_writer::tag('textarea', $currentanswer,
                    array('id' => $inputname, 'name' => $inputname, 'rows' => 20, 'cols' => 60)));
        }

        return $result;
    }
}