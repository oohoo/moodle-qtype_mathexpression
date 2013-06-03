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

import algebra
import os
import web

from sage.all import *
from sage.calculus.calculus import symbolic_expression_from_string
from exceptions import SyntaxError


def simple_compare(expr1, expr2, vars):
    """ Performs a simple symbolic comparison between two expressions.
        This method will perform a very simple comparision between two
        algebraic expressions. No expansion or factorization is performed
        hence expressions like "(x+1)^2" and "(1+x)^2" will evaluate as
        the same but expressions like "(x+1)^2" and "x^2+2*x+1" will not.
        @type expr1: string
        @param expr1: the first expression to compare
        @type expr2: string
        @param expr2: the second expression to compare
        @type vars: array
        @param vars: an array of variable names used in the expressions
        @rtype: bool
        @return: true if the expressions are equal, false otherwise
    """
    web.debug("Simple compare of '%s' to '%s' with variables %s" %
             (expr1, expr2, vars))
    expr1 = algebra.convert_latex(expr1)
    expr2 = algebra.convert_latex(expr2)
    f = symbolic_expression_from_string("(%s)-(%s)" % (expr1, expr2))
    # Simply check to see if the representation of the expression is
    # a string containing the single character '0'.
    result = {
        'expr1': expr1,
        'expr2': expr2,
        'result': (f.__repr__() == '0')
    }
    return result


def full_compare(answer, response, vars, exclude=[]):
    """ Performs a full symbolic comparison between two expressions.
        This method will perform a full comparison between the two
        expressions passed to it. This will involve fully simplifying each
        and thencomparing to see if the result is the same. A list of the
        variables used must also be passed.

        Optionally a list of excluded expressions can also be passed. If
        the response matches one of the excluded expressions, using the
        simple compare method, then the comparison will return false. This
        is to allow questions such as "expand (x+1)^2" to stop the
        student just entering "(x+1)^2" and have SAGE accept it as a
        match to the correct answer.
        @type answer: string
        @param answer: the answer expression to compare against
        @type response: string
        @param response: the response expression entered by the student
        @type vars: array
        @param vars: an array of variable names used in the expressions
        @type exclude: array
        @param exclude: an array of expressions to exclude as invalid
        @rtype: bool
        @return: true if the expressions are equal, false otherwise
    """
    web.debug("Full compare of '%s' to '%s' with variables '%s' excluding '%s'" %
             (answer, response, ','.join(vars), ';'.join(exclude)))
    try:
        answer = algebra.convert_latex(answer)
        response = algebra.convert_latex(response)
        answer_expr = symbolic_expression_from_string(answer)
        response_expr = symbolic_expression_from_string(response)
    except SyntaxError, e:
        web.debug("Error parsing answer and response expressions: %s" % e)
        f = "Error parsing answer and response expressions: %s" % e
        return f
    # First check for exlcuded responses
    for exc in exclude:
        web.debug(exc)
        exc = algebra.convert_latex(exc)
        web.debug(exc)
        # Create and expression from the excluded string
        expr = symbolic_expression_from_string(exc)
        # Take a difference between the excluded expression and the
        # response provided by the student
        diff = response_expr-expr
        # See if the difference has a representation of zero. If so it
        # matches with a simple comparison and so should be exlcuded.
        web.debug(diff)
        if diff.__repr__() == '0':
            # Response is excluded so immediately return false
            return {
                'expr1': answer,
                'expr2': response,
                'result': False
            }
    # Create an expression that is the difference of the answer and response
    f = answer_expr-response_expr
    # Simply use the 'is_zero' method to determine if the expressions are
    # equal. There is no need to perform 'simplify_full'.
    result = {
        'expr1': answer,
        'expr2': response,
        'result': f.is_zero()
    }
    return result


def evaluate_expression(expr):
    f = symbolic_expression_from_string(expr)
    return f.__repr__()
