<!DOCTYPE html>
<html>
<head>
<title>Mail</title>
</head>
@php
  date_default_timezone_set("asia/Kolkata");  
  extract($mailData);
  $dateflow= date_create($createtime); 
	$createtime = date_format($dateflow,"d-m-Y h:i A");
  //$createtime=date('d-m-Y H:m A',strtotime($createtime));
  $time = date('d-m-Y' ,strtotime($time));
@endphp
  <body style="font-family: calibri,arial;">
    <div style="font-size: 13pt;">
        Dear Team,
        <br/><br/>
        @if($steps==1)
          {{$username}} has created a new payment collection with the details below at {{date("d-m-Y h:i:s A")}}:         
        @elseif(($steps==2))
            {{$username}} has collected the payment from {{$guest}} at {{date("d-m-Y h:i:s A")}}.
        @elseif(($steps==3))
            {{$username}} has received the payment from {{$sender}} at {{date("d-m-Y h:i:s A")}}.
        @elseif(($steps==4))
            {{$username}} has settled the Payment at {{date("d-m-Y h:i:s A")}}.
          @elseif(( $steps == 5))
            {{$username}} has Modification payment details at {{date("d-m-Y h:i:s A")}}.
        @endif

        <p>Payment Details:</p>
        <table width="600" border="1" cellspacing="0" cellpadding="8" style="text-align: left; font-family: calibri,arial; border:1px solid #ccc; border-collapse:collapse; text-align: left;">
          <tr>
            <th> Payment Ref. No. </th>
            <td> {{$income_ref_no}} </td>
          </tr>
          <tr>
            <th> Payment Creation time </th>
            <td> {{$createtime}} </td>
          </tr>
          <tr>
            <th> Guest Name </th>
            <td> {{$guest}} </td>
          </tr>
          <tr>
            <th> Guest Email </th>
            <td> {{$email}} </td>
          </tr>
          <tr>
            <th> Guest phone </th>
            <td> {{$phone}} </td>
          </tr>
          <tr>
            <th> Amount </th>
            <td>{{$currency}} {{ number_format($amount,2)}} </td>
          </tr>
          <tr>
            <th> Services </th>
            <td> {{$services}} </td>
          </tr>
          <tr>
            <th> Collection Date </th>
            <td> {{$time}} </td>
          </tr>
        </table>
        <br>
        <p>
            {{-- <a href="http://192.168.2.7/cashcollectrole/public/dashboard/income/view/{{bin2hex($income_ref_no)}}"><u> Click here to login & view payments details </u></a> --}}
            <a href="https://cash.indianholiday.com/dashboard/income/income/view/{{bin2hex($income_ref_no)}}"><u> Click here to login & view payments details </u></a>
        </p>
        <p>
            Thank You
        </p>
        <p>
            IHPL Cash Collection
        </p>
      </div>
  </body>
</html>