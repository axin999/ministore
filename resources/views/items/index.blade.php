@extends('master')
@section('title', 'Add Items')
@section('content')
@include('items.modal')
<ul class="nav nav-tabs">
	<li class="nav-item" id="navPricelist">
		<a class="nav-link" data-toggle="tab" href="#pricelist">Price List</a>
	</li>
	<li class="nav-item" id="navAdditems">
		<a class="nav-link" data-toggle="tab" href="#items">Add Item</a>
	</li>
	<li class="nav-item" id="navAddCategory">
		<a class="nav-link" data-toggle="tab" href="#category">Add Category</a>
	</li>
	<li class="nav-item" id="navPriceset">
		<a class="nav-link" data-toggle="tab" href="#priceset">Price Set</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<a class="dropdown-item" href="#">Something else here</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Separated link</a>
		</div>
	</li>
</ul>
<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade" id="pricelist">
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
		<input type="text" name="">
	</div>
	<div class="tab-pane fade" id="items">
		<div>
			<form method="post">
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
							<h4>Price</h4>
							<label>Whole Sale:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<label>Half:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<label>Per piece:</label><input type="text" class="form-control" id="name" placeholder="Item Name" name="name">
							<strong>{{ $errors->first('name') }}</strong>
							<button type="submit" class="btn btn-primary">Submit</button>
						</fieldset>
					</div>
				</div>
				</center>
			</form>
		</div>
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
	<div class="tab-pane fade" id="priceset">
		<div class="container">
			<span class="glyphicon glyphicon-plus"></span>
			<div class="container w-100 h-auto p-3 my-auto mx-auto">
				<div class="card-header bg-dark text-white">
					Price Set
				</div>
				<div class="card-body bg-dark text-white">
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Dropdown button
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="dropdown1">
		<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
	</div>
	<div class="tab-pane fade" id="dropdown2">
		<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
	</div>
</div>
</div>
<script>
var token = "{{ csrf_token() }}";
var url = "{{ route('edit') }}";
var priceseturl = "{{ route('showpricesets') }}";
var addpriceseturl = "{{ route('addpricesets') }}";
var sampleurl = "{{ action('PricesetsController@showpricesets','categoryId') }}";
console.log('ew',addpriceseturl);
</script>
@endsection