@extends('layouts.app')

@section('content')
@yield('user_content')



<div class="modal" id="delete-user-modal">
  <div class="modal-dialog" role="dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Delete user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p class="modal-text">
          Do you <u>really</u> want to <span class="text-danger">delete</span> account ?
        </p>
      </div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="deleteUser()">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>
</div>

<div class="modal" id="modify-user-modal">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">

      <div class="form-group">
        <label for="new-user-fullname" class="col-md-12 control-label">Fullname</label>
            <div class="col-md-12">
                <input id="new-user-fullname" type="text" class="form-control" required autofocus>
            </div>
      </div>

      <div class="form-group">
        <label for="new-user-email" class="col-md-12 control-label">E-mail</label>
            <div class="col-md-12">
                <input id="new-user-email" type="text" class="form-control" required autofocus>
            </div>
        </div>

      <div class="form-group">
        <label for="new-user-address" class="col-md-12 control-label">Address</label>
            <div class="col-md-12">
                <input id="new-user-address" type="text" class="form-control" required autofocus>
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="modifyUser()">Modify</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
    
  </div>
</div>
@endsection