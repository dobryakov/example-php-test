<?php

/**
 * This script compares two PHP expressions:
 *   1) !($d instanceof Certificate)
 *   2) !$d instanceof Certificate
 *
 * It prints both the raw expression results and which `if (...) {}` branch runs.
 */

class Certificate {}

$cases = [
    'certificate_object' => new Certificate(),
    'stdClass_object' => new stdClass(),
    'null' => null,
    'false_boolean' => false,
    'integer_0' => 0,
];

foreach ($cases as $caseName => $d) {
    echo "==============================\n";
    echo "CASE: {$caseName}\n";

    $dType = is_object($d) ? get_class($d) : gettype($d);
    echo "d type/value: {$dType} / ";
    var_export($d);
    echo "\n";

    $expr1 = !($d instanceof Certificate);
    $expr2 = !$d instanceof Certificate;
    $notd = !$d;
    $expr2_if_we_parenthesize_as_instanceof = ($notd instanceof Certificate);

    echo "Expression 1: !(\$d instanceof Certificate) => ";
    var_export($expr1);
    echo "\n";

    echo "Expression 2: !\$d instanceof Certificate => ";
    var_export($expr2);
    echo "\n";

    echo "Sanity check: !\$d => ";
    var_export($notd);
    echo "\n";

    echo "Sanity check: (\$(!\$d)) instanceof Certificate => ";
    var_export($expr2_if_we_parenthesize_as_instanceof);
    echo "\n";

    // Make the branch behavior explicit.
    if (!($d instanceof Certificate)) {
        echo "if1 branch: executed\n";
    } else {
        echo "if1 branch: NOT executed\n";
    }

    if (!$d instanceof Certificate) {
        echo "if2 branch: executed\n";
    } else {
        echo "if2 branch: NOT executed\n";
    }

    echo "\n";
}

