<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
         //コントローラーのメソッドに対して認証を必要とするミドルウェアを設定
         $this->middleware('auth');
    }

    public function index(Request $request)
    {
        \Log::info('Request data:', $request->all());
    
        $query = Product::query();
    
        if ($request->filled('search')) {
            $query->where('products.product_name', 'like', '%' . $request->search . '%');
        }
    
        if ($request->filled('company_id')) {
            $query->where('products.company_id', $request->company_id);
        }
    
        if ($request->filled('price_min')) {
            $query->where('products.price', '>=', $request->price_min);
        }
    
        if ($request->filled('price_max')) {
            $query->where('products.price', '<=', $request->price_max);
        }
    
        if ($request->filled('stock_min')) {
            $query->where('products.stock', '>=', $request->stock_min);
        }
    
        if ($request->filled('stock_max')) {
            $query->where('products.stock', '<=', $request->stock_max);
        }
    
        $query->join('companies', 'products.company_id', '=', 'companies.id')
              ->select('products.*', 'companies.company_name');
    
        if ($sort = $request->sort) {
            $direction = $request->direction == 'desc' ? 'desc' : 'asc';
            $allowedSorts = ['id', 'product_name', 'price', 'stock', 'company_name'];
    
            if (in_array($sort, $allowedSorts)) {
                if ($sort === 'company_name') {
                    $query->orderBy('companies.company_name', $direction);
                } else {
                    $query->orderBy('products.' . $sort, $direction);
                }
            } else {
                $query->orderBy('products.id', 'desc');
            }
        } else {
            $query->orderBy('products.id', 'desc');
        }
    
        $products = $query->get();

        //ここで img_path をフルURLに変換
        $products->transform(function ($product) {
            $product->img_path = asset($product->img_path);
            return $product;
        });
    
        \Log::info('Query SQL:', [$query->toSql()]);
        \Log::info('Query bindings:', $query->getBindings());
        \Log::info('Query result:', $products->toArray());
    
        //ここで Ajax と通常リクエストを分ける
        if ($request->ajax()) {
            return response()->json($products);
        } else {
            $companies = Company::all();
            return view('products.index', compact('products', 'companies'));
        }
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //全ての会社の情報を取得
        $companies = Company::all();

        //商品新規登録画面を表示。取得した全ての会社情報を画面に渡す
        return view('products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //リクエストされた情報を確認して、必要な情報が全て揃っているかチェック
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['img_path'] = Product::handleImageUpload($request);
            
            $product = Product::createProduct($data);
            DB::commit();
            return redirect()->back()->with('success', __('messages.success_store'));
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating product: ' . $e->getMessage());
            return back()->withErrors(['error' => __('messages.error_store')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //商品詳細画面を表示。商品の詳細情報を画面に渡す
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //全ての会社の情報を取得
        $companies = Company::all();

        // 商品編集画面を表示。商品の情報と会社の情報を画面に渡す
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //リクエストされた情報を確認して、必要な情報が全て揃っているかチェック
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $imgPath = Product::handleImageUpload($request);
            if ($imgPath) {
                $data['img_path'] = $imgPath;
            }

            $product->updateProduct($data);
            DB::commit();
            return redirect()->route('products.edit', $product->id)->with('success', __('messages.success_update'));
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating product: ' . $e->getMessage());
            return back()->withErrors(['error' => __('messages.error_update')]);;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
    
        try {
            $product->delete();
            DB::commit();
    
            //非同期リクエストならJSONを返す
            if (request()->ajax()) {
                return response()->json(['message' => __('messages.success_delete')]);
            }
    
            // 通常の（同期）リクエストならリダイレクト
            return redirect('/products')->with('success', __('messages.success_delete'));
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting product: ' . $e->getMessage());
    
            //エラー時もJSONを返す
            if (request()->ajax()) {
                return response()->json(['message' => __('messages.error_delete')], 500);
            }
    
            return back()->withErrors(['error' => __('messages.error_delete')]);
        }
    }    
}
