@extends('backend.layouts.master')

@section('content')
<table class="table">
    
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">User</th>
            <th scope="col">Type</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($Subscriptions as $Subscription)
        <tr>
                <th scope="row">{{$Subscription->id}}</th>
                <td>{{$Subscription->user}}</td>
                @if($Subscription->type == 1)
                <td>পুরুষ</td>
                @elseif($Subscription->type == 2)
                <td>নারী</td>
                @elseif($Subscription->type == 3)
                <td>অন্যান্য</td>
                @endif
              </tr>
        @endforeach
        
        </tbody>
      </table>
@endsection