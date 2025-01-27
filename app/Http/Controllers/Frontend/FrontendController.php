<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AppDownload;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Contact;
use App\Models\Counter;
use App\Models\Coupon;
use App\Models\DailyOffer;
use App\Models\Feedback;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Mail;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    function index() : View
    {
        $sectionTitles = $this->getSectionTitles();
        $sliders = Slider::active()->get();
        $whyChooseUs = WhyChooseUs::active()->get();
        $categories = Category::active()->showAtHome()->get();
        $dailyOffers = DailyOffer::with('product')->active()->take(15)->get();
        $banners = Banner::active()->latest()->take(10)->get();
        $chefs = Chef::active()->showAtHome()->get();
        $appSection = AppDownload::first();
        $feedbacks = Feedback::active()->showAtHome()->get();
        $counter = Counter::first();
        $latestBlogs = Blog::withCount(['comments' => function($query){
            $query->active();
        }])->with(['category', 'user'])->active()->latest()->take(3)->get();

        return view('frontend.home.index',
            compact(
                'sliders',
                'sectionTitles',
                'whyChooseUs',
                'categories',
                'dailyOffers',
                'banners',
                'chefs',
                'appSection',
                'feedbacks',
                'counter',
                'latestBlogs'
            ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    function getSectionTitles() : Collection
    {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'feedback_top_title',
            'feedback_main_title',
            'feedback_sub_title'
        ];

        return SectionTitle::whereIn('key', $keys)->pluck('value','key');
    }

    /**
     * Display a chef page
     *
     * @return View
     */
    function chef() : View
    {
        $chefs = Chef::active()->paginate(12);

        return view('frontend.pages.chefs', compact('chefs'));
    }

    /**
     * Display a feedback page
     *
     * @return View
     */
    function feedback() : View
    {
        $feedbacks = Feedback::active()->paginate(9);

        return view('frontend.pages.feedback', compact('feedbacks'));
    }

    /**
     * Show a about page
     *
     * @return View
     */
    function about() : View {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'feedback_top_title',
            'feedback_main_title',
            'feedback_sub_title'
        ];

        $sectionTitles = SectionTitle::whereIn('key', $keys)->pluck('value','key');;
        $about = About::first();
        $whyChooseUs = WhyChooseUs::active()->get();
        $chefs = Chef::active()->showAtHome()->get();
        $counter = Counter::first();
        $feedbacks = Feedback::active()->showAtHome()->get();

        return view('frontend.pages.about', compact('about', 'whyChooseUs', 'sectionTitles', 'chefs', 'counter', 'feedbacks'));
    }

    /**
     * Show a privacy policy page
     *
     * @return View
     */
    function privacyPolicy() : View
    {
        $privacyPolicy = PrivacyPolicy::first();

        return view('frontend.pages.privacy_policy', compact('privacyPolicy'));
    }

    /**
     * Show contact page
     *
     * @return View
     */
    function contact() : View
    {
        $contact = Contact::first();

        return view('frontend.pages.contact', compact('contact'));
    }

    /**
     * Send a contact mail
     *
     * @param Request $request
     * @return Response
     */
    function sendContactMessage(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max: 1000']
        ]);

        Mail::send(new ContactMail($request->name, $request->email, $request->subject, $request->message));

        return response(['status' => 'success', 'message' => 'Message Sent Successfully!']);
    }

    /**
     * Display a blog
     *
     * @param Request $request
     * @return View
     */
    function blog(Request $request) : View
    {
        $blogs = Blog::withCount(['comments'=> function($query){
            $query->active();
        }])->with(['category', 'user'])->active();

        if($request->has('search') && $request->filled('search')){
            $blogs->where(function($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if($request->has('category') && $request->filled('category')) {
            $blogs->whereHas('category', function($query) use ($request){
                $query->where('slug', $request->category);
            });
        }

        $blogs = $blogs->latest()->paginate(9);

        $categories = BlogCategory::active()->get();

        return view('frontend.pages.blog', compact('blogs', 'categories'));
    }

    /**
     * Display a blog details
     *
     * @param string $slug
     * @return View
     */
    function blogDetails(string $slug) : View
    {
        $blog = Blog::with(['user'])->where('slug', $slug)->active()->firstOrFail();

        $comments = $blog->comments()->active()->orderBy('id', 'DESC')->paginate(20);

        $latestBlogs = Blog::select('id', 'title', 'slug', 'created_at', 'image')
            ->active()
            ->where('id', '!=', $blog->id)
            ->latest()->take(5)->get();

        $categories = BlogCategory::withCount(['blogs' => function($query){
            $query->active();
        }])->active()->get();

        $nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'ASC')->first();
        $previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();

        return view('frontend.pages.blog_details', compact('blog', 'latestBlogs', 'categories', 'nextBlog', 'previousBlog', 'comments'));
    }

    /**
     * Create comment to a blog
     *
     * @param Request $request
     * @param string $blog_id
     * @return RedirectResponse
     */
    function blogCommentStore(Request $request, string $blog_id) : RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'max:500']
        ]);

        $blog = Blog::findOrFail($blog_id);

        BlogComment::create(array_merge($request->all(),
            [
                'user_id' => auth()->user()->id,
                'blog_id' => $blog->id
            ]
        ));

        toastr()->success('Comment submitted successfully and waiting to approve.');

        return redirect()->back();
    }

    /**
     * Set time to reservation
     *
     * @param Request $request
     * @return Response
     */
    function reservation(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'persons' => ['required', 'numeric']
        ]);

        if(!Auth::check()){
            throw ValidationException::withMessages(['Please Login to Request Reservation']);
        }

        Reservation::create(array_merge($request->all(),
            [
                'reservation_id' => rand(0, 500000),
                'user_id' => auth()->user()->id,
                'status' => Reservation::STATUS_PENDING
            ]
        ));

        return response(['status' => 'success', 'message' => 'Request send successfully']);
    }

    /**
     * Subscribe
     *
     * @param Request $request
     * @return Response
     */
    function subscribe(Request $request) : Response
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ], ['email.unique' => 'Email is already subscribed!']);

        Subscriber::create($request->all());

        return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
    }

    /**
     * Show a products page
     *
     * @param Request $request
     * @return View
     */
    function products(Request $request) : View
    {
        $products = Product::active()->orderBy('id', 'DESC');

        if($request->has('search') && $request->filled('search')) {
            $products->where(function($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if($request->has('category') && $request->filled('category')) {
            $products->whereHas('category', function($query) use ($request){
                $query->where('slug', $request->category);
            });
        }

        $products = $products->withAvg('reviews', 'rating')->withCount('reviews')->paginate(12);

        $categories = Category::active()->get();

        return view('frontend.pages.product', compact('products', 'categories'));
    }

    /**
     * Show a product page
     *
     * @param string $slug
     * @return View
     */
    function showProduct(string $slug) : View
    {
        $product = Product::with(['productImages', 'options'])->where(['slug' => $slug, 'status' => 1])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->take(8)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()->get();

        $reviews = ProductRating::where(['product_id' => $product->id, 'status' => 1])->paginate(30);

        return view('frontend.pages.product_view', compact('product', 'relatedProducts', 'reviews'));
    }

    /**
     * Load a product modal page
     *
     * @param int $productId
     */
    function loadProductModal($productId)
    {
        $product = Product::with(['options'])->findOrFail($productId);

        return view('frontend.layouts.ajax-files.product_popup_modal', compact('product'))->render();
    }

    /**
     * Store a review for product
     *
     * @param Request $request
     * @return RedirectResponse
     */
    function productReviewStore(Request $request) : RedirectResponse
    {
        $request->validate([
            'rating' => ['required', 'min:1', 'max:5', 'integer'],
            'review' => ['required', 'max:500'],
            'product_id' => ['required', 'integer']
        ]);

        $user = Auth::user();

        $hasPurchased = $user->orders()->whereHas('orderItems', function($query) use ($request){
            $query->where('product_id', $request->product_id);
        })
            ->where('order_status', 'delivered')
            ->get();

        if(count($hasPurchased) == 0){
            throw ValidationException::withMessages(['Please Buy The Product Before Submit a Review!']);
        }

        $alreadyReviewed = ProductRating::where(['user_id' => $user->id, 'product_id' => $request->product_id])->exists();

        if($alreadyReviewed){
            throw ValidationException::withMessages(['You already reviewed this product']);
        }

        ProductRating::create(array_merge($request->all(),
            [
                'user_id' => $user->id,
                'status' => 0
            ]
        ));

        toastr()->success('Review added successfully and waiting to approve');

        return redirect()->back();
    }

    /**
     * Apply a coupon
     *
     * @param Request $request
     * @return Response
     */
    function applyCoupon(Request $request) : Response
    {
        $subtotal = $request->subtotal;
        $code = $request->code;

        $coupon = Coupon::where('code', $code)->first();

        if(!$coupon) {
            return response(['message' => 'Invalid Coupon Code.'], 422);
        }
        if($coupon->quantity <= 0){
            return response(['message' => 'Coupon has been fully redeemed.'], 422);
        }
        if($coupon->expire_date < now()){
            return response(['message' => 'Coupon has expired.'], 422);
        }

        if($coupon->discount_type === 'percent') {
            $discount = number_format($subtotal * ($coupon->discount / 100), 2);
        }elseif ($coupon->discount_type === 'amount'){
            $discount = number_format($coupon->discount, 2);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);

        return response([
            'message' => 'Coupon Applied Successfully.',
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'coupon_code' => $code
        ]);
    }

    /**
     * Destroy a coupon
     *
     * @return Response
     */
    function destroyCoupon()
    {
        try{
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grand_cart_total' => grandCartTotal()]);
        }catch(\Exception $e){
            logger($e);
            return response(['message' => 'Something went wrong']);
        }
    }
}
