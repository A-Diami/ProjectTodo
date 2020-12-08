<?php

namespace App\Http\Controllers;

use App\Notifications\TodoAffected;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodosController extends Controller
{
    // recupere les users
    public $users;

    public function __construct()
    {
        $this->users = User::getAllUsers();
    }

    /**
     * assigner une liste a un user
     *
     * @param  Todo  $todo
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function affectedTo(Todo $todo, User $user)
    {
        $todo->affectedTo_id = $user->id;
        $todo->affectedBy_id = Auth::user()->id; // est affectee a la personne ki est connectee
       // dd($todo->affectedBy_id);
        $todo->update();
        $user->notify(new TodoAffected($todo));
        return back();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // afficher les todos recents
        $datas = Todo::paginate(10);
       // $userId = Auth::user()->id;
        //$datas = Todo::where(['affectedTo_id' => $userId])->orderBy('id','desc')->paginate(10);
        // recupere toutes la liste de todos
        //$datas = Todo::all()->reject(function($todo){
           // return $todo->done == 0;
        //});
        //dd($data);
        $users = $this->users;
        return view('todos.index',compact('datas','users'));

    }
  /**
     * return les todos qui sont terminees
     */
    public function done()
    {
        // recupere moi les todos ou le champs done est egale a 1
        $datas = Todo::where('done',1)->paginate(10);

        $users = $this->users;
        return view('todos.index',compact('datas','users'));
    }

     /**
     * return les todos qui ne sont pas terminees.

     */
    public function undone()
    {
        // recupere moi les todos ou le champs undone est egale a 0
        $datas = Todo::where('done',0)->paginate(10);

        $users = $this->users;
        return view('todos.index',compact('datas','users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->creator_id = Auth::user()->id;
        $todo->affectedTo_id = Auth::user()->id;
        $todo->name = $request->name;
        $todo->description = $request->description;
        notify()->success("la todo <span class='badge badge-dark'>#$todo->id</span> vient d'etre creee");
        $todo->save();

        return redirect()->route('todos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit',compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if (!isset($request->done))
        {
            $request['done'] = 0;
        }
        //dd($request);
        $todo->update($request->all());
        notify()->success("la todo <span class='badge badge-dark'>#$todo->id</span> vient d'etre mise a jour");

        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        notify()->warning("la todo <span class='badge badge-dark'>#$todo->id</span> vient d'etre supprime");

        return back();
    }

      /**
     * permet de changer le status de la todo en done.
     *
     * @param  Todo $todo
     * @return void
     */

    public function makedone(Todo $todo)
    {
        $todo->done = 1;
        $todo->update();
        return back();

    }

        /**
     * permet de changer le status de la todo en undone.
     *
     * @param  Todo $todo
     * @return void
     */

    public function makeundone(Todo $todo)
    {
        $todo->done = 0;
        $todo->update();
        notify()->success("la todo <span class='badge badge-dark'>#$todo->id</span> est a nouveau ouverte");

        return back();

    }


}
