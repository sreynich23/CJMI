<!DOCTYPE html>
<html>
<head>
    <title>Approval Notification</title>
</head>
<body>
    <h1>Dear {{ $reviewer->name }},</h1>
    <p>We are pleased to inform you that your request to become a reviewer has been approved.</p>
    <p><strong>Details:</strong></p>
    <ul>
        <li><strong>Email:</strong> {{ $reviewer->email }}</li>
        <li><strong>Expertise:</strong> {{ ucfirst($reviewer->expertise) }}</li>
    </ul>
    <p>We look forward to working with you!</p>
    <p>Best regards,</p>
    <p>The {{ config('app.name') }} Team</p>
</body>
</html>
