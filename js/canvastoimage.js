/**
 *
 *@Author - Eugene Mutai
 *@Twitter - JheneKnights
 *@Email - eugenemutai@gmail.com
 *
 * Date: 10/10/12
 * Time: 5:06 PM
 * @Description: Acquire's and turns all or selected Canvas presentations on the page and turns them into Images
 *
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/gpl-2.0.php
 *
 * @Copyright (C) 2012
 * @Version - 2.4 stable
 *
 * @Full-Version
 * @Requires - a server-side processing script to get Data and decode it back to an Image, USE : canvastopng.php (in same folder)
 *
 * @Version 2.0 ++
 *
 *  Change made:
 *  - use of button instead of automatic parsing
 *  - download capability added, autodownloads the image as soon as the image is created successfully
 *  - css modified to be general
 *  - css editable in options
 *  - Can call the image making function without the plug in parameters
 *  - Refreshes in 5 seconds to allow creation of more than one image
 *  - externerlised its functions
 *  - invoke the plug in just by using $.canvasToImage() which will just get all the canvases on the page and create images for each one of them
 *  - added minimalistic progress monitoring
 */

(function($) { //Wrap it in an ANNOYMOUS function so as not to AFFECT/OVERWRITE DEFAULT jQUERY Functions

    $.cv = $.cv || {}

    $.cv.count = 0
    $.cv.defaults = {
        selected: true, //false,
        styling: {"position":"fixed", "width": "auto", "height": "auto", "left": 0, "bottom": -2, "color": "#fefaf4",
            "background-color": "#0b0", "padding": "5px", "border":"2px solid #009900", "textAlign": "center",
            "fontWeight": "bold", "font-size": "16px", "border-top-right-radius": "7px", "color": '#fff'}
    } //styling for the button, independent entirely

    $.fn.extend({

        canvasToImage: function(options) {

            var moreOptions = {
                element: $(this)
            }
            var use  = $.extend({}, $.cv.defaults, moreOptions, options);

            //load the button to create the image
            $('body').append('<div id="notify">' +
                '<a id="notfy"> Create Image </a>' +
                '</div>');
            $('#notify').css(use.styling)
            $.cv.element = use.element;
            $.cv.defaults.selected = use.selected;
            //console.log(use.element)
            enablebind()

        }
    });

    //if false - get all canvas DOM elements
    init = function(use) {
        if(use == false) {
            //get all canvas elemements in the Document
            var c = document.getElementsByTagName("canvas")
            if(c.length > $.cv.count) {
                //now loop through them sending them to the required file
                for(var n =0; n< c.length; n++ ) {
                    var e = c[n]
                    console.log(e)
                    makeImageFromMe(e)
                    console.log("The author just left the plug-in to do it's thing, LIKE A BOSS!")
                }
            }
        } //IF true|yes|1 - make image from this specified tag
        else if(use == (true || 1 || "yes")) {
            var e = $.cv.element[0] //get the element itself
            console.log($.cv.element[0])
            makeImageFromMe(e)

        }
    }

    //AJAX REQUEST TO SEND CANVAS DATA TO CREATE PDF
    makeImageFromMe = function(el) {
        var canvasData = el.toDataURL("image/png"); //encrypte the data from the specific locationID
        $('#notify').html('<a id="notfy">Please give me a second...</a>')
        $('#notify').css({"background-color":"#ffdd00", "border":"2px solid #3b3300"})
        $.post("./canvastopng.php", {data: canvasData}, function(data) {
            if(data.success == 0) {
                $("#notify").html('<img src="./images/delete.png" align="absmiddle" />  ' +
                    data.message + ' : ' + data.name + '(' + data.size +')')
            }else{
                $("#notify").html('<a id="dpng">' +
                    '<img src="./images/accept.png" align="absmiddle" />  ' + data.message + '</a>')
                window.location = "./canvastopng.php?d=" + data.name //promp the image to be downloaded automatically
                if($.cv.defaults.selected == (true || 1 || "yes")) {
                         $("#notify").html('<a id="notfy"> Create Another Image </a>');
                         enablebind()
                    //$(this).remove() //remove it completely from DOM
                } //my secret is here.
            }
            $("#notify").css({"background-color": "#0b0", "border":"2px solid #009900", "color": "#fff"})
            //$("#notify").css(use.styling)
            $.cv.count++
        }, "json");
        //use the data you get back to join both the location data and the image created associated with it
    }

    enablebind = function() {
        $("#notfy").bind('click', function() {
            init($.cv.defaults.selected); //initialise the image making progress
        })
    }

    //call this method directly by not tagging any element to it $.canvasToImage()
    //it will create images for all the canvases existent in the page
    canvasToImage = function() {
        $.fn.canvasToImage()
    }

})(jQuery)
