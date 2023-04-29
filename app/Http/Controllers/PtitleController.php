<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePtitleRequest;
use App\Http\Requests\UpdatePtitleRequest;
use Illuminate\Support\Str;

use App\Models\Vktitle;
use App\Library\PageWeb;

use App\Library\Web\WebRoutes;


class PtitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __Construct(){

    }
    
    public function index() {     
    	
        return View::make('layouts.appweb');
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $title= "hola mundooo";
        return View('layouts.pages.menu')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePtitleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePtitleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ptitle  $ptitle
     * @return \Illuminate\Http\Response
     */
    public function show(Ptitle $ptitle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ptitle  $ptitle
     * @return \Illuminate\Http\Response
     */
    public function edit(Ptitle $ptitle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePtitleRequest  $request
     * @param  \App\Models\Ptitle  $ptitle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePtitleRequest $request, Ptitle $ptitle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ptitle  $ptitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ptitle $ptitle)
    {
        //
    }
}
