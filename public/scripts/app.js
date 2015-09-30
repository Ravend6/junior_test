(function () {
    'use strict';

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    $('#select-lang').on('change', function () {
        var lang = $(this).find('#lang').val();

        document.cookie="language=" + lang + ';expires=Thu, 18 Dec 2017 12:00:00 UTC';
        location.reload();
    });

    // Login validation
    $('#login-form').on('submit', function () {
        var isValid = false;
        var form = $(this);
        var emailInput = form.find('#email');
        var email = emailInput.val();
        var passwordInput = form.find('#password');
        var password = passwordInput.val();
        if (email === '') {
            emailInput.parent().parent().addClass('has-error');
            var msg = 'It is necessary to fill Email';
            if (getCookie('language') === 'ru') {
                msg = 'Необходимо заполнить Email';
            } 
            emailInput.next().text(msg);
        } 
        if (validateEmail(email)) {
            emailInput.next().text('');
            emailInput.parent().parent().removeClass('has-error');
            emailInput.parent().parent().addClass('has-success');
            
            // $.ajax({
            //     url: '/email-unique',
            //     type: 'post',
            //     data: {email: email}
            // }).done(function (data) {
            //     if (data === '1') {
            //         emailInput.parent().parent().addClass('has-error');
            //         var emailUniqueError = 'This email is already used.';
            //         if (getCookie('language') === 'ru') {
            //             emailUniqueError = 'Такой email уже используется.';
            //         } 
            //         emailInput.next().text(emailUniqueError);

            //     } else {
            //         emailInput.next().text('');
            //         emailInput.parent().parent().removeClass('has-error');
            //         emailInput.parent().parent().addClass('has-success');
            //     }
            // });
        } 

        if (password.length < 5) {
            passwordInput.parent().parent().addClass('has-error');
            var passwordError = 'Small length of password.';
            if (getCookie('language') === 'ru') {
                passwordError = 'Маленькая длина пароля.';
            } 
            passwordInput.next().text(passwordError);
            
        } else {
            passwordInput.next().text('');
            passwordInput.parent().parent().removeClass('has-error');
            passwordInput.parent().parent().addClass('has-success');
        }

        if (emailInput.parent().parent().hasClass('has-success') &&
            passwordInput.parent().parent().hasClass('has-success')) {
            
             
        }
        $.ajax({
            url: '/verify-password',
            type: 'post',
            data: {email: email, password: password},
            async: true
        }).done(function (data) {
            if (data === 'fail') {
                passwordInput.parent().parent().addClass('has-error');
                var identityError = 'Invalid email or password.';
                if (getCookie('language') === 'ru') {
                    identityError = 'Неверный email или пароль.';
                } 
                isValid = false;
                passwordInput.next().text(identityError);
            } else if (data === 'done') {
                isValid = true;

                $.ajax({
                    url: '/login',
                    type: 'post',
                    data: {email: email, password: password},
                    async: true
                }).done(function (data) {
                     location.href = '/profile';
                });
            }
        });

        if (isValid) {

        } else {
            return false;
        }

        
    });
}());