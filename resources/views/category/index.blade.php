@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <table class="table table-striped table-inverse">
        <thead>
            <tr class="bg-primary">
                <th>Number</th>
                <th>Category</th>
                @if(Auth::user()->isAdmin())
                <th>Modify</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr scope="row">
                <td>{{$loop->index + 1 }}</td>
                <td>{{$category->name}}</td>
                @if(Auth::user()->isAdmin())
                <td><button type="button" class="btn btn-warning" onclick="showModifyCategoryModal({{$category->id}}, '{{$category->name}}')"><i class="fa fa-pencil"></i></button></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="modal" id="modify-category-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify category name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="email" class="col-md-12 control-label">New name</label>
            <div class="col-md-12">
                <input id="new-category-name" type="text" class="form-control" required autofocus>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="modifyCategory()">Modify</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection