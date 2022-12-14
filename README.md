______________________________________________________________________________

# Dynamic DB
### Author: Tusliram Kushwah

______________________________________________________________________________

### table of contents

- <a href="#what-it-does"> About </a>
- <a href="#how-to-install"> Install </a>
- <a href="#how-to-use"> Uses </a>
- <a href="#this-getdataarg1-arg2-arguments"> Fetch operation </a>
- <a href="#this-getdatapaginatearg1-arg2-arg3-arguments"> Fetch with pagination operation </a>
- <a href="#this-insertdataarg1-arg2-arg3-arguments"> Insert operation </a>
- <a href="#this-updatedataarg1-arg2-arg3-arg4-arguments"> Update operation </a>
- <a href="#this-deletedataarg1-arg2-arg3-arguments"> Delete operation </a>


______________________________________________________________________________




# What it does
This package can create/alter table dynamically, handle multiple databases 


______________________________________________________________________________



# How to install
>Step 1. You need to run the following command

```php 
composer require tulsiramk/dynamicdb
```

>Step 2. You need to add the following lines to your root composer.json 


```php
"autoload": {
    "psr-4": {
        "App\\": "app/",
        ....
        "tulsiramk\\dynamicdb\\": "vendor/tulsiramk/dynamicdb/src/"            
}
```

And then run the following command from your root directory.
```composer dump-autolo```



>Step 3. You need to add service provider to you `config/app.php`


```php
"providers" => [

    tulsiramk\dynamicdb\DynamicDBServiceProvider::class,

]

```

______________________________________________________________________________


# How to use

>Step 1. You need to use trait to your controller

```php
class Products extends Controller
{
    use \tulsiramk\dynamicdb\DynamicDBTraits;

    ....
```
>Step 2. If you want to use another connection name instead `mysql` then you need to set connection name else skip step 2.

```php
# Set connection name if you are use other then mysql from you config/database.php
# If you are using multiple databases then you need to call below function before make any operation.
$this->setConName('wordpress');

```

______________________________________________________________________________


Step 3. You can use any operation from the list

- `$this->getData(arg, arg)`
- `$this->getDataPaginate(arg, arg, arg)`
- `$this->insertData(arg, arg, arg)`
- `$this->updateData(arg, arg, arg, arg)`
- `$this->deleteData(arg, arg, arg)`

______________________________________________________________________________

#### $this->getData(arg1, arg2) arguments

```php
# To get records from database you need to call following function

$this->getData(arg1, arg2, opt3, opt4, opt5, opt6, opt7)

arg1: string `select columns or * `;
arg2: string `table_name`; 
opt3: optional => where clause array or string
opt4: optional => string order by column_name [Default order ASC]
opt5: optional => string order by Order [DESC/ASC]
opt6: optional => int limit of the records
opt7: optional => int offset of the records

```

###### What $this->getData(arg1, arg2) fn does
- Check table exists or not.
- Return records or null
- If limit 1 then its return single collection of data


______________________________________________________________________________



#### $this->getDataPaginate(arg1, arg2, arg3) arguments

```php
# To get records with pagination from database you need to call following function

$this->getDataPaginate(arg1, arg2, arg3, opt4, opt5, opt6, opt7, opt8)

arg1: string `select columns or * `;
arg2: string `table_name`; 
arg3: int `number of records per page`; 
opt4: optional => where clause array or string
opt5: optional => string order by column_name [Default order ASC]
opt6: optional => string order by Order [DESC/ASC]
opt7: optional => int limit of the records
opt8: optional => int offset of the records

```

###### What $this->getData(arg1, arg2) fn does
- Check table exists or not.
- Return records or null


______________________________________________________________________________



#### $this->insertData(arg1, arg2, arg3) arguments

```php
# To insert records into database you need to call following function

$this->insertData(arg1, arg2, arg3)

arg1: string `table_name`;
arg2: single dimensional array => `['db_col_name1' => 'value1', 'db_col_name2' => 'value2', ... ]` 
arg3: object $request

```
###### prefix of the argument arg2

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


###### What $this->insertData(arg1, arg2, arg3) fn does
- Check table exists or not.
- If not exists create the same.
- If table exists but column not exists
- Create column also
- If you use prefix of the list then column type will be the same

______________________________________________________________________________



#### $this->updateData(arg1, arg2, arg3, arg4) arguments

```php
# To update records into database you need to call following function

$this->updateData(arg1, arg2, arg3, arg4)

arg1: string `table_name`;
arg2: single dimensional array => `['db_col_name1' => 'value1', 'db_col_name2' => 'value2', ... ]` 
arg3: object $request
arg4: (Where clause) single dimensional array => `['name' => 'john', 'status' => 1, ... ]` 

```
###### prefix of the argument arg2

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


###### What $this->updateData(arg1, arg2, arg3, arg4) fn does
- Check table exists or not.
- If not exists create the same.
- If table exists but column not exists
- Create column also
- If you use prefix of the list then column type will be the same (for new column; existed column type will not change)
- Make new entry to `dd_history` table for take old records 
- 

______________________________________________________________________________



#### $this->deleteData(arg1, arg2, arg3) arguments

```php
# To delete record from database you need to call following function

$this->deleteData(arg1, arg2, arg3)

arg1: string `table_name`; 
arg2: object $request
arg3: (Where clause) single dimensional array => `['name' => 'john', 'status' => 1, ... ]` 

```


###### What $this->deleteData(arg1, arg2, arg3) fn does
- Check table exists or not.
- Check record exists or not.
- Make new entry to `dd_history` table for take old records

______________________________________________________________________________





