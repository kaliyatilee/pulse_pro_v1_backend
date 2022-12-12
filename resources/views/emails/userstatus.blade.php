<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        .td_two {
            background-color: #fff;
            font-size: 16px;
            color: #000;
            font-weight: 500;
            padding: 20px;
            text-align: center;
            border-radius: 3px 3px 0 0;
            border-bottom: 1px solid #c3c3c3;
        }
    </style>
</head>

<body>
    <div style="margin: 0;  font-family: 'Raleway', sans-serif;  box-sizing: border-box;  font-size: 14px;">
        <table style=" background-color: #f6f6f6;  width: 100%; margin: 0;  font-family: 'Raleway', sans-serif;  box-sizing: border-box;  font-size: 14px;">
            <tr>
                <td width="600" style="display: block !important; max-width: 100% !important;  margin: 0 auto !important;  clear: both !important;  width: 750px;">
                    <div style="max-width: 100%;  margin: 0 auto;  display: block;  padding: 10px;">
                        <table style="margin-bottom: 0px;padding: 0px;background: #FFF;border: 1px solid #e9e9e9;border-bottom: none;" width="100%" cellspacing=0 class="booking_recepit" cellpadding=0>
                            <tr>
                                <td width="92%" bgcolor="#F36C21" align="center" style="width:40%;text-align:center; background: #F4F4F4 !important;padding: 15px;">
                                    <img src="{{ $logo }}" alt="Pulsehealth" width="150" class="imgfloat" />
                                </td>
                            </tr>
                        </table>


                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fff;  border: 1px solid #e9e9e9;  border-radius:      3px;">
                            <tr>
                                <td class="content-wrap aligncenter" style="text-align:center">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="text-align:center;padding: 0 0 20px;">
                                                <table class="invoice" style="margin: 20px auto;  text-align: left;  width: 100%;">
                                                    <tr>
                                                        <td style="padding: 5px 30px;">
                                                            <table class="invoice-items" style="width:100%; line-height: 25px;">

                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 20%;">Hi
                                                                            {{ $fullname }},<br><br> Your login status on Pulsehealth is {{ $userstatus }}. 
                                                                                <br><br>
                                                                            @if($userstatus == 'Inactive')
                                                                                Please contact administrator for reason.<br><br>
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="width: 20%;"><br>Thanks for using Pulsehealth!<br><br>Regards,<br><br>The team at Pulsehealth</td>
                                                                    </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
            </tr>
        </table>

        </div>
        </td>
        </tr>
        </table>
    </div>
</body>

</html>