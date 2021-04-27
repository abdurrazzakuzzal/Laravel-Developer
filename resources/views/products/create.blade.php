@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
    </div>
    @if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    <div id="app">
        <section>
            <form method="POST" action="{{ route('create.product') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="product_name" placeholder="Product Name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Product SKU</label>
                                    <input type="text" name="product_sku" placeholder="Product SKU" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                                <div class="form-group">
                                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" required>
                                </div>
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
                                            <label for="variant">Variant one</label>
                                            <select name="variantid" id="" class="form-control">
                                                <option value="">Select variant</option>
                                                @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Variant two</label>
                                            <select name="variantid2" id="" class="form-control">
                                                <option value="">Select variant</option>
                                                @foreach ($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Variant three</label>
                                            <select name="variantid3" id="" class="form-control">
                                                <option value="">Select variant</option>
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
                                                        <input type="text" class="form-control" name="price" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="stock" required>
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


@section('page-script')
<script type="text/javascript">
	$('#mySelect2').select2('destroy');
</script>
@stop
