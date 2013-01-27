$(function(){
    // Chosen plugin
    $(".select").chosen();

    // Form elements styling
    $("select, .check, .check :checkbox, input:radio, input:file").uniform();

    /*$('.loading').live('click',function() {
        var str=$(this).attr('title');
        var overlay=$(this).attr('rel');
        loading(str,overlay);
        setTimeout("unloading()",1500);
    });
    $('#preloader').live('click',function(){
        unloading();
    });*/

});

/**
 * Functions
 */

// Loading overlay
function loading(name, overlay)
{
    $('body').append('<div id="overlay"></div><div id="preloader">'+name+'..</div>');
    if (overlay == 1){
        $('#overlay').css('opacity', 0.4).fadeIn(400, function(){ $('#preloader').fadeIn(400); });
        return false;
    }
    $('#preloader').fadeIn();
}

// Unloading overlay
function unloading()
{
    $('#preloader').fadeOut(400,function(){ $('#overlay').fadeOut().remove;}).remove();
}

function showAlertMessageError(str,delay)
{
    if(delay){
        $('#alertMessage').removeClass('success info warning').addClass('error').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500,function(){
            $(this).delay(delay).animate({ opacity: 0,right: '-20'}, 500,function(){ $(this).hide(); });
        });
        return false;
    }
    $('#alertMessage').addClass('error').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500);
}

function showAlertMessageSuccess(str,delay)
{
    if(delay){
        $('#alertMessage').removeClass('error info warning').addClass('success').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500,function(){
            $(this).delay(delay).animate({ opacity: 0,right: '-20'}, 500,function(){ $(this).hide(); });
        });
        return false;
    }
    $('#alertMessage').addClass('success').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500);
}

function showAlertMessageWarning(str,delay)
{
    if(delay){
        $('#alertMessage').removeClass('error success  info').addClass('warning').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500,function(){
            $(this).delay(delay).animate({ opacity: 0,right: '-20'}, 500,function(){ $(this).hide(); });
        });
        return false;
    }
    $('#alertMessage').addClass('warning').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500);
}

function showAlertMessageInfo(str,delay)
{
    if(delay){
        $('#alertMessage').removeClass('error success  warning').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500,function(){
            $(this).delay(delay).animate({ opacity: 0,right: '-20'}, 500,function(){ $(this).hide(); });
        });
        return false;
    }
    $('#alertMessage').html(str).stop(true,true).show().animate({ opacity: 1,right: '10'}, 500);
}