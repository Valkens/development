$(function() {
    $('textarea').elastic();

    $('textarea').keypress(function (e) { // Listen to keyboard press event by user
        if (e.keyCode == 32 || e.charCode == 32) { // if user press spacebar
            var content = $(this).val(); // Get all the data in the textarea
            //var url = content.match(/https?:\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?/);
            var url = content.match(/(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi);

            // regular expression that will allow us to extract url from the textarea
            if (url.length > 0 && $('#ajax_flag').val() == 0) { // If there's atleast one url entered in the textarea
                //ajax_flag ensure that if a url is found and user press spacebar,ajax will trigger only once .
                $("#fetched_data").slideDown('show'); // show this div with a 'slidedown' effect - previously hiddden by default
                $("#loader").html("<img style='float:right;' src='public/img/ajax-loader.gif'>"); // Add an Ajax loading image similar to facebook


                $.get("getsite/" + encodeURIComponent(url[0]).replace(new RegExp('%2F','gi'), '%252F'), function (response) { // Ajax call using get passing the url extracted from the textarea
                    $("#ajax_content").html(response) //Place the response processed by get_content.php and place it in a div with id = ajax_content
                    $('#loader').empty(); // remove the ajax loading image now
                    $('img#1').fadeIn(); // Add a fading effect with the first image thumbnail extracted from the external website
                    $('#current_img').val(1); // Initiate value =1 - this will be used for the next / previous button
                });

                $('#ajax_flag').val(1); // Ensure that only once ajax will trigger if a url match is found in the textarea
            }
            //return false;
        }
    });

    ///////////////////////////////////////////////////////////////////////	 Next image
    $('#next').live("click", function () { // when user click on next button
        var firstimage = $('#current_img').val(); // get the numeric value of the current image
        if (firstimage <= $('#total_images').val() - 1) // as long as last image has not been reached
        {
            $('img#' + firstimage).hide(); // hide the current image to be able to display the next image
            firstimage = parseInt(firstimage) + parseInt(1); // Increment image no so that next image no. can be displayed
            $('#current_img').val(firstimage); // Incremented in input tag
            $('img#' + firstimage).show(); // show second image
        }
        $('#totalimg').html(firstimage + ' of ' + $('#total_images').val()); // Update the current image no display value
    });
    ///////////////////////////////////////////////////////////////////////	 Next image
    ///////////////////////////////////////////////////////////////////////	 prev image
    $('#prev').live("click", function () { // When user clicks on Previous Button
        //Same logic as for Next Button
        var firstimage = $('#current_img').val();


        if (firstimage >= 2) {
            $('img#' + firstimage).hide();
            firstimage = parseInt(firstimage) - parseInt(1);
            $('#current_img').val(firstimage);
            $('img#' + firstimage).show();
        }
        $('#totalimg').html(firstimage + ' of ' + $('#total_images').val());
    });
    ///////////////////////////////////////////////////////////////////////	 prev image

});