<?php
namespace App\Library\Crud;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;




class DataSchema {


	protected function __Construct(){
		//self::_run();		
	}

	//obtener tablas por nombre
	protected static function Getdata(String $table=''){
		
		$result=[];
		$data= self::InformationTables();

		//if(array_key_exists($table, $data)){}

			foreach($data as $k=> $rows){
			
				$tables['KCU']= $k;
	    		$r= self::SqlQuery($tables);
	    		$result[$k]= $r['KCUL']; 

	    	}

	    	return $result;
		
	}

	protected static function GetAllRel(){
		$data= self::InformationTables();

		foreach($data as $k=> $rows){
			$tables['KCU']= $k;
	    	return self::SqlQuery($tables)['REL'];
		}
			
	}

	protected static function InformationTables(){

		try{
	    
	    $INFOS=[];
	    $tables['KCUT']='tables';
	    $INFOS= self::SqlQuery($tables);
	    $data=[];
	    $result=[];
	 	
	 	//dd($INFOS);
	    if(isset($INFOS['REL_T'])){//rel_t list table to menu html css
	    
	        $data= $INFOS['REL_T'];
	    
	        if(is_array($data) && !empty($data)){
	    
	            $c=count($data);

	            for($i=0; $i < $c; $i++){
	            	//dd($data[$i]);
	                $result[$data[$i]['TABLE_NAME']]= $data[$i]['TABLE_NAME'];

	            }

	         return $result;

	        }
	    }

	}
	catch(\Exception $e){
		self::Exception($e);
	}
}

protected static function Exception(\Exception $e){
		
	$msg= "Sys: Code---> ".$e->getCode()."\n Message---> ".$e->getMessage()."\n Line---> ".$e->getLine();
	echo $msg;
}

	//run querys
	private static function DBRaw($query){
		try{
			//dd($query);
   	 	
   	 		$data= DB::select(DB::raw($query));
    	 	return $data;
    	
    	}
    	catch(\Exception $e){
    		self::Exception($e);
    	}
	}

	//get run querys
	protected static function getquery($query){
		$data=  self::DBRaw($query);
		return $data;
	}
	private static function getall($query){
		$data=  self::DBRaw($query);
		return self::all($data);
	}

	protected static function all($query){
	    $results=[];
	    $arr=[];
	    $data=  $query;
	    //dd($data);
	    if(is_array($data)){
	        foreach($data as $j=> $rows){
	        if (is_object($data[$j])){
	            $po= get_object_vars($data[$j]);
	            foreach($po as $k=> $fields){
	                $arr[$k]= $po[$k];
	                }
	         $results[$j]= $arr;
	            }
	         }

	       return $results;
	    }
	}//end func.


/*******************************
 * 							   *
 * Fuente: microsoft sql       *
 *                             *
 *******************************/
	private static function SqlQuery($nTB){

      try{


        $data=[];
        if(isset($nTB['KCU'])) {
                    $query="SELECT `TABLE_CATALOG` AS `TABLE_CATALOG`,
                        `TABLE_SCHEMA` AS `TABLE_SCHEMA`,
                        `TABLE_NAME` AS `PRIMARY_TABLE_NAME`,
                        `COLUMN_NAME` AS `COLUMN_NAME`,
                        `ORDINAL_POSITION` AS `ORDINAL_POSITION`,
                        `COLUMN_DEFAULT` AS `COLUMN_DEFAULT`,
                        `IS_NULLABLE` AS `IS_NULLABLE`,
                        `DATA_TYPE` AS `DATA_TYPE`,
                        `CHARACTER_MAXIMUM_LENGTH` AS `CHARACTER_MAXIMUM_LENGTH`,
                        `CHARACTER_OCTET_LENGTH` AS `CHARACTER_OCTET_LENGTH`,
                        `NUMERIC_PRECISION` AS `NUMERIC_PRECISION`,
                        `NUMERIC_SCALE` AS `NUMERIC_SCALE`,

                        `CHARACTER_SET_NAME` AS `CHARACTER_SET_NAME`,
                        `COLLATION_NAME` AS `COLLATION_NAME`,
                        `COLUMN_TYPE` AS `COLUMN_TYPE`,
                        `COLUMN_KEY` AS `COLUMN_KEY`,
                        `EXTRA` AS `EXTRA`,
                        `PRIVILEGES` AS `PRIVILEGES`,
                        `COLUMN_COMMENT` AS `COLUMN_COMMENT`

                        FROM `INFORMATION_SCHEMA`.`COLUMNS`
                            WHERE `TABLE_SCHEMA`= '".env('DB_DATABASE')."' AND `TABLE_NAME`='".$nTB['KCU']."'
                            ORDER BY `ORDINAL_POSITION`, `ORDINAL_POSITION` ";

                    $data['KCUL']= self::getall($query);

                    $query2= "SELECT ".$nTB['KCU'].".TABLE_NAME AS `UNIQUE_TABLE_NAME`,
                        COLUMN_NAME AS `COLUMN_NAME`,
                        UNIQUE_CONSTRAINT_SCHEMA,
                        UNIQUE_CONSTRAINT_NAME,
                        ".$nTB['KCU'].".REFERENCED_TABLE_NAME,
                        REFERENCED_COLUMN_NAME,
                        ".$nTB['KCU'].".CONSTRAINT_NAME AS `FOREING_CONSTRAINT_NAME`,
                        ORDINAL_POSITION,
                        POSITION_IN_UNIQUE_CONSTRAINT,
                        ".$nTB['KCU'].".CONSTRAINT_SCHEMA

                        FROM `INFORMATION_SCHEMA`.`REFERENTIAL_CONSTRAINTS` RC

                        INNER JOIN `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE` ".$nTB['KCU']."
                            ON  ".$nTB['KCU'].".CONSTRAINT_CATALOG = RC.CONSTRAINT_CATALOG
                            AND ".$nTB['KCU'].".CONSTRAINT_SCHEMA = RC.CONSTRAINT_SCHEMA
                            AND ".$nTB['KCU'].".CONSTRAINT_NAME = RC.CONSTRAINT_NAME
                            AND ".$nTB['KCU'].".TABLE_NAME = RC.TABLE_NAME
                            AND ".$nTB['KCU'].".REFERENCED_TABLE_NAME = RC.REFERENCED_TABLE_NAME

                        WHERE ".$nTB['KCU'].".CONSTRAINT_SCHEMA = '".env('DB_DATABASE')."'
                         AND ".$nTB['KCU'].".TABLE_NAME = ".$nTB['KCU'].".TABLE_NAME
                         AND ".$nTB['KCU'].".REFERENCED_TABLE_NAME = RC.REFERENCED_TABLE_NAME

                         ORDER BY ".$nTB['KCU'].".CONSTRAINT_NAME, ".$nTB['KCU'].".CONSTRAINT_NAME ";


                    $data['REL']=  self::getall($query2);


                     return $data;
            }

            if(isset($nTB['KCUT'])){
                    $query3= "SELECT * FROM `INFORMATION_SCHEMA`.`TABLES`
                     WHERE `TABLE_SCHEMA`= '".env('DB_DATABASE')."' ";
                    //`TABLE_NAME`, `TABLE_ROWS`, `CREATE_TIME`, `UPDATE_TIME`
                    $data['REL_T']=  self::getall($query3);

                     return $data;
            }


        }catch(\Exception $e){
        	self::Exception($e);
        }
    }



}//endclass
