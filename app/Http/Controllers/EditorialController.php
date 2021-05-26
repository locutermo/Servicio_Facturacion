<?php

namespace App\Http\Controllers;

use App\Editorial;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class EditorialController extends Controller
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
     * Return editorials list
     *
     * @return Illuminate\Http\Response [description]
     */
    public function getListarEditorial()
    {
        $editorials = Editorial::all();
       
        return $this->successResponse($editorials);
    }

    /**
     * Create an instance of editorial
     *
     * @return Illuminate\Http\Response [description]
     */
    public function addEditorial(Request $request)
    {
        $rules=[
            'name' => 'required|max:255',
            'category' => 'required|max:255|in:Informe,Tesis,Revista,Libro',
        ];
        $this->validate($request, $rules);
        
        $editorials=Editorial::all()->where('name',$request->name)->where('category',$request->category);

        if ($editorials->isEmpty()) {
            $editorial=Editorial::create($request->all());
        }else{
            return $this->errorResponse('Ya existe un registro', Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        
        return $this->successResponse($editorial,Response::HTTP_CREATED);
    }

    /**
     * Return an specific editorial
     *
     * @return Illuminate\Http\Response [description]
     */
    public function showEditorial($editorial)
    {
        $editorial=Editorial::findOrFail($editorial);
        return $this->successResponse($editorial);
    }

    /**
     * Update the information of an editorial 
     *
     * @return Illuminate\Http\Response [description]
     */
    public function editorialUpdate(Request $request, $editorial ) 
    {
        $rules = [
            'name' => 'required|max:255',
            'category' => 'required|max:255|in:Informe,Tesis,Revista,Libro',
        ];

        $this->validate($request, $rules);

        $editorial = Editorial::findOrFail($editorial);

        $editorial->fill($request->all());

        if ($editorial->isClean()) {
            return $this->errorResponse('Debe cambiar al menos un valor', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $editorials=Editorial::all()->where('name',$request->name)->where('category',$request->category);
        if ($editorials->isEmpty()) {
            $editorial->save();
        }else{
            return $this->errorResponse('Ya existe un registro con el mismo nombre y categoria', Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        return $this->successResponse($editorial,Response::HTTP_CREATED);
    }

    /**
     * Remove an exiting editor
     *
     * @return Illuminate\Http\Response [description]
     */
    public function editorialDelete($editorial) 
    {
        $editorial = Editorial::findOrFail($editorial);

        $editorial->delete();

        return $this->successResponse($editorial);
    }
}

