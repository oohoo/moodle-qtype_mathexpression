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
        global $PAGE, $DB;
        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/mathquill.min.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/mathquill.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/js/matheditor.js'));
        $PAGE->requires->css(new moodle_url('/lib/editor/tinymce/plugins/matheditor/tinymce/css/matheditor.css'));
        $PAGE->requires->js(new moodle_url('/lib/editor/tinymce/plugins/matheditor/all_strings.php'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/mathexpression.js'));
        $PAGE->requires->css(new moodle_url('/question/type/mathexpression/styles.css'));

        $mform->addElement('header', 'answerheader', get_string('answer', 'qtype_mathexpression'), true);
        $mform->setExpanded('answerheader', 1);

        $mform->addElement('textarea', 'buttonlist', get_string('buttonlist', 'qtype_mathexpression'),
            array('rows' => 6, 'cols' => 80));
        $mform->addHelpButton('buttonlist', 'buttonlist', 'qtype_mathexpression');
        $mform->setDefault('buttonlist', get_string('buttonlist_default', 'qtype_mathexpression'));

        $mform->addElement('static', 'matheditor', get_string('answer', 'qtype_mathexpression'),
            $this->math_editor('question-matheditor', '.answer-matheditor'));

        $mform->addElement('hidden', 'answer', '', array('class' => 'answer-matheditor'));
        $mform->setType('answer', PARAM_RAW);

        $comparetypes = array('simple' => get_string('simple', 'qtype_mathexpression'),
            'full' => get_string('full', 'qtype_mathexpression'));

        $select = $mform->addElement('select', 'comparetype', 
            get_string('comparetype', 'qtype_mathexpression'), $comparetypes);
        $select->setSelected('full');
        $mform->addHelpButton('comparetype', 'comparetype', 'qtype_mathexpression');

        $mform->addElement('header', 'excludedheader',
            get_string('excludedexpressions', 'qtype_mathexpression'), true);
        $mform->setExpanded('excludedheader', 1);

        $mform->addElement('static', 'exclude_help', '', get_string('exclude_help', 'qtype_mathexpression'));

        $repeated = array();
        $repeated[] = $mform->createElement('static', 'matheditor',
            get_string('exclude', 'qtype_mathexpression'),
            $this->math_editor('exclude-matheditor', ''));
        $repeated[] = $mform->createElement('hidden', 'exclude', '');
        $mform->setType('exclude', PARAM_RAW);

        $number = 0;
        if(isset($this->question->id)) {
            $number = $DB->count_records('qtype_mathexpression_exclude', array('questionid' => $this->question->id));
        }

        $this->repeat_elements($repeated, $number, array(), 'exclude_number', 'add_exclude', 1,
            get_string('addexcludedexpression', 'qtype_mathexpression'), true);
    }

    /**
     * Preprocesses the question data before being sent to be rendered by the form.
     *
     * @override
     * @param object $question the data being passed to the form
     * @return object $question the modified data
     */
    protected function data_preprocessing($question) {
        global $DB;
        $question = parent::data_preprocessing($question);

        $question = $this->data_preprocessing_answers($question);
        
        if (isset($question->options)) {
            $answer = array_shift($question->options->answers);
            $question->answer = $answer->answer;
        }

        if (isset($question->id)) {
            $options = $DB->get_record('qtype_mathexpression_options',array('questionid' => $question->id));
            $question->buttonlist = $options->buttonlist;
            $question->comparetype = $options->comparetype;

            $excluded = $DB->get_records('qtype_mathexpression_exclude', array('questionid' => $question->id));
            $question->exclude = array();
            foreach($excluded as $excl) {
                $question->exclude[] = $excl->answer;
            }
            $question->exclude_number = count($excluded);
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
     * @param class the class value for the element
     * @param identifier the hidden input field identifier
     * @return string html
     */
    private function math_editor($class, $identifier) {
        $result = '<div class="'.$class.'" data-matheditor="'.$identifier.'">';
        $result .= '</div>';
        return $result;
    }
}
