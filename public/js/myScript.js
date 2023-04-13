$(document).ready(function() {
    $('.select2').select2();
});

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

function reload(){
    $.confirm({
        title: 'Oops...',
        content: 'Terdapat kesalahan saat pengiriman data, Segarkan halaman ini?',
        icon: 'fa fa-arrow-rotate-right',
        theme: 'supervan',
        closeIcon: true,
        animation: 'scale',
        type: 'orange',
        autoClose: 'ok|10000',
        escapeKey: 'cancelAction',
        buttons: {   
            ok: {
                text: "ok!",
                btnClass: 'btn-success',
                keys: ['enter'],
                action: function(){
                    document.location.reload();
                }
            },
            cancel: function(){
                console.log('the user clicked cancel');
            }
        }
    });
}

function success(message) {
    $.confirm({
        title: 'Sukses',
        content: message,
        icon: 'fa fa-check',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        autoClose: 'ok|3000',
        type: 'green',
        buttons: {
            ok: {
                text: "ok!",
                btnClass: 'btn-success',
                keys: ['enter']
            }
        }
    });
}

function successRemove(message) {
    $.confirm({
        title: 'Sukses',
        content: message,
        icon: 'fa fa-check',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        autoClose: 'ok|3000',
        type: 'green',
        buttons: {   
            ok: {
                text: "ok!",
                btnClass: 'btn-success',
                keys: ['enter'],
                action: function(){
                    document.location.reload();
                }
            }
        }
    });
}

function succesStore(message) {
    $.confirm({
        title: 'Sukses',
        content: message,
        icon: 'fa fa-check',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        autoClose: 'ok|3000',
        type: 'green',
        buttons: {   
            ok: {
                text: "ok!",
                btnClass: 'btn-success',
                keys: ['enter'],
                action: function(){
                    document.location.reload();
                }
            }
        }
    });
}

function err(message) {
    $.confirm({
        title: 'Error',
        content: message,
        icon: 'fa fa-exclamation',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        autoClose: 'ok|5000',
        type: 'red',
        buttons: {
            ok: {
                text: "ok!",
                btnClass: 'btn-success',
                keys: ['enter']
            }
        }
    });
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict'
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()    


