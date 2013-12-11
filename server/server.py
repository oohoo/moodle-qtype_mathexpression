#/**
# * *************************************************************************
# * *                            MathExpression                            **
# * *************************************************************************
# * @package     question                                                  **
# * @subpackage  mathexpression                                            **
# * @name        MathExpression                                            **
# * @copyright   oohoo.biz, Roger Moore                                    **
# * @link        http://oohoo.biz                                          **
# * @author      Raymond Wainman, Roger Moore                              **
# * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
# * *************************************************************************
# * ************************************************************************ */

import web
import sageserver
import json


urls = (
    '/sage/simple', 'sage_simple',
    '/sage/evaluate', 'sage_evaluate',
    '/sage/full', 'sage_full'
)


class sage_simple:
    def GET(self):
        args = web.input(answer='', response='', vars='[]')
        result = sageserver.simple_compare(args.answer, args.response, json.loads(args.vars))
        return json.dumps(result)

    def POST(self):
        return self.GET()


class sage_full:
    def GET(self):
        args = web.input(answer='', response='', vars='[]', exclude='[]')
        web.debug('VARS');
        web.debug(json.loads(args.vars.encode('unicode-escape')));
        result = sageserver.full_compare(args.answer, args.response, json.loads(args.vars.encode('unicode-escape')),
                                         json.loads(args.exclude.encode('unicode-escape')))
        return json.dumps(result)

    def POST(self):
        return self.GET()

if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()
