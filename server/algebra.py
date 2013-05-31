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


def convert_latex(latex):
    """Converts the given latex into its algebraic form. Note not all latex has
    an algebraic equivalent, therefore this method is fairly retricted to basic
    operations like sqrt, logs, trigonometry, fractions, etc. Returns the
    algebra string.

    For example, the quadratic equation is represented in LaTeX by:
    "\\frac{-b+\\sqrt{b^2-4ac}}{2a}"
    Gets converted to its algebraic equivalent:
    "(-b+sqrt(b^2-4ac))/(2a)"

    Arguments:
    latex -- the latex string

    """
    # First step is to replace the symbols
    latex = convert_symbols_(latex)
    # Next we replace functions (eg. sqrt)
    latex = convert_functions_(latex)
    # Finally we replace all instances of curly brackets by their parenthesis equivalents
    latex = latex.replace('{', '(')
    latex = latex.replace('}', ')')

    return latex


class SymbolConversion:
    """Object representing a symbol conversion.

    Attributes:
    regex -- the symbol in Latex (eg. \\times)
    output -- the algebraic equivalent of the symbol (eg. *)

    """
    def __init__(self, regex, output):
        self.regex = regex
        self.output = output


class FunctionConversion:
    """Object representing a function conversion.

    Attributes:
    name -- the function name in Latex (eg. \\sqrt)
    arguments -- the number of arguments in curly brackets for this function
        in latex, (eg. \\sqrt has 1, \\frac has 2)
    output -- how the function should be output, children are represented by
        "$_" placeholders (eg. \\frac is output by "($1)/($2)")

    """
    def __init__(self, name, arguments, output):
        self.name = name
        self.arguments = arguments
        self.output = output

# See the SymbolConversion class definition for more information
symbol_conversions = [
    SymbolConversion('\\bullet', '*'),
    SymbolConversion('\\cdot', '*'),
    SymbolConversion('\\cos', 'cos'),
    SymbolConversion('\\div', '/'),
    SymbolConversion('\\times', '*'),
    SymbolConversion('\\left(', '('),
    SymbolConversion('\\ln', 'ln'),
    SymbolConversion('\\log', 'log'),
    SymbolConversion('\\right)', ')'),
    SymbolConversion('\\sin', 'sin'),
    SymbolConversion('\\tan', 'tan'),

    # Greek
    SymbolConversion('\\alpha', 'alpha'),
    SymbolConversion('\\beta', 'beta'),
    SymbolConversion('\\gamma', 'gamma'),
    SymbolConversion('\\Gamma', 'Gamma'),
    SymbolConversion('\\delta', 'delta'),
    SymbolConversion('\\epsilon', 'epsilon'),
    SymbolConversion('\\zeta', 'zeta'),
    SymbolConversion('\\eta', 'eta'),
    SymbolConversion('\\theta', 'theta'),
    SymbolConversion('\\Theta', 'Theta'),
    SymbolConversion('\\iota', 'kappa'),
    SymbolConversion('\\lambda', 'lambda'),
    SymbolConversion('\\Lambda', 'Lambda'),
    SymbolConversion('\\mu', 'mu'),
    SymbolConversion('\\nu', 'nu'),
    SymbolConversion('\\xi', 'xi'),
    SymbolConversion('\\Xi', 'Xi'),
    SymbolConversion('\\pi', 'pi'),
    SymbolConversion('\\Pi', 'Pi'),
    SymbolConversion('\\rho', 'rho'),
    SymbolConversion('\\sigma', 'sigma'),
    SymbolConversion('\\Sigma', 'Sigma'),
    SymbolConversion('\\tau', 'tau'),
    SymbolConversion('\\upsilon', 'upsilon'),
    SymbolConversion('\\phi', 'phi'),
    SymbolConversion('\\Phi', 'Phi'),
    SymbolConversion('\\chi', 'chi'),
    SymbolConversion('\\psi', 'psi'),
    SymbolConversion('\\Psi', 'Psi'),
    SymbolConversion('\\omega', 'omega'),
    SymbolConversion('\\Omega', 'Omega')
]

# See the FunctionConversion class definition for more information
function_conversions = [
    FunctionConversion('\\frac', 2, '($1)/($2)'),
    FunctionConversion('\\sqrt', 1, 'sqrt($1)')
]


def convert_symbols_(latex):
    """Replaces all symbols in the latex string by their algebra equivalents.
    All symbol replacement schemes are defined in the symbol_conversions
    array. Returns a string with the replaced symbols.

    For example, in latex a multiplication is represented by "\\times", this
    will simply replace this symbol by its algebraic equivalent - "*".

    Arguments:
    latex -- the latex string

    """
    for conversion in symbol_conversions:
        latex = latex.replace(conversion.regex, conversion.output)

    return latex


def convert_functions_(latex):
    """Replaces all functions in the latex string by their algebra equivalents.
    All function replacement schemes are defined in the function_conversions
    array. Returns a string with the replaced functions.

    For example, in latex a fraction is represented by "\\frac{top}{bottom}",
    this will simply replace this function by its algebraic equivalent -
    "(top)/(bottom)".

    Arguments:
    latex -- the latex string

    """
    # Go through each function in the function_conversions array
    for conversion in function_conversions:
        location = latex.find(conversion.name)

        # Iterate through each instance of the function within the string
        while location != -1:
            pre_string = latex[0:location]

            location = location + len(conversion.name)

            # Store each argument inside an array to be used later, each
            # argument is enclosed within curly brackets {}
            args = []
            string_index = location
            for argument in range(0, conversion.arguments):
                bracket_stack = []
                first_bracket = False

                arg_value = ''
                while ((len(bracket_stack) != 0 and string_index < len(latex))
                        or not first_bracket):
                    character = latex[string_index]
                    if character == '{':
                        bracket_stack.append(True)
                        # Only include a bracket if the first one has been seen already
                        if first_bracket:
                            arg_value = arg_value + '{'
                        first_bracket = True
                    elif character == '}':
                        bracket_stack.pop()
                        # Don't include the final bracket
                        if len(bracket_stack) != 0:
                            arg_value = arg_value + '}'
                    else:
                        arg_value = arg_value + character

                    string_index = string_index + 1

                args.append(arg_value)

            post_string = latex[string_index:len(latex)]

            output = conversion.output
            for argument in range(0, conversion.arguments):
                output = output.replace('$' + str(argument+1), args[argument])

            latex = pre_string + output + post_string
            # Reset location pointer to beginning of new content
            location = len(pre_string)
            location = latex.find(conversion.name, location)

    return latex
