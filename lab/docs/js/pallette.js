/**
 * User: Eugene Mutai
 * Date: 9/25/12
 * Time: 14:00 PM
 * Stickinote Design and Font Management Plug in
 * 1st jQuery Plug-in made by I
 */

//++++++++ THESE ARE THE THEME OPTIONS AVAILABLE ++++++//
var pallete = [
    {"name":"A New Life", "color":["fe7e0cd","46b8b2","f99384"]},
    {"name":"Alarming", "color":["fa023c","c8ff00","4b000f"]},
    {"name":"Autumn Begins", "color":["c8ad66","7c2700","f1b85f"]},
    {"name":"Beautiful Day", "color":["ccf390","ff003d","f7c41f"]},
    {"name":"Best Friends", "color":["f1e9c2","8846be","983e26"]},
    {"name":"Chocolate Cream", "color":["a37e58","fbcfcf","fcfbe3"]},
    {"name":"Cifuel", "color":["413e4a","b38184","f7e4be"]},
    {"name":"Coffee Script", "color":["4a300a", "f7e11e", "fc760f"]},
    {"name":"Confusion", "color":["f8ca00","8a9b0f","bd1550"]},
    {"name":"Dream Street", "color":["cac8bc","eae5d2","f26882"]},
    {"name":"Dream in Color", "color":["519548","bef202","eafde6"]},
    {"name":"Eat Cake", "color":["f8ca00","774f38","e08e79"]},
    {"name":"Evil Within", "color":["292929","999999","da0230"]},
    {"name":"Facebook", "color":["18138c", "e6e6e6", "78c0ff"]},
    {"name":"FireFox", "color":["f56f16", "eef5e1", "693b13"]},
    {"name":"Fresh Cut", "color":["8fbe00","f9f2e7","40c0cb"]},
    {"name":"Fresh Kiss", "color":["412e28","b3204d","d1c089"]},
    {"name":"Good Day", "color":["2b9e15", "f5f5f3", "f2ea07"]},
    {"name":"His Curse", "color":["4a014f", "d111f7", "229dc9"]},
    {"name":"Hug Me Maybe", "color":["f1e9c2","983e26","88846b"]},
    {"name": "Instructions", "color":["fefefe", "666666", "cc0000"]},
    {"name":"Jhene Knights", "color":["ba0e08", "ebfafa", "f0f71b"]},
    {"name":"Only You", "color":["e6c996","77664e","cf1902"]},
    {"name":"Punk Girl", "color":["eb1579", "faedf8", "f2f211"]},
    {"name":"Soldier", "color":["655c45","ccb07e","e9e2c7"]},
    {"name":"StickiNote", "color":["fef070","666666","cc0000"]},
    {"name": "Tar", "color":["9c9c9c", "1f1f1f", "ebeff0"]},
    {"name":"That's Sarah", "color":["c1fef8", "f02491", "29b1cc"]},
    {"name":"Thunder Bear", "color":["ffffce","1bc6b7","97030a"]},
    {"name":"Tiger in the Sun", "color":["724a0f","ebd723","c4c3c1"]},
    {"name":"Wheatfield", "color":["fff0a3","f03a5a","a33c0e"]},
    {"name":"Your Beautiful", "color":["64908a","e8caa4","cc2a41"]}
];
console.log(pallete[0].name); //test if the Pallette system is working

//++++++++++ FONT OPTIONS +++++++//
var fonts = [
    {"name":"Architects Daughter", "string":"22pt 'Architects Daughter'"},
    {"name":"Amarante", "string": "24pt 'Amarante'"},
    {"name":"Averia Sans Libre", "string":"24pt 'Averia Sans Libre'"},
    {"name":"Crafty Girls", "string":" 22pt 'Crafty Girls'"},
    {"name":"Combo", "string":"26pt 'Combo'"},
    {"name":"Comfortaa", "string":"22pt 'Comfortaa'"},
    {"name":"Coming Soon", "string":"24pt 'Coming Soon'"},
    {"name":"Didact Gothic", "string":"25pt 'Didact Gothic'"},
    {"name":"Dosis", "string": "28pt 'Dosis'"},
    {"name":"Delius Swash Caps", "string":"24pt 'Delius Swash Caps'"},
    {"name":"Griffy", "string": "24pt 'Griffy'"},
    {"name":"Gloria Hallelujah", "string":"22pt 'Gloria Hallelujah'"},
    {"name":"Happy Monkey", "string": "22pt 'Happy Monkey'"},
    {"name":"Handlee", "string": "24pt 'Handlee'"},
    {"name":"Homemade Apple", "string":"20pt 'Homemade Apple'"},
    {"name":"Just Me Again Down Here", "string":"30pt 'Just Me Again Down Here'"},
    {"name":"Julee", "string": "25pt 'Julee'"},
    {"name":"Jura", "string":"24pt 'Jura'"},
    {"name":"Kaushan Script", "string":"24pt 'Kaushan Script'"},
    {"name":"Love Ya Like A Sister", "string": "24pt 'Love Ya Like A Sister'"},
    {"name":"Macondo", "string":"24pt 'Macondo'"},
    {"name":"McLaren", "string": "22pt 'McLaren'"},
    {"name":"MedievalSharp", "string": "22pt 'MedievalSharp'"},
    {"name":"Metamorphous", "string": "19pt 'Metamorphous'"},
    {"name":"Miniver", "string":"24pt 'Miniver'"},
    {"name":"Oregano", "string":"28pt 'Oregano'"},
    {"name":"Orienta", "string": "22pt 'Orienta'"},
    {"name":"Oxygen", "string":"24pt 'Oxygen'"},
    {"name":"Patrick Hand", "string": "28pt 'Patrick Hand'"},
    {"name":"Pacifico", "string":"24pt 'Pacifico'"},
    {"name":"Puritan", "string":"22pt 'Puritan'"},
    {"name":"Princess Sofia", "string":"30pt 'Princess Sofia'"},
    {"name":"Quando", "string": "20pt 'Quando'"},
    {"name":"Quicksand", "string": "22pt 'Quicksand'"},
    {"name":"Ribeye Marrow", "string":" 20pt 'Ribeye Marrow'"},
    {"name":"Rock Salt", "string":"18pt 'Rock Salt'"},
    {"name":"Schoolbell", "string":"24pt 'Schoolbell'"},
    {"name":"Special Elite", "string":"22pt 'Special Elite'"},
    {"name":"Spirax", "string":"24pt 'Spirax'"},
    {"name":"Sofia", "string":"24pt 'Sofia'"},
    {"name":"Swanky and Moo Moo", "string": "25pt 'Swanky and Moo Moo'"},
    {"name":"Ubuntu", "string":"24pt 'Ubuntu'"},
    {"name":"Unkempt", "string": "24pt 'Unkempt'"},
    {"name":"Waiting for the Sunrise", "string":"24pt 'Waiting for the Sunrise'"}
];
console.log(fonts[0].name + " -- font system seems to pass here"); //test if the Fonts system

//+++++++++ My 1St jQuery Function +++++++++
jQuery.fn.loadUtilities = function () {
    var s = "", f = "", d, families = [];

    $(this).html("<p>Loading Theme and Font Options...</p>");

    //now build the theme select option
    $.each(pallete, function(x, color) {
        s = s + '<option value="' + color.name + '">' + color.name + '</option>' ;
    });
    //finalise the theme option
    s = '<select id="pallete">' + s + '</select>'; //pap!!

    //now begin buliding the theme option
    $.each(fonts, function (e, font) {
        f = f + '<option value="' + font.name + '">' + font.name + '</option>';
    });
    f = '<select id="font">' + f + "</select>";
    d = s + f + "<p>Themes || Fonts</p>"; //now join the th two and post them
    $(this).html(d); //finally display the choises available

    for(x in fonts) {
        families[x] = fonts[x].name;
    }

    //Load the required fonts from the server through GooGle
    $.getScript("http://ajax.googleapis.com/ajax/libs/webfont/1.0.31/webfont.js", function() {
        console.log("Script loaded and executed."); //let me know in the console log that the fonts have loaded
    });

    WebFontConfig = {
        google: {
            families:["Architects Daughter", "Amarante", "Averia Sans Libre", "Crafty Girls", "Combo", "Comfortaa",
                "Coming Soon","Delius Swash Caps", "Didact Gothic", "Dosis", "Griffy", "Gloria Hallelujah", "Handlee",
                "Happy Monkey", "Homemade Apple", "Just Me Again Down Here", "Julee", "Jura", "Kaushan Script",
                "Love Ya Like A Sister", "Macondo", "McLaren", "Metamorphous", "MedievalSharp", "Miniver", "Oregano", "Orienta",
                "Oxygen", "Patrick Hand", "Pacifico", "Princess Sofia", "Puritan", "Quicksand", "Quando", "Ribeye Marrow",
                "Rock Salt", "Schoolbell",  "Special Elite","Spirax", "Swanky and Moo Moo", "Sofia", "Ubuntu", "Unkempt",
                "Waiting for the Sunrise"]
        },
        active: function() { //when finished
            console.log("All the Fonts have been loaded too...")
            console.log(families.toString());
            font = fonts[16].string; //test it out
            drawCanvas();
        }
    }

    //now bind each select element to it's response function
    $("#pallete").bind("change", function(){
        installPallette(); //start keep watch in the select changes
    });

    $("#font").bind("change", function(){
        installFont(); //start keep watch in the select changes
    });

    function installPallette() {
        var p = $("#pallete").val(); //get the selected value of the pallete
        var bgclr, text, htclr; //declare variables 1st

        for(x in pallete) {
            if(pallete[x].name == p){ //loop thru the pallettes matching the required pallette request
                bgclr = pallete[x].color[0]; //put in asssigned vars
                text =  pallete[x].color[1];
                htclr = pallete[x].color[2];
                break;
            }
        }

        $("#bgclr").val(bgclr).css({"background": "#" + bgclr}); //give back the variables & mod where needed
        $("#text").val(text).css({"background": "#" + text});
        $("#hashtag").val(htclr).css({"background": "#" + htclr});
        drawCanvas();

    }

    function installFont() {
        var f = $("#font").val();
        for(x in fonts) { // loop through the fonts getting the corresponding font match
            if(fonts[x].name == f) {
                font = fonts[x].string; //if found assign to font as the defualt in use from now
                drawCanvas();
                //console.log(font); //log it in console to confirm that it is working
                break; //all is done no more looping
            }
        }
    }

}


