<?php

namespace App\Http\Controllers;

use App\CompanyDetail;
use App\Nds;
use Illuminate\Http\Request;
use App\Invoice;
use App\Service;
use PDF;

class InvoiceController extends Controller
{
  public function export_pdf($invoice_id = 1)
  {

    $company_detail = CompanyDetail::findOrFail(1);
    $invoice = Invoice::findOrFail($invoice_id);
    $invoice->nds_10 = 0;
    $invoice->nds_18 = 0;
    $invoice->nds_20 = 0;
    $invoice->sum2str = $this->sum2words($invoice->sum);
    $invoice->load('customer', 'services');
    $i = 0;
    foreach ($invoice->services as $ser){
      $percent = Nds::findorFail($ser['nds_id'])->percent;
      $invoice->services[$i]['percent'] = $percent;
      $sum = $ser['sum'];
      switch ($percent){
        case 10:
          $invoice->nds_10 = $invoice->nds_10 + ($sum * 0.1);
          break;
        case 18:
          $invoice->nds_18  = $invoice->nds_18  + ($sum * 0.18);
          break;
        case 20:
          $invoice->nds_20 = $invoice->nds_20 + ($sum * 0.2);
          break;
      }
      $i++;
    }
    // Send data to the view using loadView function of PDF facade
    $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'company_detail' => $company_detail]);
    $path = public_path('invoices/invoice-' . $invoice->number . '.pdf');
    // If you want to store the generated pdf to the server then you can use the store function
    if ($pdf->save($path)) {
      return $path;
    } else {
      return false;
    }

  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $invoices = Invoice::all();
    $invoices->load('customer', 'project');

    return response()->json([
      'invoices' => $invoices->toArray()
    ]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'payment_date' => 'required',
      'customer_id' => 'required',
    ]);
    $number = $this->getNum();
    $services = $request->get('services');
    $invoice = new Invoice([
      'manager_id' => 1,
      'payment_date' => $request->get('payment_date'),
      'customer_id' => $request->get('customer_id'),
      'sum' => $request->get('sum'),
      'number' => $number,
      'pdf_path' => '',
    ]);
    $invoice->save();
    foreach ($services as $ser) {
      $service = new Service([
        'title' => $ser['title'],
        'price' => $ser['price'],
        'count' => $ser['count'],
        'sum' => $ser['sum'],
        'nds_id' => $ser['nds_id'],
        'invoice_id' => $invoice->id,
      ]);
      $service->save();
    }
    $invoice->pdf_path = $this->export_pdf($invoice->id);
    $invoice->save();
    $invoice->load('services');
    return response()->json($invoice->toArray());
  }

  /**
   * Get number of invoices
   *
   * @return string $num
   */
  public function getNum()
  {
    $cur = date('ym');

    $invoice = Invoice::orderBy('created_at', 'desc')->first();
    if ($invoice) {
      $num = $cur . '-' . $invoice->id;
    } else {
      $num = date('ym') . '-0';
    }
    $num = explode('-', $num);
    $num = $cur . '-' . ($num[1] + 1);
    return $num;
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $invoice = Invoice::findOrFail($id);
    $invoice->load('customer', 'services');
    $i = 0;
    foreach ($invoice->services as $ser) {
      $percent = Nds::findorFail($ser['nds_id'])->percent;
      $invoice->services[$i]['percent'] = $percent;
      $i++;
    }
    return response()->json($invoice->toArray());
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $invoice = Invoice::findOrFail($id);
    $invoice->update($request->all());
    return response()->json($invoice->toArray());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $invoice = Invoice::findOrFail($id);
    $invoice->delete();
    return response()->json('Successfully Deleted');
  }
  public function num2word($n, $words)
  {
    return ($words[($n = ($n = $n % 100) > 19 ? ($n % 10) : $n) == 1 ? 0 : (($n > 1 && $n <= 4) ? 1 : 2)]);
  }

  public function sum2words($n)
  {
    $words = array(
      900 => 'девятьсот',
      800 => 'восемьсот',
      700 => 'семьсот',
      600 => 'шестьсот',
      500 => 'пятьсот',
      400 => 'четыреста',
      300 => 'триста',
      200 => 'двести',
      100 => 'сто',
      90 => 'девяносто',
      80 => 'восемьдесят',
      70 => 'семьдесят',
      60 => 'шестьдесят',
      50 => 'пятьдесят',
      40 => 'сорок',
      30 => 'тридцать',
      20 => 'двадцать',
      19 => 'девятнадцать',
      18 => 'восемнадцать',
      17 => 'семнадцать',
      16 => 'шестнадцать',
      15 => 'пятнадцать',
      14 => 'четырнадцать',
      13 => 'тринадцать',
      12 => 'двенадцать',
      11 => 'одиннадцать',
      10 => 'десять',
      9 => 'девять',
      8 => 'восемь',
      7 => 'семь',
      6 => 'шесть',
      5 => 'пять',
      4 > 'четыре',
      3 => 'три',
      2 => 'два',
      1 => 'один',
    );

    $level = array(
      4 => array('миллиард', 'миллиарда', 'миллиардов'),
      3 => array('миллион', 'миллиона', 'миллионов'),
      2 => array('тысяча', 'тысячи', 'тысяч'),
    );
    list($rub, $kop) = explode('.', number_format($n, 2));
    $parts = explode(',', $rub);

    for ($str = '', $l = count($parts), $i = 0; $i < count($parts); $i++, $l--) {
      if (intval($num = $parts[$i])) {
        foreach ($words as $key => $value) {
          if ($num >= $key) {
            // Fix для одной тысячи
            if ($l == 2 && $key == 1) {
              $value = 'одна';
            }
            // Fix для двух тысяч
            if ($l == 2 && $key == 2) {
              $value = 'две';
            }
            $str .= ($str != '' ? ' ' : '') . $value;
            $num -= $key;
          }
        }
        if (isset($level[$l])) {
          $str .= ' ' . $this->num2word($parts[$i], $level[$l]);
        }
      }
    }

    if (intval($rub = str_replace(',', '', $rub))) {
      $str .= ' ' . $this->num2word($rub, array('рубль', 'рубля', 'рублей'));
    }

    $str .= ($str != '' ? ' ' : '') . $kop;
    $str .= ' ' . $this->num2word($kop, array('копейка', 'копейки', 'копеек'));

    return mb_strtoupper(mb_substr($str, 0, 1, 'utf-8'), 'utf-8') .
      mb_substr($str, 1, mb_strlen($str, 'utf-8'), 'utf-8');
  }
}
