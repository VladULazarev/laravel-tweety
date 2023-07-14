/**
 * CONTENT
 *
 * 1. Set variables
 * 2. Show more 'tweets' for '/home' and '/profiles/{$user}'page
 * 3. Delete the 'tweet'
 * 4. Store and show the new 'tweet'
 * 5. Get new 'tweets' for the current user using 'ajax'
 */

$(document).ready(function(){

// --------------------------------------------- 1. Set variables and functions

    const shortTime = 100;
    const middleTime = 300;
    const _token = $("input[name='_token']").val();

    // Show the content
    $(".content").fadeTo(300, 1);

    /**
     * Show error messages from the current form
     *
     * @param {string} formName - The name of the current form
     * @param {string} errorMsg - The text of the message
     */
    function showMsg(formName, errorMsg) {
        setTimeout(function () {
            $('.' + formName + '-error').append(errorMsg);
        }, shortTime);
        $('.form-errors').fadeTo(shortTime, 1);
    }

    /**
     * Hide error messages from the form
     *
     * @param {string} formName - The name of the current form
     */
    function hideMsg(formName) {
        $('.form-errors').fadeTo(shortTime, 0);
        $('.' + formName + '-error').empty();
    }

    /**
     * Hide error messages from the form if the 'body' field is on focus
     *
     * @param {string} formName - The name of the current form
     */
    $("#body").focus(function () {
        $('.form-errors').fadeTo(shortTime, 0);
    });

// ------------- 2. Show more 'tweets' for '/home' and '/profiles/{$user}'page

    // Skip first 10 records (we get them on first load of the current page)
    let skip = 10;

    let options = {
        //root: document.querySelector('body'),
        rootMargin: '0px',
        threshold: 1.0
    };

    // Get the current location
    const currentUrl = location.href.split('/');

    // Get the first segment of the current url
    const currentUrlFirstSegment = currentUrl[currentUrl.length-2];

    // Set '$route' by default
    let $route = 'more-tweets';

    // If currentUrl = 'http://tweety/profiles/{$user}'
    if (currentUrlFirstSegment === 'profiles') {

        // Add to '$route' the current second segment of the url
        $route = 'more-profiles-tweets/' + currentUrl[currentUrl.length-1];;
    }

    // callback works when 'observer' was found
    const callback = function(entries, observer) {

        $.post("/" + $route, {

            _token: _token,
            skip: skip

        }, function(data) {

            if (data) {

                // Append and show the found data
                setTimeout(function(){ $(".timeline").append(data); }, middleTime);

            } else {
                $("#observer").remove();
                $(".preloader").remove();
            }
        });

        skip += 10;
    };

    const observer = new IntersectionObserver(callback, options);
    const target = document.querySelector('#observer');

    // If the 'target' was found
     if (target) {
        observer.observe(target);
    }

// ------------------------------------------------------ 3. Delete the 'tweet'

    // Click dots
    $(document).on("click", ".tweet-dots", function(){

        // Show 'Удалить' tooltip
        $(this).next().addClass('display-block');

        // Apply the transparent background
        $('body').append("<div class='popup-container'></div>");
    });

    // Cancel the deleting (click somewhere out to the tooltip)
    $(document).on("click", ".popup-container", function(){

        // Hide the tooltip
        $(".delete-tweet").removeClass('display-block');

        // Remove the transparent background
        $(".popup-container").remove();
    });

   // Click 'Удалить' tooltip and delete the 'tweet'
    $(document).on("click", ".delete-tweet", function(){

        // Get 'id' of the 'tweet'
        const tweetId = $(this).data("value");

        // Hide the tooltip
        $(".delete-tweet").removeClass('display-block');

        // Remove the transparent background
        $(".popup-container").remove();

        // Hide the deleted 'tweet'
        $("." + tweetId).fadeTo(middleTime, 0);
        setTimeout(function(){ $("." + tweetId).addClass('display-none'); }, middleTime);

        // Delete the 'tweet'
        $.post("/delete-tweet", {
            _token: _token,
            tweetId: tweetId
        });
    });

// --------------------------------------- 4. Store and show the new 'tweet'

    // Click the button 'Твитнуть'
    $('.new-tweet').on("click",function(e){

        e.preventDefault();
        hideMsg('tweet');

        // Get value from the 'body' field
        const body = $("#body").val().trim();

        // Check if there are 'bad' characters
        const checkBody = body.match(/^[A-Za-z0-9А-Яа-я!\?\' \._@\,\(\-]+$/);

        // If 'data' has 'bad symbols'
        if (! checkBody ) {
            let errorMsg = "Сообщение пустое или содержит 'плохие' символы!";
            showMsg('tweet', errorMsg);
            return false;
        }

        // Set variables
        const userId = $("input[name='current-user']").val();

        // Set timeout
        setTimeout(function(){

            $.post('/tweets', {

                body: body,
                userId: userId,
                _token: _token

            }, function(data) {

                // If something went wrong
                if (data == '') {

                    let errorMsg = "Что-то пошло не так...";
                    showMsg('tweet', errorMsg);
                    $("textarea").val('');

                } else if (data) {

                    hideMsg('tweet');
                    $(".timeline").prepend(data);
                    $("textarea").val('');
                    return false;
                }
            });

        }, middleTime);

    });

// ---------------------- 5. Get new 'tweets' for the current user using 'ajax'

    const getNewTweets = function() {

        const getCurrentUrl = currentUrl[currentUrl.length-1];

        // Start the script only if the current url = http://tweety/home
        if (getCurrentUrl === 'home') {

            // Get the 'id' of the last 'tweet'
            let tweetLastId = $(".tweet").first().data("value");

            // Get 'id' of the current user
            const userId = $("input[name='current-user']").val();

            // Send data to controller
            $.post('/new-tweets', {

                tweetLastId: tweetLastId,
                userId: userId,
                _token: _token

            }, function(data) {
                
                if (data == '') {

                    //console.log('No new tweets');

                // Add new 'tweets' to the top of the timeline
                } else if (data) {

                    $(".timeline").prepend(data);

                    return false;
                }
            });

            // Start function 'getNewTweets' every 5 seconds
            setTimeout(getNewTweets, 5000);
        }
    }

    getNewTweets();

});
