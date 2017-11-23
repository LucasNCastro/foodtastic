@extends('layouts.user_layout')

@section('user_content')
<div class="container mt-4">
    
    <table class="table table-striped table-inverse">
        <thead>
            <tr class="bg-primary">
                <th>User</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr scope="row">
                <td>
                    <div class="card bg-secondary mb-3">
                            <div class="card-header">
                                <h4><span class="badge badge-pill badge-primary">{{$loop->index + 1}}</span>&nbsp;&nbsp;{{$user->username}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">Fullname</div>
                                    <div class="col" id="fullname-{{$user->id}}">{{$user->fullname}}</div>
                                </div>

                                <div class="row">
                                    <div class="col">Email</div>
                                    <div class="col"  id="email-{{$user->id}}">{{$user->email}}</div>
                                </div>

                                <div class="row">
                                    <div class="col">Address</div>
                                    <div class="col"  id="address-{{$user->id}}">{{$user->address}}</div>
                                </div>

                                <div class="row">
                                    <div class="col">Role</div>
                                    <div class="col">{{$user->role->name}}</div>
                                </div>

                                <div class="row">
                                    <div class="col">Created at</div>
                                    <div class="col">{{$user->created_at}}</div>
                                </div>

                                <div class="row">
                                    <div class="col">Updated at</div>
                                    <div class="col">{{$user->updated_at}}</div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col">
                                        <button type="button" class="btn btn-warning" onclick="showModifyUserModal({{$user->id}})">Modify</button>
                                        @if($user->blocked == 0)
                                            <button type="button" class="btn btn-danger" onclick="blockUser({{$user->id}})">Block</button>
                                            @if($user->role->name != 'admin')
                                                <button type="button" class="btn btn-green" onclick="makeAdmin({{$user->id}})">Make admin</button>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-primary" onclick="unblockUser({{$user->id}})">Unblock</button>
                                        @endif
                                        @if($user->role->name == 'admin')
                                            <button type="button" class="btn btn-dark" onclick="removeAdmin({{$user->id}})">Remove admin</button>
                                        @endif

                                        @if(($user->role->name == 'admin' && $user->id == Auth::user()->id) || $user->role->name != 'admin')
                                            <button type="button" class="btn btn-danger" onclick="showDeleteUserModal({{$user->id}})">Remove</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection