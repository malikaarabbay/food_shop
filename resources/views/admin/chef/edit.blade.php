@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Chef</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.chefs.update', $chef->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload" />
                            <input type="hidden" name="old_image" value="{{ $chef->image }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $chef->name }}">
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $chef->title }}">
                    </div>

                    <br>
                    <h5>Social Links</h5>
                    <div class="form-group">
                        <label for="">Facebook <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="fb" value="{{ $chef->fb }}">
                    </div>
                    <div class="form-group">
                        <label for="">Linkedin <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="in" value="{{ $chef->in }}">
                    </div>
                    <div class="form-group">
                        <label for="">X <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="x" value="{{ $chef->x }}">
                    </div>
                    <div class="form-group">
                        <label for="">Web <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="web" value="{{ $chef->web }}">
                    </div>

                    <div class="form-group">
                        <label>Show at Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            @foreach(Config::get('params.status') as $key => $value)
                                <option @selected($value === $chef->show_at_home) value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            @foreach(Config::get('params.status') as $key => $value)
                                <option @selected($value === $chef->status) value="{{ $value }}">{{ $key }}</option>
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
                'background-image': 'url({{ asset($chef->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
