<!DOCTYPE html>
<html lang="en">
<!-- header -->
   <head>
      <!-- csrf token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
      <title>Practical</title>
      <!-- js and css cdn -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
      <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

     <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css"/>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
     <!-- end js and css -->
   </head>
   <!-- body -->
   <body>
      <div class="container">
      </br>
         <div>
            <h4 style="float:left;">User List</h4>
            <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-product" style="float: right;" >Add New</a>
         <br><br></br><br>
            
         </div>
         <!-- user listing view -->
         <table class="table table-bordered table-striped" id="laravel_datatable">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>File</th>
                  <th>Created at</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
              @foreach($user as $u)
              <tr id="user_{{ $u->id }}">
                <td>{{ $u->id }}</td>
                <td>
                  <img src="{{URL::to('user')}}/{{ $u->image }}" height="50px" width="50px">
                </td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->phone }}</td>
                <td>@if($u->gender == 1) Male @elseif($u->gender == 2) female @else other @endif </td>
                <td>@if($u->file) <a href="{{URL::to('user')}}/{{ $u->file }}" target="_blank">download</a> @else - @endif
                </td>
                <td>{{ $u->created_at }}</td>
                <td><a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{ $u->id }}" data-original-title="Edit" class="edit btn btn-success edit-product">
                    Edit
                </a>
                <a href="javascript:void(0);" id="delete-product" data-toggle="tooltip" data-original-title="Delete" data-id="{{ $u->id }}" class="delete btn btn-danger">
                    Delete
                </a></td>
              </tr>
              @endforeach
            </tbody>
         </table>
      </div>
      <!-- end user listing view -->

      <!-- add edit popup box -->
      <div class="modal fade" id="ajax-product-modal" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="productCrudModal"></h4>
                  <a class="close" href="#">×</a>
               </div>
               <div class="modal-body">
                  <div class="alert alert-danger print-error-msg" style="display:none">
                     <ul></ul>
                  </div>
                  <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                     <input type="hidden" name="user_id" id="user_id">
                     <div class="row">
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="" >
                           <div id="name-error" style="display: none;" class="danger">Please Enter Name</div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                           <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="" >
                           <div id="email-error" style="display: none;" class="danger">Please Enter Email</div>
                        </div>
                     </div>
                     </div>
                     <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label">phone</label>
                        <div class="col-sm-12">
                           <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="" required="" >
                           <div id="email-error" style="display: none;" class="danger">Please Enter Phone</div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-12">
                           <input type="radio" id="male" name="gender" value="1">
                           <label for="html">Male</label>
                           <input type="radio" id="female" name="gender" value="2">
                           <label for="html">Female</label>
                           <input type="radio" id="other" name="gender" value="3">
                           <label for="html">Other</label>
                           <div id="gender-error" style="display: none;" class="danger">Please select</div>
                        </div>
                     </div>
                     </div>
                     <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-12">
                           <input id="image" type="file" name="image" accept="image/*" onchange="readURL(this);">
                           <input type="hidden" name="hidden_image" id="hidden_image">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-12 control-label">preview Image</label>
                        <div class="col-sm-12">
                           <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="form-group hidden" width="70" height="70">
                        </div>
                     </div>
                     </div>
                     <div class="row">
                     <div class="form-group">
                        <label class="col-sm-2 control-label">File</label>
                        <div class="col-sm-12">
                           <input id="file" type="file" name="file" accept="file/*">
                        </div>
                        <div id="modal-file"></div>
                     </div>
                     </div>
                     <div class="col-sm-offset-0 col-sm-12">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create" style="float:right">Save changes
                        </button>
                     </div>
                  </form>
               </div>
               <div class="modal-footer"></div>
            </div>
         </div>
      </div>
   </body>
</html>
<!-- start cutome js or js functional and ajax call -->
<script>
   $(document).ready(function () {
      $('#laravel_datatable').DataTable();
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
   });

  var SITEURL = '{{URL::to('')}}';

   /*  When user click add user button */
   $('#create-new-product').click(function () {
      $('#btn-save').val("create-product");
      $('#user_id').val('');
      $('#productForm').trigger("reset");
      $('#productCrudModal').html("Add New User");
      $('#ajax-product-modal').modal('show');
      $('#modal-preview').attr('src', 'https://via.placeholder.com/150');
   });

   $(function (event) { 
      $('body').on('submit', '#productForm', function (e) {
            e.preventDefault();
            var actionType = $('#btn-save').val();
            $('#btn-save').html('Sending..');
            var formData = new FormData(this);
            $.ajax({
               type:"post",
               url: "{{ url('user-list/store') }}",
               data: formData,
               cache:false,
               contentType: false,
               processData: false,
               success: function (response) {
                   if($.isEmptyObject(response.error)){
                     $('#ajax-product-modal').modal('hide');
                     swal("Data Submit successfully", "You clicked the button!", "success");
                     location.reload();
                  }else{
                     swal("Somthing Wrong", "Please check the error message!", "error");
                    printErrorMsg(response.error);
                  }
               }
            });
      });
   });  
   /*error show*/
   function printErrorMsg (msg) {
     $(".print-error-msg").find("ul").html('');
     $(".print-error-msg").css('display','block');
     $.each( msg, function( key, value ) {
         $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
     });
   }

   /* When click edit user */
   $('body').on('click', '.edit-product', function () {
      var html = "";
      $("#modal-file" ).append(html);
      var user_id = $(this).data('id');
      $.get('user-list/' + user_id +'/edit', function (data) {
         $('#productCrudModal').html("Edit User");
         $('#btn-save').val("edit-product");
         $('#ajax-product-modal').modal('show');
         $('#user_id').val(data.id);
         $('#name').val(data.name);
         $('#email').val(data.email);
         $('#phone').val(data.phone);
         if(data.gender == 1){
            $("#male").attr('checked', 'checked');
         } else if(data.gender == 2){
            $("#female").attr('checked', 'checked');
         } else {
            $("#other").attr('checked', 'checked');
         }
         $('#phone').val(data.phone);
         $('#modal-preview').attr('alt', 'No image available');
         if(data.image){
            $('#modal-preview').attr('src', SITEURL +'/user/'+data.image);
            $('#hidden_image').attr('src', SITEURL +'/user/'+data.image);
         }
         if(data.file){
            var filename = SITEURL +'/file/'+data.file;
            $("#modal-file" ).append("<a href="+filename+" target='_blank' >Downoad File</a>" );
         }
      })
   });

   $('body').on('click', '#delete-product', function () {
      var user_id = $(this).data("id");
      if(confirm("Are You sure want to delete !")){
         $.ajax({
            type:"post",
            url: "{{ url('user-list/delete/') }}",
            data: {'id':user_id},
            success: function (response) {
                $('#user_'+user_id).remove();
                swal("Record Deleted Successfully", "You clicked the button!", "success");
            }
         });
      }
   });  

   function readURL(input, id) {
      id = id || '#modal-preview';
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
         $(id).attr('src', e.target.result);
         };
         reader.readAsDataURL(input.files[0]);
         $('#modal-preview').removeClass('hidden');
         $('#start').hide();
      }
   }
   
</script>