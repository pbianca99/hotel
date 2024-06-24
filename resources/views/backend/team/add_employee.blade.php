@extends('admin.admin_dashboard')
@section('admin')
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Add New Employee</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add New Employee</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-8">
								<div class="card">
                                    <form id="myForm" action="{{route('team.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf

									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Name</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="text" name="name" class="form-control" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="text" name="email" class="form-control" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Phone</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="text" name="phone" class="form-control" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Position</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="text" name="position" class="form-control" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Salary</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="number" name="salary" class="form-control" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Start Date</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="date" name="start_date" class="form-control" />
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Image</h6>
											</div>
											<div class="form-group col-sm-9 text-secondary">
												<input type="file" name="image" class="form-control" id="image" />
											</div>
										</div>


                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0"></h6>
											</div>
											<div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{url('upload/no_image.png')}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80"/>
											</div>
										</div>





										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<input type="submit" class="btn btn-primary px-4" value="Save Changes" />
											</div>
										</div>
									</div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
				email: {
                    required : true,
                }, 
				phone: {
                    required : true,
                }, 
				position: {
                    required : true,
                }, 
				salary: {
                    required : true,
                }, 
				start_date: {
                    required : true,
                }, 
				image: {
                    required : true,
                }, 
                
            },
            messages :{
                name: {
                    required : 'Please Enter Employee Name',
                }, 
				email: {
                    required : 'Please Enter An Email Address',
                }, 
				phone: {
                    required : 'Please Enter Employee`s Phone Number',
                }, 
				position: {
                    required : 'Please Enter Employee`s Position',
                }, 
				salary: {
                    required : 'Please Enter Employee`s Salary',
                }, 
				start_date: {
                    required : 'Please Enter Employee`s Start Date',
                }, 
				image: {
                    required : 'Please Select an Image',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>



@endsection