@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Privacy Policy</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Privacy Policy</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.privacy-policy.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Text</label>
                        <textarea name="description" class="summernote" class="form-control">{!! @$privacyPolicy->description !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
