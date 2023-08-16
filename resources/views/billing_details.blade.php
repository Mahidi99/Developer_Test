<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details</title>
</head>
<body>
    <h1>Billing Details</h1>
    <p>Last Reading Date: {{ $lastReadingDate }}</p>
    <p>Previous Reading Date: {{ $previousReadingDate }}</p>
    <p>Last Meter Reading: {{ $lastMeterReading }}</p>
    <p>Previous Meter Reading: {{ $previousMeterReading }}</p>
    <p>Fixed Charge: {{ $fixedCharge }}</p>
    <p>Charge for First Range: {{ $chargeFirstRange }}</p>
    <p>Charge for Second Range: {{ $chargeSecondRange }}</p>
    <p>Total Charge: {{ $totalCharge }}</p>
</body>
</html>
