@include('layouts.head')
<body>
    <input type="text" value={{$index}} hidden id="index">
    <div class="display-block text-center gallery-container">
        <div class="row pt-5 pl-5">
            <div class="col-sm-2 d-flex flex-row ml-5 pl-5">
                <a href="{{url()->previous()}}" class="my-auto">
                    <i class="fas fa-arrow-left pl-5"></i>
                </a>
                <h3 class="m-0 pl-5">Gallery</h3>
            </div>
        </div>
        <div class="gallery-modal" id="modal" onclick="closeModal()">
            @foreach ($images as $key=>$image)
                @if ($image->picture == $highlight_image->picture)
                <div class="col-sm-12" name="images" id={{$key}}>
                    <img src="{{asset('/img/images/products/'.$image->picture)}}" alt="" class="img-fluid hightlight-image">
                </div>
                @endif
                <div class="col-sm-12 gallery-slides" name="images" id={{$key}}>
                    <img src="{{asset('/img/images/products/'.$image->picture)}}" alt="" class="img-fluid hightlight-image">
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center pb-2">
            <div class="col-sm-10">
                <div class="row for-gallery-thumbnail">
                    @foreach ($images as $key=>$image)
                    <div class="col-sm-2 pt-3 gallery-thumbnail" onclick="showSlides({{$key}})">
                        <img src="{{asset('/img/images/products/'.$image->picture)}}" alt="" class="img-fluid thumbnail imgProp">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on('load',combinedFunctions);
        function combinedFunctions(){
            var index = $('#index').val();
            showSlides(index);
        };
        function closeModal(){
            var modal = document.getElementById('modal');
            modal.style.display = "none";
        }
        function showSlides(index){
            console.log(index);
            var images = document.getElementsByName('images');
            var modal = document.getElementById('modal');
            for(var i = 0; i<images.length; i++){
                images[i].style.display = "none";
            }
            var show = document.getElementById(index);
            console.log(show);
            show.style.display = "block";
            modal.style.display = "block";
        }
    </script>
</body>