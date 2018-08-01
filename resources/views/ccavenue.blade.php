<html>
    <head>
        <title>
            CCavenue
        </title>
    </head>
    <form action="{{ url('indipay/request') }}" method="post">
        Enter Amount <input type="text" required name="amount">
        Select Currency <select name="currency" required>
            <option value="INR">
                INR
            </option>
            <option value="USD">
                USD
            </option>
            <option value="CAD">
                CAD
            </option>
        </select>
        <input type="submit" value="Pay Now" name="save">
    </form>
</html>