JSCompressor by Jesse Vitrone

This Java based tool allows a developer to compress and merge multiple
javascript files into 1 big file, therefor reducing the work that your
browser has to do to get all the needed javascript code.

run it simply like this:

java JSCompressor

This will read the config from the default jsCompressor.xml
If you'd like to have it read for a different config file, just
specify the file name with the -config <filename> flag.

For more information on setting up a config file, see the comments
in jsCompressor.xml

The pre-compiled classes that are here were compiled with jdk 1.4.1_02.
If they don't work for you, you should be able to recomile your own 
with a simple "javac JSCompressor.java"

Feel free to email comments, bugs, etc to jesse@6thgearsoftware.com