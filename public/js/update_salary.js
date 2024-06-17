$(document).ready(function () {
    $(document).on('keyup', '.salary_amount', function () {
        var amount = $('.salary_amount').val();
        var salary = $('.employee_salary').val();
        var revised = amount - salary;
        var per = (revised / salary) * 100;
        $('.salary_percentage').val(per.toFixed(2));
    });
    $(document).on('keyup', '.salary_percentage', function () {
        var percentage = $('.salary_percentage').val();
        var salary = $('.employee_salary').val();
        var increasedAmount = (percentage / 100) * salary;
        var amount = parseFloat(salary) + parseFloat(increasedAmount);
        $('.salary_amount').val(amount.toFixed(2));
    });
});