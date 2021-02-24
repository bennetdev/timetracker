class Stopwatch {
    constructor(project_id) {
        this.project_id = project_id;
        this.time = 0;
        this.offset = 0;
        this.interval;
        this.hours = 0;
        this.minutes = 0;
    }

    format_time(new_minutes) {
        var time = $("#" + this.project_id + " .watch .time");

        var current_time = time.html();
        var current_hours = parseInt(current_time.split(":")[0].replaceAll(" ", ""));
        var current_minutes = parseInt(current_time.split(":")[1].replaceAll(" ", ""));

        this.minutes = current_minutes + new_minutes;
        this.hours = current_hours;
        if (this.minutes >= 60) {
            this.hours += 1;
            this.minutes = this.minutes % 60;
        }
        else if(this.minutes < 0){
            if(this.hours > 0){
                this.hours -= 1;
                this.minutes += 60;
            }
            else{
                this.minutes = 0;
            }
        }
        var display_minutes = this.minutes.toString();
        var display_hours = this.hours.toString();

        if (this.minutes < 10) {
            display_minutes = "0 " + display_minutes;
        } else {
            var split_min = display_minutes.split("")
            display_minutes = split_min[0] + " " + split_min[1];
        }

        if (this.hours < 10) {
            display_hours = "0 " + display_hours;
        } else {
            var split_hour = display_hours.split("")
            display_hours = split_hour[0] + " " + split_hour[1];
        }

        var display_time = display_hours + " : " + display_minutes

        time.html(display_time)
        update_project_time(this.project_id, display_time);
    }

    update_hourly() {
        var price = $("#" + this.project_id + " .total").val();
        var price_number = parseFloat(price.substring(1, price.length));
        var hours = this.hours + this.minutes / 60;
        var price_per_hour = 0
        if(hours > 0){
            price_per_hour = Math.round(price_number / hours * 100) / 100;
        }


        $("#" + this.project_id + " .per_hour").html("$" + price_per_hour.toString() + "/hr");
    }

    start() {
        this.offset = Date.now();
        this.interval = setInterval(this.update.bind(this), 60000);
    }

    stop() {
        clearInterval(this.interval);
        this.interval = null;
    }

    render(new_minutes) {
        this.format_time(new_minutes);
        this.update_hourly()
    }

    update() {
        var now = Date.now();
        this.time += now - this.offset;
        this.offset = now;
        this.render(1);
    }
}

function add_project(){
    $.post("./app/addProject.php", function (result){
        $(".add_project").before(result)
    });
}

function update_project_name(id, name){
    $.post("./app/updateProject.php",{name: name, id: id} ,function (){

    });
}
function update_project_money(id, money){
    $.post("./app/updateProject.php",{money: money, id: id} ,function (){

    });
}
function update_project_time(id, time){
    $.post("./app/updateProject.php",{time: time, id: id} ,function (){

    });
}


$(document).ready(function () {
    var stopwatches = {};
    var projects = $(".project");
    for (var i = 0; i < projects.length; i++){
        var id = $(projects[i]).attr("id");
        var stopwatch = new Stopwatch(id)
        stopwatch.format_time(0);
        stopwatch.update_hourly();
        stopwatches[id] = stopwatch;
    }

    $(".projects").on("click", ".play", function () {
        var play = $(this)
        var project = $(this).closest(".project")
        var not_live = project.find(".not_live");
        var id = project.attr("id")
        play.html("pause")
        play.addClass("pause")
        play.removeClass("play")

        not_live.addClass("live")
        not_live.removeClass("not_live")

        stopwatches[id].start();
    })
    $(".projects").on("click", ".pause", function () {
        var pause = $(this)
        var project = $(this).closest(".project")
        var live = project.find(".live");
        var id = project.attr("id")
        pause.html("play_arrow")
        pause.addClass("play")
        pause.removeClass("pause")

        live.addClass("not_live")
        live.removeClass("live")

        stopwatches[id].stop();
    })
    $(".projects").on("click", ".up.hours", function (){
        var project = $(this).closest(".project")
        var id = project.attr("id")
        stopwatches[id].render(60);
    });
    $(".projects").on("click", ".down.hours", function (){
        var project = $(this).closest(".project")
        var id = project.attr("id")
        stopwatches[id].render(-60);
    });
    $(".projects").on("click", ".up.minutes", function (){
        var project = $(this).closest(".project")
        var id = project.attr("id")
        stopwatches[id].render(1);
    });
    $(".projects").on("click", ".down.minutes", function (){
        var project = $(this).closest(".project")
        var id = project.attr("id")
        stopwatches[id].render(-1);
    });
    $(".add_project").on("click", function (){
       add_project();
    });
    $(".projects").on("change", ".title", function (){
        update_project_name($(this).closest(".project").attr("id"), $(this).val());
    })
    $(".projects").on("change", ".total", function (){
        update_project_money($(this).closest(".project").attr("id"), $(this).val());
    })
})