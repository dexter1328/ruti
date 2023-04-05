<?php

namespace App\Http\Controllers\Supplier;

use App\Category;
use App\Http\Controllers\Controller;
use App\Orders;
use App\ProductReview;
use App\ProductVariants;
use App\Rating;
use App\SuppliersOrder;
use App\Traits\Permission;
use App\User;
use App\Vendor;
use App\VendorStore;
use App\W2bOrder;
use App\W2bProduct;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use Permission;

    private $stripe_secret;

    public function __construct()
    {
        $this->middleware('auth:vendor');
        $this->middleware(function ($request, $next) {
            if(!$this->hasVendorPermission(Auth::user())){
                return redirect('supplier/home');
            }
            return $next($request);
        });
        $this->stripe_secret = config('services.stripe.secret');
    }

    public function __invoke(Request $request)
    {
        return $this->dashboard($request);
    }

    public function dashboard(Request $request)
    {

        if($request->has('start') && $request->has('end') && $request->start !='' && $request->end != ''){
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));
        }else{
            $start_date = today()->subMonth()->format('Y-m-d');
            $end_date = today()->format('Y-m-d');
        }


        $vendor_data = Vendor::where('status', 'active')->where('parent_id', Auth::user()->id)->get();

        if (Auth::user()->parent_id == 0) {
            $vendorID = Auth::user()->id;
        } else {
            $vendorID = Auth::user()->parent_id;
        }

        $product_count = W2bProduct::where('supplier_id', $vendorID)->count();

        $vendor = Vendor::where('parent_id', $vendorID)->count();

        $order = SuppliersOrder::join('w2b_orders', function (Builder $join) {
                $join->on('suppliers_orders.order_id', '=', 'w2b_orders.id');
            })
            ->where('w2b_orders.status', 'delivered')
            ->where('suppliers_orders.supplier_id', $vendorID)
            ->count();

        //$order_users = Orders::selectRaw('DISTINCT customer_id')->where('vendor_id',Auth::user()->id)->get()->pluck('customer_id')->toArray();
        $order_users = SuppliersOrder::selectRaw('DISTINCT user_id')
            ->where('supplier_id', $vendorID)
            ->pluck('user_id')
            ->toArray();

        $user = User::whereIn('id', $order_users)->count();

        // sales graph
        $graph_sales = SuppliersOrder::selectRaw('count(suppliers_orders.id) as total_sales, Date(suppliers_orders.created_at) as sales_date')
            ->whereBetween(DB::raw('DATE(w2b_orders.created_at)'), [$start_date, $end_date])
            ->join('w2b_orders', function ($join) {
                $join->on('suppliers_orders.order_id', '=', 'w2b_orders.order_id');
            })
            ->where('w2b_orders.status', '=', 'delivered')
            ->where('suppliers_orders.supplier_id', $vendorID)
            ->groupBy(['sales_date'])->get();

        $graph_sales = Arr::pluck($graph_sales, 'total_sales', 'sales_date');

        $total_sales_graph_label = [];
        $total_sales_graph_data = [];

        $date = $start_date;
        while (strtotime($date) <= strtotime($end_date)) {

            $total_sales_graph_label[] = date("d M", strtotime($date));
            if (array_key_exists($date, $graph_sales)) {
                $total_sales_graph_data[] = (int)$graph_sales[$date];
            } else {
                $total_sales_graph_data[] = 0;
            }
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        // earning graph
        $graph_earning = SuppliersOrder::selectRaw('sum(w2b_orders.total_price) as total_revenue, Date(suppliers_orders.created_at) as sales_date')
            ->whereBetween(DB::raw('DATE(w2b_orders.created_at)'), [$start_date, $end_date])
            ->join('w2b_orders', function ($join) {
                $join->on('suppliers_orders.order_id', '=', 'w2b_orders.order_id');
            })
            ->where('w2b_orders.status', '=', 'delivered')
            ->where('suppliers_orders.supplier_id', $vendorID)
            ->groupBy(['sales_date'])->get();

        $graph_earning = Arr::pluck($graph_earning, 'total_revenue', 'sales_date');

        $total_earning_graph_label = [];
        $total_earning_graph_data = [];

        $date = $start_date;
        while (strtotime($date) <= strtotime($end_date)) {

            $total_earning_graph_label[] = date("d M", strtotime($date));
            if (array_key_exists($date, $graph_earning)) {
                $total_earning_graph_data[] = (int)$graph_earning[$date];
            } else {
                $total_earning_graph_data[] = 0;
            }

            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        //customer_review
        $customer_reviews = Rating::with('product')
            ->whereHas('product', function ($query) use ($vendorID) {
                $query->where('supplier_id', $vendorID);
            })
            ->latest('id')->take(5)->get();

        //recent order
        $recent_orders = SuppliersOrder::query()
            ->with('w2bOrder', 'user')
            ->where('supplier_id', $vendorID)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();


        $input = $request->all();
        return view('supplier.home', compact(
            'start_date',
            'end_date',
            'vendor',
            'order',
            'user',
            'total_sales_graph_label',
            'total_sales_graph_data',
            'total_earning_graph_label',
            'total_earning_graph_data',
            'customer_reviews',
            'recent_orders',
            'vendor_data',
            'product_count',
            'input'
        ));
    }

    protected function getCategoriesDropDown($prefix, $items)
    {
        $str = '';
        $span = '<span>—</span>';
        foreach ($items as $key => $value) {
            $str .= '<option value="' . $value['id'] . '">' . $prefix . $value['name'] . '</option>';
            if (array_key_exists('child', $value)) {
                $str .= $this->getCategoriesDropDown($prefix . $span, $value['child'], 'child');
            }
        }
        return $str;
    }
}
