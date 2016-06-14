<html>
<head>
    <title>Accepted</title>
    <link href="" rel="stylesheet">
</head>
<body>
<h3>Your Password Reset Link</h3>
<p>
    Click the link below to reset your password. only the admin account's password can be reset through email. If you need to reset
    password of an account of another type, please contact your admin.
</p>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">
    Click Here to Reset Your Password
</a>

</body>
</html>