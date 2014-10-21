!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script src="http://getangular.com/angular-1.0a.js#database=samples" type="text/javascript"></script>    
  <title>Invoice Application</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body ng-auth="eager" ng-entity="invoice=Invoice:{items:[{}]}; Customer" ng-init="customers = Customer.all()">
<div id="body">
[ <a href="index.html">List All Invoices</a> ]
  <h1>Invoice# {{invoice.no}}</h1>
  <div ng-eval="customer = customers.findById(invoice.customerId)" style="float: left;">
    <b>Ship To:</b><br/>
    {{customer.name}}<br/>
    {{customer.address1}}<br/>
    {{customer.address2}}<br/>
  </div>
<p class="fields">Invoice#
  <input type="text" name="invoice.no"/>
  <br />
  PO:
  <input type="text" name="invoice.po"/>
  <br />
  Date :
  <input class="date" type="text" name="invoice.date" ng-widget="datepicker"/> <br/>
  Ship To: <select name="invoice.customerId">
    <option value="">-- Select Customer --</option>
    <option ng-repeat="customer in customers" value="{{customer.$id}}">{{customer.name}}</option>
  </select>
  {{cu}}
</p>
<table cellspacing="0" cellpadding="3" width="100%">
  <tr>
    <th class="content" scope="col">Qty</th>
    <th width="100%" scope="col">Description</th>
    <th scope="col">Unit Cost</th>
    <th scope="col">Discount %</th>
    <th scope="col">Price</th>
    <td scope="col"><input type="button" ng-action="invoice.items.add()" value="+"/>
      &nbsp;</td>  </tr>
  <tr ng-repeat="item in invoice.items">
    <td class="content"><input name="item.qty" size="4" value="1"></td>
    <td width="100%" class="content"><input name="item.description" size="20" style="width:98%;"></td>
    <td class="content"><input name="item.cost" size="10"></td>
    <td class="content"><input name="item.discount" size="10" value="0"></td>
    <td class="content">{{item.price = (1-item.discount/100) * (item.qty * item.cost)|currency}}</td>
    <td><input type="button" ng-action="invoice.items.remove(item)" value="X"/></td>
  </tr>

  <tr>
    <td colspan="4">Sub Total:</td>
    <td class="content">{{invoice.subTotal = invoice.items.sum('price')|currency}}</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4">Tax:
      <input name="invoice.taxRate" size="4"/>
    %</td>
    <td class="content">{{invoice.tax = invoice.taxRate / 100 * invoice.subTotal|currency}}</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4">Total:</td>
    <td class="content">{{invoice.total = invoice.subTotal + invoice.tax|currency}}</td>
    <td></td>
  </tr>
</table>
<p>Options: {{invoice.options}}<br />
  <select name="invoice.options" size="3" multiple="multiple">
    <option value="gift">Gift wrap</option>
    <option value="padding">Extra padding</option>
    <option value="expedite">Expedite</option>
  </select>
</p>
<ul>
  <li>Shipped on:<span class="content">
    <input name="invoice.shipped" size="10" id="invoice.shipped" />
  </span>Tracking #<span class="content">
    <input name="invoice.tracking" size="20" id="invoice.tracking" />
    </span>
    Track: {{invoice.tracking|trackPackage}}
  <li>Received on:<span class="content">
    <input name="invoice.recived" size="10" id="invoice.recived" />
  </span>
    by
    <span class="content">
    <input name="invoice.receivedBy" size="10" />
    </span>
    <ul>
      <li>
        <input name="invoice.reciveStatus" type="radio" value="accepted"/>
        {{invoice.receivedBy}} has accepted the package</li>
      <li>
        <input type="radio" name="invoice.reciveStatus" value="rejected" />
        {{invoice.receivedBy}} has rejected the package due to:
        <ul>
          <li>
            <input name="invoice.rejectDamage" type="checkbox" value="damage"/>
            Damage.
          </li>
          <li>
            <input name="invoice.rejectIncomplete" type="checkbox" value="incomplete"/>
            Incomplete.
          </li>
        </ul>
      </li>
      </ul>
  </li>
  <li>Paid on:<span class="content">
    <input name="invoice.paid" size="10" id="item.paid" />
  </span>check# <span class="content">
  <input name="invoice.checkNo" size="5" id="item.checkNo" />
  </span></li>
  </ul>
  Notes: <br />
  <textarea name="invoice.notes" rows="5"></textarea>
  <div style="float: right;">
   {{$window.location|qrcode}}
  </div>
  <p>Notes: {{invoice.notes}}</p>
  <p>&nbsp;</p>
  <p>Thank you for your business...</p>
  <input type="submit" value="Save" />
  <input type="reset" value="Revert" />
</div>
</body>
</html>