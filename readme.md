You need to add 

"autoload": {
        "psr-4": {
            "App\\": "app/",
            ....
            "tulsiramk\\dynamicdb\\": "vendor/tulsiramk/dynamicdb/src/"
            
        }

to your root composer.json

And run composer dump-autolo


////////////////////////////////////////////////


config/app.php

'providers' => [


    .............
    tulsiramk\dynamicdb\DynamicDBServiceProvider::class,

]



