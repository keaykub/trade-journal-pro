<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{{ $header ?? '' }}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
{{ Illuminate\Mail\Markdown::parse($slot) }}

{{ $subcopy ?? '' }}
</td>
</tr>
</table>
</td>
</tr>

<!-- ⭐ เพิ่มส่วนนี้ - WickFill Footer แทน Laravel Footer -->
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<div style="text-align: center; color: #718096; font-size: 12px; padding: 32px; background-color: #f7fafc; margin-top: 20px; border-radius: 8px;">
    <!-- WickFill Logo -->
    <div style="margin-bottom: 16px;">
        <div style="display: inline-block; width: 40px; height: 40px; background: linear-gradient(135deg, #0046ff 0%, #008cff 100%); border-radius: 10px; line-height: 40px; color: white; font-size: 16px; font-weight: bold; margin-bottom: 8px;">
            W
        </div>
        <div style="color: #1a202c; font-size: 14px; font-weight: 600;">WickFill</div>
        <div style="color: #718096; font-size: 11px;">แพลตฟอร์มบันทึกการเทรด</div>
    </div>

    <!-- Copyright -->
    <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
        <p style="margin: 0; color: #718096; font-size: 11px; line-height: 1.4;">
            © {{ date('Y') }} WickFill. สงวนลิขสิทธิ์<br>
            อีเมลนี้ส่งโดยอัตโนมัติ กรุณาอย่าตอบกลับ
        </p>

        <!-- Links -->
        <div style="margin-top: 12px;">
            <a href="#" style="color: #0046ff; text-decoration: none; font-size: 10px; margin: 0 4px;">นโยบายความเป็นส่วนตัว</a>
            <span style="color: #cbd5e0;">|</span>
            <a href="#" style="color: #0046ff; text-decoration: none; font-size: 10px; margin: 0 4px;">เงื่อนไขการใช้งาน</a>
            <span style="color: #cbd5e0;">|</span>
            <a href="#" style="color: #0046ff; text-decoration: none; font-size: 10px; margin: 0 4px;">ติดต่อเรา</a>
        </div>
    </div>
</div>
</td>
</tr>
</table>
</td>
</tr>
<!-- ⭐ จบส่วนที่เพิ่ม -->

</table>
</td>
</tr>
</table>
</body>
</html>
