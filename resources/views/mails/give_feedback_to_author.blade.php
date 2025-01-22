<!DOCTYPE html>
<html>
<head>
    <title>Feedback for Your Submission</title>
</head>
<body>
    <h1>Hello {{ $user->name }}</h1>
    <p>You have been assigned to review the submission titled "<strong>{{ $submission->title }}</strong>".</p>

    <p>During the review, the following feedback was provided:</p>

    <ul>
            <li>{{ $comment }}</li>
    </ul>

    <p>Based on the feedback, please update your submission accordingly.</p>

    <p>Once the updates are complete, you can re-submit your work for review.</p>

    <p>Please log in to the system to start reviewing or make the necessary updates.</p>

    <p>Best regards,</p>
    <p>The Review Team</p>
</body>
</html>
