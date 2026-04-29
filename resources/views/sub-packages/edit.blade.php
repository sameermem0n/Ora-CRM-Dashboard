@extends('layouts.web')
@section('title', 'Dashboard')
@section('content')

<div class="content-page">
	<div class="content">

		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Sub Packages</a></li>
								<li class="breadcrumb-item active">Edit Package Item</li>
							</ol>
						</div>
						<h4 class="page-title">Edit Package Item</h4>
					</div>
				</div>
			</div>

			<a href="{{ route('sub_packages.index') }}" style="font-size: 20px;"><i class="fa fa-arrow-circle-left mb-2" aria-hidden="true"></i></a>

			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul class="mb-0">
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif

						{!! Form::open(['method' => 'PATCH', 'url' => url('sub_packages/' . $sub_package->id)]) !!}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Package <span class="text-danger">*</span></label>
									{!! Form::select('package_id', $packages, $sub_package->package_id, ['class' => 'form-control', 'required']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Sub Service <span class="text-danger">*</span></label>
									{!! Form::select('sub_service_id', $services, $sub_package->sub_service_id, ['class' => 'form-control', 'required']) !!}
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Description <span class="text-danger">*</span></label>
									{!! Form::textarea('description', $sub_package->description, ['class' => 'form-control', 'rows' => 4, 'required']) !!}
								</div>
							</div>
						</div>

						<div class="form-group text-left mb-0">
							<button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
								Update
							</button>
							<a href="{{ route('sub_packages.index') }}" class="btn btn-secondary waves-effect waves-light">Cancel</a>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection