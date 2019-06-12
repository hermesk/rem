<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        //
        $clients = Client::paginate(15);

        return view('backend.clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();
       return view('backend.clients.create',compact('client'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Client::class);
        $client = Client::create($this->validateRequest());
       
       session()->flash('message',' Client Saved Successfully');
    return redirect()->route('clients.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)//route model binding
    {
        return view('backend.clients.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('backend.clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Client $client)
    {
         
         $client->update($this->validateRequest());
        session()->flash('message',' Client Updated Successfully');
        return redirect()->route('backend.clients.show',['client'=>$client]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('backend.clients.index');
    }

    private  function validateRequest()
    {
        return request()->validate([
             'name'=>'required|string|max:50',
             'idno'=> 'required|min:7|unique:clients',
             'mobile'=>'required|numeric|min:10',
             'kra_pin'=>'nullable|min:8|unique:clients'  
                  ]);

    }
}
