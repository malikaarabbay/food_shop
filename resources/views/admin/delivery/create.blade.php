@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Areas</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Create Delivery area</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.delivery.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Area Name</label>
                                    <input type="text" name="area_name" class="form-control" value="{{ old('area_name') }}">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Min delivery time</label>
                                            <input type="text" name="min_delivery_time" class="form-control" value="{{ old('min_delivery_time') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Delivery fee</label>
                                            <input type="text" name="delivery_fee" class="form-control" value="{{ old('delivery_fee') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Max delivery time</label>
                                            <input type="text" name="max_delivery_time" class="form-control" value="{{ old('max_delivery_time') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control" id="">
                                                @foreach(Config::get('params.status') as $key => $value)
                                                    <option value="{{ $value }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
