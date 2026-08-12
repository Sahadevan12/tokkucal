<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <h2 style="margin-bottom: 4px;">New message from the Tokkucal contact form</h2>
    <p style="color: #64748b; margin-top: 0;">Reply directly to this email to respond to {{ $senderName }}.</p>

    <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
        <tr>
            <td style="padding: 6px 0; font-weight: bold; width: 90px;">Name</td>
            <td style="padding: 6px 0;">{{ $senderName }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; font-weight: bold;">Email</td>
            <td style="padding: 6px 0;">{{ $senderEmail }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; font-weight: bold;">Subject</td>
            <td style="padding: 6px 0;">{{ $contactSubject }}</td>
        </tr>
    </table>

    <p style="font-weight: bold; margin-bottom: 4px;">Message</p>
    <p style="white-space: pre-wrap; background: #f8fafc; padding: 12px 16px; border-radius: 8px;">{{ $messageBody }}</p>
</body>
</html>
