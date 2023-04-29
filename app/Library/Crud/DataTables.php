<?php
namespace App\Library\Crud;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

use App\Library\Crud\DataSchema;



class DataTables extends DataSchema {

	//public $InfoInputs=[];
    protected $TABLE_NAME=[];
    protected $getdatajoin=[];
    protected $DataDB=[];
    protected $DataInputs=[];
    protected $createInputs=[];
    protected $editInputs=[];
    protected $ALL_COLUMN_TABLE;
    protected $ALL_COLUMN_TABLE_EDIT;
    protected $ORDINAL_POSITION;
    protected $IS_NULLABLE;
    protected $DATA_TYPE;
    protected $MaxLength;
    protected $COLUMN_TYPE;
    protected $COLUMN_KEY;
    protected $COLUMN_PRIMARY_KEY;
    protected $COLUMN_COMMENT;

    /**public**/

    public $gridHtml;
    public $formHtmlCreate;
    public $formHtmlUpdate;

	public function __Construct(){
		parent::__construct();	
		$this->_GetInformationSchema();
        $this->run();
        
	}


private function run(){

    /*load data**/
  if(!empty($this->TABLE_NAME)){
    $this->DataDB();
    $this->schemadataDbJoin();
    /****** */
    $this->_GetInputsHtml();
    $this->gridHtml();
    $this->formHtmlUpdate();
    $this->formHtmlCreate();
    
    } 
    
}

public function gridHtml(){
        
        if(\Request::segment(2) == 'grid' ){
            $tableName= \Request::segment(3);
            $data['route']= $tableName; 
            $data['data']= $this->get_DataDb()[$tableName];
            $this->gridHtml= $this->loadGridHtml($data);
        
        }
}

public function formHtmlCreate(){

    
    if(\Request::segment(4) == 'create'){
        $tableName= \Request::segment(3);
        $url_create= "create.insert_".$tableName;

        $form= "<form data-form=\"create\" action=\"".route($url_create)."\" method=\"post\">\n";
        $form .= "<input type=\"hidden\" name=\"_method\" value=\"PUT\">\n";
        $form .=  "<input type=\"hidden\" name=\"_token\" value=\" ".csrf_token()." \"/>"; 

        foreach ($this->createInputs as $key => $value) {
        
            $createForm= (object) $value['create'];
        
            $form .= $createForm->label;
            $form .= $createForm->input;
        
        }
            
            $form .= $this->_btnForms(['update'=>['id'=> 'create', 'name'=> 'create'],
                                'cancel'=>[ 'id'=> $tableName, 'name'=> 'cancel' ]]);
            $form .= "</form>\n";
            $this->formHtmlCreate= $form;
    }
}

public function formHtmlUpdate(){

    //update.insert_vk_titles
    if(\Request::segment(4) == 'update'){
        $tableName= \Request::segment(3);
        $idpr= \Request::segment(5);
        $url_update= "update.insert_".$tableName;

        $form= "<form data-form=\"update\"  action=\"".route($url_update, $idpr)."\" method=\"post\">\n";

        $form .= "<input type=\"hidden\" name=\"_method\" value=\"PUT\">\n";
        $form .=  "<input type=\"hidden\" name=\"_token\" value=\" ".csrf_token()." \"/>"; 
            foreach ($this->editInputs as $key => $value) {

                $updateForm= (object) $value['edit'];
                
                $form .= $updateForm->label;
                $form .= $updateForm->input;
            }
        
        $form .= $this->_btnForms(['update'=>['id'=> 'update', 'name'=> 'update'],
                                'cancel'=>[ 'id'=> $tableName, 'name'=> 'cancel' ]]);
        $form .= "</form>\n";
        $this->formHtmlUpdate= $form;
    }
}

private function _btnForms(Array $data){

    $button="";
    foreach($data as $k=> $name){
        $button .= "<button id=\"".$name['id']."\" name=\"".$name['name']."\" class=\"btn btn-primary me-md-2\" type=\"button\">".$name['name']."</button>\n";
        }

        $divGroup  = "<br><div class=\"d-grid gap-2 d-md-flex justify-content-md-end\">\n";
        $divGroup .= $button;
        $divGroup .= "</div>\n";

        return $divGroup;

}


private function _GetInputsHtml(){
   
   if(\Request::segment(2) == 'form'){

        $tableName= \Request::segment(3);

        $ConfigForms= $this->ConfigForms();
        $conf['config']= $ConfigForms[$tableName];
        $this->createInputs= $this->loadInputsHtml($conf);

        if(!empty(\Request::segment(5))){

            $data=[];
            $data['config']= $ConfigForms[$tableName];
            $data['data']= $this->DataDB[$tableName];
            $data['id']= \Request::segment(5);
            $this->editInputs= $this->loadInputsHtml($data);
        
        }

    }
}


private function pregMatchAll($regex, $type){
    preg_match_all($regex, $type, $matches);
    return $matches;
}

protected function setEnum($dataenums, $value=0){
    $regex = "/'(.*?)'/";
    $matches= $this->pregMatchAll($regex, $dataenums);
            $selectEnum="";
            $this->ArrSelectedEnum= ["0"=>'Off-line', "1"=>'On-line'];
            $this->ArrColorBgSelectedEnum= ["0"=>'color: red', "1"=>'color: green'];
            foreach ($matches[1] as $m => $selval) {
                if($value >= 1){
                    if($value === $selval){
                        $selectEnum .="<option style=\"".$this->ArrColorBgSelectedEnum[$selval]."\" selected value=\"".$selval."\">".$this->ArrSelectedEnum[$selval]."</option>\n";
                    }else{
                        $selectEnum .="<option value=\"".$selval."\">".$this->ArrSelectedEnum[$selval]."</option>\n";
                    }
                }else{
                    $selectEnum .="<option value=\"".$selval."\">".$this->ArrSelectedEnum[$selval]."</option>\n";
                }
            }
    return $selectEnum;
}

protected function loadInputsHtml(Array $data){


    if(array_key_exists('config', $data)){
        
        $DataInputs=[];
        $tableName= \Request::segment(3);

        foreach($data['config'] as $k => $rows){
                
              //dd($rows);
            $type= $rows['type'];
            $id= $rows['id'];
            $name= $rows['name'];
            $value= $rows['value'];



            $disabled="";
            if ($this->DATA_TYPE[$tableName][$k] == 'timestamp') {
               $disabled =" readonly";
            }
            
            if ($this->COLUMN_KEY[$tableName][$id] == 'PRI') {
                $disabled ="disabled=\"true\" ";
            }

            $required= "";
            if ($this->IS_NULLABLE[$tableName][$id] == 'NO')  {
                $required = "required=\"true\" ";
            }

            $MaxLength= "";
            if ($this->MaxLength[$tableName][$id] > 0)  {
                $lenght= $this->MaxLength[$tableName][$id];
                $MaxLength = "maxlength=\"$lenght\" ";
            }

            
            if ($this->DATA_TYPE[$tableName][$k] == 'enum') {
                $enums=['enum'=> '0', '1'];
                $dataenums= $this->COLUMN_TYPE[$tableName][$k];
                               

                $inputLabels= "<label for=\"$id\" class=\"col-sm-2 col-form-label\">$name</label>\n";

                $selectEnum= "<select id=\"$id\" data-id=\"$id\" name=\"$name\" class=\"form-select\" aria-label=\"select_$k\">\n";

                $selectEnum .= $this->setEnum($dataenums);
                  
                $selectEnum .="</select>\n";
                $inputCreate= $selectEnum;

            }
            else{

            $inputLabels= "<label for=\"$id\" class=\"col-sm-2 col-form-label\">$name</label>\n";
            $inputCreate= "<input class=\"form-control\" type=\"$type\" id=\"$id\" data-id=\"$id\" name=\"$name\" value=\"\" $MaxLength $disabled $required>\n";
             }

            $DataInputs[$k]['create']['label']= $inputLabels; 
            $DataInputs[$k]['create']['input']= $inputCreate;


        if(array_key_exists('data', $data)){

                $DataDB= $data['data'];
                $c= count($DataDB);

                $idUpdate=[];
                $valuedb= [];
        
                for ($i=0; $i < $c; $i++) {
                    $Db= $DataDB[$i];

                    foreach($Db as $x=> $xv){
                        if(isset($Db->$x)){
                           // dd($Db, $k);
                     

                            $idUpdate= $Db->id;
                            $valuedb= $Db->$k;
                              
                            if(!empty($data['id'])){
                                if($idUpdate == $data['id']){
                                
                                    $inputLabels= "<label for=\"$id\" class=\"col-sm-2 col-form-label\">$name</label>\n";
                                 
                                   if ($this->DATA_TYPE[$tableName][$k] == 'enum') {
                                          
                                        $col_enum= $this->ALL_COLUMN_TABLE[$tableName][$k];
                                        $dataenums= $this->COLUMN_TYPE[$tableName][$k];

                                        $selectEnum  = "<select id=\"$id\" data-id=\"$id\" name=\"$name\" class=\"form-select\" aria-label=\"select_$k\">\n";
                                        $selectEnum .= $this->setEnum($dataenums, $Db->$col_enum);
                                        $selectEnum .= "</select>\n";
                                        
                                        $inputUpdate = $selectEnum;

                                    }
                                    else{

                                    $inputUpdate= "<input class=\"form-control\" type=\"$type\" id=\"$id\" data-id=\"$id\" name=\"$name\" value=\"$valuedb\" $MaxLength $disabled $required>\n";
                                        }

                                    $DataInputs[$k]['edit']['label']= $inputLabels;
                                    $DataInputs[$k]['edit']['input']= $inputUpdate;
                                   
                                }

                            }else{
                                return "<p>required index id</p>";
                            }

                        }
                     
                    }


                }

            }

        }


        return $DataInputs;

    }

       return "<p>set function array['config'], array['data']</p>";


}



protected function loadGridHtml(Array $data){


    if(empty($data)){
        return "<p>sin datos!</p>";
    }

    $r=[];
    $hc=[];
    $hl=[];

    if(array_key_exists('route', $data) && array_key_exists('data', $data)){
  
            $tableName= $data['route'];    
            foreach($data['data'] as $k => $rows){
                foreach ($rows as $j => $row) {
                    //dd($k, $j, $row);
                    $hc['cols'][0][$j]= $j;
                    $hc['cols'][1]['actions']= "Actions";
                    $hl['rows'][$k][$j]= $rows->$j;     
                    if(array_key_exists($j, $this->COLUMN_KEY[$tableName])){
                        if($this->COLUMN_KEY[$tableName][$j] == 'PRI'){
                            $colID= $this->ALL_COLUMN_TABLE[$tableName][$j];
                            $idUpdate= $rows->$colID;  
                            $hl['rows'][$k]['rowID']= $idUpdate;
                            $hl['rows'][$k]['update']= "/admin/form/".$tableName.'/update/'.$idUpdate;
                            $hl['rows'][$k]['delete']= "/admin/".$tableName."/delete/".$idUpdate;
                        }
                    }
                }
            }

            $url_create= "/admin/form/".$tableName."/create";

            $table ="<table data-table=\"$tableName\" class=\"table table-sm table-primary table-striped table-hover caption-top\">\n";
            $table .= "<caption>List of ".$tableName." </caption>";
            $table .= "<a data-create=\"$tableName\" class=\"btn btn-primary\" href=\"".$url_create."\" role=\"button\">create</a>";
                $table .="<thead>\n<tr class=\" \" >\n";  
              
                if (isset($hc['cols'])) {
                    foreach ($hc['cols'][0] as $col) {
                        $lNo= strlen($col);
                        if(array_key_exists($col, $this->DATA_TYPE[$tableName])){
                            if($this->DATA_TYPE[$tableName][$col] !== 'text'){
                                if($this->DATA_TYPE[$tableName][$col] == 'enum'){
                                    $table .="<th data-th=\"$col\" class=\"col col-sm-$lNo\">".$col."</th>\n";
                                }else{
                                    $table .="<th data-th=\"$col\" class=\"col col-sm-$lNo\">".$col."</th>\n";
                                }
                            }
                        }
                    }
                    
                    $action= $hc['cols'][1]['actions'];
                    $table .="<th class=\"col col-sm-2\">".$action."</th>\n";         
                }

            $table .="</tr>\n</thead>\n";
            $table .="<tbody>\n";  
                if (isset($hl['rows'])) {
                    foreach ($hl['rows'] as $rows) {
                      $table .="<tr data-id=\"trRefence_".$rows['rowID']."\" class=\"trRefence\">\n";
                        foreach($hc['cols'][0] as $k=> $cols){
                            if(array_key_exists($cols, $this->DATA_TYPE[$tableName])){
                                if($this->DATA_TYPE[$tableName][$cols] !== 'text'){
                                    if($this->DATA_TYPE[$tableName][$cols] == 'enum'){
                                        $table .="<td data-id=\"".$cols."_".$rows['rowID']."\" class=\"tdRefence\" title=\"Click $cols to update Form\">\n";
                                         if (array_key_exists($cols, $this->DATA_TYPE[$tableName])) {
                                            if ($this->DATA_TYPE[$tableName][$cols] == 'enum') {
                                                $col_enum= $this->ALL_COLUMN_TABLE[$tableName][$cols];
                                                $dataenums= $this->COLUMN_TYPE[$tableName][$cols];
                                                $selecGrid= $this->setEnum($dataenums, $rows[$col_enum]);
                                                $table .="<select data-id=\"select_".$cols."_".$rows['rowID']."\" id=\"select_".$cols."_".$rows['rowID']."\" class=\"form-select form-select-sm w-50\" aria-label=\"select_$cols\">\n";
                                                $table .=$selecGrid;
                                                $table .="</select>\n";
                                                $table .="</td>\n";
                                            }
                                        }                                    

                                    }else{

                                        $table .="<td data-id=\"".$cols."_".$rows['rowID']."\" class=\"tdRefence\" title=\"Click $cols to update Form\"><a href=\"".$rows['update']."\" style=\"text-decoration:none;color:#000\">".$rows[$cols]."</a></td>\n"; 
                                    }
                                }
                            }
                        } 

                            $table .= "<td>";
                            $table .= "<div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"group-$tableName\">\n";
                            $table .= "<a data-update=\"update\" class=\"btn btn-primary\" href=\"".$rows['update']."\">Edit</a>\n";
                            $table .= "<a data-delete=\"delete\" class=\"btn btn-danger\" href=\"".$rows['delete']."\">Delete</a>\n";
                            $table .= "</div>\n";
                            $table .= "</td>\n";
                            $table .= "</tr>\n";     
                    }
                }

            $table .="</tbody>\n";
            $table .="</table>\n"; 
            
            return $table;
    }

    return "<p>SYS: required to run loadGridHtml(array['route'], array['data'])</p>";
    
}

protected function get_DataDB(){
    return $this->DataDB;
}

private function set_DataDB(Array $data){
    return $this->DataDB= $data;
}

protected function get_DataJoin(){
    return $this->getdatajoin;
}

private function set_DataJoin(Array $data){
    return  $this->getdatajoin= $data;
}

/******get data table******/
private function DataDb(){

    $result=[];
    $table= $this->TABLE_NAME;
    $DB= [];
    foreach($table as $k=> $tbs){
        $DB= DB::table($k);
        $data[$k]= $DB->get();
    }
    
    foreach($data as $t=> $rows){     
      $result[$t] = $rows->toArray();
    }

    $this->set_DataDB($result);
}

/******get data join******/

function DataJoin(Array $data){
     
}

private function _listJoined(Array $data){
    foreach ($data as $k => $rows) {
        dd($rows);
        if($rows == 'id'){
            $rId= Str::of($rows)->substrReplace('', 4)->value;
            $strSub[$rows]= $rId;

        }else{
            $tSub= Str::of($rows)->substrReplace('', 4)->value;
            $strSub[$rows]= $tSub;
        }
                
        $dt[$k] = $strSub[$rows];
        $joined[$k]['cols'] = $rows;
        $joined[$k]['tables'] = Str::singular($k);
        foreach ($dt as $j => $r) {
            $stJ= Str::of($j)->substrReplace('', 6)->value;
            $joined[$k]['id']= $r."_".$stJ;        
        }
    }
    //dd($joined);
    return $joined;   
}

private function _filterColunmKey(Array $data){
    /**filter key sql colunm**/
    $q=[];
    foreach($data as $ta=> $coltb){
        $dt[$ta]= $ta;
        $strTable= str_replace('vk_',  'sub_', $dt[$ta]);
        foreach ($coltb as $key => $value) {
            if(array_key_exists($key, $this->COLUMN_KEY[$ta])) {
                    $valCol= Str::of($ta)->substrReplace('', 6)->value;
                   // $q[$ta]['table']= Str::singular($ta);
                switch ($this->COLUMN_KEY[$ta][$key]) {
                    case 'PRI':
                        $q[$ta][$key]= $ta.".".$key." AS ".$key."_".$valCol;
                        
                        break;
                    case 'UNI':
                        $q[$ta][$key]= $ta.".".$key;
                            
                        break;
                    case 'MUL':
                        $q[$ta][$key]= $ta.".".$key;
                            
                        break;
                }  
            }
            
            $result= $q;
            
        }
    }
    
    //dd($result);
    return $result;
}

/**select items text */
private function _selectItems(Array $filter){
    $fcv=['uni', 'mul'];
    $selects=[];
    $result=[];
    foreach ($filter as $f => $rows) {    
        foreach ($fcv as $valuef) {       
            if(array_key_exists($valuef,$filter[$f])){
                foreach ($filter[$f][$valuef] as $k => $v) {
                   if(!str_starts_with($k, 'vk_')){ 
                        if(str_starts_with($k, 'id_')){
                            $dt[$f]= $f;
                            $strTable= str_replace('vk_',  'sub_', $dt[$f]);
                           // $selects[$f]['count_id'] = "COALESCE(".$f.".count_".$v.", 0) AS count_".$v;
                            $selects[$strTable][$k] = ", COALESCE(".$strTable.".count_".$v.", 0) AS count_".$v;
                            
                        }
                        if(!str_starts_with($k, 'id')){
                            $selects[$f][$k] = $f.".".$v;
                        }
                    }
                }
            }
        }
    }
    //dd($selects);
    return $selects;
}

private function QuerydataJoin(Array $data){
    
    $refeuniq=[];
    $c=count($data["refeuniq"]);
    
    $select=" ";
    $from=" FROM ";
    $selects=[];
    $query=[];
    $queryj=[];
    $queryn=[];
    for ($i=0; $i < $c; $i++) {
        
        $refeuniq= $data["refeuniq"][$i];
        $refejoin= $data["refejoin"][$i];
        $Id_reference= $data["reference"][$i];
        $Id_join= $data["join"][$i];
        
        $arf= $this->_filterColunmKey($data['allColsRefence'][$i]);
        $arj= $this->_filterColunmKey($data['allColsJoin'][$i]);
       // dd($arf, $arj, $data);
        
        foreach ($refeuniq as $k => $rows) {

            if(array_key_exists($k, $arf)){
                $select = "SELECT ". implode(', ', $arf[$k]);
                
                
            }

            if(array_key_exists($k, $arj)){            
                $select = "SELECT ".implode(', ', $arj[$k]);
                
            }
            $query[$i][$k] = $select.$from.$k;
            //$query[$i][$rows] = $select.$from.$rows;
            
            if(in_array($k, $refejoin)){
                foreach ($refejoin as $r => $jn) {
                   $queryj[$jn][$r]= " LEFT JOIN ".$r.
                   " ON ".$refejoin[$r].".".$Id_reference[$jn]."=".$r.".".$Id_join[$r];
                }
            }
        }
        foreach ($Id_join as $n => $val) {
            $queryj[$n][$refejoin[$n]]= " JOIN ".$refejoin[$n].
            " ON ".$n.".".$Id_join[$n]."=".$refejoin[$n].".".$Id_reference[$refejoin[$n]];
        }
    
        foreach ($query[$i] as $q => $row){
            if(array_key_exists($q, $queryj)){
                $result[$q]=  $row.implode('',$queryj[$q]);
                $getquery[$q]= self::getquery($result[$q]);
            }
        }
    }


         
   // dd($getquery);

}

private function schemadataDbJoin(){

    $shemaData= self::GetAllRel();
    $schemaQueryJoin= [];
    $COLUMN_TABLE= $this->ALL_COLUMN_TABLE;

    for($i=0; $i < $c= count($shemaData); $i++){
        $data= $shemaData[$i];
        
        foreach($data as $f=> $cl){
            $schemaQueryJoin['allColsRefence'][$i][$data['REFERENCED_TABLE_NAME']]=$COLUMN_TABLE[$data['REFERENCED_TABLE_NAME']];
            $schemaQueryJoin['reference'][$i][$data['REFERENCED_TABLE_NAME']]= $data['REFERENCED_COLUMN_NAME'];
            $schemaQueryJoin['refeuniq'][$i][$data['REFERENCED_TABLE_NAME']]= $data['UNIQUE_TABLE_NAME'];
            /**unique table */
            $schemaQueryJoin['allColsJoin'][$i][$data['UNIQUE_TABLE_NAME']]=$COLUMN_TABLE[$data['UNIQUE_TABLE_NAME']];
            $schemaQueryJoin['join'][$i][$data['UNIQUE_TABLE_NAME']]= $data['COLUMN_NAME'];
            $schemaQueryJoin['refejoin'][$i][$data['UNIQUE_TABLE_NAME']]= $data['REFERENCED_TABLE_NAME'];
            //$Tconsult['join'][$data['UNIQUE_TABLE_NAME']]= $data['COLUMN_NAME'];
        }
    }

        //dd($schemaQueryJoin);
       $this->QuerydataJoin($schemaQueryJoin);   
    

}//


private function _GetInformationSchema() {
    try{
            /**cargando session admin**/
            if (\Request::segment(1) == 'admin') {
                    $data=[];
                    $table= \Request::segment(3);
                if(!empty($table)){
                    $Getdata= self::Getdata($table);      
                    if(array_key_exists($table, $Getdata)) {
                        $datos= $Getdata;
                        foreach($datos as $y=> $data){
                            foreach($data as $x=> $rows){
                                foreach($rows as $i=> $row){
                                switch($i){
                                    case 'COLUMN_KEY':
                                        $this->COLUMN_KEY[$y][$rows['COLUMN_NAME']]=$data[$x][$i];
                                        if($data[$x][$i] === 'PRI'){
                                            $this->COLUMN_PRIMARY_KEY[$y][$rows['COLUMN_NAME']]= $rows['COLUMN_NAME'];
                                        }
                                    break;
                                    case 'COLUMN_NAME':
                                        $cname= $data[$x]['COLUMN_NAME'];
                                        $this->ALL_COLUMN_TABLE[$y][$cname]= $cname;
                                        $this->ALL_COLUMN_TABLE_EDIT[$y][$cname]= $data[$x];

                                    break;
                                    case 'COLUMN_TYPE':
                                        $ctype= $data[$x]['COLUMN_NAME'];
                                        $this->COLUMN_TYPE[$y][$ctype]= $data[$x][$i];
                                    break;
                                    case 'DATA_TYPE':
                                        $cname= $data[$x]['COLUMN_NAME'];
                                        $this->DATA_TYPE[$y][$cname]= $data[$x][$i];
                                    break;
                                    case 'ORDINAL_POSITION':
                                        $o_position= $data[$x]['COLUMN_NAME'];
                                        $this->ORDINAL_POSITION[$y][$o_position]= $data[$x][$i];
                                    break;
                                    case 'IS_NULLABLE':
                                        $i_null= $data[$x]['COLUMN_NAME'];
                                        $this->IS_NULLABLE[$y][$i_null]= $data[$x][$i];
                                    break;
                                    case 'COLUMN_COMMENT':
                                        $c_comment= $data[$x]['COLUMN_NAME'];
                                        $this->COLUMN_COMMENT[$y][$c_comment]= $data[$x][$i];
                                    break;
                                    case 'PRIMARY_TABLE_NAME':
                                        $this->TABLE_NAME[$data[$x][$i]]= $data[$x][$i];
                                    break;
                                    case 'CHARACTER_MAXIMUM_LENGTH':
                                        $this->MaxLength[$y][$data[$x]['COLUMN_NAME']]= $data[$x][$i];
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    catch(\Exception $e){
       self::Exception($e);
    }
}

/*switch data form */
private function ConfigForms(){
    try{
    $data=[];
    $Inputs=[];
    $data= $this->DATA_TYPE;

    if(is_array($data) && !empty($data)){
       foreach($data as $k=> $rows){
            foreach($rows as $j=> $row){      
                switch($row){
                    case 'int':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                        break;
                    case 'bigint':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];    
                        break;
                    case 'enum':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                        break;
                    case 'varchar':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                         break;
                    case 'text':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'textarea', 'name'=>$j, 'value'=>"", 'rows'=> 10, 'cols'=> 30];
                        break;
                    case 'date':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'date', 'name'=>$j, 'value'=>""];
                        break;
                    case 'datetime':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'date', 'name'=>$j, 'value'=>""];
                        break;
                    case 'timestamp':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'datetime-local', 'name'=>$j, 'value'=>""];
                        break;
                    case 'tinyint':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'checkbox', 'name'=>$j, 'value'=>""];
                        break;
                    case 'decimal':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                        break;
                    case 'double':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                        break;
                    case 'float':
                            $Inputs[$k][$j]= ['id'=> $j, 'type'=> 'text', 'name'=>$j, 'value'=>""];
                        break;
                 }
            }
        }        
       return $Inputs;
    }
    }
    catch(\Exception $e){
       self::Exception($e);
    }
}

	
}//endclass