<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Form</title>
</head>

<h1> Adding Customer Data </h1>
<body bgcolor="#CCD1D1">
    <div>
        <h2>About Customers</h2>
    </div>
    <form action="{{ route('add_customer_details.store') }}" method="POST">
        @csrf <!-- Add CSRF token for security -->
        <label for="customer_account_number">Account No:</label><br>
        <input type="text" name="customer_account_number" id="customer_account_number" required><br><br>

        <label for="date">Date:</label><br>
        <input type="text" name="date" id="date" required><br><br>

        <label for="meter_reading_value">Meter Value:</label><br>
        <input type="text" name="meter_reading_value" id="meter_reading_value" required><br><br>

        <input type="submit" name="submit" id="submit">
    </form>

    @if($errors->has('date_error'))
        <p>{{ $errors->first('date_error') }}</p>
    @endif

    <br>
    <h2>Report</h2>
    <table border="1">
        <tr>
            <th>Customer</th>
            <th>Last reading date</th>
            <th>Previous reading date</th>
            <th>Last meter reading</th>
            <th>Previous meter reading</th>
            <th>Fixed charge amount</th>
            <th>First range billed amount</th>
            <th>Second range billed amount</th>
            <th>Third range billed amount</th>
            <th>Total billed amount</th>
        </tr>
        @foreach ($add_customer_details as $key => $customer)
            <tr>
                <td>{{ $customer->customer_account_number }}</td>
                <td>{{ $customer->date }}</td>
                <td>
                    @if ($key > 0)
                        {{ $add_customer_details[$key - 1]->date }}
                    @endif
                </td>
                <td>{{ $customer->meter_reading_value }}</td>
                <td>
                    @if ($key > 0)
                        {{ $add_customer_details[$key - 1]->meter_reading_value }}
                    @endif
                </td>
                <td>{{ $customer->previous_date }}</td>
                <td>{{ $customer->chargeFirstRange }}</td>
                <td>{{ $customer->chargeSecondRange }}</td>
                <td>{{ $customer->totalChargeThirdRange }}</td>
                <td>{{ $customer->totalCharge }}</td> <!--changeeeeeeee -->
                
            </tr>
        @endforeach
    </table>


    <br>
    <h2>Calculate Billing Details</h2>
    <form action="{{ route('calculate_billing_details') }}" method="POST">
        @csrf
        <label for="customer_account_number">Customer Account Number:</label><br>
        <input type="text" name="customer_account_number" id="customer_account_number" required><br><br>
        <input type="submit" value="Calculate">
    </form>
</body>
</html>