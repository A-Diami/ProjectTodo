@extends('layouts.app')

@section('content')
<div class="card">
<div class="card-header">
    creation d'une nouvelle video
</div>
<div class="card-body">
    <form action="{{ route('todos.store') }}" method="post">
    @csrf
        <div class="form-group">
            <label for="name">Titre</label>
            <input type="text" name="name" class="form-control" id="name"/>
            <small id="nameHelp" class="form-text text-muted">Entrer le titre de votre todo</small>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" id="description"/>
        </div>
            <button type="submit" class="btn btn-primary">Valider</button>
    </form>
    </div>
</div>
@endsection