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

$string['addanswer'] = 'Add Answer';
$string['addexcludedexpression'] = 'Add Excluded Expression';
$string['addvariable'] = 'Add Variable';
$string['answer'] = 'Answer';
$string['answermustbegiven'] = 'Answer must be given';
$string['answers'] = 'Answers';
$string['buttongroups'] = 'Button Groups';
$string['buttonlist'] = 'Button List';
$string['buttonlist_help'] = 'This list specifies the buttons that will appear within the response'
    .' math editor and that will be available to the student. This should be a comma delimited '
    .'list of button identifiers. (eg. <code>alpha,square_root,plus</code>).';
$string['comparetype'] = 'Compare Type';
$string['comparetype_help'] = 'How the student\'s response is evaluated. Currently there are two '
    .'methods: <ul><li><b>Simple:</b> Performs a simple symbolic comparison between two '
    .'expressions. No expansion or factorization is performed hence expressions like "(x+1)^2" '
    .'and "(1+x)^2" will evaluate as the same but expressions like "(x+1)^2" and "x^2+2*x+1" will '
    .'not.</li><li><b>Full:</b> Performs a full symbolic comparison between two expressions. '
    .'This will involve fully simplifying each and then comparing to see if the result is the '
    .'same.</li></ul>';
$string['configuration'] = 'Configuration';
$string['correctanswer'] = 'Correct Answer';
$string['exclude'] = 'Exclude';
$string['exclude_help'] = 'An optional list of excluded expressions can be defined. If the '
    .'the response matches one of the excluded expressions<br/> using the simple compare method, '
    .'then the comparison will return false. This is to allow questions such as <br/>'
    .'<code>expand (x+1)^2</code> to stop the student just entering <code>(x+1)^2</code> and have SAGE accept it as a '
    .'match to the correct answer.<br/><br/>';
$string['excludedexpressions'] = 'Excluded Expressions';
$string['full'] = 'Full';
$string['greeklower'] = 'Greek Lower Case';
$string['greekupper'] = 'Greek Upper Case';
$string['infinity'] = 'Infinity';
$string['logs/exponential'] = 'Logarithms/Exponential';
$string['matrix'] = 'Matrix';
$string['mustprovideanswer'] = 'Must provide an answer';
$string['operators'] = 'Operators';
$string['pluginname'] = 'Math Expression';
$string['pluginname_help'] = 'Question type that requires a mathematical expression as an answer';
$string['pluginname_link'] = 'question/type/mathexpression';
$string['pluginnameadding'] = 'Adding a Math Expression question';
$string['pluginnameediting'] = 'Editing a Math Expression question';
$string['pluginnamesummary'] = 'Question type that requires a mathematical expression as an '
    .'answer. Evaluates the expression using a sophisticated Math Engine (SAGE) to compare '
    .'correctness';
$string['pleaseeenteranswer'] = 'Please enter an answer';
$string['sageserver'] = 'Sage Server';
$string['sageserver_help'] = 'URL to a Sage server that is needed to perform expression '
    .'comparisons. Please see the documentation within the Math Expression question type folder '
    .'(and more specifically the server folder) for more details. To test your configuration '
    .'visit <a href="'.$CFG->wwwroot.'/question/type/mathexpression/configcheck.php">'
    .$CFG->wwwroot.'/question/type/mathexpression/configcheck.php</a>';
$string['simple'] = 'Simple';
$string['superscript'] = 'Superscript';
$string['trigonometry'] = 'Trigonometry';
$string['variable'] = 'Variable';
$string['variables'] = 'Variables';
$string['vars_help'] = 'Define all the variables in the equation, these will appear in the student\'s '
    .'answer editor for easy access.<br/>These are also used when evaluating the '
    .'correctness of the answer.<br/><br/>';
$string['youranswer'] = 'Your Answer:';



//------------------------------------------------------------------------------
// All lang texts

$string['mathexpression:absolute_braces'] = 'Absolute Braces';
$string['mathexpression:alef'] = 'Alef';
$string['mathexpression:algebra'] = 'Algebra';
$string['mathexpression:alpha'] = 'Alpha';
$string['mathexpression:alpha_uppercase'] = 'Uppercase Alpha';
$string['mathexpression:angle'] = 'Angle';
$string['mathexpression:angle_braces'] = 'Angle Braces';
$string['mathexpression:approximately'] = 'Approximately';
$string['mathexpression:arccos'] = 'Arccosine';
$string['mathexpression:arcsin'] = 'Arcsine';
$string['mathexpression:arctan'] = 'Arctangent';
$string['mathexpression:arrow_left'] = 'Left Arrow';
$string['mathexpression:arrow_left_long'] = 'Long Left Arrow';
$string['mathexpression:arrow_right'] = 'Right Arrow';
$string['mathexpression:arrow_right_long'] = 'Long Right Arrow';
$string['mathexpression:asymptotically_equal'] = 'Asymptotically Equal';
$string['mathexpression:bar'] = 'Bar';
$string['mathexpression:because'] = 'Because';
$string['mathexpression:beta'] = 'Beta';
$string['mathexpression:beta_uppercase'] = 'Uppercase Beta';
$string['mathexpression:bold'] = 'Bold';
$string['mathexpression:bullet'] = 'Bullet';
$string['mathexpression:calculus'] = 'Calculus';
$string['mathexpression:ceiling'] = 'Ceiling';
$string['mathexpression:chi'] = 'Chi';
$string['mathexpression:chi_uppercase'] = 'Uppercase Chi';
$string['mathexpression:colours'] = 'Colours';
$string['mathexpression:comma'] = 'Comma';
$string['mathexpression:complex'] = 'Complex Numbers';
$string['mathexpression:contains'] = 'Contains';
$string['mathexpression:coproduct'] = 'Coproduct';
$string['mathexpression:coproduct_limits'] = 'Coproduct with limits';
$string['mathexpression:conjunction'] = 'Conjunction';
$string['mathexpression:cos'] = 'Cosine';
$string['mathexpression:cosh'] = 'Hyperbolic Cosine';
$string['mathexpression:cot'] = 'Cotangent';
$string['mathexpression:create'] = 'Create';
$string['mathexpression:csc'] = 'Cosecant';
$string['mathexpression:curly_braces'] = 'Curly Braces';
$string['mathexpression:definition'] = 'Definition';
$string['mathexpression:delta'] = 'Delta';
$string['mathexpression:delta_uppercase'] = 'Uppercase Delta';
$string['mathexpression:derivative'] = 'Derivative';
$string['mathexpression:desc'] = 'Math Editor';
$string['mathexpression:description'] = 'Math Editor';
$string['mathexpression:differential'] = 'Differential';
$string['mathexpression:disjunction'] = 'Disjunction';
$string['mathexpression:division'] = 'Division';
$string['mathexpression:dots_diagonal'] = 'Diagonal Dots';
$string['mathexpression:dots_horizontal'] = 'Horizontal Dots';
$string['mathexpression:dots_vertical'] = 'Vertical Dots';
$string['mathexpression:empty_set'] = 'Empty set';
$string['mathexpression:epsilon'] = 'Epsilon';
$string['mathexpression:epsilon_uppercase'] = 'Uppercase Epsilon';
$string['mathexpression:equal'] = 'Equal';
$string['mathexpression:equivalence'] = 'Equivalence';
$string['mathexpression:eta'] = 'Eta';
$string['mathexpression:eta_uppercase'] = 'Uppercase Eta';
$string['mathexpression:exists'] = 'Exists';
$string['mathexpression:not_exists'] = 'Not exists';
$string['mathexpression:exponential'] = 'Exponential';
$string['mathexpression:factorial'] = 'Factorial';
$string['mathexpression:floor'] = 'Floor';
$string['mathexpression:font_color'] = 'Font Color';
$string['mathexpression:forall'] = 'For all';
$string['mathexpression:fraction'] = 'Fraction';
$string['mathexpression:gamma'] = 'Gamma';
$string['mathexpression:gamma_uppercase'] = 'Uppercase Gamma';
$string['mathexpression:general'] = 'General';
$string['mathexpression:greater'] = 'Greater than';
$string['mathexpression:greater_equal'] = 'Greater than or equal';
$string['mathexpression:greek'] = 'Greek';
$string['mathexpression:hat'] = 'Hat';
$string['mathexpression:hbar'] = 'H Bar';
$string['mathexpression:implication'] = 'Implication';
$string['mathexpression:implication_left'] = 'Implication';
$string['mathexpression:in'] = 'In';
$string['mathexpression:infinity'] = 'Infinity';
$string['mathexpression:insert'] = 'Insert';
$string['mathexpression:integers'] = 'Integers';
$string['mathexpression:integral'] = 'Integral';
$string['mathexpression:integral_contour'] = 'Integral Contour';
$string['mathexpression:integral_contour_limits'] = 'Integral Contour with limit';
$string['mathexpression:integral_double'] = 'Double Integral';
$string['mathexpression:integral_double_limits'] = 'Double Integral with limit';
$string['mathexpression:integral_limits'] = 'Integral with limits';
$string['mathexpression:integral_surface'] = 'Surface Integral';
$string['mathexpression:integral_surface_limits'] = 'Surface Integral with limit';
$string['mathexpression:integral_triple'] = 'Triple Integral';
$string['mathexpression:integral_triple_limits'] = 'Triple Integral with limit';
$string['mathexpression:integral_volume'] = 'Volume Integral';
$string['mathexpression:integral_volume_limits'] = 'Volume Integral with limit';
$string['mathexpression:intersection'] = 'Intersection';
$string['mathexpression:iota'] = 'Iota';
$string['mathexpression:iota_uppercase'] = 'Uppercase Iota';
$string['mathexpression:irrationals'] = 'Irrationals';
$string['mathexpression:italic'] = 'Italic';
$string['mathexpression:kappa'] = 'Kappa';
$string['mathexpression:kappa_uppercase'] = 'Uppercase Kappa';
$string['mathexpression:lambda'] = 'Lambda';
$string['mathexpression:lambda_uppercase'] = 'Uppercase Lambda';
$string['mathexpression:latex'] = 'LaTeX';
$string['mathexpression:less'] = 'Less than';
$string['mathexpression:less_equal'] = 'Less than or equal';
$string['mathexpression:limit'] = 'Limit';
$string['mathexpression:log'] = 'Logarithm';
$string['mathexpression:logbase'] = 'Logarithm with base';
$string['mathexpression:logicsets'] = 'Logic & Sets';
$string['mathexpression:matrix'] = 'Matrix';
$string['mathexpression:matrix_bar'] = 'Matrix with bar';
$string['mathexpression:matrix_bracket'] = 'Matrix with bracket';
$string['mathexpression:matrix_parenthesis'] = 'Matrix with parenthesis';
$string['mathexpression:minus'] = 'Minus';
$string['mathexpression:minus_plus'] = 'Minus-Plus';
$string['mathexpression:miscellaneous'] = 'Miscellaneous';
$string['mathexpression:mu'] = 'Mu';
$string['mathexpression:mu_uppercase'] = 'Uppercase Mu';
$string['mathexpression:nabla'] = 'Nabla';
$string['mathexpression:naturals'] = 'Naturals';
$string['mathexpression:natural_log'] = 'Natural Logarithm';
$string['mathexpression:negation'] = 'Negation';
$string['mathexpression:negation_tilde'] = 'Negation';
$string['mathexpression:not_contains'] = 'Not contains';
$string['mathexpression:not_equal'] = 'Not equal';
$string['mathexpression:not_in'] = 'Not in';
$string['mathexpression:not_subset'] = 'Not subset';
$string['mathexpression:not_subset_equal'] = 'Not subset or equal';
$string['mathexpression:not_superset'] = 'Not superset';
$string['mathexpression:not_superset_equal'] = 'Not superset or equal';
$string['mathexpression:nu'] = 'Nu';
$string['mathexpression:nu_uppercase'] = 'Uppercase Nu';
$string['mathexpression:omega'] = 'Omega';
$string['mathexpression:omega_uppercase'] = 'Uppercase Omega';
$string['mathexpression:omicron'] = 'Omicron';
$string['mathexpression:omicron_uppercase'] = 'Uppercase Omicron';
$string['mathexpression:operators'] = 'Operators';
$string['mathexpression:oplus'] = 'O Plus';
$string['mathexpression:otimes'] = 'O Times';
$string['mathexpression:overline'] = 'Overline';
$string['mathexpression:parallel'] = 'Parallel';
$string['mathexpression:partial'] = 'Partial';
$string['mathexpression:perpendicular'] = 'Perpendicular';
$string['mathexpression:phi'] = 'Phi';
$string['mathexpression:phi_uppercase'] = 'Uppercase Phi';
$string['mathexpression:pi'] = 'Pi';
$string['mathexpression:pi_uppercase'] = 'Uppercase Pi';
$string['mathexpression:plus'] = 'Plus';
$string['mathexpression:plus_minus'] = 'Plus-Minus';
$string['mathexpression:primes'] = 'Primes';
$string['mathexpression:psi'] = 'Psi';
$string['mathexpression:psi_uppercase'] = 'Uppercase Psi';
$string['mathexpression:product'] = 'Product';
$string['mathexpression:product_limits'] = 'Product with limits';
$string['mathexpression:rationals'] = 'Rationals';
$string['mathexpression:reals'] = 'Reals';
$string['mathexpression:rho'] = 'Rho';
$string['mathexpression:rho_uppercase'] = 'Uppercase Rho';
$string['mathexpression:round_braces'] = 'Round Braces';
$string['mathexpression:sec'] = 'Secant';
$string['mathexpression:set_minus'] = 'Set minus';
$string['mathexpression:sigma'] = 'Sigma';
$string['mathexpression:sigma_uppercase'] = 'Uppercase Sigma';
$string['mathexpression:sin'] = 'Sine';
$string['mathexpression:sinh'] = 'Hyperbolic Sine';
$string['mathexpression:square_braces'] = 'Square Braces';
$string['mathexpression:square_root'] = 'Square Root';
$string['mathexpression:square_root_power'] = 'Square Root with power';
$string['mathexpression:subscript'] = 'Subscript';
$string['mathexpression:subscript_left'] = 'Left Subscript';
$string['mathexpression:subset'] = 'Subset';
$string['mathexpression:subset_equal'] = 'Subset or equal';
$string['mathexpression:subsuper'] = 'Subscript and Superscript';
$string['mathexpression:subsuper_left'] = 'Left Subscript and Superscript';
$string['mathexpression:sum'] = 'Sum';
$string['mathexpression:sum_limits'] = 'Sum with limits';
$string['mathexpression:superscript'] = 'Superscript';
$string['mathexpression:superscript_left'] = 'Left Superscript';
$string['mathexpression:superset'] = 'Superset';
$string['mathexpression:superset_equal'] = 'Superset or equal';
$string['mathexpression:tan'] = 'Tangent';
$string['mathexpression:tanh'] = 'Hyperbolic Tangent';
$string['mathexpression:tau'] = 'Tau';
$string['mathexpression:tau_uppercase'] = 'Uppercase Tau';
$string['mathexpression:therefore'] = 'Therefore';
$string['mathexpression:theta'] = 'Theta';
$string['mathexpression:theta_uppercase'] = 'Uppercase Theta';
$string['mathexpression:times'] = 'Times';
$string['mathexpression:union'] = 'Union';
$string['mathexpression:upsilon'] = 'Upsilon';
$string['mathexpression:upsilon_uppercase'] = 'Uppercase Upsilon';
$string['mathexpression:variables'] = 'Variables';
$string['mathexpression:vector'] = 'Vector';
$string['mathexpression:xi'] = 'Xi';
$string['mathexpression:xi_uppercase'] = 'Uppercase Xi';
$string['mathexpression:zeta'] = 'Zeta';
$string['mathexpression:zeta_uppercase'] = 'Uppercase Zeta';




$string['mathexpression:mePlus'] = 'Plus';
$string['mathexpression:meMinus'] = 'Minus';
$string['mathexpression:meMinusElem'] = 'Minus Element';
$string['mathexpression:meTimes'] = 'Times';
$string['mathexpression:meDivision'] = 'Divide';

$string['mathexpression:meParen'] = 'Parenthesis';
$string['mathexpression:meBrace'] = 'Braces';
$string['mathexpression:meBracket'] = 'Brackets';


$string['mathexpression:meCrossProduct'] = 'meCrossProduct';
$string['mathexpression:meDotProduct'] = 'meDotProduct';
$string['mathexpression:meScalarProduct'] = 'meScalarProduct';
$string['mathexpression:mePower'] = 'mePower';