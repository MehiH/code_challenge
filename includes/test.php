<?php 

use Parle\{Parser, ParserException, Lexer, Token};

$p = new Parser;
$p->token("INTEGER");
$p->left("'+' '-' '*' '/'");

$p->push("start", "exp");
$prod_add = $p->push("exp", "exp '+' exp");
$prod_sub = $p->push("exp", "exp '-' exp");
$prod_mul = $p->push("exp", "exp '*' exp");
$prod_div = $p->push("exp", "exp '/' exp");
$p->push("exp", "INTEGER"); /* Production index unused. */

$p->build();

$lex = new Lexer;
$lex->push("[+]", $p->tokenId("'+'"));
$lex->push("[-]", $p->tokenId("'-'"));
$lex->push("[*]", $p->tokenId("'*'"));
$lex->push("[/]", $p->tokenId("'/'"));
$lex->push("\\d+", $p->tokenId("INTEGER"));
$lex->push("\\s+", Token::SKIP);

$lex->build();

$exp = array(
    "1 + 1",
    "33 / 10",
    "100 * 45",
    "17 - 45",
);

foreach ($exp as $in) {
    if (!$p->validate($in, $lex)) {
        throw new ParserException("Failed to validate input");
    }

    $p->consume($in, $lex);

    while (Parser::ACTION_ERROR != $p->action && Parser::ACTION_ACCEPT != $p->action) {
        switch ($p->action) {
            case Parser::ACTION_ERROR:
                throw new ParserException("Parser error");
                break;
            case Parser::ACTION_SHIFT:
            case Parser::ACTION_GOTO:
            case Parser::ACTION_ACCEPT:
                break;
            case Parser::ACTION_REDUCE:
                switch ($p->reduceId) {
                    case $prod_add:
                        $l = $p->sigil(0);
                        $r = $p->sigil(2);
                        echo "$l + $r = " . ($l + $r) . "\n";
                        break;
                    case $prod_sub:
                        $l = $p->sigil(0);
                        $r = $p->sigil(2);
                        echo "$l - $r = " . ($l - $r) . "\n";
                        break;
                    case $prod_mul:
                        $l = $p->sigil(0);
                        $r = $p->sigil(2);
                        echo "$l * $r = " . ($l * $r) . "\n";
                        break;
                    case $prod_div:
                        $l = $p->sigil(0);
                        $r = $p->sigil(2);
                    echo "$l / $r = " . ($l / $r) . "\n";
                        break;
            }
            break;
        }
        $p->advance();
    }
}