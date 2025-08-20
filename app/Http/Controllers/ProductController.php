<?php


namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArticleRequest;


class ProductController extends Controller 
{
    
    public function index(Request $request)
    {
    $companies = Company::all();

    $query = Product::with('company');

    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    $products = $query->paginate(10);

    return view('products.index', compact('products', 'companies'));
    }


    public function create()
    {
        
        $companies = Company::all();

       
        return view('products.create', compact('companies'));
    }

   public function store(ArticleRequest $request)
{
    try {
        DB::beginTransaction();

        $product = new Product([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
        ]);

        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();

        Log::info('登録成功: ' . $product->id); 

        DB::commit();

        return redirect()->route('products.index')
            ->with('success', '商品を登録しました');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('登録失敗: ' . $e->getMessage());

        return redirect()->back()
            ->withErrors(['error' => '登録処理中にエラーが発生しました'])
            ->withInput();
    }
}


    public function show(Product $product)
   
    {
        $product->load('company');

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }

    public function update(ArticleRequest $request, Product $product)
{
    $request->validate(Product::rules(true));
    try {
        DB::beginTransaction();

    $product->product_name = $request->product_name;
    $product->company_id = $request->company_id;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->comment = $request->comment;

    if ($request->hasFile('img_path')) {
        $filename = $request->img_path->getClientOriginalName();
        $filePath = $request->img_path->storeAs('products', $filename, 'public');
        $product->img_path = '/storage/' . $filePath;
    }
    $product->save(); 

        DB::commit(); 

    return redirect()->route('products.index')
            ->with('success', '商品情報を更新しました');
    } catch (\Exception $e) {
        DB::rollBack(); 
        Log::error('商品更新エラー: ' . $e->getMessage());

        return redirect()->back()
            ->withErrors(['error' => '更新処理中にエラーが発生しました'])
            ->withInput();
    }
}


    public function destroy(Product $product)
    {
        try {
        DB::beginTransaction();

        if ($product->img_path && Storage::disk('public')->exists(str_replace('/storage/', '', $product->img_path))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->img_path));
        }
        $product->delete();

        DB::commit();

       
       return redirect()->route('products.index')
            ->with('success', '商品を削除しました');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('削除エラー: ' . $e->getMessage());

        return redirect()->back()
            ->withErrors(['error' => '削除処理中にエラーが発生しました']);
    }
}
    
     }
    


