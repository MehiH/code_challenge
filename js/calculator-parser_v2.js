// # calculator-parser.js

// ## Part One – Breaking code down into tokens

// This function, `tokenize(code)`, takes a string `code` and splits it into
function tokenize(code) {
    var results = [];
    var tokenRegExp = /\s*([A-Za-z0-9]+|\S)\s*/g;

    var m;
    while ((m = tokenRegExp.exec(code)) !== null)
        results.push(m[1]);
    return results;
}


function isToken(token) {
    return token !== undefined && token.match(/^[A-Za-z0-9]+$/) !== null;
}


// ## Part Two – The parser

// The parser’s job is to decode the input and build a collection of objects
// that represent the code.
// Parse the given string `code` as an expression in our little language.

function parse(code) {
    // Break the input into tokens.
    var tokens = tokenize(code);

    var position = 0;

    // `peek()` returns the next token without advancing `position`.
    function peek() {
        return tokens[position];
    }

    // `consume(token)` consumes one token, moving `position` to point to the next one.
    function consume(token) {
        assert.strictEqual(token, tokens[position]);
        position++;
    }

    function parsePrimaryExpr() {
        var t = peek();

        if (isToken(t)) {
            consume(t);
            return {type: "token", value: t};
        } else if (t === "(") {
            consume(t);
            var expr = parseExpr();
            if (peek() !== ")")
                throw "query error: expected )"; //new SyntaxError("query error: expected )");
            consume(")");
            return expr;
        } else {
            // If we get here, the next token doesn’t match any of the
            // rules. So it’s an error.
            // throw new SyntaxError("query error: expected a token(alfanumeric), & , | , or parentheses");
            throw "query error: expected a token(alfanumeric), & , | , or parentheses";
        }
    }

    function parseExpr() {
        var expr = parsePrimaryExpr();
        var t = peek();
        while (t === "&" || t === "|") {
            consume(t);
            var rhs = parsePrimaryExpr();
            expr = {type: t, left: expr, right: rhs};
            t = peek();
        }
        return expr;
    }

    var result = parseExpr();

    if (position !== tokens.length)
        throw "query error: unexpected'" + peek() + "'"; // throw new SyntaxError("query error: unexpected'" + peek() + "'");

    return result;
}
