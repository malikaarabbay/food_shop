@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupons</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Create Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.coupon.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}">
                                </div>
                                <div class="form-group">
                                    <label>Min purchase amount</label>
                                    <input type="text" name="min_purchase_amount" class="form-control" value="{{ old('min_purchase_amount') }}">
                                </div>
                                <div class="form-group">
                                    <label>Expire date</label>
                                    <input type="date" name="expire_date" class="form-control" value="{{ old('expire_date') }}">
                                </div>
                                <div class="form-group">
                                    <label>Discount type</label>
                                    <select name="discount_type" class="form-control" id="">
                                        <option value="1">percent</option>
                                        <option value="0">amount ({{ config('settings.site_currency_icon') }})</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" name="discount" class="form-control" value="{{ old('discount') }}">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="">
                                        @foreach(Config::get('params.status') as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
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
