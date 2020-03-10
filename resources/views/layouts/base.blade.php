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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="css/fixedHeader.bootstrap4.css">
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="/js/data-table.js" type="text/javascript"></script>

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
        @section('content')
        @show
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
        </style>
 @section('scripting')

 @show
</html>