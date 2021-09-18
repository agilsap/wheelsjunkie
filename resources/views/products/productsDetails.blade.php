@include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="{{asset('asset/Navbar_logo.png')}}" alt="AdminLTELogo">
        </div>

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="justify-content-center">Product Details</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                @if ($sukses)
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fas fa-check"></i>
                    <strong> {{$sukses}} </strong>
                </div>
                @endif
                @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fas fa-exclamation-triangle"></i>
                    <strong> {{ session()->get('error') }} </strong>
                </div>
                @endif
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-11">
                                <h3><strong>{{$product->product_name}}</strong></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <a href="{{route('gallery.index',$product->product_id)}}">
                                        <div class="picture-overlay-container">
                                            <img class="img-fluid d-block image-overlayed"
                                                src="{{asset('img/images/products/'.$product->product_thumbnail)}}" />
                                            <div class="picture-overlay-middle">
                                                <div class="picture-overlay-text">
                                                    ADD PICTURES
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="row justify-content-between mt-3">
                                    <input type="text" value=0 id ='index' hidden>
                                    <div class="col-md-1 my-auto card py-5" onclick="slideThumbnails(-1)">
                                        <div class="row mx-auto">
                                            <
                                        </div>
                                    </div>
                                    @foreach ($product_images as $key => $thumbnail)
                                    <div class="col-md-3 elevation-2 mx-1" id={{$key}} name="images" style="display:none;">
                                        <a href="{{route('gallery.showGallery',$thumbnail->gallery_id)}}" class="">
                                            <img src="{{asset('/img/images/products/'.$thumbnail->picture)}}"
                                                class="img-fluid d-block">
                                        </a>
                                    </div>
                                    @endforeach
                                    <div class="col-md-1 my-auto card py-5" onclick="slideThumbnails(+1)">
                                        <div class="row mx-auto">
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="justify-text">{{$product->description}}</p>
                            </div>
                            <div class="col-md-4 card">
                                <div class="card-body">
                                    <form action="{{route('products.quickUpdate',$product->product_id)}}" method="POST">
                                        @csrf
                                        <div class="mb-2 row">
                                            <label class="col-md-12 ml-0">Quantity ({{$product->unit}})</label>
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button id="btnD" class="btn btn-outline-primary btn-minus"
                                                            type="button">&minus;</button>
                                                    </div>
                                                    <input name="quantity" type="text" id="quantity"
                                                        class="form-control text-center" value={{$product->quantity}}>
                                                    <div class="input-group-append">
                                                        <button id="btnI" class="btn btn-outline-primary btn-plus"
                                                            type="button">&plus;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="col-md-12 ml-0">Condition</label>
                                            <div class="col-md-12">
                                                <select
                                                    class="custom-select {{ $errors->has('condition') ? 'is-invalid' : '' }}"
                                                    name="condition" id="condition" required>
                                                    <option value="" {{(old('condition') == '') ? 'selected' : ''}}
                                                        disabled>
                                                        Choose One
                                                    </option>
                                                    <option value="0" {{($product->condition == 'New') ? 'selected=true' : ''}}>
                                                        New</option>
                                                    <option value="1" {{($product->condition == 'Used') ? 'selected=true' : ''}}>
                                                        Used</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary col-md-3 row ml-0">Save
                                            Updates</button>
                                        <div class="mt-5 row">
                                            <div class="col-md-12">
                                                <a class="btn btn-warning text-white btn-flat"
                                                    href="{{route('products.edit',$product->product_id)}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a class="btn btn-flat {{$product->is_deleted ? "btn-default" : "btn-danger"}}"
                                                    href="{{route('products.delete',$product->product_id)}}"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                    {{$product->is_deleted ? "Show" : "Delete"}}
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong><a href="/">WheelsJunkie.com </a></strong>
        </footer>
    </div>
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.js')}}"></script>
    <script src="{{asset('dist/js/demo.js')}}"></script>
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
    <script>
        $('#btnD').on('click', function(){
          var qty = $('#quantity').val();
          if(qty>0){
              $('#quantity').val(parseInt($('#quantity').val()) - 1);
          }
        });
        $('#btnI').on('click', function(){
                $('#quantity').val(parseInt($('#quantity').val()) + 1);
        });
        window.on('load',slideThumbnails(0));
        function slideThumbnails(move){
            var images = document.getElementsByName('images');
            var index = parseInt($('#index').val());
            if(index<=0){
                index = 0;
            }
            var newIndex = index + move;
            if(newIndex<0){
                newIndex=0;
            }
            if(newIndex>(images.length/3)){
                newIndex = index;
            }
            var rangeR = ((newIndex+1)*3)-1;
            var rangeL = rangeR-2;
            if(images.length < 4){
                rangeR = 2;
                rangeL = 0;
                newIndex = 0;
            }
            console.log(images,index,newIndex,rangeL, rangeR, images.length);
            for(var i = 0; i<images.length; i++){
                if(i<=rangeR && i>=rangeL){
                    images[i].style.display="block";
                }else{
                    images[i].style.display = "none";
                }
            }
            $('#index').val(parseInt(newIndex));
        }
    </script>
</body>

</html>