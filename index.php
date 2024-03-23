
<?php include 'header.php';?>

<?php
function amortizationTable($loanAmount, $interestRate, $loanTerm) {
    $monthlyInterestRate = $interestRate / 100 / 12;
    $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$loanTerm));

    echo "<h2>Amortization CalCulator</h2>";
    echo "<table>";
    echo "<tr><th>#</th><th>Loan Balance</th><th>Payment</th><th>Principal</th><th>Interest</th></tr>";

    $balance = $loanAmount;
    for ($i = 1; $i <= $loanTerm; $i++) {
        $interest = $balance * $monthlyInterestRate;
        $principal = $monthlyPayment - $interest;
        $balance -= $principal;

        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$" . number_format($balance, 2) . "</td>";
        echo "<td>$" . number_format($monthlyPayment, 2) . "</td>";
        echo "<td>$" . number_format($principal, 2) . "</td>";
        echo "<td>$" . number_format($interest, 2) . "</td>";
        
        echo "</tr>";

        if ($i == 10) {
            break; // Break the loop after displaying 10 rows
        }
    }

    echo "</table>";
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loanAmount = $_POST["loanAmount"];
    $interestRate = $_POST["interestRate"];
    $loanTerm = $_POST["loanTerm"];

    amortizationTable($loanAmount, $interestRate, $loanTerm);
}
?>
<div id="loanForm">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="loanAmount">Loan Amount ($):</label>
        <input type="number" name="loanAmount" id="loanAmount" required>
        <label for="interestRate">Annual Interest Rate (%):</label>
        <input type="number" step="0.01" name="interestRate" id="interestRate" required>
        <label for="loanTerm">Loan Term (months):</label>
        <input type="number" name="loanTerm" id="loanTerm" required>
        <input type="submit" value="Calculate">
    </form>
</div>



<?php include 'footer.php';?>