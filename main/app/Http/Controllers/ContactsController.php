<?php

namespace App\Http\Controllers;

use App\ContactForms;
use App\Customers;
use App\DeliveryTimes;
use App\Forms;
use App\Orders;
use App\OrdersTracking;
use App\Products;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    public function index() {
        $forms = ContactForms::where('business_id', auth()->id())->get();
        return view('contacts.index', ['forms' => $forms]);
    }

    public function create() {
        return view('contacts.create');
    }

    public function delete($id) {
        $form = ContactForms::find($id);
        $form->delete();

        return back()->with('success', 'Deleted');
    }

    public function createPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' 	=> 'required',
            'link'		=> 'required|unique:contact_forms',
            'redirect'  => 'nullable',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $forms = new ContactForms();
            $forms->business_id = auth()->id();
            $forms->title = $request->title;
            $forms->link = $request->link;
            $forms->redirect = $request->redirect;
            $forms->form_fields = json_encode($request->form_fields);
            $forms->save();

            return redirect('/contacts')->with('success', 'Form created');

        }
    }

    public function edit($id) {
        return view('contacts.edit', ['form' => ContactForms::find($id)]);
    }

    public function editPost(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'link'      => 'required',
            'redirect'  => 'nullable',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {

            $forms = ContactForms::Find($id);
            $forms->business_id = auth()->id();
            $forms->title = $request->title;
            $forms->link = $request->link;
            $forms->redirect = $request->redirect;
            $forms->form_fields = json_encode($request->form_fields);
            $forms->save();

            return back()->with('success', 'Form Modified');

        }
    }

    public function viewForm($link) {
        $form = ContactForms::where('link', $link)->firstOrFail();

        $form->views = $form->views + 1;
        $form->save();

        return view('contacts.view', ['form' => $form]);
    }

    public function viewFormPost(Request $request) {

        $validator = Validator::make($request->all()['data'], [
            'link' => 'required',
            'fullname'  => 'required',
            'phonenumber' => 'required|digits:11',
            'email' => array('required'),
        ]);

        $validator->after(function($validator) use($request)
        {
            $data = $request->all()['data'];

        });

        $data = $request->all()['data'];

        $link = $data['link'];
        $form = ContactForms::where('link', $link)->firstOrFail();

        if($validator->fails()) {

            $m = null;
            $messages = $validator->messages();

            foreach ($messages->all('<li style="font-size: 15px; text-align: left; padding-bottom: 5px;">:message</li>') as $message)
            {
                $m .= $message;
            }

            $msg = "<div class='alert alert-danger'> ".$m."</div>";

            return \response()->json(['code' => 400, 'message' => $msg]);

        } else {

            // $user = User::where('id', $data['id'])->first();

            // if ($user->orders_count == 0 || $user->orders_count == NULL) {
            //     return \response()->json(['code' => 400, 'message' => 'This form is temporarily unavailable.', 'link' => $link]);
            // }

            $invoice_number = strtoupper("".rand(10000, 50000));

            // Create Customer
            $customer = new Customers();
            $customer->business_id = $data['id'];
            $customer->form_id = $form->id;
            $customer->fullname = $data['fullname'] ?? 'noname';
            $customer->address = $data['address'] ?? 'noaddress';
            $customer->state = $data['state'] ?? 'nostate';
            $customer->phonenumber = $data['phonenumber'] ?? 'nonumber';
            $customer->email = str_replace('gmail.con', 'gmail.com', str_replace(' ', '', $data['email'] ?? User::find($data['id'])->email_address));
            $customer->phonenumber_two = $data['phonenumbertwo'] ?? 'nonumber';
            $customer->save();

            $message = "
                Redirecting..
            ";

            $link = '';
            if($form->redirect == '') {
                $link = url('/contact-form-success');
            } else {
                $link = $form->redirect;
            }

            \session()->flash('success', 'Thank you');
            return \response()->json(['code' => 200, 'message' => $message, 'link' => $link]);
        }
    }

    public function success() {
        return view('contacts.success');
    }

    public function entries() {
        $forms = Customers::where('form_id', '!=', NULL)->where('business_id', auth()->id())->get();
        return view('contacts.entries', ['forms' => $forms]);
    }
}
