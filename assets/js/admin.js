// Función para mostrar u ocultar la contraseña al hacer clic en el botón.
document.getElementById('show_password').addEventListener('click', function() {
var passwordField = document.getElementById('aceprensa_password');
var buttonIcon = this;

if (passwordField.type === 'password') {
    passwordField.type = 'text';
    buttonIcon.classList.remove('dashicons-visibility');
    buttonIcon.classList.add('dashicons-hidden');
} else {
    passwordField.type = 'password';
    buttonIcon.classList.remove('dashicons-hidden');
    buttonIcon.classList.add('dashicons-visibility');
}
});
jQuery(document).ready(function($) {
    // Inicializa Select2 en el campo de categorías.
    $('#aceprensa_categories').select2({
        placeholder: 'Selecciona categorías',
        minimumInputLength: 3, // Mínimo de 3 caracteres para activar la búsqueda.
        ajax: {
            url: '/../wp-content/plugins/aceprensa-posts/inc/remote-posts.php',
            method: 'post',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    endpoint: 'categories?search=' + params.term, // Término de búsqueda proporcionado por el usuario.
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(category) {
                        return {
                            id: category.id,
                            text: category.name
                        };
                    }),
                };
            },
        },
    });
    for (var i in savedCats) {
            var data = {
                id: i,
                text: savedCats[i],
            };
            var newOption = new Option(data.text, data.id, true, true);

            $('#aceprensa_categories').append(newOption);
            createNewInput(i, savedCats[i]).insertBefore("#aceprensa_categories");
    }
    // 
    $('#aceprensa_categories').on('select2:unselect', function(e) {
        e.params.data.element.remove();
        $('input[name="aceprensa_selected_categories[' + e.params.data.id + ']"').remove();
    });
    $('#aceprensa_categories').on('select2:select', function(e) {
        createNewInput(e.params.data.id, e.params.data.text).insertBefore("#aceprensa_categories");
    });
    function createNewInput(id, value) {
        var newInput = $("<input>").attr({
                    name: 'aceprensa_selected_categories[' + id + ']',
                    type: "hidden",
                    value: value
                })
        return newInput;
    }
});
