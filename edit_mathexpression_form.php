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
        $mform->addElement('editor', 'answer', get_string('answer', 'qtype_mathexpression'));
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

        // Store answer in format that the editor can use
        $answer = array_shift($question->options->answers);
        if (isset($question->options)) {
            $question->answer = array();
            $question->answer['text'] = $answer->answer;
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

        $trimmedanswer = trim($answer['text']);
        if ($trimmedanswer == '') {
            $errors['answer'] = get_string('mustprovideanswer', 'qtype_mathexpression', 1);
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
}
