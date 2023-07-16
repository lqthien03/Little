<?php

namespace App\Http\Controllers;

use App\Mail\ThankYouMail;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Dotenv\Validator;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Barryvdh\DomPDF\PDF;


class TicketController extends Controller
{
    protected function getFirstCapitalLetter(string $str)
    {
        $strFinal = '';

        $str = strtolower($str);
        $arr = explode(' ', $str);
        foreach ($arr as $i) {
            $strFinal .= strtoupper($i[0]);
        }

        return $strFinal;
    }
    protected function getQrCode(string $ticket_name, int $orderId, int $orderDetailId, string $date_order)
    {
        return $this->getFirstCapitalLetter($ticket_name) . $orderId  . $orderDetailId . date('Ymd', strtotime($date_order));
    }
    
    protected function changeStatus(object $row, string $status)
    {
        $row->status = $status;
        $row->save();
    }
    protected function checkUserExistByPhone(string $phone, string $email, string $name)
    {
        $userId = User::where('phone', $phone)->first();
        if (empty($userId)) {
            $newUser = new User;
            $newUser->email = $email;
            $newUser->phone = $phone;
            $newUser->name = $name;
            $newUser->save();
            return $newUser->id;
        }
        return $userId->id;
    }
    protected function insertOrderDetail(int $orderId, int $id_ticket, int $quantity)
    {
        $order = new OrderDetail();
        $order->id_order = $orderId;
        $order->id_ticket = $id_ticket;
        $order->quantity = $quantity;
        $order->save();
        return $order->id;
    }
    protected function createUnpaidOrder(string $total_price, string $date_order, string $checkout_session_id, int $id_user)
    {
        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $total_price;
        $order->date_order = $date_order;
        $order->session_id = $checkout_session_id;
        $order->id_users = $id_user;
        $order->save();
    }
    protected function soldTicket(int $id, int $quantity)
    {
        $ticket = Ticket::find($id);
        $ticket->remain -= $quantity;
        $ticket->save();
    }
    public function index()
    {
        $tickets = Ticket::all();
        return view('index', compact('tickets'));
    }
    public function beforepay(Request $request)
    {
        //kiểm tra số lượng vé
        $ticket = Ticket::findOrFail($request->ticket);
        $tickets_remaining = $ticket->remain;

        $request->validate([
            "quantity" => 'bail|required|integer|min:1|max:' . $tickets_remaining,
            "date_order" => 'required|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            // "name" => ['required', 'regex:/^[A-Za-z\s]+$/'],
            "name" => ['required', 'regex:/^[\p{L}\s]+$/u'],
            "phone" => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})/', 'size:10']
        ], [
            'quantity.max' => 'Không đủ vé',
            'quantity.min' => 'Số vé phải lớn hơn 0',
            'date_order.after_or_equal' => 'Ngày đặt phải từ hôm nay trở đi',
            'name.regex' => 'Tên không được chứa ký tự đặc biệt (số)',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.size' => 'Số điện thoại phải có 10 số'
        ]);


        $userId = $this->checkUserExistByPhone($request->phone, $request->email, $request->name);

        // $total = $ticket->price * $request->quantity;
        $total = Ticket::find($request->ticket)->value('price') * $request->quantity;
        // dd($total);

        $data = [
            'ticket' => Ticket::select('name', 'id', 'remain')->where('id', $request->ticket)->first(),
            'quantity' => $request->quantity,
            'date_order' => $request->date_order,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'total' => $total,
            'id_user' => User::select('id')->where('phone', $request->phone)->first()->id
        ];


        return view('beforepay')->with('data', $data);
    }

    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApikey(env('STRIPE_SECRET_KEY'));
        $unitAmount = $request->total_price * 100 / $request->quantity;

        if ($unitAmount < 50) {
            $quantity = ceil(50 / $unitAmount);
            $unitAmount = 50;
        } else {
            $quantity = $request->quantity;
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'invoice_creation' => ['enabled' => true],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'vnd',
                    'product_data' => [
                        'name' => $request->name,
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true)  . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' =>  route('checkout.cancel', [], true) . '?currency=vnd',
            'metadata' => [
                'id_ticket' => $request->id_ticket,
                'date_order' => $request->date_order,
                'remain' => $request->remain,
                'quantity' => $quantity,
            ],
        ]);
        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $request->total_price;
        $order->date_order = $request->date_order;
        $order->session_id = $checkout_session->id;
        $order->id_users = $request->id_user;
        $order->save();

        return redirect($checkout_session->url);
    }

    public function webhook()
    {

        \Stripe\Stripe::setApikey(env('STRIPE_SECRET_KEY'));


        $endpoint_secret = env('STRIPE_WWEBHOOK_SECRET');

        $payload = file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {


            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {


            return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $session_id = $session->id;

                $order = Order::where('session_id', $session_id)->first();

                if ($order) {
                    if ($order->status === 'unpaid')
                        $this->changeStatus($order, 'paid');

                    $id_ticket = $session->metadata['id_ticket'];
                    $quantity = $session->metadata['quantity'];
                    $date_order = $session->metadata['date_order'];
                    $remain = $session->metadata['remain'];
                    $userEmail = $session->customer_details['email'];
                    $userName = $session->customer_details['name'];

                    $orderDetail = OrderDetail::where('id_order', $order->id)->first();
                    if (empty($orderDetail))
                        $orderDetailId = $this->insertOrderDetail($order->id, $id_ticket, $quantity);
                    else
                        $orderDetailId = $orderDetail->id;


                    $ticket = Ticket::where('id', $id_ticket)->first();
                    if ($ticket) {
                        $ticket_name = $ticket->name;
                        if ($ticket->remain == $remain) {
                            $this->soldTicket($ticket->id, $quantity);
                        }
                    }

                    $qrCodeString = $this->getQrCode($ticket_name, $order->id, $orderDetailId, $date_order);
                    Mail::to($userEmail)->send(new ThankYouMail($userName, $userEmail, $order->total_price, $order->date_order, $quantity, $ticket_name, $qrCodeString));
                }

            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }

    public function success(Request $request)
    {

        \Stripe\Stripe::setApikey(env('STRIPE_SECRET_KEY'));
        try {
            $session_id = $request->get('session_id');
            $session = \Stripe\Checkout\Session::retrieve($session_id);

            $id_ticket = $session->metadata['id_ticket'];
            $remain = $session->metadata['remain'];
            $quantity = $session->metadata['quantity'];
            $date_order = $session->metadata['date_order'];

            if (!$session) {
                throw new NotFoundHttpException();
            }

            $order = Order::where('session_id', $session_id)->first();

            if (!$order) {
                throw new NotFoundHttpException();
            }
            $orderId = $order->id;

            if ($order->status === 'unpaid')
                $this->changeStatus($order, 'paid');


            $orderDetail = OrderDetail::where('id_order', $orderId)->first();
            if (empty($orderDetail))
                $orderDetailId = $this->insertOrderDetail($orderId, $id_ticket, $quantity);
            else
                $orderDetailId = $orderDetail->id;


            $ticket = Ticket::where('id', $id_ticket)->first();
            if ($ticket) {
                $ticket_name = $ticket->name;
                if ($ticket->remain == $remain)
                    $this->soldTicket($ticket->id, $quantity);
            }

            $qrCodeString = $this->getQrCode($ticket_name, $orderId, $orderDetailId, $date_order);

            $data = [
                'string_to_qr' => $qrCodeString,
                'quantity' => $quantity,
                'date_order' => date('d/m/Y', strtotime($date_order)),
                'ticket_name' => $ticket_name,
            ];

            return view('checkout-success')->with('data', $data);
        } catch (Exception $e) {
            throw new NotFoundHttpException();
        }
    }


    public function cancel(Request $request)
    {
        $order = Order::where('session_id', $request->get('session_id'))->first();
        $this->changeStatus($order, 'cancel');
        return redirect()->route('index');
    }


    public function save(Request $request)
    {
        $order = DB::table('orders')->where('session_id', $request->session_id)->first();
        $user = DB::table('users')->find($order->id_users);
        $orderDetail = DB::table('order_details')->where('id_order', $order->id)->first();
        $ticket_name = DB::table('tickets')->where('id', $orderDetail->id_ticket)->first()->name;


        if (isset($_POST['mail'])) {
            Mail::to($user->email)->send(new ThankYouMail($user->name, $user->email, $order->total_price, $order->date_order, $orderDetail->quantity, $ticket_name, $request->string_to_qr));
            return redirect()->route('index');
        }



        if (isset($_POST['save'])) {
            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'price' => number_format($order->total_price, 0, ',', '.'),
                'date_order' => date('d/m/Y', strtotime($order->date_order)),
                'quantity' => $orderDetail->quantity,
                'ticket_name' => $ticket_name,
                'string_to_qr' => $request->string_to_qr
            ];

            $pdf = app()->make('dompdf.wrapper');
            $pdf->loadView('email.content', $data)
                ->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
    }
}
