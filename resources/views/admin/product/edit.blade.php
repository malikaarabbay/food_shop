@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Update Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $product->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Choose File</label>
                                        <input type="file" name="image" id="image-upload" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control select2" id="">
                                        @foreach ($categories as $category)
                                            <option @selected($product->category_id === $category->id) value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                                </div>
                                <div class="form-group">
                                    <label>Offer price</label>
                                    <input type="text" name="offer_price" class="form-control" value="{{ $product->offer_price }}">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" name="quantity" class="form-control" value="{{ $product->quantity }}">
                                </div>
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea name="short_description" class="form-control">{!! $product->short_description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control summernote">{!! $product->description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Sku</label>
                                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                                </div>
                                <div class="form-group">
                                    <label>Options</label>
                                    <select name="options[]" class="form-control select2" multiple>
                                        @foreach($options as $key=>$item)
                                            <option value="{{$item->id }}" @if($product->options->containsStrict('id', $item->id)) selected="selected" @endif>
                                                {{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Seo Title</label>
                                    <input type="text" name="seo_title" class="form-control" value="{{ $product->seo_title }}">
                                </div>
                                <div class="form-group">
                                    <label>Seo Description</label>
                                    <textarea name="seo_description" class="form-control">{!! $product->seo_description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Show at Home</label>
                                    <select name="show_at_home" class="form-control" id="">
                                        @foreach(Config::get('params.status') as $key => $value)
                                            <option @selected($value === $product->show_at_home) value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="">
                                        @foreach(Config::get('params.status') as $key => $value)
                                            <option @selected($value === $product->status) value="{{ $value }}">{{ $key }}</option>
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
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset($product->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        })
    </script>
@endpush
