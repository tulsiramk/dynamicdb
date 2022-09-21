# Dynamic DB
### Author: Tusliram Kushwah

# What it does
This package can create/alter table dynamically, handle multiple databases 



# How to install
>First you need to run the following command
```composer require tulsiramk/dynamicdb```

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



# How to use

>Step 1. You need to use trait to your controller

```php
class Products extends Controller
{
    use \tulsiramk\dynamicdb\DynamicDBTraits;

    ....
```
>Step 2. If you want to use another connection name instead `mysql` then you need to set connection name else leave it.

```php
Set connection name

$this->setConName('wordpress');

```
Step 3. You can use any operation from the listing

- `$this->insertData(arg, arg, arg)`
- `$this->updateData(arg, arg, arg, arg)`
- `$this->deleteData(arg, arg, arg)`


#### `$this->insertData(arg1, arg2, arg3) arguments

```php
To insert data into database you need to call following function

$this->insertData(arg1, arg2, arg3)

arg1: string `table_name`;
arg2: single dimensional array => `['db_col_name1' => 'value1', 'db_col_name2' => 'value2', ... ]` 
arg3: object $request

```

###### What $this->insertData(arg1, arg2, arg3) fn does
- Check table exists or not.
- If not exists create the same.
- If table exists but column not exists
- Create column also
- If you use prefix of the list then column type will be the same

<table>
    <tr>
        <td>`db_col_name1_[text]`</td>
        <td>This will create `db_col_name1` column with type `text`</td>
    </tr>
    <tr>
        <td>`db_col_name1_[number]`</td>
        <td>This will create `db_col_name1` column with type `int(11)`</td>
    </tr>
    <tr>
        <td>`db_col_name1_[date]`</td>
        <td>This will create `db_col_name1` column with type `date`</td>
    </tr>
    <tr>
        <td>`db_col_name1`</td>
        <td>This will create `db_col_name1` column with type `varchar(255)`</td>
    </tr>
</table>




#### `$this->updateData(arg1, arg2, arg3, arg4) arguments

```php
To insert data into database you need to call following function

$this->insertData(arg1, arg2, arg3)

arg1: string `table_name`;
arg2: single dimensional array => `['db_col_name1' => 'value1', 'db_col_name2' => 'value2', ... ]` 
arg3: object $request
arg4: (Where clause) single dimensional array => `['name' => 'john', 'status' => 1, ... ]` 

```



###### What $this->updateData(arg1, arg2, arg3, arg4) fn does
- Check table exists or not.
- If not exists create the same.
- If table exists but column not exists
- Create column also
- If you use prefix of the list then column type will be the same (for new column; existed column type will not change)
- Make new entry to `dd_history` table for take old records 
- 

<table>
    <tr>
        <td>`db_col_name1_[text]`</td>
        <td>This will create `db_col_name1` column with type `text`</td>
    </tr>
    <tr>
        <td>`db_col_name1_[number]`</td>
        <td>This will create `db_col_name1` column with type `int(11)`</td>
    </tr>
    <tr>
        <td>`db_col_name1_[date]`</td>
        <td>This will create `db_col_name1` column with type `date`</td>
    </tr>
    <tr>
        <td>`db_col_name1`</td>
        <td>This will create `db_col_name1` column with type `varchar(255)`</td>
    </tr>
</table>



#### `$this->deleteData(arg1, arg2, arg3) arguments

```php
To insert data into database you need to call following function

$this->insertData(arg1, arg2, arg3)

arg1: string `table_name`; 
arg2: object $request
arg3: (Where clause) single dimensional array => `['name' => 'john', 'status' => 1, ... ]` 

```


###### What $this->deleteData(arg1, arg2, arg3) fn does
- Check table exists or not.
- Check record exists or not.
- Make new entry to `dd_history` table for take old records






