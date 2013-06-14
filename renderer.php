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
     * Return any HTML that needs to be included in the page's <head> when this
     * question is used.
     * @global $PAGE
     * @param $qa the question attempt that will be displayed on the page.
     * @return string HTML fragment.
     */
    public function head_code(question_attempt $qa) {
        global $PAGE;
        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/mathquill.min.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/mathquill.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/matheditor.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/matheditor.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/all_strings.php'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/mathexpression.js'));
        return parent::head_code($qa);
    }

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
        $inputname_mathml = $qa->get_qt_field_name('answer_mathml');

        $result = html_writer::tag('div', $question->format_questiontext($qa), array('class' => 'qtext'));

        if($options->readonly) {
            $result .= html_writer::tag('div', get_string('youranswer', 'qtype_mathexpression'));
            $result .= html_writer::tag('div', $qa->get_response_summary());
        } else {
            $inputattributes = array(
                'type' => 'hidden',
                'name' => $inputname,
                'class' => 'matheditor-answer',
                'value' => $currentanswer
            );
            $result .= html_writer::empty_tag('input', $inputattributes);

            $mathmlattributes = array(
                'type' => 'hidden',
                'name' => $inputname_mathml
            );
            $result .= html_writer::empty_tag('input', $mathmlattributes);

            $buttonlistattributes = array(
                'type' => 'hidden',
                'id' => 'id_buttonlist',
                'value' => $question->buttonlist
            );
            $result .= html_writer::empty_tag('input', $buttonlistattributes);

            $result .= html_writer::tag('div', '', array('class' => 'question-matheditor',
                'data-matheditor' => 'input[name="'.$inputname.'"]',
                'data-matheditorvars' => json_encode($question->variable),
                'data-matheditor-mathml' => 'input[name="'.$inputname_mathml.'"]'));
        }

        return $result;
    }
}