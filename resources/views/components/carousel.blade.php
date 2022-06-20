<!-- Image Carousel -->

<div class="image-carousel">
    <div class="image-carousel-inner">
        <button aria-label="slide backward" class="slider-backward" id="prev">
            <em class="fa-solid fa-angle-left"></em>
        </button>
        <div class="slider-wrapper">
            <div id="slider" class="slider-wrapper-inner">
                <div class="imagesContainer">
                    @foreach ($medias ?? [] as $media)
                        <div class="image" id="model-1-image" style="background-image: url({{ $media->url }});">
                            <div class="image-text">
                                <div id="model-1" onclick="imagePop(id);"> <i class="fa-solid fa-magnifying-glass-plus"></i> </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <button aria-label="slide forward" class="slider-forward" id="next">
            <em class="fa-solid fa-angle-right"></em>
        </button>
    </div>
</div>
<div class="imagePop" id="imagePopId">
    <div class="click1" onclick="imageMoveLeft();"> <i class="fas fa-arrow-alt-circle-left fa-3x"></i></div>
    <div class="click2" onclick="imageMoveRight();"> <i class="fas fa-arrow-alt-circle-right fa-3x"></i> </div>
    <div class="close" onclick="imagePopNone();"> <i class="fas fa-times fa-3x"></i> </div>
    <section class="imagePopUnder" onclick="imagePopNone();"></section>
    <section class="imageContain" id="imageContainId" onclick="imageChange(id);"></section>
</div>


@pushOnce('script')

<script>
    let defaultTransform = 0;
    let imageUrls = [];
    let imageNumber = 0;
    @foreach ($medias ?? [] as $key => $media)
        imageUrls[{{ $key }}] = 'url("{{ $media->url }}")';
    @endforeach
    imageNumber = imageUrls.length
    function goNext() {
        defaultTransform = defaultTransform - 398;
        var slider = document.getElementById("slider");
        if (Math.abs(defaultTransform) >= slider.scrollWidth / 1.7) defaultTransform = 0;
        slider.style.transform = "translateX(" + defaultTransform + "px)";
    }
    next.addEventListener("click", goNext);

    function goPrev() {
        var slider = document.getElementById("slider");
        if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
        else defaultTransform = defaultTransform + 398;
        slider.style.transform = "translateX(" + defaultTransform + "px)";
    }
    prev.addEventListener("click", goPrev);
    function imagePop(id) {
        document.getElementById('imagePopId').style.display = 'block'
        document.getElementsByTagName('body')[0].style.overflowY = 'hidden'
        var imageName = document.getElementById(id + '-image').style.backgroundImage
        var imageIndex = 0
        imageIndex = imageUrls.indexOf(imageName)
        document.getElementsByClassName('imageContain')[0].style.animation = 'he 800ms forwards'
        document.getElementsByClassName('imageContain')[0].style.backgroundImage = imageUrls[imageIndex]
    }

    function imageChange(id) {
        var imageName = document.getElementById(id).style.backgroundImage
        var imageIndex = 0
        imageIndex = imageUrls.indexOf(imageName)
        if (imageIndex >= imageNumber - 1)
            imageIndex = 0
        else
            imageIndex++
        document.getElementById(id).style.backgroundImage = imageUrls[imageIndex]
    }

    function imageMoveLeft() {
        var imageName = document.getElementById('imageContainId').style.backgroundImage
        var imageIndex = 0
        imageIndex = imageUrls.indexOf(imageName)
        if (imageIndex <= 0)
            imageIndex = imageNumber - 1
        else
            imageIndex--
        document.getElementById('imageContainId').style.backgroundImage = imageUrls[imageIndex]
    }

    function imageMoveRight() {
        var imageName = document.getElementById('imageContainId').style.backgroundImage
        var imageIndex = 0
        imageIndex = imageUrls.indexOf(imageName)
        if (imageIndex >= imageNumber - 1)
            imageIndex = 0
        else
            imageIndex++
        document.getElementById('imageContainId').style.backgroundImage = imageUrls[imageIndex]
    }

    function imagePopNone() {
        document.getElementsByClassName('imagePop')[0].style.display = 'none'
        document.getElementsByTagName('body')[0].style.overflowY = 'scroll'
    }
</script>

@endPushOnce
