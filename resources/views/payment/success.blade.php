<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aseman</title>
</head>
<body>
<div style="direction:rtl; margin: auto; width: 80%;color: #52a25f;text-align: center;">
    <h2 style="font-size: 50px;font-weight: bold;">پرداخت موفق</h2>
    <p style="font-size: 40px;color: #637682;">
        لطفا اپلیکیشن را باز نمایید
    </p>
    <a href="aseman://success/{{ $code }}">بازگشت به اپلیکیشن</a>
</div>
<script>
    window.location.href = "aseman://success/{{ $code }}";
</script>
</body>
</html>
