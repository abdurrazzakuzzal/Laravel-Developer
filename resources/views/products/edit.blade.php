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
                                    <input type="text" name="product_name" placeholder="Product Name" class="form-control"
                                        value="{{ $product->products->title }}">
                                    <input type="hidden" name="id" class="form-control"
                                        value="{{ $product->products->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Product SKU</label>
                                    <input type="text" name="product_sku" placeholder="Product SKU" class="form-control"
                                        value="{{ $product->products->sku }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="" cols="30" rows="4"
                                        class="form-control">{{ $product->products->description }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                                <br />
                                <div class="form-group">
                                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                                </div>
                                <br />
                                @if(isset($image) && !empty($image))
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>Original Image:</strong>
                                        <br/>
                                        <img src="/images/{{$image->file_path}}" height="150" width="300"/>
                                    </div>
                                </div>
                                    @endif
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="variant">Option one</label>
                                            <select name="variantid" class="form-control">
                                                @if (!empty($product->productvariantsone[0]))
                                                    <option selected value="{{ (int)$product->productvariantsone[0]->variant_id }}">
                                                        {{ $product->productvariantsone[0]->variant }}</option>
                                                @else
                                                    <option selected value="">{{ 'Select variant' }}</option>
                                                @endif

                                                @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Option two</label>
                                            <select name="variantid2" id="" class="form-control">

                                                @if (!empty($product->productvariantstwo[0]))
                                                    <option selected value="{{ $product->productvariantstwo[0]->variant_id }}">
                                                        {{ $product->productvariantstwo[0]->variant }}</option>
                                                @else
                                                    <option selected value="">{{ 'Select variant' }}</option>
                                                @endif
                                                @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Option three</label>
                                            <select name="variantid3" id="" class="form-control">

                                                @if (!empty($product->productvariantsthree[0]))
                                                    <option selected value="{{ $product->productvariantsthree[0]->variant_id }}">
                                                        {{ $product->productvariantsthree[0]->variant }}</option>
                                                @else
                                                    <option selected value="">{{ 'Select variant' }}</option>
                                                @endif

                                                @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header text-uppercase">Preview</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Price</td>
                                                <td>Stock</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="price"
                                                        value="{{ $product->price }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="stock"
                                                        value="{{ $product->stock }}">
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
