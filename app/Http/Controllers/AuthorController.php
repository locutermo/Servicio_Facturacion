<?php

namespace App\Http\Controllers;
use App\Imports\AuthorsImport;
use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
class AuthorController extends Controller
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
     * Return authors list
     *
     * @return Illuminate\Http\Response [description]
     */
    public function getListarAuthor()
    {
        $authors = Author::all();
        return $this->successResponse($authors);
    }

    public function importData(Request $request){
        $rules=[
            'authors_file' => 'required|mimes:xls,csv,xlsx'                
        ];   
        $this->validate($request, $rules);        

        $data = collect([]);

        $authors = (new AuthorsImport)->toCollection($request->file('authors_file'));
        foreach($authors[0] as $author){
            if($author['name']!=null && $author['categories']!=null){
                $_author = Author::where('name',$author['name']);
                $not_exists = $_author->get()->isEmpty();
                $_author = $_author->updateOrCreate( 
                    ['name'=>$author['name']],
                    ['name'=> $author['name'],'categories'=> $author['categories']]
                );
                if($_author->wasChanged()){
                    $_author->status='Actualizado';
                    $data->push($_author);
                }else if($not_exists){
                    $_author->status='Registrado';
                    $data->push($_author);
                }else{
                    $_author->status='No se hizo nada';
                    $data->push($_author);
                }
            }
            
        }

        return $this->successResponse($data);
    }

    /**
     * Create an instance of author
     *
     * @return Illuminate\Http\Response [description]
     */
    public function addAuthor(Request $request)
    {
        $rules=[
            'name' => 'required|max:255',
            'categories' => 'required|max:255',
        ];
        $this->validate($request, $rules);

        $authors=Author::all()->where('name',$request->name)->where('categories',$request->categories);
        if ($authors->isEmpty()) {
            $author=Author::create($request->all());
        }else{
            return $this->errorResponse('Ya existe un registro', Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        
        return $this->successResponse($author,Response::HTTP_CREATED);
    }

    /**
     * Return an specific author
     *
     * @return Illuminate\Http\Response [description]
     */
    public function showAuthor($author)
    {
        $author=Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     * Update the information of an author 
     *
     * @return Illuminate\Http\Response [description]
     */
    public function authorUpdate(Request $request, $author ) 
    {
        $rules = [
            'name' => 'required|max:255',
            'categories' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('Debe cambiar al menos un valor', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $authors=Author::all()->where('name',$request->name)->where('categories',$request->categories);
        if ($authors->isEmpty()) {
            $author->save();
        }else{
            return $this->errorResponse('Ya existe un registro con el mismo nombre y categoria', Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        return $this->successResponse($author,Response::HTTP_CREATED);
    }

    /**
     * Remove an exiting author
     *
     * @return Illuminate\Http\Response [description]
     */
    public function authorDelete($author) 
    {
        $author = Author::findOrFail($author);

        $author->delete();

        return $this->successResponse($author);
    }
}

