@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Hotel Staff</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{route('add.employee')}}" class="btn btn-warning px-3 radius-30"> Add New Team Member </a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
                                        <th>Serial Number</th>
                                        <th>Image</th>
										<th>Name</th>
										<th>Position</th>
										<th>Start date</th>
										<th>Salary</th>
                                        <th>Email</th>
										<th>Phone</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($team as $key=> $item)
                                        

									<tr>
										<td>{{$key+1}}</td>
										<td><img src="{{asset($item->image)}}" alt="" style="width:70px; height:40px"></td>
										<td>{{$item->name}}</td>
										<td>{{$item->position}}</td>
										<td>{{$item->start_date}}</td>
										<td>{{$item->salary}}</td>
                                        <td>{{$item->email}}</td>
										<td>{{$item->phone}}</td>
                                        <td>
                                            <a href="{{route('edit.employee',$item->id)}}" class="btn btn-warning px-3 radius-30"> Edit </a>
                                            <a href="{{route('delete.employee',$item->id)}}" class="btn btn-danger px-3 radius-30" id="delete"> Delete </a>
                                        </td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<hr/>
			</div>








@endsection