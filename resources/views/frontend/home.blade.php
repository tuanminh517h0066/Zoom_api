@extends('layouts.frontend')

@section('page_title', 'ホーム')

@section('content')
<div class="row column-main">
  <div id="content-page" class="main-page home-page">
        <p>Home page</p>       
        <a href="{{ route('get.create') }}"> create zoom view</a>
        @if($meetings)
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Join_URL</th>
              <th scope="col">Button</th>
            </tr>
          </thead>
          <tbody>
            @foreach($meetings as $meeting_item)
            <tr>
           
              <th scope="row">{{ $meeting_item->id }}</th>
              <td>{{ $meeting_item->join_url }}</td>
              <td>
                
                <a href="{{ route('join.meeting',$meeting_item->id) }}" target="_blank">Join</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        @else
        <p> dont have any  data</p>
        @endif
  </div>
</div>
@stop
