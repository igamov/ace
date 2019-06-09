<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <style type="text/css">
    * {
      font-family: arial;
      font-size: 14px;
      line-height: 14px;
    }
    table {
      margin: 0 0 15px 0;
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
    }
    table td {
      padding: 5px;
    }
    table th {
      padding: 5px;
      font-weight: bold;
    }

    .header {
      margin: 0 0 0 0;
      padding: 0 0 15px 0;
      font-size: 12px;
      line-height: 12px;
      text-align: center;
    }

    /* Реквизиты банка */
    .details td {
      padding: 3px 2px;
      border: 1px solid #000000;
      font-size: 12px;
      line-height: 12px;
      vertical-align: top;
    }

    h1 {
      margin: 0 0 10px 0;
      padding: 10px 0 10px 0;
      border-bottom: 2px solid #000;
      font-weight: bold;
      font-size: 20px;
    }

    /* Поставщик/Покупатель */
    .contract th {
      padding: 3px 0;
      vertical-align: top;
      text-align: left;
      font-size: 13px;
      line-height: 15px;
    }
    .contract td {
      padding: 3px 0;
    }

    /* Наименование товара, работ, услуг */
    .list thead, .list tbody  {
      border: 2px solid #000;
    }
    .list thead th {
      padding: 4px 0;
      border: 1px solid #000;
      vertical-align: middle;
      text-align: center;
    }
    .list tbody td {
      padding: 0 2px;
      border: 1px solid #000;
      vertical-align: middle;
      font-size: 11px;
      line-height: 13px;
    }
    .list tfoot th {
      padding: 3px 2px;
      border: none;
      text-align: right;
    }

    /* Сумма */
    .total {
      margin: 0 0 20px 0;
      padding: 0 0 10px 0;
      border-bottom: 2px solid #000;
    }
    .total p {
      margin: 0;
      padding: 0;
    }

    /* Руководитель, бухгалтер */
    .sign {
      position: relative;
    }
    .sign table {
      width: 60%;
    }
    .sign th {
      padding: 40px 0 0 0;
      text-align: left;
    }
    .sign td {
      padding: 40px 0 0 0;
      border-bottom: 1px solid #000;
      text-align: right;
      font-size: 12px;
    }

    .sign-1 {
      position: absolute;
      left: 149px;
      top: -44px;
    }
    .sign-2 {
      position: absolute;
      left: 149px;
      top: 0;
    }
    .printing {
      position: absolute;
      left: 271px;
      top: -15px;
    }
  </style>
</head>
<body>

<table class="details">
  <tbody>
  <tr>
    <td colspan="2" style="border-bottom: none;">{{$company_detail->bank}}</td>
    <td>БИК</td>
    <td style="border-bottom: none;">{{$company_detail->bik}}</td>
  </tr>
  <tr>
    <td colspan="2" style="border-top: none; font-size: 10px;">Банк получателя</td>
    <td>Сч. №</td>
    <td style="border-top: none;">{{$company_detail->ks}}</td>
  </tr>
  <tr>
    <td width="25%">ИНН {{$company_detail->inn}}</td>
    <td width="30%">@isset ($company_detail->kpp) КПП {{$company_detail->kpp}}@endisset</td>
    <td width="10%" rowspan="3">Сч. №</td>
    <td width="35%" rowspan="3">{{$company_detail->rs}}</td>
  </tr>
  <tr>
    <td colspan="2" style="border-bottom: none;">{{$company_detail->legal_name}}</td>
  </tr>
  <tr>
    <td colspan="2" style="border-top: none; font-size: 10px;">Получатель</td>
  </tr>
  </tbody>
</table>

<h1>Счет на оплату № {{$invoice->number}} от {{ Date::parse($invoice->created_at)->format('j F Y г.') }}</h1>

<table class="contract">
  <tbody>
  <tr>
    <td width="15%">Поставщик:</td>
    <th width="85%">
      {{$company_detail->legal_name}}, ИНН {{$company_detail->inn}}, КПП {{$company_detail->kpp}}, {{$company_detail->legal_address}}
    </th>
  </tr>
  <tr>
    <td>Покупатель:</td>
    <th>
      {{$invoice->customer['legal_name']}}, ИНН {{$invoice->customer['inn']}}, КПП {{$invoice->customer['kpp']}}@isset ($invoice->customer['legal_address']), {{$invoice->customer['legal_address']}}@endisset
    </th>
  </tr>
  </tbody>
</table>

<table class="list">
  <thead>
  <tr>
    <th width="5%">№</th>
    <th width="47%">Наименование товара, работ, услуг</th>
    <th width="10%">Количество</th>
    <th width="10%">НДС</th>
    <th width="14%">Цена</th>
    <th width="14%">Сумма</th>
  </tr>
  </thead>
  <tbody>
  @foreach($invoice->services as $service)
    {{$i = 1}}
  <tr>
    <td align="center">{{$i}}</td>
    <td align="left">{{$service->title}}</td>
    <td align="right">{{$service->count}}</td>
    <td align="right">{{$service->percent}} %</td>
    <td align="right">@double($service->price)</td>
    <td align="right">@double($service->sum)</td>
  </tr>
    {{$i++}}
  @endforeach
  </tbody>
  <tfoot>
  @if ($invoice->nds_10 != 0)
    <tr>
      <th colspan="5">НДС 10%:</th>
      <th>@double($invoice->nds_10)</th>
    </tr>
  @endif
  @if ($invoice->nds_18 != 0)
    <tr>
      <th colspan="5">НДС 18%:</th>
      <th>@double($invoice->nds_18)</th>
    </tr>
  @endif
  @if ($invoice->nds_20 != 0)
    <tr>
      <th colspan="5">НДС 20%:</th>
      <th>@double($invoice->nds_20)</th>
    </tr>
  @endif
  <tr>
    <th colspan="5">Итого к оплате:</th>
    <th>@double($invoice->sum)</th>
  </tr>

  </tfoot>
</table>
<div class="total">
  <p>Всего наименований на сумму @double($invoice->sum) руб.</p>
  <p><strong>{{$invoice->sum2str}}</strong></p>
</div>
<div class="sign">
  <table>
    <tbody>
    <tr>
      <th width="30%">Руководитель</th>
      <td width="70%">{{$company_detail->director}}</td>
    </tr>
    <tr>
      <th>Бухгалтер</th>
      <td>{{$company_detail->accountant}}</td>
    </tr>
    </tbody>
  </table>
</div>
</body>
</html>