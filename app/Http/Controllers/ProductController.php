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
        \Log::info('Request data:', $request->all()); //リクエストデータをログに記録

        $query = Product::query();  // 新しいクエリビルダーインスタンスを作成

        // 検索ワードが入力されている場合、その条件をクエリに追加
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // 会社IDが指定されている場合、その条件をクエリに追加
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // 価格範囲検索
        if ($request->filled('price_min')) {
        $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
        $query->where('price', '<=', $request->price_max);
        }

        // 在庫数範囲検索
        if ($request->filled('stock_min')) {
        $query->where('stock', '>=', $request->stock_min);
        }

        if ($request->filled('stock_max')) {
        $query->where('stock', '<=', $request->stock_max);
        }

        // 関連する会社データも一緒に取得
        $products = $query->with('company')->get();

        \Log::info('Query SQL:', [$query->toSql()]); // クエリのSQLをログに記録
        \Log::info('Query bindings:', $query->getBindings()); // クエリのバインディングをログに記録
        \Log::info('Query result:', $products->toArray()); // クエリ結果をログに記録

        if ($request->ajax()) {
            // Ajax リクエストの場合は JSON レスポンスを返す
            return response()->json($products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'img_path' => asset($product->img_path),
                    'product_name' => $product->product_name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'company_name' => $product->company->company_name,
                ];
            }));
        }

        if($sort = $request->sort){
            $direction = $request->direction == 'desc' ? 'desc' : 'asc'; // directionがdescでない場合は、デフォルトでascとする
            $query->orderBy($sort, $direction);
        }

        // 通常のリクエストの場合はビューを返す
        $companies = Company::all();
        return view('products.index', compact('products', 'companies'));
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
            return redirect('/products')->with('success', __('messages.success_delete'));
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting product: ' . $e->getMessage());
            return back()->withErrors(['error' => __('messages.error_delete')]);
        }
    }
}
