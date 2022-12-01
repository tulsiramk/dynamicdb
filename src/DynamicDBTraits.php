<?php

namespace Tulsiramk\DynamicDB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use DB;

trait DynamicDBTraits
{
    private static $where_clauses = [
        '!=',
        '=', 
        ">=",
        "<=",
        "like",
        "LIKE",
        ">",
        "<",
        "<>",        
    ];
    protected static $db = 'mysql';

    
    protected $conn;
    protected $schema;




    public function getConnName(){
        echo self::$db;
    }

    public function setConName($db_con_name)
    {   
        if(!is_numeric($db_con_name)){            
            self::$db = $db_con_name;
        }
        else{            
            dd('connection name should be string.');
            //throw ValidationException::withMessages('connection name should be string.');
        }
        
    }

    public function getDbConnect(){ 
        $this->conn = DB::connection(self::$db);        
    }

    public function getSchemaConnect(){
        $this->schema = Schema::connection(self::$db);
    }


    public function checkTable(string $table_name){
        $this->getSchemaConnect();
        return $this->schema->hasTable($table_name);
    }



    public function getData($select, $table_name, $where = null, $order_by = null, $order_by_value = null, $limit = null, $offset = null){
        
        // Get DB connection
        $this->getDbConnect();
        
        if(!$this->checkTable($table_name)){
            return false;
        }
        

        //\DB::enableQueryLog(); // Enable query log

        $resData = $this->conn->table($table_name)->select($select);
        if($where){   
            if(is_array($where)){
                $resData->where($where);
            }
            else{


                if(str_contains($where, 'and') || str_contains($where, 'AND') || str_contains($where, 'or')  || str_contains($where, 'OR') )
                {

                    if (str_contains($where, 'and')) {
                        $and_where_array = explode('and', $where);
                        foreach($and_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }

                    if (str_contains($where, 'AND')) {
                        $and_where_array = explode('AND', $where);
                        foreach($and_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                    if (str_contains($where, 'or')) {
                        $or_where_array = explode('or', $where);
                        foreach($or_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->orWhere(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                    if (str_contains($where, 'OR')) {
                        $or_where_array = explode('OR', $where);
                        foreach($or_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->orWhere(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                }
                else{
                    foreach(self::$where_clauses as $claus){
                        if (str_contains($where, $claus)) { 
                            $whereArray = explode($claus, $where);
                            $whereArray[] = $claus;
                            break;
                        }
                    }                    
                    $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                }

            }

            
        }
        
        if($order_by){                 
            if($order_by_value){                   
                $order_by_order = $order_by_value;
            }
            else{
                $order_by_order = 'asc';
            }
            $resData->orderBy($order_by, $order_by_order);
        }
        if($offset){
            $resData->offset($offset);
        }
        if($limit){ 
            $resData->limit($limit);
        }
        if($limit == 1){ 
            $returnData = $resData->first();
        }
        else{           
            $returnData = $resData->get();
        }
        
        //dd(\DB::getQueryLog()); // Show results of log
        return $returnData;

        // paginate-> check
       
    }

    public function getDataPaginate($select, $table_name, int $paginate, $where = null, $order_by = null, $order_by_value = null, $limit = null, $offset = null){
        
        // Get DB connection
        $this->getDbConnect();
        
        if(!$this->checkTable($table_name)){
            return false;
        }
        

        //\DB::enableQueryLog(); // Enable query log

        $resData = $this->conn->table($table_name)->select($select);
        if($where){   
            if(is_array($where)){
                $resData->where($where);
            }
            else{


                if(str_contains($where, 'and') || str_contains($where, 'AND') || str_contains($where, 'or')  || str_contains($where, 'OR') )
                {

                    if (str_contains($where, 'and')) {
                        $and_where_array = explode('and', $where);
                        foreach($and_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }

                    if (str_contains($where, 'AND')) {
                        $and_where_array = explode('AND', $where);
                        foreach($and_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                    if (str_contains($where, 'or')) {
                        $or_where_array = explode('or', $where);
                        foreach($or_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->orWhere(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                    if (str_contains($where, 'OR')) {
                        $or_where_array = explode('OR', $where);
                        foreach($or_where_array as $where_str){
                            foreach(self::$where_clauses as $claus){
                                if (str_contains($where_str, $claus)) { 
                                    $whereArray = explode($claus, $where_str);
                                    $whereArray[] = $claus;
                                    break;
                                }
                            }
                            $resData->orWhere(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                        }
                    }
                }
                else{
                    foreach(self::$where_clauses as $claus){
                        if (str_contains($where, $claus)) { 
                            $whereArray = explode($claus, $where);
                            $whereArray[] = $claus;
                            break;
                        }
                    }                    
                    $resData->where(str_replace(' ', '', $whereArray[0]), str_replace(' ', '', $whereArray[2]), str_replace(' ', '', $whereArray[1]));
                }

            }

            
        }
        
        if($order_by){                 
            if($order_by_value){                   
                $order_by_order = $order_by_value;
            }
            else{
                $order_by_order = 'asc';
            }
            $resData->orderBy($order_by, $order_by_order);
        }
        if($offset){
            $resData->offset($offset);
        }
        if($limit){ 
            $resData->limit($limit);
        }
        if($limit == 1){ 
            $returnData = $resData->paginate($paginate);
        }
        else{           
            $returnData = $resData->paginate($paginate);
        }
        
        //dd(\DB::getQueryLog()); // Show results of log
        return $returnData;

        // paginate-> check
       
    }


    /**
     * I will take two arguments (arg1, arg2)
     * arg1 = Table name
     * arg2 = array // ['col1' => 'val1', 'col2' => 'val2' .... 'coln' => 'valn'] // date type VARCHAR (255)
     * arg2 = array // ['col1[text]' => 'longVal'] // this will create a col1 column in database with data type TEXT
     * arg2 = array // ['col1[number]' => 12345] // create a col1 column in database with data type INTEGER
     * arg2 = array // ['col1[DATE]' => '2022-09-01 00:00:00'] // create a col1 column in database with data type DATE
     * 
     * array = ['ColName user'] == col_name_user
     * array = ['UserAddress *^%$$ hoMe'] == user_address_ho_me
     * 
     * Extra columns [id (int, auto_increment, primary_key, not null), dd_status (int not null), trk_created_at (datetime default CURRENT_TIMESTAMP, not null), trk_updated_at (datetime null), dd_ip_address (varchar 255, null)]
     * 
     * if table created then return true else return false 
     * 
     */
    public function createTable(string $table_name, array $data){
        // Get DB connection
        $this->getDbConnect();

        $column_names = array_keys($data);
        if(is_array($column_names)){
            if(count($column_names) > 0){
                $create_table_query = "CREATE TABLE $table_name (";
                $create_table_query .= "id INT NOT NULL AUTO_INCREMENT,";
                foreach ($column_names as $column_name) {

                    $column_name = preg_replace('/\B([A-Z])/', '_$1', $column_name);

                    if (str_contains($column_name, 'long_')) { 
                        //$column_name = str_replace('[text]', '', $column_name);
                        $column_name = Str::slug($column_name, '_');
                        $create_table_query .= "$column_name TEXT NULL, "; 
                    }
                    else if (str_contains($column_name, '[text]')) { 
                        $column_name = str_replace('[text]', '', $column_name);
                        $column_name = Str::slug($column_name, '_');
                        $create_table_query .= "$column_name TEXT NULL, "; 
                    }
                    else if(str_contains($column_name, '[number]')){
                        $column_name = str_replace('[number]', '', $column_name);
                        $column_name = Str::slug($column_name, '_');
                        $create_table_query .= "$column_name INT NULL, ";
                    }
                    else if(str_contains($column_name, '[date]')){
                        $column_name = str_replace('[date]', '', $column_name);
                        $column_name = Str::slug($column_name, '_');
                        $create_table_query .= "$column_name DATE NULL, ";
                    }
                    else{    
                        $column_name = Str::slug($column_name, '_');                    
                        $create_table_query .= "$column_name varchar(255) NULL, ";
                    }
                    
                }

                //---Extra columns--
                
                $create_table_query .= "dd_status int NOT NULL, ";
                $create_table_query .= "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ";
                $create_table_query .= "updated_at TIMESTAMP NULL, ";
                $create_table_query .= "dd_ip_address varchar(255) NULL, ";

                $create_table_query .= "PRIMARY KEY (id)"; 
                $create_table_query .= ")";

                return $this->conn->statement($create_table_query);
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

       
               
    }

    /**
     * This will create new columns into table
     */
    public function staticCheckColumns(string $table_name, array $data){

        // Get DB connection
        $this->getSchemaConnect();

        $column_names = array_keys($data);
        if(is_array($column_names)){
            if(count($column_names) > 0){
                foreach ($column_names as $column_name) {
                    
                    if (!$this->schema->hasColumn($table_name, $column_name)) {                        
                        
                        $column_name = preg_replace('/\B([A-Z])/', '_$1', $column_name);

                        if (str_contains($column_name, 'long_')) { 
                            //$column_name = str_replace('[text]', '', $column_name);
                            $column_name = Str::slug($column_name, '_');

                            if (!$this->schema->hasColumn($table_name, $column_name)) {
                                $add_column_query = "ALTER TABLE $table_name ";
                                $add_column_query .= "ADD COLUMN `$column_name` TEXT NULL ";
                                $this->conn->statement($add_column_query);
                            } 
                        }
                        else if (str_contains($column_name, '[text]')) { 
                            $column_name = str_replace('[text]', '', $column_name);
                            $column_name = Str::slug($column_name, '_');

                            if (!$this->schema->hasColumn($table_name, $column_name)) {
                                $add_column_query = "ALTER TABLE $table_name ";
                                $add_column_query .= "ADD COLUMN `$column_name` TEXT NULL ";
                                $this->conn->statement($add_column_query);
                            } 
                        }
                        else if(str_contains($column_name, '[number]')){
                            $column_name = str_replace('[number]', '', $column_name);
                            $column_name = Str::slug($column_name, '_');

                            if (!$this->schema->hasColumn($table_name, $column_name)) {
                                $add_column_query = "ALTER TABLE $table_name ";
                                $add_column_query .= "ADD COLUMN `$column_name` INT NULL ";
                                $this->conn->statement($add_column_query);
                            }
                        }
                        else if(str_contains($column_name, '[date]')){
                            $column_name = str_replace('[date]', '', $column_name);
                            $column_name = Str::slug($column_name, '_');

                            if (!$this->schema->hasColumn($table_name, $column_name)) {
                                $add_column_query = "ALTER TABLE $table_name ";
                                $add_column_query .= "ADD COLUMN `$column_name` DATE NULL ";
                                $this->conn->statement($add_column_query);
                            }
                        }
                        else{    
                            $column_name = Str::slug($column_name, '_');  
                            
                            if (!$this->schema->hasColumn($table_name, $column_name)) {
                                $add_column_query = "ALTER TABLE $table_name ";
                                $add_column_query .= "ADD COLUMN `$column_name` varchar(255) NULL ";
                                $this->conn->statement($add_column_query);
                            }
                        }

                        //echo $add_column_query;
                        //$this->conn->statement($add_column_query);
                    }
                    
                }
                
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * Create table if not exists and and create columns if not exists
     */
    public function insertData(string $table_name, array $data, $request){        
        $res = $this->checkTable($table_name);
        if($res){
            $checkColumns = $this->staticCheckColumns($table_name, $data);            
            if($checkColumns){ 
                //---Insert Data--
                return $this->trueInsertData($table_name, $data, $request);
            }
            else{
                echo "Unable to create column";
            }
        }
        else{
            $is_create_table = $this->createTable($table_name, $data);
            if($is_create_table){
                //---Insert Data--                
                return $this->trueInsertData($table_name, $data, $request);
            }
            else{
                return "There is some issue to create table.";
            }
            //var_dump($is_create_table);
        }
        //var_dump($res);
    }

    /**
     * This will insert data into database
     */
    public function trueInsertData(string $table_name, array $data ,$request){   
        // Get DB connection
        $this->getDbConnect();
        
        
        $cleanData = $this->cleanData($data); 
        //---Extra columns--
        //dd($this->schema->hasColumn($table_name, 'dd_status'));
        if ($this->schema->hasColumn($table_name, 'dd_status')){
            $cleanData['dd_status'] = 1;
            $cleanData['dd_ip_address'] = $request->ip();
        }

        

        $insRes = $this->conn->table($table_name)->insertGetId($cleanData);        
        if($insRes){
            //DB::getPdo()->lastInsertId();
            return $insRes;
        }
        else{
            return $insRes;
        }
    }

    /**
     * This function will return clean data [clean_key => value];
     */
    public function cleanData(array $data){
        $cleanData = array();
        if(count($data) > 0){
            foreach ($data as $column_name => $col_value) {      

                $column_name = preg_replace('/\B([A-Z])/', '_$1', $column_name);

                if (str_contains($column_name, '[text]')) { 
                    $column_name = str_replace('[text]', '', $column_name);
                    $column_name = Str::slug($column_name, '_');
                    $cleanData[$column_name] = $col_value;                       
                }
                else if(str_contains($column_name, '[number]')){
                    $column_name = str_replace('[number]', '', $column_name);
                    $column_name = Str::slug($column_name, '_');
                    $cleanData[$column_name] = $col_value;
                }
                else if(str_contains($column_name, '[date]')){
                    $column_name = str_replace('[date]', '', $column_name);
                    $column_name = Str::slug($column_name, '_');
                    $cleanData[$column_name] = $col_value;
                }
                else{    
                    $column_name = Str::slug($column_name, '_'); 
                    $cleanData[$column_name] = $col_value;
                    
                }
            }
            return $cleanData;
        }
        else{
            return 'No data to insert';
        }
    }

    /**
     * This function will check table and column exists or not and update it
     */

    public function updateData(string $table_name, array $data, $request, $whereCondition){

        $res = $this->checkTable($table_name);
        if($res){
            $checkColumns = $this->staticCheckColumns($table_name, $data);            
            if($checkColumns){ 
                //---Insert Data--
                return $this->trueUpdateData($table_name, $data, $request, $whereCondition);
            }
            else{
                echo "Unable to create column";
            }
        }
        else{
            $is_create_table = $this->createTable($table_name, $data);
            if($is_create_table){
                //---Insert Data--                
                return $this->trueUpdateData($table_name, $data, $request, $whereCondition);
            }
            else{
                return "There is some issue to create table.";
            }
            //var_dump($is_create_table);
        }
    }


     /**
     * This will update data into database
     */
    public function trueUpdateData(string $table_name, array $data ,$request, $whereCondition){        

        // Get DB connection
        $this->getDbConnect();


        $cleanData = $this->cleanData($data); 
        //---Extra columns--
        if ($this->schema->hasColumn($table_name, 'dd_status')){
            $cleanData['dd_status'] = 1;
            $cleanData['dd_ip_address'] = $request->ip();
        }
        $rcExists = $this->getData('*', $table_name, $whereCondition);
        if($rcExists){
            $history['long_old_rc'] = json_encode($rcExists);
            $history['long_updated_rc'] = json_encode($cleanData);
            $history['operation'] = 'deleted';
            $history['trk_status'] = 1;
            $this->insertData('dd_history', $history, $request);        
            return $this->conn->table($table_name)->where($whereCondition)->update($cleanData);
        }
        else{
            return false;
        } 
        
    }


    public function deleteData(string $table_name, $request, $whereCondition){
        // Get DB connection
        $this->getDbConnect();

        $res = $this->checkTable($table_name);
        if($res){
            $rcExists = $this->getData('*', $table_name, $whereCondition);
            if($rcExists){
                $history['long_old_rc'] = json_encode($rcExists);
                $history['operation'] = 'deleted';
                $this->insertData('dd_history', $history, $request);
                return DB::table($table_name)->where($whereCondition)->delete();
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

}


