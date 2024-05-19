<div class="row">
    <div class="col-md-6">
		<label>Name</label>
		<input type="text" class="form-control is_required" placeholder="Name" name="name" value="@isset($customer->name){{$customer->name}}@else{{old('name')}}@endisset" />
    </div>
	<div class="col-md-6">
		<label>Email</label>
		<input type="text" class="form-control is_required" placeholder="email" name="email" value="@isset($customer->email){{$customer->email}}@else{{old('email')}}@endisset" />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
		<label>Contact</label>
		<input type="text" class="form-control is_required" placeholder="contact" name="contact" value="@isset($customer->contact){{$customer->contact}}@else{{old('contact')}}@endisset" />
    </div>
	<div class="col-md-6">
		<label>Address</label>
		<textarea class="form-control is_required" placeholder="address" name="address">@isset($customer->address){{$customer->address}}@else{{old('address')}}@endisset</textarea>
    </div>
</div>
<hr class="mb-4 mt-4">
<button type="submit" class="btn btn-primary">{{Request()->request->get('pageTitle')}}</button>