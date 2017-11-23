@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <table class="table table-striped table-inverse">
        <thead>
            <tr class="bg-primary">
                <th>Number</th>
                <th>City</th>
                @if(Auth::user()->isAdmin())
                <th>Modify</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
            <tr scope="row">
                <td>{{$loop->index + 1 }}</td>
                <td>{{$city->name}}</td>
                @if(Auth::user()->isAdmin())
                <td><button type="button" class="btn btn-warning" onclick="showModifyCityModal({{$city->id}}, '{{$city->name}}')"><i class="fa fa-pencil"></i></button></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="modal" id="modify-city-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify city name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="email" class="col-md-12 control-label">New name</label>
            <div class="col-md-12">
                <input id="new-city-name" type="text" class="form-control" required autofocus>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="modifyCity()">Modify</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection