@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Feedbacks</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Feedback</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.feedbacks.update', $feedback->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload" />
                            <input type="hidden" name="old_image" value="{{ $feedback->image }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $feedback->name }}">
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $feedback->title }}">
                    </div>

                    <div class="form-group">
                        <label for="">Review</label>
                        <textarea type="text" class="form-control" name="review">{{ $feedback->review }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Rating</label>
                        <select name="rating" class="form-control" id="">
                            <option @selected($feedback->rating === 1) value="1">1</option>
                            <option @selected($feedback->rating === 2) value="2">2</option>
                            <option @selected($feedback->rating === 3) value="3">3</option>
                            <option @selected($feedback->rating === 4) value="4">4</option>
                            <option @selected($feedback->rating === 5) value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Show at Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            @foreach(Config::get('params.status') as $key => $value)
                                <option @selected($value === $feedback->show_at_home) value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            @foreach(Config::get('params.status') as $key => $value)
                                <option @selected($value === $feedback->status) value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset($feedback->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
