# Dynamic DB
### Author: Tusliram Kushwah

#### What it does
This package can create/alter table dynamically, handle multiple database 


>Step 1. You need to add the following lines to your root composer.json 


```php
"autoload": {
    "psr-4": {
        "App\\": "app/",
        ....
        "tulsiramk\\dynamicdb\\": "vendor/tulsiramk/dynamicdb/src/"            
}
```

And run the following command from you root directory.
```composer dump-autolo```



>Step 2. You need to add service provider to you `config/app.php`


```php
"providers" => [

    tulsiramk\dynamicdb\DynamicDBServiceProvider::class,

]

```



