/*
 * For additional validation (client side) for all forms.
 * Code taken from Bootstrap: https://getbootstrap.com/docs/5.0/forms/validation/
 */

(function() {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event)
            {
                if(!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()


function takeGenreValue(bookID) {
    var e = document.getElementById("")
}