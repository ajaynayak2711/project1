<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Traits\CreatedUpdatedBy;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Request()->request->add(['pageTitle'=>"Customer", 'pageBtnText'=>"Add Customer", 'pageBtnClass'=>'primary', 'redirectURL'=>route('customer.create')]);
        Request()->request->add(['datatables_columns' => [
            'ID' => ['data' => 'DT_RowIndex','name' => 'id', 'searchable' => false],
            "Name" => ["data" =>"name", "name" => "name"],
            'Email' => ['data' => 'email','name' => 'email'],
            'Contact' => ['data' => 'contact','name' => 'contact'],
            'Address' => ['data' => 'address','name' => 'address'],
            'Action' => ['data' => 'action', 'orderable' => false, 'searchable' => false]
        ]]);

        if ($request->ajax()) {
            $query  = customer::select('*');
            return Datatables::of($query)
            ->addIndexColumn()
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);
            })
            ->filterColumn('created_at', function($query, $keyword) {
                $query->whereDate('created_at', '=', $keyword);
            })
            ->addColumn('action', function($row) {
					return '<a href="'.route('customer.edit',$row->id).'" class="btn btn-dark">Edit</a> <a data-url="'.route('customer.destroy',$row->id).'" href="javascript:void();" class="btn btn-danger delete-item">Delete</a>';
            })
            ->addColumn('created_at', function($row){
               return date("d-m-Y",strtotime($row->created_at));
           })->rawColumns(["action"])->make(true);
        }
        return view('customer.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Request()->request->add(['pageTitle'=>'Add Customer', 'pageBtnText'=>'Back', 'pageBtnClass'=>'danger', 'redirectURL'=>route('customer.index')]);
        $data['customer'] = customer::where(['status' => '1'])->get();
        return view('customer.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'contact' => 'required',
            'address' => 'required',
        ]);
        customer::create($post);
        return redirect()->to("customer")->with('success', 'Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customer $customer)
    {
        Request()->request->add(['pageTitle'=>"Update Customer", 'pageBtnText'=>"Back", 'pageBtnClass'=>'danger', 'redirectURL'=>route('customer.index')]);
		$data['customer'] = $customer;
		return view('customer.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customer $customer)
    {
		$id = $customer->id;
        $post = $request->all();
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,'.$id,
            'contact' => 'required',
            'address' => 'required',
        ]);
		$customer->update($post);
        return redirect()->to("customer")->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customer $customer)
    {
        $customer->delete();	
		return response()->json(['message' => 'Deleted Successfully', 'status' => TRUE]);
    }
}
