$(function () {
    var nationalDays = ["2019-01-01","2019-01-04"];

    $("#datetime1").datepicker({
        dateFormat : 'yy-mm-dd',
      //  minDate :2,
    //    beforeShowDay: noWeekendsOrHolidays

    });
    function noWeekendsOrHolidays(selDate) {
        var noWeekend = jQuery.datepicker.noWeekends(selDate),
            noNationalDays = chkNationalDays(selDate),
            noNext2Days = chkNext2Days(selDate)

        if (noWeekend[0]) {
            if (noNationalDays[0]) {
                return noNext2Days;
            } else {
                return noNationalDays;
            }
        } else  {
            return noWeekend;
        }
    };

    function chkNext2Days(selectedDate) {
        var today = new Date();
        if (isEqual(selectedDate, today)) return [false, '', ''];
        today.setDate(today.getDate());
        if (isEqual(selectedDate, today)) return [false, '', ''];
        today.setDate(today.getDate());
        if (isEqual(selectedDate, today)) return [false, '', ''];
        return [true, '', ''];
    }
    function chkNationalDays(selectedDate) {
        var retVal = [true, '', ''];
        nationalDays.forEach(function(dt) {
            var today = new Date(dt);
            if (isEqual(selectedDate, today)) {
                retVal = [false, '', '']; return;
            }
        });
        return retVal;
    };
    function isEqual(srcDate, tarDate) {
        if ((srcDate.getDate() == tarDate.getDate()) &&
            (srcDate.getMonth() == tarDate.getMonth()) &&
            (srcDate.getFullYear() == tarDate.getFullYear())) {
            return true;
        } else { return false; }
    }

    $("#datetime2").datepicker({
        dateFormat: 'yy-mm-dd' ,
       // minDate :  2,
        //beforeShowDay:  noWeekendsOrHolidays
    });
});