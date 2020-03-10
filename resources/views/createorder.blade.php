@extends('layouts.base')

@section('content')

<div class="payload">
    <div class="grid">
        <?php $i = 0; ?>
       
        <div class="blocks">

        <label style="margin:0 auto;"> Email </label><br>
        <textarea name=""></textarea>    
        
       </div>

       
       

        
        <style>
            .save:hover{
               box-shadow: 0px 0px 50px -15px red!important;
            }
        </style>
      </div>
</div>

<div class="blocks save" style="cursor:pointer;transition:.5s ease">
    <span style="margin-top:10%; display:block"> Creeaza comanda </span>
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

</script>

@endsection
     