# Results: `!($d instanceof Certificate)` vs `!$d instanceof Certificate`

## Setup
- Docker image: `php:8.3-cli`
- Test script run inside the container: `tests/instanceof_test.php`
- Execution commands:
  - `docker build -t instanceof_test .`
  - `docker run --rm instanceof_test`

The test defines:
- `class Certificate {}`
- several `$d` values: a `Certificate` instance, a `stdClass` instance, `null`, `false`, and `0`

For each case, the script prints:
- `!($d instanceof Certificate)` (Expression 1)
- `!$d instanceof Certificate` (Expression 2)
- a sanity check: `($(!$d)) instanceof Certificate` (to show the difference if `!` were applied before `instanceof`)

## Observed output

```text
==============================
CASE: certificate_object
d type/value: Certificate / \Certificate::__set_state(array(
))
Expression 1: !($d instanceof Certificate) => false
Expression 2: !$d instanceof Certificate => false
Sanity check: !$d => false
Sanity check: ($(!$d)) instanceof Certificate => false
if1 branch: NOT executed
if2 branch: NOT executed

==============================
CASE: stdClass_object
d type/value: stdClass / (object) array(
)
Expression 1: !($d instanceof Certificate) => true
Expression 2: !$d instanceof Certificate => true
Sanity check: !$d => false
Sanity check: ($(!$d)) instanceof Certificate => false
if1 branch: executed
if2 branch: executed

==============================
CASE: null
d type/value: NULL / NULL
Expression 1: !($d instanceof Certificate) => true
Expression 2: !$d instanceof Certificate => true
Sanity check: !$d => true
Sanity check: ($(!$d)) instanceof Certificate => false
if1 branch: executed
if2 branch: executed

==============================
CASE: false_boolean
d type/value: boolean / false
Expression 1: !($d instanceof Certificate) => true
Expression 2: !$d instanceof Certificate => true
Sanity check: !$d => true
Sanity check: ($(!$d)) instanceof Certificate => false
if1 branch: executed
if2 branch: executed

==============================
CASE: integer_0
d type/value: integer / 0
Expression 1: !($d instanceof Certificate) => true
Expression 2: !$d instanceof Certificate => true
Sanity check: !$d => true
Sanity check: ($(!$d)) instanceof Certificate => false
if1 branch: executed
if2 branch: executed
```

## Conclusion
For all tested inputs, these two conditions behave identically:
- `if (!($d instanceof Certificate)) { ... }`
- `if (!$d instanceof Certificate) { ... }`

## Explanation (what PHP parses)
The results show that PHP parses `!$d instanceof Certificate` as:
- `!( $d instanceof Certificate )`

If PHP instead applied `!` first (i.e. as if it were `($(!$d)) instanceof Certificate`), the “Sanity check” would match Expression 2. It does not: the sanity check is `false` in all cases, while Expression 2 matches Expression 1.

So, the difference is just operator precedence: `instanceof` is evaluated before the unary `!`.

## Artifacts
- `Dockerfile`
- `tests/instanceof_test.php`
- `results.md`

