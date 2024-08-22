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
                            <h4>Update Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $coupon->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ $coupon->code }}">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" class="form-control" value="{{ $coupon->quantity }}">
                                </div>
                                <div class="form-group">
                                    <label>Min purchase amount</label>
                                    <input type="text" name="min_purchase_amount" class="form-control" value="{{ $coupon->min_purchase_amount }}">
                                </div>
                                <div class="form-group">
                                    <label>Expire date</label>
                                    <input type="date" name="expire_date" class="form-control" value="{{ $coupon->expire_date }}">
                                </div>
                                <div class="form-group">
                                    <label>Discount type</label>
                                    <select name="discount_type" class="form-control" id="">
                                        <option @selected($coupon->discount_type === 1) value="1">percent</option>
                                        <option @selected($coupon->discount_type === 0) value="0">amount ({{ config('settings.site_currency_icon') }})</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" name="discount" class="form-control" value="{{ $coupon->discount }}">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="">
                                        @foreach(Config::get('params.status') as $key => $value)
                                            <option @selected($value === $coupon->status) value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
