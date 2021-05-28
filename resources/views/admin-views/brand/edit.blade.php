@extends('layouts.back-end.app')
@section('title','Brand Edit')
<style>
    #brand-image-modal .modal-content{
             width: 1116px !important;
           margin-left: -264px !important;
       }
      
       @media(max-width:768px){
           #brand-image-modal .modal-content{
               width: 698px !important;
   margin-left: -75px !important;
       }
       
     
       }
       @media(max-width:375px){
           #brand-image-modal .modal-content{
             width: 367px !important;
           margin-left: 0 !important;
       }
      
       }

  @media(max-width:500px){
   #brand-image-modal .modal-content{
             width: 400px !important;
           margin-left: 0 !important;
       }
     
      }
  }
</style>
@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Brand Update</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{ trans('messages.brand_update')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.brand.update',[$b['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="name">{{ trans('messages.name')}}</label>
                                    <input type="text" name="name" value="{{$b['name']}}" class="form-control" id="name"
                                           placeholder="Ex : LUX">
                                </div>
                                <div class="col-md-2">
                                    <label for="brand">{{ trans('messages.brand_logo')}}</label><br>
                                    <button type="button" class="btn bg-secondary text-light btn-sm" data-toggle="modal"
                                            data-target="#brand-image-modal" data-whatever="@mdo"
                                            id="image-count-brand-image-modal">
                                            <i class="tio-add-circle"></i> Upload
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">{{ trans('messages.image')}}</label><br>
                            <img onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                width="200" src="{{asset('storage/app/public/brand')}}/{{$b['image']}}">
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'brand-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    @include('shared-partials.image-process._script',[
    'id'=>'brand-image-modal',
    'height'=>400,
    'width'=>800,
    'multi_image'=>false,
    'route'=>route('image-upload')
    ])
@endpush
