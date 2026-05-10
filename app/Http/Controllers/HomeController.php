<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\models\product\Category;
use App\models\product\Product;
use App\models\blog\Blog;
use Session;
use App\models\website\Partner;
use App\models\blog\BlogCategory;
use App\models\BannerAds;
use App\models\website\Video;
use App\models\website\Founder;
use App\models\website\Prize;
use App\models\website\AlbumAffter;
use App\models\ReviewCus;
use App\models\PageContent;
use App\models\Services;
use App\models\Project;
use App\models\WhyChooseUs;
use App\models\ProcessStep;
use App\models\IntegrationLogo;

class HomeController extends Controller
{
    public function home()
    {
        $data['hotnews'] = Blog::where([
            ['status','=',1]
        ])->orderBy('id','DESC')->limit(3)->get(['id','title','slug','created_at','image','description']);
        $data['gioithieu'] = PageContent::where(['slug'=>'gioi-thieu','language'=>'vi'])->first(['id','title','content','image']);
        $data['whyChooseUs'] = WhyChooseUs::where('status',1)
            ->orderBy('position','ASC')
            ->orderBy('id','ASC')
            ->get(['id','title','icon','description']);
        $data['processSteps'] = ProcessStep::where('status',1)
            ->orderBy('position','ASC')
            ->orderBy('id','ASC')
            ->get(['id','title','icon']);
        $data['integrationLogos'] = IntegrationLogo::where('status',1)
            ->orderBy('group_key','ASC')
            ->orderBy('position','ASC')
            ->orderBy('id','ASC')
            ->get(['id','name','image','link','group_key'])
            ->groupBy('group_key');
        $data['integrationLogoGroups'] = IntegrationLogo::GROUPS;
        $data['bannerads'] = BannerAds::where(['status'=>1,'status_show'=>'banner_ads'])->get();
        $data['ReviewCus'] = ReviewCus::where(['status'=>1])->get();
        $data['Partner'] = Partner::where(['status'=>1])->get();
        $data['duan'] = Project::with(['cateService'])->where('status',1)->limit(6)->get();
        $data['homePro'] = Product::where(['status'=>1,'discountStatus'=>1])
            ->select('id','category','name','discount','price','images','slug','cate_slug','type_slug','description','status_variant')
            ->with(['cate:id,slug,name'])
            ->inRandomOrder()->limit(18)->get();
        $this->attachVariantPriceRange($data['homePro']);
        return view('home',$data);
    }

    private function attachVariantPriceRange($products): void
    {
        $products = collect($products);
        if ($products->isEmpty()) {
            return;
        }

        $variantProductIds = $products
            ->where('status_variant', 1)
            ->pluck('id')
            ->filter()
            ->values()
            ->all();

        if (empty($variantProductIds)) {
            return;
        }

        $ranges = \App\models\VariantSkuValue::query()
            ->selectRaw('product_id, MIN(price) as min_price, MAX(price) as max_price')
            ->whereIn('product_id', $variantProductIds)
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        foreach ($products as $product) {
            $range = $ranges->get($product->id);
            $product->variant_min_price = $range ? (float) $range->min_price : null;
            $product->variant_max_price = $range ? (float) $range->max_price : null;
        }
    }
}
