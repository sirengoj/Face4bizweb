
@extends('layouts.back-end.app-seller')
@section('title','Shop Edit')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Custom styles for this page -->
     <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <style>
        @media(max-width:375px){
         #shop-image-modal .modal-content{
           width: 367px !important;
         margin-left: 0 !important;
     }
    
     }

@media(max-width:500px){
 #shop-image-modal .modal-content{
           width: 400px !important;
         margin-left: 0 !important;
     }
   
   
}
 </style>
@endpush
@section('content')
    <!-- Content Row -->
    <div class="content container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0 ">Edit Shop Info</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('seller.shop.update',[$shop->id])}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{$shop->name}}" class="form-control" id="name"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Contact <span class="text-danger">*</span></label>
                                    <input type="text" name="contact" value="{{$shop->contact}}" class="form-control" id="name"
                                           required>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea type="text" rows="4" name="address" value="" class="form-control" id="address"
                                   required>{{$shop->address}}</textarea>
                        </div>


                        <center>
                            <div class="form-group" id="select-img">
                                <button type="button" class="btn btn-secondary text-light" data-toggle="modal" style="width: 100%"
                                        data-target="#shop-image-modal" data-whatever="@mdo"
                                        id="image-count-shop-image-modal">
                                        <i class="tio-add-circle"></i> Image Upload
                                </button>
                            </div>
                        </center>

                        <button type="submit" class="btn btn-primary" id="btn_update">Update</button>
                        <a class="btn btn-danger" href="{{route('seller.shop.view')}}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'shop-image-modal'])
    <!--modal-->
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
   



    @include('shared-partials.image-process._script',[
     'id'=>'shop-image-modal',
     'height'=>300,
     'width'=>300,
     'multi_image'=>false,
     'route'=>route('image-upload')
     ])
   

@endpush
