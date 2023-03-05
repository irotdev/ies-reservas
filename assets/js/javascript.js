

// Return a date with the format yyyy-mm-dd
function formatDate(date) {
    let d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    let year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}


function change_month_to_show(currentYear, numberOfMonthNormal, needAjaxUpdate = true) {
    
    // Firt part (changing part of the view of months and years)
    $(".month-actual").removeClass("month-actual");
    $("#previous-calendar-month-" + numberOfMonthNormal).addClass("month-actual");

    // Second part (changing part of the view of month and days)
    $(".month-with-days").addClass("display-none");
    $(".initial-month-to-show").removeClass("display-none");
    $(".calendar-month-" + numberOfMonthNormal).removeClass("display-none").removeClass("initial-month-to-show");
    
    // Hiding the daily data (part4) and the current day of the month selected (part3)
    $(".daily-data-cal").addClass("display-none");
    $(".calendar-day-selected").removeClass("calendar-day-selected");

    // Preparing the hide value of the date of the current month selected
    $("#hide-date-from").html(formatDate(new Date(currentYear, numberOfMonthNormal - 2, 22)));
    $("#hide-date-to").html(formatDate(new Date(currentYear, numberOfMonthNormal, 6)));
    $("#hide-year").text(currentYear);
    $("#hide-month").text(numberOfMonthNormal);

    // Updating the current view
    if (needAjaxUpdate) read_ajax_data_updated();
}


function change_item_to_show(keyOfItem) {
    
    // Firt part (changing part of the view of the items)
    $(".select-item-td").removeClass("item-actual");
    $("#item-" + keyOfItem).addClass("item-actual");
    
    // Second part (changing part of the view of the numbers of elements free or not (internal table))
    $(".internal-table").addClass("display-none").removeClass("internal-table-item-actual");
    $(".internal-table-" + keyOfItem).removeClass("display-none").addClass("internal-table-item-actual");

    // Third part (changing the name of the calendar (right) to show the item)
    $(".select-item-span").addClass("display-none").removeClass("item-actual2");
    $(".item-" + keyOfItem).removeClass("display-none").addClass("item-actual2");

    // Hiding the daily data (part4) and the current day of the month selected (part3)
    $(".daily-data-cal").addClass("display-none");
    $(".calendar-day-selected").removeClass("calendar-day-selected");

    // Updating the current item in the hide place for data
    $("#hide-item").html(keyOfItem);
    
    // Updating the current view
    read_ajax_data_updated();
}


// Update the selected month with the selected item (when click in part1 and part2, updating part3)
function read_ajax_data_updated() {

    // Update all the values of the current month
    console.log("data updated");
    let params = {
        item: $('#hide-item').html(),
        operation: "read",
        monthly_data: "true",
        date_from: $('#hide-date-from').html(),
        date_to: $('#hide-date-to').html()
    };

    $.ajax({
        url: '../api/',
        type: 'get',
        data: params,
        dataType: 'JSON',
        success: function(response){

            // Restarting empty value of all the internal-td class
            $(".internal-td").text("--");

            let len = response['data'].length;
            for(let i = 0; i < len; i++){
                let date = response['data'][i].date;
                let hour = response['data'][i].hour;
                let quantity = response['data'][i].quantity;

                let className = ".td-" + date + "-" + hour;

                // Add the current value for the internal td 
                $(className).text(quantity);
            }
        }
    });
}


// Click in the part3 in order to show the daily data (part4)
$(".calendar-day-clickable-details").click(function(){

    let tdDate = $(this).find(".day-of-the-td").text();
    let params = {
        item: $('#hide-item').html(),
        operation: "read",
        date_from: tdDate,
        date_to: tdDate
    };

    // Restarting the daily data for every hour of the selected day
    $(".daily-data-td").text("");
    $(".daily-data-cal").removeClass("display-none");

    // Changing the selected day
    $(".calendar-day-selected").removeClass("calendar-day-selected");
    $(this).addClass("calendar-day-selected");
    
    // Writing the current day
    let daySpanish = $(this).find(".hide-extra-dayOfTheWeekSpanish").text();
    let dayNumber = $(this).find(".hide-extra-dayOfTheMonth").text();
    let monthSpanish = $(this).find(".hide-extra-monthSpanish").text();
    $(".daily-date-selected").text(daySpanish + ", " + dayNumber + " de " + monthSpanish);

    $.ajax({
        url: '../api/',
        type: 'get',
        data: params,
        dataType: 'JSON',
        success: function(response){

            let arrayDailyData = {1: "", 2: "", 3: "", 4: "", 5: "", 6: ""};
            let arrayDailyDataSum = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0};
            let len = response['data'].length;
            for (let i = 0; i < len; i++){
                // Creating the name of the class of the daily-data by hour (daily-1, daily-2, ..., daily-3)
                let getHour = response['data'][i].hour;

                // Adding information to the TD
                let tdContent = arrayDailyData[getHour];
                tdContent += "<p class='daily-data-internal-text-details' id='id-reserve-" + parseInt(response['data'][i].id) + "'> - " + parseInt(response['data'][i].quantity) + " (reserva de " + response['data'][i].username + ").</p>";
                arrayDailyData[getHour] = tdContent;

                // Calculating sum of elements
                arrayDailyDataSum[getHour] += parseInt(response['data'][i].quantity);
            }

            
            // Fill every hour
            for(let i = 1; i <= 6; i++){
                // Creating the name of the class of the daily-data by hour (daily-1, daily-2, ..., daily-3)
                let className = ".daily-" + i;
                if (arrayDailyDataSum[i] > 0) {
                    let extraText = "<p class='daily-data-internal-sum-resume'>" + (response['item_numbers'] - arrayDailyDataSum[i]) + " de " + response['item_numbers'] + " disponibles:</p>";
                    $(className).html(extraText + arrayDailyData[i]);
                } else {
                    $(className).html("<p class='daily-data-internal-sum-resume'>" + (response['item_numbers'] + " disponibles.</p>"));
                }


                // Add data of the hour
                //$(className).text(response['data'][i].quantity);
                
            }
        }
    });
});


const logout = (url) => {
    const confirm = window.confirm("¿Está seguro de que desea salir de la aplicación?");
    if(confirm){
        window.location.href = url;
    }
}