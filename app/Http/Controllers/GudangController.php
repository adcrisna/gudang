<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\HistoryProduct;
use Redirect;
use Auth;
use DB;
use App\Models\Lokasi;

class GudangController extends Controller
{
    public function index(){
        $data['title'] = "Gudang";
        $data['nama'] = Auth::user()->name;
        return view('Gudang/index',$data);
    }

    public function dataProduct(){
        $data['title'] = "Data Products";
        $data['nama'] = Auth::user()->name;
        $data['product'] = Product::all();
        $data['lokasi'] = Lokasi::all();
        return view('Gudang/dataProducts',$data);
    }

    public function dataHistory(){
        $data['title'] = "Data History";
        $data['nama'] = Auth::user()->name;
        $data['product'] = HistoryProduct::where('user_id',Auth::user()->id)->get();
        return view('Gudang/dataHistory',$data);
    }

    public function addProduct(Request $request)
    {
        DB::beginTransaction();

        try {
            $namafoto = "Gambar"."  ".$request->name." ".date("Y-m-d H-i-s");
            $extention = $request->file('gambar')->extension();
            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/gambar';
            $request->file('gambar')->move($destination,$photo);

            $product = New Product;
            $product->name = $request->name;
            $product->merk = $request->merk;
            $product->stok_awal = $request->stok;
            $product->stok = $request->stok;
            $product->lokasi_id = $request->lokasi;
            $product->user_id = Auth::user()->id;
            $product->gambar = $photo;
            $product->created_at = date("Y-m-d H:i:s");
            $product->updated_at = date("Y-m-d H:i:s");
            $product->save();

            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Ditambah!');
            return Redirect::route('gudang.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('gudang.product');
        }
    }
    public function updateProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            if (empty($request->gambar)) {
                $product = Product::find($request->id);
                $product->name = $request->name;
                $product->merk = $request->merk;
                $product->stok_awal = $request->stok_awal;
                $product->stok = $request->stok;
                $product->lokasi_id = $request->lokasi;
                $product->user_id = Auth::user()->id;
                $product->created_at = date("Y-m-d H:i:s");
                $product->updated_at = date("Y-m-d H:i:s");
                $product->save();
            }else{
                $product = Product::find($request->id);

                \File::delete(public_path('gambar/'.$product->gambar));

                $namafoto = "Gambar"."  ".$request->name." ".date("Y-m-d H-i-s");
                $extention = $request->file('gambar')->extension();
                $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                $destination = base_path() .'/public/gambar';
                $request->file('gambar')->move($destination,$photo);

                $product->name = $request->name;
                $product->merk = $request->merk;
                $product->stok_awal = $request->stok_awal;
                $product->stok = $request->stok;
                $product->lokasi_id = $request->lokasi;
                $product->user_id = Auth::user()->id;
                $product->gambar = $photo;
                $product->created_at = date("Y-m-d H:i:s");
                $product->updated_at = date("Y-m-d H:i:s");
                $product->save();
            }

            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Diubah!');
            return Redirect::route('gudang.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('gudang.product');
        }
    }
    
    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $getProduct = Product::where('id',$id)->first();
            \File::delete(public_path('gambar/'.$getProduct->gambar));
            $product = Product::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Dihapus!');
            return Redirect::route('gudang.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('gudang.product');
        }
    }
    public function transaksi(Request $request)
    {
        
        DB::beginTransaction();
        try {

            if ($request->status == 'Pengembalian') {
                $barang = Product::find($request->id);
                $cekStok = $barang->stok + $request->jumlah;
                if ($cekStok > $barang->stok_awal) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok Awal!');
                    return Redirect::route('gudang.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang->stok = $barang->stok + $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Peminjaman') {
                if ($request->jumlah > $request->stok) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('gudang.product');
                }

                if ($request->stok <= 0) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('gudang.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok - $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Keluar') {
                if ($request->jumlah > $request->stok) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('gudang.product');
                }

                if ($request->stok <= 0) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('gudang.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok - $request->jumlah;
                $barang->stok_awal = $barang->stok_awal - $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Masuk') {
                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok + $request->jumlah;
                $barang->stok_awal = $barang->stok_awal + $request->jumlah;
                $barang->save();
            }

            DB::commit();
            \Session::flash('msg_success','Berhasil Melakukan Transaksi!');
            return Redirect::route('gudang.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('gudang.product');
        }
    }
}
