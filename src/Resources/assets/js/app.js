$(function() {
    $('.account-items-list table tbody tr').each(function() {
        var id = $(this).find('td:nth-child(1)').text();
        var status = $(this).find('td span.badge').text();
        var link = window.location.origin + '/customer/account/orders/' + id + '/tracking';
        if (status == 'Completed')
            $(this).find('td.actions a').after('<a href="' + link + '"><span class="icon icon-truck"></span></a>');
    });
});
