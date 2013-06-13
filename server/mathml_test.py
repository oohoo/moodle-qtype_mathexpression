import unittest
import mathml


class TestMathML(unittest.TestCase):
    def test_convert_mathmltag(self):
        result = mathml.mathmlToSage('<math/>')
        self.assertEqual(result, '')

    def test_convert_simpleadd(self):
        result = mathml.mathmlToSage('<math><mi>a</mi><mo>+</mo><mi>b</mi></math>')
        self.assertEqual(result, '(a)+(b)')

    def test_convert_mfrac(self):
        result = mathml.mathmlToSage('<math><mfrac><mi>a</mi><mi>b</mi></mfrac></math>')
        self.assertEqual(result, '((a))/((b))')

    def test_convert_mqrt(self):
        result = mathml.mathmlToSage('<math><msqrt><mi>a</mi><mi>b</mi></msqrt></math>')
        self.assertEqual(result, 'sqrt((a)(b))')

    def test_convert_msup(self):
        result = mathml.mathmlToSage('<math><msup><mi>b</mi><mn>2</mn></msup></math>')
        self.assertEqual(result, '(((b))^((2)))')

    def test_quadratic(self):
        test = '<math mode="display" xmlns="http://www.w3.org/1998/Math/MathML"><mrow><mfrac>'
        test = test + '<mrow><mo>-</mo><mi>b</mi><mo>+</mo><msqrt><msup><mi>b</mi><mn>2</mn>'
        test = test + '</msup><mo>-</mo><mn>4</mn><mi>a</mi><mi>c</mi></msqrt></mrow><mrow>'
        test = test + '<mn>2</mn><mi>a</mi></mrow></mfrac></mrow></math>'
        result = mathml.mathmlToSage(test)
        self.assertEqual(result, '(-(b)+sqrt((((b))^((2)))-(4)(a)(c)))/((2)(a))')


if __name__ == '__main__':
    unittest.main()
