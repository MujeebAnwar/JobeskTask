@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    @foreach($competitionVideos->userVideos as $video)
                        <div class="col-md-4">
                            <div class="card mb-3" style="max-width: 18rem;">
                                <div class="card-header bg-transparent ">{{$video->name}}</div>
                                <div class="card-body ">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{$video->video_path}}" allowfullscreen></iframe>

                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    User Name :  {{$video->user->name}} <br>
                                    @if($competitionVideos->status)
                                   {{$competitionVideos->video_id == $video->id ? 'Winner' :''}}
                                    @else
                                        Rating :
                                        <select name="rating"  id="" class="form-control rating"  data-video="{{$video->id}}">
                                            <option value="">Select Rating</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.rating').on('change',function () {
            if ($(this).val())
            {
                var data =
                    {

                        'video_id' : $(this).data('video'),
                        'rating' :$(this).val(),
                        '_token' : "{{csrf_token()}}"
                    }

                $.ajax ({
                    type: "POST",
                    url: "{{route('competitionVideosRating')}}",
                    data: data,
                    dataType: "JSON",
                    success: function(result) {
                        console.log(result)
                    }
                });


            }
        })

    })
</script>
@endsection