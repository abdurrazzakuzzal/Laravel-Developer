@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
    </div>
    <div id="app">
        <section>
            <form method="POST" action="{{ route('edit.product') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="product_name" placeholder="Product Name" class="form-control" value="{{ $product->title }}">
                                    <input type="hidden" name="id" class="form-control" value="{{ $product->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Product SKU</label>
                                    <input type="text" name="product_sku" placeholder="Product SKU" class="form-control" value="{{ $product->sku }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="" cols="30" rows="4" class="form-control">{{ $product->description }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Variants</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Option</label>
                                            <select class="form-control" name="variant">
                                                @foreach($variants as $variant)
                                                <option value="{{ $variant->title }}">
                                                    {{ $variant->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="float-right text-primary" style="cursor: pointer;">Remove</label>
                                            <label>.</label>
                                            <input-tag class="form-control">{{ $variant->title }}</input-tag>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">Add another option</button>
                            </div>

                            <div class="card-header text-uppercase">Preview</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Variant</td>
                                                <td>Price</td>
                                                <td>Stock</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $product->variant}}
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" name="price" value="{{ $product->price}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="stock" value="{{ $product->stock}}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Save</button>
                <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
            </form>
        </section>
    </div>
@endsection
