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

class qtype_mathexpression_question extends question_graded_automatically
{

    /** @var string valid LaTeX representation of the answer */
    public $correctanswer;

    /** @var array of strings for excluded answers */
    public $exclude;

    /** @var string compare type, how the answer is evaluated */
    public $comparetype;

    /**
     * Assigns an expected data type for the user answer. These types are defined in the
     * {@code lib/moodlelib.php} file and are prefixed by {@code PARAM_}. For this question type,
     * only a single field is given by the user and it is called {@code answer}.
     *
     * @override
     * @return array storing (variable name) => (variable type)
     */
    public function get_expected_data()
    {
        return array('answer' => PARAM_RAW);
    }

    /**
     * Assigns a correct answer for the given variable name. That is, use this value when comparing
     * the user answer to determine if it is correct.
     *
     * @override
     * @return array storing (variable name) => (correct answer)
     */
    public function get_correct_response()
    {
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
    public function is_complete_response(array $response)
    {
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
    public function summarise_response(array $response)
    {
        if (isset($response['answer']))
        {
            // Return MathJax renderable text
            return '\(' . $response['answer'] . '\)';
        }
        else
        {
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
    public function is_same_response(array $prevresponse, array $newresponse)
    {
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
    public function get_validation_error(array $response)
    {
        return get_string('pleaseenteranswer', 'qtype_mathexpression');
    }

    /**
     * Convert a Macro like Latex string in the desired language
     * @global moodle_database $DB
     * @param int $languageid The language ID for the translation
     * @param string $latex The macro like latex string
     * @return string
     */
    public function get_language_translation($languageid, $latex)
    {
        global $DB;
        $translations = array();
        $result = $latex;

        $sql = 'SELECT a.id AS id, a.name as macro, t.translation AS translation '
                . 'FROM {qtype_mathexpression_trad} AS t '
                . '   JOIN {qtype_mathexpression_action} AS a ON a.id = t.actionid '
                . 'WHERE t.langid = ?';
        $translations = $DB->get_records_sql($sql, array($languageid));
        $regex = '/(?:\{((?:[^{}]++|\{(?1)\})++)\})/';
        $params = array();

        //Search and replace each translation
        foreach ($translations as $translation)
        {
            //The number of params is needed from the translation
            $nbParams = substr_count($translation->translation, '%s');
            $nextPos = strpos($result, '\\' . $translation->macro);
            //While there is this macro we replace it
            while ($nextPos !== false)
            {
                $length_macroname = strlen('\\' . $translation->macro);
                
                //Search all the occurences of {text}{text}....
                preg_match_all($regex, substr($result, $nextPos), $params);

                $params_with_braces = $params[0];
                $params_clean = $params[1];
                $length_params = 0;

                //Get the size of the params
                for ($i = 0; $i < $nbParams; $i++)
                {
                    $length_params += strlen($params_with_braces[$i]);
                }
                //Build the start and end of the string
                $start = substr($result, 0, $nextPos);
                $end = substr($result, strlen($start) + $length_macroname + $length_params);

//                echo "<br/>";
//                echo "RESULT BEFORE TRANSFORM=$result<br/>";

                //Put the translation with the params
                $result = $start . vsprintf($translation->translation, $params_clean) . $end;

//                echo "MACRO ACTION=$translation->macro<br/>";
//                echo "START=$start<br/>";
//                echo "TRANSLATION STRING=$translation->translation<br/>";
//                echo "RESULT=$result<br/>";
//                echo "END=$end<br/>";
//                print_object($params_clean);

                //Search the next position
                $nextPos = strpos($result, '\\' . $translation->macro);
            }
        }
        return $result;
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
    public function grade_response(array $response)
    {
        global $CFG, $DB;
        
        //Get the language
        $sage_language = $DB->get_record('qtype_mathexpression_lang', array('name' => 'Sage Math'));

        //Replace the latex in the variable and the exclude
        foreach($this->variable as $key => $var)
        {
            $this->variable[$key] = $this->get_language_translation($sage_language->id, $var);
        }
        foreach($this->exclude as $key => $var)
        {
            $this->exclude[$key] = $this->get_language_translation($sage_language->id, $var);
        }
        
        $fields = array('response' => $this->get_language_translation($sage_language->id, $response['answer']),
            'vars' => json_encode($this->variable));
        $this->get_language_translation($sage_language->id, $response['answer']);

        $url = $CFG->qtype_mathexpression_sageserver;
        if ($url == '')
        {
            throw new moodle_exception('Must provide a Sage server URL in the Question Type settings');
        }

        if ($this->comparetype == 'full')
        {
            $url .= '/full';
            $fields['exclude'] = json_encode($this->exclude);
        }
        else if ($this->comparetype == 'simple')
        {
            $url .= '/simple';
        }
        else
        {
            throw new moodle_exception('Invalid Math Expression compare type');
        }
         
        $fraction = 0;
        foreach ($this->answers as $answer)
        {
            $fields['answer'] = $this->get_language_translation($sage_language->id, $answer->answer);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_response = curl_exec($ch);
            curl_close($ch);
            try
            {
                $sage_result = json_decode($server_response);
                if ($sage_result->result)
                {
                    $fraction = $answer->fraction;
                }
            }
            catch (Exception $e)
            {
                // Do nothing, fraction is already 0
            }
        }

        // Utilize the user defined state for the given fraction value, see the question_state
        // documentation for more information
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

}
