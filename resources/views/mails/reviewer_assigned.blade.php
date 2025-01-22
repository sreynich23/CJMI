<!DOCTYPE html>
<html>
<head>
    <title>You Have Been Assigned as a Reviewer</title>
</head>
<body>
    <h1>Hello {{ $reviewer->name }}</h1>
    <p>You have been assigned to review the submission titled "{{ $submission->title }}".</p>
    <p>Please log in to the system to start reviewing.</p>
    <p>Best regards,</p>
    <p>The Review Team</p>
</body>
</html>
