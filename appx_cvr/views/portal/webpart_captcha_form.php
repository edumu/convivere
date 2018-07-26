<?php
    
    // Include the IconCaptcha classes.
    require('../resources/php/captcha-session.class.php');
    require('../resources/php/captcha.class.php');

    // Set the path to the captcha icons. Set it as if you were
    // currently in the PHP folder containing the captcha.class.php file.
    // ALWAYS END WITH A /
    // DEFAULT IS SET TO ../icons/
    IconCaptcha::setIconsFolderPath("../icons/");

    // Use custom messages as error messages (optional).
    // Take a look at the IconCaptcha class to see what each string means.
    // IconCaptcha::setErrorMessages(array('', '', '', ''));
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>IconCaptcha Plugin v2 - By Fabian Wennink</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <meta name="author" content="Fabian Wennink © <?= date('Y') ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Include IconCaptcha stylesheet -->
        <link href="../resources/style/css/style.css" rel="stylesheet" type="text/css">
 
    </head>
    <body>
       
        <!-- Just a basic HTML form, captcha should ALWAYS be placed WITHIN the <form> element -->
        <h2>Form #1</h2>
        <form action="form/ajax-submit.php" method="post">

            <!-- Element that we use to create the IconCaptcha with -->
            <div class="captcha-holder"></div>

            <!-- Submit button to test your IconCaptcha input -->
            <input type="submit" value="Submit form #1 to test captcha" >
        </form>
              
        
        <script type="text/javascript">
            $('form').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize()
                }).done(function (data) {
                    $('.message').html(data);
                }).fail(function (data) {
                    console.log('Error: Failed to submit form.')
                });
                
            }                
            });
        </script>

        <!-- Include IconCaptcha script -->
        <script src="../resources/js/script.min.js" type="text/javascript"></script>

        <!-- Initialize the IconCaptcha -->
        <script async type="text/javascript">
            $(window).ready(function() {
                $('.captcha-holder').iconCaptcha({
                    captchaTheme: ["light"],
                    captchaFontFamily: '', 
                    captchaClickDelay: 500, 
                    captchaHoverDetection: true, 
                    enableLoadingAnimation: true,
                    loadingAnimationDelay: 1500, 
                    requestIconsDelay: 1500, 
                    captchaAjaxFile: '../resources/php/captcha-request.php', // The path to the Captcha validation file.
                    captchaMessages: { // You can put whatever message you want in the captcha.
                        header: "Select the image that does not belong in the row",
                        correct: {
                            top: "Great!",
                            bottom: "You do not appear to be a robot."
                        },
                        incorrect: {
                            top: "Oops!",
                            bottom: "You've selected the wrong image."
                        }
                    }
                })
                .bind('init.iconCaptcha', function(e, id) { // You can bind to custom events, in case you want to execute some custom code.
                    console.log('Event: Captcha initialized', id);
                }).bind('selected.iconCaptcha', function(e, id) {
                    console.log('Event: Icon selected', id);
                }).bind('refreshed.iconCaptcha', function(e, id) {
                    console.log('Event: Captcha refreshed', id);
                }).bind('success.iconCaptcha', function(e, id) {
                    console.log('Event: Correct input', id);
                }).bind('error.iconCaptcha', function(e, id) {
                    console.log('Event: Wrong input', id);
                });
            });
        </script>
    </body>
</html>