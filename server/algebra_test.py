#/**
# * *************************************************************************
# * *                            MathExpression                            **
# * *************************************************************************
# * @package     question                                                  **
# * @subpackage  mathexpression                                            **
# * @name        MathExpression                                            **
# * @copyright   oohoo.biz                                                 **
# * @link        http://oohoo.biz                                          **
# * @author      Raymond Wainman (wainman@ualberta.ca)                     **
# * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
# * *************************************************************************
# * ************************************************************************ */

import unittest
import algebra


class TestAlgebra(unittest.TestCase):

    def test_convert_symbols_empty(self):
        result = algebra.convert_symbols_('')
        self.assertEqual(result, '')

    def test_convert_symbols_simple(self):
        result = algebra.convert_symbols_('\\times')
        self.assertEqual(result, '*')

    def test_convert_symbols_complex(self):
        result = algebra.convert_symbols_('123\\times856+963\\times45^2')
        self.assertEqual(result, '123*856+963*45^2')

    def test_convert_symbols_invalid(self):
        result = algebra.convert_symbols_('123\\time856+963\\times45^2')
        self.assertEqual(result, '123\\time856+963*45^2')

    def test_convert_functions_empty(self):
        result = algebra.convert_functions_('')
        self.assertEqual(result, '')

    def test_convert_functions_simple(self):
        result = algebra.convert_functions_('\\sqrt{123}')
        self.assertEqual(result, 'sqrt(123)')

    def test_convert_functions_simple_multiple_args(self):
        result = algebra.convert_functions_('\\frac{123}{5a}')
        self.assertEqual(result, '(123)/(5a)')

    def test_convert_functions_simple_nested_brackets(self):
        result = algebra.convert_functions_('\\sqrt{5a+{i}}')
        self.assertEqual(result, 'sqrt(5a+{i})')

    def test_convert_functions_simple_nested_function(self):
        result = algebra.convert_functions_('\\sqrt{5a+\\sqrt{i}}')
        self.assertEqual(result, 'sqrt(5a+sqrt(i))')

    def test_convert_functions_complex(self):
        result = algebra.convert_functions_('\\sqrt{5a+\\frac{i}{a}}')
        self.assertEqual(result, 'sqrt(5a+(i)/(a))')

    def test_convert_functions_complex_nested(self):
        result = algebra.convert_functions_('\\sqrt{5a+\\frac{\\frac{23}{2}}{a}}')
        self.assertEqual(result, 'sqrt(5a+((23)/(2))/(a))')

    def test_convert_latex(self):
        result = algebra.convert_latex('\\frac{-b+\\sqrt{b^2-4ac}}{2a}')
        self.assertEqual(result, '(-b+sqrt(b^2-4ac))/(2a)')

    def test_convert_latex_leftright(self):
        result = algebra.convert_latex('\\left(a+b\\right)')
        self.assertEqual(result, '(a+b)')


if __name__ == '__main__':
    unittest.main()
