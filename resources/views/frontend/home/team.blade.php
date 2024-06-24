@php
    $employee = App\Models\Employee::latest()->get();
@endphp

<div class="team-area-three pt-100 pb-70">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Cunoașteți Echipa Noastră</h2>
                </div>
                <div class="team-slider-two owl-carousel owl-theme pt-45">

                @foreach ($employee as $item)
                    
            
                    <div class="team-item">
                        <a href="team.html">
                            <img src="{{asset($item->image)}}" alt="Images">
                        </a>
                        <div class="content">
                            <h3><a href="team.html">{{$item->name}}</a></h3>
                            <span>{{$item->position}}</span>
                            <ul class="social-link">
                                <li>
                                    <a href="mailto:{{$item->email}}" target="_blank"><i class="fadeIn animated bx bx-envelope"></i></a>
                                </li> 
                                <li>
                                    <a href="tel:{{$item->phone}}" target="_blank"><i class="fadeIn animated bx bx-phone"></i></a>
                                </li> 
                            </ul>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>