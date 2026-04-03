The goal is to find out is these constructions are equal or not:

1st condition:
if (!($d instanceof Certificate)) {...

2nd condition:
if (!$d instanceof Certificate) {...

To proove the result, you should initialize docker container with modern version of PHP, write two examples of using these conditions, run them INSIDE the container and catch the results. Do NOT install or run any code on the host.

Save all artefacts you generate, including Dockefile and test files.

You should provide the results with an explaination. Put them into results.md

