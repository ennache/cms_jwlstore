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

<div>
  
    <div class="grid">
        <?php $i = 0; ?>
        @foreach ($columns_prod as $column)
        <div class="blocks">

        <label prod_id="{{$prod->product_id}}" style="margin:0 auto;">{{$column}}</label><br>
        @if($i == 0) <textarea readonly name="{{$column}}">{{$prod->$column}}</textarea>    
            @else
        <textarea name="{{$column}}">{{$prod->$column}}</textarea>
            @endif
            <?php $i++ ?>
       </div>
        @endforeach

        <div class="blocks save" style="cursor:pointer;transition:.5s ease">
            <span style="margin-top:10%; display:block"> Salveaza modificari produs </span>
        </div>
        <style>
            .save:hover{
               box-shadow: 0px 0px 50px -15px red!important;
            }
            </style>
      </div>
    <table>  <?php $prop_arr = count($tags)>0?array_keys((array)$tags[0]):array();  ?>
        <thead>
            @foreach ($prop_arr as $prop)
                <th> {{$prop}} </th>
            @endforeach
          
            <th class="del">  </th>
        </thead>
        <tbody>
          
          @foreach ($tags as $tag)
             <tr>
                 <?php $i = 0; ?>
                @foreach ($tag as $prop)
                        <td>  
                                {{$prop}} 
                      
                        </td>
                       
                 <?php $i++; ?> 
                @endforeach
            
                <td onclick="stergeEt(this)" class="tbl-btn" tag_id="{{$tag->id}}"  > Sterge </td>
             </tr>
         @endforeach
        
        </tbody>
    </table>

    <div style="border:1px solid red; float:left;font-size:20px; padding-right:20px;">
        <h3> Etichete existente </h3>
     <ul>
         @foreach ($tags_standalone as $item)
         <li>{{$item->id}} {{$item->name}}
         </li>
         @endforeach
     </ul>
    
    
    </div>
    <div class="presented"> Adauga eticheta </div>
    <div class="insert insert-tags presented">
        <input type="number" min="0">
        <button class="add-tag"> Adauga eticheta</button>
    </div>

    

    <table>  <?php $prop_arr = count($sizes)>0?array_keys((array)$sizes[0]):array();  ?>
        <thead>
            @foreach ($prop_arr as $prop)
                <th> {{$prop}} </th>
            @endforeach
            <th > </th> 
            <th class="del">  </th>
        </thead>
        <tbody>
          
          @foreach ($sizes as $size)
             <tr>
                 <?php $i = 0; ?>
                @foreach ($size as $prop)
                        <td>  
                              @if($i != 2)  {{$prop}}
                                 @else
                                  <input value="{{$prop}}" type="number" class="qt">
                                  @endif
                      
                        </td>
                       
                 <?php $i++; ?> 
                @endforeach
                    <td class="tbl-btn" size_id="{{$size->size_id}}" prod_id="{{$prod->product_id}}"  onclick="saveSize(this)"> Salveaza
                <td class="tbl-btn" size_id="{{$size->size_id}}" prod_id="{{$prod->product_id}}"   onclick="delSize(this)"> Sterge </td>
             </tr>
         @endforeach
        
        </tbody>
    </table>

    <div style="border:1px solid red; float:left;font-size:20px; padding-right:20px;">
        <h3> Id-uri si marimi </h3>
     <ul>
         @foreach ($sizes_standalone as $item)
         <li>{{$item->size_id}} {{$item->size}}
         </li>
         @endforeach
     </ul>
    
    
    </div>
    <div class="presented"> Adauga marime </div>
    <div class="insert insert-tags presented">
        <input type="number" min="0" placeholder="ID">
        <input type="number" min="0" placeholder="CANTITATE">
        <button class="add-size"> Adauga marime</button>
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
            form.action = "http://localhost:8000/admin/updateprods";
            form.method = "POST"
            form.style.opacity = "0";
            form.appendChild($('input[name="_token"]').clone()[0]);
            $(this).siblings().find('textarea,input').toArray().forEach(function(element,index){
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
                url: "http://localhost:8000/admin/updateprods",// where you wanna post
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
     function stergeEt(element){
         element = $(element);
         $.ajax({
             url:"/admin/rmtag",
             type:"post",
             data:{
                 tag:element.attr("tag_id"),
                 _token:$('input[name="_token"]').val(),
                 prod:"{{$prod->product_id}}"
             }
             ,success:function(data){
                if(data.scs){
                       alert("eticheta stearsa");
                
                       window.location.reload();
                   }else {
                       console.log(data.reason);
                       alert("eticheta nu a fost stearsa \n"+data.reason);
                       
                   }
             },error:function(data){
                alert("erroare la stergerea etichetei (vezi consola)");
                    console.log(data);
             }
         })
     }   
    $('.add-tag').on('click',function(ev){
       var etc =  $(this).siblings().val();

       if(etc != 0){
           $.ajax({
               url:"/admin/addtag",
               type:"post",
               data:{tag:etc,prod:"{{$prod->product_id}}",_token:$('input[name="_token"]').val()},
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

    $('.add-size').on('click',function(ev){
        $.ajax({
               url:"/admin/addsize",
               type:"post",
               data:{size:$(this).siblings().first().val(),qt:$(this).siblings().last().val(),prod:"{{$prod->product_id}}",_token:$('input[name="_token"]').val()},
               success:function(data){
                   if(data.scs){
                       alert("marime adaugata");
                       $(this).siblings().val(0);
                       $(this).siblings().attr("value",0);
                       window.location.reload();
                   }else {
                       console.log(data.reason);
                       alert("marimea nu a fost adaugata \n"+data.reason);
                       
                   }
               }
               ,error:function(data){
                    alert("erroare la adaugarea marimea (vezi consola)");
                    console.log(data);
               }
           })
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


