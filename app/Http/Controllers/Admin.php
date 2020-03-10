<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use DB;

class Admin extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    public function central(Request $req){
        $table= $req->section;
        $columns = Schema::getColumnListing($table);
        $entries = DB::table($table)->get();

        return view('layouts.central')->with(['columns'=>$columns,'entries'=>$entries,'table'=>$table]);
    }

    public function deleteSize(Request $req){
        DB::table('Product_sizes')->where('size_id',$req->key)->delete();
        DB::table('Sizes')->where('size_id',$req->key)->delete();
        return redirect()->intended("/admin/central?section=Sizes");
    }

    public function deleteTags(Request $req){
        DB::table('Products_tags')->where('tag_id',$req->key)->delete();
        DB::table('Tags')->where('id',$req->key)->delete();
        return redirect()->intended("/admin/central?section=Tags");
    }

    public function deleteprotypes(Request $req){
        DB::table('Products')->where('product_type_code',$req->key)->delete();
        DB::table('Ref_Product_Types')->where('product_type_code',$req->key)->delete();
        return redirect()->intended("/admin/central?section=Ref_Product_Types");
    }

    public function produse(Request $req){

        $columns = Schema::getColumnListing("Products");
        $entries = DB::table('Products')->get();

        return view('produse')->with(['columns'=>$columns,'entries'=>$entries]);
    }

    public function details(Request $req){
        header('Access-Control-Allow-Origin', "*");
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $table = $req->table;
        $keycode = $req->keycode;
        $key = $req->key;
     

        switch($table){
            case 'Products':{


                return self::Products($key);
            }break;
            case 'Orders':{
                return self::Orders($key,$req);
            }break;

            case 'Shipments':{
                $order_id = DB::table('Shipments')->where('shipment_id',$key)->first()->order_id;
                return redirect()->intended('/admin/details?table=Orders&key='.$order_id);
            }break;
            case 'Invoices':{
                $order_id = DB::table('Invoices')->where('invoice_number',$key)->first()->order_id;
                return redirect()->intended('/admin/details?table=Orders&key='.$order_id);
            }break;
            case 'Payments':{
                $in = DB::table('Payments')->where('payment_id',$key)->first()->invoice_number;
                $order_id = DB::table('Invoices')->where('invoice_number',$in)->first()->order_id;
                return redirect()->intended('/admin/details?table=Orders&key='.$order_id);
             
            }
            default:{
                print_r($_GET);
                return ;
            }
        }


    }

    
    private function Orders($primary_key){
        $order_ = $primary_key;

       $cols = array();
       $cols["customers_cols"] = Schema::getColumnListing('Customers');
       $cols["orders_cols"] = Schema::getColumnListing('Orders');
       $cols["products_cols"] = Schema::getColumnListing('Products');
       $cols["invoices_cols"] = Schema::getColumnListing('Invoices');
       $cols["shipments_cols"] = Schema::getColumnListing('Shipments');

        $order = DB::table('Orders')->where('order_id',strtoupper($order_))->first();
        
        $user = DB::table('Customers')->where('customer_id',$order->customer_id)->first();
        $osc = DB::table("Ref_Order_Status_Codes")->get();
        if($order !== null && $user && $user->customer_id === $order->customer_id){
            // Set up the order details
            $ois =  DB::table('Order_Items')->where(['order_id'=>$order->order_id,])->get();
            foreach($ois as $key => $item){
               $product =  DB::table('Products')->where('product_id',$item->product_id)->first();
               
               $ois[$key] = (object) array_merge( (array) $product, (array) $item); 
               $ois[$key]->size_desc = DB::table('Sizes')->where('size_id',$ois[$key]->size)->pluck('size')->first();
            }
            $order_items = DB::select("
                    select order_id,product_id,product_name,Sizes.size,count(*) as bucati 
                    from Order_Items join Products using(product_id)
                    join Sizes on(Sizes.size_id = Order_Items.size)
                    where order_id = '$primary_key'
                    group by order_id,product_id,product_name,Sizes.size
            ")  ;              
       
       /*     foreach($order_items as $key => $item){
           //    $product =  DB::table('Products')->where('product_id',$item->product_id)->first();
               
              // $order_items[$key] = (object) array_merge( (array) $product, (array) $item); 
               $order_items[$key]->size_desc = DB::table('Sizes')->where('size_id',$order_items[$key]->size)->pluck('size')->first();
            }*/

            //Set up the billing details

            $invoice = DB::table('Invoices')->where('order_id',$order->order_id)->first();
            $shipment = DB::table('Shipments')->where('order_id',$invoice->order_id)->first();
        

            return view('order')->with(['user'=>$user,'ordered_items'=>$order_items,
                                        'order'=>$order,
                                        'invoice'=>$invoice,
                                        'shipment'=>$shipment,
                                        'cols'=>$cols,
                                        'ordered_items'=>$order_items,
                                        'ois'=>$ois,
                                        'order_status_codes'=>$osc
                                        ]);
        } 
    }

    private function Products($primary_key){
        $columns_prod = Schema::getColumnListing('Products');
        $product = DB::table('Products')->where('product_id',$primary_key)->first();
        $sizes = DB::table('Product_sizes')->where('product_id',$primary_key)->join('Sizes','Sizes.size_id','=','Product_sizes.size_id')->get();
        $prod_types = DB::table('Ref_Product_Types')->get();
        $tags = DB::table('Products_tags')->where('product_id',$primary_key)->join('Tags','Products_tags.tag_id','=','Tags.id')->get();
        $tags_standalone = DB::table('Tags')->get();
        $sizes_standalone = DB::table("Sizes")->get();
        return view('produse')->with(['columns_prod'=>$columns_prod,'prod'=>$product,'sizes'=>$sizes,'tags'=>$tags,'product_types'=>$prod_types,'tags_standalone'=>$tags_standalone,'sizes_standalone'=>$sizes_standalone]);
    }

    public function getTags(){
        return response()->json(DB::table('Tags')->get());
    }



    public function addtag(Request $req){
        $tag= $req->tag;
        $prod = $req->prod;
        $scs = false;
        $reason = "";
        $prod = DB::table('Products')->where('product_id',$prod)->first();
        $tag = DB::table('Tags')->where('id',$tag)->first();

        if(!!$prod && !!$tag && !(DB::table('Products_tags')->where(['product_id'=>$prod->product_id,'tag_id'=>$tag->id])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Products_tags')->insertGetId(['product_id'=>$prod->product_id,'tag_id'=>$tag->id]);

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Eticheta gasita (".!!$tag.") >> Produs gasit (".!!$prod.")";
        }
        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);

    }

    public function resetuser(Request $req){
       $id = $req->customer_id;
        DB::table('Customers')->where('customer_id',$id)->update(['activated'=>0,'password'=>'X']);
        return redirect()->intended('/admin/central?section=Customers');
    }
    public function superuser(Request $req){
        $user_id = $req->customer_id;

        return redirect()->intended("http://localhost:8000/admin/superuser?target=$user_id&user=root&password=!QA@WSEDZXC");
    }

    public function deleteOrder(Request $req){
        $order_id = $req->id;
        if($req->resupply){
            $res = DB::select("select product_id,size, count(*) as nr from Order_Items where order_id = '$order_id' 
                        group by product_id,size
                        ");
            foreach($res as $result){
                $cstock = DB::select("select Quantity_AV from Product_sizes where product_id = '$result->product_id' and size_id = '$result->size'
                ")[0]->Quantity_AV;
                DB::table('Product_sizes')->where(['product_id'=>$result->product_id,'size_id'=>$result->size])->update(['Quantity_AV'=>($cstock + $result->nr)]);  
            }
        }
      
        DB::table('Orders')->where('order_id',$order_id)->update(['order_status_code'=>5]);
/*
        $invoice = DB::select("select invoice_number from Invoices where order_id = '$order_id'")->first();
        DB::table('Payments')->where("invoice_number",$invoice->invoice_number)->delete();
        DB::table('Order_Items')->where('order_id',$order_id)->delete();
        DB::tatble('Invoices')->where('order_id',$order_id)->delete();*/

        return redirect()->intended('/admin/details?table=Orders&keycode=order_id&key='.$order_id);
    }

    public function createprod(Request $req){
        $columns_prod = Schema::getColumnListing('Products');
        $prod_types = DB::table('Ref_Product_Types')->get();
         $tags_standalone = DB::table('Tags')->get();
        $sizes_standalone = DB::table("Sizes")->get();
       
        return View('createprod')->with(['columns_prod'=>$columns_prod,'product_types'=>$prod_types,'tags_standalone'=>$tags_standalone,'sizes_standalone'=>$sizes_standalone]);
    }

    public function createOrder(Request $req){


        return view('createorder')->with([]);
    }

    public function createprodtype(Request $req){
        $type= $req->prodt;
        $desc = $req->desc;
        $scs = false;
        $reason = "";

        if( !(DB::table('Ref_Product_Types')->where(['product_type_category'=>$type])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Ref_Product_Types')->insertGetId(['product_type_category'=>$type,'product_type_description'=>$desc]);

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Tipul  deja exista";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);
    }


    public function createSize(Request $req){
        $size= $req->size;
        $desc = $req->desc;
        $scs = false;
        $reason = "";

        if( !(DB::table('Sizes')->where(['size'=>$size])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Sizes')->insertGetId(['size'=>$size,'description'=>$desc]);

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Marimea deja exista";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);

    }


    public function createTag(Request $req){
        $tag= $req->tag;
    
        $scs = false;
        $reason = "";

        if( !(DB::table('Tags')->where(['name'=>$tag])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Tags')->insertGetId(['name'=>$tag]);

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Eticheta deja exista";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);

    }
    public function addsize(Request $req){
        $size= $req->size;
        $qt = $req->qt;
        $prod = $req->prod;
        $scs = false;
        $reason = "";
        $prod = DB::table('Products')->where('product_id',$prod)->first();
        $size = DB::table('Sizes')->where('size_id',$size)->first();
        
        if(!!$prod && !!$size && !(DB::table('Product_sizes')->where(['product_id'=>$prod->product_id,'size_id'=>$size->size_id])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Product_sizes')->insertGetId(['product_id'=>$prod->product_id,'size_id'=>$size->size_id,'Quantity_AV'=>$qt]);

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Eticheta gasita (".!!$tag.") >> Produs gasit (".!!$prod.")";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);

    }
    public function rmtag(Request $req){
        $tag= $req->tag;
        $prod = $req->prod;
        $scs = false;
        $reason = "";
        $prod = DB::table('Products')->where('product_id',$prod)->first();
        $tag = DB::table('Tags')->where('id',$tag)->first();

        if(!!$prod && !!$tag && !!(DB::table('Products_tags')->where(['product_id'=>$prod->product_id,'tag_id'=>$tag->id])->first())){
            $scs = false;
            
          try{
              
            $scs = DB::table('Products_tags')->where(['product_id'=>$prod->product_id,'tag_id'=>$tag->id])->delete();

          }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Eticheta gasita (".!!$tag.") >> Produs gasit (".!!$prod.")";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);
        
    }

    public function savestatus(Request $req){
        $order = $req->order;
        $status = $req->status;
        $scs = false;
        $reason = "";
        if($order && $status && !!(DB::table('Ref_Order_Status_Codes')->where('order_status_code',$status)->first())){
            DB::table('Orders')->where('order_id',$order)->update(['order_status_code'=>$status]);
            $scs = true;
        }else{
            $reason = "E posibil ca statusul sa nu existe in baza de date";
        }
        return response()->json(['scs'=>$scs,'reason'=>$reason]);
    }

    public function updatesize(Request $req){
        $prod = $req->prod;
        $size = $req->size;
        $qt = $req->qt;
        $prod = DB::table('Products')->where('product_id',$prod)->first();
        $size = DB::table('Sizes')->where('size_id',$size)->first();
        $scs = false;
        $reason = "";
        if(!!$prod && !!$size && $qt>=0){
           try{
                DB::table('Product_sizes')->where(['product_id'=>$prod->product_id,'size_id'=>$size->size_id])
                ->update(['Quantity_AV'=>$qt]);
                $scs = true;
            }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Marime gasita (".!!$size.") >> Produs gasit (".!!$prod.")";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);
    }

    public function deleteorderedi(Request $req){
        $order = $req->order;
        $product = $req->product;
        $size = DB::table('Sizes')->where('size',$req->size)->first();
        $scs = false; $reason = "";
      
        if($order && $product && $size){
           $oi =  DB::table('Order_Items')
                    ->where(['product_id'=>$product,'order_id'=>$order,'size'=>$size->size_id])
                    ->first();
             $scs =       DB::table('Order_Items')->where('order_item_id',$oi->order_item_id)->delete();
            
        }else{
            $reason = "Unul din parametrii nu a fost recunoscut";
        }



        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);
    }

    public function rmsizes(Request $req){
        $prod = $req->prod;
        $size = $req->size;
        $prod = DB::table('Products')->where('product_id',$prod)->first();
        $size = DB::table('Sizes')->where('size_id',$size)->first();
        $scs = false;
        $reason = "";
        if(!!$prod && !!$size){
           try{
              $scs = DB::table('Product_sizes')->where(['product_id'=>$prod->product_id,'size_id'=>$size->size_id])
                ->delete();
              $scs = !!$scs;  
            }catch(Exception $e){
                $reason = $e->getMessage();
          }

          
        }else{
            $reason = "Marime gasita (".!!$size.") >> Produs gasit (".!!$prod.")";
        }

        return response()->json(['scs'=>!!$scs,'reason'=>$reason]);
    }


    public function delprod(Request $req){
        try{
          
            self::deleteDir("./images/product_".$req->key);
            DB::table('Products_tags')->where('product_id',$req->key)->delete();
            DB::table('Product_sizes')->where('product_id',$req->key)->delete();
            DB::table('Products')->where('product_id',$req->key)->delete();
        }catch(Exception $e){

        }
        return redirect()->intended('/admin/central?section=Products');
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \Exception("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
