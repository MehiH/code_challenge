// # calculator-backends.js

function evaluateQuery(code) {

    function evaluate(obj) {
        switch (obj.type) {
        case "token":  return "\\b"+obj.value+"\\b";
        case "&":  return "("+evaluate(obj.left) +"[(\\d\\s\\w)]*"+ evaluate(obj.right)+")"+"|("+evaluate(obj.right) +"[(\\d\\s\\w)]*"+ evaluate(obj.left)+")";
        case "|":  return "("+ evaluate(obj.left)+"|"+ evaluate(obj.right)+")";
        }
    }
    return evaluate(parse(code));
}

var parseModes = {
    calc: evaluateQuery
};
