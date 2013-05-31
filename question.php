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

class qtype_mathexpression_question extends question_graded_automatically {
    /** @var string valid LaTeX representation of the answer */
    public $correctanswer;

    /**
     * Assigns an expected data type for the user answer. These types are defined in the
     * {@code lib/moodlelib.php} file and are prefixed by {@code PARAM_}. For this question type,
     * only a single field is given by the user and it is called {@code answer}.
     *
     * @override
     * @return array storing (variable name) => (variable type)
     */
    public function get_expected_data() {
        return array('answer' => PARAM_RAW);
    }

    /**
     * Assigns a correct answer for the given variable name. That is, use this value when comparing
     * the user answer to determine if it is correct.
     *
     * @override
     * @return array storing (variable name) => (correct answer)
     */
    public function get_correct_response() {
        return array('answer' => $this->correctanswer);
    }

    /**
     * Determines if the user response can be considered complete and can subsequently move to the
     * COMPLETE state from the INCOMPLETE one. This function is mostly geared toward questions that
     * require multiple inputs. Since this question type only has a single input, we can simply
     * verify the presence of the user answer and ensure it is not empty.
     *
     * @override
     * @param array $response the user responses (a hash of field => value elements)
     * @return true if the response is complete, false otherwise
     */
    public function is_complete_response(array $response) {
        return !empty($response['answer']);
    }

    /**
     * Produces a plain text summary of the user response, to be used in reports or other
     * feedback components.
     *
     * @override
     * @param array $response the user responses (a hash of field => value elements)
     * @return string plain text summary of user response
     */
    public function summarise_response(array $response) {
        if (isset($response['answer'])) {
            // Return MathJax renderable text
            return '\('.$response['answer'].'\)';
        } else {
            return null;
        }
    }

    /**
     * Given two separate response instances, checks to see if there is a difference between the
     * two. This is used by several responses to test if the user changed their response.
     *
     * @override
     * @param array $prevresponse the previous user responses (a hash of field => value elements)
     * @param array $newresponse the new user responses (a hash of field => value elements)
     * @return true if the responses are the same, false otherwise
     */
    public function is_same_response(array $prevresponse, array $newresponse) {
        // arrays_same_at_key_missing_is_blank is defined in the question/engine/lib.php file
        // it simply compares the two arrays at the given key and checks to see if they are
        // equivalent using ===
        return question_utils::arrays_same_at_key_missing_is_blank(
            $prevresponse, $newresponse, 'answer');
    }

    /**
     * Returns the message shown when a validation error occurs. In this case, this would only
     * happen when {@code is_complete_response} returns false (see 
     * {@link question_graded_automatically}). In other words, the user did not enter a response.
     *
     * @override
     * @param array $response the user responses (a hash of field => value elements)
     * @return string containing validation error
     */
    public function get_validation_error(array $response) {
        return get_string('pleaseenteranswer', 'qtype_mathexpression');
    }

    /**
     * Grades the user response and returns a score along with a question state (right, partial or
     * wrong - see {@link question_state}). The score is some fraction between
     * {@link get_min_fraction()} and {@code 1.0}.
     *
     * @override
     * @param array $response the user responses (a hash of field => value elements)
     * @return array (number, integer) corresponding to the fraction and the state.
     */
    public function grade_response(array $response) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://129.128.136.52:8080/sage/simple");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            array('expr1' => $response['answer'],
                'expr2' => $this->correctanswer,
                'vars' => 'a')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_response = curl_exec($ch);
        echo $server_response;
        $sage_result = json_decode($server_response);
        print_object($sage_result);
        if($sage_result->result) {
            $fraction = 1.0;
        } else {
            $fraction = 0;
        }

        // Utilize the user defined state for the given fraction value, see the question_state
        // documentation for more information
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }
}
