<?php

use Illuminate\Support\Facades\Auth;

?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs">
                <a href="{{ route('todos.create') }}" name="" id="" class="btn btn-primary m-2" role="button">Ajouter
                    une todo</a>
            </div>
            <div class="col-xs">
                @if(Route::currentRouteName() == 'todos.index')
                    <a href="{{ route('todos.undone') }}" name="" id="" class="btn btn-warning m-2" role="button">Voir
                        les todos ouvertes</a>
            </div>
            <div class="col-xs">
                <a href="{{ route('todos.done') }}" name="" id="" class="btn btn-success m-2" role="button">Voir les
                    todos terminees</a>
                @elseif(Route::currentRouteName() == 'todos.done')
                    <a href="{{ route('todos.index') }}" name="" id="" class="btn btn-dark m-2" role="button">Voir
                        toutes les todos</a>
            </div>
            <div class="col-xs">
                <a href="{{ route('todos.undone') }}" name="" id="" class="btn btn-warning m-2" role="button">Voir les
                    todos ouvertes</a>
                @elseif(Route::currentRouteName() == 'todos.undone')
                    <a href="{{ route('todos.index') }}" name="" id="" class="btn btn-dark m-2" role="button">Voir
                        toutes les todos</a>
            </div>
            <div class="col-xs">
                <a href="{{ route('todos.done') }}" name="" id="" class="btn btn-success m-2" role="button">Voir les
                    todos terminees</a>
                @endif
            </div>
        </div>
    </div>
    @foreach($datas as $data)
        <div class="alert alert-{{ $data->done ? 'success' : 'warning' }}" role="alert">
            <div class="row">
                <div class="col-sm">
                    <p class="my-0">
                        <strong>
                        <span class="badge badge-dark">
                            #{{ $data->id }}
                        </span>
                        </strong>
                        <small>
                            creee {{ $data->created_at->from() }}
                            @if($data->todoAffectedTo && $data->todoAffectedTo->id == \Illuminate\Support\Facades\Auth::user()->id)
                                affectee moi
                            @elseif($data->todoAffectedTo)
                                {{$data->todoAffectedTo ? ', affecte a '.$data->todoAffectedTo->name:''}}
                            @endif
                            @if($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id == \Illuminate\Support\Facades\Auth::user()->id)
                                par moi meme
                            @elseif($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id != \Illuminate\Support\Facades\Auth::user()->id)
                                par  {{ $data->todoAffectedBy->name }}
                            @endif
                        </small>
                    </p>
                    <details>
                        <summary>
                            <strong>{{ $data->name }}
                                @if ($data->done)
                                    <p>
                                        Terminee
                                        {{ $data->updated_at->from() }} -- Terminee en
                                        {{ $data->updated_at->diffForHumans($data->created_at,1) }}
                                    </p>
                                    <span class="badge badge-success">Done </span>
                                @endif
                            </strong>
                        </summary>
                        <p>{{ $data->description }}</p>
                    </details>

                </div>
                <div class="col-sm form-inline justify-content-end my-1">
                    {{-- button affecter --}}
                    <div class="dropdown">
                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"
                                aria-haspopup="true" class="btn btn-secondary dropdown-toggle">Affecter a
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($users as $user)
                                <a class="dropdown-item"
                                   href="/todos/{{ $data->id }}/affectedTo/{{ $user->id }}"> {{ $user->name }} </a>
                            @endforeach
                        </div>
                    </div>
                    {{-- button done/undone --}}
                    @if($data->done == 0)
                        <form action="{{ route('todos.makedone',$data->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <button type="submit" class="btn btn-success mx-1" style="min-width:90px">Done</button>
                        </form>
                    @else
                        <form action="{{ route('todos.makeundone',$data->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <button type="submit" class="btn btn-warning mx-1" style="min-width:90px">Undone</button>
                        </form>
                    @endif
                    {{--button editer --}}
                    {{--@can('edit',$data) --}}
                    <a name="" id="" class="btn btn-info mx-1" href="{{ route('todos.edit',$data->id) }}" role="button">Editer</a>
                    {{--@elsecannot('edit', $data) --}}
                <!--  <a name="" id="" class="btn btn-info mx-1 disabled" href="{{ route('todos.edit',$data->id) }}" role="button">Editer</a> -->
                    {{-- @endcan --}}
                    {{-- button delete --}}
                    <form action="{{ route('todos.destroy',$data->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger mx-1">EFFACER</button>
                    </form>

                </div>
            </div>

        </div>
    @endforeach
    {{ $datas->links() }}
@endsection
