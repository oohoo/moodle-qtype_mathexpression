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

        // Bind the question fields with the Math Editor
        $('.question-matheditor').each(function() {
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