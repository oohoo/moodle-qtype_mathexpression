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

import mathml as mathmlconv
import os
import web

from sage.all import *
from sage.calculus.calculus import symbolic_expression_from_string
from sage.misc.preparser import preparse
from exceptions import SyntaxError


def prep_variables(vars):
    """ Converts the given MathML formatted variables into their equivalent
        Sage representation.
        @type vars: list
        @param vars: the list of variables in MathML format
        @rtype: list
        @return: the list of variables in Sage format
    """
    placeholders = ['a', 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n',
                    'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
    variables = []
    used_vars = []
    for x in range(0, len(vars)):
        variables.append(mathmlconv.mathmlToSage(vars[x]))
        used_vars.append((placeholders[x], var(placeholders[x])))
    return variables, used_vars


def replace_variables(expr, variables, placeholders):
    """ Replaces the variables defined in the variables list by simple
        placeholders. This allows complex variables (such as theta_{12}) to be
        replaced by simpler terms that are better understood by Sage.
        @type expr: string
        @param expr: the expression
        @type variables: list
        @param variables: list of variables to be replaced
        @rtype: string
        @return: the expression with the replaced variables
    """
    web.debug(placeholders)
    for x in range(0, len(variables)):
        expr = expr.replace(variables[x], '(' + placeholders[x][0] + ')')
    return expr


def prep_expression(expr, variables, placeholders):
    expr = mathmlconv.mathmlToSage(expr)
    expr = replace_variables(expr, variables, placeholders)
    #expr = preparse(expr)
    #expr = expr.replace('Integer', '')
    #expr = expr.replace('RealNumber', '')
    web.debug(expr)
    vars = {}
    for var in placeholders:
        vars[var[0]] = var[1]
    try:
        expr = sage_eval(expr, vars)
    except SyntaxError, e:
        web.debug("Error parsing : %s" % e)
        return sage_eval('')
    return expr


def simple_compare(answer, response, vars=[]):
    """ Performs a simple symbolic comparison between two expressions.
        This method will perform a very simple comparision between two
        algebraic expressions. No expansion or factorization is performed
        hence expressions like "(x+1)^2" and "(1+x)^2" will evaluate as
        the same but expressions like "(x+1)^2" and "x^2+2*x+1" will not.
        @type answer: string
        @param answer: the first expression to compare
        @type response: string
        @param response: the second expression to compare
        @type vars: array
        @param vars: an array of variable names used in the expressions
        @rtype: bool
        @return: true if the expressions are equal, false otherwise
    """
    web.debug("Simple compare of '%s' to '%s' with variables %s" %
             (answer, response, vars))
    sage.misc.preparser.implicit_multiplication(10)  # Configure Sage

    variables, placeholders = prep_variables(vars)
    answer = prep_expression(answer, variables, placeholders)
    response = prep_expression(response, variables, placeholders)

    f = answer-response
    # Simply check to see if the representation of the expression is
    # a string containing the single character '0'.
    result = {
        'answer': str(answer),
        'response': str(response),
        'result': (f.__repr__() == '0')
    }
    web.debug(str(result))
    return result


def full_compare(answer, response, vars=[], exclude=[]):
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
    web.debug("Full compare of %s to %s with variables %s excluding %s" %
             (answer, response, str(vars), str(exclude)))
    sage.misc.preparser.implicit_multiplication(10)  # Configure Sage

    variables, placeholders = prep_variables(vars)

    answer = prep_expression(answer, variables, placeholders)
    response = prep_expression(response, variables, placeholders)

    # First check for exlcuded responses
    for exc in exclude:
        # Create and expression from the excluded string
        exc = prep_expression(exc, variables, placeholders)
        # Take a difference between the excluded expression and the
        # response provided by the student
        diff = response-exc
        # See if the difference has a representation of zero. If so it
        # matches with a simple comparison and so should be exlcuded.
        if diff.__repr__() == '0':
            # Response is excluded so immediately return false
            result = {
                'answer': str(answer),
                'response': str(response),
                'result': False
            }
            web.debug(str(result))
            return result

    # Create an expression that is the difference of the answer and response
    f = answer-response
    # Simply use the 'is_zero' method to determine if the expressions are
    # equal. There is no need to perform 'simplify_full'.
    result = {
        'answer': str(answer),
        'response': str(response),
        'result': f.is_zero()
    }
    web.debug(str(result))
    return result
