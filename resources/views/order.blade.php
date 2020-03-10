@extends('layouts.base')

@section('content')
<div class="data-tables">
<table> 
    <thead>
        @foreach ($cols["customers_cols"] as $prop)
            <th> {{$prop}} </th>
        @endforeach
      
       
    </thead>
    <tbody>
      
    
         <tr>
             <?php $i = 0; ?>
             @foreach ($user as $usr)
                    <td>  
                            {{$usr}} 
                  
                    </td>
                   
             <?php $i++; ?> 
            @endforeach
        
     </tr>

    
    </tbody>
</table>

<div style="border:1px solid red; float:left;font-size:20px; padding-right:20px;">
    <h3> order_status_codes </h3>
 <ul>
     @foreach ($order_status_codes as $item)
     <li>{{$item->order_status_code}} {{$item->order_status_description}}
     </li>
     @endforeach
 </ul>


</div>


<table> 
    <thead>
        @foreach ($cols["orders_cols"] as $prop)
            <th> {{$prop}} </th>
        @endforeach
      
       <th>Controls</th>
    </thead>
    <tbody>
      
    
         <tr>
             <?php $i = 0; ?>
             @foreach ($order as $prop)
                   @if($i!=2) <td>  
                            {{$prop}} 
                  
                    </td>
                    @else 
                        <td>
                        <input type="number" value="{{$prop}}" min="1" name="status" class="status">
                        </td>
                   @endif
             <?php $i++; ?> 
            @endforeach
                    <td class="tbl-btn save-order" order_id = "{{$order->order_id}}">Salveaza </td>
        
     </tr>

    
    </tbody>
</table>

<table> 
    <thead>
        @foreach (array_keys((array)$ordered_items[0]) as $prop)
            <th> {{$prop}} </th>
        @endforeach
      <th> Controls </th>
       
    </thead>
    <tbody>
      
        @foreach ($ordered_items as $oi)
            
   
         <tr>
             <?php $i = 0; ?>
             @foreach ($oi as $prop)
                    <td>  
                            {{$prop}} 
                  
                    </td>
                   
             <?php $i++; ?> 
            @endforeach
                <td class="tbl-btn del-oi"  order_id = "{{$oi->order_id}}" product_id="{{$oi->product_id}}" size="{{$oi->size}}">Sterge</td>
     </tr>
     @endforeach

    
    </tbody>
</table>

<table> 
    <thead>
        @foreach ($cols["shipments_cols"] as $prop)
            <th> {{$prop}} </th>
        @endforeach
      
       
    </thead>
    <tbody>
      
    
         <tr>
             <?php $i = 0; ?>
             @foreach ($shipment as $prop)
                    <td>  
                            {{$prop}} 
                  
                    </td>
                   
             <?php $i++; ?> 
            @endforeach
        
     </tr>

    
    </tbody>
</table>
</div>
<div class="row">
    <div class="col-md-12 p-lg-3" style="margin-top:20px;">
        <h2 class="h3 mb-3 text-black order-number">Order #<?php echo $order->AWB;?></h2>
        <div class="">
          
       <style>
        html,body{
            position: absolute;
            width:100%;
            height:100%;
        }
    .invoice-box {
        
        height: 80%;
        display: block;
        margin: auto;
        padding: 30px;
      
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        margin-bottom: 20px;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    .tm{
        text-transform: uppercase;
        text-decoration: none;;
    letter-spacing: .2em;
    font-size: 20px;
    padding-left: 10px;
    padding-right: 10px;
    border: 2px solid #25262a;
    color: #000 !important;
    }
    </style>
    </head>
    
    <body>
    
    <h2 class="h3 mb-3 text-black" style="  margin-top: 50px;">Factura</h2>              
    <div class="invoice-box" style="width:80%;">
        <table cellpadding="0" cellspacing="0" style="display:block;">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title stie_logo" style="text-align:left;">
                                <a href="localhost:8000" class="tm js-logo-clone">Silver Boutique</a>  </td>
                            
                            <td>
                            Factura #: {{$invoice->invoice_number}}<br>
                                Creata: {{$invoice->invoice_date}}<br>
                               
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="text-align:left;">
                                Silver Boutique<br>
                                Adresa<br>
                                Bucuresti, 1234
                            </td>
                            
                            <td>
                               
                            {{$invoice->first_name}} {{$invoice->last_name}}<br>
                               {{$invoice->email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td style="text-align:left;">
                    Modalitate de plata
                </td>
                
                <td>
                    {{$invoice->payment_method==1?"CARD":"RAMBURS"}} {{$invoice->payment_method < 0?$invoice->payment_method==-2?"(La exp)":"(La dest)":""}}
        
                </td>
            </tr>
            
           
            <tr class="heading">
                <td style="text-align:left;">
                    Produs
                </td>
                
                <td>
                    Pret
                </td>
            </tr>
            <?php $total = 0; $i = 0; foreach ($ois as $oi) {
                ?>
            <tr class="item" >
                <td style="text-align:left;">
                   {{$oi->product_name}} {{$oi->size_desc}}
                </td>
                
                <td>
                    <?php $i++; $total += $oi->order_item_price; echo $oi->order_item_price; ?> Lei
                </td>
            </tr>
        <?php } ?>
    
        <tr class="item last" >
            <td style="text-align:left;">
               {{$shipment->courier}}
            </td>
            
            <td>
               <?php  $total += $shipment->shipping_price; echo $shipment->shipping_price; ?> Lei
            </td>
        </tr>
            
          
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: {{$total}} Lei
                </td>
            </tr>
        </table>
    </div>
    
        
        </div>
    
        <div class="form-group row" style="display:block; height:100px;">
            <div class=""  style="margin-right:15px;float:right">
            <button class="btn btn-primary btn-lg btn-block dld"  >Download</button>
          </div>
      </div>
    
    
    
    
    <!--div class="col-md-12 mb-5 mb-md-0">
            
                    <h2 class="h3 mb-3 text-black">Detalii livrare</h2>
                    <div class="p-3 p-lg-5 border">
                     
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                          <input type="text" disabled class="form-control" id="c_fname" name="c_fname" value="<?php echo $shipment->first_name;?>">
                        </div>
                        <div class="col-md-6">
                          <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" disabled id="c_lname" name="c_lname" value="<?php echo $shipment->last_name;?>">
                        </div>
                      </div>
            
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" disabled id="c_address" name="c_address" placeholder="Street address" value="<?php echo $shipment->address;?>">
                        </div>
                        <div class="col-md-6">
                            <label for="c_address" class="text-black">Address</label>
                            <input type="text" class="form-control"  disabled placeholder="Apartment, suite, unit etc. (optional)" value="<?php echo $shipment->address_sec;?>">
                          </div>
                      </div>
            
                    
            
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label for="c_state_country" class="text-black">State <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" disabled id="c_state_country" name="c_state_country" value="<?php echo $shipment->state;?>">
                        </div>
                        <div class="col-md-6">
                          <label for="c_postal_zip" class="text-black"> Zip <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" disabled id="c_postal_zip" name="c_postal_zip" value="<?php echo $shipment->zip;?>">
                        </div>
                      </div>
            
                      <div class="form-group row mb-5">
                        <div class="col-md-6">
                          <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" disabled id="c_phone" name="c_phone" placeholder="Phone Number" value="<?php echo $shipment->phone_number;?>">
                        </div>
                      </div>
    
                      <div class="form-group row mb-5">
                            <div class="col-md-6">
                              <label for="c_phone" class="text-black">Delivered by</label>
                              <input type="text" class="form-control" disabled id="c_deliver" name="c_deliver" placeholder="" value="<?php echo $shipment->courier;?>">
                            </div>
                            <div class="col-md-6">
                                <label for="c_phone" class="text-black">AWB</label>
                                <input type="text" class="form-control" disabled id="c_awb" name="c_awb" placeholder="" value="<?php echo $shipment->shipment_tracking_number;?>">
                              </div>
                            
                      </div>
    
                    
    
            </div>
    </div-->
    
      
    </div>
        </div>

    <h3> Orice evidenta a comenzii va fi stearsa </h3>
    <a href="deleteOrder?id={{$order->order_id}}"> Sterge comaanda </a> <br>
    <a href="deleteOrder?id={{$order->order_id}}&resupply=1"> Sterge comanda cu reumplere stock </a>
<style>
    .tbl-btn{
        cursor: pointer;
        color: red;

    }
.grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: .5rem;
  padding: .5rem;
  grid-auto-rows: minmax(100px, auto);
  min-height: calc(100vh - 1rem);
  width:50%;
  margin:0 auto;


}
 .blocks{box-shadow: 0px 0px 50px -28px black;
    margin: 20px;
    text-align: center;
    background: white;
    border:1px dotted black;
 }

 .dataTables_wrapper.no-footer{
               padding:50px;
               width: max-content!important;
               max-width: 94vw;
               margin:0 auto;
           }
           table{
                    display: block;
            width: 100%;
            overflow-x: auto;
           }
           .presented{
               text-align: center;
            width:50%;
             margin:0 auto;
           }

           .invoice-box table{
               display: table!important;
           }
    </style>


@csrf

@endsection


@section('scripting')
<script>

 $('table').DataTable();
</script>


<style>
    .invoice-box{
        width:100%;
        transition: all .5s ease;

    }.downloading{
        width:735px!important;
        transition: all .7s ease;
    }
        .table td:first-child{
            width:80%;
        }</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script>

    $('.save-order').on('click',function(ev){

        $.ajax({
            url:"/admin/save_order_status",
            type:"post",
            data:{order:$(this).attr("order_id"),
                  status:$('.status').val(),
                  _token:$('input[name="_token"]').val()
            },
            success:function(data){
                if(data.scs){
                    window.location.reload();
                }else{
                    alert(data.reason);
                }
            },error:function(data){
                alert("Statusul nu a fost salvat, verifica consola");
                console.log(data);
            }
        })
    })  

    $('.del-oi').on('click',function(ev){

$.ajax({
    url:"/admin/deleteorderedi",
    type:"post",
    data:{order:$(this).attr("order_id"),
          product:$(this).attr("product_id"),
          size:$(this).attr("size"),
          _token:$('input[name="_token"]').val()
    },
    success:function(data){
        if(data.scs){
            window.location.reload();
        }else{
            alert(data.reason);
        }
    },error:function(data){
        alert("Statusul nu a fost salvat, verifica consola");
        console.log(data);
    }
})
})  



  window.onload = function(){
        $('.dld').on('click',function(ev){
            var quality  = 10;
            const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    let dateObj = new Date();
    let month = monthNames[dateObj.getMonth()];
    let day = String(dateObj.getDate()).padStart(2, '0');
    let year = dateObj.getFullYear();
    let output = month  + '-'+ day  + '-' + year;
            var filename  = 'FacturaSilverB'+$('.order-number')[0].innerText.split('#')[1]+".pdf";
            $('.invoice-box').addClass('downloading');
            setTimeout(function(){
		    html2canvas($('.invoice-box>table')[0], 
								{scale: 0.1,
                                onrendered: function (canvas) {
                                                canvas.getContext("2d").scale(0.5,0.5);
                                                var pdf = new jsPDF('p', 'pt', 'a4',{orientation:'landscape'});
                                                window.pdf = pdf;
                                                window.image = canvas.toDataURL('image/png',wid = canvas.width/2, hgt = canvas.height/2);
                                                pdf.addImage(window.image, 'PNG', 25, 25, 0, 0);
                                                pdf.save(filename);
                                                $('.invoice-box').removeClass('downloading');
                                }}
                        );
            },1500);
        })
  }
</script>
@endsection
