<?php

namespace App\Http\Controllers;

use App\Item;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function overall(){
        $sales = Sale::all();
        $ordered_sales = Sale::all()
            ->groupBy(function ($val){
                return $val->cart_id;
            });
        $total_income = 0;
        $total_profit = 0;

        $items = Item::all();
        $items_out_of_stock = count(Item::where('quantity', '<', 1)->get());
        $items_instock = count(Item::where('quantity', '>', 0)->get());
        $total_items_left= count($items);
        $total_items_price = 0;
        $total_expenses = 0;

        foreach ($items as $_item){
            $total_items_price += $_item->selling_price;
            $total_expenses += $_item->purchase_price;
        }

        // get total income and total profit
        foreach ($sales as $sale){
            // total income
            $total_income += $sale->price;

            // total profit
//            $selling_price = $sale->item->selling_price;
//            $purchase_price = $sale->item->purchase_price;
//            $sale_profit = $selling_price - $purchase_price;
            $total_profit += $sale->profit;
        }


        foreach ($ordered_sales as $index=>$ordered_sale){
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

        return [
            'sales' => $ordered_sales,
            'total_sales' => count($sales),
            'total_income' => $total_income,
            'total_profit' => $total_profit,
            'items_out_of_stock' => $items_out_of_stock,
            'items_instock' => $items_instock,
            'total_items_left' => $total_items_left,
            'total_items_price' => $total_items_price,
            'total_expenses' => $total_expenses,
        ];

    }

    public function get_single_day(Request $request){
        $this->validate($request, [
            'date' => 'required'
        ]);
        $total_income = 0;
        $total_profit = 0;
        $date = Carbon::parse($request->date)->toDateString();
        $ordered_sales = Sale::all()->whereBetween('created_at', [$date." 00:00:00", $date." 23:59:59"])
            ->groupBy(function ($val){
            return $val->cart_id;
        });
        $sales = Sale::whereDate('created_at', $date)->get();

        // get total income and total profit
        foreach ($sales as $sale){
            // total income
            $total_income += $sale->price;

            // total profit
//            $selling_price = $sale->item->selling_price;
//            $purchase_price = $sale->item->purchase_price;
//            $sale_profit = $selling_price - $purchase_price;
            $total_profit += $sale->price;
        }

        // append sale->user and sale->item to sale
        foreach ($ordered_sales as $index=>$ordered_sale){
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


        return [
            'sales' => $ordered_sales,
            'total_sales' => count($sales),
            'total_income' => $total_income,
            'total_profit' => $total_profit,
        ];
    }

    public function get_range(Request $request){
        $this->validate($request, [
            'start' => 'required',
            'end' => 'required'
        ]);
        $start = Carbon::parse($request->start)->toDateString();
        $end = Carbon::parse($request->end)->toDateString();
        $sales = Sale::whereBetween('created_at', [$start." 00:00:00", $end." 23:59:59"])->get();
        $ordered_sales = Sale::all()->whereBetween('created_at', [$start." 00:00:00", $end." 23:59:59"])
            ->groupBy(function ($val){
                return $val->cart_id;
            });

        $total_income = 0;
        $total_profit = 0;

        // append sale->user and sale->item to sale
        foreach ($ordered_sales as $index=>$ordered_sale){
            $first_sale = $ordered_sale[0];
            $first_sale['user'] = $first_sale->user;
            $first_sale['date'] = Carbon::parse($first_sale->created_at)->toDayDateTimeString();
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

        // get total income and total profit
        foreach ($sales as $sale){
            // total income
            $total_income += $sale->price;

            // total profit
//            $selling_price = $sale->item->selling_price;
//            $purchase_price = $sale->item->purchase_price;
//            $sale_profit = $selling_price - $purchase_price;
            $total_profit += $sale->profit;
        }

        return [
            'sales' => $ordered_sales,
            'total_sales' => count($sales),
            'total_income' => $total_income,
            'total_profit' => $total_profit,
        ];
    }

}
