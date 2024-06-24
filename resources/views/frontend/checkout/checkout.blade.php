@extends('frontend.main_master')
@section('main')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg7">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li> Check Out</li>
                    </ul>
                    <h3> Check Out</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Checkout Area -->
		<section class="checkout-area pt-100 pb-70">
			<div class="container">

				<form method="post" role="form" action="{{route('checkout.store')}}"
                class="stripe_form require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}">
                    @csrf


					<div class="row">
                        <div class="col-lg-8">
							<div class="billing-details">
								<h3 class="title">Billing Details</h3>

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label>Country <span class="required">*</span></label>
											<div class="select-box">
												<select class="form-control" name="country">
													<option value="Romania">Romania</option>
													<option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="China">China</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Bulgaria">Bulgaria</option>
													<option value="Ukraine">Ukraine</option>
													<option value="Germany">Germany</option>
													<option value="France">France</option>
													<option value="Japan">Japan</option>
												</select>
											</div>
                                            @if ($errors->has('country'))
                                            <div class="text-danger">{{ $errors->first('country') }}</div>
                                            @endif
										</div>
									</div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label>Nume <span class="required">*</span></label>
            <input type="text" name="name" class="form-control"
            value="{{\Auth::user()->name}}">
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label>Email<span class="required">*</span></label>
            <input type="email" name="email" class="form-control"
            value="{{\Auth::user()->email}}">
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="form-group">
            <label>Telefon</label>
            <input type="text" name="phone" class="form-control"
            value="{{\Auth::user()->phone}}">
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label>Adresa <span class="required">*</span></label>
            <input type="text" name="address" class="form-control"
            value="{{\Auth::user()->address}}">
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label>Oras<span class="required">*</span></label>
            <input type="text" name="state" class="form-control">
            @if ($errors->has('state'))
            <div class="text-danger">{{$errors->first('state')}}</div>
            @endif
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group">
            <label>Cod Postal<span class="required">*</span></label>
            <input type="text" name="zip_code" class="form-control">
            @if ($errors->has('zip_code'))
            <div class="text-danger">{{$errors->first('zip_code')}}</div>
            @endif
        </div>
    </div>


								</div>
							</div>
						</div>
                        
                        
                        <div class="col-lg-4">
                            <section class="checkout-area pb-70">
                                <div class="card-body">
                                      <div class="billing-details">
                                            <h3 class="title">Booking Summary</h3>
                                            <hr>
              
<div style="display: flex">
        <img style="height:100px; width:120px;object-fit: cover" 
        src="{{ (!empty($room->image))? url('upload/room_images/'.$room->image): url('upload/no_image.png') }} " 
        alt="Image" alt="Image">
        <div style="padding-left: 10px;">
            <a href=" " style="font-size: 20px; color: #595959;font-weight: bold">{{@$room->type->name}}</a>
            <p><b>{{$room->price}} RON / Noapte</b></p>
        </div>

</div>
              
                                            <br>
              
                                            <table class="table" style="width: 100%">
                                            @php
                                                $subtotal = $room->price * $nights * $book_data['number_of_rooms'];
                                                $discount = ($room->discount/100)*$subtotal;
                                            @endphp
                                                   
                                                  <tr>
                                                        <td><p>Total: <br><b> ({{$book_data['check_in']}} - {{$book_data['check_out']}})</b></p></td>
                                                        <td style="text-align: right"><p>{{$nights}} Nopti</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Nr. camere:</p></td>
                                                        <td style="text-align: right"><p>{{$book_data['number_of_rooms']}} Camere</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Subtotal</p></td>
                                                        <td style="text-align: right"><p>{{$subtotal}} RON</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Discount</p></td>
                                                        <td style="text-align:right"> <p>{{$discount}} RON</p></td>
                                                  </tr>
                                                  <tr>
                                                        <td><p>Total</p></td>
                                                        <td style="text-align:right"> <p>{{$subtotal - $discount}} RON</p></td>
                                                  </tr>
                                            </table>
              
                                      </div>
                                </div>
                          </section>

						</div>


						<div class="col-lg-8 col-md-8">
							<div class="payment-box">
                                <div class="payment-method">
                                <p>
       <input type="radio" class="pay_method" id="stripe" name="payment_method" value="Stripe">
        <label for="stripe">Plata online cu cardul</label>
          </p>


           <div id="stripe_pay" class="d-none">
        <br>
        <div class="form-row row">
              <div class="col-xs-12 form-group required">
                    <label class="control-label">Numele de pe card</label>
                    <input class="form-control" size="4" type="text" />
              </div>
        </div>
        <div class="form-row row">
              <div class="col-xs-12 form-group  required">
                    <label class="control-label">Nr. card</label>
                    <input autocomplete="off" class="form-control card-number" size="20" type="text" />
              </div>
        </div>
        <div class="form-row row">
              <div class="col-xs-12 col-md-4 form-group cvc required"><label class="control-label">CVC</label><input autocomplete="off" class="form-control card-cvc" placeholder="ex. 311" size="4" type="text" /></div>
              <div class="col-xs-12 col-md-4 form-group expiration required"><label class="control-label">Luna expirarii</label><input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" /></div>
              <div class="col-xs-12 col-md-4 form-group expiration required"><label class="control-label">Anul expirarii</label><input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" /></div>
        </div>
        <div class="form-row row">
              <div class="col-md-12 error form-group hide"><div class="alert-danger alert">Please correct the errors and try again.</div></div>
        </div>
  </div>
                                    <p>
                                        <input type="radio" id="cash-on-delivery" name="payment_method" value="COD">
                                        <label for="cash-on-delivery">Plata in numerar la proprietate</label>
                                    </p>
                                </div>
<button type="submit" class="order-btn" id="myButton">Plaseaza Comanda</button>

                            </div>
						</div>
					</div>
				</form>
			</div>
		</section>
		<!-- Checkout Area End -->


        <style>
            .hide{display:none}
      </style>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">

      $(document).ready(function () {

            $(".pay_method").on('click', function () {
                  var payment_method = $(this).val();
                  if (payment_method == 'Stripe'){
                        $("#stripe_pay").removeClass('d-none');
                  }else{
                        $("#stripe_pay").addClass('d-none');
                  }
            });

      });






      $(function() {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {

                  var pay_method = $('input[name="payment_method"]:checked').val();
                  if (pay_method == undefined){
                        alert('Selectati o metoda de plata!');
                        return false;
                  }else if(pay_method == 'COD'){

                  }else{
                        document.getElementById('myButton').disabled = true;

                        var $form         = $(".require-validation"),
                                inputSelector = ['input[type=email]', 'input[type=password]',
                                      'input[type=text]', 'input[type=file]',
                                      'textarea'].join(', '),
                                $inputs       = $form.find('.required').find(inputSelector),
                                $errorMessage = $form.find('div.error'),
                                valid         = true;
                        $errorMessage.addClass('hide');

                        $('.has-error').removeClass('has-error');
                        $inputs.each(function(i, el) {
                              var $input = $(el);
                              if ($input.val() === '') {
                                    $input.parent().addClass('has-error');
                                    $errorMessage.removeClass('hide');
                                    e.preventDefault();
                              }
                        });

                        if (!$form.data('cc-on-file')) {

                              e.preventDefault();
                              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                              Stripe.createToken({
                                    number: $('.card-number').val(),
                                    cvc: $('.card-cvc').val(),
                                    exp_month: $('.card-expiry-month').val(),
                                    exp_year: $('.card-expiry-year').val()
                              }, stripeResponseHandler);
                        }
                  }



            });



            function stripeResponseHandler(status, response) {
                  if (response.error) {

                        document.getElementById('myButton').disabled = false;

                        $('.error')
                                .removeClass('hide')
                                .find('.alert')
                                .text(response.error.message);
                  } else {

                        document.getElementById('myButton').disabled = true;
                        document.getElementById('myButton').value = 'Te rugam asteapta...';

                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $form.get(0).submit();
                  }
            }

      });
</script>



@endsection