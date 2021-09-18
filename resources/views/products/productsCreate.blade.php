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
                            <h1 class="justify-content-center">Add a New Product</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="container-fluid containCust">
                    <div class="card ">
                        <form class="form-horizontal" method="POST" id="createForm" action="{{route('products.store')}}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header bg-dark ">
                                <h3 class="card-title cardTitle">Product Information</h3>
                            </div>
                            <div class="card-body ">
                                <!-- product_name !-->
                                <div class="form-group row" id="product_name">
                                    <label for="product_name" class="col-md-3 control-label">Product Name<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('product_name')}}" type="text" name="product_name"
                                                id="product_name"
                                                class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }} "
                                                placeholder="Product Name" aria-label="Product Name"
                                                aria-describedby="basic-addon2" required>
                                        </div>
                                        @if ($errors->has('product_name'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('product_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- product_thumbnail !-->
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="product_thumbnail" class="control-label">Product Picture <strong
                                                class="required_red">*</strong></label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div class="custom-file ">
                                                <input type="file" name="product_thumbnail" id="product_thumbnail"
                                                    class="custom-file-input form-control {{ $errors->has('product_thumbnail') ? 'is-invalid' : '' }}"
                                                    required />
                                                <label class="custom-file-label" for="product_thumbnail"
                                                    class="custom-file-label">Choose File</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('product_thumbnail'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('product_thumbnail') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- category !-->
                                <div class="form-group row">
                                    <label for="category" class="col-md-3 control-label">Product Category <strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="btn-group btn-group-toggle btn-toolbar d-flex flex-warp {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                            data-toggle="buttons">
                                            <div
                                                class="btn btn-md btn-outline-primary  {{(old('category') == '') ? 'active' : ''}} {{(old('category') == '0') ? 'active' : ''}}">
                                                <input {{(old('category') == '') ? 'checked' : ''}}
                                                    {{(old('category') == '0') ? 'checked' : ''}} type="radio"
                                                    name="category" id="rims" value="0" autocomplete="off"
                                                    onchange="toggleCategory(this)" required>Rims
                                            </div>
                                            <div
                                                class="btn btn-md btn-outline-primary  {{(old('category') == '1') ? 'active' : ''}}">
                                                <input {{(old('category') == '1') ? 'checked' : ''}} type="radio"
                                                    name="category" id="wheels" value="1" autocomplete="off"
                                                    onchange="toggleCategory(this)">Tires
                                            </div>
                                        </div>
                                        @if ($errors->has('category'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- rim_type !-->
                                <div class="form-group row" id="rim_type_toggle">
                                    <label for="rim_type" class="col-md-3 control-label">Rim Type
                                        <strong class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="btn-group btn-toolbar d-flex flex-warp btn-group-toggle {{ $errors->has('rim_type') ? 'is-invalid' : '' }}"
                                            style="" data-toggle="buttons" id="toggleType">

                                            <div
                                                class="btn btn-md btn-outline-primary {{(old('rim_type') == '') ? 'active' : ''}} {{(old('0') == 'replica') ? 'active' : ''}}">
                                                <input {{(old('rim_type') == '') ? 'checked' : ''}}
                                                    {{(old('rim_type') == '0') ? 'checked' : ''}} type="radio"
                                                    name="rim_type" value="0" id="replica" autocomplete="off"
                                                    required>Replica
                                            </div>
                                            <div
                                                class="btn btn-md btn-outline-primary {{(old('rim_type') == '1') ? 'active' : ''}}">
                                                <input {{(old('rim_type') == '1') ? 'checked' : ''}} type="radio"
                                                    name="rim_type" value="1" id="original" autocomplete="off">Original
                                            </div>
                                            <div
                                                class="btn btn-md btn-outline-primary {{(old('rim_type') == '2') ? 'active' : ''}}">
                                                <input {{(old('rim_type') == '2') ? 'checked' : ''}} type="radio"
                                                    name="rim_type" value="2" id="oem" autocomplete="off">OEM
                                            </div>
                                        </div>
                                        @if ($errors->has('rim_type'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('rim_type') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- price !-->
                                <div class="form-group row">
                                    <label for="price" class="col-md-3 control-label">Price <strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp. </span>
                                            </div>
                                            <input type="text" name="price" id="price"
                                                class="form-control text-left {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                                value="{{old('price')}}" required />
                                        </div>
                                    </div>
                                </div>
                                <!-- weight !-->
                                <div class="form-group row" id="weight_field">
                                    <label for="weight" class="col-md-3 control-label">Total Weight <strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('weight')}}" type="text" name="weight" id="weight"
                                                class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }} "
                                                placeholder="Weight" aria-label="Weight" aria-describedby="basic-addon2"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Kg</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('weight'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('weight') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- quantity !-->
                                <div class="form-group row">
                                    <label for="quantity" class="col-md-3 control-label">Quantity <strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" name="quantity" id="quantity" placeholder="Quantity"
                                                class="form-control text-left {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                                value="{{old('quantity')}}" required />
                                        </div>
                                    </div>
                                    <!-- unit !-->
                                    <div class="col-md-2" id="unit">
                                        <div class="">
                                            <select class="custom-select {{ $errors->has('unit') ? 'is-invalid' : '' }}"
                                                name="unit" required>
                                                <option value="" {{(old('unit') == '') ? 'selected' : ''}} disabled>
                                                    Unit
                                                </option>
                                                <option value="0" {{(old('unit') == '0') ? 'selected' : ''}}>
                                                    Piece(s)</option>
                                                <option value="1" {{(old('unit') == '1') ? 'selected' : ''}}>Set
                                                </option>
                                            </select>
                                        </div>
                                        @if ($errors->has('unit'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('unit') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row" id="rim_diameter_toggle">
                                    <label for="rim_diameter" class="col-md-3 control-label">Rim Diameter<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('rim_diameter')}}" type="text" name="rim_diameter"
                                                id="rim_diameter"
                                                class="form-control {{ $errors->has('rim_diameter') ? 'is-invalid' : '' }} "
                                                placeholder="Rim Diameter" aria-label="Rim Diameter"
                                                aria-describedby="basic-addon2" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Inch</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('rim_diameter'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('rim_diameter') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- condition !-->
                                <div class="form-group row">
                                    <label for="condition" class="col-md-3 control-label">Condition</lable>
                                        <strong class="required_red">*</strong>
                                    </label>
                                    <div class="col-md-5 ">
                                        <div class="">
                                            <select
                                                class="custom-select {{ $errors->has('condition') ? 'is-invalid' : '' }}"
                                                name="condition" id="condition" required>
                                                <option value="" {{(old('condition') == '') ? 'selected' : ''}}
                                                    disabled>
                                                    Choose One
                                                </option>
                                                <option value="0" {{(old('condition') == '0') ? 'selected' : ''}}>
                                                    New</option>
                                                <option value="1" {{(old('condition') == '1') ? 'selected' : ''}}>
                                                    Used</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- front_rim_width !-->
                                <div class="form-group row" id="front_rim_width_toggle">
                                    <label for="front_rim_width" class="col-md-3 control-label">Front Rim Width<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('front_rim_width')}}" type="text" name="front_rim_width"
                                                id="front_rim_width"
                                                class="form-control {{ $errors->has('front_rim_width') ? 'is-invalid' : '' }} "
                                                placeholder="Front Rim Width" aria-label="Front Rim Width"
                                                aria-describedby="basic-addon2" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Inch</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('front_rim_width'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('front_rim_width') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- rear_rim_width !-->
                                <div class="form-group row" id="rear_rim_width_toggle">
                                    <label for="rear_rim_width" class="col-md-3 control-label">Rear Rim Width<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('rear_rim_width')}}" type="text" name="rear_rim_width"
                                                id="rear_rim_width"
                                                class="form-control {{ $errors->has('rear_rim_width') ? 'is-invalid' : '' }} "
                                                placeholder="Rear Rim Width" aria-label="Rear Rim Width"
                                                aria-describedby="basic-addon2" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Inch</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('rear_rim_width'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('rear_rim_width') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- front_offset !-->
                                <div class="form-group row" id="front_offset_toggle">
                                    <label for="front_offset" class="col-md-3 control-label">Front Offset<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ET</span>
                                            </div>
                                            <input value="{{old('front_offset')}}" type="text" name="front_offset"
                                                id="front_offset"
                                                class="form-control {{ $errors->has('front_offset') ? 'is-invalid' : '' }} "
                                                placeholder="Front Offset" aria-label="Front Offset"
                                                aria-describedby="basic-addon2" required>
                                        </div>
                                        @if ($errors->has('front_offset'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('front_offset') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- rear_offset !-->
                                <div class="form-group row" id="rear_offset_toggle">
                                    <label for="rear_offset" class="col-md-3 control-label">Rear Offset<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ET</span>
                                            </div>
                                            <input value="{{old('rear_offset')}}" type="text" name="rear_offset"
                                                id="rear_offset"
                                                class="form-control {{ $errors->has('rear_offset') ? 'is-invalid' : '' }} "
                                                placeholder="Rear Offset" aria-label="Rear Offset"
                                                aria-describedby="basic-addon2" required>
                                        </div>
                                        @if ($errors->has('rear_offset'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('rear_offset') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- pcd -->
                                <div id="pcd_toggle">
                                    <!-- pcd_control !-->
                                    <div class="form-group row">
                                        <label for="pcd_control" class="col-md-3 control-label">Double PCD<strong
                                                class="required_red">*</strong></label>
                                        <div class="col-md-5">
                                            <div class="btn-group btn-group-toggle btn-toolbar d-flex flex-warp {{ $errors->has('pcd_control') ? 'is-invalid' : '' }}"
                                                data-toggle="buttons">
                                                <div
                                                    class="btn btn-md btn-outline-primary  {{(old('pcd_control') == '') ? 'active' : ''}} {{(old('pcd_control') == 'yes') ? 'active' : ''}}">
                                                    <input {{(old('pcd_control') == '') ? 'checked' : ''}}
                                                        {{(old('pcd_control') == 'yes') ? 'checked' : ''}} type="radio"
                                                        name="pcd_control" id="yes" value="yes" autocomplete="off"
                                                        onchange="togglePCD(this)" required>Yes
                                                </div>
                                                <div
                                                    class="btn btn-md btn-outline-primary  {{(old('pcd_control') == 'no') ? 'active' : ''}}">
                                                    <input {{(old('pcd_control') == 'no') ? 'checked' : ''}}
                                                        type="radio" name="pcd_control" id="no" value="no"
                                                        autocomplete="off" onchange="togglePCD(this)">No
                                                </div>
                                            </div>
                                            @if ($errors->has('pcd_control'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('pcd_control') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <!-- pcd_1 !-->
                                    <div class="form-group row">
                                        <label for="pcd_1" class="col-md-3 control-label">PCD</lable>
                                            <lable id="pcd_1_toggle">1</lable>
                                            <strong class="required_red">*</strong>
                                        </label>
                                        <div class="col-md-5 ">
                                            <div class="">
                                                <select
                                                    class="custom-select {{ $errors->has('pcd_1') ? 'is-invalid' : '' }}"
                                                    name="pcd_1" id="pcd_1" required>
                                                    <option value="" {{(old('pcd_1') == '') ? 'selected' : ''}}
                                                        disabled>
                                                        Choose One
                                                    </option>
                                                    <option value="0" {{(old('pcd_1') == '0') ? 'selected' : ''}}>
                                                        4 x 100 mm</option>
                                                    <option value="1" {{(old('pcd_1') == '1') ? 'selected' : ''}}>
                                                        4 x 108 mm</option>
                                                    <option value="2" {{(old('pcd_1') == '2') ? 'selected' : ''}}>
                                                        4 x 114,3 mm</option>
                                                    <option value="3" {{(old('pcd_1') == '3') ? 'selected' : ''}}>
                                                        5 x 100 mm</option>
                                                    <option value="4" {{(old('pcd_1') == '4') ? 'selected' : ''}}>
                                                        5 x 108 mm</option>
                                                    <option value="5" {{(old('pcd_1') == '5') ? 'selected' : ''}}>
                                                        5 x 112 mm</option>
                                                    <option value="6" {{(old('pcd_1') == '6') ? 'selected' : ''}}>
                                                        5 x 114,3 mm</option>
                                                    <option value="7" {{(old('pcd_1') == '7') ? 'selected' : ''}}>
                                                        5 x 120 mm</option>
                                                    <option value="8" {{(old('pcd_1') == '8') ? 'selected' : ''}}>
                                                        5 x 127 mm</option>
                                                    <option value="9" {{(old('pcd_1') == '9') ? 'selected' : ''}}>
                                                        5 x 130 mm</option>
                                                    <option value="10" {{(old('pcd_1') == '10') ? 'selected' : ''}}>
                                                        5 x 139,7 mm</option>
                                                    <option value="11" {{(old('pcd_1') == '11') ? 'selected' : ''}}>
                                                        5 x 165,1 mm</option>
                                                    <option value="12" {{(old('pcd_1') == '12') ? 'selected' : ''}}>
                                                        6 x 114,3 mm</option>
                                                    <option value="13" {{(old('pcd_1') == '13') ? 'selected' : ''}}>
                                                        6 x 139,7 mm</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <!-- pcd_2 !-->
                                    <div class="form-group row" id="pcd_2_toggle">
                                        <label for="pcd_2" class="col-md-3 control-label">PCD 2
                                            <strong class="required_red">*</strong></label>
                                        <div class="col-md-5 ">
                                            <div class="">
                                                <select
                                                    class="custom-select {{ $errors->has('pcd_2') ? 'is-invalid' : '' }}"
                                                    name="pcd_2" id="pcd_2" required>
                                                    <option value="" {{(old('pcd_2') == '') ? 'selected' : ''}}
                                                        disabled>
                                                        Choose One
                                                    </option>
                                                    <option value="0" {{(old('pcd_2') == '0') ? 'selected' : ''}}>
                                                        4 x 100 mm</option>
                                                    <option value="1" {{(old('pcd_2') == '1') ? 'selected' : ''}}>
                                                        4 x 108 mm</option>
                                                    <option value="2" {{(old('pcd_2') == '2') ? 'selected' : ''}}>
                                                        4 x 114,3 mm</option>
                                                    <option value="3" {{(old('pcd_2') == '3') ? 'selected' : ''}}>
                                                        5 x 100 mm</option>
                                                    <option value="4" {{(old('pcd_2') == '4') ? 'selected' : ''}}>
                                                        5 x 108 mm</option>
                                                    <option value="5" {{(old('pcd_2') == '5') ? 'selected' : ''}}>
                                                        5 x 112 mm</option>
                                                    <option value="6" {{(old('pcd_2') == '6') ? 'selected' : ''}}>
                                                        5 x 114,3 mm</option>
                                                    <option value="7" {{(old('pcd_2') == '7') ? 'selected' : ''}}>
                                                        5 x 120 mm</option>
                                                    <option value="8" {{(old('pcd_2') == '8') ? 'selected' : ''}}>
                                                        5 x 127 mm</option>
                                                    <option value="9" {{(old('pcd_2') == '9') ? 'selected' : ''}}>
                                                        5 x 130 mm</option>
                                                    <option value="10" {{(old('pcd_2') == '10') ? 'selected' : ''}}>
                                                        5 x 139,7 mm</option>
                                                    <option value="11" {{(old('pcd_2') == '11') ? 'selected' : ''}}>
                                                        5 x 165,1 mm</option>
                                                    <option value="12" {{(old('pcd_2') == '12') ? 'selected' : ''}}>
                                                        6 x 114,3 mm</option>
                                                    <option value="13" {{(old('pcd_2') == '13') ? 'selected' : ''}}>
                                                        6 x 139,7 mm</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                                <!-- tire_diameter -->
                                <div class="form-group row" id="tire_diameter_toggle" hidden=true>
                                    <label for="tire_diameter" class="col-md-3 control-label">Tire Diameter<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('tire_diameter')}}" type="text" name="tire_diameter"
                                                id="tire_diameter"
                                                class="form-control {{ $errors->has('tire_diameter') ? 'is-invalid' : '' }} "
                                                placeholder="Wheel Diameter" aria-label="Wheel Diameter"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Inch</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('tire_diameter'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('tire_diameter') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- tire_width !-->
                                <div class="form-group row" id="tire_width_toggle" hidden=true>
                                    <label for="tire_width" class="col-md-3 control-label">Tire Width<strong
                                            class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('tire_width')}}" type="text" name="tire_width"
                                                id="tire_width"
                                                class="form-control {{ $errors->has('tire_width') ? 'is-invalid' : '' }} "
                                                placeholder="Wheel Width" aria-label="Wheel Width"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">mm</span>
                                            </div>
                                        </div>
                                        @if ($errors->has('tire_width'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('tire_width') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- tire_width_ratio -->
                                <div class="form-group row" id="tire_width_ratio_toggle" hidden=true>
                                    <label for="tire_width_ratio" class="col-md-3 control-label">Tire Thickness Ratio
                                        <strong class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input value="{{old('tire_width_ratio')}}" type="text"
                                                class="form-control {{ $errors->has('tire_width_ratio') ? 'is-invalid' : '' }} "
                                                name="tire_width_ratio" id="tire_width_ratio"
                                                placeholder="Wheel Thickness Ratio" aria-label="Wheel Thickness Ratio"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            @if ($errors->has('tire_width_ratio'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('tire_width_ratio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <!-- description -->
                                <div class="form-group row">
                                    <label for="description" class="col-md-3 control-label">Description
                                        <strong class="required_red">*</strong></label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" name="description" id="" rows="5" required
                                            {{ $errors->has('description') ? 'is-invalid' : '' }}
                                            placeholder="Product Description"></textarea>
                                        @if ($errors->has('description'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="" class="btn btn-lg btn-primary m-1" onclick="validator()">Submit</button>
                                <button type="submit" hidden id="realSubmit"></button>
                                <a href="" class="btn btn-lg btn-default m-1">Reset</a>
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
    <script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function validator(){
            console.log('is being validated');
            var price = document.getElementById('price').value;
            price = price.replace(/,/g, '');
            document.getElementById('price').value = price;
            var weight = document.getElementById('weight').value;
            weight = weight.replace(/,/g, '.');
            document.getElementById('weight').value = weight;
            var quantity = document.getElementById('quantity').value;
            quantity = quantity.replace(/,/g, '.');
            document.getElementById('quantity').value = quantity;
            var front_rim_width = document.getElementById('front_rim_width').value;
            front_rim_width = front_rim_width.replace(/,/g, '.');
            document.getElementById('front_rim_width').value = front_rim_width;
            var rear_rim_width = document.getElementById('rear_rim_width').value;
            rear_rim_width = rear_rim_width.replace(/,/g, '.');
            document.getElementById('rear_rim_width').value = rear_rim_width;
            var front_offset = document.getElementById('front_offset').value;
            front_offset = front_offset.replace(/,/g, '.');
            document.getElementById('front_offset').value = front_offset;
            var rear_offset = document.getElementById('rear_offset').value;
            rear_offset = rear_offset.replace(/,/g, '.');
            document.getElementById('rear_offset').value = rear_offset;
            var tire_diameter = document.getElementById('tire_diameter').value;
            tire_diameter = tire_diameter.replace(/,/g, '.');
            document.getElementById('tire_diameter').value = tire_diameter;
            var tire_width = document.getElementById('tire_width').value;
            tire_width = tire_width.replace(/,/g, '.');
            document.getElementById('tire_width').value = tire_width;
            var tire_width = document.getElementById('tire_width').value;
            tire_width = tire_width.replace(/,/g, '.');
            document.getElementById('tire_width').value = tire_width;
            var tire_width_ratio = document.getElementById('tire_width_ratio').value;
            tire_width_ratio = tire_width_ratio.replace(/,/g, '.');
            document.getElementById('tire_width_ratio').value = tire_width_ratio;
        }
        function toggleCategory(obj){
            console.log('control');
            if($('#wheels').is(':checked')==true){
                console.log('wheels');
                document.getElementById('rim_type_toggle').hidden=true;
                document.getElementById('rim_type_toggle').disabled=true;
                document.getElementById('replica').required=false;

                document.getElementById('rim_diameter_toggle').hidden=true;
                document.getElementById('rim_diameter_toggle').disabled=true;
                document.getElementById('rim_diameter').required=false;

                document.getElementById('front_rim_width_toggle').hidden=true;
                document.getElementById('front_rim_width_toggle').disabled=true;
                document.getElementById('front_rim_width').required=false;

                document.getElementById('rear_rim_width_toggle').hidden=true;
                document.getElementById('rear_rim_width_toggle').disabled=true;
                document.getElementById('rear_rim_width').required=false;

                document.getElementById('front_offset_toggle').hidden=true;
                document.getElementById('front_offset_toggle').disabled=true;
                document.getElementById('front_offset').required=false;

                document.getElementById('rear_offset_toggle').hidden=true;
                document.getElementById('rear_offset_toggle').disabled=true;
                document.getElementById('rear_offset').required=false;

                document.getElementById('pcd_toggle').hidden=true;
                document.getElementById('pcd_toggle').disabled=true;
                document.getElementById('yes').required=false;
                document.getElementById('pcd_1').required=false;
                document.getElementById('pcd_2').required=false;

                document.getElementById('tire_diameter_toggle').hidden=false;
                document.getElementById('tire_diameter_toggle').disabled=false;
                document.getElementById('tire_diameter').required=true;

                document.getElementById('tire_width_toggle').hidden=false;
                document.getElementById('tire_width_toggle').disabled=false;
                document.getElementById('tire_width').required=true;

                document.getElementById('tire_width_ratio_toggle').hidden=false;
                document.getElementById('tire_width_ratio_toggle').disabled=false;
                document.getElementById('tire_width_ratio').required=true;

            }
            if($('#rims').is(':checked')==true){
                console.log('rims');
                document.getElementById('rim_type_toggle').hidden=false;
                document.getElementById('rim_type_toggle').disabled=false;
                document.getElementById('replica').required=true;

                document.getElementById('rim_diameter_toggle').hidden=false;
                document.getElementById('rim_diameter_toggle').disabled=false;
                document.getElementById('rim_diameter').required=true;

                document.getElementById('front_rim_width_toggle').hidden=false;
                document.getElementById('front_rim_width_toggle').disabled=false;
                document.getElementById('front_rim_width').required=true;

                document.getElementById('rear_rim_width_toggle').hidden=false;
                document.getElementById('rear_rim_width_toggle').disabled=false;
                document.getElementById('rear_rim_width').required=true;

                document.getElementById('front_offset_toggle').hidden=false;
                document.getElementById('front_offset_toggle').disabled=false;
                document.getElementById('front_offset').required=true;

                document.getElementById('rear_offset_toggle').hidden=false;
                document.getElementById('rear_offset_toggle').disabled=false;
                document.getElementById('rear_offset').required=true;

                document.getElementById('pcd_toggle').hidden=false;
                document.getElementById('pcd_toggle').disabled=false;
                document.getElementById('yes').required=true;
                document.getElementById('pcd_1').required=true;
                document.getElementById('pcd_2').required=true;

                document.getElementById('tire_diameter_toggle').hidden=true;
                document.getElementById('tire_diameter_toggle').disabled=true;
                document.getElementById('tire_diameter').required=false;

                document.getElementById('tire_width_toggle').hidden=true;
                document.getElementById('tire_width_toggle').disabled=true;
                document.getElementById('tire_width').required=false;

                document.getElementById('tire_width_ratio_toggle').hidden=true;
                document.getElementById('tire_width_ratio_toggle').disabled=true;
                document.getElementById('tire_width_ratio').required=false;
            }
        }

        function togglePCD(obj){
            console.log('control');
            if($('#yes').is(':checked')==true){
                console.log('yes');
                document.getElementById('pcd_1_toggle').hidden=false;
                document.getElementById('pcd_2_toggle').hidden=false;
                document.getElementById('pcd_1').required=true;
                document.getElementById('pcd_2').required=true;
            }
            if($('#no').is(':checked')==true){
                console.log('no');
                document.getElementById('pcd_1_toggle').hidden=true;
                document.getElementById('pcd_2_toggle').hidden=true;
                document.getElementById('pcd_1').required=false;
                document.getElementById('pcd_2').required=false;
            }
        }
    </script>
</body>

</html>