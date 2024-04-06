$(document).ready(function() {
    var idInput = $('#logID'),
        pwdInput = $('#logPWD'),
        eye = $(".showPWD"),
        btnSend = $('.button-submit');

    // Fonction
    function setPopup(a) {
        $('.popup').addClass('active');
        var iconpopup = $('.icon-popup');
        var textpopup = $('.text-popup');
    
        if (a == "empty") {
            iconpopup.html('<i class="fa-solid fa-xmark"></i>');
            textpopup.text('Please complete all fields');
            idInput.css('border-color', '#f00');
            pwdInput.css('border-color', '#f00');
        }
        if (a == "invalidInfo") {
            iconpopup.html('<i class="fa-solid fa-exclamation"></i>');
            textpopup.text('Incorrect information');
            idInput.css('border-color', '#f00');
            pwdInput.css('border-color', '#f00');
        }
        if (a == "valid") {
            iconpopup.html('<i class="fa-solid fa-check"></i>');
            textpopup.text('Successful connection');
            idInput.css('border-color', '#0f0');
            pwdInput.css('border-color', '#0f0');
        }
        if (a == "error") {
            iconpopup.html('<i class="error fa-solid fa-exclamation"></i>');
            textpopup.text('An error has occurred');
        }
        setTimeout(function() {
            $('.popup').removeClass('active');
        }, 3200)
    }
    function isEmpty(value) {
        return value.trim() === "";
    }
    function checkForm(username, password) {
        if (!isEmpty(username) && !isEmpty(username)) {
            $.ajax({
                url: '../../process/auth/login.php',
                type: 'POST',
                data: { 
                    username: username,
                    password: password
                },

                dataType: 'json',
                timeout: 120000,
                success: function(response) {
                    if (response.message === 'valid') {
                        setPopup('valid')
                        setTimeout(function(){
                            window.location.href = 'https://vibz.infinityfreeapp.com/';
                        }, 2000)} 
                    else if (response.message === 'invalid'){
                        setPopup('invalidInfo')
                    } else {
                        setPopup('error');
                        console.log(response.message)
                    }
                },
                error: function() {
                    console.log('Erreur de la requête AJAX.');
                }
            });
        } else if (isEmpty(username) || isEmpty(username)) {
            setPopup('empty')
        } else {
            setPopup('invalidInfo')
        }
    }
    
    eye.on('click', () => {
        if(pwdInput.attr('type') === "password"){
            eye.addClass("fa-eye-slash").removeClass("fa-eye");
            pwdInput.attr("type", "text");
        } else {
            eye.addClass("fa-eye").removeClass("fa-eye-slash");
            pwdInput.attr("type", "password");
        }
    });
    btnSend.on('click', (e) => {
        e.preventDefault();
        idVal = idInput.val()
        pwdVal = pwdInput.val()
        checkForm(idVal, pwdVal)
    }); 

})