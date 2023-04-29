<?php
namespace App\Library\Web;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Library\Web\PageWeb;

class WebRoutes {


	public $routes;

	function __Construct(PageWeb $pageweb){
		$this->routes=  $pageweb->WebRoutes;
		//$this->Menu=  $pageweb->Menu; 
		//dd($pageweb);
		
	}

	

	public function Routes(){
		
		\Route::middleware('web')->get('api/menu', function(PageWeb $data){
			  return response()->json($data->Menu);
		});

		\Route::middleware(['web'])->prefix('/')->group(function (){
			
			$this->RouteGroup();
		});
	}


	private function RouteGroup(){

		$r= $this->routes;

		$arrayf= array_key_first($r);
			
		foreach($r as $i=> $lr){
		
		if($arrayf == $i){
				//dd($arrayf, $i, $lr);

				//$name= Str::of($r[$i]['name'])->camel()->value;
				//dd($name, $lr['link']);
				\Route::permanentRedirect('/', $lr['link']);
				\Route::get($lr['link'], function(PageWeb $pages){
					$data['pages']= $pages->data;
					
					$json= response()->json($data);
					return View::make('layouts.appweb');
				
				})->name($lr['name']);
			}else{
				
				//$name= Str::of($lr['name'])->camel()->value;
				\Route::get($lr['link'], function(PageWeb $pages){
					$data['pages']= $pages->data;
					$json= response()->json($data);
					return View::make('layouts.appweb', compact('json'));
				})->name($lr['name']);
		}
		
		
		}

	}

}
