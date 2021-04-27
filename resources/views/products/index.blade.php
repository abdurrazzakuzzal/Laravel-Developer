@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>

    @if(Session::has('success'))
    <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif

    <div class="card">
        <form method="get" action="{{ route('filter.product') }}" enctype="multipart/form-data" class="card-header">
            @csrf
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        @foreach ($groups as $i => $group)
                            <option value="" class="bg-secondary text-white">{{ $group->description }}</option>
                            @foreach ($variants as $variant)
                                @if ($variant->description == $group->description)
                                <option>{{ $variant->title }}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From"
                            class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" value="YYYY-MM-DD" placeholder="YYYY-MM-DD" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Variant</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->products->id }}</td>
                                <td>{{ $product->products->title }} <br> Created at :
                                    {{ $product->products->created_at }}</td>
                                <td>{{ $product->products->description }}</td>
                                <td>
                                    <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                        <dt class="col-sm-3 pb-0">
                                            @if (!empty($product->productvariantsone[0]))
                                                {{ $product->productvariantsone[0]->variant }}
                                            @endif
                                            @if (!empty($product->productvariantstwo[0]))
                                                / {{ $product->productvariantstwo[0]->variant }}
                                            @endif
                                            @if (!empty($product->productvariantsthree[0]))
                                                /{{ $product->productvariantsthree[0]->variant}}
                                            @endif

                                        </dt>
                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4 pb-0">Price : {{ number_format($product->price, 2) }}
                                                </dt>
                                                <dd class="col-sm-8 pb-0">InStock :
                                                    {{ number_format($product->stock) }}</dd>
                                            </dl>
                                        </dd>
                                    </dl>
                                    <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show
                                        more</button>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('product.edit', $product->products->id) }}"
                                            class="btn btn-success">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    showing {{ $products->currentPage() }} out of {{ $products->lastPage() }}
                </div>
                <div class="col-md-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
