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
								<li class="breadcrumb-item active" aria-current="page">Rezervari</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{route('add.employee')}}" class="btn btn-warning px-3 radius-30"> Adauga o rezervare </a>
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
                                        <th>Nr. rezervare</th>
										<th>Data rezervarii</th>
										<th>Client</th>
										<th>Camera</th>
										<th>Check In/Check Out</th>
                                        <th>Total camere</th>
										<th>Oaspeti</th>
                                        <th>Plata</th>
                                        <th>Stare</th>
                                        <th>Actiune</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($allData as $key=> $item)
                                        

									<tr>
										<td>{{$key+1}}</td>
										<td><a href="{{route('edit_booking',$item->id)}}"> {{$item->code}} </a></td>
										<td>{{$item->created_at->format('d/m/Y')}}</td>
										<td>{{$item['user']['name']}}</td>
										<td>{{$item['room']['type']['name']}}</td>
										<td>
                                            <span class="badge bg-primary">{{$item->check_in}}</span>
                                            /<br>
                                            <span class="bagde bg-warning text-dark">{{$item->check_out}}</span>
                                        </td>
                                        <td>{{$item->number_of_rooms}}</td>
										<td>{{$item->person}}</td>
                                        <td>
                                            @if($item->payment_status == '1')
                                            <span class="text-success">Complet</span>
                                            @else
                                            <span class="text-danger">In asteptare</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == '1')
                                            <span class="text-success">Confirmat</span>
                                            @else
                                            <span class="text-danger">In asteptare</span>
                                            @endif
                                        </td>
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