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

    def test_convert_mtable_row(self):
        test = '<math xmlns="http://www.w3.org/1998/Math/MathML"><mrow><mo>(</mo>'
        test = test + '<mtable rowspacing="4pt" columnspacing="1em"><mtr><mtd><mn>1</mn></mtd>'
        test = test + '<mtd><mn>2</mn></mtd><mtd><mn>3</mn></mtd></mtr></mtable><mo>)</mo>'
        test = test + '</mrow></math>'
        result = mathml.mathmlToSage(test)
        self.assertEqual(result, '(matrix([(1),(2),(3)]))')

    def test_convert_mtable_col(self):
        test = '<math xmlns="http://www.w3.org/1998/Math/MathML"><mrow><mo>(</mo>'
        test = test + '<mtable rowspacing="4pt" columnspacing="1em"><mtr><mtd><mn>1</mn></mtd>'
        test = test + '</mtr><mtr><mtd><mn>2</mn></mtd></mtr><mtr><mtd><mn>3</mn></mtd></mtr>'
        test = test + '</mtable><mo>)</mo></mrow></math>'
        result = mathml.mathmlToSage(test)
        self.assertEqual(result, '(matrix([(1)],[(2)],[(3)]))')

    def test_convert_mtable(self):
        test = '<math xmlns="http://www.w3.org/1998/Math/MathML"><mrow><mo>(</mo>'
        test = test + '<mtable rowspacing="4pt" columnspacing="1em"><mtr><mtd><mn>1</mn></mtd>'
        test = test + '<mtd><mn>2</mn></mtd></mtr><mtr><mtd><mn>3</mn></mtd><mtd><mn>4</mn></mtd>'
        test = test + '</mtr></mtable><mo>)</mo></mrow></math>'
        result = mathml.mathmlToSage(test)
        self.assertEqual(result, '(matrix([(1),(2)],[(3),(4)]))')


if __name__ == '__main__':
    unittest.main()
