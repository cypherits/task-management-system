$(document).ready(function () {

    // ------------------------------------------------------- //
    // Custom Scrollbar
    // ------------------------------------------------------ //

    if ($(window).outerWidth() > 992) {
        $("nav.side-navbar").mCustomScrollbar({
            scrollInertia: 200
        });
    }

    // Main Template Color
    var brandPrimary = '#33b35a';

    // ------------------------------------------------------- //
    // Side Navbar Functionality
    // ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e) {

        e.preventDefault();

        if ($(window).outerWidth() > 1194) {
            $('nav.side-navbar').toggleClass('shrink');
            $('.page').toggleClass('active');
        } else {
            $('nav.side-navbar').toggleClass('show-sm');
            $('.page').toggleClass('active-sm');
        }
    });

    // ------------------------------------------------------- //
    // External links to new window
    // ------------------------------------------------------ //

    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });
});


var dataTablesInit = [];

function init_datatable(id, ajaxUrl, colPriority, options, init = true) {
    bLengthChange = true;
    bInfo = true;
    bFilter = true;
    init_func = function () {
        var self = this.api(),
                $searchButton = $('<button>').addClass('datatables_search_btn').html('<i class="fa fa-search"></i>').click(function () {
            self.search(input.val()).draw();
        });
        $('.dataTables_filter').append($searchButton);
    };
    if (ajaxUrl != '') {
        options.ajax = ajaxUrl;
    }
    options.responsive = true;
    options.ordering = false;
    if(init){
        options.initComplete = init_func;
    }
    options.language = {
        sLengthMenu: "_MENU_",
        sInfo: "Showing _START_ - _END_ of (_TOTAL_)",
        sSearch: " ",
        sSearchPlaceholder: "Search here..",
        paginate: {
            next: ">",
            previous: "<"
        }
    };
    options.bLengthChange = bLengthChange;
    options.bInfo = bInfo;
    options.bFilter = bFilter;
    options.columnDefs = colPriority;
    dataTablesInit[id] = $('#' + id).DataTable(options);
}