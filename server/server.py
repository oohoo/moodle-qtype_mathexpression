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
        args = web.input(expr1='', expr2='', vars='')
        result = sageserver.simple_compare(args.expr1, args.expr2, json.loads(args.vars))
        return json.dumps(result)

    def POST(self):
        return self.GET()


class sage_evaluate:
    def GET(self):
        args = web.input(expr='')
        result = sageserver.evaluate_expression(args.expr)
        return json.dumps(result)

    def POST(self):
        return self.GET()


class sage_full:
    def GET(self):
        args = web.input(expr1='', expr2='', vars='[]', exclude='[]')
        result = sageserver.full_compare(args.expr1, args.expr2, json.loads(args.vars), json.loads(args.exclude))
        return json.dumps(result)

    def POST(self):
        return self.GET()

if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()
