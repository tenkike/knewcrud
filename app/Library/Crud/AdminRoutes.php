<?php
namespace App\Library\Crud;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Library\Crud\DataSchema;
use App\Library\Crud\DataTables;

class AdminRoutes extends DataSchema {

	public function __Construct()
	{
			parent::__construct();
			
	}

	public static function init_routes(){
	\Route::middleware(['web', 'auth'])->prefix('admin')->group(function(){
			self::_routes();
		});

		\Route::middleware(['api'])->prefix('api/admin')->group(function(){
			self::_routesApi();
		});
	}

   

	private static function _routes(){
		
		$data= self::_setRoutes();
		if(!empty($data)){
		foreach($data as $k=> $rows){
			//$uris[]= 'R'.$k;
			//	dd($k, $rows);
			$uris[$k]['grid']= '/grid/'.$k;
			//$uris[$k]['form']= '/form/'.$k;

			$uris[$k]['create']= '/form/'.$k.'/create';
			$uris[$k]['update']= '/form/'.$k.'/update/{id}';
			$uris[$k]['delete']= $k.'/delete/{id}';

			foreach($uris as $j=> $list){
				
				/** routes grid**/
			  	\Route::get($list['grid'],  function(DataTables $data){
			  		if (View::exists('admin.grid')) {
						$grid= $data->gridHtml; 
					    return View::make('admin.grid', compact('grid'));
					}

			  	})->name('grid_'.$j);


				/** routes create**/
			  	\Route::get($list['create'],  function(DataTables $data){

			  		if (View::exists('admin.form')) {
						$form= $data->formHtmlCreate; 
					    return View::make('admin.form', compact('form'));
					}

			  	})->name('create_'.$j);
			  	
			  	/** routes edit**/

			  	\Route::get($list['update'],  function (DataTables $data){

			  		if (View::exists('admin.form')) {
						$form= $data->formHtmlUpdate; 
					    return View::make('admin.form', compact('form'));
					}

			  	})->name('update_'.$j);

			  	/** routes delete**/

				\Route::delete($list['delete'], function (Request $request){

					return $request;
					
				})->name('delete_'.$j);
			}
			
		}

	}
	}
 
	private static function _routesApi(){
		
		$data= self::_setRoutes();
			if(!empty($data)){
		foreach($data as $k=> $rows){

			$uris[$k]['create']= '/form/'.$k.'/create';		
			$uris[$k]['update']= '/form/'.$k.'/update/{id}';
			$uris[$k]['delete']= $k.'/delete/{id}';

			foreach($uris as $j=> $list){
			
					/** routes create**/	  	
			  	\Route::post($list['create'], function (Request $request){

			  		dd($request);

			  	})->name('create.insert_'.$j);

			  	/** routes edit**/
			  	\Route::post($list['update'],  function (Request $request){

			  		//	dd($request);
			  	
			  	})->name('update.insert_'.$j);

			  	/** routes delete**/

				/*\Route::delete($list['delete'], function (Request $request){

					return $request;
					
				})->name('delete_'.$j);*/

			

			}
			
		}
	}

	}

	private static function _setRoutes(){

			//\Config::set('appweb.admin.active', true);
			
		$data=[];

		if(\Config::get('appweb.admin.active')){
			$data= \Config::get('appweb.admin.routes');
		}
		else{
			$data= self::InformationTables();
		}

		//dd($data);

		return $data;
		
	}


}