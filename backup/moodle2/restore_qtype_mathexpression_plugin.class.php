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

class restore_qtype_mathexpression_plugin extends restore_qtype_plugin {

    protected function define_question_plugin_structure() {
        $paths = array();

        $elename = 'options';
        $elepath = $this->get_pathfor('/options');
        $paths[] = new restore_path_element($elename, $elepath);

        $elename = 'exclude';
        $elepath = $this->get_pathfor('/excludes/exclude');
        $paths[] = new restore_path_element($elename, $elepath);

        $elename = 'var';
        $elepath = $this->get_pathfor('/vars/var');
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths;
    }

    public function process_options($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Detect if the question is created or mapped.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;

        if($questioncreated) {
            $data->questionid = $newquestionid;
            $newitemid = $DB->insert_record('qtype_mathexpression_options', $data);
            $this->set_mapping('qtype_mathexpression_options', $oldid, $newitemid);
        }
    }

    public function process_exclude($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Detect if the question is created or mapped.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;

        if($questioncreated) {
            $data->questionid = $newquestionid;

            $newitemid = $DB->insert_record('qtype_mathexpression_exclude', $data);
            $this->set_mapping('qtype_mathexpression_exclude', $oldid, $newitemid);
        }
    }

    public function process_var($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        // Detect if the question is created or mapped.
        $oldquestionid   = $this->get_old_parentid('question');
        $newquestionid   = $this->get_new_parentid('question');
        $questioncreated = $this->get_mappingid('question_created', $oldquestionid) ? true : false;

        if($questioncreated) {
            $data->questionid = $newquestionid;

            $newitemid = $DB->insert_record('qtype_mathexpression_vars', $data);
            $this->set_mapping('qtype_mathexpression_vars', $oldid, $newitemid);
        }
    }
}
