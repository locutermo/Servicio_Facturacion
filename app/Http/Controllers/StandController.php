<?php

namespace App\Http\Controllers;

use App\Stand;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StandController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return stands list
     *
     * @return Illuminate\Http\Response [description]
     */
    public function getListarStand()
    {
        $stands = Stand::all();
        return $this->successResponse($stands);
    }

    /**
     * Create an instance of stand
     *
     * @return Illuminate\Http\Response [description]
     */
    public function addStand(Request $request)
    {
        $rules=[
            'title' => 'required |max:255',
            'level' => 'digits_between:1,2|min:1|not_in:0',
            'type' => 'required|max:255|in:Tesis,Revista,Libro',
            'status'=> 'required|max:255|in:Habilitado,Deshabilitado',
        ];
        $this->validate($request, $rules);

        //$stands=Stand::all()->where('title',$request->title)
        $stands=Stand::all()->where('title',$request->title)->where('level',$request->level)
            ->where('type',$request->type)->where('status',$request->status);

        if ($stands->isEmpty()) {
            $stand=Stand::create($request->all());
        }else{
            return $this->errorResponse('Ya existe un registro', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        return $this->successResponse($stand,Response::HTTP_CREATED);
    }

    /**
     * Return an specific stand
     *
     * @return Illuminate\Http\Response [description]
     */
    public function showStand($stand)
    {
        $stand=Stand::findOrFail($stand);
        return $this->successResponse($stand);
    }

    /**
     * Update the information of an stand 
     *
     * @return Illuminate\Http\Response [description]
     */
    public function standUpdate(Request $request, $stand ) 
    {
        $rules = [
            'title' => 'required|max:255',
            'level' => 'digits_between:1,2|min:1|not_in:0',
            'type' => 'required|max:255|in:Tesis,Revista,Libro',
            'status'=> 'required|max:255|in:Habilitado,Deshabilitado',
        ];

        $this->validate($request, $rules);

        $stand = Stand::findOrFail($stand);

        $stand->fill($request->all());

        if ($stand->isClean()) {
            return $this->errorResponse('Debe cambiar al menos un valor a uno de los campos', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stands=Stand::all()->where('title',$request->title)->where('level',$request->level)
            ->where('type',$request->type)->where('status',$request->status);

        if ($stands->isEmpty()) {
            $stand->save();
        }else{
            return $this->errorResponse('Ya existe un registro ', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->successResponse($stand,Response::HTTP_CREATED);
    }

    /**
     * Remove an exiting stand
     *
     * @return Illuminate\Http\Response [description]
     */
    public function standDelete($stand) 
    {
        $stand = Stand::findOrFail($stand);

        $stand->delete();

        return $this->successResponse($stand);
    }
}

