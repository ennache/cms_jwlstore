<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Silver Boutique</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/lightbox.min.css">

    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="css/fixedHeader.bootstrap4.css">
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="js/data-table.js" type="text/javascript"></script>

    <style>
     @media screen and (max-width:380px){ 
        .js-logo-clone{
          font-size: 15px!important;
      }}
     td{
         text-align: center;
     }
      </style>
  </head>
  <script>
    
    try{
      window.jqLoaded = new (function(){
          this.posted =[],
          this.triggered=false,
          this.subscribe=function(callback){
            if(this.triggered == true)
               callback();
               else
            this.posted.push(callback);
            console.log(">> callback registered ",this.posted);
          }.bind(this),
          this.fire=function(){
            this.triggered = true;
            for(var i = 0; i<this.posted.length;i++) 
                this.posted[i]();
            console.log(">> fired");    
          }.bind(this)
        })
      
     
    }catch(e){ console.log(e)}

    window.jqLoaded.subscribe(function(){
        
    })
    </script>
  <body class="staged">
    <script>
       /*var script = document.createElement('script');
      script.onload =window.jqLoaded.fire;
      script.src = "js/jquery-3.3.1.min.js";
      document.body.appendChild(script);
      window.jqLoaded.subscribe(function(){    
        var script = document.createElement('script');
   
      script.src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js";
      document.body.appendChild(script);
          
      var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js";
   document.body.appendChild(script);

   var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js";
   document.body.appendChild(script);

   var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js";
   document.body.appendChild(script);
   var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js";
   document.body.appendChild(script);

   var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js";
   document.body.appendChild(script);

   var script = document.createElement('script');
   
   script.src = "https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js";
   document.body.appendChild(script);
      });*/
        </script>
@csrf
      <div class="nav-bar">
        <ul>
            <li>
              <a href="/admin/central?section=Products">  Produse </a>
            </li>
            <li>
              <a href="/admin/central?section=Ref_Product_Types">  Tipuri Produse </a>
            </li>

            <li>
                <a href="/admin/central?section=Orders">    Comenzi
                </a>   </li>

            <li>
                <a href="/admin/central?section=Payments">
                Plati
                </a>
            </li>

            <li>
                <a href="/admin/central?section=Customers">
                Useri
                </a>
            </li>

            <li> 
                <a href="/admin/central?section=Tags">
                Colectii
                </a>
            </li>
            <li> 
              <a href="/admin/central?section=Sizes">
              Marimi
              </a>
          </li>
            <li> 
                <a href="/admin/central?section=Invoices">
                Facturi
                </a>
            </li>
            <li>
              <a href="/admin/central?section=Shipments">  Livrari </a>
            </li>
        </ul>
      </div>

      <div class="content">

        @if($table=="Products")
          <a href="/admin/createProd">creeaza produs</a>
        @endif
       
        <div>
          <table>
              <thead>
                  @foreach ($columns as $column)
                      <th style=""> {{$column}} </th>
                  @endforeach 
      
                  <th class="ed"> Details </th>
      
              </thead>
              <tbody>
              @foreach ($entries as $entry)
                <tr>
                      @foreach ($entry as $cell)
                          <td> {{$cell}} </td>
                      @endforeach
                    @if($table == "Tags"||$table == "Sizes"|| $table == "Ref_Product_Type")
                      <td> <a href="/admin/delete{{$table}}?key={{((array)$entry)[array_keys((array)$entry)[0]]}}"> Sterge </a> </td>
                     @elseif($table =="Customers")
                      <td> <a href="/admin/accessUser?customer_id={{$entry->customer_id}}" target="_blank"> Acceseaza </a>
                        <a style="color:lime" href="/admin/resetUser?customer_id={{$entry->customer_id}}"> Reseteaza Parola </a>
                      </td>
                     
                     @else
                      <td> <a href="/admin/details?table={{$table}}&keycode={{$columns[0]}}&key={{((array)$entry)[$columns[0]]}}"> Details </a> </td>
                    @endif
                </tr>
              @endforeach
              </tbody>

          </table>
          
          <style>
                 .presented{
               text-align: center;
            width:50%;
             margin:0 auto;
           }
            </style>
          @if($table == "Tags")
          <div class="presented"> Adauga Eticheta </div>
          <div class="insert insert-tags presented">
              
              <input type="text" placeholder="Numele etichetei">
              <button class="add-tag"> Adauga Eticheta</button>
          </div>


        
          @elseif($table == "Sizes")
            <div class="presented"> Adauga Marime </div>
            <div class="insert insert-tags presented">
                <input type="text" class="marime" placeholder="Marime">
                <input type="text"  class="desc" placeholder="Descriere">
                <button class="add-size"> Adauga Marime</button>
            </div>

            @elseif($table == "Ref_Product_Types")
            <div class="presented"> Adauga Tip produs </div>
            <div class="insert insert-tags presented">
              <input type="text" class="desc-type"   placeholder="descriere tip produs">
                <input type="text" class="nume-type"   placeholder="Nume tip produs">
                <button class="add-prodt"> Adauga tip produs</button>
            </div>
          @endif
      </div>
      </div>

    </body>
    <style>
        .nav-bar ul{
            list-style-type: none;

            top:0;
            left:0;
            display:block;
     
            padding-bottom:20px;
            border-bottom:1px solid black;
           }
           .nav-bar li{
               display: inline-block;
               width: calc(100% / 10.5);
               text-align: center;
           
           }
           .nav-bar a{
                color:black;
                text-decoration: none;
           }
           .nav-bar a:hover{
               color:red;
           }
           .content{
               margin-top:71px;
               width:100%;
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
        </style>
 <script>
               $(document).ready(function(ev){
                $('table').DataTable();

          
            $('.add-tag').on('click',function(ev){
                var etc =  $(this).siblings().val();

                if(etc != 0){
                    $.ajax({
                        url:"/admin/createTag",
                        type:"post",
                        data:{tag:etc,_token:$('input[name="_token"]').val()},
                        success:function(data){
                            if(data.scs){
                                alert("eticheta adaugata");
                                $(this).siblings().val(0);
                                $(this).siblings().attr("value",0);
                                window.location.reload();
                            }else {
                                console.log(data.reason);
                                alert("eticheta nu a fost adaugata \n"+data.reason);
                                
                            }
                        }
                        ,error:function(data){
                              alert("erroare la adaugarea etichetei (vezi consola)");
                              console.log(data);
                        }
                    })
                }
              });

              $('.add-prodt').on('click',function(ev){
                var etc =  $(this).siblings().val();

                if(etc != 0){
                    $.ajax({
                        url:"/admin/createprodt",
                        type:"post",
                        data:{prodt:$('.nume-type').val(),desc:$('.desc-type').val(),_token:$('input[name="_token"]').val()},
                        success:function(data){
                            if(data.scs){
                                alert("tip produs adaugat");
                               
                                window.location.reload();
                            }else {
                                console.log(data.reason);
                                alert("tipul nu a fost adaugat \n"+data.reason);
                                
                            }
                        }
                        ,error:function(data){
                              alert("erroare la adaugarea tipului (vezi consola)");
                              console.log(data);
                        }
                    })
                }
              });

              $('.add-size').on('click',function(ev){
                var etc =  $(this).siblings().val();

                if(etc != 0){
                    $.ajax({
                        url:"/admin/createSize",
                        type:"post",
                        data:{size:$('.marime').val(),desc:$('.desc').val(),_token:$('input[name="_token"]').val()},
                        success:function(data){
                            if(data.scs){
                                alert("eticheta adaugata");
                                $(this).siblings().val(0);
                                $(this).siblings().attr("value",0);
                                window.location.reload();
                            }else {
                                console.log(data.reason);
                                alert("marime nu a fost adaugata \n"+data.reason);
                                
                            }
                        }
                        ,error:function(data){
                              alert("erroare la adaugarea marime (vezi consola)");
                              console.log(data);
                        }
                    })
                }
              });
   
   
            });
 </script>
</html>