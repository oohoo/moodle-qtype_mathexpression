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

class qtype_mathexpression_edit_form extends question_edit_form {

    /**
     * Defines any custom form elements needed when creating the question.
     *
     * @override
     * @param object $mform the object being built
     */
    protected function definition_inner($mform) {
        global $PAGE;
        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/mathquill.min.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/mathquill.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/matheditor.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/matheditor.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/all_strings.php'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/mathexpression.js'));
        $PAGE->requires->css(new moodle_url('/question/type/mathexpression/styles.css'));

        $matheditor = $this->math_editor();
        $mform->addElement('static', 'matheditor', get_string('answer', 'qtype_mathexpression'),
                $matheditor);

        $mform->addElement('hidden', 'answer', '&nbsp;', array('class' => 'matheditor-answer'));
        $mform->setType('answer', PARAM_RAW);
    }

    /**
     * Preprocesses the question data before being sent to be rendered by the form.
     *
     * @override
     * @param object $question the data being passed to the form
     * @return object $question the modified data
     */
    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);

        $question = $this->data_preprocessing_answers($question);
        
        if (isset($question->options)) {
            $answer = array_shift($question->options->answers);
            $question->answer = $answer->answer;
        }

        return $question;
    }

    /**
     * Validates the submitted question type form.
     *
     * @override
     * @param array $data array of ("fieldname" => value) of submitted data
     * @param array $files array of uploaded files (not applicable to this implementation)
     * @return array $errors array of errors
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        $answer = $data['answer'];

        if ($answer == '') {
            $errors['matheditor'] = get_string('mustprovideanswer', 'qtype_mathexpression', 1);
        }

        return $errors;
    }

    /**
     * Returns the name of the question type.
     *
     * @override
     * @return string the question type name
     */
    public function qtype() {
        return 'mathexpression';
    }

    /**
     * Generates the HTML markup for the matheditor form element.
     *
     * @return string html
     */
    private function math_editor() {
        $result = '<div class="question-matheditor" data-matheditor=".matheditor-answer">';
        $result .= '</div>';
        return $result;
    }
}
