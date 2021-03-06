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

class qtype_mathexpression extends question_type {
    /**
     * Saves question-type specific options
     *
     * @override
     * @param object $question  This holds the information from the editing form, it is not a
     *      standard question object
     * @return object $result->error or $result->noticeyesno or $result->notice
     */
    public function save_question_options($question) {
        global $DB;

        $result = new stdClass();

        // Remove old answers
        $DB->delete_records('question_answers', array('question' => $question->id));

        // Remove old options
        $DB->delete_records('qtype_mathexpression_options', array('questionid' => $question->id));

        // Remove old excluded answers
        $DB->delete_records('qtype_mathexpression_exclude', array('questionid' => $question->id));

        // Remove old variables
        $DB->delete_records('qtype_mathexpression_vars', array('questionid' => $question->id));

        // Insert new answers
        for($i = 0; $i < count($question->answer); $i++) {
            $answer = new stdClass();
            $answer->question = $question->id;
            $answer->answer = $question->answer[$i];
            $answer->fraction = $question->fraction[$i];
            $answer->feedback = $question->feedback[$i]['text'];
            $answer->feedbackformat = $question->feedback[$i]['format'];
            $answer->id = $DB->insert_record('question_answers', $answer);
        }

        // Insert new options
        $options = new stdClass();
        $options->questionid = $question->id;
        $options->buttonlist = $question->buttonlist;
        $options->comparetype = $question->comparetype;
        $options->id = $DB->insert_record('qtype_mathexpression_options', $options);

        // Insert excluded expressions (if applicable)
        if($question->comparetype == 'full') {
            $excluded = new stdClass();
            $excluded->questionid = $question->id;
            if(isset($question->exclude)) {
                for($i = 0; $i < sizeof($question->exclude); $i++) {
                    $expression = $question->exclude[$i];
                    if($expression != '') {
                        $excluded->answer = $expression;
                        $DB->insert_record('qtype_mathexpression_exclude', $excluded);
                    }
                }
            }
        }

        // Insert variables
        if(isset($question->variable)) {
            $var = new stdClass();
            $var->questionid = $question->id;
            for($i = 0; $i < sizeof($question->variable); $i++) {
                $expr = $question->variable[$i];
                if($expr != '') {
                    $var->variable = $expr;
                    $DB->insert_record('qtype_mathexpression_vars', $var);
                }
            }
        }

        $parentresult = parent::save_question_options($question);
        if ($parentresult !== null) {
            // Parent function returns null if all is OK.
            return $parentresult;
        }
    }
    
    /**
     * Initialises the custom fields within the {@code qtype_mathexpression_question} class.
     *
     * @override
     * @param question_definition $question the question_definition we are creating
     * @param object $questiondata the question data loaded from the database
     */
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        global $DB;
        parent::initialise_question_instance($question, $questiondata);

        foreach($questiondata->options->answers as $answer) {
            if($answer->fraction == 1) {
                $question->correctanswer = $answer->answer;
            }
        }
        $question->answers = $questiondata->options->answers;

        $options = $DB->get_record('qtype_mathexpression_options',array('questionid' => $questiondata->id));
        $question->buttonlist = $options->buttonlist;
        $question->comparetype = $options->comparetype;

        $excluded = $DB->get_records('qtype_mathexpression_exclude', array('questionid' => $questiondata->id));
        $question->exclude = array();
        foreach($excluded as $excl) {
            $question->exclude[] = $excl->answer;
        }

        $variables = $DB->get_records('qtype_mathexpression_vars', array('questionid' => $questiondata->id));
        $question->variable = array();
        foreach($variables as $var) {
            $question->variable[] = $var->variable;
        }
    }
}
