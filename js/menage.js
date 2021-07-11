var
    _win,
    question,
    _in,
    _out,
    httpRequest,
    tooManyMatches = null,
    lastError = null;

function init() {
    _in = document.getElementById("query_input");
    _out = document.getElementById("output");
    _win = window;
    _win.Shell = window;

    function setMode(newMode) {
        mode = newMode;
    }
    setMode('calc');
}

function go(val_query) {
    question = val_query;

    if (question == "")
        return;

    _in.value='';

    if (_win.closed) {
        printError("Target window has been closed.");
        return;
    }

    try {
        var result = parseModes[mode](question);
        makeRequest('includes/menagequery.php',result);
    } catch (exc) {
        Shell.printError(exc);
    }
}

function writeNode(type, node) {
    var newdiv = document.createElement("div");
    newdiv.className = type;
    newdiv.appendChild(node);
    _out.appendChild(newdiv);
    return newdiv;
}

function println(s, type) {
    s = String(s);
    if (s)
        return writeNode(type, document.createTextNode(s));
}

function printAnswer(a) {
    if (a !== undefined)
        println(a, "normalOutput");
}

function printError(er) {
    var lineNumberString;

    lastError = er; // for debugging the shell
    if (er.name) {
        // lineNumberString should not be "", to avoid a very wacky bug in IE 6.
        lineNumberString = (er.lineNumber != undefined) ? (" on line " + er.lineNumber + ": ") : ": ";
        println(er.name + lineNumberString + er.message, "error"); // Because IE doesn't have error.toString.
    } else {
        println(er, "error");
    }
}

function makeQuery() {
    question = _in.value;
    separateTokenFromComand(question);
    setTimeout(function() { _in.value = ""; }, 0);
}

function separateTokenFromComand(query){
    //value  = str.split(" ");
    array_with_instructions = query.split('\n');
    array_with_instructions = array_with_instructions.map(Function.prototype.call, String.prototype.trim);
    array_with_instructions.forEach(function(array_with_instruction) {
        if(array_with_instruction != ""){
            separate_inst = array_with_instruction.split(' ');
            comand = separate_inst[0];

            switch (comand) {
                case 'query':
                    val_query = array_with_instruction.substr(6, array_with_instruction.length);
                    console.log(val_query);
                    go(val_query); 
                    break;

                case 'index':
                    if(isAlfaNumberOrSpace(array_with_instruction)){
                        if(isNumber(separate_inst[1])){
                            makeRequest('includes/menageindex.php',separate_inst);
                            console.log("inside Index:",separate_inst);
                        }else{
                            Shell.printAnswer("index error: document id not found");
                        }
                    }else{
                        Shell.printAnswer("index error: expected alphanumeric values");
                    }
                    // writeNode("normalOutput", result);
                    break;

                default:
                    Shell.printAnswer("Not a valid instruction");
            }
            console.log(comand);
        }
    })
    //console.log(array_with_instructions);
}

function isNumber(number) {
    return number !== undefined && number.match(/^[0-9]+$/) !== null;
}
function isAlfaNumberOrSpace(anumber) {
    return anumber !== undefined && anumber.match(/^[A-Za-z0-9\s]+$/) !== null;
}

function makeRequest(url,data) {
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('POST', url,false);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('data=' + encodeURIComponent(data));
}

function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            try {
                Shell.printAnswer(httpRequest.responseText);
            } catch (exc) {
                Shell.printError(exc);
            }
            // alert(httpRequest.responseText);
        } else {
            alert('There was a problem with the request.');
        }
    }
}