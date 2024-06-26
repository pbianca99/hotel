<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;

class BookingController extends Controller
{


    public function checkout()
    {
        if (Session::has('book_date')) {
            $book_data = Session::get('book_date');
            $room = Room::find($book_data['room_id']);

            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $nights = $toDate->diffInDays($fromDate);

            return view('frontend.checkout.checkout', compact('book_data', 'room', 'nights'));
        } else {
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );

            return redirect('/')->with($notification);
        }
    }

    public function bookingStore(Request $request)
    {
        $validatedData = $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'person' => 'required',
            'number_of_rooms' => 'required',
        ]);

        if ($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Insufficient rooms available!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        Session::forget('book_date');

        $data = [
            'number_of_rooms' => $request->number_of_rooms,
            'available_room' => $request->available_room,
            'person' => $request->person,
            'check_in' => date('Y-m-d', strtotime($request->check_in)),
            'check_out' => date('Y-m-d', strtotime($request->check_out)),
            'room_id' => $request->room_id,
        ];

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }

    public function checkoutStore(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        // Retrieve booking data from session
        $bookData = Session::get('book_date');
        $toDate = Carbon::parse($bookData['check_in']);
        $fromDate = Carbon::parse($bookData['check_out']);
        $totalNights = $toDate->diffInDays($fromDate);

        // Retrieve room details
        $room = Room::find($bookData['room_id']);
        $subtotal = $room->price * $totalNights * $bookData['number_of_rooms'];
        $discount = ($room->discount / 100) * $subtotal;
        $totalPrice = $subtotal - $discount;
        $code = rand(1000000000, 9999999999);

        // Initialize payment status and transaction ID
        $paymentStatus = 0;
        $transactionId = '';

        try {
            // Check if payment method is Stripe
            if ($request->payment_method == 'Stripe') {
                // Set Stripe API key
                Stripe::setApiKey(env('STRIPE_SECRET'));
                //Stripe::setApiKey('sk_test_51PUsPgP4261Y0x4txiuWEyKwnBcaRQxFmtjwUyJ5aWjDntwX9DmtO3F0oQahw6oN0pBGvpQTif0vtqH3XW4kZEmh00ipxZo2Ut');
                // Create Stripe charge
                $payment = \Stripe\Charge::create([
                    "amount" => $totalPrice * 100, // Amount in cents
                    "currency" => "ron", // Currency code
                    "source" => "tok_visa", //$request->stripeToken, // Token generated by Stripe.js
                    "description" => "Payment for booking number " . $code,
                ]);

                // Check if payment is successful
                if ($payment->status == 'succeeded') {
                    $paymentStatus = 1;
                    $transactionId = $payment->id;
                } else {
                    // Handle payment failure
                    $notification = [
                        'message' => 'Payment failed!',
                        'alert-type' => 'error'
                    ];

                    return redirect('/')->with($notification);
                }
            }

            // Create new Booking record
            $booking = new Booking();
            $booking->room_id = $room->id;
            $booking->user_id = Auth::user()->id;
            $booking->check_in = $bookData['check_in'];
            $booking->check_out = $bookData['check_out'];
            $booking->person = $bookData['person'];
            $booking->number_of_rooms = $bookData['number_of_rooms'];
            $booking->total_night = $totalNights;
            $booking->actual_price = $room->price;
            $booking->subtotal = $subtotal;
            $booking->discount = $discount;
            $booking->total_price = $totalPrice;
            $booking->payment_method = $request->payment_method;
            $booking->transaction_id = $transactionId;
            $booking->payment_status = $paymentStatus;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->country = $request->country;
            $booking->state = $request->state;
            $booking->zip_code = $request->zip_code;
            $booking->address = $request->address;
            $booking->code = $code;
            $booking->status = 0;
            $booking->save();

            // Save booked dates
            $startDate = Carbon::parse($bookData['check_in']);
            $endDate = Carbon::parse($bookData['check_out'])->subDay();
            $dates = CarbonPeriod::create($startDate, $endDate);

            foreach ($dates as $date) {
                $bookedDate = new RoomBookedDate();
                $bookedDate->booking_id = $booking->id;
                $bookedDate->room_id = $room->id;
                $bookedDate->book_date = $date->toDateString();
                $bookedDate->save();
            }

            // Clear booking session data
            Session::forget('book_date');

            // Redirect with success notification
            $notification = [
                'message' => 'Booking successful!',
                'alert-type' => 'success'
            ];

            return redirect('/')->with($notification);

        } catch (ApiErrorException $e) {
            // Handle Stripe API errors
            $notification = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];

            return redirect('/')->with($notification);
        }
    }


    public function BookingList(){
        $allData = Booking::orderBy('id','desc')->get();
        return view('backend.booking.booking_list',compact('allData'));
    }

    public function EditBooking($id){
        $editData = Booking::with('room')->find($id);
        return view('backend.booking.edit_booking',compact('editData'));
    }

    public function UpdateBookingStatus(Request $request, $id){

        $booking = Booking::find($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        $notification = array(
            'message' => 'Informatie modificata cu succes!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function UpdateBooking(Request $request, $id){
        if ($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Nu mai sunt camere disponibile!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('Y-m-d', strtotime($request->check_in));
        $data->check_out = date('Y-m-d', strtotime($request->check_out));
        $data->save();

        RoomBookedDate::where('booking_id', $id)->delete();

        $sdate = date('Y-m-d',strtotime($request->check_in));
        $edate = date('Y-m-d',strtotime($request->check_out));
        $eldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate,$eldate);
        foreach($d_period as $period){
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $data->room_id;
            $booked_dates->book_date = date('Y-m-d',strtotime($period));
            $booked_dates->save();
        }

        $notification = array(
            'message' => 'Rezervare modificata cu succes!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        
    }

}

