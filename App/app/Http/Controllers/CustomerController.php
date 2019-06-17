<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customers = Customer::all();
      $customers->load('manager');
      return response()->json([
        'customers' => $customers->toArray()
      ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|max:255',
        'phone' => 'required',
      ]);
      $customer = new Customer([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'phone' => $request->get('phone'),
        'site' => $request->get('site'),
        'inn' => $request->get('inn'),
        'kpp' => $request->get('kpp'),
        'ogrn' => $request->get('ogrn'),
        'legal_name' => $request->get('legal_name'),
        'actual_address' => $request->get('actual_address'),
        'legal_address' => $request->get('legal_address'),
        'bank_details' => $request->get('bank_details'),
        'manager_id' => $request->get('manager_id'),
        'customer_type_id' => $request->get('customer_type_id'),
        'area_activity_id' => $request->get('area_activity_id'),
        'spokesman_id' => $request->get('spokesman_id'),
      ]);

      $customer->save();

      return response()->json($customer->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function show($id)
  {
    $customer = Customer::findOrFail($id);
    return response()->json($customer->load('area_activity','projects', 'invoices', 'manager', 'spokesman'));
  }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
  {
    $customer = Customer::findOrFail($id);
    $customer->update($request->all());
    return response()->json($customer->toArray());
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function destroy($id)
  {
    $customer = Customer::findOrFail($id);
    $customer->delete();
    return response()->json('Successfully Deleted');
  }
}
