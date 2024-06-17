<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        /* reset */
        * {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
            vertical-align: top;
        }

        /* content editable */
        *[contenteditable] {
            border-radius: 0.25em;
            outline: 0;
        }

        *[contenteditable] {
            cursor: pointer;
        }

        span[contenteditable] {
            display: inline-block;
        }

        /* heading */
        h1 {
            font: bold 100% sans-serif;
            letter-spacing: 0.5em;
            text-align: center;
            text-transform: uppercase;
        }

        /* table */
        table {
            table-layout: fixed;
            width: 100%;
        }

        table {
            border-collapse: separate;
            border-spacing: 2px;
        }

        th,
        td {
            border-width: 1px;
            padding: 0.5em 0.95em;
            position: relative;
            text-align: left;
            border-radius: 0;
        }

        th,
        td {
            border-radius: 0;
            height: 40px;
            vertical-align: middle;
            border-style: solid;
            font-size: 10px;
            text-transform: uppercase;
        }

        th {
            background: #EEE;
            border-color: #BBB;
        }

        td {
            border-color: #DDD;
        }

        /* page */
        html {
            font: 16px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
        }

        html {
            background: #999;
            cursor: default;
        }

        body {
            box-sizing: border-box;
            min-height: 11in;
            height: auto;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.5in;
            width: 8.5in;
        }

        body {
            background: #FFF;
            border-radius: 1px;
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        }

        /* table meta */
        table.meta th {
            width: 40%;
        }

        table.meta td {
            width: 60%;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }

            html {
                background: none;
                padding: 0;
            }

            body {
                box-shadow: none;
                margin: 0;
            }

            span:empty {
                display: none;
            }
        }

        @page {
            margin: 0;
        }

        header td {
            border-color: #DDD;
            border: 0px solid;
        }

        .blueBg {
            background-color: #1f4e79;
            color: #fff;
            font-weight: 500;
        }

        th,
        td {
            border: 0.5px solid #ddd;
        }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td style="width: 150px;">
                    <img src="https://www.pocketstudionepal.com/images/baliyo-logo.png" alt="">
                </td>
                <td>
                    <h5
                        style="font-weight: 700; color: #212121; font-size: 23px;text-transform: uppercase;margin: 8px 0;">
                        Pocket Studio
                    </h5>
                    <p style="font-size:16px;">Naxal, Narayanchaur</p>
                </td>
            </tr>
        </table>
    </header>
    <table>
        <tr>
            <td style="text-align: center;border: 0px solid; margin-bottom: 10px;">
                <h6 style="font-weight: 700; color: #212121; font-size: 22px;text-transform: capitalize;">Travel
                    Authorizaton Form
                </h6>
            </td>
        </tr>
    </table>
    <table style="margin-bottom: 10px;">
        <tr>
            <td style="text-align: right;border: 0px solid; margin-bottom: 10px;">
                <p>Date: {{ $submitted_date }}</p>
            </td>
        </tr>
    </table>
    <table class=" meta" style=" border-spacing: 0;">
        <tr>
            <th class="blueBg"><span contenteditable>Name of Employee</span></th>
            <td><span contenteditable>{{ $submitted_name }}</span></td>
        </tr>
        <tr>
            <th class="blueBg"><span contenteditable>Traveling for (Name of Program)</span></th>
            <td><span contenteditable>{{ $program_name }}</span></td>
        </tr>
        <tr>
            <th class="blueBg"><span contenteditable>Place of Field Visit</span></th>
            <td><span contenteditable>{{ $place }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg"><span contenteditable>Date of Visit</span></th>
            <th class="blueBg"><span contenteditable>From</span></th>
            <td><span contenteditable>{{ $from }}</span></td>
            <th class="blueBg"><span contenteditable>To</span></th>
            <td><span contenteditable>{{ $to }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg" style="width: 100%;"><span contenteditable>Traveling Purpose</span></th>
        </tr>
        <tr>
            <td style="width: 100%;height: 100px; vertical-align: top;"><span contenteditable>{{ $purpose }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg"><span contenteditable>MODE OF TRAVEL:</span></th>
            <td><span contenteditable>{{ $travel_mode }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg"><span contenteditable>Other Travel Mode</span></th>
            <td><span contenteditable>{{ $other_travel_mode }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg" style="width: 100%;"><span contenteditable>Remarks and Justifications</span></th>
        </tr>
        <tr>
            <td style="width: 100%;height: 100px; vertical-align: top;"><span contenteditable>{{ $justification }}</span></td>
        </tr>
        <tr>
            <th class="blueBg" style="width: 100%;"><span contenteditable>Advance Request</span></th>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <td style="width: 200px;text-align: center;border: 0px solid; padding: 0;">
                <table style="width:100%;border-spacing:0;">
                    <tr>
                        <th colspan="3 " class="blueBg" style="border: 1px solid #ddd;text-align: center; ">Accomodation
                        </th>
                    </tr>
                    <tr>
                        <th class="blueBg" style="    padding: 0 7px;
                        "> Days</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Per Diem</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Total</th>
                    </tr>
                    <tr>
                        <td>{{ $accommodation_day }}</td>
                        <td>{{ $accommodation_per_diem }}</td>
                        <td>{{ $accommodation_total }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 200px;text-align: center;border: 0px solid; padding: 0;">
                <table style="width:100%;border-spacing:0;">
                    <tr>
                        <th colspan="3 " class="blueBg" style="border: 1px solid #ddd;text-align: center; ">Daily
                            Allowance
                        </th>
                    </tr>
                    <tr>
                        <th class="blueBg" style="    padding: 0 7px;
                        "> Days</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Per Diem</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Total</th>
                    </tr>
                    <tr>
                        <td>{{ $daily_allowance_day }}</td>
                        <td>{{ $daily_allowance_per_diem }}</td>
                        <td>{{ $daily_allowance_total }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 200px;text-align: center;border: 0px solid; padding: 0;">
                <table style="width:100%;border-spacing:0;">
                    <tr>
                        <th colspan="3 " class="blueBg" style=" border: 1px solid #ddd;text-align: center; ">Travel(*)
                        </th>
                    </tr>
                    <tr>
                        <th class="blueBg" style="    padding: 0 7px;
                        "> Days</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Per Diem</th>
                        <th class="blueBg" style="    padding: 0 7px;
                        ">Total</th>
                    </tr>
                    <tr>
                        <td>{{ $contingency_day }}</td>
                        <td>{{ $contingency_per_diem }}</td>
                        <td>{{ $contingency_total }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 100%;text-align: center;border: 0px solid; padding: 0;">
                <table style="width:100%;border-spacing:0;">
                    <tr>
                        <th class="blueBg" style="border: 1px solid #ddd;text-align: center; ">Advance Taken</th>
                    </tr>
                    <tr>
                        <th class="blueBg">Total</th>
                    </tr>
                    <tr>
                        <td>{{ $advance_taken }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg" style="width: 100%;"><span contenteditable>Remarks (*)</span></th>
        </tr>
        <tr>
            <td style="width: 100%;height: 100px; vertical-align: top;"><span contenteditable>{{ $remarks }}</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg" style="width: 100%;text-align: center;"><span contenteditable>Submitted By</span></th>
            <th class="blueBg" style="width: 100%;text-align: center;"><span contenteditable>Recommended By</span></th>
            <th class="blueBg" style="width: 100%;text-align: center;"><span contenteditable>Approved By</span></th>
        </tr>
        <tr>
            <td style="width: 100%;height: 100px; vertical-align: bottom; text-align: center;"><span
                    contenteditable>{{ $submitted_name }} <br> {{ $submitted_dept }}</span></td>
            <td style="width: 100%;height: 100px; vertical-align: bottom; text-align: center;"><span
                    contenteditable>.....................................</span></td>
            <td style="width: 100%;height: 100px; vertical-align: bottom; text-align: center;"><span
                    contenteditable>.....................................</span></td>
        </tr>
        <tr>
            <td style="width: 100%;"><span contenteditable>Date: {{ $submitted_date }}</span></td>
            <td style="width: 100%;"><span contenteditable>Date:</span></td>
            <td style="width: 100%;"><span contenteditable>Date:</span></td>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg" style="width: 100%;"><span contenteditable>FOR RESPECTIVE DEPARTMENT USE ONLY:</span>
            </th>
        </tr>
    </table>
    <table style=" border-spacing: 0;">
        <tr>
            <th class="blueBg"><span contenteditable>Requested On:</span></th>
            <td><span contenteditable></span></td>
            <th class="blueBg"><span contentediBtable>From</span></th>
            <td><span contenteditable></span></td>
            <th class="blueBg"><span contenteditable>Signature</span></th>
            <td><span contenteditable></span></td>
        </tr>
    </table>
</body>
</html>
