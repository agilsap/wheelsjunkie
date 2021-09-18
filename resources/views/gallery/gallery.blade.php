@include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="justify-content-center">Product Gallery - {{$product->product_name}}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fas fa-check"></i>
                    <strong> {{ session()->get('success') }} </strong>
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
                        <form action="{{route('gallery.store',$product->product_id)}}"
                            class="form-image-upload" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <strong>Add Image:</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <div class="custom-file ">
                                            <input type="file" name="image[]" id="image"
                                                class="custom-file-input form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                                multiple required>
                                            <label for="image" class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                    @if ($errors->has('image'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-brand-reverse btn-block">Upload</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{route('gallery.destroy',$product->product_id)}}" method="POST">
                            <div class="list-group gallery">
                                <div class='row pt-3'>
                                    @csrf
                                    @foreach($pictures as $picture)
                                    <div class='col-lg-4'>
                                        {{$picture->picture}}
                                        <div class="d-flex flex-col">
                                            @if ($picture->selected == 0)
                                            <div class="icheck-primary mt-3 ml-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="pic{{$picture->gallery_id}}" name="images[]"
                                                    value="{{$picture->gallery_id}}">
                                                <label class="form-check-label" for="pic{{$picture->gallery_id}}">
                                                </label>
                                            </div>
                                            @endif
                                            <a class="thumbnail fancybox" rel="ligthbox"
                                                href=""
                                                onclick="return confirm('Apakah anda yakin ingin memilih foto ini untuk thumbnail property?')">
                                                <img class="img-fluid imgProp mx-auto d-block" alt=""
                                                    src="{{asset('img/images/products/'.$picture->picture)}}">
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-danger">Delete Picture</button>
                                </div>
                            </div>
                        </form>
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
    <script type="application/javascript">
    $('input[type="file"]').change(function(e){
        let label = "";
        let count = 0;
        let files = Array.from(this.files);
        files.map(file => {
            if(count == files.length-1){
                label = label+file.name;
            }else{
                label = label+file.name+', ';
            }
            count++;
        });
        $('.custom-file-label').html(label);
    });
</script>
</body>

</html>