@extends('layouts.base')

@section('content')

<div style="border:1px solid red; float:left;font-size:20px; padding-right:20px;">
    <h3> Tipuri produse <br> (pentru product_type_code) </h3>
 <ul>
     @foreach ($product_types as $item)
     <li>{{$item->product_type_code}} {{$item->product_type_category}}
     </li>
     @endforeach
 </ul>


</div>

<div class="payload">
  
    <div class="grid">
        <?php $i = 0; ?>
        @foreach ($columns_prod as $column)
        <div class="blocks">

        <label style="margin:0 auto;">{{$column}}</label><br>
        @if($i == 0) <textarea readonly name="{{$column}}"></textarea>    
            @else
        <textarea name="{{$column}}"></textarea>
            @endif
            <?php $i++ ?>
       </div>
        @endforeach

        <div class="blocks save" style="cursor:pointer;transition:.5s ease">
            <span style="margin-top:10%; display:block"> Creeaza produs </span>
        </div>
        <style>
            .save:hover{
               box-shadow: 0px 0px 50px -15px red!important;
            }
            </style>
      </div>
 
      <br>
    <div style="border:1px solid red; float:right;font-size:20px; padding-right:20px;">
        <h3> Etichete existente </h3>
     <ul>
         @foreach ($tags_standalone as $item)
         <li>{{$item->id}} {{$item->name}}
         </li>
         @endforeach
     </ul>
    <br>
    
    </div>
    <div class="presented"> Adauga etichete separate prin virgula (ex: 5,2,4,6,7) </div>
    <div class="insert insert-tags presented">
        <input type="text" name="tags" >
       
    </div>

    
    


    <div style="border:1px solid red; float:left;font-size:20px; padding-right:20px;">
        <h3> Id-uri si marimi </h3>
     <ul>
         @foreach ($sizes_standalone as $item)
         <li>{{$item->size_id}} {{$item->size}}
         </li>
         @endforeach
     </ul>
    
    
    </div>
    <div class="presented"> Adauga marimi (id-uri separate cu virgula si cantitatile corespunzatoare separate cu virgula) </div>
    <div class="insert insert-tags presented">
        <input type="text" name="size_ids"  placeholder="5,7,2,3,4,1">
        <input type="text" name="size_qt"  placeholder="10,23,45,22,1,5">
     
    </div>
</div>
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
    </style>
@csrf
@endsection

@section('scripting')
    <script>

        
        
        $('.save').on('click',function(ev){
          
            var form = document.createElement('form');
            form.action = "http://localhost:8000/admin/createprods";
            form.method = "POST"
            form.style.opacity = "0";
            form.appendChild($('input[name="_token"]').clone()[0]);
            $('.payload').find('textarea,input').toArray().forEach(function(element,index){
                if(element.type == "textarea" && false){
                       var input = document.createElement('input');
                        input.name = element.attributes.name;
                    input.value = element.value;

                form.appendChild($(input).clone()[0]);
                }else{

                    form.appendChild($(element).clone()[0]);
                }
                console.log(element);
            });

            var formData = new FormData(form);
            window.form = formData;
            console.log(formData.keys());
            $.ajax({
                type: "POST",
                url: "http://localhost:8000/admin/createprods",// where you wanna post
                data: formData,
                processData: false,
                contentType: false,
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage); // Optional
                    alert("Erroare la ajax", "vezi consola");
                },
                success: function(data) {console.log(data)
                    if(data.scs){
                        window.location.reload();
                    }else{
                        alert(data.reason);
                    }
                }
            })

           //form.submit();

        })
    
     
 

  


               var labels =  $('label').filter(function(index,element){
                    return element.innerHTML.includes("image");
                })

                console.log(labels);
                var content = labels.parent().find('textarea');
                labels.each(function(index,element){
                    if($(element).parent().find('textarea').val()){

                        var img = document.createElement('img');
                        img.classList.add("prev");
                        img.style.maxWidth = "200px";
                        img.title ="Poza mica";
                        img.src = "http://localhost:8000/images/products/product_"+$(element).attr("prod_id")+"/small/"+$(element).parent().find('textarea').val();
                        $(element).parent().append(img);
                        var file_input_small= document.createElement('input');
                        file_input_small.type= "file";
                        file_input_small.name= element.innerHTML+"_small";
                        file_input_small.title = "AICI PUI POZA MICA";
                        file_input_small.accept = 'accept="image/*';
                        $(element).parent().append(file_input_small);

                        var img = document.createElement('img');
                        img.classList.add("prev");
                        img.style.maxWidth = "200px";
                        img.title ="Poza mare";
                        img.src = "http://localhost:8000/images/products/product_"+$(element).attr("prod_id")+"/"+$(element).parent().find('textarea').val();
                        $(element).parent().append(img);

                        var file_input_large= document.createElement('input');
                        file_input_large.type= "file";
                        file_input_large.name= element.innerHTML+"_large";
                        file_input_large.title = "AICI PUI POZA MARE";
                        file_input_large.accept = 'accept="image/*';

                        $(element).parent().append(file_input_large);
                       
                    }else{

                        var file_input_small= document.createElement('input');
                        file_input_small.type= "file";
                        file_input_small.name= element.innerHTML+"_small";
                        file_input_small.title = "AICI PUI POZA MICA";
                        file_input_small.accept = 'accept="image/*';
                        $(element).parent().append(file_input_small);

              
                    var file_input_large= document.createElement('input');
                    file_input_large.type= "file";
                    file_input_large.name= element.innerHTML+"_large";
                    file_input_large.title = "AICI PUI POZA MARE";
                    file_input_large.accept = 'accept="image/*';

                    $(element).parent().append(file_input_small);
                    $(element).parent().append(file_input_large);
                    
                    }
                    $(element).parent().find('textarea').remove();

                })
         
         $('table').DataTable();


         function saveSize(element){
             var size_id = $(element).attr("size_id");
             var prod_id = $(element).attr("prod_id");
             window.rst = $(element).siblings()[2]
            element = $($(element).siblings()[2]);
            
            if(element.find("input").val() > 0){

                var qt = element.find("input").val();
                $.ajax({
                    url:"/admin/updatesize",
                    type:"post",
                    data:{size:size_id,prod:prod_id,
                          qt:qt,_token:$('input[name="_token"]').val()},
                    success:function(data){
                        if(data.scs){
                            alert("marime updatata");
                            $(this).siblings().val(0);
                            $(this).siblings().attr("value",0);
                            window.location.reload();
                        }else {
                            console.log(data.reason);
                            alert("marimea nu a fost updatata \n"+data.reason);
                            
                        }
                    },
                    error:function(data){
                        alert("erroare la updatarea marimii (vezi consola)");
                    console.log(data);
                    }
                })
            }
         }
         function delSize(element){
            var size_id = $(element).attr("size_id");
             var prod_id = $(element).attr("prod_id");
             window.rst = $(element).siblings()[2]
            element = $($(element).siblings()[2]);
            
       
                $.ajax({
                    url:"/admin/rmsizes",
                    type:"post",
                    data:{size:size_id,prod:prod_id,
                        _token:$('input[name="_token"]').val()},
                    success:function(data){
                        if(data.scs){
                            alert("marime stearsa");
                            $(this).siblings().val(0);
                            $(this).siblings().attr("value",0);
                            window.location.reload();
                        }else {
                            console.log(data.reason);
                            alert("marimea nu a fost stearsa \n"+data.reason);
                            window.location.reload();
                            
                        }
                    },
                    error:function(data){
                        alert("erroare la stergerea marimii (vezi consola)");
                    console.log(data);
                    }
                })
            
         }  
    </script>
@endsection


