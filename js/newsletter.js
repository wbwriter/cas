/**
 * Created by gueny_000 on 17/10/2016.
 */

//Ajax request for newsletter inscription

/**
 * success = 0;
 * already_subscribed = 1;
 * error = 2;
 */

var newsletter_email = "";

function subscribe()
{
    newsletter_email = $('#subscribe').val();

    $.ajax({
        type: "POST",
        url: "newsletter/subscription",
        data: {newsletter_email : newsletter_email},
        success: function(data, status, xhttp) {
            success_callback(data);
        },
        error: function (xhr) {
            alert("An error occured : "+xhr.statusText);
        }
    });

    return false;
}

function success_callback(data)
{
    data = Number(data);
    if(isNaN(data)){ data = 1; }

    switch(data)
    {
        case 0 : newsletter_success();
            break;
        case 1 : newsletter_duplicate();
            break;
        case 2 : newsletter_error();
            break;
    }
}

function newsletter_success()
{
    hideall();
    $('#newsletter_success_msg').text(newsletter_email);
    $('#newsletter_success').fadeIn(1000);
    //clean the input field
    $('#subscribe').val('');
}

function newsletter_duplicate()
{
    hideall();
    $('#newsletter_duplicate_msg').text(newsletter_email);
    $('#newsletter_duplicate').fadeIn(1000);
    //clean the input field
    $('#subscribe').val('');
}

function newsletter_error()
{
    hideall();
    $('#newsletter_error_msg').text(newsletter_email);
    $('#newsletter_error').fadeIn(1000);
}

function hideall()
{
    $('#newsletter_success').hide();
    $('#newsletter_duplicate').hide();
    $('#newsletter_error').hide();
}