function display_info(gps) {
    $.ajax({
        type: 'POST',
        url: gps_information_url + '/' + gps,
        dataType: 'json',
        success: function(result){
            info = gps_data[gps];
            $('#gps_information_url').text(info.url);
            $('#gps_information_object').text(info.object);
            $('#gps_information_start').text(info.starttime);
            $('#gps_information_end').text(info.endtime);
            $('#gps_information_date').text(info.date);

            $('#gps_information_info').text(result.data.message);
            $('#gps_information_video').text(result.data.video);
            $('#gps_information_image').text(result.data.image);
            $('#gps_information_voice').text(result.data.voice);
        },
        error: function(){}
    });
}