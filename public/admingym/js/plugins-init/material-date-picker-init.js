(function ($) {
    "use strict";

    // MAterial Date picker
    $("#mdate").bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
    });
    $("#mdate2").bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
    });
    $("#timepicker").bootstrapMaterialDatePicker({
        format: "HH:mm",
        time: true,
        date: false,
    });
    $("#date-format").bootstrapMaterialDatePicker({
        format: "dddd DD MMMM YYYY - HH:mm",
    });
    $("#date-formatEdit").bootstrapMaterialDatePicker({
        format: "dddd DD MMMM YYYY - HH:mm",
    });

    $("#min-date").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm",
        minDate: new Date(),
    });

    $("#min-date2").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm",
        minDate: new Date(),
    });

    $("#min-date3").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm",
        minDate: new Date(),
    });
})(jQuery);
