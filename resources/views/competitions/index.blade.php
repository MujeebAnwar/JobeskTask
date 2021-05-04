@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('msg'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{session()->get('msg')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">

            <div class="card-header">
                Competitions
            </div>
            <div class="card-body">

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Competition Name</th>
                                <th>Videos</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($competitons as $competition)
                                <tr>
                                    <td>Competition {{$competition->id}}</td>
                                    <td>
                                        <a href="{{route('competitionVideos',$competition->id)}}" class="btn btn-primary">Videos</a>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>

    </div>
@endsection