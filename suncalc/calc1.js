
var mode="DOZ";
var clearflag=0;
var equationDec =[];
var equationDoz =[];
var current ="";
var output ="";

function replaceXL (xlString) {
    xlString = xlString.replace (/\r?X/g,"a");
    xlString = xlString.replace (/\r?L/g,"b");
    return xlString;
}

function replaceAB (abString) {
    abString = abString.replace (/\r?a/g,"X");
    abString = abString.replace (/\r?b/g,"L");
    return abString;
}

function convertDozToDec (dozString) {

    if (dozString.match(/\./)) {
        return convertDozenalFraction(dozString);
    }

    else {
        dozString = replaceXL(dozString);
        var decNumber = parseInt(dozString,12);
        return decNumber;
    }
}

function convertDecToDoz (dec) {

    var doz = 0

    if (typeof(dec)=="string") {
        dec = parseFloat(dec,10);
    }

    doz = dec.toString(12);
    doz = replaceAB(doz);

    return doz;
}




function convertDozenalFraction (dozString) {

    var result=[];

    dozString = replaceXL(dozString);

    var dozFrac = dozString.split(".");
    
    var originalLength = dozFrac[1].length;

    var remainder = dozFrac[1];

    console.log("Started with dozFrac[1]: "+dozFrac[1]+" Remainder: "+remainder);
 

    for (var i =0; i<originalLength; i++){

        console.log("It: "+i+" Step 1 - Remainder: "+remainder);

        remainder = parseInt(remainder,12);

        console.log("It: "+i+" Step 2 - Remainder: "+remainder);

        remainder *= 10;

        console.log("It: "+i+" Step 3 - Remainder: "+remainder);

        remainder = remainder.toString(12);

        console.log("It: "+i+" Step 4 - Remainder: "+remainder);

        while (remainder.length < originalLength) {
            var zero = "0";
            remainder = zero.concat(remainder);
            console.log("while ran");
        }

        console.log("It: "+i+" Step 5 - Remainder: "+remainder);

        result[i] = remainder.slice(0,1);
        remainder = remainder.slice(1);

        console.log("It: "+i+" Step 6 Result[]: "+result+" Remainder: "+remainder);
    }

    console.log("Finished with:"+result+" Remainder: "+remainder);

    originalLength = remainder.length;

    remainder = parseInt(remainder,12);

    console.log("Step 1 - Remainder: "+remainder);

    remainder = remainder.toString(10);

    console.log("Step 2 - Remainder: "+remainder);

    while (remainder.length < originalLength) {
            var zero = "0";
            remainder = zero.concat(remainder);
            console.log("while ran again");
        }

    console.log("Step 3 - Remainder: "+remainder);

    remainder = "0."+remainder;

    console.log("Step 4 - Remainder: "+remainder);

    remainder = parseFloat(remainder,10);

    console.log("Step 5 - Remainder: "+remainder);

    if (remainder >0.5) {
        dozFrac[0] = parseInt(dozFrac[0],12);
        dozFrac[0] += 1
        console.log("Step 6 < - Remainder: "+remainder);
    }

    dozFrac[1] = result.join("");
    dozFrac = dozFrac.join(".");

    return dozFrac;
}



function createMatchedEquation () {
     

    // Clear equation arrays
    equationDec=[];
    equationDoz=[];

    // convert output string to equation array
    // first replace all operator keys with #+#
    current = current.replace(/\r?\*/g,"#*#");
    current = current.replace(/\r?\//g,"#/#");
    current = current.replace(/\r?\-/g,"#-#");
    current = current.replace(/\r?\+/g,"#+#");


    if (mode=="DOZ") {

        // Cut the string at # to give dozenal equation array
        equationDoz = current.split(/\r?\#/);
        

        // Cycle through dozenal equation array
        for (var i =0; i<equationDoz.length; i++) {

            //copy operators over decimal equation array without processing
            if (equationDoz[i].match(/[\/\*\-\+]/)) {
                equationDec[i]=equationDoz[i];
            }

            // convert dozenal strings to decimal number and plug into new array
            else {
                equationDec[i] = convertDozToDec(equationDoz[i]);
            }
        }
       
    }

    if (mode=="DEC") {
        equationDec = current.split(/\r?\#/);
        
        for (var i =0; i<equationDec.length; i++) {

            //copy operators over without processing
            if (equationDec[i].match(/[\/\*\-\+\.]/)) {
                equationDoz[i]=equationDec[i];
            }

            // convert decimals to dozenals and replace ab's with XL's
            else {
                equationDoz[i]=convertDecToDoz(equationDec[i]);  
            }
        }
    } 
    //console.log("create finished with"+equationDec+equationDoz);     
}

//add all .key divs to keys array
var keys = $(".key");


//assign onclick method to all keys 
for (var i = 0; i<keys.length; i++) {

    keys[i].onclick = function (e) {

        //get whats currently displayed in #output
        current = $("#output").html();

        // get the key pressed by taking the html from the .key that was clicked
        var input = $(this).html();
        
        // clear button actions
        if (input=="C") {
            $("#output").html("");
           
            equationDoz=[];
            equationDec=[];
        }

        // = button actions (where all the magic happens)
        else if (input=="=") {
        
            // Use function to create dozenal or decimal equation array
            createMatchedEquation();

            // Calculate answer - convert decimal array to single string and eval()
            output = equationDec.join("");
            output = eval(output);  

            if (mode=="DOZ") {
                // convert result back into base12 and replace a/b's with X/L's
                output = output.toString();
                output = convertDecToDoz(output);
            }

            //output the result
            $("#output").html(output);
        }

        // switch output from dozenal TO decimal (button value shows current)
        else if (input=="DOZ") {

            // if current is a formula, create matched array and display that
            if (current.match(/[\/\*\-\+]/)) {      
                createMatchedEquation();
                output = equationDec.join("");
            }

            // if current is a number, display conversion
            else {
                output = convertDozToDec(current);
                
              }

            $("#output").html(output);
            mode="DEC";
            // change colors and DEC/DOZ label
            $(this).html(mode);
            $("#output").css("background-color","#ddffe7");
            $(this).css("background-color","#ddffe7");

            
            //clearflag=1;
        }
        
        // switch mode TO dozenal
        else if (input=="DEC") {

            output="";
            if (current!="") { 
                
                if (current.match(/[\/\*\-\+]/)){
                    createMatchedEquation ();
                    output=equationDoz.join("");
                }
                else {  
                    output = convertDecToDoz(current);
                }
            }

            $("#output").html(output);

            mode ="DOZ";
            $("#output").css("background-color","#ff9696");
            $(this).html(mode);
            $(this).css("background-color","#ff9696");

           
            //clearflag =1;
        }
            

        else {
            // Prevent double pressing operator
            if  (input.match(/[\/\*\-\+]/) && current.slice(-1).match(/[\/\*\-\+]/)) {
                current = current.slice(0,current.length-1);
            }
            //default: appends key press value to existing output string and displays
            $("#output").html(current+=input);
        }       
    }
}