<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request to Reject Review</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <div
        style="max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333333; text-align: center;">Request to Reject Review</h2>
        <p style="color: #555555; line-height: 1.6;">
            Dear {{ $user->name }},
        </p>
        <p style="color: #555555; line-height: 1.6;">
            We hope this email finds you well. Unfortunately, we must inform you that your review request for the
            submission titled <strong>{{ $submission->title }}</strong> has been rejected.
        </p>
        <p style="color: #555555; line-height: 1.6;">reason: {{ $reason }}</p>
        <p style="color: #555555; line-height: 1.6;">
            If you believe this decision was made in error or you have additional concerns, please feel free to contact
            us for clarification or further discussion.
        </p>
        <p style="color: #555555; line-height: 1.6;">
            Thank you for your understanding, and we hope to work with you again in the future.
        </p>
        <p style="color: #555555; line-height: 1.6;">Best regards,</p>
        <p style="color: #555555; line-height: 1.6;">
            The {{ config('app.name') }} Team
        </p>
    </div>
</body>

</html>
