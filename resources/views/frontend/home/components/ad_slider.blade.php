<section class="fp__add_slider mt_100 xs_mt_70 pt_100 xs_pt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row add_slider wow fadeInUp" data-wow-duration="1s">
            @foreach($banners as $banner)
                <div class="col-xl-4">
                    <a href="{{ $banner->url }}" class="fp__add_slider_single" style="background: url({{ asset($banner->banner) }});">
                        <div class="text">
                            <h3>{{ $banner->title }}</h3>
                            <p>{{ $banner->sub_title }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>