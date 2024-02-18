<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Meeting Notes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
        }

        .meeting-title {
            font-size: 28px;
            color: #0056b3;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .note {
            background-color: #f9f9f9;
            padding: 20px;
            border-left: 5px solid #0056b3;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .note p {
            margin: 0;
            padding: 0;
        }

        .timestamp {
            font-size: 14px;
            color: #999;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="meeting-title">{{ $meetingNotes->first()->event->meetingTitle }}</div>
        @foreach ($meetingNotes as $note)
            <div class="note">
                <p>{!! $note->notes !!}</p>
                <div class="timestamp">Timestamp: {{ $note->created_at }}</div>
            </div>
        @endforeach
    </div>

</body>

</html>
