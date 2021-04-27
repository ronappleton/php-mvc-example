# php-mvc-example
An example framework for php

This is a real basic example of a php framework.

It's interesting to see how things work sometimes, please note this project is deliberatly not a composer project so that
it can be seen just how useful composer can be.

There are currently no models in this example framework yet, however it does have the following.

 - A frontend cntroller
 - An input library
 - A view processor
 - A router, with route parameters
 
 While the router is not production ready by any means, it does show how much can go into routing and use a pretty modern convention.
 It is a controller factory of sorts.
 
 Please note, it is designed to be used with the built in php server and is written in php 8, but adaption to lesser php versions is a simple process,
 just remove the type hint in method parameters for everything other than array and remove the return types and ctrict type declarations.
 
 ```php
 php -S localhost:8080 public/index.php
 ```

From your project base directory will run the framework. You can then open your browser and head to http://localhost:8080 to use.


Note: This is not a how to, it is not an example of how it should be done, it is simply an example of how it can be done, no priciples have been followed, no discoveries made and in no way should you build a site with this and release it on the internet. I simply wanted to provide an example on the internet that is not using switch cases and query parameters for routing, and how we can acheive pretty urls without rewriting (you should use rewriting).

Credits:
https://selvinortiz.com/blog/traversing-arrays-using-dot-notation for the dot notation access of super globals in the Input helper. Its been done so many times,
it was pointless me writing it.
