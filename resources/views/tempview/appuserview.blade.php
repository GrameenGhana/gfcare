@extends('layouts.app')

<!-- Main Content -->
@section('content')

   <div class="panel panel-default">
        <div class="panel-heading">
            App Users
            
        </div>

        <div class="panel-body">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Phone Number</th>
                        <th>Education</th>
                        <th>Program</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                       @foreach ($appusers as $appuser)  
                       <tr>
                           <td>{{$appuser->firstname}}  {{$appuser->lastname}} </td>
                           <td>{{$appuser->DOB}}</td>
                           <td>{{$appuser->gender}}</td>
                           <td>{{$appuser->phonenumber}}</td>
                           <td>{{$appuser->education}}</td>
                           <td>{{$appuser->program}}</td>

                       </tr>
                       @endforeach
                </tbody>
            </table>
        </div>

    </div>



@endsection