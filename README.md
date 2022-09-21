Step 1 . You need to add the following lines to your root composer.json And run <code>composer dump-autolo<code>
<pre>
"autoload": {
    "psr-4": {
        "App\\": "app/",
        ....
        "tulsiramk\\dynamicdb\\": "vendor/tulsiramk/dynamicdb/src/"            
}
</pre>



<hr/>


config/app.php

'providers' => [


    .............
    tulsiramk\dynamicdb\DynamicDBServiceProvider::class,

]



