
var mode="DOZ";
var clearflag=0;
var equationDec =[];
var equationDoz =[];
var current ="";
var output ="";
var x = "X";
var l = "L";

$(document).keypress(function (event) {
     var keynum;

            if(window.event){ // IE                 
                keynum = e.keyCode;
            }else
                if(e.which){ // Netscape/Firefox/Opera                  
                    keynum = e.which;
                 }
            alert(String.fromCharCode(keynum));
        }
})


function replaceXL (xlString) {
    var regX = new RegExp("X","g");
    var regL = new RegExp("L","g");
    xlString = xlString.replace (regX,"a");
    xlString = xlString.replace (regL,"b");
    return xlString;
}

function replaceAB (abString) {
    abString = abString.replace (/\r?a/g,"X");
    abString = abString.replace (/\r?b/g,"L");
    return abString;
}


function int_to_doz(intv) {
    console.log("int to doz: "+intv);
            var res="";
            var R, Q=Math.floor(Math.abs(intv));
            while (true) {
                R = Q % 12;
                res = "0123456789ab".charAt(R)+res;
                Q = (Q-R) / 12;
                if (Q == 0) break;
            }
            return ((intv<0) ? "-"+res : res);
        }


function to_doz(dec) {
            if (dec == "" || dec == "-") return dec;
            var res="";
            var parts = dec.split('.');
            intpart = parts[0];
            fracpart = parts[1];

            result = int_to_doz(intpart);

            if (parts.length > 1 && fracpart.length > 0) {
                result += ';'+intfrac_to_doz(fracpart);
            }

            return result;
        }


function intfrac_to_doz(frac) {
    var len = frac.length;
    frac = parseFloat("0."+frac);
    var res="";
    while (len > 0) {
        var v = 0;
        var n = frac * 12;
        if (len > 1) {
            v = Math.floor(n);
        } else {
            v = Math.round(n);
        }
        frac = n - v;
        res += int_to_doz(v);
        len--;
    }
    return res;
}


function intdoz_to_dec(intdoz) {
            var neg = false;
            if (intdoz.charAt(0) == '-') {
                intdoz = intdoz.substring(1);
                neg = true;
            }
            var res=0, n=0;
            for (i=0; i<intdoz.length; i++) {
                d = intdoz.charAt(i);
                if (d == 'b') {
                    n = 11;
                } else if (d == 'a') {
                    n = 10;
                } else {
                    n = parseInt(d);
                }
                res += n*Math.pow(12,(intdoz.length-i-1));
            }
            if (neg) {
                res = '-'+res;
            }
            return res;
        }


function from_doz(doz) {

            if (doz == "" || doz == "-") return doz;
            var parts = doz.split(';');
            intpart = parts[0];
            fracpart = parts[1];

            var div_times = 0;
            var prec = 0;
            if (parts.length > 1) {
                prec = div_times = fracpart.length;
                intpart = intpart+fracpart;
            }

            result = intdoz_to_dec(intpart);

            while (div_times > 0) {
                result = result/12;
                div_times--;
            }

            result *= Math.pow(10,prec);
            result = Math.round(result);
            result /= Math.pow(10,prec);

            return result;
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
    current = replaceXL(current);


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
                //equationDoz[i] = replaceXL(equationDoz[i]);
                equationDec[i] = from_doz(equationDoz[i]);
            }
        }
       
    }

    if (mode=="DEC") {
        equationDec = current.split(/\r?\#/);
        
        for (var i =0; i<equationDec.length; i++) {

            //copy operators over without processing
            if (equationDec[i].match(/[\/\*\-\+]/)) {
                equationDoz[i]=equationDec[i];
            }

            // convert decimals to dozenals and replace ab's with XL's
            else {
                equationDoz[i]=to_doz(equationDec[i]); 
                //equationDoz[i]=replaceAB(equationDoz[i]); 
            }
        }
    } 
    console.log("create finished with"+equationDec+equationDoz);     
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
            console.log("Step 1: "+output);
            output = output.toString();
            console.log("Step 2: "+output);

            if (mode=="DOZ") {
                // convert result back into base12 and replace a/b's with X/L's
                output = to_doz(output);
                console.log("Step 3a: "+output);
                
            }
            console.log("Step 3: "+output);

            if (output.length > 15) {
                    output = output.slice(0,15);
                    console.log("Step 4a: "+output);
                }
            console.log("Step 5: "+output);

            //output the result
            $("#output").html(replaceAB(output));
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
                output = from_doz(replaceXL(current));
                
              }

            $("#output").html(output);

            mode="DEC";
            // change colors and DEC/DOZ label
            $(this).html(mode);
            $("#output").css("background-color","#ddffe7");
            $(this).css("background-color","#ddffe7");
            $("#point").html(".");

            
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
                    output = to_doz(current);
                }
            }

            $("#output").html(replaceAB(output));

            mode ="DOZ";
            $("#output").css("background-color","#ff9696");
            $(this).html(mode);
            $(this).css("background-color","#ff9696");
            $("#point").html(";");

           
            //clearflag =1;
        }
            

        else {
            // Prevent double pressing operator
            if  (input.match(/[\/\*\-\+]/) && current.slice(-1).match(/[\/\*\-\+]/)) {
                current = current.slice(0,current.length-1);
            }

            if (input.match(/[\/\*\+]/) && current=="") {
                input = "";
            }

            if (input.match(/[\X\L]/) && mode=="DEC") {
                input = "";
            }
            //default: appends key press value to existing output string and displays
            $("#output").html(current+=input);
        }       
    }
}