@extends('user.layout.master')

@section('styles')
<style type="text/css">
        .lst-kix_list_2-6>li:before {
            content: "\0025aa  "
        }
        
        .lst-kix_list_2-7>li:before {
            content: "\0025aa  "
        }
        
        ul.lst-kix_list_1-0 {
            list-style-type: none
        }
        
        .lst-kix_list_2-4>li:before {
            content: "\0025aa  "
        }
        
        .lst-kix_list_2-5>li:before {
            content: "\0025aa  "
        }
        
        .lst-kix_list_2-8>li:before {
            content: "\0025aa  "
        }
        
        .lst-kix_list_3-0>li:before {
            content: "\0025cf  "
        }
        
        .lst-kix_list_3-1>li:before {
            content: "\0025cb  "
        }
        
        .lst-kix_list_3-2>li:before {
            content: "\0025a0  "
        }
        
        ul.lst-kix_list_3-7 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-8 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-3 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-1 {
            list-style-type: none
        }
        
        .lst-kix_list_3-5>li:before {
            content: "\0025a0  "
        }
        
        ul.lst-kix_list_1-4 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-2 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-1 {
            list-style-type: none
        }
        
        .lst-kix_list_3-4>li:before {
            content: "\0025cb  "
        }
        
        ul.lst-kix_list_1-2 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-0 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-7 {
            list-style-type: none
        }
        
        .lst-kix_list_3-3>li:before {
            content: "\0025cf  "
        }
        
        ul.lst-kix_list_3-5 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-8 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-6 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-5 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-3 {
            list-style-type: none
        }
        
        ul.lst-kix_list_1-6 {
            list-style-type: none
        }
        
        ul.lst-kix_list_3-4 {
            list-style-type: none
        }
        
        .lst-kix_list_3-8>li:before {
            content: "\0025a0  "
        }
        
        .lst-kix_list_3-6>li:before {
            content: "\0025cf  "
        }
        
        .lst-kix_list_3-7>li:before {
            content: "\0025cb  "
        }
        
        ul.lst-kix_list_2-8 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-2 {
            list-style-type: none
        }
        
        .lst-kix_list_1-0>li:before {
            content: "\0025cf  "
        }
        
        ul.lst-kix_list_2-3 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-0 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-1 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-6 {
            list-style-type: none
        }
        
        .lst-kix_list_1-1>li:before {
            content: "\0025cb  "
        }
        
        .lst-kix_list_1-2>li:before {
            content: "\0025a0  "
        }
        
        ul.lst-kix_list_2-7 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-4 {
            list-style-type: none
        }
        
        ul.lst-kix_list_2-5 {
            list-style-type: none
        }
        
        .lst-kix_list_1-3>li:before {
            content: "\0025cf  "
        }
        
        .lst-kix_list_1-4>li:before {
            content: "\0025cb  "
        }
        
        .lst-kix_list_1-7>li:before {
            content: "\0025cb  "
        }
        
        .lst-kix_list_1-5>li:before {
            content: "\0025a0  "
        }
        
        .lst-kix_list_1-6>li:before {
            content: "\0025cf  "
        }
        
        li.li-bullet-0:before {
            margin-left: -18pt;
            white-space: nowrap;
            display: inline-block;
            min-width: 18pt
        }
        
        .lst-kix_list_2-0>li:before {
            content: "\0025cf  "
        }
        
        .lst-kix_list_2-1>li:before {
            content: "o  "
        }
        
        .lst-kix_list_1-8>li:before {
            content: "\0025a0  "
        }
        
        .lst-kix_list_2-2>li:before {
            content: "\0025aa  "
        }
        
        .lst-kix_list_2-3>li:before {
            content: "\0025aa  "
        }
        
        ol {
            margin: 0;
            padding: 0
        }
        
        table td,
        table th {
            padding: 0
        }
        
        .c10 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 20.2pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c19 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 464.9pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c2 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 72.8pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c16 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 29.2pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c7 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 50.2pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c6 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 75pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c14 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 70.5pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c3 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 53.2pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c8 {
            border-right-style: solid;
            padding: 5pt 5pt 5pt 5pt;
            border-bottom-color: #000000;
            border-top-width: 1pt;
            border-right-width: 1pt;
            border-left-color: #000000;
            vertical-align: top;
            border-right-color: #000000;
            border-left-width: 1pt;
            border-top-style: solid;
            border-left-style: solid;
            border-bottom-width: 1pt;
            width: 34.5pt;
            border-top-color: #000000;
            border-bottom-style: solid
        }
        
        .c25 {
            color: #404040;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 21pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c4 {
            color: #262626;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 10pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c15 {
            color: #ff0000;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 11pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c0 {
            color: #262626;
            font-weight: 100;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 29pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c11 {
            color: #262626;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 11pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c13 {
            color: #000000;
            font-weight: 400;
            text-decoration: none;
            vertical-align: baseline;
            font-size: 11pt;
            font-family: "Poppins";
            font-style: normal
        }
        
        .c1 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        .c29 {
            -webkit-text-decoration-skip: none;
            text-decoration: underline;
            vertical-align: baseline;
            text-decoration-skip-ink: none;
            font-size: 14pt;
            font-style: normal
        }
        
        .c17 {
            padding-top: 12pt;
            padding-bottom: 12pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        .c26 {
            padding-top: 12pt;
            padding-bottom: 12pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: center
        }
        
        .c33 {
            -webkit-text-decoration-skip: none;
            color: #1155cc;
            font-weight: 400;
            text-decoration: underline;
            text-decoration-skip-ink: none;
            font-family: "Poppins"
        }
        
        .c22 {
            padding-top: 0pt;
            padding-bottom: 8pt;
            line-height: 1.0791666666666666;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        .c31 {
            padding-top: 12pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        .c27 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            orphans: 2;
            widows: 2;
            text-align: center
        }
        
        .c54 {
            padding-top: 0pt;
            padding-bottom: 8pt;
            line-height: 1.0791666666666666;
            orphans: 2;
            widows: 2;
            text-align: center
        }
        
        .c37 {
            border-spacing: 0;
            border-collapse: collapse;
            margin-right: auto
        }
        
        .c23 {
            font-size: 9pt;
            font-family: "Poppins";
            color: #262626;
            font-weight: 700
        }
        
        .c36 {
            margin-left: auto;
            border-spacing: 0;
            border-collapse: collapse;
            margin-right: auto
        }
        
        .c55 {
            margin-left: 1.5pt;
            border-spacing: 0;
            border-collapse: collapse;
            margin-right: auto
        }
        
        .c12 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            text-align: left
        }
        
        .c53 {
            color: #404040;
            font-weight: 700;
            font-size: 21pt;
            font-family: "Poppins"
        }
        
        .c40 {
            padding-top: 0pt;
            padding-bottom: 0pt;
            line-height: 1.0;
            text-align: center
        }
        
        .c47 {
            color: #000000;
            font-weight: 700;
            font-size: 11pt;
            font-family: "Poppins"
        }
        
        .c21 {
            text-decoration: none;
            vertical-align: baseline;
            font-size: 9pt;
            font-style: normal
        }
        
        .c51 {
            background-color: #ffffff;
            max-width: 464.9pt;
            padding: 13.5pt 72pt 0.5pt 58.5pt
        }
        
        .c28 {
            text-decoration: none;
            vertical-align: baseline;
            font-style: normal
        }
        
        .c18 {
            font-family: "Poppins";
            color: #262626;
            font-weight: 400
        }
        
        .c32 {
            color: #262626;
            font-weight: 700;
            font-family: "Poppins"
        }
        
        .c34 {
            color: #404040;
            font-weight: 400;
            font-family: "Poppins"
        }
        
        .c35 {
            padding: 0;
            margin: 0
        }
        
        .c38 {
            color: inherit;
            text-decoration: inherit
        }
        
        .c50 {
            height: 40.6pt
        }
        
        .c56 {
            padding-left: 0pt
        }
        
        .c30 {
            font-size: 14pt
        }
        
        .c45 {
            font-size: 12pt
        }
        
        .c5 {
            height: 0pt
        }
        
        .c43 {
            margin-left: 36pt
        }
        
        .c39 {
            height: 35.5pt
        }
        
        .c44 {
            font-size: 26pt
        }
        
        .c49 {
            height: 0.1pt
        }
        
        .c52 {
            height: 22.6pt
        }
        
        .c42 {
            font-size: 48pt
        }
        
        .c9 {
            height: 11pt
        }
        
        .c46 {
            font-size: 9pt
        }
        
        .c20 {
            height: 33.2pt
        }
        
        .c41 {
            height: 25.7pt
        }
        
        .c48 {
            font-size: 11pt
        }
        
        .c24 {
            font-size: 10pt
        }
        
        .title {
            padding-top: 24pt;
            color: #000000;
            font-weight: 700;
            font-size: 36pt;
            padding-bottom: 6pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        .subtitle {
            padding-top: 18pt;
            color: #666666;
            font-size: 24pt;
            padding-bottom: 4pt;
            font-family: "Georgia";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            font-style: italic;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        li {
            color: #000000;
            font-size: 11pt;
            font-family: "Calibri"
        }
        
        p {
            margin: 0;
            color: #000000;
            font-size: 11pt;
            font-family: "Calibri"
        }
        
        h1 {
            padding-top: 24pt;
            color: #000000;
            font-weight: 700;
            font-size: 24pt;
            padding-bottom: 6pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        h2 {
            padding-top: 18pt;
            color: #000000;
            font-weight: 700;
            font-size: 18pt;
            padding-bottom: 4pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        h3 {
            padding-top: 14pt;
            color: #000000;
            font-weight: 700;
            font-size: 14pt;
            padding-bottom: 4pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        h4 {
            padding-top: 12pt;
            color: #000000;
            font-weight: 700;
            font-size: 12pt;
            padding-bottom: 2pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        h5 {
            padding-top: 11pt;
            color: #000000;
            font-weight: 700;
            font-size: 11pt;
            padding-bottom: 2pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
        
        h6 {
            padding-top: 10pt;
            color: #000000;
            font-weight: 700;
            font-size: 10pt;
            padding-bottom: 2pt;
            font-family: "Calibri";
            line-height: 1.0791666666666666;
            page-break-after: avoid;
            orphans: 2;
            widows: 2;
            text-align: left
        }
    </style>
@endsection

@section('content')
<p class="c27 c9"><span class="c28 c18 c44"></span></p>
    <p class="c27 c9" id="h.gjdgxs"><span class="c28 c18 c44"></span></p>
    <p class="c27" id="h.e00jdijli4mc"><span class="c0">Hulagi Logistics</span></p>
    <p class="c27" id="h.1f4tljamxmrw"><span class="c28 c32 c42">Quotation</span></p>
    <p class="c27 c9"><span class="c28 c18 c42"></span></p>
    <p class="c26"><span style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 438.80px; height: 181.79px;"><img alt="" src="{{asset("asset/img/logo.PNG")}}" style="width: 438.80px; height: 181.79px; margin-left: -0.00px; margin-top: -0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);" title=""></span></p>
    <p class="c9 c17"><span class="c11"></span></p>
    <p class="c26"><span class="c28 c18 c45">&#2360;&#2369;&#2354;&#2349; &#2342;&#2352;&#2350;&#2366; &#2357;&#2367;&#2358;&#2381;&#2357;&#2366;&#2360;&#2367;&#2354;&#2379; &#2360;&#2375;&#2357;&#2366; &#2404;</span></p>
    <p class="c17 c9"><span class="c28 c18 c45"></span></p>
    <p class="c22 c9"><span class="c28 c18 c45"></span></p>
    <p class="c22 c9"><span class="c28 c18 c45"></span></p>
    <p class="c22 c9"><span class="c28 c18 c45"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c31"><span class="c28 c18 c30">Hulagi Logistics.</span></p>
    <p class="c31"><span class="c28 c18 c30">Dillibazar, Kathmandu Nepal </span></p>
    <p class="c31"><span class="c28 c18 c30">Email: </span><span class="c29 c18"><a class="c38" href="mailto:hulagilogistics@gmail.com">hulagilogistics@gmail.com</a></span><span class="c28 c18 c30">, </span><span class="c29 c18"><a class="c38" href="mailto:hulagilogistics@gmail.com">hulagilogistics@gmail.com</a></span></p>
    <p class="c31"><span class="c28 c18 c30">Web: </span><span class="c18 c29"><a class="c38" href="https://www.google.com/url?q=http://www.hulagi.com&amp;sa=D&amp;source=editors&amp;ust=1628516220615000&amp;usg=AOvVaw3-g9slvnwVdLubm4lQnOau">www.hulagi.com</a></span></p>
    <p class="c31"><span class="c28 c18 c30">Phone: 01-5912256, Phone: 01-5912257</span><span class="c18 c30">5555</span><span class="c28 c18 c30"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c9 c22"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c1"><span class="c11">Dear Sir / Ma&rsquo;am,&nbsp;</span></p>
    <p class="c1 c9"><span class="c11"></span></p>
    <p class="c1"><span class="c11">Hulagi Logisticsis a leading </span><span class="c18">national</span><span class="c11">&nbsp;provider of comprehensive logistics and transportation solutions in Nepal. We </span><span class="c18">are the only</span>
        <span class="c11">&nbsp;company </span><span class="c18">with its own</span><span class="c11">&nbsp;network all over Nepal, Hulagi Logistics rapidly evolved into a </span><span class="c18">national</span><span class="c11">&nbsp;brand recognized for its customized services and innovative multi-product offering. </span>
        <span class="c18">Being a tech-based</span><span class="c11">&nbsp;logistics company </span><span class="c18">that</span><span class="c11">&nbsp;is continuously expanding and excels as a leading company today, Hulagi Logistics employs more than 20 people inside Nepal and we have a strong alliance network providing a National presence. The range of services offered by Hulagi Logistics  includes international and domestic express delivery, freight forwarding, logistics and warehousing, records and information </span>
        <span class="c18">management</span><span class="c11">&nbsp;solutions, e-business solutions, and online shopping services.&nbsp;</span></p>
    <p class="c1"><span class="c11">&nbsp;&nbsp;</span></p>
    <p class="c1"><span class="c11">Our Pricing for inside the Kathmandu Valley</span><span class="c11">&nbsp;( Kathmandu, Bhaktapur, Lalitpur )</span></p>
    <p class="c1 c9"><span class="c11"></span></p>
    <ul class="c35 lst-kix_list_3-0 start">
        <li class="c1 c43 c56 li-bullet-0"><span class="c18">Rs. 105 for all Kathmandu valley ( Inside and outside Ringroad. )</span></li>
    </ul>
    <p class="c1 c9"><span class="c11"></span></p>
    <p class="c1 c9"><span class="c11"></span></p>
    <a id="t.6591a837c4e8e0a3a655433aed3aab0a11bdd682"></a>
    <a id="t.0"></a>
    <table class="c37">
        <tbody>
            <tr class="c5">
                <td class="c19" colspan="1" rowspan="1">
                    <p class="c27"><span class="c11">Previous pricing for all Kathmandu Valley that goes upto 115 has been reduced to 105</span></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="c1 c9"><span class="c11"></span></p>
    <p class="c1"><span class="c11">&nbsp;</span></p>
    <p class="c1"><span class="c11">&nbsp;&nbsp;</span></p>
    <p class="c1 c9"><span class="c11"></span></p>
    <p class="c1"><span class="c18">O</span><span class="c11">utside the&nbsp;Kathmandu valley prices are attached below.&nbsp;</span></p>
    <p class="c1 c9"><span class="c21 c18"></span></p>
    <p class="c1 c9 c43"><span class="c21 c18"></span></p>
    <p class="c1"><span class="c11">&nbsp;</span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c22 c9"><span class="c11"></span></p>
    <p class="c40 c9"><span class="c28 c24 c34"></span></p>
    <p class="c40"><span class="c28 c53">&#2342;&#2375;&#2358;&#2349;&#2352;&#2367; &#2310;&#2347;&#2381;&#2344;&#2376; &#2325;&#2366;&#2352;&#2381;&#2351;&#2366;&#2354;&#2351; &#2349;&#2319;&#2325;&#2379; &#2319;&#2325; &#2350;&#2366;&#2340;&#2381;&#2352; &#2325;&#2350;&#2381;&#2346;&#2344;&#2368;</span></p>
    <p class="c40 c9"><span class="c25"></span></p>
    <p class="c22 c9"><span class="c15"></span></p>
    <a id="t.0328dc44fd7d138fdd168b303f9eaf64030e0955"></a>
    <a id="t.1"></a>
    <table class="c55">
        <tbody>
            <tr class="c50">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c28 c32 c48">S.N.</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c28 c32 c48">Location</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23">Up to 1 KG</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Above 1 KG (PER KG)</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Upto 470 Orders monthly</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Upto 900 Orders &nbsp;monthly</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Upto 1500 Orders Monthly</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Cargo</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c23 c28">Time to Deliver</span></p>
                    <p class="c1 c9"><span class="c23 c28"></span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">1</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Pokhara</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Damauli</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">3 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">3</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Dumre</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">180</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">3 to 4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">4</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Waling (Syangja)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">3-4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">5</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Baglung</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2-4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">6</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Beni</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2-4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">7</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Kusma</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2 -4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">8</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Parbat</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">2-4 Days.</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">9</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Gorkha</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Coming Soon</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
            </tr>
            <tr class="c52">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">10</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Lamjung</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Coming Soon</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">11</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">Dhading</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18 c24">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Coming Soon</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">12</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bharatpur Chitwan</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">13</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Gaidakot</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">14</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Kawasoti</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">15</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Parsa ( Tandi )</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">16</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Nawalpur</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">17</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Nawalparasi</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">18</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Butwal</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">19</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bhairahawa</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">20</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18">Sunuwal</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">170 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">21</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c11">Palpa (Tansen)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">22</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c11">Gulmi (Tamghas)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">190 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-5 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">23</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Kapilvastu / Chandrauta</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">&nbsp;165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">24</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dang (Tulsipur)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">178 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">25</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dang ( Gorahi )</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">178 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">26</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dang ( Lamahi )</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">27</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Nepalgunj</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">28</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Kohalpur</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">29</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Surkhet</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">155 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-5 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">30</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bardiya (Gulariya)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">31</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bardiya(Rajapur)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">190Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">32</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bardiya(Bhurigaun</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">33</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Lamki (Kailali)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">34</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bauniya ( Kailali)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">35</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Tikapur ( Kailali )</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">36</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Mahendranagar</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">37</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dhangadhi</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">38</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Attariya</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">38</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Ghodaghodi</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">195 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">39</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Sindhuli</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">40</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bardibas</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">41</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Hetauda</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">42</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Lahan</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">43</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Gaighat</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">44</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Katari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">45</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Janakpur</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c39">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">46</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dhalkebar</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">47</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Birgunj</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">48</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Rajbiraj</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">49</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Inaruwa</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">50</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Itahari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Day</span></p>
                </td>
            </tr>
            <tr class="c20">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">51</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Biratnagar</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2 Day</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">52</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dharan</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">53</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dhankuta</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c4"></span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c4"></span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">54</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Belbari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">55</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Damak</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">56</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Birtamode (Jhapa)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">145 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2 Day</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">57</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c18">Kakarbhitta</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">58</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Kankai (Surunga)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">155 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c49">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">59</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Budhabare</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">60</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Bhadrapur</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">155 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">61</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Ilam Bazar</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">190 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">55 Rs.</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-5 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">63</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Illam (Fikal)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">210 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-7 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">64</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Urlabari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">65</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Dhulabari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">2-3 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">66</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Pathari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">175 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">67</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Belbari</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">68</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Morang</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-5 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">69</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Simara</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">165 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">70</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Rautahat (Gaur)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">71</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c18 c24">Rautahat (</span><span class="c18 c46">Chandranigahapur</span><span class="c4">)</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">180 Rs.</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">50% of 1 KG Fare.</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">5% Discount on total fare</span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">9% Discount of total fare</span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">15% Discount of total fare.</span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">3-4 Days</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">72</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Banepa</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">135 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">1 Day</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">73</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Dhulikhel</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">1 Day</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">74</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Panauti</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">145 Rs</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12"><span class="c11">N/A</span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">1 Day</span></p>
                </td>
            </tr>
            <tr class="c5">
                <td class="c10" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">75</span></p>
                </td>
                <td class="c6" colspan="1" rowspan="1">
                    <p class="c12"><span class="c4">Kathmandu</span></p>
                </td>
                <td class="c16" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">105</span></p>
                </td>
                <td class="c7" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c14" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c2" colspan="1" rowspan="1">
                    <p class="c1 c9"><span class="c4"></span></p>
                </td>
                <td class="c8" colspan="1" rowspan="1">
                    <p class="c12 c9"><span class="c11"></span></p>
                </td>
                <td class="c3" colspan="1" rowspan="1">
                    <p class="c1"><span class="c4">Same Day / Next Day</span></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c9 c54"><span class="c13"></span></p>
    <a id="t.6ef28c638ac6075247ee1f4cf9a182e90160d24b"></a>
    <a id="t.2"></a>
    <table class="c36">
        <tbody>
            <tr class="c41">
                <td class="c19" colspan="1" rowspan="1">
                    <p class="c27"><span class="c28 c47">DELIVERY TIME MENTIONED ABOVE VARIES DUE TO COVID / LOCKDOWN AND NATURAL CALAMITIES INCLUDING OPERATION OF LAND AND AIRWAYS DURING THIS PERIOD</span></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22"><span class="c47 c28">Our International Rates : </span></p>
    <p class="c22"><span class="c33"><a class="c38" href="https://www.google.com/url?q=https://hulagi.com/internationalquote&amp;sa=D&amp;source=editors&amp;ust=1628516220857000&amp;usg=AOvVaw3m_45u90zHBGl94XuizSBf">https://hulagi.com/internationalquote</a></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22"><span class="c47 c28">Our Terms Terms and Conditions:</span></p>
    <p class="c22"><span class="c33"><a class="c38" href="https://www.google.com/url?q=https://hulagi.com/vendor-terms-and-conditions&amp;sa=D&amp;source=editors&amp;ust=1628516220858000&amp;usg=AOvVaw1sOuOt6T-GO8nYnZCdhcX3">https://hulagi.com/vendor-terms-and-conditions</a></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <hr>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22"><span class="c13">This quotation is valid from 08/1/2021</span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
    <p class="c22 c9"><span class="c13"></span></p>
@endsection