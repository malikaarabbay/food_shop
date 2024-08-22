@if($feedbacks)
    <section class="fp__testimonial pt_95 xs_pt_66 mb_150 xs_mb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_40">
                    <h4>{{ @$sectionTitles['feedback_top_title'] }}</h4>
                    <h2>{{ @$sectionTitles['feedback_main_title'] }}</h2>
                    <span>
                        <img src="{{ asset('frontend/images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                    <p>{{ @$sectionTitles['feedback_sub_title'] }}</p>
                </div>
            </div>
        </div>

        <div class="row testi_slider">
            @foreach($feedbacks as $feedback)
                <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                <div class="fp__single_testimonial">
                    <div class="fp__testimonial_header d-flex flex-wrap align-items-center">
                        <div class="img">
                            <img src="{{ asset($feedback->image) }}" alt="clients" class="img-fluid w-100">
                        </div>
                        <div class="text">
                            <h4>{{ $feedback->name }}</h4>
                            <p>{{ $feedback->title }}</p>
                        </div>
                    </div>
                    <div class="fp__single_testimonial_body">
                        <p class="feedback">{{ $feedback->review }}</p>
                        <span class="rating">
                           @for ($i = 1; $i <= $feedback->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
