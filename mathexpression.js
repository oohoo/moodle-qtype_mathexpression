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

// Anonymous function to avoid namespace collisions
(function() {
    $(document).ready(function() {
        // A language handler, retrieves the localized strings for use within the editor
        var langHandler = {
            getLang: function(id) {
                id = id.split('.')[1];
                var value = mathEditor_allStrings[id];
                // See all_strings.php
                if(value) {
                    return value;
                } else {
                    return '{' + id + '}';
                }
            }
        };

        var buttonListElement = $('#id_buttonlist');

        var updateButtonList = function() {
            buttonListElement.val('');
            $('input[name="mathbuttongroups"]').each(function() {
                if($(this).is(':checked')) {
                    buttonListElement.val(buttonListElement.val() + ',' + $(this).data('math'));
                }
            });
            buttonListElement.trigger('propertychange');
        };

        // Checkbox default values
        $('input[name="mathbuttongroups"]').each(function() {
            if(buttonListElement.val().indexOf($(this).data('math')) !== -1) {
                $(this).attr('checked', true);
            }
            $(this).click(updateButtonList);
        });

        // Bind the question fields with the Math Editor
        $('.question-matheditor').each(function() {
            var editor = new MathEditor(this, langHandler);
            editor.setVariables($(this).data('matheditorvars'));

            // Retrieve the button list from the form element (if it exists)
            if(buttonListElement.length > 0) {
                editor.setButtonList(buttonListElement.val(), true);
                buttonListElement.bind('input propertychange', function() {
                    editor.setButtonList(buttonListElement.val(), true);
                });
            }

            // Attach a callback to the onchange event of the editor and update a hidden field
            // within the form
            var inputField = $($(this).data('matheditor'));
            editor.onChange(function(latex) {
                inputField.val(latex);
            });

            // Retrieve any existing data from this field and render it within the editor
            editor.setLatex(inputField.val());
        });

        // Bind the exclude fields with the Math Editor
        $('.exclude-matheditor').each(function(index) {
            var editor = new MathEditor(this, langHandler);

            // Retrieve the button list from the form element (if it exists)
            var buttonListElement = $('#id_buttonlist');
            if(buttonListElement.length > 0) {
                editor.setButtonList(buttonListElement.val(), true);
                buttonListElement.bind('input propertychange', function() {
                    editor.setButtonList(buttonListElement.val(), true);
                });
            }

            // Attach a callback to the onchange event of the editor and update a hidden field
            // within the form
            var inputField = $('input[name="exclude[' + index + ']"]');
            editor.onChange(function(latex) {
                inputField.val(latex);
            });

            // Retrieve any existing data from this field and render it within the editor
            editor.setLatex(inputField.val());
        });

        // Bind the question fields with the Math Editor
        $('.variable-matheditor').each(function(index) {
            var editor = new MathEditor(this, langHandler);
            editor.setButtonList('alpha,beta,gamma,delta,epsilon,zeta,eta,theta,iota,kappa,lambda,'
                + 'mu,nu,xi,omicron,pi,rho,sigma,tau,upsilon,phi,chi,psi,omega,alpha_uppercase,'
                + 'beta_uppercase,gamma_uppercase,delta_uppercase,epsilon_uppercase,zeta_uppercase,'
                + 'eta_uppercase,theta_uppercase,iota_uppercase,kappa_uppercase,lambda_uppercase,'
                + 'mu_uppercase,nu_uppercase,xi_uppercase,omicron_uppercase,pi_uppercase,'
                + 'rho_uppercase,sigma_uppercase,tau_uppercase,upsilon_uppercase,phi_uppercase,'
                + 'chi_uppercase,psi_uppercase,omega_uppercase,vector,hat,subscript,superscript,'
                + 'hbar', true);

            // Attach a callback to the onchange event of the editor and update a hidden field
            // within the form
            var inputField = $('input[name="variable[' + index + ']"]');
            editor.onChange(function(latex) {
                inputField.val(latex);
            });

            // Retrieve any existing data from this field and render it within the editor
            editor.setLatex(inputField.val());
        });

        // Only show the exclude fields when the compare type is full
        $('select#id_comparetype').change(function() {
            if($(this).val() === 'full') {
                $('fieldset#id_excludedheader').show();
            } else {
                $('fieldset#id_excludedheader').hide();
            }
        }).change();
});
})();