@extends('secondmaster')
@section('title', 'Add Items')
@section('content')
@include('items.modal')
<div id="pricesection">

<div id="myTabContent" class="tab-content">
	{{-- <div class="tab-pane fade" id="pricelist">
		@foreach ($errors->all() as $error)
		<p class="alert alert-danger">{{ $error }}</p>
		<p>ussy</p>
		@endforeach
		<form method="post" action="/additem">
			@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
			@endif
			{!! csrf_field() !!}
			<center>
			<div class="card text-white bg-success mb-3" style="max-width: 40rem; margin-top: 2rem;">
				<div class="card-header">Add Item</div>
				<div class="card-body">
					<fieldset>
						<h4>Item Name:</h4><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
						<strong>{{ $errors->first('name') }}</strong>
						<button type="submit" class="btn btn-primary">Submit</button>
					</fieldset>
				</div>
			</div>
			</center>
		</form>
	</div> --}}
	<div class="tab-pane fade" id="additems">
{{-- 		<div class="row">
			<div class="col-md-12">
			<form method="post">
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif
				{!! csrf_field() !!}
				
				<div class="card text-white bg-success mb-3">
					<div class="card-header">Add Item</div>
					<div class="card-body">
						
							
						<fieldset>
						<div class="form-group">
							<div class="col-md-5">
							<h4>Item Name:</h4><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<h4>Price</h4>
							<label>Description:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<label>Quantity:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<label>Per piece:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<strong>{{ $errors->first('name') }}</strong>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
						</div>
						<div class="form-group">
							<div class="col-md-5">
								<div class="dropdown mt-2">
									<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Select Category
									</button>
									<div class="dropdown-menu bg-primary" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item text-primary" href="#">Action</a>
										<a class="dropdown-item text-primary" href="#">Another action</a>
										<a class="dropdown-item text-primary" href="#">Something else here</a>
									</div>
								</div>

						</div>
						</div>
						</fieldset>
					</div>
				</div>

			</form>
			</div>
		</div> --}}

                                <h3 class="register-heading">Add Items</h3>
                                <form method="post" onsubmit="event.preventDefault();">
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Item Name" id="item_name" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Description" id="description" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Quantity" id="quantity"value="">
                                        </div>

                                    </div>
                                    <div class="col-md-6 category-row">
                                    	<div class="form-group">
                                            <select class="form-control" id="category_select">
                                                <option class="hidden" selected="" disabled="">Please select Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                	<button type="button" id="submit_additem">Add Item</button>
                                </div>
                                </form>

	</div>

	<div class="tab-pane fade" id="category">
		<div class="container w-50">
			<form method="post" action="/addcategories">
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif
				{!! csrf_field() !!}
				<center>
				<div class="card text-white bg-success pt-10 mt-4">
					<div class="card-header">Add Category</div>
					<div class="card-body">
						<fieldset>
							<h4>Category Name:</h4><input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name">
							<strong>{{ $errors->first('name') }}</strong>
							<button type="submit" class="btn btn-primary mt-4 pb-2">Submit</button>
						</fieldset>
					</div>
				</div>
				</center>
			</form>
		</div>

		<div class="container w-auto p-3 ">
			<div class="card text-white bg-dark mb-3 my-auto mx-auto">
				<div class="card-header text-center">Current Categories</div>

				<div class="card-body">
					
					
					<table  class="table table-hover table-striped table-dark w-100" border="1">
						<tr>
							<th style="width: 25%;">ID</th>
							<th style="width: 50%;">Name</th>
							<th style="width: 25%;" colspan="2">{{-- TOKEN:{!!  $kups = csrf_token(); echo $kups; !!} --}}</th>
						</tr>
						@foreach($categories as $category)
						<tr>
							<td data-categoryid="{{ $category->id }}">{!! $category->id !!}</td>
							<td class="categorynamevalue" colspan="2">{!! $category->category_name !!}</td>
							<td class="editcategory">
								<button type="button" class="btn btn-primary btn-sm editcategory_btn" data-toggle="modal" data-target="#modalEditCategory"> EDIT</button>
								<button type="button" class="btn btn-warning btn-sm addpriceset_btn" data-toggle="modal" data-target="#addPriceSet">Price Set</button>
								
									<button type="button" class="btn btn-danger btn-sm del-ctg">DELETE</button>
								
								
							</td>
						</tr>
						@endforeach
					</table>
				</div>

			</div>
		</div>

	</div>

</div>
</div>
</div>
{{-- <script>
var token = "{{ csrf_token() }}";
var url = "{{ route('edit') }}";
var priceseturl = "{{ route('showpricesets') }}";
var addpriceseturl = "{{ route('addpricesets') }}";

</script> --}}
@endsection