
$(document).ready(function () {
        $(document).on('keyup', '.cit_amount', function () {
            var amount = $('.cit_amount').val();
            var salary = $('.employee_salary').val();
            var per = (amount / salary) * 100;
            $('.cit_percentage').val(per.toFixed(2));
        });
        $(document).on('keyup', '.cit_percentage', function () {
            var percentage = $('.cit_percentage').val();
            var salary = $('.employee_salary').val();
            var amount = (percentage / 100) * salary;
            $('.cit_amount').val(amount.toFixed(2));
        });
    });



