<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Vending;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller { //商品のデータを取得してリストを表示
    public function list(Request $request) { $query = Vending::query();

    // 検索条件
    $keyword   = $request->input('keyword');
    $maker     = $request->input('maker');
    $priceMin  = $request->input('price_min');
    $priceMax  = $request->input('price_max');
    $stockMin  = $request->input('stock_min');
    $stockMax  = $request->input('stock_max');

    // 検索の絞り込み
    if (!empty($keyword)) {
        $query->where('product_name', 'LIKE', "%{$keyword}%");
    }

    if (!empty($maker)) {
        $company = Company::where('company_name', $maker)->first();
        if ($company) {
            $query->where('company_id', $company->id);
        }
    }

    if (!empty($priceMin)) {
        $query->where('price', '>=', $priceMin);
    }

    if (!empty($priceMax)) {
        $query->where('price', '<=', $priceMax);
    }

    if (!empty($stockMin)) {
        $query->where('stock', '>=', $stockMin);
    }

    if (!empty($stockMax)) {
        $query->where('stock', '<=', $stockMax);
    }

    // ソート処理
    $sort  = $request->input('sort', 'id');         // デフォルト: id
    $order = $request->input('order', 'desc');      // デフォルト: 降順
    $query->orderBy($sort, $order);

    // ページネーション + クエリ引き継ぎ
    $products = $query->paginate(7)->appends($request->all());

    $companies = Company::all();

    // Ajaxのときはテーブル部分だけ返す
    if ($request->ajax()) { return view('partials.product_table', [
        'products' => $products,
        'sort' => $sort,
        'order' => $order
        ])->render();
    }
    // 通常の表示
    return view('page.list', compact(
        'products', 'keyword', 'maker',
        'priceMin', 'priceMax', 'stockMin', 'stockMax', 'sort', 'order', 'companies'
    ));
    }

    //新規登録画面に行く
    public function registShow() { $companies = Company::all();
        return view('page.regist', ['companies' => $companies]); }


    //詳細画面に行く
    public function detailShow($id) { $product = Vending::findOrFail($id);
        return view('page.detail', compact('product')); }

    //商品の登録をする
    public function regist(ProductRequest $request) { $image_path = null;
        if ($request -> hasFile('image')) {
        $image = $request->file('image');
        $file_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $file_name);
        $image_path = 'storage/images/' . $file_name;
        }

        $model = new Vending();

        DB::beginTransaction();try {
            $model -> newregist($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {DB::rollback();
            dd($e -> getMessage());
            return back() -> withErrors(['error' => '登録に失敗しました。']);
        }
        return redirect(route('list')) -> with('success', '商品が登録されました。');
    }

    //商品の削除をする
    public function delete($id)
{
    try {
        $product = Vending::findOrFail($id);
        $product->delete();

        //ID振り直し処理
        $products = Vending::orderBy('id')->get();
        $count = 1;
        foreach ($products as $p) {
            $p->id = $count;
            $p->save();
            $count++;
        }

        // AUTO_INCREMENTのリセット
        DB::statement('ALTER TABLE products AUTO_INCREMENT = ' . $count);

        if (request()->ajax()) {
            return response()->json(['message' => '削除成功']);
        }

        return redirect(route('list'))->with('success', '商品が削除されました。');
    } catch (\Exception $e) {
        Log::error('削除処理中にエラー: ' . $e->getMessage());

        if (request()->ajax()) {
            return response()->json(['message' => '削除に失敗しました'], 500);
        }

        return back()->withErrors(['error' => '削除に失敗しました。']);
    }
    }

    //編集画面を表示する
    public function editShow($id) { $product = Vending::findOrFail($id);
        $companies = Company::all();
        return view('page.edit', compact('product', 'companies'));
    }

    //商品を編集する
    public function edit(ProductRequest $request, $id) { $product = Vending::findOrFail($id);
    DB::beginTransaction();
    try { $image_path = $product -> image; if ($request -> hasFile('image')) { $image = $request -> file('image');
            $file_name = $image -> getClientOriginalName();
            $image -> storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }
        $product->update([
            'product_name' => $request->title,
            'company_id' => $request->maker,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $image_path
        ]);
        DB::commit();
        return redirect(route('list')) -> with('success', '商品情報が更新されました。');
    } catch (\Exception $e) {
        DB::rollback();

        return back() -> withErrors(['error' => '更新に失敗しました。']);
    }
    }
}