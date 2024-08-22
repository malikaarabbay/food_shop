@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Options | {{ $option->title }}</h1>
        </div>
        <div>
            <a class="btn btn-primary my-3" href="{{ route('admin.option.index') }}">Go back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>All Options</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-md-8 col-lg-8">
                                <form action="{{ route('admin.option-set.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="option_id" value="{{ $option_id }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thread>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thread>
                        <tbody>
                            @foreach($optionSets as $option)
                            <tr>
                                <td>{{ $option->title }}</td>
                                <td>{{ $option->price }}</td>
                                <td>
                                    <a href="{{ route('admin.option-set.destroy', $option->id) }}" class='btn btn-danger delete-item mx-2'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($optionSets) === 0)
                                <tr>
                                    <td colspan="3" class="text-center">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
