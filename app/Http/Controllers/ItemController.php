<?php

namespace App\Http\Controllers;

use App\Item;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        $this->validate($request, [
            'type' => 'required|string'
        ]);
        $items = [];
        switch ($request->type){
            case 'all':
                $items = Item::all();
                break;
            case 'in':
                $items = Item::where('quantity', '>', 0)->get();
                break;
            case 'out':
                $items = Item::where('quantity', '<', 1)->get();
                break;
        }
        return response()->json([
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        //
        $item = Item::create([
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'quantity' => $request->quantity,
            'store_box' => $request->store_box
        ]);
        return response()->json(['success'=>'Item added successfully']);
    }

    public function show($id)
    {
        $__item = Item::findOrFail($id);
        $__item['number_of_sales'] = count($__item->sales);

        $item_sales_ = Sale::all()->where('item_id', $__item->id)
            ->groupBy(function ($val){
                return $val->cart_id;
        });

        foreach ($item_sales_ as $index=>$ordered_sale){
            $first_sale = $ordered_sale[0];
            $first_sale['user'] = $first_sale->user;
            $first_sale['date'] = Carbon::parse($first_sale->created_at)->toTimeString();
            $total_profit_ = 0;
            $total_income_ = 0;
            foreach ($ordered_sale as $item_)
            {
                $item = $item_->item;
                $item_['item'] = $item;
                $total_income_ += $item_->price;
                $total_profit_ += $item_->profit;
            }
            $first_sale['total_income'] = $total_income_;
            $first_sale['total_profit'] = $total_profit_;
        }

        return response()->json([
            'item' => $__item,
            'sales' => $item_sales_,
        ]);
    }

    public function update(Request $request)
    {
        //
        $item = Item::findOrFail($request->id);
        $item->name = $request->name;
        $item->purchase_price = $request->purchase_price;
        $item->selling_price = $request->selling_price;
        $item->quantity = $request->quantity;
        $item->store_box = $request->store_box;
        $item->update();
        return response()->json(['success' => 'Item ('.$item->name.') updated successfully']);
    }

    public function destroy(Request $request)
    {
        //
        $item = Item::findOrFail($request->id);
        if ($item->delete()){
            return response()->json(['success'=>'Item Removed Successfully']);
        }

    }

}
