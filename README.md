# glu-log-php

## WHAT IS THIS?

This is a logging utility for recording personal glucose data of people who 
have diabetes and insuline treatment. It's to be installed on a www server, 
and can be used even with the simplest browser, even with a 2011 mobile.
Thus, the UI is quite terse but functional.

It begun in 2010 as a tinkering project of mine, as a friend had a son with diabetes.
The friend worked for Nokia, thus it was made for small (Nokia) mobile screens.
It is still a tinkering project, and if nothing else, proves that I'm a prominent 
in tinkering. This is about the first thing I've ever made in PHP.

The purpose of publication of this is educational and of course self-promotional,
and I would be happy if this should be helpful to someone.

## INSTALLATION

You'll need a web server account with PHP 5, MySQL and FTP access.
Copying files to tour web root is not enough, you will also have to create
databases clientdata and healthrecords in MySQL and fill in access credentials
in *./DbMan/conf/DbConf.php*

## SECURITY WARNING

The security is pretty low, even if it has a challenge-response 
system for transaction authentication. There are better challenge-response libraries 
available nowadays, mine was never really acid tested. The data flow is unencrypted.

## COMPONENTS COPYRIGHT NOTICE

prototype.js is used. Thanks!

```
Prototype JavaScript framework, version 1.7
(c) 2005-2010 Sam Stephenson
Prototype is freely distributable under the terms of an MIT-style license.
For details, see the Prototype web site: http://www.prototypejs.org/ 
```

