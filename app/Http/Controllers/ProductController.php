<?php

namespace App\Http\Controllers;

use App\Models\Vending;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class ProductController extends Controller
{
    //商品のデータを取得してリストを表示
    public function list() { $products = Vending::paginate(7);
        $companies = Company::all();
        $keyword = '';
        $maker = '';
        return view('page.list', compact('products', 'keyword', 'maker', 'companies')); }


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

    //商品を削除する
    public function delete($id) { DB::beginTransaction();
        try { $product = Vending::findOrFail($id);
            $product->delete();
            //削除した時IDがリセットされるようにする
            $products = Vending::orderBy('id')->get();
            $count = 1;
            foreach ($products as $product) { $product->id = $count;
                $product->save();
                $count++;
            }

            // AUTO_INCREMENTをリセット
            DB::statement('ALTER TABLE products AUTO_INCREMENT = ' . $count);

            DB::commit();
            return redirect(route('list'))->with('success', '商品が削除されました。');
        } catch (\Exception $e) {
            DB::rollback();
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
        dd($e -> getMessage());
        return back() -> withErrors(['error' => '更新に失敗しました。']);
    }
    }

    // 商品を検索する
    public function search(Request $request) { $query = Vending::query();
    $keyword = $request -> input('keyword');
    $maker = $request -> input('maker'); if (!empty($keyword)) { $query -> where('product_name', 'LIKE', "%{$keyword}%");
    }
    if (!empty($maker)) { $company = Company::where('company_name', $maker)->first();
        if ($company) { $query->where('company_id', $company->id);
        }
    }
    $products = $query->paginate(7);
    $companies = Company::all();

    return view('page.list', compact('products', 'keyword', 'maker', 'companies'));
    }


}