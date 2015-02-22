/**
 *
 *@Author - Eugene Mutai
 *@Twitter - JheneKnights
 *
 * Date: 3/10/13
 * Time: 5:11 PM
 * Description: Model javascript Script for PrittyNote
 *
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.opensource.org/licenses/gpl-2.0.php
 *
 * Copyright (C) 2013
 * @Version - Full, Object Oriented, Stable, Pretty
 * @Codenames - sha1: cc99d04a02371d96ecaefd2254be75b048e80373, md5: ce3d6db7d4dd0a93a5383c08809ea513
 */


var prittyNote = {

    //default prittyNote variables
    maxWidth: 350,
    y: 80,
    font: '24pt Arial',
    drawText: undefined,
    bgImage: false,
    theImage: undefined,
    canvas: 'statuscanvas',
    tweets: new Array(),
    tweetIds: new Array(),
    userDef: false,
    limit: {
        max: 180,
        min: 2
    },

    setValue: function(value) {
        document.getElementsByTagName('textarea')[0].value = value;
    },

    getValue: function() {
        prittyNote.drawText = document.getElementsByTagName('textarea')[0].value;
        return prittyNote.drawText;
    },

    getStatus: function() {
        var text = prittyNote.getValue()
        prittyNote.drawCanvas(text);
    },

    //Give the user a basic IDEA of how his prittyNote will look like
    getColors: function() {
        var clr = $("#text").val(),
            bgclr = $("#bgclr").val(),
            hashtagclr = $("#hashtag").val();
        return {
            "text": clr,
            "bgcolor": bgclr,
            "hashtag": hashtagclr
        };
    },

    //FUNCTION TO DRAW THE CANVAS
    drawCanvas: function(text, image) {

        var words = text.split(" ");
        var color = prittyNote.getColors();
        var font = prittyNote.font;
        var maxWidth = prittyNote.maxWidth

        var clr = "#" + color.text,
            bgclr = "#" + color.bgcolor,
            hTagclr = "#" + color.hashtag;

        var lineHeight = parseFloat(font, 10) + parseFloat(font, 10) / 8;

        prittyNote.clearCanvasGrid(prittyNote.canvas);

        var canvas = document.getElementById(prittyNote.canvas); //the canvas ID
        var context = canvas.getContext('2d');

        canvas.width = 450;
        var x = (canvas.width - maxWidth) / 2,
            y = 0; //prittyNote.y;

        if (prittyNote.bgImage) image = true;
        else image = false;

        var ht = 450;
        var hd = prittyNote.getHeight(text, context, x, y, maxWidth, lineHeight, image);

        //To centralise the quote on the note canvas
        y = Math.round(ht - hd.height) / 2; //over-ride the y offset
        if (y < 50) y = prittyNote.y;
        console.log("This will be the top offset --", y, hd);

        canvas.height = ht;
        context.globalAlpha = 1

        if (image) {
            var imageObj = new Image();
            imageObj.onload = function() {
                context.drawImage(imageObj, 0, 0, canvas.width, ht);
                context.fillStyle = '#000';
                context.globalAlpha = 0.5
                context.fillRect(0, 0, canvas.width, ht);
                context.fillStyle = clr;
                context.font = font;
                context.globalAlpha = 1
                prittyNote.wrapText(context, text, x, y, maxWidth, canvas.width, lineHeight, clr, hTagclr);
            };
            imageObj.src = prittyNote.theImage
        } else {
            context.fillStyle = bgclr;
            context.fillRect(0, 0, canvas.width, ht);
            context.globalAlpha = 1
            context.fillStyle = clr;
            context.font = font;
            prittyNote.wrapText(context, text, x, y, maxWidth, canvas.width, lineHeight, clr, hTagclr);
        }

        $("#imagepath").html("letters: " + text.length + " | words: " + words.length + " | height: " + ht + "px")
    },

    //function to calculate the height to assign the canvas dynamically
    getHeight: function(text, ctx, x, y, mW, lH, img) {
        var words = text.split(" "); //all words one by one
        var c = 0,
            a = x,
            h;
        var br = /(`)[\w]{0,}/

        $.map(words, function(wd) {
            var string = wd + " ";
            var m = ctx.measureText(string);
            var w = m.width;

            var b = br.test(string);
            if (b) y += lH, x = a, c++;

            x += w;

            if (x > mW) {
                x = a;
                y += lH;
                c++;
            }
        })

        c++
        var wrapH = (c * 2) * lH;

        h = lH + wrapH; // + lH;
        //if(img) h += lH;
        //if(h < 200) h = 200;
        return {
            height: h,
            wrapheight: wrapH,
            offset: y,
            newlines: c,
            text: text
        };
    },

    //wrap the text so as to fit in the Canvas
    wrapText: function(ctx, text, x, y, mW, cW, lH, clr, hTagclr) {

        var words = text.split(' '); //split the string into words
        var line = '',
            p, a = x; //required variables "a" keeps default "x" pos
        var hash = /(\#|\@)[\w]{0,}/, //match hash tags & mentions
            rest = /(\#\#)[\w]{0,}/, //match for double tags to print all the rest a diff color
            startquote = /\"[\w]{0,}/, //if start of quote
            endquote = /([\w]\"){0,}/, //end of quote
            br = /(`)[\w]{0,}/;

        var qc = 0; //will count, 0 means return color to normal

        for (var n = 0; n < words.length; n++) {
            var string = words[n] + " ";
            var m = ctx.measureText(string);
            var w = m.width; //width of word + " "

            var p = hash.test(string); //match string to regex
            var r = rest.test(string);
            var sq = startquote.test(string);
            var eq = endquote.test(string);
            var b = br.test(string);
            //console.log(pr); //debugging purposes

            console.log("This is qc -- ", qc);

            //test for ## -- change color of the rest of sentence if true
            if (r) {
                ctx.fillStyle = hTagclr;
                clr = hTagclr; //change default color
                string = string.replace('##', ''); //remove the double hashtags
                w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
            }
            //test for new line
            else if (b) {
                y += lH //jump downwards one more //next line
                x = a //restart writing from x = 0
                string = string.replace('`', ''); //remove the underscore
                w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
            } else {
                //test for quotes, will depict the quote length and color it all

                if (p) { //change color of only single words with single hash tags
                    ctx.fillStyle = hTagclr;
                    string = string.replace('#', '');
                    w = ctx.measureText(string).width; //recalculate width to remove whitespaces left
                }
                //reset default text color if not
                else {
                    if (qc == 0) ctx.fillStyle = clr;
                }
            }

            ctx.fillText(string, x, y); //print it out

            x += w; //set next "x" offset for the next word

            var xnw = ctx.measureText(words[n + 1] + " ").width; //check for the future next word
            var xn = x + xnw;
            //console.log(xn);

            if (xn >= cW) { //try it's existence to see if it breaks the maxW rule
                y += lH;
                x = a;
            } else { //if it doesn't continue as if it hasn't yet bin plotted down
                if (x > mW) {
                    x = a;
                    y += lH; //new line
                }
            }
        }
        ctx.fillText(line, x, y);
    },

    //FUNCTION TO CLEAR CANVAS
    clearCanvasGrid: function(canvasname) {
        var canvas = document.getElementById(canvasname);
        var context = canvas.getContext('2d');
        //context.beginPath();

        // Store the current transformation matrix
        context.save();

        // Use the identity matrix while clearing the canvas
        context.setTransform(1, 0, 0, 1, 0, 0);
        context.clearRect(0, 0, canvas.width, canvas.height);

        // Restore the transform
        context.restore(); //CLEARS THE SPECIFIC CANVAS COMPLETELY FOR NEW DRAWING
    },

    //checks to see if the chosen file is an image
    isImage: function(imagedata) {
        var allowed_types = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'JPEG', 'JPG', 'PNG', 'GIF', 'BMP'],
            itscool = false

        var imgtype = imagedata.toString().split(';')
        imgtype = imgtype[0].split('/')
        console.log(imgtype)

        if ($.inArray(imgtype[1], allowed_types) > -1) {
            itscool = true
        }
        return itscool
    },

    readImage: function(input) {
        var image
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                image = e.target.result
                prittyNote.bgImage = prittyNote.isImage(image)
                if (prittyNote.bgImage) {
                    prittyNote.theImage = image
                    prittyNote.drawCanvas(prittyNote.getValue(), image)
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    },

    removeImage: function() {
        prittyNote.bgImage = false
        prittyNote.drawCanvas(prittyNote.getValue())
    },

    //AJAX REQUEST TO SEND CANVAS DATA TO CREATE IMAGE
    makePrittyNote: function() {
        var canvas = 'statuscanvas';
        var testCanvas = document.getElementById(canvas); //canvasID
        var canvasData = testCanvas.toDataURL("image/png"); //encrypte the data

        $('.createImagebtn .label').html("Just a moment...")
        $('.createImagebtn').removeClass('redbtn').addClass('greenbtn')
        $.post("./canvastopng.php", {
            data: canvasData
        }, function(data) {
            if (data.success == 0) {
                $('.createImagebtn .label').html("Error occured. Try Once More")
                $('.createImagebtn').removeClass('greenbtn').addClass('redbtn')
            } else {
                $('.createImagebtn .label').html("Create Another Image")
                $('.createImagebtn').removeClass('greenbtn').addClass('redbtn')
                window.location = "./canvastopng.php?d=" + data.name
                //promp the image to be downloaded automatically
            }
        }, "json");
        //use the data you get back to join both the location data and the image created associated with it
    },

    //AFTER GETING RESPONSE FROM THE CANVASTOPNG SEND DATA TO MATCH THE IMAGE AND LOCATION IN AN ARRAY/JSON FILE
    imageMergedata: function(imgid, userId, imgpath) {
        var echo = '<img src="../images/accept.png" alt="OK" title="Success"/>';
        $.get("./getlocajax.php", {
            imgid: imgid,
            user: userId,
            text: prittyNote.getValue(),
            path: imgpath
        },

        function(data) {
            $("#imagepath").html(echo + " " + data.message);
            $("#statuscanvas").wrap('<a target="_blank" href="' + data.path + '" title="' + data.text + '" />');
        }, "json");
    },

    makeDemoNotes: function() {
        //!st check if the browser supports LocalStorage technology
        if (localStorage) { //If it does
            if (localStorage.getItem('demoImages') == (null || "NaN")) {
                localStorage.setItem('demoImages', "1");
                prittyNote.makePrittyNote();
            } else {
                if (parseInt(localStorage.getItem('demoImages')) >= prittyNote.limit) {
                    $('#loadingPrefh2').css('color', '#cc0000').html('Oops! That\'s all you can make. Please purchase the PRO version to be able to make more cool PrittyNotes, Thank you!').parent().show();
                    $('.purchaseBtn').css('visibility', 'visible');
                } else {
                    var newValue = parseInt(localStorage.getItem('demoImages')) + 1;
                    localStorage.setItem('demoImages', newValue);
                    prittyNote.makePrittyNote();
                }
            }
        } //If the browser is an old one, and doesn't support LocalStorage, fallback to Cookies
        else {
            if ($.cookie('demoImages') == null) {
                $.cookie('demoImages', 1, {
                    expires: 1000,
                    path: '/'
                });
                prittyNote.makePrittyNote();
            } else {
                if (parseInt($.cookie('demoImages')) > prittyNote.limit) { //prevent more images from being made
                    $('#loadingPrefh2').css('color', '#cc0000').html('Oops! That\'s all you can make. Please purchase the PRO version to be able to make more cool PrittyNotes, Thank you!').parent().show();
                    $('.purchaseBtn').css('visibility', 'visible');
                } else { //else count them, and make images
                    var newValue = parseInt($.cookie('demoImages')) + 1;
                    $.cookie('demoImages', newValue);
                    prittyNote.makePrittyNote();
                }
            }
        } //$('#loadingPref').fadeOut(200)
    },

    loadTweets: function() {
        $('.preserveForm .loadTweets').remove()
        prittyNote.pFclone = $('.preserveForm').clone()

        $('.footer').animate({
            "font-size": "1em",
            "left": 0
        }, 600)

        var widthNeeded = $(window).width() - 820
        if (widthNeeded >= 300) { //if there is enough space to put Twitter content on the side
            var newMargin = ($(window).width() - (820 + 300)) / 2 //now determine the margin for equal division
            $('.content').animate({
                marginLeft: newMargin
            }, 300, function() {
                //$(this).wrap('<div class="wrapper">')
                $(this).append('<div class="loadTweets"></div>').css({
                    width: '100%',
                    height: 'auto'
                })
                setTimeout(function() {
                    if ($('div.loadTweets')) {
                        prittyNote.pullTweets($(window).height(), 300, $('div.loadTweets'))
                    }

                }, 300)
            })
        } else {
            $('.writeform').empty() //remove everything from element
            prittyNote.pullTweets(400, widthNeeded, $('.writeform'))
        }
        setTimeout(function() {
            prittyNote.setTweetRefresh() //enable refreshing of tweets
        }, 20000) //after 20 seconds
    },

    pullTweets: function(height, width, that) {
        that.html('<h2 style="border-bottom: 1px solid #bbb; padding: 3px; margin: 0">tweets ' + '<span id="showRefreshing" style="font-size: 11px; color: #87cefa;">loading</span></h2>' + '<div class="Tw"></div>')

        console.log($(this).selector)
        if (that.selector !== '.writeform') that.css({
            float: 'left',
            width: 300,
            height: height,
            "border-left": "1px solid #e8e8e8",
            "margin-top": 0,
            "margin-left": '5px'
        })

        $('.Tw') //show loading image
        .animate({
            'height': height - 100,
            'width': 300
        }, 600, function() {
            $(this)
                .css({
                'overflowY': 'scroll',
                'overflowX': 'hidden',
                'border-bottom': '1px solid #aaa'
            })
                .append('<img id="loadingCircle" src="../images/325.gif" style="position: relative; top: 40%; left: 40%" alt="Loading Tweets..." />')
        })
        if (width < 280) $(prittyNote.pFclone).insertAfter('.Tw')
        //$('.content').css('margin', 0).css('margin-left', newMargin)
        prittyNote.refreshTweets()
    },

    //function to fetch new tweets every minute
    refreshTweets: function() {
        var fileorurl
        //check to see if tweets were previously loaded
        if (prittyNote.tweets.length == 0) {
            fileorurl = './home-timeline.php';
            $('#showRefreshing').html('loading tweets...');
        } else { //if true, get the latest last tweet ID, for refreshing
            var last = Math.max.apply(null, prittyNote.tweetIds);
            fileorurl = './home-timeline.php?last=' + encodeURIComponent(last)
            $('#showRefreshing').html('loading more tweets...');
        }
        //get the last latest tweet depending on maximum id
        //now request for new tweets
        //fileorurl = './dump/jheneknights-timeline.json' //- for debugging purposes
        $.getJSON(fileorurl, function(json) {
            if (prittyNote.tweets.length == 0) $('#loadingCircle').remove()
            if (json.success == 1) {

                if (prittyNote.userDef == false) {
                    //load user's data into profile pic place
                    document.getElementsByClassName('twitterProf')[0].innerHTML = '<h3><img width="30px" align="absmiddle" src="' + json.image + '"> ' + json.username + '</h3>';
                    prittyNote.userDef = true;
                } //if the user's profile was not shown on the upper right corner

                //$('.Tw').empty() //remove the loading bar and all the other tweets
                $.map(json.data, function(t, i) {
                    prittyNote.tweets.push({
                        id: t.id,
                        tweet: t.text
                    })
                    prittyNote.tweetIds.push(t.id)
                    var tw = '<table class="tweets" data-id="' + t.id + '">' + '<tr>' + '<td class="profilepic">' + '<img src="' + t.user.profile_image_url + '" alt="Profile Picture" />' + '</td>' + '<td class="body">' + '<h4>' + t.user.screen_name + '</h4>' + '<p id="tw">' + t.text + '</p>' + '</td>' + '</tr>' + '</table>'
                    $('.Tw').prepend(tw)
                })
                $('#showRefreshing').html('')
                $('.tweets').css({
                    cursor: 'pointer',
                    'border-bottom': '#f2f2f2 solid 1px',
                    width: '100%'
                })

                $('.tweets').bind('mouseover', function() {
                    $(this).css({
                        backgroundColor: '#fefac6'
                    })
                })
                $('.tweets').bind('mouseout', function() {
                    $(this).css({
                        backgroundColor: '#fefefe'
                    })
                })

                //create the onClick bind event
                $('.tweets').bind('click', function() {
                    var twId = $(this).attr('data-id') //the ID of the tweet, unique to each
                    $.map(prittyNote.tweets, function(a, b) {
                        if (twId == a.id) {
                            prittyNote.drawText = a.tweet //set as default drawingText
                            prittyNote.drawCanvas(a.tweet)
                            prittyNote.setValue(decodeURIComponent(a.tweet)) //load into text area
                            //console.log(a.tweet) //debugging purposes
                        }
                    })
                })
            } else {
                //if the user is not logged in
                if (json.success == 0) {
                    $('#loadingPrefh2').html("Oops! Let's go log in to Twitter first")
                    $('#loadingPref').fadeIn(300, function() {
                        window.location = json.redirect //redirect him so as to log in
                    })
                }
                //failed to load tweets
                if (json.success == 2) console.log(json.message), $('#showRefreshing').html(json.message)
            }
        })

    },

    //Function to enable the fetching of new tweets after every minute
    setTweetRefresh: function() {
        prittyNote.keyEvents() //rebind to refresh events set
        var refresh = setInterval(function() {
            prittyNote.trimTweets()
            prittyNote.refreshTweets()
        }, 20000) //fetch new tweets after every 10 seconds
    },

    //function to check for too many tweets in DIV so trim them down to required number
    trimTweets: function() {
        var len = $('.tweets').length
        console.log(len) //total tweets in number
        if (len > 300) {
            prittyNote.tweets = prittyNote.tweets.sort(function(a, b) {
                return b.id - a.id
            }) //sort by largest Id to lowest
            //console.log(tweets)
            prittyNote.tweetIds = tweetIds.sort(function(a, b) {
                return b - a
            })
            //reduce the number of Ids and TweetArray to 300 if more
            prittyNote.tweetIds.length = 300;
            prittyNote.tweets.length = 300;
            //console.log(tweetIds)
            $('.tweets').each(

            function() {
                var Id = $(this).attr('data-id')
                if ($.inArray(Id, prittyNote.tweetIds) == -1) $(this).remove()
            })
        }
    },

    //function to check the string length, max characters
    checkTextLength: function() {
        var text = prittyNote.getValue(),
            len = text.length,
            e = $("#post");
        //MAX allowed is 350
        if (len > prittyNote.limit.max) {
            prittyNote.drawCanvas('#Oh #Snap! You\'ve #written too much!')
        } else if (len < prittyNote.limit.min) { //least allowed is 20
            prittyNote.drawCanvas('#Hmmm! You\'ve barely #written anything!')
        } else { //if everything is okay in between 20 - 350
            prittyNote.drawCanvas(text);
        }
    },

    keyEvents: function() {
        $('#image').bind('change', function() {
            prittyNote.readImage(this)
        })
        $('.removeBg').bind('click', function() {
            prittyNote.removeImage()
        })
        $('input[data-color]').each(function() {
            $(this).bind({
                focus: function() {
                    $(this).trigger('change');
                    //$.map(['blur', 'change', 'focus'], function(a) { $(this).trigger(a); });
                    console.log("triggered Keyup -- color selected", $(this).data('color'));
                },
                change: function() {
                    prittyNote.getColors();
                    prittyNote.checkTextLength();
                },
                blur: prittyNote.checkTextLength()
            })
        })
    }

};


//++++++++++++++++++ load Utilities jQuery Plug-in ++++++++++++++++++++++++
(function($) {

    var families = [],
        pallete = [],
        fonts = [],
        s = "",
        f = "",
        d

        $.fn.extend({

            loadUtilities: function(options) {

                var el = this
                var defaults = {
                    fileorurl: './js/stickinoteUtilitiesTRY.json'
                }

                var use = $.extend({}, defaults, options);

                //Put a loading cover on the APP to prevent usage till full optimisation
                $('body').append('<div id="loadingPref" style="position: absolute; top:0; left: 0; width:100%; height: 100%; background: #fefefe; opacity: 0.8; text-align: center; z-index: 1"><h2 id="loadingPrefh2"  style="margin-top: 30%"></h2></div>');

                $('#loadingPrefh2').html('Loading Fonts...')
                //Load the required fonts from the server through GooGle
                $.getScript("http://ajax.googleapis.com/ajax/libs/webfont/1.0.31/webfont.js", function() {
                    console.log("Script loaded and executed."); //let me know in the console log that the fonts have loaded
                    $('#loadingPrefh2').html('Loading Themes....')
                });

                WebFontConfig = {
                    google: {
                        families: ["Architects Daughter", "Arvo::latin", "Amarante", "Averia Sans Libre", "Cabin+Sketch:700:latin", "Crafty Girls", "Combo", "Comfortaa", "Coming Soon", "Dancing+Script:700:latin", "Delius Swash Caps", "Didact Gothic", "Dosis", "Electrolize", "Griffy", "Gloria Hallelujah", "Handlee", "Happy Monkey", "Homemade Apple", "Imprima", "IM Fell Great Primer", "Just Me Again Down Here", "Josefin Slab", "Julee", "Jura", "Kaushan Script", "Love Ya Like A Sister", "Macondo", "McLaren", "Marmelad", "Metamorphous", "MedievalSharp", "Miniver", "Oregano", "Orienta", "Oxygen", "Patrick Hand", "Pacifico", "Princess Sofia", "Puritan", "Quicksand", "Quando", "Raleway:400", "Ribeye Marrow", "Rock Salt", "Schoolbell", "Special Elite", "Spirax", "Swanky and Moo Moo", "Sofia", "Ubuntu", "Unkempt", "Waiting for the Sunrise", "Varela Round", "Vollkorn"]
                    },

                    loading: function() {
                        //do something while fonts are loading
                        console.log("Total Font to be loaded -- " + WebFontConfig.google.families.length)
                    },

                    active: function() { //when finished

                        $.getJSON(use.fileorurl, function(json) {

                            pallete = json.data.palletes,
                            fonts = json.data.fonts

                            console.log('Total Themes that are Loaded -- ' + pallete.length)
                            prittyNote.font = fonts[1].string //for testing purposes
                            $('#loadingPrefh2').html('Doing a little cleaning...')

                            //now build the theme select option
                            $.each(pallete, function(x, p) {
                                s = s + '<option value="' + p.name + '">' + p.name + '</option>';
                            });
                            //finalise the theme option
                            s = '<select id="pallete">' + s + '</select>'; //pap!!
                            //console.log(s)

                            //now begin building the theme option
                            $.each(fonts, function(e, w) {
                                families.push(w.name);
                                f = f + '<option value="' + w.name + '">' + w.name + '</option>';
                            });
                            f = '<select id="font">' + f + "</select>";
                            d = 'Themes: ' + s + ' Fonts: ' + f; //now join the th two and post them

                            //console.log(el)
                            $(el).html(d); //finally display the choices available

                            //now bind each select element to it's response function
                            $("#pallete").bind("change", function() {
                                installPallette(); //start keep watch in the select changes
                            });

                            $("#font").bind("change", function() {
                                installFont(); //start keep watch in the select changes
                            });

                        })
                        console.log(families.toString());
                        $('#loadingPrefh2').html('Yaaeey! We good to go!')

                        setTimeout(function() {
                            $('#loadingPref').fadeOut(200, function() {
                                prittyNote.drawCanvas(prittyNote.getValue()); //now draw the example canvas
                            })
                        }, 500) //now remove the loading panel now
                    }
                }
            }
        })

        function installPallette() {
            var p = $("#pallete").val(); //get the selected value of the palettes
            var bgclr, text, htclr; //declare variables 1st
            //console.log(p)
            $.map(pallete, function(a, b) {
                if (a.name == p) { //loop thru the palette matching the required palette request
                    bgclr = a.color[0]; //put in assigned vars
                    text = a.color[1];
                    htclr = a.color[2];
                    //console.log(a.color)
                }
            })

            $("#bgclr").val(bgclr).css({
                "background": "#" + bgclr
            }); //give back the variables & mod where needed
            $("#text").val(text).css({
                "background": "#" + text
            });
            $("#hashtag").val(htclr).css({
                "background": "#" + htclr
            });
            prittyNote.drawCanvas(prittyNote.getValue());
        }

        function installFont() {
            var f = $("#font").val();

            $.map(fonts, function(a, b) { // loop through the fonts getting the corresponding font match
                if (a.name == f) {
                    prittyNote.font = a.string; //if found assign to font as the defualt in use from now
                    prittyNote.drawCanvas(prittyNote.getValue());
                    //console.log(font); //log it in console to confirm that it is working
                    // break; //all is done no more looping
                }
            })
        }

})(jQuery) 