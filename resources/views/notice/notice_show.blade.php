@extends('admin.layout.base')

@section('title', 'NOtice ')

@section('content')
<a href="notice_create"> Add Notice </a>
{{Session('msg')}}
        <br>

        <table>
            <tr>
                <td>id</td>
                <td>Heading</td>
                <td>Description</td>
                <td>Created at</td>
                <td>Action</td>
                
            </tr>
            
            @foreach($noticeArr as $notice)
            <tr>
                <td>{{$notice->id}}</td>
                <td>{{$notice->Heading}}</td>
                <td>{{$notice->Description}}</td>
                <td>{{$notice->created_at}}</td>
                <td><A href="notice_delete/{{$notice->id}}">Delete</a></td>
                <td><A href="notice_edit/{{$notice->id}}">edit</a></td>
          
            </tr>
             @endforeach
        </table>
  