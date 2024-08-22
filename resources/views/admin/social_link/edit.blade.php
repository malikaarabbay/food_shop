@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Social Links</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Link</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-link.update', $link->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Icon</label>
                        <br>
                        <div class="btn btn-secondary" role="iconpicker" name="icon" data-icon="{{ $link->icon }}"></div>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $link->name }}">
                    </div>

                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" value="{{ $link->link }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            @foreach(Config::get('params.status') as $key => $value)
                                <option @selected($value === $link->status) value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
