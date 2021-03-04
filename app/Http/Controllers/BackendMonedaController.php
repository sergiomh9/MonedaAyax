<?php

namespace App\Http\Controllers;
use App\Models\Moneda;
use Illuminate\Http\Request;

class BackendMonedaController extends Controller
{
    
     public function index()
    {
        
        $token = csrf_token();
        $monedas = Moneda::paginate(4);
        return response()->json(['monedas' => $monedas, 'token' => $token]);
    }
    
    
      public function show($moneda)
    {
        $moneda = Moneda::find($moneda);
        return response()->json(['moneda' => $moneda]);
    }


    public function edit($moneda)
    {
        $moneda = Moneda::find($moneda);
        return view('backend.moneda.edit', ['moneda' => $moneda]);
    }    
    
    public function update(Request $request, $id)
    {
        $moneda = Moneda::find($id);
        
        try{
            $result = $moneda->update($request->all());    
        }catch(\Exception $e){
            $result = $e;            
        }        

        return response()->json(['result' => $result, 'moneda' => $moneda]);
    }
    
      public function create()
    {
        return view('backend.moneda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
          $moneda = new Moneda($request->all());
          try{
              $result = $moneda->save();
          }catch(\Exception $e){
              $result  = $e;
              dd($result);
          }
        
        if($moneda->id > 0){

            $result = $moneda->save();
            $response = ['moneda' => $moneda];
            return response()->json($response);
        } else {
            return response()->json(['error' => 'La entrada esta duplicada']);
        }
    }
    
    public function destroy(Request $request, $id)
    {
        $moneda = Moneda::find($id);
        
        try{
            $result = $moneda->delete();    
        }catch(\Exception $e){
            $result = 0;
        }
        return response()->json(['monedas' => Moneda::paginate(3), 'result' => $result]);
        
    }
    
}
