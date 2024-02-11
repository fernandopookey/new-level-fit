(function ($) {
    "use strict";

    // MAterial Date picker
    $("#mdate").bootstrapMaterialDatePicker({
        format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
    });
    $("#mdate2").bootstrapMaterialDatePicker({
        format: "dd-MMMM-YYYY",
        weekStart: 0,
        time: false,
    });
    $("#mdate3").bootstrapMaterialDatePicker({
        format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
    });
    $("#mdate4").bootstrapMaterialDatePicker({
        format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
    });
    $("#mdate5").bootstrapMaterialDatePicker({
        format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
        minDate: new Date(),
    });
    $(".mdate-custom").bootstrapMaterialDatePicker({
        format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
        // defaultDate: new Date(),
    });
    $(".mdate-custom2").bootstrapMaterialDatePicker({
        // format: "DD-MMMM-YYYY",
        weekStart: 0,
        time: false,
        // defaultDate: new Date(),
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
