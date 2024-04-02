$(function () {
	"use strict";




	/* ==========================================================================
       Sub Form   
       ========================================================================== */


	$('#mc-form').ajaxChimp({
		callback: callbackFunction,
		url: 'http://csmthemes.us3.list-manage.com/subscribe/post?u=9666c25a337f497687875a388&id=45b2c44b98'
			// http://xxx.xxx.list-manage.com/subscribe/post?u=xxx&id=xxx
	});


	function callbackFunction(resp) {
		if (resp.result === 'success') {
			$('#mc-error').slideUp();
			$('#mc-success').slideDown();
			$('#mc-form button').prop('disabled', true);
		} else if (resp.result === 'error') {
			$('#mc-success').slideUp();
			$('#mc-error').slideDown();
		}
	}




	/* ==========================================================================
   Countdown timer
   ========================================================================== */

	$('.countdown').downCount({
		date: '12/15/2019 12:00:00' // m/d/y
	});




	/* ==========================================================================
       Navbar
     ========================================================================== */

	$(window).on('scroll', function () {
		var scrollValue = $(window).scrollTop();
		if (scrollValue > 400) {
			$('.navbar').addClass('affix');
		} else {
			$('.navbar').removeClass('affix');
		}
	});



	/* ==========================================================================
	   Collapse nav bar
	   ========================================================================== */


	$(".nav-item a:not(.nav-item .dropdown-toggle)").on('click', function () {
		$(".navbar-collapse").collapse('hide');
		$(".navbar-toggler").removeClass("hamburger-active");
	});



	/* ==========================================================================
	   Dropdown menu easing  
	   ========================================================================== */


	$('.dropdown').on('show.bs.dropdown', function () {
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown('fast');
	});


	$('.dropdown').on('hide.bs.dropdown', function () {
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp('fast');
	});




	/* ==========================================================================
	   Hamburger Menu Animation 
	   ========================================================================== */



	$(".navbar-toggler").on("click", function () {
		$(this).toggleClass("hamburger-active");
	});







	/* ==========================================================================
       Smooth scroll
     ========================================================================== */


	$('a[href*="#"]')

	.not('[href="#"]')
		.not('[href="#0"]')
		.on('click', function (event) {

			if (
				location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
				location.hostname === this.hostname
			) {

				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

				if (target.length) {

					event.preventDefault();
					$('html, body').animate({
						scrollTop: (target.offset().top - 80)
					}, 1000);
					return false;
				}
			}

		});





	/* ==========================================================================
	Contact form
	========================================================================== */


	var formFields = $('.contact-form form input, .contact-form form textarea');



	$(formFields).on('focus', function () {
		$(this).removeClass('input-error');
	});
	$('.contact-form form').submit(function (e) {
		e.preventDefault();
		$(formFields).removeClass('input-error');
		var postdata = $('.contact-form form').serialize();
		$.ajax({
			type: 'POST',
			url: 'php/contact.php',
			data: postdata,
			dataType: 'json',
			success: function (json) {

				if (json.nameMessage !== '') {
					$('.contact-form form .contact-name').addClass('input-error');
				}
				if (json.emailMessage !== '') {
					$('.contact-form form .contact-email').addClass('input-error');
				}
				if (json.messageMessage !== '') {
					$('.contact-form form textarea').addClass('input-error');
				}
				if (json.antispamMessage !== '') {
					$('.contact-form form .contact-antispam').addClass('input-error');
				}
				if (json.nameMessage === '' && json.emailMessage === '' && json.messageMessage === '' && json.antispamMessage === '') {

					$('.contact-form-success').slideDown();


					$('.contact-form form button').prop('disabled', true);
					$('.contact-form form').find('input, textarea').val('');

				}
			}
		});
	});



});















(function ($) {
    "use strict";

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);
