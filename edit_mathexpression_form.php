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

    private static $operator_buttons = 'fraction,round_braces,plus,minus,times,division,bullet,square_root';
    private static $superscript_buttons = 'superscript';
    private static $trigonometry_buttons = 'sin,cos,tan';
    private static $log_buttons = 'natural_log,exponential,log';
    private static $greek_lower_buttons = 'alpha,beta,gamma,delta,epsilon,zeta,eta,theta,iota,kappa,lambda,mu,nu,xi,omicron,pi,rho,sigma,tau,upsilon,phi,chi,psi,omega';
    private static $greek_upper_buttons = 'alpha_uppercase,beta_uppercase,gamma_uppercase,delta_uppercase,epsilon_uppercase,zeta_uppercase,eta_uppercase,theta_uppercase,iota_uppercase,kappa_uppercase,lambda_uppercase,mu_uppercase,nu_uppercase,xi_uppercase,omicron_uppercase,pi_uppercase,rho_uppercase,sigma_uppercase,tau_uppercase,upsilon_uppercase,phi_uppercase,chi_uppercase,psi_uppercase,omega_uppercase';
    private static $infinity_buttons = 'infinity';
    private static $matrix_buttons = 'matrix_parenthesis';

    /**
     * Defines any custom form elements needed when creating the question.
     *
     * @override
     * @param object $mform the object being built
     */
    protected function definition_inner($mform) {
        global $PAGE, $DB;

        // All the external requirements
        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/js/mathquill.min.js'));
        $PAGE->requires->css(new moodle_url('/question/type/mathexpression/css/mathquill.css'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/js/matheditor.js'));
        $PAGE->requires->css(new moodle_url('/question/type/mathexpression/css/matheditor.css'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/all_strings.php'));
        $PAGE->requires->js(new moodle_url('/question/type/mathexpression/mathexpression.js'));
        $PAGE->requires->css(new moodle_url('/question/type/mathexpression/styles.css'));

        // Configuration form

        $actions = $DB->get_records('qtype_mathexpression_action');
        $operator_buttons = array();
        foreach($actions as $action)
        {
            $operator_buttons[] =$action->name;
        }
        $operator_buttons = implode(',', $operator_buttons);
        $mform->addElement('html', html_writer::script('var actions = '.json_encode($actions).''));
        $mform->addElement('header', 'configheader', get_string('configuration', 'qtype_mathexpression'), true);
        $mform->setExpanded('configheader', 1);

        $mform->addElement('checkbox', 'mathbuttongroups', get_string('buttongroups', 'qtype_mathexpression'),
            get_string('operators', 'qtype_mathexpression'), array('data-math' => $operator_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('superscript', 'qtype_mathexpression'),
            array('data-math' => self::$superscript_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('trigonometry', 'qtype_mathexpression'),
            array('data-math' => self::$trigonometry_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('logs/exponential', 'qtype_mathexpression'),
            array('data-math' => self::$log_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('greeklower', 'qtype_mathexpression'),
            array('data-math' => self::$greek_lower_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('greekupper', 'qtype_mathexpression'),
            array('data-math' => self::$greek_upper_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('infinity', 'qtype_mathexpression'),
            array('data-math' => self::$infinity_buttons));
        $mform->addElement('checkbox', 'mathbuttongroups', '', get_string('matrix', 'qtype_mathexpression'),
            array('data-math' => self::$matrix_buttons));

        $mform->addElement('textarea', 'buttonlist', get_string('buttonlist', 'qtype_mathexpression'),
            array('rows' => 6, 'cols' => 80));
        $mform->addHelpButton('buttonlist', 'buttonlist', 'qtype_mathexpression');
        $mform->setDefault('buttonlist', self::$operator_buttons.','.self::$superscript_buttons.','.self::$trigonometry_buttons
            .','.self::$log_buttons.','.self::$infinity_buttons.','.self::$matrix_buttons);

        $comparetypes = array('simple' => get_string('simple', 'qtype_mathexpression'),
            'full' => get_string('full', 'qtype_mathexpression'));

        $select = $mform->addElement('select', 'comparetype', 
            get_string('comparetype', 'qtype_mathexpression'), $comparetypes);
        $select->setSelected('full');
        $mform->addHelpButton('comparetype', 'comparetype', 'qtype_mathexpression');

        // Answers

        $mform->addElement('header', 'answerheader', get_string('answers', 'qtype_mathexpression'), true);
        $mform->setExpanded('answerheader', 1);

        $repeated_answers = array();
        $repeated_answers[] = $mform->createElement('static', 'matheditor', get_string('answer', 'qtype_mathexpression'),
           $this->math_editor('answer-matheditor', '#id_buttonlist'));

        $repeated_answers[] = $mform->createElement('hidden', 'answer', '');
        $mform->setType('answer', PARAM_RAW);

        $repeated_answers[] = $mform->createElement('select', 'fraction', get_string('grade'), question_bank::fraction_options());

        $repeated_answers[] = $mform->createElement('editor', 'feedback', get_string('feedback', 'question'), array('rows' => 5),
            $this->editoroptions);

        $number_answers = 1;
        if(isset($this->question->id)) {
            $number_answers = $DB->count_records('question_answers', array('question' => $this->question->id));
        }

        $this->repeat_elements($repeated_answers, $number_answers, array(), 'answer_number', 'add_answer', 1,
            get_string('addanswer', 'qtype_mathexpression'), true);

        // Variables

        $mform->addElement('header', 'variablesheader',
            get_string('variables', 'qtype_mathexpression'), true);
        $mform->setExpanded('variablesheader', 1);

        $mform->addElement('static', 'vars_help', '', get_string('vars_help', 'qtype_mathexpression'));

        $repeated_vars = array();
        $repeated_vars[] = $mform->createElement('static', 'matheditor',
            get_string('variable', 'qtype_mathexpression'),
            $this->math_editor('variable-matheditor'));
        $repeated_vars[] = $mform->createElement('hidden', 'variable', '');
        $mform->setType('variable', PARAM_RAW);

        $number_vars = 0;
        if(isset($this->question->id)) {
            $number_vars = $DB->count_records('qtype_mathexpression_vars', array('questionid' => $this->question->id));
        }

        $this->repeat_elements($repeated_vars, $number_vars, array(), 'variable_number', 'add_variable', 1,
            get_string('addvariable', 'qtype_mathexpression'), true);

        // Excludes

        $mform->addElement('header', 'excludedheader',
            get_string('excludedexpressions', 'qtype_mathexpression'), true);
        $mform->setExpanded('excludedheader', 1);

        $mform->addElement('static', 'exclude_help', '', get_string('exclude_help', 'qtype_mathexpression'));

        $repeated = array();
        $repeated[] = $mform->createElement('static', 'matheditor',
            get_string('exclude', 'qtype_mathexpression'),
            $this->math_editor('exclude-matheditor'));
        $repeated[] = $mform->createElement('hidden', 'exclude', '');
        $mform->setType('exclude', PARAM_RAW);

        $number = 0;
        if(isset($this->question->id)) {
            $number = $DB->count_records('qtype_mathexpression_exclude', array('questionid' => $this->question->id));
        }

        $this->repeat_elements($repeated, $number, array(), 'exclude_number', 'add_exclude', 1,
            get_string('addexcludedexpression', 'qtype_mathexpression'), true);

        $this->add_interactive_settings();
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

            $variables = $DB->get_records('qtype_mathexpression_vars', array('questionid' => $question->id));
            $question->variable = array();
            foreach($variables as $var) {
                $question->variable[] = $var->variable;
            }
            $question->variable_number = count($variables);
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

        $answers = $data['answer'];
        $answercount = 0;
        $maxgrade = false;
        foreach ($answers as $key => $answer) {
            $trimmedanswer = trim($answer);
            if ($trimmedanswer !== '') {
                $answercount++;
                if ($data['fraction'][$key] == 1) {
                    $maxgrade = true;
                }
            } else if ($data['fraction'][$key] != 0 ||
                    !html_is_blank($data['feedback'][$key]['text'])) {
                $errors["fraction[$key]"] = get_string('answermustbegiven', 'qtype_mathexpression');
                $answercount++;
            }
        }
        if ($answercount==0) {
            $errors['fraction[0]'] = get_string('notenoughanswers', 'qtype_mathexpression', 1);
        }
        if ($maxgrade == false) {
            $errors['fraction[0]'] = get_string('fractionsnomax', 'question');
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
     * @param identifier_buttonlist the list of buttons
     * @return string html
     */
    private function math_editor($class, $identifier_buttonlist=null) {
        $result = '<div class="'.$class.'"';
        if($identifier_buttonlist) {
            $result .= ' data-matheditor-buttons="'.$identifier_buttonlist.'"';
        }
        $result .= '>';
        $result .= '</div>';
        return $result;
    }
}
